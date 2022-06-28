<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url()?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?=base_url()?>assets/img/icons/online-shopping.png">
  <title>
    PDMS | Register
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="<?=base_url()?>assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- Validation CSS -->
  <link rel="stylesheet" href="<?=base_url()?>assets/css/validation.css">
  <!-- CSS Files -->
  <link id="pagestyle" href="<?=base_url()?>assets/css/material-dashboard.css?v=3.0.2" rel="stylesheet" />
  <link rel="stylesheet" href="<?=base_url()?>assets/css/style.css">
  <!-- Jquery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <!-- Sweet Alert -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
          <div class="container-fluid ps-2 pe-0">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="javascript:">
              Register Admin Productive Data Management System
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto">
                <!-- <li class="nav-item"> -->
                  <!-- <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="#"> -->
                    <!-- <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i> -->
                    <!-- Dashboard -->
                  <!-- </a> -->
                <!-- </li> -->
                <!-- <li class="nav-item"> -->
                  <!-- <a class="nav-link me-2" href="#"> -->
                    <!-- <i class="fa fa-user opacity-6 text-dark me-1"></i> -->
                    <!-- Profile -->
                  <!-- </a> -->
                <!-- </li> -->
                <li class="nav-item">
                  <a class="nav-link me-2" href="<?=base_url()?>authentication">
                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                    Sign In
                  </a>
                </li>
              </ul>
              <ul class="navbar-nav d-lg-block d-none">
                <li class="nav-item">
                  <a href="javascript:" class="btn btn-sm mb-0 me-1 bg-gradient-dark">v.1.0</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('<?=base_url()?>assets/img/illustrations/cafe.svg'); background-size: cover;">
              </div>
            </div>

            <!-- Form -->
            <div class="load-form">
              <?= $contents?>
            </div>
            <!-- End Form -->
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="<?=base_url()?>assets/js/core/popper.min.js"></script>
  <script src="<?=base_url()?>assets/js/core/bootstrap.min.js"></script>
  <script src="<?=base_url()?>assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="<?=base_url()?>assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>

    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url()?>assets/js/material-dashboard.min.js?v=3.0.2"></script>
</body>

</html>