@extends('layout.super_admin')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Form Layouts</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Kelola Assessor</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">

      <div class="col-lg-12">


        <div class="card">
          <div class="card-body">
            <h5 class="card-title center" align="center">Kelola CPMK Pemrograman Web</h5>
            <button class="btn btn-primary mb-3 float-end" data-toggle="modal"
              data-target="#tambahModal">Tambah</button>

            <!-- Default Table -->
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th width="600">CPMK</th>
                  <th width="50">Aksi</th>
                </tr>
              </thead>
              <tbody>
                {{-- @foreach($cpmks as $index => $cmpk)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td></td>
                    </tr>
                @endforeach --}}
                <tr>
                  <th scope="row"></th>
                  <td></td>
                  <td><a type="button" class="bi-trash fs-2"></>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- End Default Table Example -->

            <!-- Modal -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah CPMK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="tambahForm" method="POST" action="">
                      <div class="col-12 mb-3">
                        <label for="matkul" class="form-label">Penjelasan CPMK</label>
                        <input type="text" name="matkul" class="form-control" id="matkul" required>
                        <div class="invalid-feedback">Tolong masukkan matkul yang ingin anda tambahkan!</div>
                      </div>
                      <button type="button" class="btn btn-primary float-end me-3"
                        onclick="saveChanges()">Submit</button>
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