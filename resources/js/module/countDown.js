(function () {
  const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;
  const now = new Date();
  const targetDate = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59); 
  const x = setInterval(function() {    
    const now = new Date().getTime(),
    distance = targetDate - now;
    if (distance <= 0) {
      targetDate.setDate(now.getDate() + 1);
      targetDate.setHours(23, 59, 59);
    }
    const newDistance = targetDate - now;
    document.getElementById("days").innerText = Math.floor(newDistance / (day)),
    document.getElementById("hours").innerText = Math.floor((newDistance % (day)) / (hour)),
    document.getElementById("minutes").innerText = Math.floor((newDistance % (hour)) / (minute)),
    document.getElementById("seconds").innerText = Math.floor((newDistance % (minute)) / second);
  }, 1000);
})();
