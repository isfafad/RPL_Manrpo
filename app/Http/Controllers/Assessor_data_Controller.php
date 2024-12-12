<?php

namespace App\Http\Controllers;
use App\Models\Assessor;
use App\Models\Jurusan;
use App\Models\Assessment;
use App\Models\Matkul;
use App\Models\Matkul_score;
use App\Models\Cpmk;
use App\Models\Self_assessment_camaba;
use App\Models\Calon_mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Assessor_data_Controller extends Controller
{
    public function list_name_table(Request $request)
{
    try {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $assessor = Assessor::where('user_id', $user->id)->first();
        if ($assessor) {
            $assessments = Assessment::where(function ($query) use ($assessor) {
                $query->where('assessor_id_1', $assessor->id)
                    ->orWhere('assessor_id_2', $assessor->id)
                    ->orWhere('assessor_id_3', $assessor->id);
            })->get();

            $mahasiswaIds = $assessments->pluck('calon_mahasiswa_id');
            $camaba = Calon_mahasiswa::whereIn('id', $mahasiswaIds)->get();

            return view('Assessor/list-name-table', compact('camaba'));
        }

        return redirect()->route('list-name-table')->with('error', 'Data assessor tidak ditemukan');
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}


    
    public function detail_user($id){
        $camaba = Calon_mahasiswa::with('User', 'Jurusan')->findOrFail($id);
    
        // Jika mahasiswa tidak ditemukan, redirect dengan pesan error
        if (!$camaba) {
            return redirect()->route('detail-user')->with('error', 'Mahasiswa tidak ditemukan');
        }
    
        // Dapatkan user yang sedang login (assessor)
        $user = auth()->user();
        $assessor = Assessor::where('user_id', $user->id)->first();
        
        // Ambil mata kuliah yang akan dikonversi beserta nilai dan statusnya
        $matkul = DB::table('self_assessment_camaba')
                    ->join('cpmk', 'self_assessment_camaba.cpmk_id', '=', 'cpmk.id')
                    ->join('matkul', 'cpmk.matkul_id', '=', 'matkul.id')
                    ->leftJoin('matkul_score', function($join) use ($assessor, $id) {
                        $join->on('matkul.id', '=', 'matkul_score.matkul_id')
                             ->where('matkul_score.assessor_id', '=', $assessor->id)
                             ->where('matkul_score.calon_mahasiswa_id', '=', $id);
                    })
                    ->where('self_assessment_camaba.calon_mahasiswa_id', $id)
                    ->select(
                        'matkul.id as matkul_id', 
                        'matkul.nama_matkul',
                        'matkul_score.status',
                        'matkul_score.nilai'
                    )
                    ->groupBy('matkul.id', 'matkul.nama_matkul', 'matkul_score.status', 'matkul_score.nilai')
                    ->havingRaw('COUNT(DISTINCT self_assessment_camaba.cpmk_id) > 0')
                    ->get();
    
        return view('Assessor/detail-user', compact('camaba', 'matkul'));
    }
    
    // public function form_user($matkul_id){
    //     $matkul = Matkul::findOrFail($matkul_id);

    //     $self_assessment_camaba = Self_assessment_camaba::with(['bukti', 'cpmk'])
    //         ->whereHas('cpmk', function ($query) use ($matkul_id) {
    //             $query->where('matkul_id', $matkul_id);
    //         })
    //         ->get();

    //     return view('Assessor/form-user', compact('matkul', 'self_assessment_camaba'));
    // }
    
    public function form_user($matkul_id){
        $matkul = Matkul::findOrFail($matkul_id);
    
        $self_assessment_camaba = Self_assessment_camaba::with('cpmk')
            ->whereHas('cpmk', function ($query) use ($matkul_id) {
                $query->where('matkul_id', $matkul_id);
            })
            ->get();
    
        // Ubah cara mendapatkan assessor_id
        $user = auth()->user();
        $assessor = Assessor::where('user_id', $user->id)->first();
        $assessor_id = $assessor->id; // Ini akan mengambil id dari tabel assessors
            
        $camaba = $self_assessment_camaba->first()->calon_mahasiswa;
        $calon_mahasiswa_id = $camaba->id;
        
        // Tambahkan query untuk mengambil matkul score
        $matkulScore = Matkul_score::where([
            'matkul_id' => $matkul_id,
            'assessor_id' => $assessor_id,
            'calon_mahasiswa_id' => $calon_mahasiswa_id
        ])->first();
        
        return view('Assessor/form-user', compact('matkul', 'self_assessment_camaba', 'camaba', 'calon_mahasiswa_id', 'assessor_id', 'matkulScore'));
    }
    public function input_calculate(Request $request)
    {
        try {
            Log::info('Request data:', [
                'assessor_id' => $request->assessor_id,
                'all_data' => $request->all()
            ]);
            
            // Validasi input
            $validated = $request->validate([
                'nilai.*.V' => 'nullable|boolean',
                'nilai.*.A' => 'nullable|boolean',
                'nilai.*.T' => 'nullable|boolean',
                'nilai.*.M' => 'nullable|boolean',
                'calon_mahasiswa_id' => 'required|exists:calon_mahasiswa,id',
                'matkul_id' => 'required|exists:matkul,id',
                'assessor_id' => 'required|exists:assessor,id',
            ]);

            // Logika kalkulasi baru
            $totalvatm = count($request->input('nilai'));
            $totalScore = 0;
        
            foreach ($request->input('nilai') as $score) {
                // Pastikan setiap nilai memiliki nilai default 0 jika tidak dicentang
                $V = $score['V'] ?? 0;  // Nilai V
                $A = $score['A'] ?? 0;  // Nilai A
                $T = $score['T'] ?? 0;  // Nilai T
                $M = $score['M'] ?? 0;  // Nilai M
        
                // Hitung skor per Capaian Pembelajaran
                $calculatedScore = ($V * 40) + ($A * 40) + ($T * 10) + ($M * 10);
                $totalScore += $calculatedScore;
            }
        
            // Hitung rata-rata skor
            $scoreaverage = min(max($totalScore / $totalvatm, 0), 100);
            $finalStatus = $scoreaverage >= 75 ? 'Lolos' : 'Gagal';

            // Simpan ke database
            $result = Matkul_score::updateOrCreate(
                [
                    'matkul_id' => $request->matkul_id,
                    'assessor_id' => $request->assessor_id,
                    'calon_mahasiswa_id' => $request->calon_mahasiswa_id,
                ],
                [
                    'status' => $finalStatus,
                    'score' => $scoreaverage,
                    'updated_at' => now()
                ]
            );

            // Redirect berdasarkan status
            if ($finalStatus == 'Lolos') {
                // Jika lolos, tetap di halaman form-user
                return redirect()->back()
                    ->with('success', 'Status kelulusan berhasil disimpan. Mahasiswa dinyatakan Lolos. Silahkan input nilai.');
            } else {
                // Jika gagal, redirect ke detail-user
                return redirect()->route('detail-user', ['id' => $request->calon_mahasiswa_id])
                    ->with('warning', 'Mahasiswa dinyatakan Gagal.');
            }
            
        } catch (\Exception $e) {
            Log::error('Error saving score: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function input_nilai_matkul(Request $request)
    {
        try {
            // Log data request untuk debugging
            Log::info('Request data:', [
                'assessor_id' => $request->assessor_id,
                'all_data' => $request->all()
            ]);

            // Validasi input
            $validated = $request->validate([
                'nilai' => 'nullable|integer', // Ubah menjadi nullable karena di tabel juga nullable
                'calon_mahasiswa_id' => 'required|exists:calon_mahasiswa,id',
                'matkul_id' => 'required|exists:matkul,id',
                'assessor_id' => 'required|exists:assessor,id',
            ]);

            // Simpan ke database menggunakan model Matkul_score
            $result = Matkul_score::updateOrCreate(
                [
                    'matkul_id' => $request->matkul_id,
                    'assessor_id' => $request->assessor_id,
                    'calon_mahasiswa_id' => $request->calon_mahasiswa_id,
                ],
                [
                    'nilai' => $request->nilai,
                    'updated_at' => now()
                ]
            );

            return redirect()->route('detail-user', ['id' => $request->calon_mahasiswa_id])->with('success', 'Nilai berhasil disimpan.');
            
            
        } catch (\Exception $e) {
            Log::error('Error menyimpan nilai: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    
    public function profile_view_assessor()
    {
        $user = Auth::user();
    
        // Pastikan user login ada
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
    
        // Pastikan assessor ditemukan
        $assessor = Assessor::where('user_id', $user->id)->first();
        if (!$assessor) {
            return redirect()->route('profile-view-assessor')->with('error', 'Assessor tidak ditemukan.');
        }
    
        return view('Assessor/profile-view-assessor', compact('assessor', 'user'));
    }

    
    public function profile_assessor_edit_view($id){
        $assessor = Assessor::findOrFail($id);
        return view('Assessor/profile-edit-assessor', compact('assessor'));
    }
    
    public function profile_edit_assessor(Request $request, $id){
        $request->validate([
            'nama' => 'required|string|max:225',
            'alamat' => 'required|string|max:225',
            'no_hp' => 'required|string|max:225',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
        ]);

        $assessor = Assessor::findOrFail($id);

        if ($request->hasFile('foto')) {
    $imageName = time().'.'.$request->foto->extension();
    $request->foto->move(public_path('Data/profile_pict_assesor'), $imageName);

    // Hapus gambar lama jika ada
    if ($assessor->foto) {
        Storage::delete('Data/profile_pict_assesor/' . $assessor->foto);
    }

    $assessor->foto = $imageName;
}

        $assessor->update($request->except('foto'));

        return redirect()->route('profile-view-assessor');
    }
}
