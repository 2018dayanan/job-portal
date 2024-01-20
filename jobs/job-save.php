<?php

include '../config/config.php';


if (isset($_GET['job_id']) && isset($_GET['worker_id']) && isset($_GET['status'])) {
    $job_id = $_GET['job_id'];
    $worker_id = $_GET['worker_id'];
    $status = $_GET['status'];

    if ($status == 'save') {
        $insert = $conn->prepare("INSERT INTO saved (job_id, worker_id) VALUES (:job_id, :worker_id)");
        $insert->execute([
            ':job_id' => $job_id,
            ':worker_id' => $worker_id,
        ]);
    header("location:../jobs/job-single.php?id=" . $job_id."");

    } else {
        $delete = $conn->prepare("DELETE FROM saved WHERE job_id = :job_id AND worker_id = :worker_id");
        $delete->execute([
            ':job_id' => $job_id,
            ':worker_id' => $worker_id,
        ]);
    header("location:../jobs/job-single.php?id=" . $job_id."");

    }

}
?>
