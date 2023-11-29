// Check if the user is logged in and adjust the profile link
const profileLink = document.getElementById('profileLink');
// Check if the user is logged in and adjust the sidebar links
if (localStorage.getItem("isLoginStatus") === "true") {
    document.getElementById("loginLink").style.display = "none";
    document.getElementById("logoutLink").style.display = "block";
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


// Sidebar controller
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

// Validate the date range
function reservationValidate() {
    // Get current date
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Month is zero-based
    var currentDay = currentDate.getDate().toString().padStart(2, '0');

    var currentDayStr = `${currentMonth}-${currentDay}-${currentYear}`;

    // Get selected check-in and check-out dates
    const checkInDateStr = document.getElementById("check-in-date").value;
    const checkoutDateStr = document.getElementById("check-out-date").value;

    if (currentDayStr === checkInDateStr) {
        alert("The closest check-in day is tomorrow.");
    } else if (checkoutDateStr < checkInDateStr) {
        alert("Invalid date range");
    } else {
        localStorage.setItem('checkIn', checkInDateStr);
        localStorage.setItem('checkOut', checkoutDateStr);

        var checkInDate = new Date(localStorage.getItem('checkIn'));
        var checkOutDate = new Date(localStorage.getItem('checkOut'));

        var timeDifference = checkOutDate - checkInDate;
        var totalDays = Math.max(Math.ceil(timeDifference / (1000 * 60 * 60 * 24)), 1);
        var Price = localStorage.getItem('rate');
        var numericPart = Price.match(/\d+(\.\d+)?/);
        var numericValue = parseFloat(numericPart[0]);
        var totalAmount = totalDays * numericValue;

        localStorage.setItem('amount', totalAmount);
        window.location.href = "paymentForm.html";
    }
}


function formatDate(date) {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
  }

// Validate the user infor input
function guestInforValidate(){
    const firstName = document.getElementById("first").value;
    const lastName = document.getElementById("last").value;
    const email = document.getElementById("email").value;
    const phoneNumber = document.getElementById("phonenum").value;
    const birthDate = document.getElementById("birthdate").value;
    const address = document.getElementById("address").value;
    const city = document.getElementById("city").value;
    const state = document.getElementById("state").value;
    const zip = document.getElementById("zipcode").value;

    // Validate required fields
    if (!firstName || !lastName || !email || !phoneNumber || !birthDate || !address || !city || !state || !zip) {
        alert("Please fill in all required fields.");
    }

    // Validate email format
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!email.match(emailPattern)) {
        alert("Invalid email address.");

    }

    // Validate phone number format (accepts xxx-xxx-xxxx or (xxx) xxx-xxxx)
    if (phoneNumber.length != 10) {
        alert("Invalid phone number format.");
    }
        localStorage.setItem('firstName', firstName);
        localStorage.setItem('lastName', lastName);
        window.location.href = "reservationDetail.html";
}

// Back to Home Page
function backHome(){
    window.location.href = "home.html";
}

function getInfor(room) {
    localStorage.setItem('roomNum', room.id);
    localStorage.setItem('type', document.getElementById(room.id + '_type').textContent);
    localStorage.setItem('rate', document.getElementById(room.id + '_rate').textContent);

    if(localStorage.getItem("isLoginStatus") === "true") {
        window.location.href = "reservationDetail.html";
    } else {
        window.location.href = "reservationGuest.html";
    }
}  