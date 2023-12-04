<?php
require_once('config.php');
header('Content-Type:application/json; Charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_POST['name'] != '' && $_POST['email'] !='' && $_POST['password'] 
    !='' && $_POST['address'] !='' && $_POST['contact'] !='') {
    
    $sql = "SELECT * FROM `users` WHERE `email` = '" . $_POST['email'] . "' AND `CONTACT` = '" . $_POST['contact'] . "'";
    $res = mysqli_query($conn, $sql);
    
    if ($res->num_rows == 0) {
        $sql = "INSERT INTO `users` (`NAME`,`EMAIL`,`PASSWORD`,`ADDRESS`,`CONTACT`) 
        VALUES ('" . $_POST['name'] . "','" . $_POST['email'] . "','" . $_POST['password'] . "','" . $_POST['address'] . "','" . $_POST['contact'] . "')";
        
        $query = mysqli_query($conn, $sql);
        
        if ($query) {
            $user["id"] = mysqli_insert_id($conn);
            $user["name"] = $_POST['name'];
            $user["email"] = $_POST['email'];
            $user["password"] = $_POST['password'];
            $user["address"] = $_POST['address'];
            $user["contact"] = $_POST['contact'];

            $response["status"] = 'success';
            $response["message"] = 'User registered successfully';
            $response["user"] = $user;
            echo json_encode($response);
        } else {
            $response["status"] = 'failed';  // corrected typo from 'faild' to 'failed'
            $response["message"] = 'Error in query';
            echo json_encode($response);
        }
    } else {
        $response["status"] = 'failed';  // corrected typo from 'faild' to 'failed'
        $response["message"] = 'User already exists';
        echo json_encode($response);
    }
} else {
    $response["status"] = 'failed';  // corrected typo from 'faild' to 'failed'
    $response["message"] = 'Please enter all imput faild email name password password contact, it cannot be empty ';
    echo json_encode($response);
}
?>