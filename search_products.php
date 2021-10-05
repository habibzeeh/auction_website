<?php 
if(!isset($_SESSION)){
	session_start();
}

require 'header.php';

require 'models/auction.php';

$keyword = $_GET["keyword"];

$auction = new auction();
$latestAuctions = $auction->getSearchAuctions($keyword);

?>
	
		<main>
		<h1>Latest Listings / Search Results / Category listing</h1>

<ul class="productList">

	<?php foreach($latestAuctions as $la): ?>
	<li>
		<img src="assets/uploads/<?php echo $auction->getPictureOfAuction($la["auction_id"]); ?>" alt="<?php echo $la["product_name"];?>">
		<article>
			<h2><?php echo $la["product_name"];?></h2>
			<h3><?php echo $auction->getCategoryName($la["category_id"]);?></h3>
			<p><?php echo $la["description"];?></p>

			<p class="price">Current bid: £<?php echo $la["price"];?></p>
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