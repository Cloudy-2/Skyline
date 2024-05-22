function togglePopup(popupId) {
    var popup = document.getElementById(popupId);
    if (popup.style.display === "none" || popup.style.display === "") {
        popup.style.display = "block";
    } else {
        popup.style.display = "none";
    }
}

document.getElementById('confirmButton').addEventListener('click', function() {
    // Check if the required inputs are filled
    var mobileNumber = document.getElementById('gcash-mobile-number').value.trim();
    var mpin = document.getElementById('gcash-password').value.trim();
    if (mobileNumber === '' || mpin === '') {
        alert("Please fill in all required fields.");
        return; // Prevent further execution
    }
    
    // If inputs are filled, proceed with the action
    document.getElementById('gcash-popup').style.display = 'none';
    document.getElementById('unique-receipt-container').style.display = 'block';
});

document.getElementById('PconfirmButton').addEventListener('click', function() {
    // Check if the required inputs are filled
    var emailOrMobile = document.getElementById('paypal-email-or-mobile').value.trim();
    var password = document.getElementById('paypal-password').value.trim();
    if (emailOrMobile === '' || password === '') {
        alert("Please fill in all required fields.");
        return; // Prevent further execution
    }
    
    // If inputs are filled, proceed with the action
    document.getElementById('paypal-popup').style.display = 'none';
    document.getElementById('unique-receipt-container').style.display = 'block';
});

document.getElementById('doneButton').addEventListener('click', function() {
    document.getElementById('unique-receipt-container').style.display = 'none';
});

document.addEventListener("DOMContentLoaded", function() {
    var totalPriceElement = document.querySelector(".total-price");
    if (totalPriceElement) {
        var totalPrice = parseFloat(totalPriceElement.innerText.replace("Overall Price: ₱", ""));
        document.getElementById("displayed_overall_price").textContent = totalPrice.toFixed(2);
    } else {
        console.error("Total price element not found.");
    }
});

// Function to calculate total price based on accommodation selection for each passenger
function calculateTotalPrice(passengerIndex) {
    var selectedAccommodation = document.getElementById("accommodation_" + passengerIndex).value;
    var originalPrice = parseFloat(document.getElementById("mainticket1").value);

    var ticketPrice = originalPrice; 
    if (selectedAccommodation === "Business") {
        ticketPrice *= 1.5; 
    } else if (selectedAccommodation === "First Class") {
        ticketPrice *= 2; 
    }

    var dob = new Date(document.getElementById("dob_" + passengerIndex).value);
    var today = new Date();
    var age = today.getFullYear() - dob.getFullYear();
    if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
        age--;
    }

    if (age >= 60) {
        ticketPrice *= 0.9; 
        document.getElementById("discount_indicator_" + passengerIndex).style.display = "inline";
    } else {
        document.getElementById("discount_indicator_" + passengerIndex).style.display = "none";
    }

    document.getElementById("displayed_ticket_price_" + passengerIndex).textContent = ticketPrice.toFixed(2);
    document.getElementById("hidden_ticket_price_" + passengerIndex).value = ticketPrice.toFixed(2);

    updateOverallPrice();
}
function previewImage(event) {
    var imagePreview = document.getElementById('imagePreview');
    var fileInput = event.target.files[0]; // Get the selected file
    var reader = new FileReader();

    reader.onload = function() {
        imagePreview.src = reader.result; // Set the source of the image to the file reader's result
        imagePreview.style.display = 'block'; // Make the image visible
    }

    if (fileInput) {
        reader.readAsDataURL(fileInput); // Read the file as a data URL
    }
}function closePopupAndUnselectRadio(popupId, radioId) {
    // Close the popup
    var popup = document.getElementById(popupId);
    if (popup) {
        popup.style.display = "none";
    } else {
        console.error("Popup element not found.");
    }

    // Unselect the radio button
    var radio = document.getElementById(radioId);
    if (radio) {
        radio.checked = false;
    } else {
        console.error("Radio button element not found.");
    }
}
