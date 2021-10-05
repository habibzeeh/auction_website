<?php
if (!isset($_SESSION)) {
	session_start();
}

require 'header.php';

require 'models/auction.php';
$user_id = $_GET["user_id"];

$auction = new auction();
$latestAuctions = $auction->getUserAuctions($user_id);
$productUser =  $auction->getUser($user_id);
$userRating = (int)$auction->getUserRating($user_id);

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
	.checked {
		color: orange;
	}
</style>

<main>
	<h1><?php echo $auction->getUserName($user_id); ?></h1>
	<?php for($i =0 ;$i<5;$i++) { ?>
	<span class="fa fa-star <?php echo $userRating >$i ? "checked" : ""; ?> "></span>
	<?php } ?>

	<ul class="productList">

		<?php foreach ($latestAuctions as $la) : ?>
			<li>
				<img src="assets/uploads/<?php echo $auction->getPictureOfAuction($la["auction_id"]); ?>" alt="<?php echo $la["product_name"]; ?>">
				<article>
					<h2><?php echo $la["product_name"]; ?></h2>
					<h3><?php echo $auction->getCategoryName($la["category_id"]); ?></h3>
					<p><?php echo $la["description"]; ?></p>

					<p class="price">Current bid: £<?php echo $la["price"]; ?></p>
					<a href="productdetails.php?id=<?php echo $la["auction_id"]; ?>" class="more">More &gt;&gt;</a>
				</article>
			</li>
		<?php endforeach; ?>
	</ul>

	<footer>
		&copy; fotheby 2021
	</footer>
</main>
</body>

</html>