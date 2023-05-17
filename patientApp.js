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
    if (patients[4] == 1) {
      diabetic.checked = true;
    }
    if (patients[5] == 1) {
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

if (window.location.pathname === "/ouvatech/chooseDoctor.php") {
  document.addEventListener("DOMContentLoaded", () => {
    fetchDoctors(1);
    fetchTotal();
  });
}

let fetchTotal = () => {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `./src/data/allDoctors.php?getTotal=true`);
  xhr.onload = () => {
    if (xhr.status === 200) {
      var total = JSON.parse(xhr.responseText);
      total = total.totalPages;
      createButtons(total);
    }
  };
  xhr.send();
};

let createButtons = (total) => {
  const paginationContainer = document.querySelector(".page-btns-container");
  for (let i = 1; i <= total; i++) {
    const button = document.createElement("button");
    button.innerText = i;
    button.addEventListener("click", () => {
      fetchDoctors(i);
    });
    paginationContainer.appendChild(button);
  }
};

let fetchDoctors = (i) => {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `./src/data/allDoctors.php?page=${i}`);
  xhr.onload = () => {
    if (xhr.status === 200) {
      const doctors = JSON.parse(xhr.responseText);
      // Process the doctors data here (e.g., create buttons, update UI)
      console.log(doctors);
      displayDrs(doctors);
      chooseDr();
    }
  };
  xhr.send();
};

let displayDrs = (doctors) => {
  const doctorsData = document.querySelector(".doctor-list-data");
  let results = ``;
  doctors.forEach((dr) => {
    results += `<div class="grid-item">Dr. ${dr.name}</div>
    <div class="grid-item">${dr.phone_number}</div>
    <div class="grid-item">${dr.education}</div>

    <div class="grid-item">${dr.clinic_name}</div>
    <div class="grid-item">${dr.clinic_number}</div>

    <div class="grid-item">${dr.location}</div>
    <div class="grid-item">
        <button class="choose-doctor-btn" data-id="${dr.doctor_id}">Choose</button>
    </div>`;
  });
  doctorsData.innerHTML = results;
};

let chooseDr = () => {
  const chooseBtn = document.querySelectorAll(".choose-doctor-btn");
  console.log(chooseBtn);
  chooseBtn.forEach((btn) => {
    btn.addEventListener("click", () => {
      const doctorID = event.target.dataset.id;
      const url = "./src/data/allDoctors.php";
      const data = {
        doctor_id: doctorID
      };

      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
        .then((response) => {
          alert(response)
          if (response.ok) {
            const successMessage = "Success"; // Set your success message here
            const params = new URLSearchParams(window.location.search);
            params.set("choice", successMessage);
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.location.href = newUrl;
          } else {
            throw new Error("Request failed");
          }
        })
        .catch((error) => {
          console.error(error);
        });
    });
  });
};
