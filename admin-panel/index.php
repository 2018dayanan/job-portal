<?php require "layouts/header.php"; ?>   
<?php require "../config/config.php"; ?>
<?php
  // jobs count
  $jobs = $conn->query("SELECT COUNT(*) AS count_jobs FROM jobs");
  $jobs->execute();
  $countjobs=$jobs->fetch(PDO::FETCH_OBJ);

  // category count
  $jobs = $conn->query("SELECT COUNT(*) AS count_categories FROM categories");
  $jobs->execute();
  $countcategories=$jobs->fetch(PDO::FETCH_OBJ);

  // admin count
  $jobs = $conn->query("SELECT COUNT(*) AS count_admins FROM admins");
  $jobs->execute();
  $countadmins=$jobs->fetch(PDO::FETCH_OBJ);


?> 
<div class="row">

  <div class="col-md-4">
    <div class="card">
            <div class="card-body">
              <h5 class="card-title">Jobs</h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">number of jobs: <?php echo $countjobs->count_jobs; ?></p>
             
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Categories</h5>
              
              <p class="card-text">number of categories: <?php echo $countcategories->count_categories; ?></p>
              
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admins</h5>
              
              <p class="card-text">number of admins: <?php echo  $countadmins->count_admins; ?></p>
              
            </div>
          </div>
        </div>
      </div>

      <?php require "layouts/footer.php"; ?>    

