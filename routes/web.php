<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Super_admin_data_controller;
use App\Http\Controllers\User_data_Controller;
use App\Http\Controllers\Admin_data_Controller;
use App\Http\Controllers\Assessor_data_Controller;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\dashboardcontroller;

Route::get('/', function () {
    return view('login');
});

//Assessor_controller
Route::middleware('auth')->group(function () {
    Route::get('/form-user/{matkul_id}',[Assessor_data_Controller::class,'form_user'])->name('form-user');
    Route::post('/input_calculate', [Assessor_data_Controller::class, 'input_calculate'])->name('input_calculate');
    Route::post('/nilai-matkul-input', [Assessor_data_Controller::class, 'input_nilai_matkul'])->name('nilai-matkul-input');
    Route::get('/list-name-table',[Assessor_data_Controller::class,'list_name_table'])->name('list-name-table');
    Route::get('/assessor/detail-user/{id}', [Assessor_data_Controller::class, 'detail_user'])->name('detail-user');
    Route::get('/profile-view-assessor', [Assessor_data_Controller::class, 'profile_view_assessor'])->name('profile-view-assessor');
    Route::get('/assessor/profile/edit/{id}', [Assessor_data_Controller::class, 'profile_assessor_edit_view'])->name('profile-assessor-edit-view');
    Route::post('/assessor/profile/edit/{id}', [Assessor_data_Controller::class, 'profile_edit_assessor'])->name('profile-edit-assessor');
});

Route::group(['middleware' => 'pendaftar'], function(){
    Route::get('user/dashboard', [dashboardcontroller::class, 'dashboard']);
});
Route::group(['middleware' => 'assessor'], function(){
    Route::get('assessor/dashboard', [dashboardcontroller::class, 'dashboard']);
});
Route::group(['middleware' => 'admin'], function(){
    Route::get('admin/dashboard', [dashboardcontroller::class, 'dashboard']);
});
Route::group(['middleware' => 'super'], function () {
    Route::get('super_admin/dashboard', [dashboardcontroller::class, 'dashbboard'])->name('super-dashboard');
});



//Admin_controller
Route::get('/profile-view-admin', [Admin_data_Controller::class, 'profile_view_admin'])->name('profile-view-admin');
Route::get('/admin/profile/edit/{id}', [Admin_data_Controller::class, 'profile_edit_admin_view'])->name('profile-edit-admin-view');
Route::post('/admin/profile/edit/{id}', [Admin_data_Controller::class, 'profile_edit_admin'])->name('profile-edit-admin');

Route::get('/account-assessor-table',[Admin_data_Controller::class, 'account_assessor_table'])->name('account-assessor-table');
Route::get('/account-assessor-add', [Admin_data_Controller::class, 'account_assessor_add'])->name('account-assessor-add');
Route::post('/account-assessor-add-data', [Admin_data_Controller::class, 'account_assessor_add_data'])->name('account-assessor-add-data');

Route::get('/account-user-table', [Admin_data_Controller::class, 'account_user_table'])->name('account-user-table');
Route::get('/account-user-add', [Admin_data_Controller::class, 'account_user_add'])->name('account-user-add');
Route::post('/account-user-add-data', [Admin_data_Controller::class, 'account_user_add_data'])->name('account-user-add-data');

Route::get('/account-admin-table', [Admin_data_Controller::class, 'account_admin_table'])->name('account-admin-table');
Route::get('/account-admin-add', [Admin_data_Controller::class, 'account_admin_add'])->name('account-admin-add');
Route::post('/account-admin-add-data', [Admin_data_Controller::class, 'account_admin_add_data'])->name('account-admin-add-data');

Route::get('/data-assessor-table', [Admin_data_Controller::class, 'data_assessor_table'])->name('data-assessor-table');
Route::get('/data-user-table', [Admin_data_Controller::class, 'data_user_table'])->name('data-user-table');
Route::get('/kelola-matkul-table', [Admin_data_Controller::class, 'kelola_matkul_table'])->name('kelola-matkul-table');
Route::post('/kelola-matkul-add-data', [Admin_data_Controller::class, 'kelola_matkul_add_data'])->name('kelola-matkul-add-data');
Route::delete('/kelola-matkul-table/{matkul}', [Admin_data_Controller::class, 'delete_matkul'])->name('delete-matkul');

Route::get('/kelola-cpmk/{matkul_id}', [Admin_data_Controller::class, 'kelola_cpmk_table'])->name('kelola-cpmk-table');
Route::get('/kelola-cpmk/create/{matkul_id}', [Admin_data_Controller::class, 'create_data_cpmk'])->name('create-data-cpmk');
Route::post('/kelola-cpmk/store', [Admin_data_Controller::class, 'add_data_cpmk'])->name('add-data-cpmk');
Route::delete('/kelola-cpmk/{cpmk}', [Admin_data_Controller::class, 'delete_cpmk'])->name('delete-cpmk');
Route::delete('/data-user-table/{user}', [Admin_data_Controller::class, 'delete_user'])->name('delete-user');

Route::get('/kelola-assessor-table', [Admin_data_Controller::class, 'kelola_assessor_table'])->name('kelola-assessor-table');
Route::get('/kelola-assessor-mahasiswa', [Admin_data_Controller::class, 'kelola_assessor_mahasiswa'])->name('kelola-assessor-mahasiswa');
Route::post('/kelola-assessor-mahasiswa/add', [Admin_data_Controller::class, 'kelola_assessor_mahasiswa_add'])->name('kelola-assessor-mahasiswa-add');

