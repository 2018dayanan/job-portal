<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php
    $select= $conn->query("SELECT * FROM users WHERE type = 'worker'");
    $select->execute();
    $allWorkers = $select->fetchAll(PDO::FETCH_OBJ);
?>

<section class="section-hero overlay inner-page bg-image" style="background-image: url('../images/hero_1.jpg');" id="home-section">
      <div class="container">
        <div class="row">
          <div class="col-md-7">
            <h1 class="text-white font-weight-bold">Workers</h1>
            <div class="custom-breadcrumbs">
              <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
              <span class="text-white"><strong>Workers</strong></span>
            </div>
          </div>
        </div>
      </div>
</section>

<section class="site-section" id="home-section">
    <div class="container">
        <div class="row d-flex justify-content-center">
        <?php foreach($allWorkers as $worker) : ?>

            <div class="col-md-4 mb-4">
                <!-- card -->

                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" style="width:100%;" src="../users/user-images/<?php echo $worker-> img; ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $worker->username; ?></h5>
                        <p class="card-text"><?php echo substr($worker->bio, 0, 50); ?></p>
                        <a target="_blank" href="../users/public-profile.php?id=<?php echo $worker->id; ?>" class="btn btn-primary">Go to profile</a>
                    </div>
                </div>
               
                <!-- Card end -->
            </div>
            <?php endforeach; ?>

        </div>    
    </dvi>      

</section>
<?php require "../includes/footer.php"; ?>