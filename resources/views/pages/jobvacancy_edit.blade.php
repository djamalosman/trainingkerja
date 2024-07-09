@extends('../layouts.mainv2')

@section('headers')
<link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('/') }}plugins/summernote/summernote-bs4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />

<style>
  
  #inputText {
        width: 100%;
        height: 40px;
        padding: 0.5em;
        margin-bottom: 1em;
        font-size: 1em;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5em 1em;
        margin: 0.2em;
        background-color: #007bff;
        color: white;
        border-radius: 0.5em;
        font-size: 1em;
        line-height: 1.5; /* Menyesuaikan tinggi baris */
        height: 2.5em; /* Menyesuaikan tinggi badge */
    }
    
    .badge .close {
        margin-left: 0.5em;
        cursor: pointer;
        font-weight: bold;
    }
    

    #inputTextLevel {
        width: 100%;
        height: 40px;
        padding: 0.5em;
        margin-bottom: 1em;
        font-size: 1em;
    }
    
    .badgeLevel {
        display: inline-flex;
        align-items: center;
        padding: 0.5em 1em;
        margin: 0.2em;
        background-color: #007bff;
        color: white;
        border-radius: 0.5em;
        font-size: 1em;
        line-height: 1.5; /* Menyesuaikan tinggi baris */
        height: 2.5em; /* Menyesuaikan tinggi badge */
    }
    
    .badgeLevel .close {
        margin-left: 0.5em;
        cursor: pointer;
        font-weight: bold;
    }


    #inputTextEdit {
        width: 100%;
        height: 40px;
        padding: 0.5em;
        margin-bottom: 1em;
        font-size: 1em;
    }
    
    .badgeEdit {
        display: inline-flex;
        align-items: center;
        padding: 0.5em 1em;
        margin: 0.2em;
        background-color: #007bff;
        color: white;
        border-radius: 0.5em;
        font-size: 1em;
        line-height: 1.5; /* Menyesuaikan tinggi baris */
        height: 2.5em; /* Menyesuaikan tinggi badge */
    }
    
    .badgeEdit .close {
        margin-left: 0.5em;
        cursor: pointer;
        font-weight: bold;
    }

    #inputTextLevelEdit {
        width: 100%;
        height: 40px;
        padding: 0.5em;
        margin-bottom: 1em;
        font-size: 1em;
    }
    
    .badgeLevelEdit {
        display: inline-flex;
        align-items: center;
        padding: 0.5em 1em;
        margin: 0.2em;
        background-color: #007bff;
        color: white;
        border-radius: 0.5em;
        font-size: 1em;
        line-height: 1.5; /* Menyesuaikan tinggi baris */
        height: 2.5em; /* Menyesuaikan tinggi badge */
    }
    
    .badgeLevelEdit .close {
        margin-left: 0.5em;
        cursor: pointer;
        font-weight: bold;
    }

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
* {
  box-sizing: border-box;
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
    <section class="content p-4">
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

    <section class="content p-4 col-md-8" >
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
                    
                    <input type="hidden" name="iddtl" id="iddtl" value="{{$iddtl }}">
                    
                    <div class="row">
                        <!-- Left Card -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label for="titleEn">Nama Lowongan</label>
                                        <input type="text" name="vacancy_name" class="form-control" value="{{$databyid->vacancy_name}}" id="vacancy_name" placeholder="">
                                        <small id="title_eng_error" class="title_eng_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Category</label>
                                        <select class="form-control" name="category" id="category"">
                                            <option value="">Pilih</option>
                                            @foreach($liscategory as $value)
                                            <option value="{{ $value->id }}" {{ $databyid->id_job_m_vacancy == $value->id ? 'selected' : '' }}>
                                                {{ $value->nama }}
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Lokasi</label>
                                        <input type="text" name="location" class="form-control" value="{{$databyid->location}}" id="location" placeholder="">
                                        <small id="title_id_error" class="title_id_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    <div class="form-group">
                                            <label for="title1">Status Lowongan</label>
                                            <textarea id="inputText"  class="form-control" placeholder="Type something and press Enter..." name="name"></textarea>
                                            <div id="badgesContainer"></div>
                                            <input type="hidden" class="badge badge-light" name="status_vacancy" value="{{$databyid->status_vacancy}}" id="badgesInput">
                                    </div>
                                    <div class="form-group">
                                        <label for="title1">Tingkatan Lowongan</label>
                                        <textarea id="inputTextLevel"  class="form-control" placeholder="Type something and press Enter..." name="name"></textarea>
                                        <div id="badgesContainerLevel"></div>
                                        <input type="hidden" class="badge badge-light" name="vacancy_level" value="{{$databyid->vacancy_level}}" id="badgesInputLevel">
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                        <!-- Right Card -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label for="titleEn">Tanggal Posting Lowongan</label>
                                        <input type="text" name="startdate" class="form-control" value="{{$posted_date}}" id="startdate" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="titleEn">Tanggal Penutupan Lowongan</label>
                                        <input type="type" name="enddate" class="form-control" value="{{$close_date}}" id="enddate" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="salarytraining">Salary</label>
                                        <input type="text" name="salarytraining" class="form-control" value="{{$databyid->salary}}" id="salarytraining" placeholder="Rp 0">
                                        <small id="title_id_error" class="title_id_error input-group text-sm mt-2 text-danger error"></small>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label for="picture">Photo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="item_file[]"  accept="image/*" multiple class="custom-file-input" id="item_files">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                      
                                       
                                    </div>
                                    @if (Count($getImage) > 0)
                                        <button type="button" class="btn btn-primary start" data-toggle="modal" data-target="#filterButtonImage">view Image</button>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card col-md-12">
                            <div class="card-body"> 
                                <<div class="form-group">
                                    <label for="titleEn">Persyaratan</label>
                                    <textarea class="form-control desc" name="requirements" id="requirements" rows="4" cols="50">{{$databyid->vacancy_description}}</textarea>
                      
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
                  
                  <p>Data berhasil diupdate</p>
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
        
        
        <!-- Modal untuk menampilkan gambar -->
        <div class="modal fade" id="filterButtonImage" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">File Image</h5>
           
                    </div>
                    @foreach ($getImage as $val)
                    <div class="modal-body">
                            <!-- Left Card -->
                                    <div class="form-group">
                                        <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="{{ asset('/') }}storage/{{ $val->namaImage ?? '' }}" alt="simulasi" class="img-thumbnail simulasi-gambar-picture-visi-misi" width="140px" data-toggle="modal" data-target="#filterButtonImage" data-src="{{ asset('/') }}storage/{{ $val->namaImage ?? '' }}">
                                        <br>
                                    </div>
                            
                    @endforeach
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

$(document).ready(function() {
        $('.img-thumbnail').click(function() {
            var imgSrc = $(this).data('src');
            $('#filterButtonImage .modal-body img').attr('src', imgSrc);
            $('#filterButtonImage').modal('show');
        });
    });
    
    document.addEventListener('DOMContentLoaded', () => {
            // Inisialisasi elemen di luar modal
            initializeBadgeInput('inputText', 'badgesContainer', 'badgesInput');
            initializeBadgeInput('inputTextLevel', 'badgesContainerLevel', 'badgesInputLevel');

            // Inisialisasi elemen di dalam modal saat modal ditampilkan
            $('#edit-item').on('shown.bs.modal', function () {
                initializeBadgeInput('inputTextEdit', 'badgesContainerEdit', 'badgesInputEdit');
                initializeBadgeInput('inputTextLevelEdit', 'badgesContainerLevelEdit', 'badgesInputLevelEdit');
            });
    });

    function initializeBadgeInput(inputTextId, badgesContainerId, badgesInputId) {
        const inputText = document.getElementById(inputTextId);
        const badgesContainer = document.getElementById(badgesContainerId);
        const badgesInput = document.getElementById(badgesInputId);

        // Clear previous event listeners
        const newInputText = inputText.cloneNode(true);
        inputText.parentNode.replaceChild(newInputText, inputText);

        newInputText.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && newInputText.value.trim() !== '') {
                event.preventDefault(); // Prevent default newline in textarea
                createBadge(badgesContainer, badgesInput, newInputText.value.trim());
                newInputText.value = '';
            } else if (event.key === 'Backspace' && newInputText.value.trim() === '') {
                const lastBadge = badgesContainer.querySelector('.badge:last-child');
                if (lastBadge) {
                    lastBadge.remove();
                    updateBadgesInput(badgesContainer, badgesInput);
                }
            }
        });

        // Initialize badgesInput value and create badges on page load
        if (badgesInput.value) {
            const initialBadges = badgesInput.value.split('|').map(badge => badge.trim());
            initialBadges.forEach(badgeText => {
                if (badgeText) {
                    createBadge(badgesContainer, badgesInput, badgeText);
                }
            });
        }
        updateBadgesInput(badgesContainer, badgesInput);
    }

    function createBadge(badgesContainer, badgesInput, text) {
        const badge = document.createElement('div');
        badge.className = 'badge';
        badge.textContent = text;

        const closeBtn = document.createElement('span');
        closeBtn.className = 'close';
        closeBtn.textContent = '×';
        closeBtn.addEventListener('click', () => {
            badge.remove();
            updateBadgesInput(badgesContainer, badgesInput);
        });

        badge.appendChild(closeBtn);
        badgesContainer.appendChild(badge);
        updateBadgesInput(badgesContainer, badgesInput);
    }

    function updateBadgesInput(badgesContainer, badgesInput) {
        const badges = [];
        badgesContainer.querySelectorAll('.badge').forEach(badge => {
            badges.push(badge.childNodes[0].nodeValue.trim());
        });
        badgesInput.value = badges.join(' | '); // Gabungkan badges dengan koma
    }
    
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
        // Function to show loading indicator
        function showLoading() {
            $('#loadingOverlay').show();
        }

        // Function to hide loading indicator
        function hideLoading() {
            $('#loadingOverlay').hide();
        }

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

        $('#preview-btn').click(function() {
            // Fungsi untuk mengubah format tanggal MM/DD/YYYY ke YYYY-MM-DD
            function formatDate(inputDate) {
                if (!inputDate) return null;
                const [month, day, year] = inputDate.split('/');
                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
            }

            function stripHtmlTags(text) {
                return text.replace(/<\/?[^>]+>/gi, '');
            }

            var formData = {
                vacancy_name: $('#vacancy_name').val(),
                category: $('#category').val(),
                location: $('#location').val(),
                badgesInput: $('#badgesInput').val(),
                badgesInputLevel: $('#badgesInputLevel').val(),
                requirements: $('#requirements').val(),
                startdate: formatDate($('#startdate').val()),
                enddate: formatDate($('#enddate').val()),
                salarytraining: $('#salarytraining').val(),
                status: 3
            };

            $('#modal-content').html(`
                <div class="form-group row">
                <label>Nama Lowongan</label>
                <input type="text" class="form-control" value="${formData.vacancy_name}" readonly>
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
                <label>Lokasi Training</label>
                <input type="text" class="form-control" value="${formData.location}" readonly>
                </div>
                <div class="form-group row">
                <label>Status Lowongan</label>
                <input type="text" class="form-control" value="${formData.badgesInput}" readonly>
                </div>

                <div class="form-group row">
                <label>Tingkatan Lowongan</label>
                <input type="text" class="form-control" value="${formData.badgesInputLevel}" readonly>
                </div>

                
                <div class="form-group row">
                <label>Tanggal Posting Lowongan</label>
                <input type="text" class="form-control" value="${formData.startdate}" readonly>
                </div>
                <div class="form-group row">
                <label>Tanggal Penutupan Lowongan</label>
                <input type="text" class="form-control" value="${formData.enddate}" readonly>
                </div>
                <div class="form-group row">
                <label>Salary</label>
                <input type="text" class="form-control" value="${formData.salarytraining}" readonly>
                </div>
                <div class="form-group row">
                <label>Persyaratan</label>
                <textarea class="form-control" rows="4" readonly>${stripHtmlTags(formData.requirements)}</textarea>
                </div>
            `);

            $('#previewModal').modal('show');

            var fileInput = document.getElementById('item_files');
            if (fileInput) {
                var files = fileInput.files;
                if (files.length > 0) {
                    var imageUrls = [];

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

                    for (var i = 0; i < files.length; i++) {
                        (function(file) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                imageUrls.push(e.target.result);

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

        $('#pending-btn').click(function() {
            submitFormWithStatus(2);
        });

        $('#publish-btn').click(function() {
            submitFormWithStatus(1);
        });

        function submitFormWithStatus(status) {
            var formData = new FormData($('#training-form')[0]);
            formData.append('status', status);

            var fileInput = $('#item_files')[0];
            for (var i = 0; i < fileInput.files.length; i++) {
                formData.append('item_files[]', fileInput.files[i]);
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            showLoading(); // Show loading indicator

            $.ajax({
                url: '/update-job-vacancy',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    hideLoading(); // Hide loading indicator
                    $('#successModal').modal('show');

                    setTimeout(function() {
                        $('#successModal').modal('hide');
                        location.reload();
                    }, 2000);

                    $('#previewModal').modal('hide');
                    $('#training-form')[0].reset();
                },
                error: function(xhr, status, error) {
                    hideLoading(); // Hide loading indicator
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan. Silakan coba lagi.';
                    $('#error-message').text('Terjadi kesalahan. Silakan coba lagi');
                    $('#errorModal').modal('show');

                    setTimeout(function() {
                        $('#errorModal').modal('hide');
                        location.reload();
                    }, 2000);
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
    // $('input[type="file"]').change(function(e) {
    //     console.log('Picture Changed');
    //     var files = [];
    //     for (var i = 0; i < $(this)[0].files.length; i++) {
    //         files.push($(this)[0].files[i].name);
    //     }
    //     const [file] = $(this)[0].files;
    //     if (file) {
    //         $(".simulasi-gambar-" + this.id).attr("src", URL.createObjectURL(file));
    //     }
    //     $(this).next(".custom-file-label").html(files.join(", "));
    // });
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
   
</script>
@endsection