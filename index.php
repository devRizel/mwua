
<?php include 'theme/header.php'; ?>
<?php include 'process/security_index.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Management System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
        .chat-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--accent-color);
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 30px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .chat-button:hover {
          background-color: var(--accent-color);
        }

        .chat-icon {
            margin-right: 8px;
        }

        .chat-window {
            display: none;
            position: fixed;
            bottom: 70px;
            right: 20px;
            width: 350px;
            max-width: 100%;
            border: 1px solid #ccc;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: white;
            z-index: 1000;
            box-sizing: border-box;
        }

        .chat-header {
          background-color: var(--accent-color);
            color: white;
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            box-sizing: border-box;
        }

        .chat-content {
            padding: 10px;
            box-sizing: border-box;
        }

        .chat-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .chat-submit {
          background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
        }

        @media (max-width: 600px) {
            .chat-button {
                bottom: 10px;
                right: 10px;
                padding: 10px 15px;
                border-radius: 20px;
            }

            .chat-window {
                bottom: 60px;
                right: 10px;
                width: calc(100% - 20px);
            }
        }
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 20px; 
      }
      .marquee-text {
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    box-sizing: border-box;
    animation: marquee 10s linear infinite;
}

@keyframes marquee {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}
.marquee-text {
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    box-sizing: border-box;
    animation: marquee 10s linear infinite;
}

@keyframes marquee {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}
    }

        .btn-role {
            border-radius: 30px;
            padding: 10px 25px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
    
        .btn-role:hover {
            background-color: #0069d9;
        }
        .btn-gray {
            background: rgb(163,162,161);
            background: linear-gradient(90deg, rgba(163,162,161,1) 22%, rgba(23,23,22,1) 73%);
    color: white;         
    border: none;          
    padding: 10px 20px;    
    border-radius: 30px;
    cursor: pointer;       
    transition: background-color 0.3s; 
}

.btn-gray:hover {
    background: rgb(240,238,235);
    background: linear-gradient(90deg, rgba(240,238,235,1) 43%, rgba(56,54,52,1) 88%);
}

.btn-gray:disabled {
    background: rgb(240,238,235);
    background: linear-gradient(90deg, rgba(240,238,235,1) 43%, rgba(56,54,52,1) 88%);
    cursor: not-allowed;
}
.btn-suc {
    background: rgb(241,244,242);
    background: linear-gradient(90deg, rgba(241,244,242,1) 5%, rgba(92,149,70,1) 42%);
    color: white;      
    border: none;         
    padding: 10px 20px;    
    border-radius: 30px;
    cursor: pointer;       
    transition: background-color 0.3s; 
}

.btn-suc:hover {
    background: rgb(241,244,242);
    background: linear-gradient(90deg, rgba(241,244,242,1) 49%, rgba(92,149,70,1) 100%);
}

.btn-suc:disabled {
    background: rgb(241,244,242);
    background: linear-gradient(90deg, rgba(241,244,242,1) 49%, rgba(92,149,70,1) 100%);
    cursor: not-allowed;
}
.btn-pri {
    background: rgb(241,244,242);
    background: linear-gradient(90deg, rgba(241,244,242,1) 5%, rgba(70,118,149,1) 42%);
    color: white;    
    border: none;        
    padding: 10px 20px;    
    border-radius: 30px;
    cursor: pointer;       
    transition: background-color 0.3s; 
}

.btn-pri:hover {
    background: rgb(241,244,242);
    background: linear-gradient(90deg, rgba(241,244,242,1) 5%, rgba(70,118,149,1) 93%);
}

.btn-pri:disabled {
    background: rgb(241,244,242);
    background: linear-gradient(90deg, rgba(241,244,242,1) 5%, rgba(70,118,149,1) 93%);
    cursor: not-allowed;
}
.modal-content{
    background: rgb(203,204,203);
background: linear-gradient(90deg, rgba(203,204,203,1) 0%, rgba(147,149,150,1) 99%);
}


.marquee {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    box-sizing: border-box;
    text-align: center;
  }

  .marquee p {
    display: inline-block;
    padding-left: 100%;
    animation: marquee 10s linear infinite;
  }

  @keyframes marquee {
    0% {
      transform: translateX(100%);
    }
    100% {
      transform: translateX(-100%);
    }
  }
.g-recaptcha {
    display: block; 
    margin: 10px auto; 
    box-sizing: border-box;
    width: 302px;
}
.riz {
    background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.4)), url(uploads/users/mcc.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    padding: 0;
    height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 1200px) {
    .riz {
        height: 60vh;
    }
}

