@extends('layout.user')
@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Lihat Nilai</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Lihat Nilai</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-12">


          <div class="card">
            <div class="card-body">
              <h5 class="card-title center" align="center">Mata Kuliah Konversi</h5>
              

              <!-- Default Table -->
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Mata Kuliah</th>
                    <th scope="col">Status</th>
                    <th scope="col">Nilai</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($matkulScores as $index => $score)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $score['matkul']->nama_matkul ?? '-' }}</td>
                      <td>
                        @if($score['is_complete'])
                            <span class="badge {{ $score['status'] == 'Lolos' ? 'bg-success' : ($score['status'] == 'Gagal' ? 'bg-danger' : 'bg-warning') }}">
                                {{ $score['status'] }}
                            </span>
                        @else
                            <span class="badge bg-warning">Belum Ditentukan</span>
                        @endif
                      </td>
                      <td>{{ $score['nilai'] }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center">Belum ada data nilai</td>
                    </tr>
                  @endforelse
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
