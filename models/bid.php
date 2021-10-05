<?php

require_once 'user.php';

/**
 * Class bid
 */
class bid
{

    /**
     * @var
     */
    private $user_id;

    /**
     * bid constructor.
     */
    function __construct()
    {
        //session_start();
        if(isset($_SESSION["user"]["id"])){
        $this->user_id = $_SESSION["user"]["id"];
        }
    }

    /**
     * save the id of the auction when place a bid by the user
     * @param $auction_id
     * @param $amount
     */
    function saveBid($auction_id, $amount){
        
        $db = new db();
        $stmt = $db->pdo->prepare('INSERT INTO bids (amount,auction_id,user_id)  VALUES (:amount, :auction_id,:user_id)');
        $values = [
            'amount'  => $amount,
            'auction_id' => $auction_id,
            'user_id'     => $this->user_id
        ];
        $stmt->execute($values);
    }


    /**
     * find the highest bid of the auction to show in details
     * @param $auction_id
     * @return mixed
     */
    function currentBid($auction_id)
    {
        $db = new db();
        $select = $db->pdo->prepare('SELECT MAX(amount) as amount FROM `bids` where auction_id=:id');
        $values = ['id' => $auction_id];
        $select->execute($values);
        $data = $select->fetch();
        return $data["amount"];
    }



}


?>