<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="theme_ocean">
    <title>Perpustakaan</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/theme.min.css">
</head>

<body>
    <!--! ================================================================ !-->
    <!--!                               [Start]                            !-->
    <!--! ================================================================ !-->
    <main class="auth-creative-wrapper">
        <div class="auth-creative-inner">
            <div class="creative-card-wrapper">
                <div class="card my-4 overflow-hidden" style="z-index: 1">
                    <div class="row flex-1 g-0">
                        <div class="col-lg-6 h-100 my-auto order-1 order-lg-0">
                            <div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-50 start-50 d-none d-lg-block">
                                <img src="<?=base_url()?>assets/images/logo-abbr.png" alt="" class="img-fluid">
                            </div>
                            <div class="creative-card-body card-body p-sm-5">
                                <h2 class="fs-20 fw-bolder mb-4">Login</h2>
                                <h4 class="fs-13 fw-bold mb-2">Masuk ke akun kamu</h4>
                                <p class="fs-12 fw-medium text-muted">Lihat informasi terkini seputar List buku mu!</p>
                                <form action="<?=base_url()?>auth_login/login" method="post" class="w-100 mt-4 pt-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-lg btn-dark w-100">Login</button>
                                    </div>    
                                </form>
                                <div class="mt-5 text-muted">
                                    <span> Belum punya akun?</span>
                                    <a href="<?=site_url('register-anggota')?>" class="fw-bold">Registrasi sekarang</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 bg-secondary order-0 order-lg-1">
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <img src="<?=base_url()?>assets/images/auth/auth-cover-login-bg.svg" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--! ================================================================ !-->
    <!--!                               [END]                              !-->
    <!--! ================================================================ !-->


<?php if ($this->session->flashdata('error')): ?>
<script>
    alert("ERROR: <?php echo $this->session->flashdata('error'); ?>");
</script>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

<?php if ($this->session->flashdata('success')): ?>
    <script>alert("<?php echo $this->session->flashdata('success'); ?>");</script>
<?php endif; ?>

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
})
</script>
