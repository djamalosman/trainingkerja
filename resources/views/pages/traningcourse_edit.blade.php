@extends('../layouts.mainv2')

@section('headers')
<link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('/') }}plugins/summernote/summernote-bs4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />

<style>


.modal-body {
    max-height: 400px;
    max-width: 500px;
    overflow-y: auto;
}
@keyframes checkAnimation {
      0% { transform: scale(0); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }

    .modal-content {
      text-align: center;
      padding: 20px;
    }

    .check-icon {
      font-size: 5em;
      color: green;
      animation: checkAnimation 1s;
    }

    .error-icon {
    font-size: 5em;
    color: red;
    animation: checkAnimation 1s;
}

    .btn-ok {
      background-color: green;
      color: white;
    }
    .form-group {
    margin-bottom: 1rem; /* Menambahkan jarak bawah antar grup form */
  }
  .form-group label {
    display: block; /* Menampilkan label sebagai block untuk memastikan label berada di atas input */
    margin-bottom: .5rem; /* Menambahkan jarak antara label dan input */
  }
  .form-control {
    width: 100%; /* Pastikan input mengambil lebar penuh dari form group */
  }

  .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1050; /* Make sure it's above other elements */
}
.spinner-border.medium {
    width: 5rem; /* Atur lebar spinner */
    height: 5rem; /* Atur tinggi spinner */
    border-width: .55em; /* Atur ketebalan border spinner */
}

.spinner-border.custom-color {
    border-color: rgba(0, 0, 0, 0.1); /* Warna border spinner yang lebih terang */
    border-top-color: #e8f0fa; /* Warna spinner (warna utama) */
}
/* Efek zoom pada gambar thumbnail */
.img-thumbnail {
    transition: transform 0.3s ease; /* Animasi zoom */
    cursor: pointer; /* Kursor pointer untuk menunjukkan gambar dapat diklik */
}

