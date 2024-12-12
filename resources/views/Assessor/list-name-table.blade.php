@extends('layout.assessor')
@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>List Ajuan Form</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">List Ajuan Form</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-12">


          <div class="card">
            <div class="card-body">
              <h5 class="card-title center" align="center">List Nama Mahasiswa</h5>

              <!-- Default Table -->
              <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Program Studi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($camaba as $index => $mahasiswa)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $mahasiswa->nama }}</td>
                            <td>{{ $mahasiswa->jurusan->nama_jurusan }}</td>
                            <td>
                                <a type="button" href="{{ route('detail-user', ['id' => $mahasiswa->id]) }}" class="bi-box-arrow-right fs-2"></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
              <!-- End Default Table Example -->

            </div>
          </div>

          
        </div>
      </div>
    </section>


  </main><!-- End #main -->
@endsection