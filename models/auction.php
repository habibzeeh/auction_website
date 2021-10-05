<?php

require_once 'user.php';
require_once 'fileHandling.php';


/**
 * Class auction
 */
class auction
{

    /**
     * keep track of the current logged in user
     * @var
     */
    private $user_id;

    /**
     * store current user
     * auction constructor.
     */
    function __construct()
    {
        //session_start();
        if(isset($_SESSION["user"]["id"])){
        $this->user_id = $_SESSION["user"]["id"];
        }
    }

    /**
     * add auction by user
     * @param $addProduct
     */
    public function createAuction($addProduct)
    {
        $db = new db();
        $hf = new fileHandling();
        $stmt = $db->pdo->prepare('INSERT INTO auction (product_name, description,category_id, endtime, price, status,user_id)  VALUES (:product_name, :description,:category_id,:endtime, :price,:status,:user_id)');
        $values = [
            'product_name' => $addProduct['Name'],
            'description'  => $addProduct['Description'],
            'category_id'     => $addProduct['SelectCategory'],
            'endtime'     => $addProduct['Date'],
            'price'     => $addProduct['Price'],
            'status'     => 0,
            'user_id'     => $this->user_id

        ];
        $stmt->execute($values);
    

        $id = $db->pdo->lastInsertId();

        if(isset($_FILES["photos"]))
        {
            $photos = $hf->convertFileArray($_FILES["photos"]);
            $count = count($photos);
            for($i=0;$i<$count;$i++){
                $this->savePicture($photos[$i],$id);
            }
    
        }


    }

    /**
     * get all auction created by current logged in user to show on his profile
     * @return array
     */
    public function getAuctionsOfUser() {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM auction WHERE user_id=:user_id');
        $values = [
            'user_id' => $this->user_id
        ];
        $select->execute($values);
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
    }

    /**
     * get details of a specific auction
     * @param $id
     * @return mixed
     */
    public function getAuctionDetails($id)
    {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM auction WHERE auction_id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetch();
        return $data;
    }

    /**
     * update auction by user
     * @param $updateProduct
     */
    public function updateAuction($updateProduct)
    {
        $db = new db();
        $stmt = $db->pdo->prepare('UPDATE ass1.auction SET product_name = :product_name, description=:description,price=:price,endtime=:endtime,category_id=:category_id WHERE auction_id = :auction_id');
        $values = [
            'auction_id' => $updateProduct['id'],
            'product_name' => $updateProduct["name"],
            'description' => $updateProduct["description"],
            'price' => $updateProduct["price"],
            'endtime' => $updateProduct["date"],
            'category_id' => $updateProduct["category_id"]  
        ];
        $stmt->execute($values);
    }

    /**
     * delete auction by user
     * @param $auction_id
     */
    public function deleteAuction($auction_id)
    {

        $db = new db();
        $stmt = $db->pdo->prepare('DELETE FROM ass1.auction WHERE  auction_id = :auction_id');
        $values = ['auction_id' => $auction_id];
        $stmt->execute($values);
    }

    /**
     *approve the auction of the user by admin
     * @param $auction_id
     */
    public function approveAuction($auction_id)
    {

        $db = new db();
        $stmt = $db->pdo->prepare('UPDATE `auction` SET `status` = 1 WHERE `auction`.`auction_id` =:auction_id');
        $values = ['auction_id' => $auction_id];
        $stmt->execute($values);
    }

    /**
     * get Categories list to show in add and update auction page
     * @return array
     */
    public function getCategories() {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM categories');
        $select->execute();
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
    }

    /**
     * get single category to show in detail of auction
     * @param $id
     * @return mixed
     */
    public function getCategory($id) {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM categories WHERE categories_id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetch();
        return $data;
    }

    /**
     * get pictures of the auction
     * @param $id
     * @return array
     */
    public function getPictures($id) {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM images WHERE auction_id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
    }

    /**
     * get a single picture of the auction to show in main listing
     * @param $id
     * @return mixed
     */
    public function getPicture($id) {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM images WHERE id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetch();
        return $data;
    }

    /**
     * delete a single picture of auction
     * @param $id
     */
    public function deletePicture($id)
    {

        $db = new db();
        $stmt = $db->pdo->prepare('DELETE FROM images WHERE  id = :id');
        $values = ['id' => $id];
        $stmt->execute($values);
    }

    /**
     * save picture and bind it to the auction
     * @param $photo
     * @param $id
     */
    public function savePicture($photo, $id)
    {

        $fh = new fileHandling();
        $filename = $fh->saveFile($photo);

        $db = new db();
        $stmt = $db->pdo->prepare('INSERT INTO images (name, auction_id)  VALUES (:name, :auction_id)');
        $values = [
            'name' => $filename,
            'auction_id'  => $id

        ];
        $stmt->execute($values);

    }

    /**
     * get latest auction list of count 10 to show on main page
     * @return array
     */
    public function getLastAuctions() {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM `auction` Where status = 1 and endtime >= CURDATE() ORDER BY `timestamp` DESC LIMIT 10');
        $select->execute();
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
    }

    /**
     * get name of the category to show in auction details
     * @param $id
     * @return mixed
     */
    public function getCategoryName($id) {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM categories WHERE categories_id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetch();
        return $data["categories_name"];
    }

