<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
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
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

      <script>
          // Add an event listener for the click event on the document
          document.addEventListener('click', function(event) {
              // Check if the clicked element has the class "delete_btn"
              if (event.target.classList.contains('delete_btn')) {
                  // Access the hidden input's value for further actions
                  let msgId = event.target.closest('.details').querySelector('input[type="hidden"]').value;
                  var data ={};
                  data.id = msgId;
                  data.type = "delete";
                  var xml = new XMLHttpRequest();
                  xml.onload = function(){
                      if(xml.readyState == 4 || xml.status == 200){
                          let fedeback = xml.responseText;
                          alert(fedeback);
                      }
                  }
                    var data_string = JSON.stringify(data);
                    
                    //alert(data_string);
                    xml.open("POST","php/delete.php",true);
                    xml.send(data_string);
              }
          });
      </script>
  <script src="javascript/chat.js"></script>

</body>
</html>
