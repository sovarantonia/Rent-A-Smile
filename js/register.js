// const signUpForm = document.getElementById("register-form");
// const firstName = document.getElementById("firstName");
// const lastName = document.getElementById("lastName");
// const signUpEmail = document.getElementById("sign-up-email");
// const signUpPassword = document.getElementById("sign-up-password");
// const confirmPassword = document.getElementById("confirm-password");
//
// const firstNameError = document.getElementById("first-name-error");
// const lastNameError = document.getElementById("last-name-error");
// const signUpEmailError = document.getElementById("sign-up-email-error");
// const signUpPasswordError = document.getElementById("sign-up-password-error");
// const confirmPasswordError = document.getElementById("confirm-password-error");
//
// const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
// const nameRegex = /^[A-Z][A-Za-z]*(-[A-Za-z]+)*$/;
//
// firstNameError.innerText = "";
// lastNameError.innerText = "";
// signUpEmailError.innerText = "";
// signUpPasswordError.innerText = "";
// confirmPasswordError.innerText = "";
//
// signUpForm.addEventListener("submit", function (event){
//     event.preventDefault();
//     if (signUpEmail.value === "" || signUpPassword.value === "" || firstName === "" || lastName === "" || confirmPassword === "") {
//         alert("Please complete all the fields.");
//         return;
//     };
//
//     if(signUpPassword.value !== confirmPassword.value){
//         alert("The passwords are not the same");
//         return;
//     };
//
//     if(!nameRegex.test(firstName.value) || !nameRegex.test(firstName.value)){
//         alert("Invalid name format.")
//         return;
//     }
// });
//
// signUpEmail.addEventListener("blur", function (event){
//     event.preventDefault();
//     signUpEmailError.innerText = ""
//     if (signUpEmail.value === ""){
//         signUpEmailError.innerText = "Enter the email adress."
//         return;
//     }
// });
//
// firstName.addEventListener("blur", function (event){
//     event.preventDefault();
//     firstNameError.innerText = ""
//     if (firstName.value === ""){
//         firstNameError.innerText = "Enter the first name."
//         return;
//     }
//     if(!nameRegex.test(firstName.value)){
//         firstNameError.innerText = "Invalid first name format."
//         return;
//     }
// });
//
// lastName.addEventListener("blur", function (event){
//     event.preventDefault();
//     lastNameError.innerText = ""
//     if (lastName.value === ""){
//         lastNameError.innerText = "Enter the last name."
//         return;
//     }
//     if(!nameRegex.test(lastName.value)){
//         lastNameError.innerText = "Invalid last name format."
//     }
// });
//
// signUpPassword.addEventListener("blur", function (event){
//     event.preventDefault();
//     signUpPasswordError.innerText = ""
//     if (signUpPassword.value === ""){
//         signUpPasswordError.innerText = "Enter the password."
//         return;
//     };
//     if(signUpPassword.length < 5){
//         signUpPasswordError.innerText = "Password should have at least 5 characters"
//         return;
//     }
// });
//
// confirmPassword.addEventListener("blur", function (event){
//     event.preventDefault();
//     confirmPasswordError.innerText = ""
//     if (confirmPassword.value === ""){
//         signUpPasswordError.innerText = "Enter the password."
//         return;
//     };
//
// });

const validation = new JustValidate("#register-form");

validation
    .addField("#firstName", [
        {
            rule: "required"
        }
    ])
    .addField("#lastName", [
        {
            rule: "required"
        }
    ])
    .addField("#sign-up-email", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            validator: (value) => () => {
                return fetch("validate-email.php?email=" + encodeURIComponent(value))
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(json) {
                        return json.available;
                    });
            },
            errorMessage: "email already taken"
        }
    ])
    .addField("#sign-up-password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#confirm-password", [
        {
            validator: (value, fields) => {
                return value === fields["#sign-up-password"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ])
    .onSuccess((event) => {
        document.getElementById("register-form").submit();
    });