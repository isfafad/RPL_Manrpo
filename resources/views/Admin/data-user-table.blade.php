@extends('layout.admin')
@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Data Mahasiswa RPL</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Data Mahasiswa RPL</li>
        </ol>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-12">


          <div class="card">
            <div class="card-body">
              <h5 class="card-title center" align="center">Data Mahasiswa RPL</h5>

              <!-- Default Table -->
              <div class="table-container">
                <table class="table-admin table-bordered">
                  <thead>
                    <tr>
                      <th class="admin-tabb" scope="col">No</th>
                      <th class="admin-tabb" scope="col">Nama</th>
                      <th class="admin-tabb" scope="col">Jurusan</th>
                      <!-- <th scope="col">Email</th>
                      <th scope="col">Username</th>
                      <th scope="col">Password</th> -->
                      <th class="admin-tabb" scope="col">Tempat Lahir</th>
                      <th class="admin-tabb" scope="col">Tanggal Lahir</th>
                      <th class="admin-tabb" scope="col">No.HP</th>
                      <th class="admin-tabb" scope="col">No.Whatsapp</th>
                      <th class="admin-tabb" scope="col">Kelamin</th>
                      <th class="alamat" scope="col">Alamat</th>
                      <th class="admin-tabb" scope="col">Kota</th>
                      <th class="admin-tabb" scope="col">Provinsi</th>
                      <th class="admin-tabb" scope="col">Kode Pos</th>
                      <th class="admin-tabb" scope="col">Jenjang</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users_camaba as $index => $user)
                      <tr>
                        <td class="admin-tabb">{{ $index + 1 }}</td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa)
                              {{ $user->calon_mahasiswa->nama }}
                          @else
                              Data tidak tersedia
                          @endif
                        </td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa && $user->calon_mahasiswa->jurusan)
                              {{ $user->calon_mahasiswa->jurusan->nama_jurusan }}
                          @else
                              
                          @endif
                      </td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa)
                              {{ $user->calon_mahasiswa->tempat_lahir }}
                          @else
                              
                          @endif
                        </td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa)
                              {{ $user->calon_mahasiswa->tanggal_lahir }}
                          @else
                              
                          @endif
                        </td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa)
                              {{ $user->calon_mahasiswa->no_hp }}
                          @else
                              
                          @endif
                        </td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa)
                              {{ $user->calon_mahasiswa->no_wa }}
                          @else
                              
                          @endif
                        </td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa)
                              {{ $user->calon_mahasiswa->kelamin }}
                          @else
                              
                          @endif
                        </td>
                        <td class="alamat">
                          @if($user->calon_mahasiswa)
                              {{ $user->calon_mahasiswa->alamat }}
                          @else
                              
                          @endif
                        </td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa)
                              {{ $user->calon_mahasiswa->kota }}
                          @else
                              
                          @endif
                        </td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa)
                              {{ $user->calon_mahasiswa->provinsi }}
                          @else
                              
                          @endif
                        </td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa)
                              {{ $user->calon_mahasiswa->kode_pos }}
                          @else
                              
                          @endif
                        </td>
                        <td class="admin-tabb">
                          @if($user->calon_mahasiswa && $user->calon_mahasiswa->jurusan)
                                    {{ $user->calon_mahasiswa->jurusan->jenjang }}
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
