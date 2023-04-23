const logout = () => {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "./src/login/logout.php");
  xhr.addEventListener("load", () => {
    if (xhr.status === 200) {
      // redirect to the login page
      window.location.href = "./login.php";
    }
  });
  xhr.send();
};

const logoutButton = document.querySelectorAll(".logout-btn");
logoutButton.forEach((btn) => {
  btn.addEventListener("click", logout);
});

const getPatientData = async () => {
  const res = await fetch("./src/patient/patientData.php");
  const data = await res.json();
  const patient = Object.values(data);
  return patient;
};

const insert = async () => {
  try {
    const patients = await getPatientData();
    const dob = document.querySelector("input[name='dob']");
    const location = document.querySelector("select[name='location']");
    const prevPregYes = document.querySelector(
      "input[name='previous-pregnancies'][value='true']"
    );
    const prevPregNo = document.querySelector(
      "input[name='previous-pregnancies'][value='false']"
    );

    const pregStage1 = document.querySelector(
      "input[name='pregnancy-stage'][value='1']"
    );
    const pregStage2 = document.querySelector(
      "input[name='pregnancy-stage'][value='2']"
    );
    const pregStage3 = document.querySelector(
      "input[name='pregnancy-stage'][value='3']"
    );
    const diabetic = document.querySelector("input[name='diabetics']");
    const hypertension = document.querySelector("input[name='hypertension']");
    dob.value = patients[0];
    location.value = patients[1];

    if (patients[2] === 0) {
      prevPregNo.checked = true;
    } else {
      prevPregYes.checked = true;
    }

    if (patients[3] == 1) {
      pregStage1.checked = true;
    } else if (patients[3] == 2) {
      pregStage2.checked = true;
    } else if (patients[3] == 3) {
      pregStage3.checked = true;
    }
    if(patients[4] == 1){
        diabetic.checked = true;
    }
    if(patients[5] == 1){
        hypertension.checked = true;
    }
  } catch (error) {
    console.log(error);
  }
};

window.onload = load = () => {
  if (window.location.pathname === "/ouvatech/userInfo.php") {
    insert();
  }
};
