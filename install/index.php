<?php include './app/Config.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Installation - Autobot</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="public/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="public/css/font-awesome.min.css">
        <!-- Custom Style -->
        <link rel="stylesheet" href="public/css/style.css">
    </head>
    <body>
        <div class="loader"></div> 
        <!-- BACK TO TOP  -->
        <a name="top"></a>

        <!-- BEGIN CONTAINER -->
        <div class="container">
            <!-- BEGIN ROW -->
            <div class="row"> 
                <div class="col-md-10 col-md-offset-1 col-sm-12"> 
                
                    <!-- MAIN WRAPPER -->
                    <div class="main_wrapper">

                        <!-- BEGIN HEADER -->
                        <div class="page-header"> 
                            <h1></h1>
                        </div>
                        <!-- ENDS HEADER -->

                        <div class="inner-container">
                            <!-- BEGIN LEFT SIDEBAR -->
                            <div class="col-sm-3 p-0 m-0">
                                <ul class="sidebar list-unstyled">
                                  <li class="<?= (($title == 'Requirements') ? 'active' : '') ?>"><a href="?step=requirements"><i class="fa fa-server"></i> Requirements</a></li>
                                  <li class="<?= (($title == 'Installation') ? 'active' : '') ?>"><a href="?step=installation"><i class="fa fa-wrench"></i> Installation</a></li>
                                  <li class="<?= (($title == 'Complete') ? 'active' : '') ?>"><a href="javascript:void(0)"><i class="fa fa-check"></i> Complete</a></li>
                                </ul>
                            </div>

                            <div class="col-sm-9 center">
                                <?php include($content) ?>
                            </div>
                            <footer style="background: white">
                                <span style="visibility: hidden">Developed by <a href="https://developerity.com">developerity.com</a></span>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="public/js/jquery.min.js"></script>
        <script src="public/js/script.js"></script>
    </body>
</html>