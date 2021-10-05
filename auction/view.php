<?php

require '../header.php';
require '../models/auction.php';

$id = $_GET["id"];

$auction = new auction();
$product = $auction->getAuctionDetails($id);
$images = $auction->getPictures($id);



?>


<link rel="stylesheet"  href="css/lightslider.css"/>
    <style>
    	ul{
			list-style: none outside none;
		    padding-left: 0;
            margin: 0;
		}
        .demo .item{
            margin-bottom: 60px;
        }
		.content-slider li{
		    background-color: #ed3020;
		    text-align: center;
		    color: #FFF;
		}
		.content-slider h3 {
		    margin: 0;
		    padding: 70px 0;
		}
		.demo{
			width: 800px;
		}
    </style>
    <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/lightslider.js"></script> 
    <script>
    	 $(document).ready(function() {
			$("#content-slider").lightSlider({
                loop:true,
                keyPress:true
            });
            $('#image-gallery').lightSlider({
                gallery:true,
                item:1,
                thumbItem:9,
                slideMargin: 0,
                speed:500,
                auto:true,
                loop:true,
                onSliderLoad: function() {
                    $('#image-gallery').removeClass('cS-hidden');
                }  
            });
		});
    </script>

    <h1> <?php echo $product["product_name"]; ?></h1>



<div class="demo">
        <div class="item">            
            <div class="clearfix" style="max-width:474px;">
                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">

                         <?php foreach ($images as $image): ?>
                            <li data-thumb="<?php echo $SERVER_PATH . "assets/uploads/t_" . $image["name"]?>"> 
                            <img src="<?php echo $SERVER_PATH . "assets/uploads/" . $image["name"]?>" />
                         </li>
                         <?php endforeach; ?>
                </ul>
            </div>
        </div>
</div>


<div class="product_details">

<table>
  <tr>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Description</th>
  </tr>

  <tr>
    <td><?php echo $product["product_name"]; ?></td>
    <td><?php echo $product["product_name"]; ?></td>
    <td><?php echo $product["price"]; ?></td>
    <td><?php echo $product["description"]; ?></td>
  </tr>
  

</table>



</div>
                         </body>

