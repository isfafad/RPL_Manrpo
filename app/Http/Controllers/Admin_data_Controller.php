<?php

namespace App\Http\Controllers;
use App\Models\Jurusan;
use App\Models\Admin;
use App\Models\User;
use App\Models\Calon_mahasiswa;
use App\Models\Assessor;
use App\Models\Cpmk;
use App\Models\Matkul;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class Admin_data_Controller extends Controller
{
    public function profile_view_admin(){
        $user = Auth::user();
        $admin = $user->admin ?? new Admin(['user_id' => $user->id]);
        return view('Admin/profile-admin', compact('admin','user'));
    }
    public function profile_edit_admin_view($id){
        $admin = Admin::where('user_id', Auth::id())->findOrFail($id);
        return view('Admin/profile-edit-admin', compact('admin'));
    }
    public function profile_edit_admin(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
        ]);

        $admin = Admin::where('user_id', Auth::id())->findOrFail($id);

        if ($request->hasFile('foto')) {
            $imageName = time().'.'.$request->foto->extension();  
            $request->foto->move(public_path('Data/profile_pict_admin'), $imageName);
            
            if ($admin->foto) {
                $oldImagePath = public_path('Data/profile_pict_admin/' . $admin->foto);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            $admin->foto = $imageName; 
            $admin->save();
        }

        $admin->update($request->except('foto')); // Update data lainnya

        return redirect()->route('profile-view-admin');
    }
    public function account_assessor_table(Request $request){
        $jurusans = Jurusan::all();
        $jurusan_id = $request->jurusan_id ?? ($jurusans->isEmpty() ? null : $jurusans[0]->id);
        $users_camaba = [];
        if ($jurusan_id) {
        $users_assessor = User::where('role', 'assessor')
                            ->whereHas('assessor', function($query) use ($jurusan_id) {
                                $query->where('jurusan_id', $jurusan_id);
                            })->get();
        }
        return view('Admin/account-assessor-table',compact('users_assessor','jurusans','jurusan_id'));
    }
    public function account_assessor_add(){
        $jurusan = Jurusan::select('id','nama_jurusan')->get();
        return view('Admin/account-assessor-add', compact('jurusan'));
    }

    public function account_assessor_add_data(Request $request){
        
        $request->validate([
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'assessor'
        ]);

        Assessor::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('account-assessor-table')->with('success', 'Assessor created successfully!');
    }

    public function account_user_table(Request $request){
        $jurusans = Jurusan::all();
        $jurusan_id = $request->jurusan_id ?? ($jurusans->isEmpty() ? null : $jurusans[0]->id);
        $users_camaba = [];
        if ($jurusan_id) {
            $users_camaba = User::where('role', 'pendaftar')
                                ->whereHas('calon_mahasiswa', function($query) use ($jurusan_id) {
                                    $query->where('jurusan_id', $jurusan_id);
                                })->get();
        }
        return view('Admin/account-user-table',compact('users_camaba','jurusans','jurusan_id'));
    }
    public function account_user_add(){
        $jurusan = Jurusan::all();
        return view('Admin/account-user-add', compact('jurusan'));
    }
    public function account_user_add_data(Request $request){

            // Validasi data
    $request->validate([
        'email' => 'required|email|max:255|unique:users',
        'username' => 'required|string|max:255|unique:users',
        'password' => 'required|string|min:6',
        'nama' => 'required|string|max:255',
        'jurusan_id' => 'required|exists:jurusan,id',
    ]);

    // Buat user baru
    $user = User::create([
        'email' => $request->email,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'role' => 'pendaftar'
    ]);

    // Buat calon mahasiswa baru
    Calon_mahasiswa::create([
        'user_id' => $user->id,
        'nama' => $request->nama,
        'jurusan_id' => $request->jurusan_id,
    ]);

    // Redirect kembali dengan pesan sukses
    return redirect()->route('account-user-table')->with('success', 'Pendaftar created successfully!');

    }
    public function account_admin_table(Request $request){
        $jurusans = Jurusan::all();
        $jurusan_id = $request->jurusan_id ?? ($jurusans->isEmpty() ? null : $jurusans[0]->id);
        $users_admin = [];
        if ($jurusan_id) {
            $users_admin = User::where('role', 'admin')
                                ->whereHas('admin', function($query) use ($jurusan_id) {
                                    $query->where('jurusan_id', $jurusan_id);
                                })->get();
        }
        return view('Admin/account-admin-table',compact('users_admin','jurusans','jurusan_id'));
    }
    public function account_admin_add(){
        $jurusan = Jurusan::all();
        return view('Admin/account-admin-add', compact('jurusan'));
    }
    public function account_admin_add_data(Request $request){
        // dd($request->all());
        $request->validate([
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);

        Admin::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('account-admin-table')->with('success', 'Admin created successfully!');
    }

    public function kelola_assessor_table(){
        return view('Admin/kelola-assessor-table');
    }
    public function kelola_assessor_mahasiswa(Request $request){
        $jurusans = Jurusan::all();
        $jurusan_id = $request->jurusan_id ?? ($jurusans->isEmpty() ? null : $jurusans[0]->id);
        $calon_mahasiswa = [];
        if ($jurusan_id) {
            $calon_mahasiswa = Calon_mahasiswa::with(['jurusan', 'assessment.assessor1', 'assessment.assessor2', 'assessment.assessor3'])
                                ->whereHas('jurusan', function($query) use ($jurusan_id) {
                                    $query->where('id', $jurusan_id);
                                })->get();
        }
        $assessor = Assessor::all();
        return view('Admin/kelola-assessor-mahasiswa', compact('calon_mahasiswa','assessor','jurusans','jurusan_id'));
    }
    public function kelola_assessor_mahasiswa_add(Request $request){
        $validated = $request->validate([
            'calon_mahasiswa_id' => 'required|exists:calon_mahasiswa,id',
            'assessor1_id' => 'required|exists:assessor,id',
            'assessor2_id' => 'required|exists:assessor,id',
            'assessor3_id' => 'required|exists:assessor,id',
        ]);

        // Cek jika assessor yang dipilih sama
        if ($validated['assessor1_id'] == $validated['assessor2_id'] || 
            $validated['assessor1_id'] == $validated['assessor3_id'] ||
            $validated['assessor2_id'] == $validated['assessor3_id']) {
            return back()->withErrors(['message' => 'Assessor tidak boleh sama.']);
        }

        $jurusan_id = Calon_mahasiswa::find($validated['calon_mahasiswa_id'])->jurusan_id;

        Assessment::updateOrCreate(
            ['calon_mahasiswa_id' => $validated['calon_mahasiswa_id']],
            [
                'jurusan_id' => $jurusan_id,
                'assessor_id_1' => $validated['assessor1_id'],
                'assessor_id_2' => $validated['assessor2_id'],
                'assessor_id_3' => $validated['assessor3_id'],
            ]
        );

        return redirect()->route('kelola-assessor-mahasiswa')->with('success', 'Assessment created successfully!');
    }
    public function kelola_matkul_table(Request $request){
        $jurusans = Jurusan::all();
        $jurusan_id = $request->jurusan_id ?? ($jurusans->isEmpty() ? null : $jurusans[0]->id);
        $matkuls = [];
        if ($jurusan_id) {
            $matkuls = Matkul::where('jurusan_id', $jurusan_id)->get();
        }
        return view('Admin/kelola-matkul-table',compact('matkuls','jurusans','jurusan_id'));
    }
    public function kelola_matkul_add_data(Request $request){
        $request->validate([
            'nama_matkul'=>'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        Matkul::create([
            'nama_matkul' => $request->nama_matkul,
            'jurusan_id' => $request->jurusan_id,
        ]);
        return redirect()->route('kelola-matkul-table')->with('success', 'Matkul created successfully!');
    }
    public function kelola_cpmk_table($matkul_id){
        $matkul = Matkul::findOrFail($matkul_id);
        $cpmks = Cpmk::where('matkul_id',$matkul_id)->get();
        return view('Admin/kelola-cpmk-table',compact('matkul','cpmks'));
    }
   
    public function create_data_cpmk($matkul_id)
    {
        $matkul = Matkul::findOrFail($matkul_id);
        return view('Admin/kelola-cpmk-table', compact('matkul'));
    }

 
    public function add_data_cpmk(Request $request)
    {
    $request->validate([
        'penjelasan' => 'required|string',
        'matkul_id' => 'required|exists:matkul,id',
    ]);

    Cpmk::create([
        'penjelasan' => $request->penjelasan,
        'matkul_id' => $request->matkul_id,
    ]);

    return redirect()->route('kelola-cpmk-table', $request->matkul_id)->with('success', 'CPMK created successfully!');
    }


    public function delete(Cpmk $cpmk)
    {
        $cpmk->delete();
        return back()->with('success', 'CPMK deleted successfully!');
    }

    public function delete_cpmk(Cpmk $cpmk)
    {
        $cpmk->delete();
        return back()->with('success', 'CPMK deleted successfully!');
    }
    
    public function delete_matkul(Matkul $matkul)
    {
        $matkul->delete();
        return back()->with('success', 'Matkul deleted successfully!');
    }

    public function delete_user(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    public function data_user_table(){
        $camaba = Calon_mahasiswa::all();
        $users_camaba = User::where('role','pendaftar')->get();
        return view('Admin/data-user-table',compact('users_camaba'));
    }
    public function data_assessor_table(){
        $assessor = Assessor::all();
        $users_assessor = User::where('role','assessor')->get();
        return view('Admin/data-assessor-table',compact('users_assessor','assessor'));
    }
}
