<?php

$SERVER_PATH = "http://localhost/ass1/";

// $pagename='';

if(!isset($_SESSION)){
	session_start();
}
require 'config.php';
// $loginout = 'login';
?>
<?php

// if (isset ($_SESSION ['userloggedin'])){
// echo 'you are logged in';
// echo '<p><a href = "logout.php"> Logout </a></p>';

//  }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Fotheby's Auctions</title>
		 <meta charset="UTF-8" />
		<link rel="stylesheet" href="<?php echo $SERVER_PATH; ?>assets/css/ibuy_main.css" />
		    <!-- Bootstrap CSS-->
			<link href="admin/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
	</head>

	<body>



		<header>

			<h1><span class="i">f</span><span class="b">o</span><span class="u">t</span><span class="y">h</span><span class="i">e</span><span class="b">b</span><span class="u">y</span></h1>

			<form action="<?php echo $SERVER_PATH?>search_products.php"  method="GET">
				<input type="text" name="keyword" id="keyword" placeholder="Search for anything" />
				<input type="submit" name="submit" value="Search" />
				<?php
				if(!isset($_SESSION['user']))
			{
				echo '<a class="btn btn-lg btn-info" href="newlogin.php" >Log in</a>';
			}
			else{

				echo '<a  href="controller.php?page=profile">' .$_SESSION['user']["full_name"] ."  </a><br>" .'<a  href="'.$SERVER_PATH.'logout.php" > Log out </a>';



			}
				
			?>
				<!-- login -->
				
			</form>
		</header>

		<img src="<?php echo $SERVER_PATH; ?>assets/images/randombanner.php" alt="Banner" />


		<nav>
			<ul>

			<?php
			$querys = $pdo -> query ('SELECT * FROM categories');
			foreach ($querys as $list) {
				$cName = $list ['categories_name'];
				//echo '<li><a href="categories.php?page=category&categoryid=' . $list['categories'] . '">' . $cName . '</a></li>';
				?>
				<li><a href="<?php echo $SERVER_PATH; ?>category_products.php?id=<?php echo $list['categories_id'];?>"><?php echo $cName;?> </a></li>
				<?php
				}
			?>
			</ul>
		</nav>
