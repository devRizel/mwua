document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    let successMessage = "";

    if (successParam === 'true') {
        if (urlParams.get('')) {
            successMessage = "";
        }

        swal("", successMessage, "success")
            .then((value) => {
                window.location.href = 'login.php?access=allowed';
            });
    }

    // Function to check if fields are empty before form submission
    const loginForm = document.querySelector('form');
    loginForm.addEventListener('submit', function(event) {
        const username = loginForm.elements['username'].value.trim();
        const password = loginForm.elements['password'].value.trim();

        if (username === '') {
            event.preventDefault(); // Prevent form submission

            swal({
                title: "Username can't be blank!",
                icon: "error",
                button: "OK"
            });
        } else if (password === '') {
            event.preventDefault(); // Prevent form submission

            swal({
                title: "Password can't be blank!",
                icon: "error",
                button: "OK"
            });
        }
    });
});