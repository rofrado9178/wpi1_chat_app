// let messageContent;

const myMessages = document.getElementById("messages");

async function loadMessage() {
  const response = await fetch("./views/chatBox.php?loadAll");
  const data = await response.json();
  console.log(data);

  // messageContent = data;

  // console.log(messageContent);
  myMessages.innerHTML = "";

  data.map((msg) => {
    myMessages.innerHTML += `<span class="msg">${msg.message} <br> <i>${msg.username}</i></span><br>`;
  });
}

loadMessage();
