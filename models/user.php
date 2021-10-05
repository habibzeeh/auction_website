<?php


include 'db.php';


/**
 * Class user to control user pages
 */
Class user{

public $id;
public $first_name;
public $last_name;
public $email;
public $role;
public $db;

    /**
     * user constructor.
     * @param $email
     */
    function __construct($email) {

    $db = new db();
    $select = $db->pdo->prepare('SELECT * FROM users WHERE email=:email');
    $values = ['email' => $email];
    $select->execute($values);
    $data = $select->fetch();
    $this->id = $data["user_id"];
    $this->first_name = $data["first_name"];
    $this->last_name = $data["last_name"];
    $this->email = $data["email"];
    $this->role = $data["role"];


  }

    /**
     * @return bool
     */
    public function isAdmin(){
    if($this->role == 'admin'){
        return true;
    }
    return false;
}

    /**
     * get details of the user
     * @return mixed
     */
    public function userInfo(){

    $data["id"] = $this->id;
    $data["email"] = $this->email;
    $data["first_name"] = $this->first_name;
    $data["last_name"] = $this->last_name;
    $data["full_name"] = $this->first_name . " " . $this->last_name;
    $data["role"] = $this->role;

    return $data;
}

}
