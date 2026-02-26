<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="theme_ocean">
    <title>Perpustakaan - Register</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/theme.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <main class="auth-creative-wrapper">
        <div class="auth-creative-inner">
            <div class="creative-card-wrapper">
                <div class="card my-4 overflow-hidden" style="z-index: 1">
                    <div class="row flex-1 g-0">
                        <div class="col-lg-6 h-100 my-auto">
                            <div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-50 start-50">
                                <img src="<?=base_url()?>assets/images/logo-abbr.png" alt="" class="img-fluid">
                            </div>
                            <div class="creative-card-body card-body p-sm-5">
                                <h2 class="fs-20 fw-bolder mb-4">Registrasi</h2> 
                                <h4 class="fs-13 fw-bold mb-2">Buat Akun mu</h4>  
                                <p class="fs-12 fw-medium text-muted">Ayo buat dan verifikasi data mu untuk menjadi bagian dari perpustakaan Kami</p>
                                
                                <form id="form-register" class="w-100 mt-4 pt-2">
                                    <div class="mb-4">  
                                        <input type="text" class="form-control" id="nis" name="nis" placeholder="NIS" required>                             
                                    </div>

                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <select class="form-control" id="kelas" name="kelas" required>
                                            <option value="" selected disabled>Pilih Kelas</option>
                                            <option value="X">X</option>
                                            <option value="XI">XI</option>
                                            <option value="XII">XII</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Alamat" required></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="termsCondition" required>
                                            <label class="custom-control-label c-pointer text-muted" for="termsCondition" style="font-weight: 400 !important">
                                                Saya menyetujui semua <a href="#">Syarat &amp; Ketentuan</a>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-lg btn-dark w-100" id="btn-register">
                                            <span id="btn-text">Registrasi Akun</span>
                                            <span id="btn-loading" style="display: none;">
                                                <i class="fas fa-spinner fa-spin"></i> Memproses...
                                            </span>
                                        </button>
                                    </div>
                                </form>
                                
                                <div class="mt-5 text-muted">
                                    <span>Sudah punya akun?</span>
                                    <a href="<?=site_url('login-sistem')?>" class="fw-bold">Login</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 bg-secondary">
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <img src="<?=base_url()?>assets/images/auth/auth-cover-login-bg.svg" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script>
    $(document).ready(function(){
        $('#togglePassword').click(function(){
            var passwordInput = $('#password');
            var icon = $(this).find('i');
            
            if(passwordInput.attr('type') === 'password'){
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
        

        $('#form-register').submit(function(e){
            e.preventDefault();
            if($("#username").val() == "" || $("#password").val() == ""){
                alert('Username dan Password wajib diisi');
                return false;
            }
            
            if($("#password").val().length < 3){
                alert('Password minimal 3 karakter');
                return false;
            }
            
            if(!$('#termsCondition').is(':checked')){
                alert('Anda harus menyetujui syarat dan ketentuan');
                return false;
            }
            
            $('#btn-text').hide();
            $('#btn-loading').show();
            $('#btn-register').prop('disabled', true);
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('register/ajax/save'); ?>",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(response) {
                    if(response.status) {
                        alert('Registrasi berhasil! Silakan login.');
                        window.location.href = "<?=site_url('login-sistem')?>";
                    } else {
                        alert('Gagal: ' + (response.message || 'Registrasi gagal'));
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error:", xhr.responseText);
                    alert('Terjadi kesalahan server');
                },
                complete: function() {
                    $('#btn-text').show();
                    $('#btn-loading').hide();
                    $('#btn-register').prop('disabled', false);
                }
            });
        });
    });
    </script>
    </body>
    </html>