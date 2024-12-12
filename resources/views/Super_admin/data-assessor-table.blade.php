@extends('layout.super_admin')
@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Data Assessor RPL</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item"><a href="/account-assessor-add">Tambah Akun</a></li>
          <li class="breadcrumb-item active">Assesor</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-12">


          <div class="card">
            <div class="card-body">
              <h5 class="card-title center" align="center">Akun Assesor</h5>

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
                      <th scope="col">No.Whatsapp</th>
                      <!-- <th scope="col">Kelamin</th>
                      <th scope="col">Alamat</th> -->
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users_assessor as $index => $user)
                      <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                          @if($user->assessor)
                              {{ $user->assessor->nama }}
                          @else
                              Data tidak tersedia
                          @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>rahasia</td>
                        <td>
                          @if($user->assessor)
                              {{ $user->assessor->no_wa }}
                          @else
                              Data tidak tersedia
                          @endif
                      </td>
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
