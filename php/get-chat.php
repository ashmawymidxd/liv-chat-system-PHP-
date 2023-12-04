<?php 
    // session_start();
    // if(isset($_SESSION['unique_id'])){
    //     include_once "config.php";
    //     $outgoing_id = $_SESSION['unique_id'];
    //     $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    //     $output = "";
    //     $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
    //             WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
    //             OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
    //     $query = mysqli_query($conn, $sql);
    //     if(mysqli_num_rows($query) > 0){
    //         while($row = mysqli_fetch_assoc($query)){
    //             if($row['outgoing_msg_id'] === $outgoing_id){
    //                 $output .= '<div class="chat outgoing">
    //                             <div class="details">
    //                                 <input type="hidden" value="'.$row['msg_id'].'">
    //                                 <p>'. $row['msg'].$row['msg_id'].'<br>
    //                                 <button onclick="alert(this.parentNode.parentNode.firstElementChild.value);
                                    
    //                                 " hidden>delete</button>
    //                                 </p>
                                   
    //                             </div>
    //                             </div>';
    //             }else{
    //                 $output .= '<div class="chat incoming">
    //                             <img src="php/images/'.$row['img'].'" alt="">
    //                             <div class="details">
    //                                 <p>'. $row['msg'] .'</p>
    //                             </div>
    //                             </div>';
    //             }
    //         }
    //     }else{
    //         $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
    //     }
    //     echo $output;
    // }else{
    //     header("location: ../login.php");
    // }

?>
<?php 
session_start();

if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";
    $timestamp = 0; // Initialize timestamp to 0

    $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
            WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id} AND deleted_at = 0)
            OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id} AND deleted_at = 0) ORDER BY msg_id";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $timestamp = max($timestamp, strtotime($row['created_at'])); // Update timestamp with the latest message's created_at time

            if ($row['outgoing_msg_id'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                            <div class="details">
                                <input type="hidden" value="'.$row['msg_id'].'">

                                <p>'. $row['msg'].'<span style="display: flex;align-items: center;justify-content: space-between;margin-top:5px">'
                                .'<span style="margin-left:3px;color:yellow;font-size:12px">'.' 
                                '.date('H:i',strtotime($row['created_at'])).' PM'.'</span>'
                                .'<i  role="button" class="fa-solid fa-trash-can delete_btn" data-id="'.$row['msg_id'].'" style="color: #ffffff;margin-left:10px"></i>'
                                .'</span>'.'</p>

                            </div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">
                            <img src="php/images/'.$row['img'].'" alt="">
                            <div class="details">
                                <p>'. $row['msg'].'<span style="margin-left:3px;color:green;font-size:12px">'.'<br>'.date('H:i',strtotime($row['created_at'])).' PM'.'</span>'.'</p>
                            </div>
                            </div>';
            }
        }
    } else {
        $output .= '<div class="text">No messages are available. Once you send a message, it will appear here.</div>';
    }

    // Return JSON response with chat data and timestamp
    $response = array('data' => $output, 'timestamp' => $timestamp);
    echo json_encode($response);
} else {
    header("location: ../login.php");
}
?>
