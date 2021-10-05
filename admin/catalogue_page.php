<?php

require 'header_admin.php';
require '../models/admin.php';

// require 'models/auction.php';

// $auction = new auction();

$admin = new admin();
$auctions = $admin->getLastAuctions();
$catalogueDay = $admin->getCatalogueDetails($_GET["id"]);
$catalogueItems = $admin->getCatalogueItems($_GET["id"]);

$products = [];

foreach ($catalogueItems as $item) {
    $products[] = $admin->getAnAuction($item['item_id']);
}

$catalogueItemIDs = [];
if($catalogueItems){
    // print_r($catalogueItems);
    if(count($catalogueItems) > 0){
        foreach ($catalogueItems as $catalogue) {
            array_push($catalogueItemIDs, $catalogue['item_id']);
        }
    
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Page-->
    <title>Update Catalogue</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">

<div class="container py-5">
  <header class="text-center">
    <h1 class="display-4"><?php echo $catalogueDay['name'] ?></h1>
    <p class="font-italic mb-0"><?php echo 'Starting on '. $catalogueDay['start_date'] ?></p>
  </header>

    <!-- row starts here  -->
  <div class="row">
    <div class="col-lg-11 mx-auto">
      <div class="row py-5">

      <?php 
            for($i = 0; $i < count($products); $i++){
            ?>
                <div class="col-lg-4">
                <figure class="rounded p-3 bg-white shadow-sm">
                    <img src="../assets/uploads/<?php echo $admin->getPictureOfAuction($products[$i][0]["auction_id"]); ?>" alt="<?php echo $product[$i][0]["product_name"];?>" class="w-100 card-img-top">
                    <figcaption class="p-4 card-img-bottom">
                    <h2 class="h5 font-weight-bold mb-2 font-italic"><?php echo $products[$i][0]['product_name'] ?></h2>
                    <h2 class="h5 font-weight-bold mb-2 font-italic"><?php echo 'Price: £'. $products[$i][0]['price'] ?></h2>
                    <p class="mb-0 text-small text-muted font-italic"><?php echo $products[$i][0]['description'] ?></p>
                    </figcaption>
                </figure>
                </div>
                <?php
                    }
                ?>

      </div>


      </div>
    </div>
    <!-- row ends here  -->

    <div>
        <form class="my-2" action="downloadpdf.php?id=<?php echo $_GET['id'] ?>" method="POST">
            <button id="add-button" name="download" type="submit" class="btn btn-lg btn-info btn-block">
                <i class="fa fa-download fa-lg"></i>&nbsp;
                <span id="payment-button-amount">Download pdf</span>
                <span id="payment-button-sending" style="display:none;">Sending…</span>
            </button>
        </form>
    </div>

  </div>
</div>


    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->

<?php
// require_once __DIR__ . '../../vendor/autoload.php';

// if (isset($_POST['download'])) {
//     ob_start();
//     ob_end_flush();
//     echo 'downloading';
//     $mpdf = new \Mpdf\Mpdf();
//     $mpdf->WriteHTML('<h1>Hello world!</h1>');
//     $mpdf->Output('mpdf.pdf', 'D');
// }

?>