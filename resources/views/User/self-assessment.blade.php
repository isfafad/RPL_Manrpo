@extends('layout.user')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Form Layouts</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="/self-assessment-table">Mata Kuliah</a></li>
                <li class="breadcrumb-item active">Self Assessment</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Pilihlah Mata Kuliah yang akan dikonversi</h5>

                        <form class="row g-3" action="{{ route('self-assessment') }}" method="GET">
                            <div class="col-6 my-3">
                                <label for="matkul" class="form-label">Mata Kuliah</label>
                                <div>
                                    <select name="matkul_id" id="matkul" class="form-select" required onchange="this.form.submit()">
                                        @foreach($matkul as $matkul)
                                            <option value="{{ $matkul->id }}" {{ $matkul_id == $matkul->id ? 'selected' : '' }}>{{ $matkul->nama_matkul }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        <h5 class="card-title text-center">Mata Kuliah yang akan diisi</h5>
                        <h6>Sub CPMK yang harus dipenuhi oleh mata kuliah tersebut</h6>

                        <form action="{{ route('add-self-assessment') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Capaian Pembelajaran Mata Kuliah</th>
                                        <th scope="col">Profisiensi Pengetahuan</th>
                                        <th scope="col">Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cpmks as $index => $cpmk)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $cpmk->penjelasan }}</td>
                                        <td>
                                            <select class="form-select" name="nilai[{{ $cpmk->id }}]" required onchange="toggleUploadFields(this, {{ $index + 1 }})">
                                                <option value="" disabled selected>Pilih Penilaian</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Tidak Pernah">Tidak Pernah</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal{{ $index + 1 }}">Upload Bukti</button>
                                        </td>

                                        <div class="modal fade" id="exampleModal{{ $index + 1 }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle{{ $index + 1 }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle{{ $index + 1 }}">Upload Bukti untuk CPMK</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="buktiNama{{ $index + 1 }}" class="form-label">Nama Bukti</label>
                                                            <input type="text" name="bukti[{{ $cpmk->id }}][nama]" class="form-control" id="buktiNama{{ $index + 1 }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jenisBukti{{ $index + 1 }}" class="form-label">Jenis Bukti</label>
                                                            <input type="text" name="bukti[{{ $cpmk->id }}][jenis_bukti]" class="form-control" id="jenisBukti{{ $index + 1 }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="file{{ $index + 1 }}" class="form-label">Upload Bukti</label>
                                                            <input type="file" name="bukti[{{ $cpmk->id }}][file]" class="form-control" id="file{{ $index + 1 }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<script>
    function toggleUploadFields(selectElement, index) {
        const selectedValue = selectElement.value;
        const modalId = '#exampleModal' + index;

        if (selectedValue === 'Tidak Pernah') {
            $(modalId).find('input').val(''); // Clear inputs
            $(modalId).find('input').prop('required', false); // Remove required attribute
        } else {
            $(modalId).find('input').prop('required', true); // Make inputs required again
        }
    }
</script>
@endsection
