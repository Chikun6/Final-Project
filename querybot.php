<?php
// include_once "student_navbar.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smartie</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <style>
    .chat-button {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      font-size: 24px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      cursor: pointer;
      z-index: 1000;
      transition: background-color 0.3s;
    }

    .chat-button:hover {
      background-color: #0056b3;
    }
  </style>
  <style>
    /* body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: url("./chatbotbackground.avif");
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat
    font-family: Arial, sans-serif;
  } */


    .modal-content{
      border-radius: 20px;
    }
    .chat-container {
      width: 100%;
      height: 90vh;
      background: rgba(256, 256, 256, 0.75);
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .chat-header {
      background: linear-gradient(90deg, rgb(87, 172, 232), #c86dd7);
      color: white;
      padding: 25px;
      font-size: large;
      font-weight: 900;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .chat-options {
      display: flex;
      gap: 10px;
      cursor: pointer;
    }

    .chat-box {
      flex: 1;
      padding: 15px;
      overflow-y: auto;
    }

    .input-container {
      display: flex;
      align-items: center;
      padding: 10px;
      border-top: 1px solid #eee;
    }

    .input-container input {
      flex: 1;
      padding: 8px 12px;
      border-radius: 20px;
      border: 1px solid #ddd;
      outline: none;
    }

    .input-container button {
      background: none;
      border: none;
      color: #f65df6;
      font-size: 20px;
      margin-left: 8px;
      cursor: pointer;
    }

    .send-icon {
      font-weight: bold;
    }

    .chat-box {
      display: flex;
      flex-direction: column;
      padding: 15px;
      overflow-y: auto;
      flex: 1;
    }

    .message {
      max-width: 80%;
      padding: 10px 15px;
      border-radius: 16px;
      margin: 8px 0;
      word-wrap: break-word;
    }

    .message.user {
      background-color: rgb(92, 236, 255);
      align-self: flex-end;
      border-bottom-right-radius: 0;
    }

    .message.bot {
      background-color: rgb(237, 121, 255);
      align-self: flex-start;
      border-bottom-left-radius: 0;
    }
  </style>
</head>

<body>
  <button class="chat-button" type="button" data-toggle="modal" data-target=".bd-example-modal-lg">
    <i class="fas fa-comment-alt"></i>
  </button>

  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="chat-container">
          <div class="chat-header">
            <span>S M A R T I E</span>
          </div>
          <div id="chat-box" class="chat-box">
          </div>
          <div class="input-container">
            <input type="text" id="userInput" placeholder="Type a message..." />
            <button onclick="sendMessage()">
              <span class="send-icon">➤</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="script.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>