@media (max-width: 992px) {
    .riz {
        height: 50vh; 
    }

    h1.fade-in-right {
        font-size: 26px; 
    }

    h3.fade-in-left {
        font-size: 20px; 
    }

    p {
        font-size: 16px; 
    }
}

@media (max-width: 768px) {
    .riz {
        height: auto; 
        padding: 20px 10px;
    }

    .col-lg-8.h-100.my-auto.text-light {
        padding-top: 20px; 
    }

    h1.fade-in-right {
        font-size: 24px; 
    }

    h3.fade-in-left {
        font-size: 18px; 
    }

    p {
        font-size: 14px; 
    }

    .riz img {
        max-width: 100%; 
        height: auto; 
    }
}

@media (max-width: 576px) {
    h1.fade-in-right {
        font-size: 20px;
    }

    h3.fade-in-left {
        font-size: 16px; 
    }

    p {
        font-size: 12px; 
    }
}

.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    background: #fff; 
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
}
.nav-link {
    text-decoration: none;
    padding: 10px;
   
}

.nav-link.active {
    font-weight: bold;
    color: var(--accent-color);
    border-bottom: 2px solid var(--accent-color);
}
h6.fw-bold {
    color: black; 
} .navbar-toggler { border: none; }
        .navbar-toggler-icon { background-image: url('data:image/svg+xml;charset=utf8,%3Csvg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30"%3E%3Cpath stroke="%23333" stroke-width="2" d="M5 6h20M5 12h20M5 18h20" /%3E%3C/svg%3E'); }
        .hidden { opacity: 0; transform: translateY(20px); transition: opacity 0.5s, transform 0.5s; }
        .visible { opacity: 1; transform: translateY(0); }
        .sticky-active { position: fixed; top: 0; width: 100%; z-index: 1000; }
        .sticky-inactive { position: static; }
        .logo-img { max-width: 100%; height: auto; }
        .navbar-toggler {
         border: none;
}

.navbar-toggler-icon {
    background-image: url('data:image/svg+xml;charset=utf8,%3Csvg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30"%3E%3Cpath stroke="%23ff0000" stroke-width="2" d="M5 6h20M5 12h20M5 18h20" /%3E%3C/svg%3E');
    color: var(--accent-color);
    size: 15px;
}

.navbar-nav .nav-link {
    color: #555; 
    font-size: 17px;
    font-weight: bold;
    text-transform: none; 
    letter-spacing: 0; 
    line-height: 1.5;
    text-decoration: none; 
    padding: 0.5rem 1rem; /
}
.navbar-nav .nav-item {
    margin: 0 1rem; 
}


.navbar-nav .nav-link:hover,
.navbar-nav .nav-link:focus {
    color: var(--accent-color);
    font-size: 17px;
    text-decoration: none; 
}


.navbar-nav .nav-link.active {
    color: var(--accent-color);
    font-size: 17px;
    text-decoration: none; 
}


.navbar-toggler {
    border: none; 
    padding: 0.5rem; 
}
.btn-getstarted {
    background-color: var(--accent-color);
    color: white; 
    padding: 10px 20px;
    border-radius: 50px;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: background-color 0.3s ease;
}

.btn-getstarted:hover {
    color: white; 
    background-color: var(--accent-color);
}
#footer {
    height: 100px; 
    padding: 20px 0; 
    background-color: #f8f9fa; 
}
    .navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    z-index: 1000; 
    background-color: #fff; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}

body {
    padding-top: 70px; 
    font-family: Arial, sans-serif;
}

#hidden-section {
        opacity: 0;
        pointer-events: none; 
    }
  </style>

</head>

<body class="index-page">

