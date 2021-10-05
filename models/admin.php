<?php

require_once 'db.php';

/**
 * Class admin to control admin pages
 */
class admin{

    /**
     * admin constructor.
     */
    function __construct()
    {

    }

    /**
     * Create Category for admin
     * @param $category_name
     */
    public function createCategory($category_name){
        $db = new db();
        $stmt = $db->pdo->prepare('INSERT INTO categories (categories_name)
        VALUES (:categories_name)');
        $values = [
            'categories_name' => $category_name
        ];
        $stmt->execute($values);

    }

    /**
     * Create Category for admin
     * @param $category_name
     */
    public function createCatalogue($catalogue_name, $start_date){
        $db = new db();
        $stmt = $db->pdo->prepare('INSERT INTO catalogue (name, start_date)
        VALUES (:name, :start_date)');
        $values = [
            'name' => $catalogue_name,
            'start_date' => $start_date
        ];
        $stmt->execute($values);

    }

    /**
     * add to catalogue for admin
     * @param $data
     */
    public function addToCatalogue($catalogue_id, $data){
        $db = new db();

        //delete previous
        $stmt = $db->pdo->prepare('DELETE FROM catalogue_items WHERE  catalogue_id = :catalogue_id');
        $values = ['catalogue_id' => $catalogue_id];
        $stmt->execute($values);

        //add new
        foreach ($data as $key => $value) {
            $stmt = $db->pdo->prepare('INSERT INTO catalogue_items (catalogue_id, item_id)
            VALUES (:catalogue_id, :item_id)');
            $values = [
                'catalogue_id' => $catalogue_id,
                'item_id' => $key
            ];
            $stmt->execute($values);
            
        }

    }

    /**
     * Get Categories to show on admin panel
     * @return array
     */
    public function cataloguePage($id) {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM catalogue_items WHERE catalogue_id = '.$id.'');
        $select->execute();
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
    }

    /**
     * Get Categories to show on admin panel
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
     * Get catalogues to show on admin panel
     * @return array
     */
    public function getCatalogues() {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM catalogue');
        $select->execute();
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
    }

    /**
     * Get user to show on admin panel
     * @return array
     */
    public function getUsers() {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM users WHERE role = "user"');
        $select->execute();
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
    }

    /**
     * Get admins to show on admin panel
     * @return array
     */
    public function getAdmins() {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM users WHERE role = "admin"');
        $select->execute();
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
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
     * get an auction  
     * @return array
     */
    public function getAnAuction($id) {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM `auction` Where auction_id = '.$id.' and endtime >= CURDATE()');
        $select->execute();
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
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
     * get details fo a specific category
     * @param $id
     * @return mixed
     */
    public function getCategoryDetails($id){
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM categories WHERE categories_id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetch();
        return $data;
    }

    /**
     * get details fo a specific catalogue
     * @param $id
     * @return mixed
     */
    public function getCatalogueDetails($id){
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM catalogue WHERE id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetch();
        return $data;
    }

    /**
     * get details fo a specific catalogue
     * @param $id
     * @return mixed
     */
    public function getCatalogueItems($id){
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM catalogue_items WHERE catalogue_id=:id');
        $values = ['id' => $id];
        $select->execute($values);
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }

    /**
     * update a category by admin
     * @param $category
     */
    public function updateCategory($category){
        $db = new db();
        $stmt = $db->pdo->prepare('UPDATE ass1.categories SET categories_name = :categories_name  WHERE categories_id = :categories_id');
    $values = [
        'categories_name' => $category['name'],
        'categories_id' => $category["id"]
    ];
    $stmt->execute($values);
    }

    /**
     * update a catalogue by admin
     * @param $category
     */
    public function updateCatalogue($catalogue){
        $db = new db();
        $stmt = $db->pdo->prepare('UPDATE ass1.catalogue SET name = :name, start_date = :start_date  WHERE id = :id');
    $values = [
        'name' => $catalogue['name'],
        'start_date' => $catalogue['start_date'],
        'id' => $catalogue["id"]
    ];
    $stmt->execute($values);
    }

    /**
     * delete any category by admin
     * @param $category_id
     */
    public function deleteCategory($category_id){

        $db = new db();
        $stmt = $db->pdo->prepare('DELETE FROM ass1.categories WHERE  categories_id = :categories_id');
        $values = ['categories_id' => $category_id];
        $stmt->execute($values);

    }

    /**
     * delete any catalogue by admin
     * @param $id
     */
    public function deleteCatalogue($id){

        $db = new db();
        $stmt = $db->pdo->prepare('DELETE FROM ass1.catalogue WHERE  id = :id');
        $values = ['id' => $id];
        $stmt->execute($values);

    }

    /**
     * unApproved list of auctions created by user to show in main listing
     * @return array
     */
    public function getProductsForApproval() {
        $db = new db();
        $select = $db->pdo->prepare('SELECT * FROM auction WHERE status=0');
        $select->execute();
        $data = $select->fetchAll(\PDO::FETCH_ASSOC);;
        return $data;
    }


}