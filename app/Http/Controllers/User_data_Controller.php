<?php

namespace App\Http\Controllers;

use App\Models\Calon_mahasiswa;
use App\Models\Self_assessment_camaba;
use App\Models\Jurusan;
use App\Models\Ijazah;
use App\Models\Matkul;
use App\Models\Matkul_score;
use App\Models\User;
use App\Models\Cpmk;
use App\Models\Bukti;
use GuzzleHttp\Promise\Create;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class User_data_Controller extends Controller
{
    
    public function profile_view_camaba(){
        $user = Auth::user();
        $calon_mahasiswa = $user->calon_mahasiswa;
        return view('User/profile-view-camaba', compact('calon_mahasiswa','user'));
    }
    public function profile_edit_camaba_view($id){
        $calon_mahasiswa = Calon_mahasiswa::findOrFail($id);
        return view('User/profile-edit-camaba', compact('calon_mahasiswa'));
    }
    public function profile_edit_camaba(Request $request, $id){
        $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string|max:255',
            'no_wa' => 'required|string|max:255',
            'kelamin' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5049',
        ]);

        $calon_mahasiswa = Calon_Mahasiswa::findOrFail($id);
        if ($request->hasFile('foto')) {
            $imageName = time().'.'.$request->foto->extension();  
            $request->foto->move(public_path('Data/profile_pict_camaba'), $imageName);
    
            // Hapus foto lama jika ada
            if ($calon_mahasiswa->foto) {
                $oldImagePath = public_path('Data/profile_pict_camaba/' . $calon_mahasiswa->foto);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            $calon_mahasiswa->foto = $imageName; 
            $calon_mahasiswa->save(); // Simpan perubahan pada model secara terpisah
        }
    
        $calon_mahasiswa->update($request->except('foto'));

        return redirect()->route('profile-view-camaba');
    }
    
    public function view_ijazah(){
        $user = Auth::user();
    
        // Cek apakah camaba yang login memiliki ijazah
        if ($user->calon_mahasiswa && $user->calon_mahasiswa->ijazah) {
            $ijazah = $user->calon_mahasiswa->ijazah;
            return view('User.view-ijazah', compact('ijazah'));
        } else {
            // Jika camaba belum memiliki ijazah, redirect ke halaman tambah ijazah
            return redirect()->route('ijazah-add-view')->with('message', 'Silakan tambah ijazah terlebih dahulu.');
        }
    }
    
    public function ijazah_edit_view($id)
    {
        $user = auth()->user();
        if ($user->role !== 'pendaftar') {
            abort(403, 'Unauthorized action');
        }
    
        $ijazah = Ijazah::where('id', $id)
                        ->where('calon_mahasiswa_id', $user->calon_mahasiswa->id)
                        ->firstOrFail();
    
        return view('User.ijazah-edit', compact('ijazah'));
    }
    
    public function ijazah_add_view(){
        // Get the logged-in user's calon_mahasiswa data
    $user = Auth::user();
    $calon_mahasiswa = $user->calon_mahasiswa;
    
        // Pass calon_mahasiswa data to the view if needed
    return view('User.ijazah-add', compact('calon_mahasiswa'));
    }
    
    
    public function ijazah_add(Request $request){
    $request->validate([
            'institusi_pendidikan' => 'required|string|max:255',
            'jenjang' => 'required|string|max:10',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'ipk_nilai' => 'required|string|max:10',
            'tahun_lulus' => 'required|integer|min:1900|max:'.(date('Y')),
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);
    
        // $filePath = $request->file('file')->store('Data/Ijazah', 'public');
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $filename;
    
        $file->move(public_path('Data/Ijazah'), $filename);
    
        Ijazah::create([
            'calon_mahasiswa_id' => Auth::user()->calon_mahasiswa->id,
            'institusi_pendidikan' => $request->institusi_pendidikan,
            'jenjang' => $request->jenjang,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'negara' => $request->negara,
            'fakultas' => $request->fakultas,
            'jurusan' => $request->jurusan,
            'ipk_nilai' => $request->ipk_nilai,
            'tahun_lulus' => $request->tahun_lulus,
            'file' => $filePath,
        ]);
    
        return redirect()->route('view-ijazah')->with('success', 'Ijazah berhasil ditambahkan.');
    }
    
    public function ijazah_edit(Request $request, $id)
    {
        $request->validate([
            'institusi_pendidikan' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'ipk_nilai' => 'required|string|max:255',
            'tahun_lulus' => 'required|Integer',
            'file' => 'sometimes|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
    
        $ijazah = ijazah::findOrFail($id);
    
        if ($request->hasFile('file')) {
            $fileExtension = $request->file('file')->extension();
    
            $filename = time() . '.' . $fileExtension;
            $filePath = $filename;
    
            $request->file('file')->move(public_path('Data/Ijazah/'), $filename);
    
            if ($ijazah->file) {
                $oldFilePath = public_path('Data/Ijazah/' . $ijazah->file); 
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
    
            $ijazah->file = $filePath; 
        }
    
        $ijazah->update($request->except('file'));
        
        return redirect()->route('view-ijazah');
    }
    

    public function self_assessment(Request $request){
        $calon_mahasiswa = auth()->user()->calon_mahasiswa;
        $matkul = Matkul::where('jurusan_id', $calon_mahasiswa->jurusan_id)->select('id','nama_matkul')->get();
        $matkul_id = $request->matkul_id ?? ($matkul->isEmpty() ? null : $matkul[0]->id);
        $cpmks = [];
        if ($matkul_id) {
            $cpmks = Cpmk::where('matkul_id', $matkul_id)->get();
        }
        return view('User/self-assessment',compact('matkul','cpmks','matkul_id'));
    }

    public function add_self_assessment(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'pendaftar') {
            abort(403, 'Unauthorized action');
        }

        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|in:Sangat Baik,Baik,Tidak Pernah',
            'bukti' => 'array',
            'bukti.*.nama' => 'nullable|string|max:255',
            'bukti.*.jenis_bukti' => 'nullable|string|max:255',
            'bukti.*.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,mp4,mkv|max:20069'
        ]);

        $calon_mahasiswa = auth()->user()->calon_mahasiswa;

        // Loop through each CPMK that has a value
        foreach ($request->nilai as $cpmk_id => $nilai) {
            // Inisialisasi $bukti dengan null
            $bukti = null;

            if ($nilai === 'Tidak Pernah') {
                // If "Tidak Pernah" is selected, skip file upload
                $bukti = Bukti::create([
                    'nama' => '', 
                    'jenis_bukti' => '', 
                    'file' => '', 
                ]);
            } else {
                // Handle the file upload for other options
                if ($request->hasFile('bukti.' . $cpmk_id . '.file')) {
                    $file = $request->file('bukti.' . $cpmk_id . '.file');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filePath = 'Data/bukti_self_assessment/' . $filename;

                    $file->move(public_path('Data/bukti_self_assessment/'), $filename);

                    // Save Bukti
                    $bukti = Bukti::create([
                        'nama' => $request->bukti[$cpmk_id]['nama'],
                        'jenis_bukti' => $request->bukti[$cpmk_id]['jenis_bukti'],
                        'file' => $filePath,
                    ]);
                } else {
                    // Create an empty bukti if no file is uploaded
                    $bukti = Bukti::create([
                        'nama' => '', 
                        'jenis_bukti' => '', 
                        'file' => '', 
                    ]);
                }
            }

            // Save Self Assessment dengan updateOrCreate
            Self_assessment_camaba::updateOrCreate(
                [
                    'calon_mahasiswa_id' => $calon_mahasiswa->id,
                    'cpmk_id' => $cpmk_id
                ],
                [
                    'nilai' => $nilai,
                    'bukti_id' => $bukti->id
                ]
            );
        }

        return redirect()->route('self-assessment-table')->with('success', 'Penilaian dan bukti berhasil disimpan.');
    }

    public function self_assessment_table(Request $request){
        $user = auth()->user();
        if ($user->role !== 'pendaftar'){
            abort(403, 'Unauthorized action');
        }
        $calon_mahasiswa = $user->calon_mahasiswa;
        $matkuls = Matkul::where('jurusan_id', $calon_mahasiswa->jurusan_id)->select('id', 'nama_matkul')->get();
        $matkul_id = $request->get('matkul_id') ?? ($matkuls->isEmpty() ? null : $matkuls[0]->id);

        // Data untuk edit mode
        $editMode = $request->get('edit_mode', false);
        $existingAssessments = [];
        
        if ($editMode && $matkul_id) {
            $existingAssessments = Self_assessment_camaba::with(['bukti', 'cpmk'])
                ->where('calon_mahasiswa_id', $calon_mahasiswa->id)
                ->whereHas('cpmk', function($query) use ($matkul_id) {
                    $query->where('matkul_id', $matkul_id);
                })
                ->get()
                ->keyBy('cpmk_id');
        }

        $cpmks = [];
        $assessments = [];
        if ($matkul_id) {
            $cpmks = Cpmk::where('matkul_id', $matkul_id)->get();
            $assessments = $calon_mahasiswa->self_assessment_camaba()->with('cpmk')->whereHas('cpmk', function($query) use ($matkul_id) {
                $query->where('matkul_id', $matkul_id);
            })->whereNotNull('nilai')->get();
        }
        return view('User/self-assessment-table', compact('assessments','matkuls','matkul_id','cpmks','editMode','existingAssessments'));
    }
    public function view_nilai(){
        $calon_mahasiswa_id = auth()->user()->calon_mahasiswa->id;
        $assessments = DB::table('self_assessment_camaba')  // Menggunakan nama tabel yang benar
            ->join('cpmk', 'self_assessment_camaba.cpmk_id', '=', 'cpmk.id')
            ->select('cpmk.matkul_id')
            ->where('self_assessment_camaba.calon_mahasiswa_id', $calon_mahasiswa_id)
            ->groupBy('cpmk.matkul_id')
            ->get();

        // array untuk menyimpan hasil penilaian
        $matkulScores = [];
        
        foreach($assessments as $assessment) {
            // Cek nilai dari ketiga assessor untuk setiap mata kuliah
            $scores = Matkul_score::where('calon_mahasiswa_id', $calon_mahasiswa_id)
                ->where('matkul_id', $assessment->matkul_id)
                ->get();
                
            $matkul = Matkul::find($assessment->matkul_id);
            
            // Hitung jumlah assessor yang sudah menilai
            $assessorCount = $scores->count();
            // Hitung jumlah status 'Lolos'
            $lolosCount = $scores->where('status', 'Lolos')->count();
            
            // Tentukan status berdasarkan mayoritas
            $status = 'Belum Ditentukan';
            if ($assessorCount >= 2) { 
                if ($lolosCount >= 2) {
                    $status = 'Lolos';
                } elseif (($assessorCount - $lolosCount) >= 2) {
                    $status = 'Gagal';
                }
            }

            $matkulScores[] = [
                'matkul' => $matkul,
                'status' => $status,
                'nilai' => $assessorCount == 3 ? $scores->first()->nilai : '-',
                'is_complete' => $assessorCount >= 2 // Ubah ke minimal 2 assessor
            ];
        }
        return view('User.view-nilai', compact('matkulScores'));
    }
    public function delete_self_assessment($id)
    {
        $user = auth()->user();
        if ($user->role !== 'pendaftar') {
            abort(403, 'Unauthorized action');
        }
    
        try {
            // Ambil data assessment berdasarkan ID dan user (melalui calon_mahasiswa)
            $assessment = $user->calon_mahasiswa
                             ->self_assessment_camaba()
                             ->findOrFail($id);
            
            // Hapus file bukti jika ada
            if ($assessment->bukti && Storage::exists($assessment->bukti)) {
                Storage::delete($assessment->bukti);
            }
            
            $assessment->delete();
            
            return redirect()->back()
                            ->with('success', 'Penilaian berhasil dihapus');
                            
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal menghapus penilaian');
        }
    }

    public function input_transkrip(){
        return view('User.input-transkrip');
    }
    

}