.img-thumbnail:hover {
    transform: scale(1.6); /* Memperbesar gambar saat di-hover, gunakan nilai yang lebih tinggi untuk zoom lebih besar */
}
.modal-body img {
    max-width: 100%; /* Memastikan gambar tidak melebihi lebar modal */
    height: 100px!important; /* Menjaga rasio aspek gambar */
}
</style>
@section('content')
<div class="content-wrapper">
    <section class="content p-0">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-sm-6">
                    <h2> Edit Training / Cources</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#" class="text-danger">Pages</a></li>
                        <li class="breadcrumb-item active">{{explode('|',$title_page)[1]}}</li>
                    </ol>
                </div>
            </div>
        </div>
        
    </section>

    <section class="content p-3 col-md-8" >
        <div class="card card-default">
            <div class="card-header bg-red">
                <h3 class="card-title"><b><h4>Status Data <?php
                    if ($databyid->status ==1) {
                      echo "Publish</b></h4>";
                    } else {
                       echo" Pending</b></h4>";
                    }
                    
                    
                    ?></h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
                <form  enctype="multipart/form-data" id="training-form">
                    
                    <input type="hidden" name="id_content" value="{{ base64_encode($content) }}">
                    <input type="hidden" name="iddtl" id="iddtl" value="{{$iddtl }}">
            
                    <div class="row">
                        <!-- Left Card -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label for="titleEn">Nama Traning</label>
                                        <input type="text" name="traning_name" value="{{$databyid->traning_name}}" class="form-control" id="title" placeholder="">
                                        <small id="title_id_error" class="title_id_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Category</label>
                                        <select class="form-control" name="category" id="category">
                                            <option value="">Pilih</option>
                                            @foreach($liscategory as $value)
                                                <option value="{{ $value->id }}" {{ $databyid->id_m_traning_course == $value->id ? 'selected' : '' }}>
                                                    {{ $value->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Jenis Sertifikasi</label>
                                        <select class="form-control" name="cetificate_type" id="cetificate_type" onclick="saveSelectedValue()">
                                            <option value="">Pilih</option>
                                            @foreach($listsertifikasi as $value)
                                            <option value="{{ $value->id }}" {{ $databyid->id_m_sertifikasi == $value->id ? 'selected' : '' }}>
                                                {{ $value->nama }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <small id="title_eng_error"  class="title_eng_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    <div class="form-group">
                                            <label for="titleEn">Durasi Traning</label>
                                            <div class="input-group mb-1">
                                                <input type="number" class="form-control" name="training_duration"  value="{{$databyid->training_duration}}" id="training_duration" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Hari</span>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Type Training</label>
                                        <input type="text" name="typeonlineoffile" class="form-control" id="typeonlineoffile" value="{{$databyid->typeonlineoffile}}" placeholder="">
                                        <small id="title_id_error" class="title_id_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Lokasi Training</label>
                                        <input type="text" name="location" class="form-control" id="location" value="{{$databyid->location}}" placeholder="">
                                        <small id="title_id_error" class="title_id_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Link Pendaftaran</label>
                                        <input type="text" name="link_pendaftaran" class="form-control"  value="{{$databyid->link_pendaftaran}}" id="link_pendaftaran" placeholder=" Masukan Link Google Form / Ms Form">
                                        <small id="title_id_error" class="title_id_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="salarytraining">Biaya Pendaftaran</label>
                                        <input type="text" name="salarytraining" class="form-control" value="{{$databyid->salarytraining}}" id="salarytraining" placeholder="Rp 0">
                                        <small id="title_id_error" class="title_id_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right Card -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label for="titleEn">Jadwal Pendaftaran</label>
                                        <input type="text" name="registration_schedule" class="form-control" value="{{$registration_schedule}}" id="registration_schedule" placeholder="">
                                        <small id="title_id_error" class="title_id_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Jadwal Penutupan</label>
                                        <input type="text" name="closing_schedule" class="form-control" id="closing_schedule" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Jadwal Mulai</label>
                                        <input type="text" name="startdate" class="form-control" value="{{$startdate}}" id="startdate" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Jadwal Selesai</label>
                                        <input type="type" name="enddate" class="form-control" value="{{$enddate}}" id="enddate" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="picture">Photo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="item_file"  accept="image/*" multiple class="custom-file-input" id="item_files">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Persyaratan</label>
                                        <textarea class="form-control desc" name="requirements" id="requirements" rows="4" cols="50">{{$databyid->requirements}}</textarea>
                                        <small id="description_error" class="description_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body"> 
                                    <div class="form-group">
                                        <label for="titleEn">Materi Training</label>
                                        <textarea class="form-control desc" name="training_material" id="training_material" rows="4" cols="50">{{$databyid->training_material}}</textarea>
                                        <small id="description_error" class="description_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Fasilitas Training</label>
                                        <textarea class="form-control desc" name="facility" id="facility" rows="4" cols="50">{{$databyid->facility}}</textarea>
                                        <small id="description_error" class="description_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="d-flex justify-content-center">
                        <button type="button" id="preview-btn" class="btn btn-primary start">Preview</button> &nbsp;&nbsp;
                        <button type="button" id="pending-btn" class="btn btn-primary start">Pending</button> &nbsp;&nbsp;
                        <button type="button" id="publish-btn" class="btn btn-primary start">Publish</button>
                    </div>
                </form>
            </div>
        </div>
       <!-- Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewModalLabel">Preview</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Content will be inserted here -->
                        <div class="card">
                            <div class="card-body">
                                <div id="modal-content">
                                    
                                    <!-- Dynamically filled by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <i class="fas fa-check-circle check-icon"></i>
                  <h4 class="mt-4">Oh Yeah!</h4>
                  <p>Data berhasil disimpan dengan status.</p>
                </div>
                <div class="modal-footer justify-content-center">
                  <button type="button" class="btn btn-ok" data-dismiss="modal">Ok</button>
                </div>
              </div>
            </div>
          </div>
    </section>
</div>

@endsection

@section('script')
<script src="{{ asset('/') }}dist/js/main.js"></script>
<script src="{{ asset('/') }}plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('/') }}plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="{{ asset('/') }}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('/') }}plugins/summernote/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function() {
  const salaryInput = document.getElementById('salarytraining');

  // Function to format number as Rupiah
  function formatRupiah(value) {
    let number_string = value.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        remainder = split[0].length % 3,
        rupiah = split[0].substr(0, remainder),
        thousands = split[0].substr(remainder).match(/\d{3}/g);
    
    // Add thousands separator
    if (thousands) {
      separator = remainder ? '.' : '';
      rupiah += separator + thousands.join('.');
    }

    // Add the currency symbol
    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return 'Rp ' + rupiah;
  }

  salaryInput.addEventListener('input', function(e) {
    this.value = formatRupiah(this.value);
  });
});

