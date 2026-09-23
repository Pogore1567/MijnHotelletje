
    function openNav(){
      document.getElementById("header").style.width = "250px";
   }
    function closeNav(){
      document.getElementById("header").style.width = "0px";
   }

    function startClock() {
        const clockElement = document.getElementById('live-clock');
        
        setInterval(() => {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            clockElement.textContent = `${hours}:${minutes}`;
        }, 1000);
    }
    
    document.addEventListener('DOMContentLoaded', startClock);

