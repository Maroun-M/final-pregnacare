// Call the getPatients function when the page is ready
if (window.location.pathname === "/ouvatech/patients.php") {
  // Function to get the patient data from the server

  const patient_row = document.querySelector(".data-container");
  function getPatients() {
    // Send an AJAX request to the server to get the patient data
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "./src/data/doctorPatients.php", true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var patients = JSON.parse(xhr.responseText);
        console.log(patients);
        let results = ``;
        patients.forEach((patient) => {
          results += `<div class="item">${patient.name}</div>
                    <div class="item">${patient.age}</div>
                    <div class="item">${patient.location}</div>
                    <div class="item">${patient.phone_number}</div>
                    <div class="item">Normal</div>
                    <div class="item "><u class="patient-records" data-id=${patient.id}>Records</u></div>`;
        });
        patient_row.innerHTML += results;
        const records_btn = document.querySelectorAll(".patient-records");
        records_btn.forEach((btn) => {
          btn.addEventListener("click", () => {
            const patient_id = event.target.dataset.id;
            window.location.href = "./patientRecords.php?patient=" + patient_id;
          });
        });
      } else if (xhr.readyState === 4) {
        console.log("Error getting patient data: " + xhr.statusText);
      }
    };
    xhr.send();
  }
  document.addEventListener("DOMContentLoaded", function () {
    getPatients();
  });

  //end of patients data for the dr.
}

if (window.location.pathname === "/ouvatech/patientRecords.php") {
  // Get the current URL
  const url = new URL(window.location.href);

  // Get the value of the 'patient' parameter
  const params = new URLSearchParams(url.search);
  const patientId = params.get("patient");

  document.addEventListener("DOMContentLoaded", () => {
    // Create a new XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    xhr.open("GET", `./src/data/patientData.php?patient=${patientId}`, true);

    // Set the response type (optional)
    xhr.responseType = "json";

    // Define the event handler for when the request completes
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Request was successful, process the response
        const data = xhr.response;

        console.log(data);
        const bloodGlucoseData = data["blood_glucose"];
        const bloodOxygenData = data["blood_oxygen"];
        const fetusData = data["fetus"];
        const hrBpData = data["hr_bp"];
        const temperatureData = data["temperature"];
        const userFilesData = data["user_files"];

        const table = document.querySelector(".tests-data-container");

        let results = ``;
        results += `<div class="header">Blood Glucose</div>
            <div class="header">${bloodGlucoseData.glucose_level}</div>
            <div class="header">${bloodGlucoseData.date}</div>
            <div class="header">${bloodGlucoseData.time}</div> `;
        table.innerHTML += results;

        let oxygenResults = ``;
        oxygenResults += `<div class="header">Blood Oxygen</div>
            <div class="header">${bloodOxygenData.percentage}%</div>
            <div class="header">${bloodOxygenData.date}</div>
            <div class="header">${bloodOxygenData.time}</div> `;
        table.innerHTML += oxygenResults;

        let hrData = ``;
        hrData += `<div class="header">Heart Rate</div>
    <div class="header">${hrBpData.bpm}</div>
    <div class="header">${hrBpData.date}</div>
    <div class="header">${hrBpData.time}</div> `;
        table.innerHTML += hrData;
        let pressure = ``;
        pressure += `<div class="header">Blood Pressure</div>
    <div class="header">Diastolic: ${hrBpData.diastolic} Systolic: ${hrBpData.systolic}</div>
    <div class="header">${hrBpData.date}</div>
    <div class="header">${hrBpData.time}</div> `;
        table.innerHTML += pressure;

        const downloadLink = document.createElement("a");

        // Set the link's href attribute to the file path
        downloadLink.href = userFilesData.file_path;

        // Set the link's text
        downloadLink.innerHTML = "Lab Test";
        let filesData = ``;
        filesData += `<div class="header">Lab Tests</div>
            <div class="header"><a href="${userFilesData.file_path}" target="_blank">Lab Tests</a></div>
            <div class="header">${userFilesData.date}</div>
            <div class="header">${userFilesData.time}</div> `;
        table.innerHTML += filesData;

        let tempData = ``;
        tempData += `<div class="header">Temperature</div>
<div class="header">${temperatureData.temp}</div>
<div class="header">${temperatureData.date}</div>
<div class="header">${temperatureData.time}</div> `;
        table.innerHTML += tempData;
        let fetusResults = ``;
        fetusResults += `<div class="header">Blood Glucose</div>
        <div class="header">Gestational Age: ${fetusData.gestational_age} Weight: ${fetusData.weight} Heart rate: ${fetusData.heart_rate}</div>
        <div class="header">${fetusData.date}</div>
        <div class="header">${fetusData.time}</div> `;
        table.innerHTML += fetusResults;
      } else {
        // Request failed, handle the error
        console.error("Request failed. Status:", xhr.status);
      }
    };

    // Send the AJAX request
    xhr.send();
  });

  const graph_btn = document.querySelector(".graphs-btn");
  graph_btn.addEventListener("click", () => {
    window.location.href = "./patientGraphs.php?ID=" + patientId;
  });
}

if (window.location.pathname === "/ouvatech/patientGraphs.php") {
  // Get the current URL
  const url = new URL(window.location.href);

  // Get the value of the 'patient' parameter
  const params = new URLSearchParams(url.search);
  const patientId = params.get("ID");

  const weeklyBtn = document.getElementById("weekly-btn");
  const monthlyBtn = document.getElementById("monthly-btn");
  const yearlyBtn = document.getElementById("yearly-btn");
  const testsBtns = document.querySelectorAll(".tests-btn");
  const dataChart = document.getElementById("data-chart");

  let selectedDataType = "Blood Glucose"; // Default data type

  // Add event listeners to the buttons
  document.addEventListener("DOMContentLoaded", () => {
    fetchData("weekly", selectedDataType);
  });

  testsBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectedDataType = btn.innerHTML;
      fetchData("weekly", selectedDataType);
    });
  });

  weeklyBtn.addEventListener("click", () =>
    fetchData("weekly", selectedDataType)
  );
  monthlyBtn.addEventListener("click", () =>
    fetchData("monthly", selectedDataType)
  );
  yearlyBtn.addEventListener("click", () =>
    fetchData("yearly", selectedDataType)
  );

  // Function to fetch the data based on the selected option and data type
  function fetchData(option, dataType) {
    const xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      `./src/data/patientData.php?range=${option}&ID=${patientId}&type=${dataType}`
    );
    xhr.onload = () => {
      if (xhr.status === 200) {
        const testsData = JSON.parse(xhr.responseText);
        console.log(testsData);
        const table = document.querySelector(".tests-data-container");
        let results = ``;
        testsData.forEach((data) => {
          if (dataType === "Blood Pressure") {
            results += `<div class="item">Diastolic: ${data.diastolic} Systolic: ${data.systolic}</div>
                  <div class="item">${data.date}</div>
                  <div class="item">${data.time}</div>`;
          } else if (dataType === "Fetus Data") {
            results += `
                  <div class="header">Gestational Age: ${data.gestational_age} Weight: ${data.weight} Heart rate: ${data.heart_rate}</div>
                  <div class="header">${data.date}</div>
                  <div class="header">${data.time}</div>`;
          } else if (dataType === "Lab Tests") {
            results += `
              <div class="header"><a href="${data.file_path}" target="_blank">Lab Tests</a></div>
              <div class="header">${data.date}</div>
              <div class="header">${data.time}</div> `;
          } else {
            results += `<div class="item">${data.value}</div>
                  <div class="item">${data.date}</div>
                  <div class="item">${data.time}</div>`;
          }
        });
        table.innerHTML = results;

        // Call the createChart function to display the chart

        createChart(testsData);
      }
    };
    xhr.send();
  }

  // Function to create or update the chart
  // Function to create or update the chart
  function createChart(testsData) {
    const canvas = document.getElementById("data-chart");

    // Check if there is an existing chart instance
    const existingChart = Chart.getChart(canvas);
    if (existingChart) {
      existingChart.destroy(); // Destroy the existing chart
    }

    const labels = testsData.map((data) => data.date);
    const dataValues = testsData.map((data) => data.value);
    if (selectedDataType === "Lab Tests") {
      const chart = new Chart(canvas, {
        type: "line",
        data: {
          labels: labels,
          datasets: [
            {
              label: selectedDataType,
              data: null,
              backgroundColor: "rgba(0, 123, 255, 0.5)",
              borderColor: "rgba(0, 123, 255, 1)",
              borderWidth: 1,
            },
          ],
        },
        options: {
          // Customize the chart options as needed
        },
      });
    }

    if (selectedDataType === "Blood Pressure") {
      const labels = testsData.map((data) => data.date);
      const dataValues1 = testsData.map((data) => data.systolic);
      const dataValues2 = testsData.map((data) => data.diastolic);
      const chart = new Chart(canvas, {
        type: "bar",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Systolic", // Customize the label for the first data value
              data: dataValues1,
              backgroundColor: "rgba(0, 123, 255, 0.5)", // Customize the background color
              borderColor: "rgba(0, 123, 255, 1)", // Customize the border color
              borderWidth: 1, // Customize the border width
            },
            {
              label: "Diastolic", // Customize the label for the second data value
              data: dataValues2,
              backgroundColor: "rgba(255, 0, 0, 0.5)", // Customize the background color
              borderColor: "rgba(255, 0, 0, 1)", // Customize the border color
              borderWidth: 1, // Customize the border width
            },
          ],
        },
        options: {
          // Customize the chart options as needed
        },
      });
    }
    if (selectedDataType === "Blood Pressure") {
        const labels = testsData.map((data) => data.date);
        const dataValues1 = testsData.map((data) => data.systolic);
        const dataValues2 = testsData.map((data) => data.diastolic);
        const chart = new Chart(canvas, {
          type: "bar",
          data: {
            labels: labels,
            datasets: [
              {
                label: "Systolic", // Customize the label for the first data value
                data: dataValues1,
                backgroundColor: "rgba(0, 123, 255, 0.5)", // Customize the background color
                borderColor: "rgba(0, 123, 255, 1)", // Customize the border color
                borderWidth: 1, // Customize the border width
              },
              {
                label: "Diastolic", // Customize the label for the second data value
                data: dataValues2,
                backgroundColor: "rgba(255, 0, 0, 0.5)", // Customize the background color
                borderColor: "rgba(255, 0, 0, 1)", // Customize the border color
                borderWidth: 1, // Customize the border width
              },
            ],
          },
          options: {
            // Customize the chart options as needed
          },
        });
      }
      if (selectedDataType === "Fetus Data") {
        const labels = testsData.map((data) => data.date);
        const dataValues1 = testsData.map((data) => data.gestational_age);
        const dataValues2 = testsData.map((data) => data.weight);
        const dataValues3 = testsData.map((data) => data.heart_rate);

        const chart = new Chart(canvas, {
          type: "bar",
          data: {
            labels: labels,
            datasets: [
              {
                label: "Gestational Age", // Customize the label for the first data value
                data: dataValues1,
                backgroundColor: "rgba(0, 123, 255, 0.5)", // Customize the background color
                borderColor: "rgba(0, 123, 255, 1)", // Customize the border color
                borderWidth: 1, // Customize the border width
              },
              {
                label: "Weight", // Customize the label for the second data value
                data: dataValues2,
                backgroundColor: "rgba(255, 0, 0, 0.5)", // Customize the background color
                borderColor: "rgba(255, 0, 0, 1)", // Customize the border color
                borderWidth: 1, // Customize the border width
              },{
                label: "Heart Rate", // Customize the label for the second data value
                data: dataValues2,
                backgroundColor: "rgba(255, 0, 0, 0.5)", // Customize the background color
                borderColor: "rgba(255, 0, 0, 1)", // Customize the border color
                borderWidth: 1, // Customize the border width
              },
            ],
          },
          options: {
            // Customize the chart options as needed
          },
        });
      }
    const chart = new Chart(canvas, {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: selectedDataType,
            data: dataValues,
            backgroundColor: "rgba(0, 123, 255, 0.5)",
            borderColor: "rgba(0, 123, 255, 1)",
            borderWidth: 1,
          },
        ],
      },
      options: {
        // Customize the chart options as needed
      },
    });
  }
}