$(document).ready(function() {
    $('#preview-btn').click(function() {
        // Fungsi untuk mengubah format tanggal MM/DD/YYYY ke YYYY-MM-DD
        function formatDate(inputDate) {
          if (!inputDate) return null; // Jika input kosong, kembalikan null
          const [month, day, year] = inputDate.split('/');
          return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        }
        function stripHtmlTags(text) {
            return text.replace(/<\/?[^>]+>/gi, ''); // Regex untuk menghapus tag HTML
        }
        // Ambil nilai dari input
        var formData = {
          traning_name: $('#title').val(),
          category: $('#category').val(),
          cetificate_type: $('#cetificate_type').val(),
          training_duration: $('#training_duration').val(),
          requirements: $('#requirements').val(),
          registration_schedule: formatDate($('#registration_schedule').val()),
          startdate: formatDate($('#startdate').val()),
          enddate: formatDate($('#enddate').val()),
          salarytraining: $('#salarytraining').val(),
          training_material: $('#training_material').val(),
          facility: $('#facility').val(),
          typeonlineoffile: $('#typeonlineoffile').val(),
          location: $('#location').val(),
          link_pendaftaran: $('#link_pendaftaran').val(),
          iddtl: $('#iddtl').val(),
          status: 3
        };
 
        // Tampilkan data di modal
        $('#modal-content').html(`
             <input type="hidden" class="form-control" value="${formData.iddtl}" readonly>
            <div class="form-group row">
                <label>Nama Traning</label>
                <input type="text" class="form-control" value="${formData.traning_name}" readonly>
            </div>
            <div class="form-group row">
            <label>Category</label>
            <select class="form-control" readonly>
                <option value="${formData.category}" selected>${$('#category option:selected').text()}</option>
            </select>
            </div>
            <div class="form-group row">
            <label>Jenis Sertifikasi</label>
            <select class="form-control" readonly>
                <option value="${formData.cetificate_type}" selected>${$('#cetificate_type option:selected').text()}</option>
            </select>
            </div>
            <div class="form-group row">
            <label>Durasi Traning</label>
            <input type="text" class="form-control" value="${formData.training_duration}" readonly>
            </div>
            
            <div class="form-group row">
            <label>Jadwal Pendaftaran Training</label>
            <input type="text" class="form-control" value="${formData.registration_schedule}" readonly>
            </div>
            <div class="form-group row">
            <label>Jadwal Mulai Training</label>
            <input type="text" class="form-control" value="${formData.startdate}" readonly>
            </div>
            <div class="form-group row">
            <label>Jadwal Selesai Training</label>
            <input type="text" class="form-control" value="${formData.enddate}" readonly>
            </div>
            <div class="form-group row">
            <label>Salary Training</label>
            <input type="text" class="form-control" value="${formData.salarytraining}" readonly>
            </div>
            
            <div class="form-group row">
            <label>Type Training</label>
            <input type="text" class="form-control" value="${formData.typeonlineoffile}" readonly>
            </div>
            <div class="form-group row">
            <label>Lokasi Training</label>
            <input type="text" class="form-control" value="${formData.location}" readonly>
            </div>
            <div class="form-group row">
            <label>Link Pendaftaran</label>
            <input type="text" class="form-control" value="${formData.link_pendaftaran}" readonly>
            </div>
            <div class="form-group row">
            <label>Persyaratan</label>
            <textarea class="form-control" rows="4" readonly>${stripHtmlTags(formData.requirements)}</textarea>
            </div>
            <div class="form-group row">
            <label>Materi Training</label>
            <textarea class="form-control" rows="4" readonly>${stripHtmlTags(formData.training_material)}</textarea>
            </div>
            <div class="form-group row">
            <label>Fasilitas Training</label>
            <textarea class="form-control" rows="4" readonly>${stripHtmlTags(formData.facility)}</textarea>
            </div>
        `);

        // Tampilkan modal
        $('#previewModal').modal('show');

        // Periksa apakah elemen file input ada dan bisa diakses
        var fileInput = document.getElementById('item_files');
        if (fileInput) {
          var files = fileInput.files;
          if (files.length > 0) {
            var fileReaders = [];
            var imageUrls = [];

            // Function to handle when all files are loaded
            function handleFilesLoaded() {
              var imagesHtml = imageUrls.map((url, index) => `
               <div class="form-group row">
                                <label for="picture">Photo ${index + 1}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="form-group row">
                                
                                <img src="${url}" alt="Preview Image ${index + 1}" class="img-thumbnail simulasi-gambar-picture-visi-misi" width="140px">
                                        <div class="input-group">
                                            <div class="custom-file">
                                               
                                            </div>
                                        </div>
                                
                            </div>
              `).join('');

              $('#modal-content').append(imagesHtml);
            }

            // Read all files
            for (var i = 0; i < files.length; i++) {
              (function(file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                  imageUrls.push(e.target.result);

                  // Check if all files are processed
                  if (imageUrls.length === files.length) {
                    handleFilesLoaded();
                  }
                };

                reader.readAsDataURL(file);
              })(files[i]);
            }
          }
        }
      });



    // Handle Pending button click
    $('#pending-btn').click(function() {
        submitFormWithStatus(2); // Status 2 for Pending
    });

    // Handle Publish button click
    $('#publish-btn').click(function() {
        submitFormWithStatus(1); // Status 1 for Publish
    });

    function submitFormWithStatus(status) {
        var formData = $('#training-form').serialize();
        formData += '&status=' + status; // Append status to form data
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        $.ajax({
            url: '/update-course-endpoint', // Replace with your endpoint
            type: 'POST',
            data: formData,
            success: function(response) {
                // Tampilkan modal sukses
                $('#successModal').modal('show');

                // Tutup modal secara otomatis setelah 3 detik (3000 ms)
                setTimeout(function() {
                    $('#successModal').modal('hide');
                    location.reload(); // Refresh halaman setelah menutup modal
                }, 2000);
                // Optionally, you can clear the form or close the modal
                $('#previewModal').modal('hide');
                $('#training-form')[0].reset(); // Reset form if needed
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

});




    $("#registration_schedule").datepicker({
        // format: "dd-mm-yyyy",
        startDate: new Date(),
    });
    $("#startdate").datepicker({
        // format: "dd-mm-yyyy",
        startDate: new Date(),
    });
    $("#enddate").datepicker({
        // format: "dd-mm-yyyy",
        startDate: new Date(),
    });
    $(".desc").summernote({
        height: 75,
    });
    $('input[type="file"]').change(function(e) {
        console.log('Picture Changed');
        var files = [];
        for (var i = 0; i < $(this)[0].files.length; i++) {
            files.push($(this)[0].files[i].name);
        }
        const [file] = $(this)[0].files;
        if (file) {
            $(".simulasi-gambar-" + this.id).attr("src", URL.createObjectURL(file));
        }
        $(this).next(".custom-file-label").html(files.join(", "));
    });
    $(function() {
        $('#side-list-traning-course').DataTable({
            "paging": true,
            "pageLength": 5,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
    function deletePrompt(id) {
        var url = "{{ route('pages-list-detail-delete',':id') }}";
        url = url.replace(":id", id);

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        });

        Swal.fire({
            title: "Delete data?",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: "#d33",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                $.ajax({
                    url: url,
                    type: "GET",
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data["status"] == "success") {
                            Toast.fire({
                                icon: "success",
                                title: data["message"],
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    location.reload();
                                }
                            });
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: data["message"],
                            });
                        }
                    },
                    error: function(reject) {
                        Toast.fire({
                            icon: "error",
                            title: "Something went wrong",
                        });
                    },
                });
            }
        });
    }

    function parsingDataToModal(id) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        });

        var url = "{{ route('edit-traningcourse-detail',':id') }}";
        url = url.replace(":id", id);
        $.ajax({
            url: url,
            type: "GET",
            processData: false,
            contentType: false,
            success: function(data) {
                data = JSON.parse(data);
                if (data["status"] == "success") {
                    $("#edit-data-list-item").html(data["output"]);
                    $("#edit-item").modal("toggle");
                } else {
                    Toast.fire({
                        icon: "error",
                        title: data["message"],
                    });
                }
            },
            error: function(reject) {
                Toast.fire({
                    icon: "error",
                    title: "Something went wrong",
                });
            },
        });
    }
</script>
@endsection