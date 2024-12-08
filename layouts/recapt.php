<script src="https://www.google.com/recaptcha/api.js?render=6LevInsqAAAAABmwkd9fu9yaQUhyO7Z2tkceE2nA"></script>
<script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('6LevInsqAAAAABmwkd9fu9yaQUhyO7Z2tkceE2nA', {action: 'submit'}).then(function(token) {
          });
        });
      }
  </script>