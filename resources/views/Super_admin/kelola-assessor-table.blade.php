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
              <h5 class="card-title center" align="center">List Nama Mahasiswa</h5>

              <!-- Default Table -->
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Program Studi</th>
                    <th scope="col">NPM</th>
                    <th scope="col">Assessor 1</th>
                    <th scope="col">Assessor 2</th>
                    <th scope="col">Assessor 3</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Muhammad Revanza</td>
                    <td>Informatika</td>
                    <td>21091011299</td>
                    <td>Bu Kartini</td>
                    <td>Pak Gede</td>
                    <td>Pak Firza</td>
                    <td><a type="button" href="/kelola-assessor-mahasiswa" class="bi-box-arrow-right fs-2"></></td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Isfa Fadil Muhammad</td>
                    <td>Informatika</td>
                    <td>21081010310</td>
                    <td>Bu Kartini</td>
                    <td>Pak Gede</td>
                    <td>Pak Firza</td>
                    <td><a type="button" class="bi-box-arrow-right fs-2"></></td>
                  <tr>
                    <th scope="row">3</th>
                    <td>Doding Laswadana</td>
                    <td>Informatika</td>
                    <td>21081010309</td>
                    <td>Bu Afina</td>
                    <td>Pak Pratama</td>
                    <td>Pak Firza</td>
                    <td><a type="button" class="bi-box-arrow-right fs-2"></></td>
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td>Rangga Wifiasmara</td>
                    <td>Informatika</td>
                    <td>21081010369</td>
                    <td>Bu Fetty</td>
                    <td>Pak Andreas</td>
                    <td>Pak Wahyu</td>
                    <td><a type="button" class="bi-box-arrow-right fs-2"></></td>
                  </tr>
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