//SuperAdmin_controller
// Route::get('/account-assessor-table',[Super_admin_data_controller::class, 'account_assessor_table'])->name('account-assessor-table');
// Route::get('/account-assessor-add', [Super_admin_data_controller::class, 'account_assessor_add'])->name('account-assessor-add');
// Route::post('/account-assessor-add-data', [Super_admin_data_controller::class, 'account_assessor_add_data'])->name('account-assessor-add-data');

// Route::get('/account-user-table', [Super_admin_data_controller::class, 'account_user_table'])->name('account-user-table');
// Route::get('/account-user-add', [Super_admin_data_controller::class, 'account_user_add'])->name('account-user-add');
// Route::post('/account-user-add-data', [Super_admin_data_controller::class, 'account_user_add_data'])->name('account-user-add-data');

// Route::get('/account-admin-table', [Super_admin_data_controller::class, 'account_admin_table'])->name('account-admin-table');
// Route::get('/account-admin-add', [Super_admin_data_controller::class, 'account_admin_add'])->name('account-admin-add');
// Route::post('/account-admin-add-data', [Super_admin_data_controller::class, 'account_admin_add_data'])->name('account-admin-add-data');

// Route::get('/data-assessor-table', [Super_admin_data_controller::class, 'data_assessor_table'])->name('data-assessor-table');
// Route::get('/data-user-table', [Super_admin_data_controller::class, 'data_user_table'])->name('data-user-table');
// Route::get('/kelola-matkul-table', [Super_admin_data_controller::class, 'kelola_matkul_table'])->name('kelola-matkul-table');
// Route::post('/kelola-matkul-add-data', [Super_admin_data_controller::class, 'kelola_matkul_add_data'])->name('kelola-matkul-add-data');

// Route::get('/kelola-cpmk/{matkul_id}', [Super_admin_data_controller::class, 'kelola_cpmk_table'])->name('kelola-cpmk-table');
// Route::get('/kelola-cpmk/create/{matkul_id}', [Super_admin_data_controller::class, 'create_data_cpmk'])->name('create-data-cpmk');
// Route::post('/kelola-cpmk/store', [Super_admin_data_controller::class, 'add_data_cpmk'])->name('add-data-cpmk');
// Route::delete('/kelola-cpmk/{cpmk}', [Super_admin_data_controller::class, 'delete'])->name('delete-cpmk');

// Route::get('/kelola-assessor-table', [Super_admin_data_controller::class, 'kelola_assessor_table'])->name('kelola-assessor-table');
// Route::get('/kelola-assessor-mahasiswa', [Super_admin_data_controller::class, 'kelola_assessor_mahasiswa'])->name('kelola-assessor-mahasiswa');

//User_controller
Route::get('/ijazah-edit-view/{id}',[User_data_Controller::class, 'ijazah_edit_view'])->name('ijazah-edit-view');
Route::post('ijazah/edit/{id}', [User_data_Controller::class, 'ijazah_edit'])->name('ijazah_edit');
Route::get('ijazah/add-view', [User_data_Controller::class, 'ijazah_add_view'])->name('ijazah-add-view');
Route::post('ijazah/add', [User_data_Controller::class, 'ijazah_add'])->name('ijazah-add');
Route::get('view-ijazah',[User_data_Controller::class, 'view_ijazah'])->name('view-ijazah');
Route::get('profile/edit/{id}', [User_data_Controller::class, 'profile_edit_camaba_view'])->name('profile_edit_camaba_view');
Route::post('profile/edit/{id}', [User_data_Controller::class, 'profile_edit_camaba'])->name('profile_edit_camaba');
Route::get('/profile-view-camaba',[User_data_Controller::class, 'profile_view_camaba'])->name('profile-view-camaba');
Route::get('/self-assessment',[User_data_Controller::class, 'self_assessment'])->name('self-assessment');
Route::post('/add-self-assessment', [User_data_Controller::class, 'add_self_assessment'])->name('add-self-assessment');
Route::delete('/delete-self-assessment/{id}', [User_data_Controller::class, 'delete_self_assessment'])->name('delete-self-assessment')->middleware(['auth']);
Route::get('/input-transkrip',[User_data_Controller::class,'input_transkrip'])->name('input-transkrip');

Route::get('/self-assessment-table',[User_data_Controller::class,'self_assessment_table'])->name('self-assessment-table');
Route::get('/view-nilai',[User_data_Controller::class,'view_nilai'])->name('view-nilai');
// Route::get('/login', [User_data_Controller::class, 'login'])->name('login');
// Route::get('/register', [User_data_Controller::class,'register'])->name('register');

Route::get('/login', [logincontroller::class, 'login'])->name('login');
Route::post('/loginproses', [logincontroller::class, 'loginproses'])->name('loginproses');
Route::get('/logout', [logincontroller::class, 'logout'])->name('logout');
Route::get('/register', [logincontroller::class, 'register'])->name('register');
Route::post('/registeruser', [logincontroller::class, 'registeruser'])->name('registeruser');

//Middleware



// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/Admin/welcome', function () {
//         return view('Admin.welcome');
//     })->name('Admin.welcome');
// });

// Route::middleware(['auth', 'role:assessor'])->group(function () {
//     Route::get('/Assessor/welcome', function () {
//         return view('Assessor.welcome');
//     })->name('Assessor.welcome');
// });

// Route::middleware(['auth', 'role:pendaftar'])->group(function () {
//     Route::get('/User/welcome', function () {
//         return view('User.welcome');
//     })->name('User.welcome');
// });
