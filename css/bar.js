var barcode = '';
var interval;

// Input event listener for the "last-barcode" input field
document.getElementById('last-barcode').addEventListener('input', function() {
    // Automatically submit the form when 5 characters are entered
    if (this.value.length === 5) {
        document.getElementById('serialForm').submit();
    }

    // If the input is cleared, reload the page to reset it
    if (this.value === '') {
        window.location.href = 'generatescannbarcode3.php?access=allowed';  // Adjust this to your original page if necessary
    }

    // Hide the "No product found" message when the input is cleared
    var noProductMessage = document.getElementById('noProductMessage');
    if (this.value === '' && noProductMessage) {
        noProductMessage.style.display = 'none';
    } else if (this.value !== '' && noProductMessage) {
        noProductMessage.style.display = 'block';
    }
});

// Keydown event listener to capture barcode scanning
document.addEventListener('keydown', function(evt) {
    if (interval) {
        clearInterval(interval);
    }

    // Check for Enter key to process the barcode
    if (evt.code == 'Enter') {
        if (barcode) {
            handleBarcode(barcode);
            barcode = ''; // Clear barcode after processing
        }
        return;
    }

    // Capture other keys except Shift for barcode
    if (evt.key != 'Shift') {
        barcode += evt.key;
        interval = setInterval(() => barcode = '', 20);
    }
});

// Function to handle the barcode and display it in the input field
function handleBarcode(scannedBarcode) {
    // Set the scanned barcode into the input field with id "last-barcode"
    document.getElementById('last-barcode').value = scannedBarcode;
}