<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url('images/logo-light-svg.svg'); ?>">

    <title>Test Module</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="<?php echo base_url('main/css/vendors_css.css'); ?>">

    <!-- Style-->
    <link rel="stylesheet" href="<?php echo base_url('main/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('main/css/skin_color.css'); ?>">

</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url(<?php echo base_url('images/login-bg.png'); ?>)">

    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100">

            <div class="col-12">
                <div class="row justify-content-center g-0">
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="bg-white rounded10 shadow-lg">
                            <div class="content-top-agile p-20 pb-0">
                                <h2 class="text-primary">Let's Get Started</h2>
                                <p class="mb-0">Register A New User.</p>
                            </div>
                            <div class="p-40">
                                <form action="<?php echo site_url('user/sign_up'); ?>" method="post">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                            <input type="text" name="full_name" value="<?php echo set_value('full_name'); ?>" class="form-control ps-15 bg-transparent" placeholder="Full Name" required>
                                        </div>
                                        <?php echo form_error('full_name', '<span class="error invalid-feedback" style="display:block">', '</span>') ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-email"></i></span>
                                            <input type="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control ps-15 bg-transparent" placeholder="Email" required>
                                        </div>
                                        <?php echo form_error('email', '<span class="error invalid-feedback" style="display:block">', '</span>') ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-phone"></i></span>
                                            <input type="text" name="mobile" value="<?php echo set_value('mobile'); ?>" class="form-control ps-15 bg-transparent" placeholder="Mobile" required>
                                        </div>
                                        <?php echo form_error('mobile', '<span class="error invalid-feedback" style="display:block">', '</span>') ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                            <input type="password" name="password" value="" class="form-control ps-15 bg-transparent" placeholder="Password" required>
                                        </div>
                                        <?php echo form_error('password', '<span class="error invalid-feedback" style="display:block">', '</span>') ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                            <input type="password" name="confirm_password" value="" class="form-control ps-15 bg-transparent" placeholder="Retype Password" required>
                                        </div>
                                        <?php echo form_error('confirm_password', '<span class="error invalid-feedback" style="display:block">', '</span>') ?>
                                    </div>
                                    <div class="row">
                                        <!-- /.col -->
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-rounded mt-10 btn-success">SIGN UP</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </form>
                                <div class="text-center">
                                    <p class="mt-15 mb-0">Already have an account?<a href="<?php echo site_url('user/login'); ?>" class="text-danger ms-5"> Sign In</a></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Vendor JS -->
    <script src="<?php echo base_url('main/js/vendors.min.js'); ?>"></script>
    <script src="<?php echo base_url('main/js/pages/chat-popup.js'); ?>"></script>
    <script src="<?php echo base_url('assets/icons/feather-icons/feather.min.js'); ?>"></script>

</body>

</html>