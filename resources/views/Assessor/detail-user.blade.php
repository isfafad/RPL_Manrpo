@extends('layout.assessor')
@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Data Calon Mahasiswa</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active"><a href="/list-name-table">Ajuan Form</a></li>
        <li class="breadcrumb-item active"><a href="/detail-user">Data Calon Mahasiswa</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
      <div class="container mt-2">
          
        <h2>Data Diri Mahasiswa</h2>
        <div class="card">
            <div class="ijazah-overview-assessor mx-4 my-3">
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Nama</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->nama ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Prodi</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->jurusan->nama_jurusan ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Alamat</div>
                  <div class="col-lg-9 col-md-8">{{   $camaba->alamat ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->user->email ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">No Wa</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->no_wa ?? '-'  }}</div>
                </div>
            </div>
        </div>
        
        
        <h2>Data Ijazah</h2>
        <div class="card">
            <div class="ijazah-overview-assessor mx-4 my-3">
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Institusi Pendidikan</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->ijazah->institusi_pendidikan ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Jenjang</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->ijazah->jenjang ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Provinsi</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->ijazah->provinsi ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Kota</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->ijazah->kota ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Negara</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->ijazah->negara ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Fakultas</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->ijazah->fakultas ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Jurusan</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->ijazah->jurusan ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Nilai/IPK</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->ijazah->ipk_nilai ?? '-'  }}</div>
                </div>
        
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 label">Tahun Lulus</div>
                  <div class="col-lg-9 col-md-8">{{  $camaba->ijazah->tahun_lulus ?? '-'  }}</div>
                </div>
        
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Bukti File</div>
                        <div class="col-lg-9 col-md-8">
                          @if($camaba->ijazah && $camaba->ijazah->file)
                              <a href="{{ asset('storage/ijazah/' . $camaba->ijazah->file) }}" 
                                class="btn btn-primary btn-sm" 
                                download>
                                  <i class="bi bi-download"></i> Download File
                              </a>
                          @else
                              <span class="text-muted">File tidak tersedia</span>
                          @endif
                        </div>
                </div>
            </div>
        </div>
          
        <div class="card">
            <div class="card-body">
                <h4 class="mt-4">Mata Kuliah yang akan dikonversi</h4>
                {{-- <ol class="list-group list-group-numbered">
                    @forelse ($matkul as $mk)
                      <li class="list-group-item d-flex justify-content-between align-items-start">
                          <div class="ms-2 me-auto">
                              <div class="fw-bold">{{ $mk->nama_matkul ?? '-' }}</div>
                              <span class="badge {{ $mk->status == 'Lolos' ? 'bg-success' : ($mk->status ? 'bg-danger' : 'bg-secondary') }}">
                                  {{ $mk->status ?? 'Belum dinilai' }}
                              </span>
                          </div>
                          <span class="bg-light {{ $mk->nilai ? 'text-success' : 'text-secondary' }} border {{ $mk->nilai ? 'border-success' : 'border-secondary' }} rounded p-2 mr-3">
                              {{ $mk->nilai ?? 'Belum ada nilai' }}
                          </span>
                          <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('form-user', ['matkul_id' => $mk->matkul_id]) }}'">
                              Lihat Detail
                          </button>
                      </li>
                      @empty
                          <div class="list-group-item">
                              Tidak ada mata kuliah yang akan dikonversi
                          </div>
                      @endforelse --}}
                </div>
        </div>
      </div>
          
      </div>
      </div>
    </section>

  </main><!-- End #main -->

@endsection