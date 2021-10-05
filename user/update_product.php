
<?php

require 'header_user.php';
require '../models/auction.php';

$auction = new auction();
$produst = $auction->getAuctionDetails($_GET["id"]);
$categories = $auction->getCategories();
$images = $auction->getPictures($_GET["id"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Page-->
    <title>Update Auction</title>

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
    <div class="page-wrapper">



        <!-- PAGE CONTAINER-->
        <div class="page-container">

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">Update Auction Details</div>
                                    <div class="card-body">
                                        <form action="../controller.php?page=update_auction" method="post" novalidate="novalidate">
                                        <input id="id" name="id" type="hidden" value="<?php echo $produst['auction_id']; ?>"/>
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Name</label>
                                                <input id="name" name="name" type="text" value="<?php echo $produst['product_name']; ?>" class="form-control" aria-required="true" aria-invalid="false">
                                            </div>

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Description</label>
                                                <textarea name="description" id="Description" rows="6" placeholder="Description..." class="form-control"><?php echo $produst['description']; ?></textarea>
                                                </div>

                                                <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectLg" class=" form-control-label">Select Category</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="category" id="category" class="form-control-lg form-control">
                                                        <option value="0">Please select</option>
                                                        <?php foreach($categories as $category): ?>
                                                            <option value="<?php echo $category["categories_id"];?>" <?php if($category["categories_id"] == $produst["category_id"]){ echo "selected";} ?> ><?php echo $category["categories_name"];?></option>
                                                            <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">End Date</label>
                                                <input id="date" name="date" type="date" value="<?php echo $produst['endtime']; ?>" class="form-control" aria-required="true" aria-invalid="false">
                                            </div>

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Price</label>
                                                <input id="price" name="price" type="number" min="0.0" step="0.1"  value="<?php echo $produst['price']; ?>" class="form-control" aria-required="true" aria-invalid="false">
                                            </div>

                                            <div class="container">
                                                <div class="row">

                                                <?php foreach($images as $image): ?>

                                                <div class="card col-3">
                                                    <img class="card-img-top" src="../assets/uploads/<?php echo $image["name"];?>" alt="Card image cap">
                                                    <div class="card-body">
                                                    <button type="button"  onclick="location.href = '../controller.php?page=delete_picture&id=<?php echo  $image['id'] . '&pid=' . $_GET['id']; ?>';" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </div>

                                                <?php endforeach; ?>

                                                </div>
                                            </div>

                                            
                                        
                                        
                                            <div>
                                                <button id="add-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                    <i class="fa fa-shopping-cart fa-lg"></i>&nbsp;
                                                    <span id="payment-button-amount">Update Auction</span>
                                                    <span id="payment-button-sending" style="display:none;">Sending…</span>
                                                </button>
                                            </div>
                                        </form>

                                        <div class="input-group"  <?php echo count($images) == 5 ?  "hidden" : "";?>>
                                            <form action = '../controller.php?page=add_picture&pid=<?php echo $_GET['id']; ?>' method="post" enctype="multipart/form-data">
                    
                                                        <input accept="image/*" type="file" id="photo" name="photo" class="form-control">
                                                        <div class="input-group-btn">
                                                        <button type="submit" type="button" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Add </button>
                                                        </div>
                                            </form>
                                                
                                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
