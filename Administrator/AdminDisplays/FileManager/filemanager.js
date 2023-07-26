function nav_link(position) {
   var dashboard = document.getElementById('dashboard');
   var charts = document.getElementById('charts');
   var file_manager = document.getElementById('file_manager');

   if (position === 1) {
      dashboard.style.borderLeft = "3px solid goldenrod";
      dashboard.style.backgroundColor = "rgba(255, 255, 255, 0.1)";
   } else if (position === 2) {
      charts.style.borderLeft = "3px solid goldenrod";
      charts.style.backgroundColor = "rgba(255, 255, 255, 0.1)";
   } else if (position === 3) {
      file_manager.style.borderLeft = "3px solid goldenrod";
      file_manager.style.backgroundColor = "rgba(255, 255, 255, 0.1)";
   } 
}

