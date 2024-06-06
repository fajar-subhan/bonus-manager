<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Fajar Subhan">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo TITLE; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo ADMINLTE ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo ADMINLTE ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo ADMINLTE ?>/dist/css/adminlte.min.css">
    <!-- Login style -->
    <link rel="stylesheet" href="<?php echo ASSETS ?>css/login.css">

    <!-- Icon -->
    <link rel="icon" href="<?php echo ASSETS ?>images/icon/logo.png">
</head>

<body class="hold-transition login-page login-page-background">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary login-card">
            <div class="card-header text-center">
                <h4><b>Bonus Manager V.1.0.0</b></h4>
            </div>
            <div class="card-body">
                <p class="login-box-msg">
                    <small>Silahkan Masuk</small>
                </p>
                <form id="login">
                    <div class="input-group mb-2" id="username_panel">
                        <input type="text" class="form-control form-control-sm" id="username" placeholder="Username" value="<?php echo (isset($_COOKIE['username'])) ? Decrypt($_COOKIE['username']) : 'test'; ?>">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div id="username_error"></div>

                    <div class="input-group mb-2" id="password_panel">
                        <input type="password" class="form-control form-control-sm" id="password" placeholder="Password" value="<?php echo (isset($_COOKIE['password'])) ? Decrypt($_COOKIE['password']) : ''; ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>

                        </div>
                    </div>
                    <div id="password_error"></div>


                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember" class="font-weight-normal">
                                    <small>Ingat Saya</small>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" id="signin" class="btn btn-sm btn-primary btn-block">Masuk</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?php echo ASSETS ?>plugins/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo ASSETS ?>plugins/bootstrap.bundle.min.js"></script>
    <!-- JS Auth -->
    <!-- Sweetalert2 -->
    <script src="<?php echo ASSETS ?>plugins/sweetalert2.all.min.js"></script>
    <script src="<?php echo ASSETS ?>js/auth/auth.js"></script>
</body>

</html>