<?php session_start(); ob_start();
$code = isset($_GET['cd']) ? $_GET['cd'] : header("location: index.html");
$icon = '';
$color = '';
$title = '';
$number = '';
switch($code)
{
    case 0: 
    {
        $color = '#dc0000';
        $icon = 'bi-x-circle-fill'; 
        $title = 'Error';
        $number = '#000';
    } break;

    case 1: 
    {
        $color = '#6699ff';
        $icon = 'bi-info-circle-fill'; 
        $title = 'Info';
        $number = '#001';
    } break;

    case 2: 
    { 
        $color = '#ffba00';
        $icon = 'bi-exclamation-triangle-fill'; 
        $title = 'Warning';
        $number = '#002';
    } break;
}

$message = isset($_GET['msg']) ? $_GET['msg'] : header("location: index.html");
?>
<div class="container-fluid pt-4 px-4">
    <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
        <div class="col-md-6 text-center p-4">
            <i class="bi <?php echo $icon; ?> display-1" style="color: <?php echo $color; ?>;"></i>
            <h1 class="display-1 fw-bold"><?php echo $title; ?></h1>
            <h1 class="mb-4"><?php echo $number; ?></h1>
            <p class="mb-4"><?php echo $message; ?></p>
            <a 
                class="btn btn-primary rounded-pill py-3 px-5" 
                style="border: none; background-color: <?php echo $color; ?>;" 
                href="index.php">Retour</a>
        </div>
    </div>
</div>

   <!-- Google Web Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">