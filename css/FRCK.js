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