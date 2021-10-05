<?php

include 'user.php';

/**
 * Super admin to control admins
 * Class super_admin
 */
class super_admin{


    /**
     * super_admin constructor.
     */
    function __construct()
    {

    }

    /**
     * add admin in the site
     * @param $user
     */
    public function createAdmin($user){
        $db = new db();

    $stmt = $db->pdo->prepare('INSERT INTO users (first_name, last_name, email, password, role)  VALUES (:first_name, :last_name, :email, :password, :role)');
    $values = [
        'first_name' => $user['first_name'],
        'last_name'  => $user['last_name'],
        'email'     => $_POST['email'],
        'password'  => password_hash($user['password'], PASSWORD_DEFAULT),
        'role' => 'admin'
    ];
      
    $stmt->execute($values);
    echo $mesage = 'Successfuly registed';

    }

    /**
     * see all the current admins working in site
     * @return array
     */
    public function getAdmins() {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM users WHERE `role`=:user_role');
        $values = ['user_role' => 'admin'];
        $select->execute($values);
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
        
    }

    /**
     * get details of a specific admin
     * @param $id
     * @return mixed
     */
    public function getAdminDetails($id){
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM users WHERE user_id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetch();
        return $data;
    }

    /**
     * view all categories by super admin
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
     * update details of an admin
     * @param $user
     */
    public function updateAdmin($user){
        $db = new db();
        $select = $db->pdo->prepare('UPDATE `users` SET `first_name` = :first_name  , `last_name` = :last_name, `email` = :email  WHERE `users`.`user_id` = :id;');
        $values = ['id' => $user["id"] , 'first_name' => $user["first_name"], 'last_name' => $user["last_name"], 'email' => $user["email"],];
        $select->execute($values);
    }

    /**
     * delete an admin
     * @param $id
     */
    public function deleteAdmin($id){

        $db = new db();
        $stmt = $db->pdo->prepare('DELETE FROM users WHERE  user_id = :id');
        $values = ['id' => $id];
        $stmt->execute($values);

    }


}