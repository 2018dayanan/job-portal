<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php 
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    // Getting Single job info
    $select = $conn-> query("SELECT * FROM jobs WHERE id ='$id'");
    $select ->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);


    // Getting Related jobs
    $related_jobs = $conn-> query("SELECT * FROM jobs WHERE job_category = '$row->job_category' AND status = 1 AND id !='$id'");
    $related_jobs -> execute();
    $related_job = $related_jobs -> fetchALL(PDO::FETCH_OBJ);

    // Getting count of related jobs
    $job_count = $conn-> query("SELECT COUNT(*) as job_count FROM jobs WHERE job_category = '$row->job_category' AND status = 1 AND id !='$id'");
    $job_count -> execute();
    $job_num = $job_count -> fetch(PDO::FETCH_OBJ);
  }else{
    header("location: ".APPURL."/404.php");
  }
  // Applying for job
  if(isset($_POST['submit_application'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $cv = $_POST['cv'];
    $worker_id = $_POST['worker_id'];
    $job_id = $_POST['job_id'];
    $job_title = $_POST['job_title'];
    $company_id = $_POST['company_id'];
 
    $insert = $conn->prepare("INSERT INTO job_application (username, email, cv, worker_id, job_id, job_title, company_id) 
    VALUES (:username, :email, :cv, :worker_id, :job_id, :job_title, :company_id)");
    $insert->execute([
        ':username' => $username,
        ':email' => $email,
        ':cv' => $cv,
        ':worker_id' => $worker_id,
        ':job_id' => $job_id,
        ':job_title' => $job_title,
        ':company_id' => $company_id
    ]);
 
        echo "<script>alert('Application sent successfully')</script>";
 
  
        header("location:".APPURL."/jobs/job-single.php?id=".$id."");
 }
 
 
//  saving jobs


 if(isset($_SESSION['id'])){
  //  checking for worker application   

   $checking_for_application = $conn->query("SELECT * FROM job_application WHERE worker_id = '$_SESSION[id]' AND job_id ='$id'");
   $checking_for_application ->execute(); 
   
  // checking for save job

   $checking_for_saved_jobs = $conn -> query("SELECT * FROM saved WHERE worker_id = '$_SESSION[id]' AND job_id = '$id'");
   $checking_for_saved_jobs->execute();
 }

// Getting Categories
$categories = $conn->query("SELECT * FROM categories");
$categories->execute();
$AllCategories = $categories->fetchALL(PDO::FETCH_OBJ);
?>

    <!-- HOME -->
    <section class="section-hero overlay inner-page bg-image" style="background-image: url('../images/hero_1.jpg');" id="home-section">
      <div class="container">
        <div class="row">
          <div class="col-md-7">
            <h1 class="text-white font-weight-bold"><?php echo $row->job_title; ?></h1>
            <div class="custom-breadcrumbs">
              <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
              <a href="#">Job</a> <span class="mx-2 slash">/</span>
              <span class="text-white"><strong><?php echo $row->job_title; ?></strong></span>
            </div>
          </div>
        </div>
      </div>
    </section>

    
    <section class="site-section">
      <div class="container">
        <div class="row align-items-center mb-5">
          <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="d-flex align-items-center">
              <div class="border p-2 d-inline-block mr-3 rounded">
                <img src="../users/user-images/<?php echo $row->company_image; ?>" alt="Image" class="img-fluid" width="100">
              </div>
              <div>
                <h2><?php echo $row->job_title; ?></h2>
                <div>
                  <span class="ml-0 mr-2 mb-2"><span class="icon-briefcase mr-2"></span><?php echo $row->company_name; ?></span>
                  <span class="m-2"><span class="icon-room mr-2"></span><?php echo $row->job_region; ?></span>
                  <span class="m-2"><span class="icon-clock-o mr-2"></span><span class="text-primary"><?php echo $row->job_type; ?></span></span>
                </div>
              </div>
            </div>
          </div>
    
        <div class="row mt-3">
          <div class="col-lg-8">
            <div class="mb-5">
              <figure class="mb-5"><img src="../images/job_single_img_1.jpg" alt="Image" class="img-fluid rounded"></figure>
              <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-align-left mr-3"></span>Job Description</h3>
              <p>
              <?php echo $row->job_description; ?>
              </p>
            </div>
            <div class="mb-5">
              <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-rocket mr-3"></span>Responsibilities</h3>
              <ul class="list-unstyled m-0 p-0">
                <li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span><span>
                <?php echo $row->responsibilities; ?>
                </span></li>
              </ul>
            </div>

            <div class="mb-5">
              <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-book mr-3"></span>Education + Experience</h3>
              <ul class="list-unstyled m-0 p-0">
                <li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span><span><?php echo $row->education_experience; ?></span></li>
                
              </ul>
            </div>

            <div class="p-5">
              <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-turned_in mr-3"></span>Other Benifits</h3>
              <ul class="list-unstyled m-0 p-0">
                <li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span><span><?php echo $row->other_benifits; ?></span></li>
          
              </ul>
            </div>
               <?php if(isset($_SESSION['username'])) : ?>
              <?php if(isset($_SESSION['type']) AND $_SESSION['type'] == "Worker") : ?>
            <div class="">
              <div class="row">

              <!-- save -->
                <?php if($checking_for_saved_jobs->rowCount() == 0): ?>
                 <div class="col-6">
                    <a href="job-save.php?job_id=<?php echo $id; ?>&worker_id=<?php echo $_SESSION['id'];?>=&status=save" name="submit_save" type="submit" class="btn btn-light col-12" style="padding:13px;margin-top:15px;"><i class="icon-heart"></i>Save Job</a>
                   </div>
                   <?php else: ?>
                    <div class="col-6">
                    <a href="job-save.php?job_id=<?php echo $id; ?>&worker_id=<?php echo $_SESSION['id'];?>=&status=delete" name="submit_save" type="submit" class="btn btn-light col-12 text-danger" style="padding:13px;margin-top:15px;"><i class="icon-heart text-red"></i>UnSave Job</a>
                   </div>
                   <?php endif; ?>
             
                <!-- saved end -->



                <!--add text-danger to it to make it read-->
                <?php if($checking_for_application->rowCount() ==0) : ?> 
                <!-- Form Started -->
                <form class="col-6" action="job-single.php?id=<?php echo $id; ?>" method="post">
                    <!--job details-->
                  <div class="form-group">
                    <input type="hidden" value="<?php echo $_SESSION['username']; ?>" name="username" class="form-control" id="" placeholder="Username">
                  </div>
                  <div class="form-group">
                  <input type="hidden" value="<?php echo $_SESSION['email']; ?>" name="email" class="form-control" id="" placeholder="Email">

                  </div>
                  <div class="form-group">
                  <input type="hidden" name="cv" value="<?php echo $_SESSION['cv']; ?>" class="form-control" id="" placeholder="CV">

                  </div>
                  <div class="form-group">
                  <input type="hidden" name="worker_id" value="<?php echo $_SESSION['id']; ?>" class="form-control" id="" placeholder="Worker ID">

                  </div>
                  <div class="form-group">
                  <input type="hidden" name="job_id" value="<?php echo $id; ?>" class="form-control" id="" placeholder="Job ID">

                  </div>
                  <div class="form-group">
                  <input type="hidden" name="job_title" value="<?php echo $row->job_title; ?>" class="form-control" id="" placeholder="Job Title">

                  </div>
                  <div class="form-group">
                  <input type="hidden" name="company_id" value="<?php echo $row->company_id; ?>" class="form-control" id="" placeholder="Company ID">
            

                  </div>

                  <div class="form-group">
                  <input type="submit" name="submit_application" class="btn btn-block btn-primary btn-md" value="Apply Now">
                </div>
              </form>

              <?php else: ?>
        <h3 class="text-info">You Applied for this job</h3>
                <?php endif; ?>
              
              
              </div>


            
              </div>

            <?php endif; ?>
            <?php else: ?>
            <b>Login so you can apply for this job</b>



            <?php endif; ?>
          

            <!-- Delete -->
            <?php if(isset($_SESSION['username'])) : ?>
              <?php if(isset($_SESSION['type']) AND $_SESSION['type'] == "Company") : ?>
                <?php if(isset($_SESSION['id']) AND $_SESSION['id'] == $row->company_id) : ?>
            <div class="row mb-5">
              <div class="col-6">
                <a href="<?php echo APPURL; ?>/jobs/update-job.php?id=<?php echo $row->id; ?>" class="btn btn-block btn-light btn-md"></i>Update</a>
                <!--add text-danger to it to make it read-->

              </div>
              <div class="col-6">
                <a href="<?php echo APPURL; ?>/jobs/job-delete.php?id=<?php echo $row->id; ?>" class="btn btn-block btn-danger btn-md ">Delete Now</a>
              </div>
            </div>
            <?php endif; ?>
            <?php endif; ?>
              <?php endif; ?> 
          </div>
          <div class="col-lg-4">
            <div class="bg-light p-3 border rounded mb-4">
              <h3 class="text-primary  mt-3 h5 pl-3 mb-3 ">Job Summary</h3>
              <ul class="list-unstyled pl-3 mb-0">
                <li class="mb-2"><strong class="text-black">Published on: </strong> <?php echo date( 'M',(strtotime($row->created_at)))."-" .date( 'D',(strtotime($row->created_at)))."-".date( 'Y',(strtotime($row->created_at)));  ?></li>
                <li class="mb-2"><strong class="text-black">Vacancy: </strong> <?php echo $row->vacancy; ?></li>
                <li class="mb-2"><strong class="text-black">Employment Status: </strong> <?php echo $row->job_type; ?></li>
                <li class="mb-2"><strong class="text-black">Experience: </strong> <?php echo $row->experience; ?></li>
                <li class="mb-2"><strong class="text-black">Job Location: </strong><?php echo $row->job_region; ?></li>
                <li class="mb-2"><strong class="text-black">Salary: </strong><?php echo $row->salary; ?></li>
                <li class="mb-2"><strong class="text-black">Gender: </strong><?php echo $row->gender; ?></li>
                <li class="mb-2"><strong class="text-black">Application Deadline: </strong> <?php echo $row->application_deadline; ?></li>
                <li class="mb-2"><strong class="text-black">Job Category: </strong><?php echo ucfirst($row->job_category); ?></li>
              </ul>
          </div>

            <div class="bg-light p-3 border rounded">
              <h3 class="text-primary  mt-3 h5 pl-3 mb-3 ">Share</h3>
              <div class="px-3">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo APPURL; ?>/jobs/job-single.php?id=<?php echo $row->id;?>&quote=<?php echo $row->job_title; ?>" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-facebook"></span></a>
                <a href="https://twitter.com/intent/tweet?text=<?php echo $row->job_title; ?>&url=<?php echo APPURL; ?>/jobs/job-single.php?id=<?php echo $row->id;?>" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-twitter"></span></a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo APPURL; ?>/jobs/job-single.php?id=<?php echo $row->id;?>" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-linkedin"></span></a>
              </div>
            </div>
            <!-- Categories-->
           
            <div class="bg-light p-3 border rounded mt-4">
              <h3 class="text-primary  mt-3 h5 pl-3 mb-3 ">Categories</h3>
              <ul class="list-unstyled pl-3 mb-0">
                <?php foreach ($AllCategories as $category ) : ?>
                <a target="_blank" href="<?php echo APPURL; ?>/categories/show-jobs.php?name=<?php echo ucfirst($category-> name); ?>"><li class="mb-2"><strong class="text-black"><?php echo $category->name; ?></strong></li></a>
                <?php endforeach; ?>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section class="site-section" id="next">
      <div class="container">

        <div class="row mb-5 justify-content-center">
          <div class="col-md-7 text-center">
            <h2 class="section-title mb-2"><?php echo $job_num ->job_count; ?> Related Jobs</h2>
          </div>
        </div>
        
        <ul class="job-listings mb-5">
          <?php foreach($related_job as $job) : ?>
        
          <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center">
            <a href="<?php echo APPURL; ?>/jobs/job-single.php?id=<?php echo $job-> id; ?>"></a>
            <div class="job-listing-logo">
              <img src="../users/user-images/<?php echo $job-> company_image; ?>" alt="Image" class="img-fluid">
            </div>

            <div class="job-listing-about d-sm-flex custom-width w-100 justify-content-between mx-4">
              <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                <h2><?php echo $job-> job_title; ?></h2>
                <strong><?php echo $job-> company_name; ?></strong>
              </div>
              <div class="job-listing-location mb-3 mb-sm-0 custom-width w-25">
                <span class="icon-room"></span><?php echo $job-> job_region; ?>
              </div>
              <div class="job-listing-meta">
                <span class="badge badge-<?php if($job->job_type == 'Part Time'){echo 'danger';} else {echo 'success';}; ?>"><?php echo $job-> job_type; ?></span>
              </div>
            </div>
            
          </li>  
          <?php endforeach; ?>
        </ul>

     

      </div>
    </section>
    

  
    
<?php require "../includes/footer.php"; ?>
    