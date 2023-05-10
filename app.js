const logged_in = document.querySelector(".login-status");
const login_btn = document.querySelector(".login-nav-btn");
const account_nav_btn = document.querySelector(".account-nav-btn");
const logout_nav_btn = document.querySelector(".logout-nav-btn");
console.log(login_btn)
var log_in_status = parseInt(logged_in.innerText); 
console.log(log_in_status);
if (log_in_status === 1) {
    login_btn.style.display = "none";
    account_nav_btn.style.display = "block";
    logout_nav_btn.style.display = "block";

}
