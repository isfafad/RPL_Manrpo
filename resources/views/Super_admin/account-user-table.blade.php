@extends('layout.super_admin')
@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Tambah Akun</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item"><a href="/account-assessor-add"></a>Tambah Akun</li>
          <li class="breadcrumb-item active">User</li>
        </ol>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-12">


          <div class="card">
            <div class="card-body">
              <h5 class="card-title center" align="center">Akun Mahasiswa RPL</h5>
              <a href="/account-user-add"><button type="button" class="btn btn-primary mb-3 float-end" >Tambah</button></a>

              <!-- Default Table -->
              <div class="table-container">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">id</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Email</th>
                      <th scope="col">Username</th>
                      <th scope="col">Password</th>
                      <!-- <th scope="col">Tempat Lahir</th>
                      <th scope="col">Tanggal Lahir</th>
                      <th scope="col">No.HP</th> -->
                      <th scope="col">Jurusan</th>
                      <!-- <th scope="col">Kelamin</th>
                      <th scope="col">Alamat</th>
                      <th scope="col">Kota</th>
                      <th scope="col">Provinsi</th>
                      <th scope="col">Kode Pos</th>
                      <th scope="col">Jenjang</th> -->
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users_camaba as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($user->calon_mahasiswa)
                                    {{ $user->calon_mahasiswa->nama }}
                                @else
                                    Data tidak tersedia
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ 'rahasia' }}</td>
                            <td>
                                @if($user->calon_mahasiswa && $user->calon_mahasiswa->jurusan)
                                    {{ $user->calon_mahasiswa->jurusan->nama_jurusan }}
                                @else
                                    Data tidak tersedia
                                @endif
                            </td>
                            <td><i type="button" class="bi-trash"></i></td>
                        </tr>
                    @endforeach
                    {{-- <tr>
                      <td>111</td>
                      <td>Revanza</td>
                      <td>rvanza453@gmail.com</td>
                      <td>rvanza</td>
                      <td>123</td>
                      <!-- <td>Gresik</td>
                      <td>04/05/2003</td>
                      <td>082333869696</td> -->
                      <td>Informatika</td>
                      <!-- <td>Laki-laki</td>
                      <td>Perum siwalan permai</td>
                      <td>Tuban</td>
                      <td>Jawa Timur</td>
                      <td>62351</td>
                      <td>S1</td> -->
                      <td><i type="button" class="bi-trash"></i></td>
                    </tr> --}}
                  </tbody>
                </table>
              </div>
              <!-- End Default Table Example -->

            </div>
          </div>


        </div>
      </div>
    </section>


  </main><!-- End #main -->
@endsection