    /**
     * get user details to show with auction
     * @param $id
     * @return mixed
     */
    public function getUser($id) {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM users WHERE user_id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetch();
        return $data;
    }

    /**
     * get user name to show in details
     * @param $id
     * @return string
     */
    public function getUserName($id) {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM users WHERE user_id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetch();
        return $data["first_name"] . " " . $data["last_name"];
    }

    /**
     * get single picture of auction
     * @param $id
     * @return string
     */
    public function getPictureOfAuction($id) {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM images WHERE auction_id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);
        if(count($data) > 0){
            return $data[0]["name"];
        }
        return "";
    }

    /**
     * mark the product sold to some user when user click on buy button
     * @param $auction_id
     */
    public function soldProduct($auction_id)
    {
        $db = new db();
        $stmt = $db->pdo->prepare('UPDATE `auction` SET `status` = 2 WHERE `auction`.`auction_id` =:auction_id');
        $values = ['auction_id' => $auction_id];
        $stmt->execute($values);
    }

    /**
     * post a review against the auction
     * @param $review
     */
    public function postReview($review){

        $db = new db();
        $stmt = $db->pdo->prepare('INSERT INTO reviews (user_id, auction_id,text)  VALUES (:user_id, :auction_id,:text)');
        $values = [
    
            'user_id'     => $this->user_id,
            'auction_id'     => $review["auction_id"],
            'text'     => $review["text"]

        ];
        $stmt->execute($values);

    }

    /**
     * get all the reviews of the auction to show in detail page
     * @param $auction_id
     * @return array
     */
    public function getReviews($auction_id)
{
    $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM `reviews` Where auction_id=:auction_id');
        $values = [
            'auction_id'  => $auction_id
        ];
        $select->execute($values);
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;

}


    /**
     * get all auction related to a specific category
     * @param $id
     * @return array
     */
    public function getCatgoryAuctions($id) {
    $db = new db();
    $select = $db->pdo->prepare('SELECT * FROM `auction` Where status = 1 and category_id=:category_id and endtime >= CURDATE()');
    $values = [
        'category_id'  => $id
    ];
    $select->execute($values);
    $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
    return $data;
}

    /**
     * get all auction related to a keyword for searching
     * @param $keyword
     * @return array
     */
    public function getSearchAuctions($keyword) {

    $db = new db();
    $select = $db->pdo->prepare('SELECT * FROM `auction` Where status = 1 and product_name Like :keyword and endtime >= CURDATE()');
    $values = [
        'keyword'  => "%".$keyword."%"
    ];
    $select->execute($values);
    $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
    return $data;
}

    /**
     * get all auction of a user to show when clicked on the name of user
     * @param $id
     * @return array
     */
    public function getUserAuctions($id) {
    $db = new db();
    $select = $db->pdo->prepare('SELECT * FROM `auction` Where status = 1 and user_id=:user_id and endtime >= CURDATE()');
    $values = [
        'user_id'  => $id
    ];
    $select->execute($values);
    $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
    return $data;
}

    /**
     * post the rating for the user in auction detail page
     * @param $rating
     */
    public function postRating($rating){

    $db = new db();
    $stmt = $db->pdo->prepare('INSERT INTO ratings (user_id, giver_id,rating)  VALUES (:user_id, :giver_id,:rating)');
    $values = [

        'giver_id'     => $this->user_id,
        'user_id'     => $rating["user_id"],
        'rating'     => $rating["rating"]

    ];
    $stmt->execute($values);

}

    /**
     * calculate the rating of the user to show on user product page
     * @param $id
     * @return mixed
     */
    public function getUserRating($id){
    $db = new db();
    $select = $db->pdo->prepare('SELECT AVG(rating) as rating FROM `ratings` WHERE user_id=5;:id');
    $values = ['id' => $id];
    $select->execute($values);
    $data = $select->fetch();
    return $data["rating"];
}

    /**
     * find out which products are bought by the user
     * @param $user_id
     * @return array
     */
    public function getUserBuyedProducts($user_id){
    $db = new db();
    $select = $db->pdo->prepare('SELECT * FROM `auction` Where auction_id in (SELECT auction_id from bids where amount = -1 and user_id = :user_id)');
    $values = [
        'user_id'  => $user_id
    ];
    $select->execute($values);
    $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
    return $data;
}


    /**
     * find out the auction bids won by the user
     * @param $user_id
     * @return array
     */
    public function getUserWonProducts($user_id){
            $db = new db();
            $select = $db->pdo->prepare('
            
            SELECT auction.*, bids.*
            FROM   auction
            JOIN   (SELECT  auction_id, 
                 :user_id AS user_id, 
                 MAX(amount) AS highest_value,
                 MAX(CASE user_id WHEN :user_id THEN amount END) AS highest_bid
        FROM     bids
        GROUP BY auction_id) bids ON auction.auction_id = bids.auction_id AND highest_bid IS NOT NULL AND highest_bid = highest_value And status = 1 And timestamp < CURRENT_DATE

            ');
            $values = [
                'user_id'  => $user_id
            ];
            $select->execute($values);
            $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
            return $data;
        }



}
