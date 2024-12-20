@extends('layout.admin')
@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Tambah Akun Mahasiswa RPL</h1>
      <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item">Akun Mahasiswa RPL</li>
            <li class="breadcrumb-item active">Form Tambah Akun Mahasiswa RPL</li>
        </ol>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-12">


          <div class="card">
            <div class="card-body">
              <h5 class="card-title center" align="center"><b>Form Tambah Akun Mahasiswa RPL</b></h5>

              <!-- Vertical Form -->
              <form class="row g-3" method="POST" action="{{ route('account-user-add-data') }}">
                @csrf
                    <div class="col-6">
                      <label for="yourName" class="form-label">Nama</label>
                      <input type="text" name="nama" class="form-control" id="nama" required>
                      <div class="invalid-feedback">Mohon, Masukkan Nama Anda!</div>
                    </div>

                    <div class="col-6">
                      <label for="yourEmail" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="email" required>
                      <div class="invalid-feedback">Mohon, Masukkan Nama Anda!</div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" id="username" required>
                        <div class="invalid-feedback">Tolong masukkan Username Anda!</div>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Tolong masukkan Password Anda!</div>
                    </div>

                    <!-- <div class="col-6">
                      <label for="yourName" class="form-label">Tempat Lahir</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Mohon, Masukkan Tempat Lahir Anda!</div>
                    </div>

                    <div class="col-6">
                      <label for="inputDate" class="form-label">Tanggal Lahir</label>
                      <input type="date" class="form-control">
                      <div class="invalid-feedback">Mohon, Masukkan Tanggal Lahir Anda!</div>
                    </div>

                    <div class="col-6">
                      <label for="yourEmail" class="form-label">No Hp</label>
                      <input type="tel" name="nohp" class="form-control" id="nohp" required>
                      <div class="invalid-feedback">Mohon, Masukkan Nomor HP Anda!</div>
                    </div> -->

                    <div class="col-6">
                        <label for="jurusan_id" class="form-label">Jurusan</label>
                        <select name="jurusan_id" id="jurusan_id" class="form-select" required>
                            @foreach($jurusan as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Mohon, Masukkan Jurusan Anda!</div>
                    </div>

                    <!-- <div class="col-6">
                      <label for="Kelamin" class="form-label">Kelamin</label>
                        <select class="form-select" aria-label="Default select example">
                          <option selected value="1">Laki-laki</option>
                          <option value="2">Perempuan</option>
                        </select>
                      <div class="invalid-feedback">Mohon, Pilih Kelamin Anda!</div>
                    </div>

                    <div class="col-6">
                      <label for="yourName" class="form-label">Alamat</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Mohon, Masukkan Alamat Anda!</div>
                    </div>

                    <div class="col-6">
                      <label for="yourName" class="form-label">Kota</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Mohon, Masukkan Kota Anda!</div>
                    </div>

                    <div class="col-6">
                      <label for="yourName" class="form-label">Provinsi</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Mohon, Masukkan Provinsi Anda!</div>
                    </div>

                    <div class="col-6">
                      <label for="yourEmail" class="form-label">Kode Pos</label>
                      <input type="kodepos" name="nowa" class="form-control" id="kodepos" required>
                      <div class="invalid-feedback">Mohon, Masukkan Nomor Kode Pos Anda!</div>
                    </div>

                    <div class="col-6">
                      <label for="Jenjang" class="form-label">Jenjang</label>
                        <select class="form-select" aria-label="Default select example">
                          <option selected value="1">S1</option>
                          <option value="2">S2</option>
                        </select>
                      <div class="invalid-feedback">Mohon, Pilih Jenjang Anda!</div>
                    </div> -->

                <!-- Modal -->
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Peringatan!</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          Apakah Kamu Yakin ingin mengirim?
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                      </div>
                  </div>
                </div>

                <div align="Right">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>



        </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection
