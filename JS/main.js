// let messageContent;

const myMessages = document.getElementById("messages");
let lastMsgId = 0;
//loading message function
async function loadMessage() {
  const response = await fetch("./views/chatBox.php?loadAll");
  const data = await response.json();
  // console.log(data);

  // messageContent = data;

  // console.log(messageContent);
  myMessages.innerHTML = "";

  data.map((msg) => {
    myMessages.innerHTML += `<span class="msg" data-id="${msg.id}">${msg.message} <br> <i>${msg.username}</i></span><br>`;
  });
  lastMsgId = data[data.length - 1].id;
}

loadMessage();

//sending message function
const sendMsg = document.getElementById("msg-box");

async function sendMessage(url, data) {
  const response = await fetch(url, {
    method: "POST",
    body: data,
  });

  const returnData = await response.json();
  refreshChat();
}

sendMsg.addEventListener("submit", function (e) {
  e.preventDefault();

  const myMessage = new FormData(sendMsg);
  sendMessage("./views/chatBox.php?post", myMessage);

  sendMsg.reset();
});

//refresh message function
async function refreshChat() {
  let refreshFormData = new FormData();
  refreshFormData.set("lastMsgId", lastMsgId);

  const response = await fetch("./views/chatBox.php?refreshMessage", {
    method: "POST",
    body: refreshFormData,
  });

  const data = await response.json();
  console.log(data);
  if(data.length !== 0){
    data.map((msg) => {
      myMessages.innerHTML += `<span class="msg" data-id="${msg.id}">
      ${msg.message} <br/> <i>${msg.username}</i></span><br/>`;
    });

  lastMsgId = data[data.length - 1].id;
  }
  

}

setInterval(refreshChat, 5000);
