// scripts.js

function validateForm() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const captcha = document.getElementById("captcha").value;

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    const passwordRequirements = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,32}$/;
    if (!passwordRequirements.test(password)) {
        alert("Password does not meet the requirements.");
        return false;
    }

    return true;
}

function refreshCaptcha() {
    document.getElementById("captchaImage").src = 'captcha.php?' + Date.now();
}

function checkPassword() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword");
    const confirmPasswordValue = confirmPassword.value;

    const matchMessage = document.getElementById("matchMessage");

    if (password === confirmPasswordValue) {
        confirmPassword.classList.remove("invalid");
        confirmPassword.classList.add("valid");
        matchMessage.textContent = "Passwords match!";
        matchMessage.classList.remove("no-match");
        matchMessage.classList.add("match");
    } else {
        confirmPassword.classList.remove("valid");
        confirmPassword.classList.add("invalid");
        matchMessage.textContent = "Passwords do not match.";
        matchMessage.classList.remove("match");
        matchMessage.classList.add("no-match");
    }

    // Fade out message after 3 seconds
    setTimeout(() => {
        matchMessage.classList.add("fade-out");
    }, 3000);

    // Clear classes and text after fade out
    setTimeout(() => {
        matchMessage.classList.remove("match", "no-match", "fade-out");
        matchMessage.textContent = "";
    }, 3300);

    // Password strength checks (if applicable)
    const length = document.getElementById("length");
    const maxLength = document.getElementById("maxLength");
    const digit = document.getElementById("digit");
    const uppercase = document.getElementById("uppercase");
    const lowercase = document.getElementById("lowercase");
    const special = document.getElementById("special");

    length.classList.toggle("valid", password.length >= 8);
    length.classList.toggle("invalid", password.length < 8);

    maxLength.classList.toggle("valid", password.length <= 32);
    maxLength.classList.toggle("invalid", password.length > 32);

    digit.classList.toggle("valid", /\d/.test(password));
    digit.classList.toggle("invalid", !/\d/.test(password));

    uppercase.classList.toggle("valid", /[A-Z]/.test(password));
    uppercase.classList.toggle("invalid", !/[A-Z]/.test(password));

    lowercase.classList.toggle("valid", /[a-z]/.test(password));
    lowercase.classList.toggle("invalid", !/[a-z]/.test(password));

    special.classList.toggle("valid", /[\W_]/.test(password));
    special.classList.toggle("invalid", !/[\W_]/.test(password));
}
