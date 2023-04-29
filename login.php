<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ouvatech</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
</head>

<body>
  <div class="wrapper  gradient-custom-login">
    <!-- <nav class="navbar fixed-top navbar-expand-lg navbar-dark">
          <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
              aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
              <div class="navbar-nav">
                <p class="nav-link" class="nav-link active" onClick="document.querySelector('.front').scrollIntoView();">
                 <a href="./index.html">Home</a> 
                </p>
                <p class="nav-link" onClick="document.querySelector('.logos-wrap').scrollIntoView();">
                  Features
                </p>
                <p class="nav-link" onClick="document.querySelector('.info-wrapper').scrollIntoView();">
                  Info
                </p>
                <p class="nav-link" onClick="document.querySelector('.vh-150').scrollIntoView();">
                  Register
                </p>
                <p class="nav-link"><a href="./login.html">Login</a></p>
              </div>
            </div>
          </div>
        </nav> -->

    <?php
    // Start session
    session_start();
    if(isset($_SESSION['user_id'])) { // Check if the user is logged in
      // User is logged in, redirect them to the home page or any other page
      header("Location: ./patientMainMenu.php");
      exit;
   }
    // Generate CSRF token
    $_SESSION['token'] = bin2hex(random_bytes(32));
    ?>



    <div class="login-form-container">
      <div class="header">
        <div class="logo-img-container">
          <img src="./images/logo.jfif" alt="">
        </div>
        <h2>LOGIN</h2>
        <p>Please enter your email and password</p>
      </div>
      <form action="./src/login/userLogin.php" method="POST" enctype="multipart/form-data">
        <div class="input-container">
          <input type="email" name="email" placeholder="Email"> <br>
          <input type="password" name="password" placeholder="Password"><br>
          <input type="hidden" name="token" value="<?php

          echo $_SESSION['token']; ?>">

        </div>
        <div class="reset-login-container">
          <a href="">
            <p>Forgot Password?</p>
          </a>
          <div class="login-btn-container">
            <button class="login-btn">LOGIN</button>
          </div>
        </div>
        <div class="signup-prompt-container">
          <p>Don't have an account? <span class="sign-up-btn">
            <a href="./index.html">Sign Up</a>
          </span></p>
        </div>
      </form>

  </div>
  <!-- footer container -->
  <!-- <hr />
        <div class="footer-container">
          <div class="footer-content">
            <p>Ouvatech© 2023. All rights reserved.</p>
          </div>
        </div> -->

  </div>
  <!-- footer container end -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
    crossorigin="anonymous"></script>
</body>

</html>