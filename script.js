const chatBox = document.getElementById("chat-box");
const userInput = document.getElementById("userInput");

async function sendMessage() {
    const message = userInput.value.trim();
    if (!message) return;
  
    appendMessage("user", message);
    userInput.value = "";
  
    try {
      const response = await fetch("gemini_proxy.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message }),
      });
  
      const data = await response.json();
      console.log("Gemini raw response:", data);
      const reply = data.candidates?.[0]?.content?.parts?.[0]?.text || "Sorry, I didn't get that.";
      appendMessage("bot", reply);
    } catch (err) {
      appendMessage("bot", "Error: " + err.message);
    }
  }

  function appendMessage(sender, text) {
    const messageDiv = document.createElement("div");
    messageDiv.className = `message ${sender}`;
    messageDiv.textContent = text;
    chatBox.appendChild(messageDiv);
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  