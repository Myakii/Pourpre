let error_message = document.getElementById("error_message");

let inputNameField = document.getElementById("inputNameField");
let inputFirstNameField = document.getElementById("inputFirstNameField");
let inputEmailField = document.getElementById("inputEmailField");
let inputPasswordField = document.getElementById("inputPasswordField");
let inputCPasswordField = document.getElementById("inputCPasswordField");
let inputPhoneField = document.getElementById("inputPhoneField");

let hidden_name = document.getElementById("hidden_name");
let hidden_first_name = document.getElementById("hidden_first_name");
let hidden_email = document.getElementById("hidden_email");
let hidden_password = document.getElementById("hidden_password");
let hidden_cpassword = document.getElementById("hidden_cpassword");
let hidden_phone_number = document.getElementById("hidden_phone_number");

inputNameField.addEventListener("input", function () {
    if (inputNameField.value === "") {
        hidden_name.style.display = "block";
    } else {
        hidden_name.style.display = "none";
    }
});

inputFirstNameField.addEventListener("input", function () {
    if (inputFirstNameField.value === "") {
        hidden_first_name.style.display = "block";
    } else {
        hidden_first_name.style.display = "none";
    }
});

inputEmailField.addEventListener("input", function () {
    if (inputEmailField.value === "") {
        hidden_email.style.display = "block";
    } else {
        hidden_email.style.display = "none";
    }
});

inputPasswordField.addEventListener("input", function () {
    if (inputPasswordField.value === "") {
        hidden_password.style.display = "block";
    } else {
        hidden_password.style.display = "none";
    }
});

inputCPasswordField.addEventListener("input", function () {
    if (inputCPasswordField.value === "") {
        hidden_cpassword.style.display = "block";
    } else {
        hidden_cpassword.style.display = "none";
    }
});

inputPhoneField.addEventListener("input", function () {
    if (inputPhoneField.value === "") {
        hidden_phone_number.style.display = "block";
    } else {
        hidden_phone_number.style.display = "none";
    }
});

// Cacher l'un des deux parties entre inscription et connexion
let login_form = document.getElementById('login_form');
let register_form = document.getElementById('register_form');
let register_button = document.getElementById('register_button');
let return_button = document.getElementById('return_button');
let picture_1 = document.getElementById('picture_1');
let picture_2 = document.getElementById('picture_2');

function show_login_form() {
    login_form.style.display = 'block';
    register_form.style.display = 'none';
    picture_1.style.display = 'block';
    picture_2.style.display = 'none';
}

function show_register_form() {
    login_form.style.display = 'none';
    register_form.style.display = 'block';
    picture_1.style.display = 'none';
    picture_2.style.display = 'block';
}

document.getElementById('register_button').addEventListener('click', show_register_form);
document.getElementById('return_button').addEventListener('click', show_login_form);

show_login_form();

// Changer la couleur du icon "home"
// let icon_home = document.getElementById('icon_home');

// if (icon_home) {
//     icon_home.addEventListener('mouseout', function () {
//         this.src = 'assets/home.svg';
//     });
// } else {
//     icon_home.addEventListener('mouseover', function () {
//         this.src = 'assets/home_pourpre.svg';
//     });
// }
