@extends('layout.admin')
@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Atur Assessor Mahasiswa</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Atur Assessor Mahasiswa</li>
        </ol>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title center" align="center">Atur Assessor Mahasiswa</h5>

              <!-- Dropdown for selecting Jurusan -->
              <form class="row g-3" action="{{ route('kelola-assessor-mahasiswa') }}" method="GET">
                <div class="col-6 my-3">
                  <label for="jurusan" class="form-label">Pilih Jurusan</label>
                  <div>
                    <select name="jurusan_id" id="jurusan" class="form-select" required onchange="this.form.submit()">
                      @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ $jurusan_id == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama_jurusan }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </form>

              <!-- Menampilkan pesan kesalahan atau sukses -->
              @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif

              @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
              @endif

              

              <div class="container mt-5">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Program Studi</th>
                          <th>Assessor 1</th>
                          <th>Assessor 2</th>
                          <th>Assessor 3</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($calon_mahasiswa as $index => $camaba)
                      @if($camaba->jurusan_id == $jurusan_id)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $camaba->nama ?? '-'  }}</td>
                            <td>{{ $camaba->jurusan->nama_jurusan ?? '-'  }}</td>
                            <td>{{ $camaba->assessment->assessor1->nama ?? 'belum' }}</td>
                            <td>{{ $camaba->assessment->assessor2->nama ?? 'belum' }}</td>
                            <td>{{ $camaba->assessment->assessor3->nama ?? 'belum' }}</td>
                            <td>
                              <button class="btn btn-outline-primary" data-toggle="modal" data-target="#editModal" onclick="editData({{ $camaba->id }})">Edit</button>
                            </td>
                        </tr>
                      @endif
                    @endforeach  
                  </tbody>
              </table>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="editModalLabel">Edit Assessor</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form id="editForm" method="POST" action="{{ route("kelola-assessor-mahasiswa-add") }}">
                            @csrf
                            <input type="hidden" name="calon_mahasiswa_id" id="calonMahasiswaId">
                              <div class="form-group">
                                  <label for="assessor1_id">Assessor 1</label>
                                  <select class="form-select" id="assessor1_id" name="assessor1_id" required>
                                    @foreach($assessor as $assessor1)
                                        <option value="{{ $assessor1->id }}">{{ $assessor1->nama }}</option>
                                    @endforeach
                                  </select>
                              </div>
                              <div class="form-group">
                                  <label for="assessor2_id">Assessor 2</label>
                                  <select class="form-select" id="assessor2_id" name="assessor2_id" required>
                                    @foreach($assessor as $assessor2)
                                        <option value="{{ $assessor2->id }}">{{ $assessor2->nama }}</option>
                                    @endforeach
                                  </select>
                              </div>
                              <div class="form-group">
                                  <label for="assessor3_id">Assessor 3</label>
                                  <select class="form-select" id="assessor3_id" name="assessor3_id" required>
                                    @foreach($assessor as $assessor3)
                                        <option value="{{ $assessor3->id }}">{{ $assessor3->nama }}</option>
                                    @endforeach
                                  </select>
                              </div>
                              <button type="submit" class="btn btn-primary" onclick="saveChanges()">Save changes</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>

          <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
          <script>
            function editData(mahasiswaId) {
                document.getElementById('calonMahasiswaId').value = mahasiswaId;
                var myModal = new bootstrap.Modal(document.getElementById('editModal'));
                myModal.show();
            }
          </script>
          


            </div>
          </div>


        </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection
