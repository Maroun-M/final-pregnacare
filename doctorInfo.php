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
    include_once("./src/doctor/doctor.php");
    $conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
    $doctor = new doctor();
    if (!isset($_SESSION['user_id']) || !$doctor->isDoctor($_SESSION['user_id'])) { // Check if the user is logged in and is patient
        echo "You don't have access to this page.";
        exit();
    }
    if (!$doctor->isDoctorConfirmed($_SESSION['user_id'])) {
        header("location:./confirm.php");
        exit();
    }
    ?>
    <div class="user-info-wrap">

        <div class="login-form-container user-info-container">
            <form action="./src/doctor/updateDoctorInfo.php" method="POST" enctype="multipart/form-data">
                <div class="user-info-header">
                    <p>Please enter more details:</p>
                </div>
                <div class="user-info-input">
                    <div class="form-labels">
                        <label for="dob">Date of birth: <span class="red">*</span></label>
                        <input type="date" id="dob" name="dob" placeholder="" /> <br />

                        <label for="location"> Location: <span class="red">*</span></label>
                        <select name="location" id="location">
                            <option value="" disabled selected>Select a city</option>
                            <option value="Beirut">Beirut</option>
                            <option value="Tripoli">Tripoli</option>
                            <option value="Sidon">Sidon</option>
                            <option value="Tyre">Tyre</option>
                            <option value="Byblos">Byblos</option>
                            <option value="Jounieh">Jounieh</option>
                            <option value="Zahle">Zahle</option>
                            <option value="Baabda">Baabda</option>
                            <option value="Aley">Aley</option>
                            <option value="Bhamdoun">Bhamdoun</option>
                            <option value="Jbeil">Jbeil</option>
                            <option value="Batroun">Batroun</option>
                            <option value="Chouf">Chouf</option>
                            <option value="Keserwan">Keserwan</option>
                            <option value="Metn">Metn</option>
                            <option value="Nabatieh">Nabatieh</option>
                            <option value="Hasbaya">Hasbaya</option>
                            <option value="Marjeyoun">Marjeyoun</option>
                            <option value="Bint Jbeil">Bint Jbeil</option>
                            <option value="Jezzine">Jezzine</option>
                            <option value="Rashaya">Rashaya</option>
                            <option value="West Bekaa">West Bekaa</option>
                            <option value="Akkar">Akkar</option>
                            <option value="Hermel">Hermel</option>
                            <option value="Baalbek">Baalbek</option>
                        </select>
                        <br />
                        <label for="education">Education: <span class="red">*</span></label>
                        <input type="text" id="education" name="education"><br>

                        <label for="clinic_name">Clinic Name: <span class="red">*</span></label>
                        <input type="text" id="clinic_name" name="clinic_name"><br>

                        <label for="clinic_number">Clinic Phone Number: <span class="red">*</span></label>
                        <input type="text" id="clinic_number" name="clinic_number"><br>


                    </div>


                </div>
                <div class="login-btn-container update-btn-container">
                    <button class="login-btn update-btn">Update</button>
                </div>
            </form>

        </div>
    </div>

</body>

</html>