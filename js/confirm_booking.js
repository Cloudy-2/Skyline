// Function to toggle pop-up visibility
function togglePopup(popupId) {
    var popup = document.getElementById(popupId);
    if (popup.style.display === "none" || popup.style.display === "") {
        popup.style.display = "block";
    } else {
        popup.style.display = "none";
    }
}

// Function to close pop-up upon successful login
function loginAndClosePopup(popupId) {
    // Simulate login process
    // Here, you can perform your login logic
    var emailOrMobile = '';
    var password = '';
    if (popupId === 'paypal-popup') {
        emailOrMobile = document.getElementById('paypal-email-or-mobile').value;
        password = document.getElementById('paypal-password').value;
        // Handle PayPal login here
        // Display a notification message
        alert("Logged in with PayPal successfully!");
    } else if (popupId === 'mastercard-popup') {
        emailOrMobile = document.getElementById('mastercard-username').value;
        password = document.getElementById('mastercard-password').value;
        // Handle Mastercard login here
        // Display a notification message
        alert("Logged in with Mastercard successfully!");
    } else if (popupId === 'gcash-popup') {
        // Handle GCash login here
        // Display a notification message
        alert("Logged in with GCash successfully!");
    }

    // Close the pop-up upon successful login
    togglePopup(popupId);
    // Enable the radio buttons after successful login
    enableRadioButtons();
}

// Function to validate input and perform login
function validateAndLogin(inputField1, inputField2, popupId, username) {
    var input1 = document.getElementById(inputField1).value;
    var input2 = document.getElementById(inputField2).value;

    if (!input1 || !input2) {
        alert("Please enter your information.");
        return;
    }

    // Perform login process
    loginAndRedirectToGcash(username);
}

// Function to handle GCash login and redirect
function loginAndRedirectToGcash(username) {
    // Assuming login is successful, redirect to gcash.php
    var mobileNumber = document.getElementById('gcash-mobile-number').value;
    var overallPrice = document.getElementById("displayed_overall_price").textContent;

    // Redirect to gcash.php with necessary parameters
    window.location.href = `gcash.php?mobile=${mobileNumber}&amount=${overallPrice}&username=${username}`;
}

// Function to update GCash amount
function updateGcashAmount() {
    var overallPrice = document.getElementById("displayed_overall_price").textContent;
    document.getElementById("gcash-amount").textContent = overallPrice;
}

document.addEventListener("DOMContentLoaded", function() {
    // Initialize totalPriceElement after the DOM has fully loaded
    var totalPriceElement = document.querySelector(".total-price");
    // Check if totalPriceElement is not null before accessing its properties
    if (totalPriceElement) {
        var totalPrice = parseFloat(totalPriceElement.innerText.replace("Overall Price: ₱", ""));
        document.getElementById("displayed_overall_price").textContent = totalPrice.toFixed(2);
    } else {
        console.error("Total price element not found.");
    }

    // Attach event listener to GCash radio button
    document.getElementById("gcash-radio").addEventListener("click", updateGcashAmount);
});

