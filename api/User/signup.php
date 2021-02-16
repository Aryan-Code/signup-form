<?php
 
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// set user property values
$user->username =isset($_POST['username']) ? $_POST['username'] : '';
$user->password = isset($_POST['password']) ? $_POST['password'] : '';
$user->name =isset($_POST['name']) ? $_POST['name'] : '';
$user->city =isset($_POST['city']) ? $_POST['city'] : '';
$user->pno =isset($_POST['pno']) ? $_POST['pno'] : '';
$user->created = date('Y-m-d H:i:s');
 
//check if username or password is empty.
if(empty($user->username) || empty($user->password) || empty($user->name) || empty($user->pno)){
    echo '<script>alert("Please don\'t leave empty fields.")</script>';
}
// create the user
else if($user->signup()){
    echo '<script>alert("You have been successfully signed up.")</script>';
    $user_arr=array(
        "status" => true,
        "message" => "Successfully Signup!",
        "id" => $user->id,
        "username" => $user->username
    );
    
}
else{
    echo '<script>alert("Username already exists.")</script>';
    $user_arr=array(
        "status" => false,
        "message" => "username already exists"
    );
}
// make it json format
print_r(json_encode($user_arr));
?>