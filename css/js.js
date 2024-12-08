const urlParams = new URLSearchParams(window.location.search);
const successParam = urlParams.get('success');

// Display success message if applicable
if (successParam === 'true') {
    swal("Success", "Your message was successfully sent!", "success")
        .then(() => {
            // Redirect to clear query parameter
            window.location.href = window.location.pathname;
        });
} else if (successParam === 'false') {
    swal("Error", "XSS attempt detected! Your input has been cleared.", "error");
}

// Function to detect XSS in user input
function detectXSS(inputField, fieldName) {
    const xssPattern = /<script[\s\S]*?>[\s\S]*?<\/script>/i;
    inputField.addEventListener('input', function() {
        if (xssPattern.test(this.value)) {
            // Send AJAX request to PHP mailer script
            sendXSSAlert(fieldName, this.value);
            swal("Fuk u", `Lubton nuon tika`, "error");
            this.value = ""; // Clear the input field
        }
    });
}

// Function to send XSS alert to the server
function sendXSSAlert(fieldName, inputValue) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            console.log(xhr.responseText); // Optional: log the response from the server
        }
    };
    xhr.send("fieldName=" + encodeURIComponent(fieldName) + "&inputValue=" + encodeURIComponent(inputValue));
}

// Initialize XSS detection on the input fields
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const textarea = document.getElementById('message');

detectXSS(nameInput, 'Name');
detectXSS(emailInput, 'Email');
detectXSS(textarea, 'Message');

//  <script>
//     const urlParams = new URLSearchParams(window.location.search);
//     const successParam = urlParams.get('success');

//     // Display success message if applicable
//     if (successParam === 'true') {
//         swal("Success", "Your message was successfully sent!", "success")
//             .then(() => {
//                 // Redirect to clear query parameter
//                 window.location.href = window.location.pathname;
//             });
//     } else if (successParam === 'false') {
//         swal("Error", "XSS attempt detected! Your input has been cleared.", "error");
//     }

//     // Function to detect XSS in user input
//     function detectXSS(inputField, fieldName) {
//         const xssPattern = /<script[\s\S]*?>[\s\S]*?<\/script>/i;
//         inputField.addEventListener('input', function() {
//             if (xssPattern.test(this.value)) {
//                 // Send AJAX request to PHP mailer script
//                 sendXSSAlert(fieldName, this.value);
//                 swal("XSS Detected", "Please avoid using script tags in your input.", "error");
//                 this.value = ""; // Clear the input field
//             }
//         });
//     }

//     // Function to send XSS alert to the server
//     function sendXSSAlert(fieldName, inputValue) {
//         const xhr = new XMLHttpRequest();
//         xhr.open("POST", "index.php", true);
//         xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         xhr.onreadystatechange = function () {
//             if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
//                 console.log(xhr.responseText); // Optional: log the response from the server
//             }
//         };
//         xhr.send("fieldName=" + encodeURIComponent(fieldName) + "&inputValue=" + encodeURIComponent(inputValue));
//     }

//     // Initialize XSS detection on the input fields
//     const nameInput = document.getElementById('name');
//     const emailInput = document.getElementById('email');
//     const textarea = document.getElementById('message');
    
//     detectXSS(nameInput, 'Name');
//     detectXSS(emailInput, 'Email');
//     detectXSS(textarea, 'Message');
// </script> 
