@extends('layout.super_admin')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Form Layouts</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Kelola Assessor</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">

      <div class="col-lg-12">


        <div class="card">
          <div class="card-body">
            <h5 class="card-title center" align="center">List Mata Kuliah</h5>
            <button class="btn btn-primary mb-3 float-end" data-toggle="modal"
              data-target="#tambahModal">Tambah</button>

            <!-- Default Table -->
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th width="600">Mata Kuliah</th>
                  <th width="100">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($matkuls as $index => $matkul)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>
                        @if($matkul->nama_matkul)
                            {{ $matkul->nama_matkul }}
                        @else
                            Data tidak tersedia
                        @endif
                      </td>
                      <td><i type="button" class="bi-trash"></i><a type="button" href="/kelola-cpmk-table"
                        class="bi-box-arrow-in-right fs-2"> </a></></td>
                    </tr>
                @endforeach    
              </tbody>
            </table>
            <!-- End Default Table Example -->

            <!-- Modal -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Mata Kuliah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="tambahForm" action="{{ 'kelola-matkul-add-data' }}" method="POST">
                      @csrf
                      <div class="col-12 mb-3">
                        <label for="nama_matkul" class="form-label">Nama Matkul</label>
                        <input type="text" name="nama_matkul" class="form-control" id="nama_matkul" required>
                        <div class="invalid-feedback">Tolong masukkan matkul yang ingin anda tambahkan!</div>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="jurusan" class="form-label">Nama Matkul</label>
                        <select name="jurusan_id" id="jurusan" class="form-select" required>
                          @foreach($jurusan as $jurusan)
                              <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                          @endforeach
                        </select>
                        <div class="invalid-feedback">Tolong masukkan matkul yang ingin anda tambahkan!</div>
                      </div>
                      <button type="submit" class="btn btn-primary float-end me-3">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>


      </div>
    </div>
  </section>


</main><!-- End #main -->
@endsection