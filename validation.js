function validateForm() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    if (name.length < 8) {
        alert("Name must be at least 8 characters long.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }
    if(email.value == email)
    {
        alert ("Email is unique");
        return false;
    }

    // Further validations can be added as needed.
    return true;
}
