function validateForm() {
    let email = document.getElementById('email').value.trim();
    let confirmEmail = document.getElementById('confirmEmail').value.trim();
    let date = document.getElementById('date').value;

    if (!email || !confirmEmail) {
        alert("Email fields cannot be empty!");
        return false;
    }

    if (email !== confirmEmail) {
        alert("Emails do not match!");
        return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Please enter a valid email address!");
        return false;
    }

    if (!date || new Date(date) < new Date()) {
        alert("Please select a valid future date!");
        return false;
    }

    alert("Thank you! Your form has been successfully submitted.");
    document.getElementById('contactForm').reset();
    return true;
}
function validateRegistrationForm() {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();

    
    if (username === "") {
        alert("Username is required.");
        return false;
    }
    if (username.length < 3 || username.length > 15) {
        alert("Username must be between 3 and 15 characters.");
        return false;
    }

    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    
    if (password === "") {
        alert("Password is required.");
        return false;
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }

   
    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

   
    alert("Registration successful!");
    document.getElementById('registerForm').reset();
    return true;
}
function validateLoginForm() {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (email === "") {
        alert("Email or Username is required.");
        return false;
    }

    if (password === "") {
        alert("Password is required.");
        return false;
    }

    alert("Login successful!");
    return true;
}
function validateRecipeForm() {
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    const ingredients = document.getElementById('ingredients').value.trim();
    const instructions = document.getElementById('instructions').value.trim();
    const image = document.getElementById('image').files[0];

    
    if (title === "" || description === "" || ingredients === "" || instructions === "") {
        alert("All fields are required.");
        return false;
    }

    
    if (image && image.type.split('/')[0] !== 'image') {
        alert("Please upload a valid image file.");
        return false;
    }

    alert("Recipe submitted successfully!");
    document.getElementById('addRecipeForm').reset();
    return true;
}

document.getElementById('search-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const query = document.getElementById('search-bar').value.trim().toLowerCase();

    const recipes = document.querySelectorAll('.recipe');
    recipes.forEach(recipe => {
        const title = recipe.querySelector('.title').textContent.toLowerCase();
        const description = recipe.querySelector('.description').textContent.toLowerCase();

        if (title.includes(query) || description.includes(query)) {
            recipe.style.display = 'block';
        } else {
            recipe.style.display = 'none';
        }
    });
});



