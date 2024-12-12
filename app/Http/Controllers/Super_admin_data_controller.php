<?php

// namespace App\Http\Controllers;

// use App\Models\Jurusan;
// use App\Models\Admin;
// use App\Models\User;
// use App\Models\Calon_mahasiswa;
// use App\Models\Assessor;
// use App\Models\Cpmk;
// use App\Models\Matkul;
// use App\Models\Super_admin;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Http\Request;

// class Super_admin_data_controller extends Controller
// {
//     public function account_assessor_table(){
//         $users_assessor = User::where('role','assessor')->get();
//         return view('super_admin/account-assessor-table',compact('users_assessor'));
//     }
//     public function account_assessor_add(){
//         $jurusan = Jurusan::select('id','nama_jurusan')->get();
//         return view('super_admin/account-assessor-add', compact('jurusan'));
//     }

//     public function account_assessor_add_data(Request $request){
        
//         $request->validate([
//             'email' => 'required|email|max:255|unique:users',
//             'username' => 'required|string|max:255|unique:users',
//             'password' => 'required|string|min:6',
//             'nama' => 'required|string|max:255',
//             'jurusan_id' => 'required|exists:jurusan,id',
//         ]);

//         $user = User::create([
//             'email' => $request->email,
//             'username' => $request->username,
//             'password' => Hash::make($request->password),
//             'role' => 'assessor'
//         ]);

//         Assessor::create([
//             'user_id' => $user->id,
//             'nama' => $request->nama,
//             'jurusan_id' => $request->jurusan_id,
//         ]);

//         return redirect()->route('account-assessor-table')->with('success', 'Assessor created successfully!');
//     }

//     public function account_user_table(){
//         $users_camaba = User::where('role','pendaftar')->get();
//         return view('super_admin/account-user-table',compact('users_camaba'));
//     }
//     public function account_user_add(){
//         $jurusan = Jurusan::all();
//         return view('super_admin/account-user-add', compact('jurusan'));
//     }
//     public function account_user_add_data(Request $request){

//             // Validasi data
//     $request->validate([
//         'email' => 'required|email|max:255|unique:users',
//         'username' => 'required|string|max:255|unique:users',
//         'password' => 'required|string|min:6',
//         'nama' => 'required|string|max:255',
//         'jurusan_id' => 'required|exists:jurusan,id',
//     ]);

//     // Buat user baru
//     $user = User::create([
//         'email' => $request->email,
//         'username' => $request->username,
//         'password' => Hash::make($request->password),
//         'role' => 'pendaftar'
//     ]);

//     // Buat calon mahasiswa baru
//     Calon_mahasiswa::create([
//         'user_id' => $user->id,
//         'nama' => $request->nama,
//         'jurusan_id' => $request->jurusan_id,
//     ]);

//     // Redirect kembali dengan pesan sukses
//     return redirect()->route('account-user-table')->with('success', 'Pendaftar created successfully!');

//     }
//     public function account_admin_table(){
//         $users_admin = User::where('role','admin')->get();
//         return view('super_admin/account-admin-table',compact('users_admin'));
//     }
//     public function account_admin_add(){
//         $jurusan = Jurusan::all();
//         return view('super_admin/account-admin-add', compact('jurusan'));
//     }
//     public function account_admin_add_data(Request $request){
//         // dd($request->all());
//         $request->validate([
//             'email' => 'required|email|max:255|unique:users',
//             'username' => 'required|string|max:255|unique:users',
//             'password' => 'required|string|min:6',
//             'nama' => 'required|string|max:255',
//             'jurusan_id' => 'required|exists:jurusan,id',
//         ]);

//         $user = User::create([
//             'email' => $request->email,
//             'username' => $request->username,
//             'password' => Hash::make($request->password),
//             'role' => 'admin'
//         ]);

//         Admin::create([
//             'user_id' => $user->id,
//             'nama' => $request->nama,
//             'jurusan_id' => $request->jurusan_id,
//         ]);

//         return redirect()->route('account-admin-table')->with('success', 'Admin created successfully!');
//     }

//     public function kelola_assessor_table(){
//         return view('super_admin/kelola-assessor-table');
//     }
//     public function kelola_assessor_mahasiswa(){
//         return view('super_admin/kelola-assessor-mahasiswa');
//     }
//     public function kelola_matkul_table(){
//         $matkuls = Matkul::all();
//         $jurusan = Jurusan::all();
//         return view('super_admin/kelola-matkul-table',compact('matkuls','jurusan'));
//     }
//     public function kelola_matkul_add_data(Request $request){
//         $request->validate([
//             'nama_matkul'=>'required|string|max:255',
//             'jurusan_id' => 'required|exists:jurusan,id',
//         ]);

//         Matkul::create([
//             'nama_matkul' => $request->nama_matkul,
//             'jurusan_id' => $request->jurusan_id,
//         ]);
//         return redirect()->route('kelola-matkul-table')->with('success', 'Matkul created successfully!');
//     }
//     public function kelola_cpmk_table($matkul_id){
//         $matkul = Matkul::findOrFail($matkul_id);
//         $cpmks = Cpmk::where('matkul_id',$matkul_id)->get();
//         return view('super_admin/kelola-cpmk-table',compact('matkul','cpmks'));
//     }
   
//     public function create_data_cpmk($matkul_id)
//     {
//         $matkul = Matkul::findOrFail($matkul_id);
//         return view('super_admin/kelola-cpmk-table', compact('matkul'));
//     }

 
//     public function add_data_cpmk(Request $request)
//     {
//     $request->validate([
//         'penjelasan' => 'required|string',
//         'matkul_id' => 'required|exists:matkul,id',
//     ]);

//     Cpmk::create([
//         'penjelasan' => $request->penjelasan,
//         'matkul_id' => $request->matkul_id,
//     ]);

//     return redirect()->route('kelola-cpmk-table', $request->matkul_id)->with('success', 'CPMK created successfully!');
//     }


//     public function delete(Cpmk $cpmk)
//     {
//         $cpmk->delete();
//         return back()->with('success', 'CPMK deleted successfully!');
//     }

//     public function data_user_table(){
//         $users_camaba = User::where('role','pendaftar')->get();
//         return view('super_admin/data-user-table',compact('users_camaba'));
//     }
//     public function data_assessor_table(){
//         $users_assessor = User::where('role','assessor')->get();
//         return view('super_admin/data-assessor-table',compact('users_assessor'));
//     }
// }
