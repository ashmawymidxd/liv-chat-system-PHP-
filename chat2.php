<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>

<body>
    <script src="./javascript/tools/jquery.js"></script>
    <div class="wrapper body_clould">
        <section class="chat-area">
            <header>
                <?php 
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: users.php");
          }
        ?>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo $row['img']; ?>" alt="">
                <div class="details">
                    <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
                    <p><?php echo $row['status']; ?></p>
                </div>
            </header>
            <div class="chat-box">

            </div>

            <form action="#" class="typing-area">
                <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type a message here..."
                    autocomplete="off">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>

    <div class="model actives">
        <div>
            <p>Delete Module</p>
            <button style="margin-top:-14px" class="close"><i class="fa-solid fa-circle-xmark"></i></button>
        </div>
        <div>
            <input type="text" name="id" id="input_value" hidden><br>
            Are You Sure You Want To Delete This<br> Or Not
        </div>
        <div>
            <button class="ok">OK</button>
            <button class="cancle">Cancel</button>
        </div>
    </div>
    <script>

    </script>

    <script>
    var model = document.querySelector(".model");
    var close_btn = document.querySelector(".close");
    var ok = document.querySelector(".ok");
    var cancle = document.querySelector(".cancle");
    var body_clould = document.querySelector(".body_clould");
    var input_value = document.getElementById("input_value");
    // Add an event listener for the click event on the document
    function hideModel() {
        model.classList.toggle("actives");
        body_clould.style.opacity = 1;
        document.body.style.zIndex = 0;
        document.body.style.backgroundColor = "white";

    }
    close_btn.onclick = () => {
        hideModel();
    }

    cancle.onclick = () => {
        hideModel();
    }
    document.addEventListener('click', function(event) {
        // Check if the clicked element has the class "delete_btn"
        if (event.target.classList.contains('delete_btn')) {
            // Access the hidden input's value for further actions
            //let msgId = event.target.closest('.details').querySelector('input[type="hidden"]').value;
            let msgId = event.target.closest('.details').querySelector('.delete_btn').getAttribute("data-id");
            //alert(msgId);

            input_value.value = msgId;

            model.classList.toggle("actives");
            body_clould.style.opacity = 0.3;
            document.body.style.zIndex = 0;
            document.body.style.backgroundColor = "#ddd";
        }
    });

    ok.onclick = () => {
        var inputValue = input_value.value;
        var data = {};
        data.id = inputValue;
        var data = {};
        data.id = inputValue;
        data.type = "delete";

        var xml = new XMLHttpRequest();
        xml.onload = function() {
            if (xml.readyState == 4 || xml.status == 200) {
                let fedeback = xml.responseText;
                hideModel();
            }
        }
        var data_string = JSON.stringify(data);

        xml.open("POST", "php/delete.php", true);
        xml.send(data_string);

        //alert(data_string);
        send_data(data, "delete");
    }
    </script>
    <script src="javascript/chat.js"></script>

</body>

</html>