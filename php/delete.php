<?php

// Get the JSON data from the request
$data = file_get_contents('php://input');
$data = json_decode($data);

// Check if the data is valid
if($data->id && $data->type == "delete") {
    $id = $data->id;

    // Connect to the MySQL database
    $conn = new mysqli('localhost', 'root', '', 'chatapp');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $id = $conn->real_escape_string($id);

    $sql = "DELETE FROM messages WHERE msg_id='$id'";

    $result = $conn->query($sql);
    if($result){
        echo "message deleted";
    }else{
        echo "somesing error";
    }


    // Close the connection
    $conn->close();
} else {
    echo "Invalid input data";
}
?>
