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
            <form action="./src/patient/updateHeartRate.php" method="POST" enctype="multipart/form-data" class="heart-rate-form">
                <div class="info-update-logo-container">
                    <img src="./icons/heartRate.svg" alt="">
                </div>
                <div class="form-inputs-container">
                    <div class="inputs-header-title">
                        <p>Please insert your heart rate:</p>
                        <p class="heart-rate-detail"></p>

                    </div>
                    <div class="rates-input">
                        <input type="number" id="heart-rate" name="heart-rate" placeholder="70" required>
                        <span class="measure-units">BPM</span>
                    </div>
                    <br>
                    <div class="inputs-header-title">
                        <p>Please insert your blood pressure:</p>
                        <p class="blood-pressure-detail"></p>
                    </div>
                    <div class="rates-input">
                        <input type="number" name="systolic" id="systolic" placeholder="Systolic: 120" required> / <input type="number" name="diastolic"
                            id="diastolic" placeholder="Diastolic: 80" required> <span class="measure-units">mmHG</span> 
                    </div>
                </div>
                <div class="login-btn-container update-btn-container">
                    <button class="login-btn update-btn add-btn">ADD</button>
                </div>
            </form>

        </div>
    </div>

</body>

</html>