const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");



form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active_done");
    }else{
        sendBtn.classList.remove("active_done");
    }
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              scrollToBottom();
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active_done");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active_done");
}

// setInterval(() =>{
//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "php/get-chat.php", true);
//     xhr.onload = ()=>{
//       if(xhr.readyState === XMLHttpRequest.DONE){
//           if(xhr.status === 200){
//             let data = xhr.response;
//             chatBox.innerHTML = data;
//             if(!chatBox.classList.contains("active_done")){
//                 //scrollToBottom();
//               }
//           }
//       }
//     }
//     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xhr.send("incoming_id="+incoming_id);
// }, 500);

let lastTimestamp = 0; // Variable to store the last retrieved timestamp

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);

                // Check if the server timestamp is different from the last timestamp
                if (response.timestamp !== lastTimestamp) {
                    let data = response.data;
                    chatBox.innerHTML = data;
                    lastTimestamp = response.timestamp;

                    if (!chatBox.classList.contains("active_done")) {
                        scrollToBottom();
                    }
                }
            }
        }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id=" + incoming_id);
}, 500);




function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  