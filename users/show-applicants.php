<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

if(!isset($_SESSION['type']) AND $_SESSION['type'] !== 'Company' ){
  header("location:../index.php");
 }
if(isset($_GET['id'])){
  $id = $_GET['id']; 
  if($_SESSION['id'] !== $id){
      header("location:../index.php");
     }
  $select = $conn->query("SELECT * FROM users WHERE id = '$id'");
  $select -> execute();
  $profile = $select -> fetch(PDO::FETCH_OBJ);

  // jobs created by this compnay
  $jobs = $conn -> query("SELECT * FROM jobs WHERE company_id = '$id' AND status = 1 LIMIT 5");
  $jobs -> execute();
  $moreJobs = $jobs -> fetchAll(PDO::FETCH_OBJ);

  // Grapping saved jobs
  $saved_jobs = $conn->query("SELECT jobs.id AS id, jobs.company_image AS company_image, jobs.company_name AS company_name, jobs.job_region AS job_region, jobs.job_type AS job_type, jobs.job_title AS job_title FROM jobs JOIN saved ON jobs.id = saved.job_id WHERE worker_id ='$id'");
  $saved_jobs -> execute();
  $jobs1 = $saved_jobs->fetchAll(PDO::FETCH_OBJ);

  $getApplicants = $conn-> query("SELECT * FROM job_application WHERE worker_id = '14'");
  $getApplicants->execute();
  $getApplicant = $getApplicants->fetchAll(PDO::FETCH_OBJ);
  // echo $getApplicant->job_titlbe;
    }else{
      echo "404";
    }
?>
<section class="section-hero overlay inner-page bg-image" style="background-image: url('<?php echo APPURL; ?>/images/hero_1.jpg');" id="home-section">
      <div class="container">
        <div class="row">
          <div class="col-md-7">
            <h1 class="text-white font-weight-bold"><?php echo $profile-> username; ?></h1>
            <div class="custom-breadcrumbs">
              <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
              <span class="text-white"><strong><?php echo $profile-> username; ?></strong></span>
            </div>
          </div>
        </div>
      </div>
</section>

<section class="site-section">
      <div class="container">
        <ul class="job-listings mb-5">
          <?php foreach($getApplicant as $jobApp): ?>
            <li style="widht:100px; height: 100px" class="d-block d-sm-flex pb-3 pb-sm-0 align-items-center">
                <div class="job-listing-logo">
                <img style="widht:100px; height: 100px" src="user-images/<?php echo $_SESSION['image']; ?>" alt="Free Website Template by Free-Template.co" class="img-fluid">
                </div>

                <div class="d-sm-flex custom-width w-100 justify-content-between mx-4">
                <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                    <h2><?php echo $jobApp->job_title; ?></h2>
                    <strong></strong>
                </div>


                <div class="job-listing-meta">
                    <a style="text-decoration: none;" class="" href="<?php echo APPURL; ?>/users/public-profile.php?id=<?php echo $jobApp->worker_id; ?>"><h2><?php echo $jobApp->email; ?></h2></a>
                </div>

                <div class="job-listing-meta">
                <a class="btn btn-success text-white" href="#" role="button" download>Download CV</a>
                </div>
                </div>
                
            </li>
            <?php endforeach; ?>
          <br>
          
      </ul>
    </div>
</section>

<?php require "../includes/footer.php"; ?>
