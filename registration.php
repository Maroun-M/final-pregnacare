<!DOCTYPE html>
<html lang="en">

  <head>  <link rel="icon" type="image/png" href="./images/pregnaCareLogo.png">

  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PregnaCare</title>
  <link rel="stylesheet" href="./style.css" />
  <link rel="icon" type="image/png" href="./images/pregnaCareLogo.png">

</head>

<body>
  <div class="registration-page-wrap">
    <div class="registration-choices-container">
      <div class="registration-page-headings">
        <p>Finishing up your registration to</p>
        <h2>PregnaCare</h2>
        <p class="gray-text">
          Enhance your health and wellbeing at any moment
        </p>
      </div>
      <div class="registration-choices">
        <form action="./src/register/register.php" method="POST" enctype="multipart/form-data"
          class="registration-choice-form">
          <input type="text" id="firstName" name="firstName" hidden value="<?php echo $_POST['firstName']; ?>" />
          <input type="text" id="lastName" name="lastName" hidden value="<?php echo $_POST['lastName']; ?>" />
          <input type="email" id="emailAddress" name="emailAddress" hidden
            value="<?php echo $_POST['emailAddress']; ?>" />
          <input type="tel" id="phoneNumber" name="phoneNumber" hidden value="<?php echo $_POST['phoneNumber']; ?>" />
          <input type="password" id="password" name="password" hidden value="<?php echo $_POST['password']; ?>" />
          <input type="password" id="confirm-password" name="confirm-password" hidden
            value="<?php echo $_POST['confirm-password']; ?>" />
          <input type="radio" name="registration-type" value="patient" id="patient-radio" />
          <label for="patient-radio">Register As Patient</label>
          <input type="radio" name="registration-type" value="doctor" id="doctor-radio" />
          <label for="doctor-radio">Register As Doctor</label>
          <input class="btn btn-primary btn-lg " type="submit" value="Submit" name="submit-registration"
            id="submit-reg-btn" />
        </form>
      </div>
    </div>

  </div>
</body>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const radioButtons = document.querySelectorAll('input[type="radio"]');

    radioButtons.forEach(function (button) {
      button.addEventListener("change", function () {
        radioButtons.forEach(function (btn) {
          btn.nextElementSibling.classList.remove("selected");
        });
        if (this.checked) {
          this.nextElementSibling.classList.add("selected");
        }
      });
    });
  });



</script>

</html>