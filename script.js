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
function reservationValidate(){
    const checkInDateStr = document.getElementById("check-in-date").value;
    const checkoutDateStr = document.getElementById("check-out-date").value;
    const roomNum = document.getElementById("room-num").value;

    if(currentDay >= checkInDateStr){
        alert("The closest check-in day is tomorrow.");
    } else if(checkoutDateStr <= checkInDateStr){
        alert("Invalid date range");
    } else {
        localStorage.setItem('roomNum', roomNum);
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
    
            case 'Twin':
                Price = 150.00;
                break;
    
            case 'King':
                Price = 250.00;
                break;
    
            case 'Queen':
                Price = 220.00;
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
    const cardNumber = document.getElementById('card_number').value;
    const cardholderName = document.getElementById('cardholderName').value;
    const expirationMonth = document.getElementById('expirationMonth').value;
    const expirationYear = document.getElementById('expirationYear').value;
    const cvv = document.getElementById('cvv').value;

    // Example: Basic input validation
    if (!cardNumber || !cardholderName || !expirationMonth || !expirationYear || !cvv) {
        alert("Please fill in all required fields.");
    } else {
        var reservationData = {
            guestID: localStorage.getItem('guestId'),
            firstName: localStorage.getItem('firstName'),
            lastName: localStorage.getItem('lastName'),
            roomNumber: localStorage.getItem('roomNum'),
            checkInDate: localStorage.getItem('checkIn'),
            checkOutDate: localStorage.getItem('checkOut'),
            amount: localStorage.getItem('amount')
        }
        // Save reservation data to localStorage
        localStorage.setItem('reservationData', JSON.stringify(reservationData));

        // Now, you can send the data to the server using AJAX (assuming the server is PHP)
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "payment.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Handle the response from the server
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Data sent successfully.");
            }
        };

        // Convert reservationData to a query string
        var params = "data=" + encodeURIComponent(JSON.stringify(reservationData));

        // Send the data to the server
        xhr.send(params);
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
        localStorage.setItem('firstName', firstName);
        localStorage.setItem('lastName', lastName);
        window.location.href = "reservationDetail.html";
    }
  
}

// Back to Home Page
function backHome(){
    window.location.href = "home.html";
}


