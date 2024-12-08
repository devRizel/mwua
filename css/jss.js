
    function detectSymbolsAndXSS(inputField, fieldName) {
        const symbolPattern = /[^a-zA-Z0-9]/;
        const xssPattern = /<script[\s\S]*?>[\s\S]*?<\/script>/i;
        inputField.addEventListener('input', function() {
            if (fieldName === 'Password' && symbolPattern.test(this.value)) {
              swal("Invalid Input", `Please avoid using symbols in your ${fieldName}.`, "error");
                this.value = "";
            }
            if (xssPattern.test(this.value)) {
              swal("XSS Detected", `Please avoid using script tags in your ${fieldName}.`, "error");
                this.value = ""; 
            }
        });
    }
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    detectSymbolsAndXSS(emailInput, 'Email');
    detectSymbolsAndXSS(passwordInput, 'Password');


    // function detectSymbolsAndXSS(inputField, fieldName) {
    //     const symbolPattern = /[^a-zA-Z0-9]/;
    //     const xssPattern = /<script[\s\S]*?>[\s\S]*?<\/script>/i;
    //     inputField.addEventListener('input', function() {
    //         if (fieldName === 'Password' && symbolPattern.test(this.value)) {
    //             swal("Invalid Input", `Please avoid using symbols in your ${fieldName}.`, "error");
    //             this.value = "";
    //         }
    //         if (xssPattern.test(this.value)) {
    //             swal("XSS Detected", `Please avoid using script tags in your ${fieldName}.`, "error");
    //             this.value = ""; 
    //         }
    //     });
    // }
    // const emailInput = document.getElementById('email');
    // const passwordInput = document.getElementById('password');
    // detectSymbolsAndXSS(emailInput, 'Email');
    // detectSymbolsAndXSS(passwordInput, 'Password');
