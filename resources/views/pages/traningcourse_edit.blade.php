@extends('../layouts.mainv2')

@section('headers')
<link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('/') }}plugins/summernote/summernote-bs4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<style>
  
  .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            text-align: right;
        }
        .btn-custom {
            margin-top: 25px;
        }
        .btn-add {
            margin-top: 0;
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
.new-input-group {
    margin-top: 10px; /* Adjust the margin as needed */
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
</style>
@section('content')

<div class="content-wrapper">
    <section class="content p-0">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-sm-6">
                    <h2> Update Training / Cources</h2>
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

    <section class="content p-3 col-md-7" >
        <div class="card card-default">
            <div class="card-header bg-red">
                <h3 class="card-title">Update Training / Cources</h3>

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
              
                    <input type="hidden" name="id_content" value="{{ base64_encode($content) }}">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <form id="trainingForm" enctype="multipart/form-data">
                                <input type="hidden" name="iddtl" value="{{ $iddtl }}">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Nama Training -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control" readonly value="Nama Training">
                                            <div class="col-md-9">  
                                                <input type="text" class="form-control" id="Nama Training" value="{{ $databyid->traning_name }}" name="nama_training">
                                            </div>
                                        </div>
                                        <!-- Category -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control" readonly value="Category">
                                            <div class="col-md-5">
                                                <select class="form-control" id="Category" name="category">
                                                    <option value="">Pilih</option>
                                                    @foreach($liscategory as $value)
                                                            <option value="{{ $value->id }}" {{ $databyid->id_m_category_training_course == $value->id ? 'selected' : '' }}>
                                                            {{ $value->nama }}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Jenis Sertifikasi -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control" readonly value="Jenis Sertifikasi">
                                            <div class="col-md-5">
                                                <select class="form-control" id="Jenis Sertifikasi" name="jenis_sertifikasi">
                                                    <option value="">Pilih</option>
                                                    @foreach($listsertifikasi as $value)
                                                        <option value="{{ $value->id }}" {{ $databyid->id_m_jenis_sertifikasi_training_course == $value->id ? 'selected' : '' }}>
                                                        {{ $value->nama }}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Durasi Training -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control" readonly value="Durasi Training">
                                            <div class="col-md-5">
                                                
                                                <div class="input-group-append">
                                                    <input type="number" class="form-control" value="{{ $databyid->training_duration }}" id="Durasi Training" name="training_duration"   placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2"><span class="input-group-text" id="basic-addon2">Hari</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Persyaratan -->
                                        <div class="form-group row">
                                            <input type="text" class="col-md-3 form-control" readonly value="Persyaratan">
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="Persyaratan" placeholder="Ketik Manual" name="persyaratan[]">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary btn-add" onclick="addInput(this)">+</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        @if (Count($listpersyaratan) > 0)
                                            @foreach ($listpersyaratan as $index => $datapersyaratan)
                                                <div class="form-group row">
                                                    <input type="text" class="col-md-3 form-control" readonly value="Persyaratan {{ $index + 1 }}">
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="Persyaratan {{ $index + 1 }}" value="{{ $datapersyaratan->nama }}" placeholder="Ketik Manual" name="persyaratanDb[]" data-idpersyaratan="{{ $datapersyaratan->id }}">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-danger btn-remove" onclick="removeDataPersyaratan(this)">-</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            
                                        @endif
                                        
                                        <!-- Jadwal Training -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control"  readonly value="Jadwal Training">
                                            <div class="col-md-2">
                                                
                                                <input type="" readonly class="form-control" style="background-color: yellow" placeholder="Mulai">
                                            </div>
                                            <div class="col-md-7">
                                                <div class="row">
                                                    <div class="col">
                                                        <select class="form-control" id="Jadwal Training Muali: Tanggal" name="jadwal_mulai_tanggal">
                                                            <option>Tanggal</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-control" id="Jadwal Training Muali: Bulan" name="jadwal_mulai_bulan">
                                                            <option>Bulan</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-control"  id="Jadwal Training Muali: Tahun" name="jadwal_mulai_tahun">
                                                            <option>Tahun</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2 offset-md-3">
                                                <input type="text" class="form-control" style="background-color: yellow" placeholder="Selesai" >
                                            </div>
                                            <div class="col-md-7">
                                                <div class="row">
                                                    <div class="col">
                                                        <select class="form-control" id="Jadwal Training Selesai: Tanggal" name="jadwal_selesai_tanggal">
                                                            <option>Tanggal</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-control" id="Jadwal Training Selesai: Bulan" name="jadwal_selesai_bulan">
                                                            <option>Bulan</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <select class="form-control" id="Jadwal Training Selesai: Tahun" name="jadwal_selesai_tahun">
                                                            <option>Tahun</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Materi Training -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control" readonly value="Materi Training">
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="Materi Training" placeholder="XXXX" name="materi_training[]">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary btn-add" onclick="addInput(this)">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if (Count($listmateri) > 0)
                                            @foreach ($listmateri as $index => $datamateri)
                                                <div class="form-group row">
                                                    <input type="text" class="col-md-3 form-control" readonly value="Materi Training {{ $index + 1 }}">
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="Materi Training {{ $index + 1 }}" value="{{ $datamateri->nama }}" placeholder="Ketik Manual" name="materi_trainingDb[]" data-idmateritraining="{{ $datamateri->id }}">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-danger btn-remove" onclick="removeDataMateriTraining(this)">-</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            
                                        @endif

                                        <!-- Fasilitas -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control" readonly value="Fasilitas">
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="Fasilitas" placeholder="XXXX" name="fasilitas[]">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary btn-add" onclick="addInput(this)">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if (Count($listmateri) > 0)
                                            @foreach ($listfasilitas as $index => $datfasilitas)
                                                <div class="form-group row">
                                                    <input type="text" class="col-md-3 form-control" readonly value="Fasilitas {{ $index + 1 }}">
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="Fasilitas {{ $index + 1 }}" value="{{ $datfasilitas->nama }}" placeholder="Ketik Manual" name="fasilitasDb[]" data-idfasilitas="{{ $datfasilitas->id }}">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-danger btn-remove" onclick="removeDataFasilitas(this)">-</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            
                                        @endif
                                        <!-- Type -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control" readonly value="Type">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" id="Type"  value="{{ $databyid->typeonlineoffile }}"  placeholder="Online / Offline" name="type">
                                            </div>
                                        </div>
                                        <!-- Lokasi -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control" readonly value="Lokasi">
                                            <div class="col-md-5">
                                                <select class="form-control" id="Lokasi" name="lokasi">
                                                    <option>Pilih Provinsi</option>
                                                    @foreach($listprovinsi as $value)
                                                        <option value="{{ $value->id }}" {{ $databyid->id_provinsi == $value->id ? 'selected' : '' }}>
                                                    {{ $value->nama }}
                                                     @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Photo -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control" readonly value="Photo">
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <input type="file" class="form-control" id="Photo" name="photo[]">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary btn-add" onclick="addInput(this)">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if (Count($listmateri) > 0)
                                            @foreach ($listfiles as $index => $datphoto)
                                                <div class="form-group row">
                                                    <input type="text" class="col-md-3 form-control" readonly value="Photo {{ $index + 1 }}">
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" readonly id="Photo {{ $index + 1 }}" value="{{ $datphoto->nama }}" name="photoData[]" data-iddphoto="{{ $datphoto->id }}">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-danger btn-remove" onclick="removeDataPhoto(this)">-</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            
                                        @endif
                                        <!-- Link Pendaftaran -->
                                        <div class="form-group row">
                                            <input type="text"class="col-md-3 form-control" readonly value="Link Pendaftaran">
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{ $databyid->link_pendaftaran }}" id="Link Pendaftaran" placeholder="Link Google Form / Ms Form" name="link_pendaftaran">
                                            </div>
                                        </div>
                                        <!-- Buttons -->
                                        <div class="form-group row">
                                            <div class="col-md-6 offset-md-3">
                                                <button type="button" class="btn btn-warning" onclick="previewForm()">Preview</button>
                                                <button type="button" class="btn btn-success" id="publishButton">Publish</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                
            </div>
                <div class="modal fade" id="previewModal">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    
                        <!-- Modal Header -->
                        <div class="modal-header">
                        <h4 class="modal-title">Modal Heading</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body" id="previewContent">
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                        <p>Data berhasil di Update</p>
                        </div>
                    </div>
                    </div> 
                </div>
                <!-- Failed Modal -->
                <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <i class="fas fa-exclamation-circle error-icon"></i>
                            <br>
                            <p id="error-message"></p>
                        </div>
                    
                    </div>
                    </div>
                </div>
                <div id="loadingOverlay" class="loading-overlay" style="display: none;">
                    <div class="spinner-border medium custom-color" role="status">
                        <span class="sr-only">Loading...</span>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function addInput(button) {
        var inputGroup = $(button).closest('.input-group');
        var newInputGroup = inputGroup.clone();
        newInputGroup.find('input').val('');
        newInputGroup.find('.btn-add').remove();
        newInputGroup.append('<button type="button" class="btn btn-danger btn-remove" onclick="removeInput(this)">-</button>');
        newInputGroup.addClass('new-input-group'); // Add class for spacing
        inputGroup.after(newInputGroup);
    }

    function removeInput(button) {
        $(button).closest('.input-group').remove();
    }

    function removeDataPersyaratan(button) {
        var $formGroup = $(button).closest('.form-group');
        var inputId = $formGroup.find('input[data-idpersyaratan]').data('idpersyaratan'); // Dapatkan ID dari atribut data-idpersyaratan
        console.log(inputId)
        
        if (inputId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                url: '/public/remove-persyaratan-endpoint/' + inputId, // Ganti dengan endpoint API Anda
                type: 'GET',
                success: function(response) {
                    $formGroup.remove();
                    // Opsional, tampilkan pesan sukses atau tangani responsnya
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan. Silakan coba lagi.';
                    $('#errorModal .modal-body').text(errorMessage); // Perbarui pesan error di modal
                    $('#errorModal').modal('show');
                }
            });
        } else {
            // Jika tidak ada ID, cukup hapus grup form
            $formGroup.remove();
        }
    }

    function removeDataMateriTraining(button) {
        var $formGroup = $(button).closest('.form-group');
        var inputId = $formGroup.find('input[data-idmateritraining]').data('idmateritraining'); // Dapatkan ID dari atribut data-idmateritraining

        if (inputId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                url: '/public/remove-materitraining-endpoint/' + inputId, // Ganti dengan endpoint API Anda
                type: 'GET',
                success: function(response) {
                    $formGroup.remove();
                    // Opsional, tampilkan pesan sukses atau tangani responsnya
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan. Silakan coba lagi.';
                    $('#errorModal .modal-body').text(errorMessage); // Perbarui pesan error di modal
                    $('#errorModal').modal('show');
                }
            });
        } else {
            // Jika tidak ada ID, cukup hapus grup form
            $formGroup.remove();
        }
    }

    function removeDataFasilitas(button) {
        var $formGroup = $(button).closest('.form-group');
        var inputId = $formGroup.find('input[data-idfasilitas]').data('idfasilitas'); // Dapatkan ID dari atribut
        console.log(inputId)
        if (inputId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                url: '/public/remove-fasilitas-endpoint/' + inputId, // Ganti dengan endpoint API Anda
                type: 'GET',
                success: function(response) {
                    $formGroup.remove();
                    // Opsional, tampilkan pesan sukses atau tangani responsnya
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan. Silakan coba lagi.';
                    $('#errorModal .modal-body').text(errorMessage); // Perbarui pesan error di modal
                    $('#errorModal').modal('show');
                }
            });
        } else {
            // Jika tidak ada ID, cukup hapus grup form
            $formGroup.remove();
        }
    }

    function removeDataPhoto(button) {
        var $formGroup = $(button).closest('.form-group');
        var inputId = $formGroup.find('input[data-iddphoto]').data('iddphoto'); // Dapatkan ID dari atribut data-idfasilita

        if (inputId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                url: '/public/remove-photo-endpoint/' + inputId, // Ganti dengan endpoint API Anda
                type: 'DELETE',
                success: function(response) {
                    $formGroup.remove();
                    // Opsional, tampilkan pesan sukses atau tangani responsnya
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan. Silakan coba lagi.';
                    $('#errorModal .modal-body').text(errorMessage); // Perbarui pesan error di modal
                    $('#errorModal').modal('show');
                }
            });
        } else {
            // Jika tidak ada ID, cukup hapus grup form
            $formGroup.remove();
        }
    }

    function previewForm() {
        var previewContent = '<table class="table table-bordered">';
        previewContent += '<tr><th>Field</th><th>Value</th></tr>';

        // Iterate over each input field with an ID
        $('#trainingForm input, #trainingForm select').each(function() {
            var id = $(this).attr('id'); // Get the ID attribute
            var value = $(this).val(); // Get the value of the input field

            // Only display fields with an ID
            if (id) {
                previewContent += '<tr><td>' + id + '</td><td>' + value + '</td></tr>';
            }
        });

        previewContent += '</table>';
        $('#previewContent').html(previewContent);
        $('#previewModal').modal('show');
    }

    $(document).ready(function() {
        
            // Initialize Select2
            $('select[name="jadwal_mulai_tanggal"], select[name="jadwal_mulai_bulan"], select[name="jadwal_mulai_tahun"]').select2();
            $('select[name="jadwal_selesai_tanggal"], select[name="jadwal_selesai_bulan"], select[name="jadwal_selesai_tahun"]').select2();
            $('select[name="category"], select[name="jenis_sertifikasi"]').select2();
            $('select[name="lokasi"]').select2();

            // Populate days
            for (let i = 1; i <= 31; i++) {
                $('select[name="jadwal_mulai_tanggal"]').append(`<option value="${i}">${i}</option>`);
            }

            // Populate months
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            months.forEach((month, index) => {
                $('select[name="jadwal_mulai_bulan"]').append(`<option value="${index + 1}">${month}</option>`);
            });

            // Populate years
            const currentYear = new Date().getFullYear();
            for (let i = currentYear; i <= currentYear + 10; i++) {
                $('select[name="jadwal_mulai_tahun"]').append(`<option value="${i}">${i}</option>`);
            }


            for (let i = 1; i <= 31; i++) {
                $('select[name="jadwal_selesai_tanggal"]').append(`<option value="${i}">${i}</option>`);
            }

            // Populate months
            const monthsSelesai = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            monthsSelesai.forEach((month, index) => {
                $('select[name="jadwal_selesai_bulan"]').append(`<option value="${index + 1}">${month}</option>`);
            });

            // Populate years
            const currentYearSelesai = new Date().getFullYear();
            for (let i = currentYearSelesai; i <= currentYearSelesai + 10; i++) {
                $('select[name="jadwal_selesai_tahun"]').append(`<option value="${i}">${i}</option>`);
            }

            // Refresh Select2 options
            $('select[name="jadwal_mulai_tanggal"]').trigger('change');
            $('select[name="jadwal_mulai_bulan"]').trigger('change');
            $('select[name="jadwal_mulai_tahun"]').trigger('change');

            $('select[name="jadwal_selesai_tanggal"]').trigger('change');
            $('select[name="jadwal_selesai_bulan"]').trigger('change');
            $('select[name="jadwal_selesai_tahun"]').trigger('change');

            $('select[name="category"]').trigger('change');
            $('select[name="jenis_sertifikasi"]').trigger('change');
            $('select[name="lokasi"]').trigger('change');
    });
        
    $(document).ready(function() {
            // Data tanggal
            var tanggalStartDate = '{{ $startdate }}';
            
            // Pecah data tanggal menjadi tahun, bulan, dan hari
            var tanggalParts = tanggalStartDate.split("-");
            var tahun = tanggalParts[0];
            var bulan = tanggalParts[1];
            var hari = tanggalParts[2];

            // Isi nilai input tanggal mulai
            $('select[name="jadwal_mulai_tanggal"]').val(tanggalStartDate);

            // Buat opsi untuk tanggal, bulan, dan tahun
            for (var i = 1; i <= 31; i++) {
                $('select[name="jadwal_mulai_tanggal"]').append($('<option>', {
                    value: i,
                    text: i,
                    selected: (i == parseInt(hari)) // Set opsi terpilih jika nilai sesuai
                }));
            }
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

          
            months.forEach((month, index) => {
                $('select[name="jadwal_mulai_bulan"]').append($('<option>', {
                    value: index + 1,
                    text: month,
                    selected: (index + 1 == parseInt(bulan)) // Set opsi terpilih jika nilai sesuai
                }));
            });

            var currentYear = new Date().getFullYear();
            for (var i = currentYear - 100; i <= currentYear + 20; i++) {
                $('select[name="jadwal_mulai_tahun"]').append($('<option>', {
                    value: i,
                    text: i,
                    selected: (i == parseInt(tahun)) // Set opsi terpilih jika nilai sesuai
                }));
            }

            var tanggalEndDate = '{{ $enddate }}';
            
            // Pecah data tanggal menjadi tahun, bulan, dan hari
            var tanggalPartsEndate = tanggalEndDate.split("-");
            var tahunEndate = tanggalPartsEndate[0];
            var bulanEndate = tanggalPartsEndate[1];
            var hariEndate = tanggalPartsEndate[2];

            // Isi nilai input tanggal selesai
            $('select[name="jadwal_selesai_tanggal"]').val(tanggalEndDate);

            // Buat opsi untuk tanggal, bulan, dan tahun
            for (var i = 1; i <= 31; i++) {
                $('select[name="jadwal_selesai_tanggal"]').append($('<option>', {
                    value: i,
                    text: i,
                    selected: (i == parseInt(hariEndate)) // Set opsi terpilih jika nilai sesuai
                }));
            }
            
            months.forEach((month, index) => {
                $('select[name="jadwal_selesai_bulan"]').append($('<option>', {
                    value: index + 1,
                    text: month,
                    selected: (index + 1 == parseInt(bulan)) // Set opsi terpilih jika nilai sesuai
                }));
            });

            var currentYearEndate = new Date().getFullYear();
            for (var i = currentYearEndate - 100; i <= currentYearEndate + 20; i++) {
                $('select[name="jadwal_selesai_tahun"]').append($('<option>', {
                    value: i,
                    text: i,
                    selected: (i == parseInt(tahunEndate)) // Set opsi terpilih jika nilai sesuai
                }));
            }

            // Set nilai dropdown ke nilai yang ada
            // $('select[name="jadwal_mulai_tanggal"]').val(parseInt(hari));
            // $('select[name="jadwal_mulai_bulan"]').val(parseInt(bulan));
            // $('select[name="jadwal_mulai_tahun"]').val(parseInt(tahun));
    });

        $(document).ready(function() {
            // Populate days
            for (let i = 1; i <= 31; i++) {
                $('#Jadwal Training Mulai\\: Tanggal').append(`<option value="${i}">${i}</option>`);
            }

            // Populate months
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            months.forEach((month, index) => {
                $('#Jadwal Training Mulai\\: Bulan').append(`<option value="${index + 1}">${month}</option>`);
            });

            // Populate years
            const currentYear = new Date().getFullYear();
            for (let i = currentYear; i <= currentYear + 10; i++) {
                $('#Jadwal Training Mulai\\: Tahun').append(`<option value="${i}">${i}</option>`);
            }
        });
        $(document).ready(function() {
            function showLoading() {
                $('#loadingOverlay').show();
            }

            function hideLoading() {
                $('#loadingOverlay').hide();
            }

            $('#publishButton').click(function() {
                showLoading(); // Show loading indicator

                var form = $('#trainingForm')[0]; // Get the form element
                var formData = new FormData(form); // Create FormData object

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                $.ajax({
                    url: '/public/update-course-endpoint', // Replace with your API endpoint
                    type: 'POST',
                    data: formData,
                    contentType: false, // Set to false for multipart/form-data
                    processData: false, // Set to false to prevent jQuery from processing the data
                    success: function(response) {
                        hideLoading(); // Hide loading indicator
                        $('#successModal').modal('show');

                        setTimeout(function() {
                            $('#successModal').modal('hide');
                            location.reload();
                        }, 2000);

                        $('#previewModal').modal('hide');
                        $('#trainingForm')[0].reset(); // Correct ID of the form
                    },
                    error: function(xhr, status, error) {
                        hideLoading(); // Hide loading indicator
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan. Silakan coba lagi.';
                        $('#errorModal .modal-body').text(errorMessage); // Update error message in the modal
                        $('#errorModal').modal('show');

                        // Optionally, you can auto-close the error modal after some time
                        // setTimeout(function() {
                        //     $('#errorModal').modal('hide');
                        //     location.reload();
                        // }, 2000);
                    }
                });
            });
        });




</script>
@endsection