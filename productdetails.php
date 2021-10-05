<?php

require 'header.php';
require 'models/auction.php'; 
require 'models/bid.php'; 

$id = $_GET["id"];

if(isset($_GET["error"]) ){

    if($_GET["error"] == 1){
    $message = "higer bid needed";
    }

    if($_GET["error"] == 2){
        $message = "Please Login..";
		}
	



echo "<script type='text/javascript'>alert('$message');</script>";
}

$auction = new auction();
$bid = new bid();
$product = $auction->getAuctionDetails($id);
$images = $auction->getPictures($id);
$productUser =  $auction->getUser($product["user_id"]);
$currentBid = $bid->currentBid($id);
$productPicture = $auction->getPictureOfAuction($id);
$reviews = $auction->getReviews($id);


$seconds = strtotime($product["endtime"]) - time();

$days = floor($seconds / 86400);

$remaningText = $days . " days";


if($days <1){

    $seconds %= 86400;

    $hours = floor($seconds / 3600);
    $seconds %= 3600;

    $minutes = floor($seconds / 60);

    $remaningText = $hours . " hours " . $minutes . " minutes";

}



?>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

<style>


div.stars {
  width: 270px;
  display: inline-block;
}

input.star { display: none; }

label.star {
  float: right;
  padding: 10px;
  font-size: 36px;
  color: #444;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\f005';
  color: #FD4;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color: #FE7;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\f006';
  font-family: FontAwesome;
}

</style>

<main>

<h1>Product Page</h1>
<article class="product">

		<img src="assets/uploads/t_<?php echo $productPicture;?>" alt="<?php echo $product["product_name"]; ?>">
		<section class="details">
			<h2><?php echo $product["product_name"]; ?></h2>
			<h3><?php echo $auction->getCategoryName($product["category_id"]); ?></h3>
			<p>Auction created by <a href="user_products.php?user_id=<?php echo $productUser["user_id"];?>"><?php echo $productUser["first_name"] ." ". $productUser["last_name"] ?></a></p>
			
			<?php if($seconds > 0 && $product["status"]!=2){ ?>
				<p class="price">Current bid: £<?php echo $currentBid; ?></p>

			<time>Time left: <?php echo $remaningText; ?></time>
            <form action="controller.php?page=place_bid&pid=<?php echo $_GET["id"];?>" class="bid" method="post">
				<input type="number" id="amount" name="amount" step="0.1" placeholder="Enter bid amount" />
				<input type="number" id="current" name="current" value="<?php echo $currentBid; ?>" hidden />
				<input type="submit" value="Place bid" />
			</form>

			<form action="controller.php?page=buy_now&pid=<?php echo $_GET["id"];?>" class="bid" method="post">
				<input type="number" id="current" name="current" value="<?php echo $currentBid; ?>" hidden />
				<input type="submit" value="Buy Now at £<?php echo $product["price"]; ?>" />
			</form>
			<?php }
			else{
			echo '<p class="price">Sold</p>';}?>
			
		</section>
		<section class="description">
		<p><?php echo $product["description"]; ?></p>


		</section>

		<section class="reviews">
			<h2>Reviews of <?php echo $productUser["first_name"] .".". $productUser["last_name"] ?></h2>
			<ul>
			<?php foreach($reviews as $review): ?>
				<li>
					<strong><?php echo $auction->getUserName($review["user_id"]); ?> </strong>
				 <?php echo $review["text"]; ?>
				 <em> <?php
				 $tt = strtotime($review["date"]);
				 echo date('d-m-Y',$tt); ?></em></li>
			<?php endforeach;?>
			</ul>

			<form action="controller.php?page=post_review&pid=<?php echo $_GET["id"];?>" method = "POST">
				<label>Add your review</label> <textarea name="reviewtext"></textarea>

				<input type="submit" name="add" value="Add Review" />
			</form>


			<form action="controller.php?page=post_rating&pid=<?php echo $_GET["id"];?>&user_id=<?php echo $productUser["user_id"];?>" method = "POST">
  Rating:<select id ="rating" name="rating">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
</select>
<input type="submit" name="Rate" value="Rate User" />
</form>
<br>
</body>
			
	
		</section>
        </article>
        <hr />
<footer>
	&copy; ibuy 2019
</footer>
        </main>
	</body>
</html>