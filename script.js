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
        window.location.href = "paymentForm.html";
    }
}

function paymentValidate() {

    document.getElementById('card_number').addEventListener('input', function (e) {
        const target = e.target;
        const input = target.value.replace(/\D/g, '').substring(0, 16); // Allow only digits and limit length to 16

        // Add space every 4 characters for better readability
        target.value = input.replace(/(\d{4})(?=\d)/g, '$1 ');
    });

    const cardNumber = document.getElementById("card_number").value;
    const cardholderName = document.getElementById("cardholderName").value;
    const expirationDateMonth = document.getElementById("expirationDateMonth").value;
    const expirationDateYear = document.getElementById("expirationDateYear").value;
    const cvv = document.getElementById("cvv").value;

    // Example: Basic input validation
    if (!cardNumber || !cardholderName || !expirationDateMonth || !expirationDateYear || !cvv) {
        alert("Please fill in all required fields.");
        return;
    }

    if (cardNumber.length != 16) {
        alert("Please enter a valid card number.");
        return;
    }

    if (expirationDateMonth === '' || expirationDateYear === '') {
        alert("Please enter a valid expiration date (MM/YY format).");
        return;
    }

    if (cvv.length != 3) {
        alert("Please enter a valid CVV.");
        return;
    }
        alert("Payment Successful!");
        window.location.href = "completeReservation.html";
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


