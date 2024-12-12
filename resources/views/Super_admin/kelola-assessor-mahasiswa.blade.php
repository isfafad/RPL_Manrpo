@extends('layout.super_admin')
@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Tambah Akun</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Tambah Akun</li>
          <li class="breadcrumb-item active">User</li>
        </ol>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-12">


          <div class="card">
            <div class="card-body">
              <h5 class="card-title center" align="center">Atur Assessor Mahasiswa</h5>

              <div class="container mt-5">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Program Studi</th>
                          <th>NPM</th>
                          <th>Assessor 1</th>
                          <th>Assessor 2</th>
                          <th>Assessor 3</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>1</td>
                          <td>Muhammad Revanza</td>
                          <td>Informatika</td>
                          <td>21091011299</td>
                          <td>Bu Kartini</td>
                          <td>Pak Gede</td>
                          <td>Pak Firza</td>
                          <td><button class="btn btn-outline-primary" data-toggle="modal" data-target="#editModal" onclick="editData(1)">Edit</button></td>
                      </tr>
                      <tr>
                          <td>2</td>
                          <td>Isfa Fadil Muhammad</td>
                          <td>Informatika</td>
                          <td>21081010310</td>
                          <td>Bu Kartini</td>
                          <td>Pak Gede</td>
                          <td>Pak Firza</td>
                          <td><button class="btn btn-outline-primary" data-toggle="modal" data-target="#editModal" onclick="editData(2)">Edit</button></td>
                      </tr>
                      <tr>
                          <td>3</td>
                          <td>Doding Laswadana</td>
                          <td>Informatika</td>
                          <td>21081010309</td>
                          <td>Bu Afina</td>
                          <td>Pak Pratama</td>
                          <td>Pak Firza</td>
                          <td><button class="btn btn-outline-primary" data-toggle="modal" data-target="#editModal" onclick="editData(3)">Edit</button></td>
                      </tr>
                      <tr>
                          <td>4</td>
                          <td>Rangga Wifiasmara</td>
                          <td>Informatika</td>
                          <td>21081010369</td>
                          <td>Bu Fetty</td>
                          <td>Pak Andreas</td>
                          <td>Pak Wahyu</td>
                          <td><button class="btn btn-outline-primary" data-toggle="modal" data-target="#editModal" onclick="editData(4)">Edit</button></td>
                      </tr>
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
                          <form id="editForm">
                              <div class="form-group">
                                  <label for="assessor1">Assessor 1</label>
                                  <select class="form-control" id="assessor1" name="assessor1"></select>
                              </div>
                              <div class="form-group">
                                  <label for="assessor2">Assessor 2</label>
                                  <select class="form-control" id="assessor2" name="assessor2"></select>
                              </div>
                              <div class="form-group">
                                  <label for="assessor3">Assessor 3</label>
                                  <select class="form-control" id="assessor3" name="assessor3"></select>
                              </div>
                              <button type="button" class="btn btn-primary" onclick="saveChanges()">Save changes</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>

          <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
          <script>
              // Placeholder for the list of assessors
              var assessors = [
                  { id: 1, name: 'Bu Kartini' },
                  { id: 2, name: 'Pak Gede' },
                  { id: 3, name: 'Pak Firza' },
                  { id: 4, name: 'Bu Afina' },
                  { id: 5, name: 'Pak Pratama' },
                  { id: 6, name: 'Bu Fetty' },
                  { id: 7, name: 'Pak Andreas' },
                  { id: 8, name: 'Pak Wahyu' }
              ];

              function fillDropdowns() {
                  var assessor1 = $('#assessor1');
                  var assessor2 = $('#assessor2');
                  var assessor3 = $('#assessor3');

                  assessor1.empty();
                  assessor2.empty();
                  assessor3.empty();

                  assessors.forEach(function(assessor) {
                      assessor1.append('<option value="' + assessor.id + '">' + assessor.name + '</option>');
                      assessor2.append('<option value="' + assessor.id + '">' + assessor.name + '</option>');
                      assessor3.append('<option value="' + assessor.id + '">' + assessor.name + '</option>');
                  });
              }

              function editData(id) {
                  fillDropdowns();
                  if (id === 1) {
                      $('#assessor1').val(1);
                      $('#assessor2').val(2);
                      $('#assessor3').val(3);
                  } else if (id === 2) {
                      $('#assessor1').val(1);
                      $('#assessor2').val(2);
                      $('#assessor3').val(3);
                  } else if (id === 3) {
                      $('#assessor1').val(4);
                      $('#assessor2').val(5);
                      $('#assessor3').val(3);
                  } else if (id === 4) {
                      $('#assessor1').val(6);
                      $('#assessor2').val(7);
                      $('#assessor3').val(8);
                  }
              }

              function saveChanges() {
                  // Implement saving changes
                  $('#editModal').modal('hide');
              }
          </script>


            </div>
          </div>


        </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection
