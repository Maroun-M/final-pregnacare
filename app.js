if (
  window.location.pathname === "/PregnaCare/index.php" ||
  window.location.pathname === "/PregnaCare/"
) {
  document.addEventListener("DOMContentLoaded", () => {
    const logged_in = document.querySelector(".login-status");
    const login_btn = document.querySelector(".login-nav-btn");
    const login_btn_mobile = document.querySelector(".login-nav-btn-mobile");
    const account_nav_btn = document.querySelector(".account-nav-btn");
    const logout_nav_btn = document.querySelector(".logout-nav-btn");
    var log_in_status = parseInt(logged_in.innerHTML);
    if (log_in_status === 1) {
      login_btn.style.display = "none";
      login_btn_mobile.style.display = "none";

      account_nav_btn.style.display = "block";
      logout_nav_btn.style.display = "block";
    } else {
      account_nav_btn.style.display = "none";
      logout_nav_btn.style.display = "none";
    }

    const hamburger = document.querySelector(".home-list");
    const nav_overlay = document.querySelector(".navbar-overlay");
    const nav_container = document.querySelector(".navbar-mobile-container");
    const empty_div = document.querySelector(".empty-div");
    hamburger.addEventListener("click", () => {
      nav_overlay.classList.add("nav-visible");
      nav_container.classList.add("nav-active");
    });

    empty_div.addEventListener("click", () => {
      nav_overlay.classList.remove("nav-visible");
      nav_container.classList.remove("nav-active");
    });
  });

  var homeVid = document.querySelector(".homeVid");
  console.log(window.innerWidth)
  if(window.innerWidth <= 500) {
    homeVid.src = "./images/vidMobile.mp4";
  }
  // Get the URL of the current page
  var url = window.location.href;
  // Create a URL object with the URL
  var urlObject = new URL(url);
  // Get the search parameters from the URL
  var searchParams = new URLSearchParams(urlObject.search);
  // Get the value of a specific parameter
  var parameterValue = searchParams.get("register");

  if (searchParams.get("register") === "") {
    document.querySelector(".signup-section").scrollIntoView();
  }

  // Get the target element
  const targetElement = document.querySelector(".front");

  // Create an intersection observer instance
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      const navbar = document.querySelector(".navbar-wrap");
      const navbar_container = document.querySelector(".navbar-container")
      if (!entry.isIntersecting) {
        navbar.style.background = "url('./images/nav-bg.png') no-repeat";

        console.log(navbar_container)

      } else if (entry.isIntersecting) {

        navbar.style.background = "";
      }
    });
  });
  // Start observing the target element
  observer.observe(targetElement);

  // Get form inputs
  var firstNameInput = document.getElementById("firstName");
  var lastNameInput = document.getElementById("lastName");
  var emailAddressInput = document.getElementById("emailAddress");
  var phoneNumberInput = document.getElementById("phoneNumber");
  var passwordInput = document.getElementById("password");
  var confirmPasswordInput = document.getElementById("confirm-password");
  var submitButton = document.querySelector('input[type="submit"]');

  // Function to check if all fields are valid
  function validateForm() {
    return (
      validateField(firstNameInput) &&
      validateField(lastNameInput) &&
      validateField(emailAddressInput) &&
      validateField(phoneNumberInput) &&
      validateField(passwordInput) &&
      validateField(confirmPasswordInput)
    );
  }

  // Function to validate individual field
  function validateField(field) {
    var errorElement = document.getElementById(field.id + "-error");
    var errorMessage = "";

    if (field.value.trim() === "") {
      errorMessage = "This field is required.";
    } else {
      switch (field.id) {
        case "firstName":
        case "lastName":
          if (!/^[a-zA-Z ]*$/.test(field.value.trim())) {
            errorMessage = "Only letters allowed.";
          }
          break;
        case "emailAddress":
          if (!/^[\w-.]+@([\w-]+\.)+[\w-]{2,}$/.test(field.value.trim())) {
            errorMessage = "Invalid email format.";
          }
          break;
        case "phoneNumber":
          if (
            !/^\+(?:[0-9] ?){6,14}[0-9]$/.test(field.value.trim()) ||
            field.value.length < 13 ||
            field.value.length > 13
          ) {
            errorMessage =
              "Invalid phone number, valid format is +961 01234567";
          }
          break;
        case "password":
          if (
            field.value.length < 8 ||
            !/[A-Z]/.test(field.value) ||
            !/[0-9]/.test(field.value)
          ) {
            errorMessage =
              "Password must be at least 8 characters long, contain at least one capital letter, and one digit.";
          }
          break;
        case "confirm-password":
          if (field.value !== passwordInput.value) {
            errorMessage = "Passwords do not match.";
          }
          break;
        default:
          break;
      }
    }

    errorElement.textContent = errorMessage;
    return errorMessage === ""; // Return true if field is valid
  }

  // Add event listeners to validate fields on input
  firstNameInput.addEventListener("input", function () {
    validateField(firstNameInput);
    submitButton.disabled = !validateForm();
  });
  lastNameInput.addEventListener("input", function () {
    validateField(lastNameInput);
    submitButton.disabled = !validateForm();
  });
  emailAddressInput.addEventListener("input", function () {
    validateField(emailAddressInput);
    submitButton.disabled = !validateForm();
  });
  phoneNumberInput.addEventListener("input", function () {
    if (!phoneNumberInput.value.startsWith("+961 ")) {
      phoneNumberInput.value = "+961 ";
    }
    validateField(phoneNumberInput);
    submitButton.disabled = !validateForm();
  });
  passwordInput.addEventListener("input", function () {
    validateField(passwordInput);
    validateField(confirmPasswordInput);
    submitButton.disabled = !validateForm();
  });
  confirmPasswordInput.addEventListener("input", function () {
    validateField(passwordInput);
    validateField(confirmPasswordInput);
    submitButton.disabled = !validateForm();
  });

  // Disable submit button initially
  submitButton.disabled = true;
}

// login form validation
if (window.location.pathname === "/PregnaCare/login.php") {
  var emailInput = document.getElementById("email");
  var passwordInput = document.getElementById("password");
  var loginBtn = document.getElementById("loginBtn");

  emailInput.addEventListener("input", validateInputs);
  passwordInput.addEventListener("input", validateInputs);

  function validateInputs() {
    var email = emailInput.value.trim();
    var password = passwordInput.value.trim();

    var isEmailValid = (/^[\w-.]+@([\w-]+\.)+[\w-]{2,}$/.test(email.trim()) || /^\d{8}$/.test(email));
    var isPasswordValid = password.length >= 8;

    loginBtn.disabled = !(isEmailValid && isPasswordValid);
  }
  document.querySelector(".sign-up-btn").addEventListener("click", () => {
    window.location.href = "index.php?register";
  });
  document.addEventListener("DOMContentLoaded", () => {
    var url = new URL(window.location.href);

    // Get the value of a specific parameter
    if (url.searchParams.has("error")) {
      const error_container = document.getElementById("passwordError");
      error_container.innerHTML = "Invalid email or password.";
    }
  });
}

if (window.location.pathname === "/PregnaCare/confirm.php") {
  const resend_btn = document.querySelector(".resend-btn");
  resend_btn.addEventListener("click", function eventListenerFunction() {
    // Disable the event listener
    resend_btn.removeEventListener("click", eventListenerFunction);

    // Reattach the event listener after 10 seconds
    setTimeout(() => {
      resend_btn.addEventListener("click", eventListenerFunction);
    }, 10000); // 10 seconds in milliseconds

    // Create a new XMLHttpRequest object
    const xhr = new XMLHttpRequest();
    // Set the request method and URL
    xhr.open("GET", "./src/register/register.php?resend=true", true);
    // Set the request header
    xhr.setRequestHeader("Content-Type", "application/json");
    // Handle the response
    xhr.onload = function () {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        const errorContaienr = document.querySelector(".confirm-error");
        errorContaienr.innerHTML = response.message;
      } else {
        console.error("Request failed");
      }
    };

    // Send the GET request
    xhr.send();
  });
}
const timer = 9000;
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;
let intervalId;

function showSlides() {
  const offset = -100 * slideIndex;
  document.querySelector('.slider').style.transform = `translateX(${offset}%)`;
}

function nextSlide() {
  slideIndex++;
  if (slideIndex >= totalSlides) {
    slideIndex = 0;
  }
  resetTimer();
  showSlides();
}

function prevSlide() {
  slideIndex--;
  if (slideIndex < 0) {
    slideIndex = totalSlides - 1;
  }
  resetTimer();
  showSlides();
}

function resetTimer() {
  clearInterval(intervalId); // Stop the current timer
  intervalId = setInterval(nextSlide, timer); // Start a new timer
}

resetTimer(); // Start the initial timer

document.addEventListener("DOMContentLoaded", function() {
  const leftArrow = document.querySelector(".arrow-left-container");
  const rightArrow = document.querySelector(".arrow-right-container");
  
  leftArrow.addEventListener("click", prevSlide);
  rightArrow.addEventListener("click", nextSlide);
});