<nav class="navbar navbar-expand-lg" style="background: #fff;">
    <div class="container-fluid d-flex align-items-center justify-content-between">
      
        <div class="d-flex align-items-center">
           
          
            <img src="assets/image/download.png" alt="Logo" style="width: 130px; height: 80px; margin-left: -18px;">
            
            <div class="d-none d-md-block">
            <h1 class="header-title text-blue ml-3" style="color: #666666; font-size: 20px;">
                IT DEPARTMENT
              </h1>
            </div>
            
            <div class="d-block d-md-none" style="margin-left: -13px;">
              <h1 class="header-title text-blue ml-3" style="color: #666666; font-size: 20px;">
                IT DEPARTMENTsss
              </h1>
            </div>
        </div>
            
       
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
        style="background-color: #f8f9fa; border-color: #c82333; padding: 8px; border-radius: 4px; margin-top: -8px; margin-right: -6px;">
            <span class="navbar-toggler-icon"></span>
        </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="#hero" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                    <a class="btn-getstarted" href="Security_Detected.php?access=allowed">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<br>
  <main class="main">
    <section id="hero" class="hero section riz">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <center><h1 style="color: white; font-size: 37px;">INVENTORY MANAGEMENT SYSTEM</h1></center>
            <br><br>
            <center><p style="color: white; font-size: 17px;">Please Select Portal to proceed.</p></center>
            <div class="d-flex justify-content-center" style="color: white;">
              <a style="color: white; border: 2px solid white;" data-bs-toggle="modal" data-bs-target="#signUpModal" class="btn-get-started">Portal</a>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img">
            <img src="uploads/users/bsit.png" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section>
    <section id="about" class="about section">
      <div class="container section-title" data-aos="fade-up">
        <h2>About Us</h2>
        <p>This system development is driven by the goal of enhancing the operational 
          efficiency of the IT Department, ensuring that all inventory is accounted for 
          and managed effectively. It will replace the time-consuming manual process with 
          an automated, reliable, 
          and scalable solution, leading to cost savings and improved resource management.</p>
      </div>
    </section>
  </main>
  
<div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="width: 100%; text-align: center; font-family: 'Arial', sans-serif; display: block;">Please Select a Portal</h5>
                <h5 class="modal-title" style="width: 100%; text-align: center; font-family: 'Arial', sans-serif; display: none;">Please Select a Portal to Scan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="d-flex justify-content-center gap-4" id="firstButtonGroup">
                    <a href="generate.php?access=allowed" class="btn btn-role btn-suc">Computer Units View</a>
                    <a href="generate2.php?access=allowed" class="btn btn-role btn-pri">Peripheral Devices View</a>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-role btn-gray" type="button" aria-expanded="false" id="scanDeviceBtn">
                        Scan Device?
                    </button>
                </div>
                <br>
                <div class="d-flex justify-content-center gap-1 d-none" id="secondButtonGroup">
                    <a href="generateview3.php?access=allowed" class="btn btn-role btn-suc">Computer Units Scan</a>
                    <a href="generateview4.php?access=allowed" class="btn btn-role btn-pri">Peripheral Devices Scan</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('scanDeviceBtn').addEventListener('click', function() {
        var firstButtonGroup = document.getElementById('firstButtonGroup');
        var secondButtonGroup = document.getElementById('secondButtonGroup');
        var firstTitle = document.querySelector('.modal-header h5:nth-child(1)');
        var secondTitle = document.querySelector('.modal-header h5:nth-child(2)');

        if (secondButtonGroup.classList.contains('d-none')) {
            firstTitle.style.display = 'none';
            secondTitle.style.display = 'block';
        } else {
            secondTitle.style.display = 'none';
            firstTitle.style.display = 'block';
        }
        if (firstButtonGroup.classList.contains('d-none')) {
                firstButtonGroup.classList.remove('d-none');
                secondButtonGroup.classList.add('d-none');
            } else {
                firstButtonGroup.classList.add('d-none');
                secondButtonGroup.classList.remove('d-none');
            }
    });
</script>
<i style="display: none;" class="mobile-nav-toggle d-xl-none bi bi-list"></i>




<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>




<footer id="footer" class="footer">
  <div class="container">
    <div class="copyright text-center">
        <center><p>Copyright © 2024
          <strong class="px-1 sitename">IT Team</strong>
          <span>All Right Reserved.</span> 
          <span>Created By <a href='https://www.facebook.com/rizelbrace2' target='_blank' style='color: var(--accent-color); text-decoration: none;'>Rizel Mulle Bracero</a></span>
        </center></p>
        <div class="social-links d-flex justify-content-center">
            <a href="https://www.facebook.com/profile.php?id=61553376179109"><i class="bi bi-facebook"></i></a>
        </div>
    </div>
  </div>
</footer>


  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/js/main.js"></script>
  <button class="chat-button" onclick="toggleChatWindow()">
        <span class="chat-icon">Message with us!</span>💬
    </button>

    <div class="chat-window" id="chatWindow">
    <div class="chat-header">
        Message with us!
        <button onclick="toggleChatWindow()" style="float:right; background: none; border: none; color: white;">&times;</button>
    </div>
    <div class="chat-content">
        <form id="chatForm" method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="chat-input" placeholder="Enter your name" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="chat-input" placeholder="Enter your email" required>
            <label for="message">Message</label>
            <textarea id="message" name="message" class="chat-input" placeholder="Enter your message" required></textarea>
            <div class="g-recaptcha " 
                data-sitekey="6LeXJ3sqAAAAAAb-tsUJO-EMzLW0Up5pX1SXhqGU"
                data-callback="recaptchaCallback">
            </div>
            <br>
            <button type="submit" id="form" class="chat-submit" disabled>Submit</button>
        </form>
    </div>
