var loader = document.getElementById("preloader");
window.addEventListener("load", function() {

    setTimeout(function() {
        loader.classList.add("hidden"); 
        setTimeout(function() {
            loader.style.display = "none"; 
        }, 1000); 
    }, 3000); 
});
let startTime = Date.now();

window.addEventListener('beforeunload', function () {
    let duration = Math.round((Date.now() - startTime) / 1000); // Duration in seconds
    console.log('Sending duration:', duration); // Add this to debug

    // Calculate minutes and seconds
    let minutes = Math.floor(duration / 60);
    let seconds = duration % 60;

    // Send duration via AJAX to the same page
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);  // Empty URL to send to the same page
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Duration sent successfully");
        }
    };

    // Send duration data to the server
    xhr.send("duration=" + duration + "&minutes=" + minutes + "&seconds=" + seconds);
});