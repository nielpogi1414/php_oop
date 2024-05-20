<?php
class database{
 
    function opencon(){
        return new PDO('mysql:host=localhost; dbname=loginmethod', 'root', '');
    }
    function check($username, $passwords){
        $con = $this->opencon();
        $query = "Select * from users WHERE Username='".$username."'&&Pass_word='".$passwords."'";
        return $con->query($query)->fetch();
    }
    function signup($username, $passwords, $firstname, $lastname, $Birthday, $sex){
        $con = $this->opencon();
   
        $query = $con->prepare("SELECT username FROM users WHERE username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();
        if ($existingUser){
            return false; // Username already exists
        }
   
        $query = $con->prepare("INSERT INTO users (username, passwords, firstname, lastname, Birthday, sex) VALUES (?, ?, ?, ?, ?,?)");
        return $query->execute([$username, $passwords, $firstname, $lastname, $Birthday,$sex]);
    }
    function signupUser($username, $passwords, $firstName, $lastName, $Birthday, $Sex) {
        $con = $this->opencon();
   
        $query = $con->prepare("SELECT username FROM users WHERE username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();
        if ($existingUser){
            return false;
        }
        $query = $con->prepare("INSERT INTO users (Username, Pass_word, firstname, lastname, Birthday, sex) VALUES (?, ?, ?, ?, ?,?)");
        $query->execute([$username, $passwords, $firstName, $lastName, $Birthday,$Sex]);
        return $con->lastInsertId();

    }
    function insertAddress($user_id, $city, $province, $street, $barangay) {
        $con = $this->opencon();
        return $con->prepare("INSERT INTO user_address (user_id, user_add_city, user_add_province, user_add_street, user_add_barangay) VALUES (?, ?, ?, ?, ?)")
            ->execute([$user_id, $city, $province, $street, $barangay]);
    }
    function view()
    {
        $con = $this->opencon();
        return $con->query("SELECT users.user_id, users.FirstName, users.LastName, users.Birthday, users.Sex, users.Username, users.Pass_word, CONCAT( user_address.user_add_street, ' ', user_address.user_add_barangay,' ', user_address.user_add_city,' ', user_address.user_add_province) AS address FROM users JOIN user_address ON users.user_id = user_address.user_id
")->fetchAll();
    }
    function delete($id)
    {
        try{
            $con = $this->opencon();
            $con->beginTransaction();

            //delete user address
            $query = $con->prepare("DELETE FROM user_address WHERE user_id = ?"); 
            $query->execute([$id]);
            
            //delete user
            $query2 =$con->prepare("DELETE FROM users WHERE user_id = ?");
            $query2->execute([$id]);

            $con->commit();
            return true;
        } catch (PDOException $e){
            $con->rollBack();
            return false; 
    }
   
}

function viewdata($id){
    try {
        $con = $this->opencon();
        $query = $con->prepare("SELECT
        users.user_id,
        users.FirstName,
        users.LastName,
        users.Birthday,
        users.Sex,
        users.Username, 
        users.Pass_word,
        user_address.user_add_street,user_address.user_add_province,user_address.user_add_province,user_address.user_add_province
        
    FROM
        users
    JOIN user_address ON users.user_id = user_address.user_id
    Where users.user_id =?;");
        $query->execute([$id]);
        return $query->fetch();
    } catch (PDOException $e) {
        // Handle the exception (e.g. , log error, return empty array. etc.)
        return [];
    
  
        }
    }


function updateUser($user_id ,$firstname, $lastname, $birthday, $sex, $username, $passwords) {
    try {
        $con = $this->opencon();
        $con->beginTransaction();
        $query = $con->prepare("UPDATE users SET firstName=?, LastName=?,Birthday=?, Sex=?,Username=?, Pass_word=? WHERE user_id=?");
        $query->execute([$firstname, $lastname,$birthday,$sex,$username, $passwords, $user_id]);
        // Update successful
        $con->commit();
        return true;
    } catch (PDOException $e) {
        // Handle the exception (e.g., log error, return false, etc.)
         $con->rollBack();
        return false; // Update failed
    }
}

function updateUserAddress($user_id, $street, $barangay, $city, $province) {
    try {
        $con = $this->opencon();
        $con->beginTransaction();
        $query = $con->prepare("UPDATE user_address SET user_add_street=?, user_add_barangay=?, user_add_city=?, user_add_province=? WHERE user_id=?");
        $query->execute([$street, $barangay, $city, $province, $user_id]);
        $con->commit();
        return true; // Update successful
    } catch (PDOException $e) {
        // Handle the exception (e.g., log error, return false, etc.)
        $con->rollBack();
        return false; // Update failed
    }
     
}
}