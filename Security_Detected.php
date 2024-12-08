
<?php
if (!isset($_GET['access']) || $_GET['access'] !== 'allowed') {
    header("Location: index.html");
    exit();
}
?>
<?php
date_default_timezone_set('Asia/Manila');
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>

<?php include 'process/security_lock.php';?>
<?php include 'theme/header.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
    <link href="css/security.css" rel="stylesheet">
    <title>Security Detected</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(to bottom, #2f3b46, #1b1e22);
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        .loader-wrapper {
    position: fixed;
    z-index: 999999;
    background:linear-gradient(to bottom, #2f3b46, #1b1e22);
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    transition: opacity 1s ease-out; 
    opacity: 1; 
}


.loader-wrapper.hidden {
    opacity: 0; 
}


.loader-logo {
    margin-top: 20px; 
    width: 120px; 
    height: auto; 
    opacity: 0.8; 
    animation: fadeIn 2s ease-out forwards, flipLogo 2s ease-in-out infinite, shakeLogo 0.5s infinite; 
    color: white;
}

@keyframes shakeLogo {
    0% { transform: translateX(0); }
    25% { transform: translateX(-2px); }
    50% { transform: translateX(2px); }
    75% { transform: translateX(-2px); }
    100% { transform: translateX(0); }
}



@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: scale(0.8);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}


@keyframes flipLogo {
    0% {
        transform: rotateY(0deg); 
    }
    50% {
        transform: rotateY(180deg); 
    }
    100% {
        transform: rotateY(360deg); 
    }
}
        .centered-container {
            max-width: 600px;
            margin: auto;
            background-color: rgba(32, 38, 45, 0.9);
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #ffc800;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        body, html {
            cursor: none;
        }
        .warning-header {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .warning-header img {
            max-width: 50px; 
            height: auto;
            animation: vibrate 0.5s infinite;
        }
        @keyframes vibrate {
            0% { transform: translateX(0); }
            25% { transform: translateX(-2px); }
            50% { transform: translateX(2px); }
            75% { transform: translateX(-2px); }
            100% { transform: translateX(0); }
        }
        .warning-header h1 {
            color: red;
            margin: 0;
            animation: shake 1s infinite;
        }
        @keyframes shake {
            0%, 100% { transform: rotate(0); }
            25% { transform: rotate(-2deg); }
            50% { transform: rotate(2deg); }
            75% { transform: rotate(-2deg); }
        }
        .shake-vibrate {
            display: inline-block;
            animation: vibrate 0.2s ease-in-out infinite, shake 0.5s ease-in-out infinite;
        }
        .draggable {
            position: absolute;
            top: 10px;
            left: 0px;
            width: 200px; 
            height: 200px;  
            border-radius: 8px;
            background-color: #20262d;
            overflow: hidden;
            cursor: move;
            z-index: 1; 
        }
        .drag-handle {
            width: 100%;
            height: 20px;
            background-color: #ffc800;
            cursor: grab;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            color: #000;
            font-weight: bold;
            user-select: none;
            position: absolute;
            top: 0;
            z-index: 10; 
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 8px;
            position: relative;
            z-index: 1; 
        }
        #hidden-section {
        opacity: 0;
        pointer-events: none; 
    }
    </style>
</head>
<body>
<div class="loader-wrapper" id="preloader">
    <div class="loader">
        <div class="loader-inner"></div>
    </div>
    <div style="display: flex; flex-direction: column; align-items: center;">
        <img src="uploads/users/warning.png" alt="Logo" class="loader-logo" />
        <h1 class="shake-vibrate" style="color: white;">
            <span style="color: red;">WARNING</span>!
        </h1>
    </div>
</div>
<script>
   var loader = document.getElementById("preloader");
window.addEventListener("load", function() {

    setTimeout(function() {
        loader.classList.add("hidden"); 
        setTimeout(function() {
            loader.style.display = "none"; 
        }, 1000); 
    }, 3000); 
});
</script>

    <div class="centered-container">
        <div class="warning-header">
            <img src="uploads/users/warning.png" alt="Warning Image">
            <h1 style="color: white;"><span style="color: red;">WARNING</span>!</h1>
            <img src="uploads/users/warning.png" alt="Warning Image">
        </div>

        <div class="draggable" id="player-container">
            <div class="drag-handle">Drag Me</div>
            <iframe id="player" src="https://www.youtube.com/embed/RnaY7k2JiZk?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>

        <div style="background-color: #e0f7fa; border-radius: 4px; padding: 10px;">
            <h2 style='text-align: center;'>Your <span style="color: red;">IP Address</span> Has Been <span style="color: red;">Detected</span></h2>
            <p style="font-size: 18px; color: #333; text-align: center;">
                <strong><?php echo $user_ip; ?></strong>
            </p>
            <p style='font-size: 12px; text-align: center;'>This IP Address not recognized to be logged in.</p>
            <p style="font-size: 18px; color: #333; text-align: center;">
                <strong><?php echo $device_info; ?></strong>
            </p>
        </div>
        <p style='font-size: 14px; text-align: justify; color: white;'>
            If you need further assistance, feel free to contact me via Facebook:
            <a href='https://www.facebook.com/rizelbrace2' target='_blank' style='color: #0062cc; text-decoration: none;'>
                Rizel Mulle Bracero
            </a>.
        </p>
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


    <script>
        let startTime = Date.now();
        window.addEventListener('beforeunload', function () {
            let duration = Math.round((Date.now() - startTime) / 1000); 
            console.log('Sending duration:', duration); 
            let minutes = Math.floor(duration / 60);
            let seconds = duration % 60;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); 
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Duration sent successfully");
                }
            };
            xhr.send("duration=" + duration + "&minutes=" + minutes + "&seconds=" + seconds);
        });
    </script>
    <script>
        const dragHandle = document.querySelector('.drag-handle');
        const draggable = document.querySelector('.draggable');
        let isDragging = false, offsetX, offsetY;

        dragHandle.addEventListener('mousedown', (e) => {
            isDragging = true;
            offsetX = e.clientX - draggable.offsetLeft;
            offsetY = e.clientY - draggable.offsetTop;
            document.body.style.cursor = 'grabbing';
        });

        document.addEventListener('mousemove', (e) => {
            if (isDragging) {
                let newLeft = e.clientX - offsetX;
                let newTop = e.clientY - offsetY;

                newLeft = Math.max(0, Math.min(newLeft, window.innerWidth - draggable.offsetWidth));
                newTop = Math.max(0, Math.min(newTop, window.innerHeight - draggable.offsetHeight));

                draggable.style.left = `${newLeft}px`;
                draggable.style.top = `${newTop}px`;
            }
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
            document.body.style.cursor = 'default';
        });

        const videoUrls = [
            "RnaY7k2JiZk", 
            "0KifzGnvZRQ", 
            "7OS3LwH9TCc"  
        ];
        let currentVideoIndex = 0;
        let tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        let firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        let player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '315',
                width: '100%',
                videoId: videoUrls[currentVideoIndex],
                events: {
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.ENDED) {
                currentVideoIndex = (currentVideoIndex + 1) % videoUrls.length; 
                player.loadVideoById(videoUrls[currentVideoIndex]);
            }
        }
    </script>
    <script src="css/log.js"></script>
    <?php include_once('layouts/recapt.php'); ?>
</body>
</html>