<?php //include "../config/config.php"; ?>
<?php session_start(); 
define("APPURL","http://localhost/joboard");
?>
<!doctype html>
<html lang="en">
  <head>
    <title>JobBoard &mdash; Website Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Free-Template.co" />
    <link rel="shortcut icon" href="ftco-32x32.png">
    
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/custom-bs.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/fonts/icomoon/style.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/fonts/line-icons/style.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/animate.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/quill.snow.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/style.css">    
  </head>
  <body id="top">

  <!-- <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div> -->
    

<div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    

    <!-- NAVBAR -->
    <header class="site-navbar mt-3">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="site-logo col-6"><a href="<?php echo APPURL; ?>">JobBoard</a></div>

          <nav class="mx-auto site-navigation">
            <ul class="site-menu js-clone-nav d-xl-block ml-0 pl-0">
              <li><a href="<?php echo APPURL; ?>" class="nav-link active">Home</a></li>
              <!-- <li><a href="<?php// echo APPURL; ?>/about.php">About</a></li> -->
              
           
             
            
              <li><a href="<?php echo APPURL; ?>/contact.php">Contact</a></li>
              <li><a href="<?php echo APPURL; ?>/gerneral/workers.php">Workers</a></li>
              <li><a href="<?php echo APPURL; ?>/gerneral/companies.php">Companies</a></li>
              
              <?php if(isset($_SESSION['username'])) : ?>
                <?php if(isset($_SESSION['type']) AND $_SESSION['type'] == "Company") :?>
                <li class="d-lg-inline"><a href="<?php echo APPURL; ?>/jobs/post-job.php"><span class="mr-2">+</span> Post a Job</a></li>
                <?php endif; ?>
                <li class="dropdown nav-item">
                  <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['username']; ?>
                    <i class="fa-solid fa-caret-down pl-1"></i>
                  </a>
  
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      
                      <a class="dropdown-item" href="<?php echo APPURL; ?>/users/public-profile.php?id=<?php echo $_SESSION['id']; ?>">Public Profile</a>
                      <a class="dropdown-item" href="<?php echo APPURL; ?>/users/update-profile.php?upd_id=<?php echo $_SESSION['id']; ?>">Update Profile</a>
                      <?php if(isset($_SESSION['type']) AND $_SESSION['type'] == 'Worker') : ?>
                      <a class="dropdown-item" href="<?php echo APPURL; ?>/users/saved_jobs.php?id=<?php echo $_SESSION['id']; ?>">Saved Job</a>
                      <?php endif; ?>
                      <?php if(isset($_SESSION['type']) AND $_SESSION['type'] == 'Company') : ?>
                      <a class="dropdown-item" href="<?php echo APPURL; ?>/users/show-applicants.php?id=<?php echo $_SESSION['id']; ?>">Show Applicants</a>
                      <?php endif; ?>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="<?php echo APPURL; ?>/auth/logout.php">Logout</a>
                    </div>
                </li>

              <?php else: ?>
              <li class="d-lg-inline"><a href="<?php echo APPURL; ?>/auth/login.php">Log In</a></li>
              <li class="d-lg-inline"><a href="<?php echo APPURL; ?>/auth/register.php">Register</a></li>

              <?php endif; ?>
            </ul>
              </nav>
        </div>
      </div>
    </header>