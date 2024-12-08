
<?php
session_start();
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); 
ini_set('session.use_strict_mode', 1); 


// In your header or a central initialization file
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
     header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
     exit();
 }

function isValidUrl($url) {
     return preg_match('/^https?:\/\/(www\.)?itinventorymanagement\.com/', $url);
 }
 
 // Example usage of the function
 $link = "https://itinventorymanagement.com";
 if (isValidUrl($link)) {
     
 } else {
     echo "Invalid URL.";
 }

if (basename($_SERVER['PHP_SELF']) == 'header.php') {
     header("HTTP/1.1 403 Forbidden");
     exit("Access denied.");
 }

 // Add CSP header
 header("Content-Security-Policy: default-src 'self'; script-src 'self' https://itinventorymanagement.com;");
 header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
 header("X-Content-Type-Options: nosniff");
 header("X-Frame-Options: DENY");
 header("X-XSS-Protection: 1; mode=block");
 header("Referrer-Policy: no-referrer");
 header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
 header('Pragma: no-cache');
 header('Expires: 0');
 header('Content-Type: text/html; charset=utf-8');
 header("X-Frame-Options: SAMEORIGIN");
 header("Referrer-Policy: strict-origin-when-cross-origin");
 header("Permissions-Policy: geolocation=()");
 
 
foreach ($_GET as $key => $value) {
    $_GET[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
foreach ($_COOKIE as $key => $value) {
    $_COOKIE[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

?>
<?php
date_default_timezone_set('Asia/Manila');
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
		<meta charset="utf-8" />
 		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
 		<meta name="description" content="" />
 		<meta name="author" content="" />
 		<script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
 		<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
 		<link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
 		    rel="stylesheet" type="text/css" />
 		<link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css"
 		    rel="stylesheet" />
 		<link href="ads/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
 		<link href="css/styles.css" rel="stylesheet" />
 		<script src="ads/assets/vendor/jquery/jquery.min.js"></script>
 		<script src="ads/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		