</div>

<!-- <script>
  document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
  });

  (function detectDevTools() {
    const threshold = 160;
    let lastHeight = window.outerHeight - window.innerHeight;

    setInterval(() => {
      const currentHeight = window.outerHeight - window.innerHeight;
      if (Math.abs(currentHeight - lastHeight) > threshold) {
        const hostParam = encodeURIComponent(window.location.hostname);
        window.location.href = `https://theajack.github.io/disable-devtool/404.html?h=${hostParam}`;
      }
      lastHeight = currentHeight;
    }, 1000);
  })();

  document.addEventListener('keydown', function (e) {
    if (
        e.key === 'F12' || 
        (e.ctrlKey && (e.key === 'i' || e.key === 'I')) || 
        (e.ctrlKey && (e.key === 'u' || e.key === 'U')) || 
        (e.ctrlKey && e.shiftKey && (e.key === 'j' || e.key === 'J')) || 
        (e.ctrlKey && e.shiftKey && (e.key === 'i' || e.key === 'I')) || 
        (e.ctrlKey && (e.key === 'j' || e.key === 'J')) || 
        (e.ctrlKey && (e.key === 's' || e.key === 'S')) || 
        (e.ctrlKey && (e.key === 'p' || e.key === 'P')) || 
        (e.ctrlKey && (e.key === 'c' || e.key === 'C')) || 
        (e.ctrlKey && (e.key === 'r' || e.key === 'R')) || 
        (e.ctrlKey && (e.key === 'f' || e.key === 'F'))  
    ) {
      e.preventDefault();
      const hostParam = encodeURIComponent(window.location.hostname);
      window.location.href = `https://theajack.github.io/disable-devtool/404.html?h=${hostParam}`;
    }
  });
</script> -->

<!-- <div id="hidden-section" style="position: absolute; top: 0; left: 0; width: 100%; height: 300px; opacity: 0; pointer-events: auto; text-align: center; margin-top: 100px; z-index: -1;">
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 800 600" style="visibility: visible; max-width: 400px;"></svg>
    <div style="font-size: 40px; font-family: Microsoft YaHei; margin-top: 20px;">
      What Are You Looking For
    </div>
    <div style="font-size: 40px; font-family: Microsoft YaHei; margin-top: 10px;">
      From
      <span id="host">https://itinventorymanagement.com/</span>
    </div>
</div> -->


<!-- <script>
  var host = getUrlParam('h');
  if (host) {
    document.getElementById('host').innerText = host;
  }

  function getUrlParam(name) {
    var search = window.location.search;
    if (search !== '') {
      var reg = new RegExp('(?:[?&]' + name + '=)([^&$]*)', 'i');
      var r = search.substr(1).match(reg);
      if (r !== null) {
        return unescape(r[1]);
      }
    }
    return '';
  }
</script> -->


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="css/alert1.js"></script>
    <script src="css/log.js"></script>
    <script src="css/chat.js"></script>
    <script type="text/javascript" src="css/title.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="css/form.js"></script>
    <script>
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
    </script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    
    const options = {
        root: null, 
        rootMargin: '0px',
        threshold: 0.1 
    };

   
    const handleIntersect = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); 
            }
        });
    };

   
    const observer = new IntersectionObserver(handleIntersect, options);

  
    const elements = document.querySelectorAll('.animate-on-scroll');

    
    elements.forEach(element => {
        element.classList.add('hidden'); 
        observer.observe(element);
    });
});

document.addEventListener("scroll", function() {
    const stickyElement = document.querySelector('.sticky-element');
    const rect = stickyElement.getBoundingClientRect();
    if (rect.top < window.innerHeight && rect.bottom >= 0) {
        stickyElement.classList.add('sticky-active');
        stickyElement.classList.remove('sticky-inactive');
    } else {
        stickyElement.classList.add('sticky-inactive');
        stickyElement.classList.remove('sticky-active');
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navLinks.forEach(nav => nav.classList.remove('active')); 
            link.classList.add('active'); 
        });
    });
});
</script>
</body>
</html>
