<?php

require 'models/super_admin.php';
require 'models/admin.php';
require 'models/auction.php';
require 'models/bid.php';
require_once 'models/fileHandling.php';

session_start();

/**
 * to switch page and perform operations
 * Class controller
 */
class controller{

    /**
     *
     */
    public function profile(){

    if(strcmp($_SESSION["user"]["role"], "super_admin") ==  0)
{
    header ('Location: super_admin/profile.php');
}
else if(strcmp($_SESSION["user"]["role"], "admin") ==  0)
{
    header ('Location: admin/profile.php');
}
else{
    header ('Location: user/profile.php');
}

}
}

$controller = new controller();


/*use page slug to navigate to specific page*/

switch($_GET["page"]){

    case 'profile':
     $controller->profile();
    break;
    case 'add_admin':
        $data["first_name"] = $_POST["fname"];
        $data["last_name"] = $_POST["lname"];
        $data["email"] = $_POST["emal"];
        $data["password"] = $_POST["password"];
        $super_admin = new super_admin();
        $super_admin->createAdmin($data);
        header ('Location: super_admin/profile.php');
    break;

    case 'update_admin':
        $data["id"] = $_POST["id"];
        $data["first_name"] = $_POST["fname"];
        $data["last_name"] = $_POST["lname"];
        $data["email"] = $_POST["email"];
        $super_admin = new super_admin();
        $super_admin->updateAdmin($data);
        header ('Location: super_admin/profile.php');
    break;

    case 'delete_admin':
        $super_admin = new super_admin();
        $super_admin->deleteAdmin($_GET["id"]);
        header ('Location: super_admin/profile.php');
    break;


    case 'add_category':
        $admin = new admin();
        $admin->createCategory($_POST["name"]);
        header ('Location: admin/profile.php');
    break;


    case 'add_catalogues':
        $admin = new admin();
        $admin->createCatalogue($_POST["name"], $_POST['start_date']);
        header ('Location: admin/catalogues.php');
    break;

    case 'update_category':
        $admin = new admin();
        $data["id"] = $_POST["id"];
        $data["name"] = $_POST["name"];
        $admin->updateCategory($data);
        header ('Location: admin/profile.php');
    break;

    case 'update_catalogue':
        $admin = new admin();
        $data["id"] = $_POST["id"];
        $data["name"] = $_POST["name"];
        $data["start_date"] = $_POST["start_date"];
        $admin->updateCatalogue($data);
        header ('Location: admin/catalogues.php');
    break;

    case 'delete_category':
        $admin = new admin();
        $admin->deleteCategory($_GET["id"]);
        header ('Location: admin/profile.php');
    break;

    case 'delete_catalogue':
        $admin = new admin();
        $admin->deleteCatalogue($_GET["id"]);
        header ('Location: admin/catalogues.php');
    break;

case 'add_auction':
    $data["Name"] = $_POST["name"];
    $data["Description"] = $_POST["description"];
    $data["SelectCategory"] = $_POST["category"];
    $data["Date"] = $_POST["date"];
    $data["Price"] = $_POST["price"];
    $auction = new auction();
    $auction->createAuction($data);
    header ('Location: user/profile.php');
break;

case 'add_to_catalogue':
    // var_dump($_POST);
    $catalogue_id = $_POST['catalogue_id'];
    $data = $_POST;
    unset($data['catalogue_id']);
    // var_dump($data);
    $admin = new admin();
    $admin->addToCatalogue($catalogue_id, $data);
    header ('Location: admin/catalogues.php');
break;

case 'catalogue_page':
    $catalogue_id = $_GET['id'];
    $admin = new admin();
    $admin->cataloguePage($catalogue_id);
    header ('Location: admin/catalogue_page.php');
break;

case 'update_auction':
    $auction = new auction();
    $data["id"] = $_POST["id"];
    $data["name"] = $_POST["name"];
    $data["description"] = $_POST["description"];
    $data["date"] = $_POST["date"];
    $data["category_id"] = $_POST["category"];
    $data["price"] = $_POST["price"];
    $auction->updateAuction($data); 
    header ('Location: user/profile.php');
break;

case 'delete_auction':
    $auction = new auction();
    $auction->deleteAuction($_GET["id"]);
    header ('Location: user/profile.php');
break;

case 'approve_product':
    $auction = new auction();
    $auction->approveAuction($_GET["id"]);
    header ('Location: admin/approval.php');
break;

case 'delete_picture':
    $auction = new auction();
    $picture = $auction->getPicture($_GET["id"]);
    $auction->deletePicture($_GET["id"]);
    $fileHandling = new fileHandling();
    $fileHandling->deleteFile($picture["name"]);
    header ('Location: user/update_product.php?id='.$_GET['pid']);
break;

case 'add_picture':
    $auction = new auction();
    $auction->savePicture($_FILES["photo"],$_GET['pid']);
    header ('Location: user/update_product.php?id='.$_GET['pid']);
break;

case 'place_bid':

    if(!isset($_SESSION["user"]["id"])){
        header ('Location: productdetails.php?error=2&id='.$_GET['pid']);
    break;
    }

    if((float)$_POST["amount"] < (float)$_POST["current"]){
    header ('Location: productdetails.php?error=1&id='.$_GET['pid']);
    break;
    }

    $bid = new bid();
    $bid->saveBid($_GET["pid"],$_POST["amount"]);
    header ('Location: productdetails.php?id='.$_GET['pid']);
break;


case 'buy_now':
    $auction = new auction();
    $auction->soldProduct($_GET["pid"]);
    $bid = new bid();
    $bid->saveBid($_GET["pid"],"-1");
    header ('Location: productdetails.php?id='.$_GET['pid']);
break;

case "post_review":
    if(!isset($_SESSION["user"]["id"])){
        header ('Location: productdetails.php?error=2&id='.$_GET['pid']);
    break;
    }
    
    $auction = new auction();
    $review["auction_id"] = $_GET['pid'];
    $review["text"] = $_POST["reviewtext"];
    $auction->postReview($review);
    header ('Location: productdetails.php?id='.$_GET['pid']);
break;

case "post_rating":
    if(!isset($_SESSION["user"]["id"])){
        header ('Location: productdetails.php?error=2&id='.$_GET['pid']);
    break;
    }
    
    $auction = new auction();
    $rating["user_id"] = $_GET['user_id'];
    $rating["rating"] = $_POST["rating"];
    $auction->postRating($rating);
    header ('Location: productdetails.php?id='.$_GET['pid']);
break;

}
