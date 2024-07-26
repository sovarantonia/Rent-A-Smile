const loginForm = document.getElementById("login-form");
const loginEmail = document.getElementById("login-email");
const loginPassword = document.getElementById("login-password");

const emailError = document.getElementById("email-error");
const passwordError = document.getElementById("password-error");

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
emailError.innerText = "";
passwordError.innerText = "";

loginForm.addEventListener("submit", function (event) {
    event.preventDefault();
    if (loginEmail.value === "" || loginPassword.value === "") {
        alert("Please enter an email adress and password.");
        return;
    };
    if (!emailRegex.test(loginEmail.value)) {
        alert("Enter a valid email address.");
        return;
    };
    loginForm.submit();
});

loginEmail.addEventListener("blur", function (event) {
    event.preventDefault();
    emailError.innerText = "";
    if (loginEmail.value === "") {
        emailError.innerText = "Enter the email adress";
        return;
    }
    if (!emailRegex.test(loginEmail.value)) {
        emailError.innerText = "Enter a valid email address.";
        return;
    };
});

loginPassword.addEventListener("blur", function (event){
    event.preventDefault();
    passwordError.innerText = "";
    if (loginPassword.value === "") {
        passwordError.innerText = "Enter the password";
        return;
    }
});