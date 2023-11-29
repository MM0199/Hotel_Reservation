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
  profileLink.textContent = 'User Account';
  profileLink.href = 'userAccount.html'; // Link to the user account page
} else {
  profileLink.textContent = 'Login';
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
        localStorage.setItem('checkIn', checkInDateStr);
        localStorage.setItem('checkOut', checkoutDateStr);
        var checkInDate = new Date(localStorage.getItem('checkIn'));
        var checkOutDate = new Date(localStorage.getItem('checkOut'));
        var timeDifference = checkOutDate - checkInDate;
        var totalDays = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
        var Price;
        switch(localStorage.getItem('type')){
            case 'Single':
                Price = 100.00;
                break;
    
            case 'Double':
                Price = 200.00;
                break;
    
            case 'Suite':
                Price = 300.00;
                break;
    
            case 'Deluxe':
                Price = 400.00;
                break;
    
            case 'Villa':
                Price = 550.00;
                break;
    
            case 'Penthouse':
                Price = 650.00;
                break;
    
            case 'Presidential Suite':
                Price = 750.00;
                break;
    
            default:
                Price = 0;
                break;
    
        }
        var totalAmount = totalDays * Price;
        localStorage.setItem('amount', totalAmount);
        document.getElementById("totalAmount").textContent = amount;
        window.location.href = "paymentForm.html";
    }
}

function paymentValidate() {
    const cardNumber = document.getElementById('input[name="card_number"]').value;
    const cardholderName = document.getElementById('input[name="cardholderName"]').value;
    const expirationDate = document.getElementById('input[name="expirationDate"]').value;
    const cvv = document.getElementById('input[name="cvv"]').value;

    // Example: Basic input validation
    if (!cardNumber || !cardholderName || !expirationDate || !cvv) {
        alert("Please fill in all required fields.");
    } else if (!isValidCardNumber(cardNumber)) {
        alert("Please enter a valid card number.");
    } else if (!isValidExpirationDate(expirationDate)) {
        alert("Please enter a valid expiration date (MM/YY format).");
    } else if (!isValidCVV(cvv)) {
        alert("Please enter a valid CVV.");
    } else {
        // If all input is valid, redirect to the paymentForm.html
        window.location.href = "completeReservation.html";
    }
}

function isValidCardNumber(cardNumber) {
    // Implement card number validation logic here
    return true; // Replace with your validation logic
}

function isValidExpirationDate(expirationDate) {
    // Implement expiration date validation logic here
    return true; // Replace with your validation logic
}

function isValidCVV(cvv) {
    // Implement CVV validation logic here
    return true; // Replace with your validation logic
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
  }

// Validate the account creation
function accountValidate(){
    const firstName = document.getElementById("firstname").value;
    const lastName = document.getElementById("lastname").value;
    const userName = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("repeatpassword").value;
    const phoneNumber = document.getElementById("phonenumber").value;
    const birthDate = document.getElementById("birthdate").value;

    // Validate required fields
    if (!firstName || !lastName  || !userName || !email || !password || !confirmPassword || !phoneNumber || !birthDate) {
        alert("Please fill in all required fields.");
    }

    // Validate email format
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!email.match(emailPattern)) {
        alert("Invalid email address.");

    }

    // Validate password strength
    if (password.length < 8) {
        alert("Password must be at least 8 characters.");
    }

    // Confirm matching passwords
    if (password !== confirmPassword) {
        alert("Passwords do not match.");
    }

    // Validate phone number format (accepts xxx-xxx-xxxx or (xxx) xxx-xxxx)
    if (phoneNumber.length != 10) {
        alert("Invalid phone number format.");
    }

    window.location.href = "completeRegistration.html";    
}

// Back to Home Page
function backHome(){
    window.location.href = "home.html";
}


