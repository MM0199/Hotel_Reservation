// Save guest login status
function saveLoginStatus() {
    // Check if both username and password fields are not empty
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
  
    if (username.trim() !== '' && password.trim() !== '') {
      localStorage.setItem('isLoginStatus', 'true');
      // Check if the user is logged in and redirect to the appropriate page
      if (localStorage.getItem('isLoginStatus') === 'true') {
        window.location.href = 'userAccount.html';
      } else {
        window.location.href = 'home.html';
      }
    } else {
      alert('Please fill in both username and password.');
    }
  }
// Check if the user is logged in and adjust the sidebar links
if (localStorage.getItem("isLoginStatus") === "true") {
    document.getElementById("loginLink").style.display = "none";
    document.getElementById("logoutLink").style.display = "block";
}

// Check if the user is logged in and adjust the profile link
const profileLink = document.getElementById('profileLink');

if (localStorage.getItem('isLoginStatus') === 'true') {
    document.getElementById('profile-pic').alt = 'User Account';
    profileLink.href = 'userAccount.html'; // Link to the user account page
} else {
    profileLink.href = 'login.html'; // Link to the login page
}

// Function to log out
function logout() {
    localStorage.setItem("isLoginStatus", "false");
    // Redirect to the login page or any other page as needed
    window.location.href = "home.html";
}

// Check if the user is logged in and adjust the correct links
function getRoom() {
    if(localStorage.getItem("isLoginStatus") === "true") {
        window.location.href = "reservationDetail.html";
    } else {
        window.location.href = "reservationGuest.html";
    }
}

// Sidebar controller
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

// Validate the date range
function dateValidate(){
    const checkInDateStr = document.getElementById("check-in-date").value;
    const checkoutDateStr = document.getElementById("check-out-date").value;
    const currentDay = formatDate(new Date());

    if(currentDay >= checkInDateStr){
        alert("The closest check-in day is tomorrow.");
    } else if(checkoutDateStr <= checkInDateStr){
        alert("Invalid date range");
    } else {
        window.location.href = "paymentForm.html";
    }
}

function paymentValidate() {
    const cardNumber = document.getElementById('card_number').value;
    const cardholderName = document.getElementById('cardholderName').value;
    const expirationMonth = document.getElementById('expirationMonth').value;
    const expirationYear = document.getElementById('expirationYear').value;
    const cvv = document.getElementById('cvv').value;

    // Example: Basic input validation
    if (!cardNumber || !cardholderName || !expirationMonth || !expirationYear || !cvv) {
        alert("Please fill in all required fields.");
    } if (!isValidCardNumber(cardNumber)) {
        alert("Please enter a valid card number.");
    } if (!isValidExpirationDate(expirationDate)) {
        alert("Please enter a valid expiration date (MM/YY format).");
    }  if (!isValidCVV(cvv)) {
        alert("Please enter a valid CVV.");
    } else {
        // If all input is valid, redirect to the paymentForm.html
        window.location.href = "completeReservation.html";
    }
}



function formatDate(date) {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
  }

// Validate the account creation
function guestInforValidate(){
    const firstName = document.getElementById("firstname").value;
    const lastName = document.getElementById("lastname").value;
    const email = document.getElementById("email").value;
    const phoneNumber = document.getElementById("phone").value;
    const birthDate = document.getElementById("birthdate").value;
    const address = document.getElementById("address").value;
    const address2 = document.getElementById("address2").value;
    const city = document.getElementById("city").value;
    const state = document.getElementById("state").value;
    const zipcode = document.getElementById("zipcode").value;

    const combinedAddress = !address2 ? address + ' ' + city + ', ' + state + ' ' + zipcode : address + ' ' + address2 + ' ' + city + ', ' + state + ' ' + zipcode;

    // Validate required fields
    if (!firstName || !lastName  || !email || !phoneNumber || !birthDate || !address || !city || !state || !zipcode) {
        alert("Please fill in all required fields.");
    }

    // Validate email format
    else if (!email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/)) {
        alert("Invalid email address.");
    }

    // Validate phone number format (accepts xxx-xxx-xxxx or (xxx) xxx-xxxx)
    else if (phoneNumber.length != 10) {
        alert("Invalid phone number format.");
    } else {
        window.location.href = "reservationDetail.html";
    }
  
}

// Back to Home Page
function backHome(){
    window.location.href = "home.html";
}


