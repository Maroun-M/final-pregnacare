<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>Ouvatech</title>
    <link rel="stylesheet" href="style.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap"
        rel="stylesheet" />
    <script src="./patientApp.js" defer></script>

</head>

<body>
    <?php 
    session_start();
  ?>
    <div class="user-info-wrap">

        <div class="login-form-container user-info-container heart-rate-inputs-container">
            <form action="./src/patient/patientEntries.php" method="POST" enctype="multipart/form-data" class="heart-rate-form">
                <div class="info-update-logo-container">
                    <img src="./icons/fetus.svg" alt="">
                </div>
                <div class="form-inputs-container">
                    <div class="inputs-header-title">
                        <p>Please insert your fetus gestational age:</p>
                        <p class="temperature-detail"></p>
                    </div>
                    <div class="rates-input">
                        <input type="text" id="gest-age" name="gest-age" placeholder="10" required>
                        <span class="measure-units">weeks</span>
                    </div> 
                    <div class="inputs-header-title">
                        <p>Please insert your fetus weight:</p>
                        <p class="temperature-detail"></p>
                    </div>
                    <div class="rates-input">
                        <input type="text" id="fetal-weight" name="fetal-weight" placeholder="200" required>
                        <span class="measure-units">grams</span>
                    </div> 
                    <div class="inputs-header-title">
                        <p>Please insert your fetus heart rate:</p>
                        <p class="temperature-detail"></p>
                    </div>
                    <div class="rates-input">
                        <input type="text" id="fetal-heart-rate" name="fetal-heart-rate" placeholder="70" required>
                        <span class="measure-units">BPM</span>
                    </div>    
                </div>
                <div class="login-btn-container update-btn-container">
                    <button class="login-btn update-btn add-btn">UPDATE</button>
                </div>
            </form>

        </div>
    </div>

</body>

</html>