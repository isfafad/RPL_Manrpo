@extends('layout.super_admin')
@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Tambah Akun</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item"><a href="/account-assessor-add"></a>Tambah Akun</li>
          <li class="breadcrumb-item active">Admin</li>
        </ol>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-12">


          <div class="card">
            <div class="card-body">
              <h5 class="card-title center" align="center">Akun Admin</h5>
              <a href="/account-admin-add"><button type="button" class="btn btn-primary mb-3 float-end" >Edit</button></a>

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
                      <!-- <th scope="col">No.HP</th> -->
                      <th scope="col">Jurusan</th>
                      <!-- <th scope="col">Kelamin</th> -->
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users_admin as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($user->admin)
                                    {{ $user->admin->nama }}
                                @else
                                    Data tidak tersedia
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ 'rahasia' }}</td>
                            <td>
                                @if($user->admin && $user->admin->jurusan)
                                    {{ $user->admin->jurusan->nama_jurusan }}
                                @else
                                    Data tidak tersedia
                                @endif
                            </td>
                            <td><i type="button" class="bi-trash"></i></td>
                        </tr>
                    @endforeach
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
