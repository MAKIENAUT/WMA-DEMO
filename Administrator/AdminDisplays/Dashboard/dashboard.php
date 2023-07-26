<?php
session_start();

// Include database configuration
require_once __DIR__ . '../../../Database/config.php';

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['logged_in'])) {
   header('Location: ../../../Login');
   exit;
}

$username = $_SESSION['username'];
$clearance = $_SESSION['clearance'];

// Fetch data from database for profession chart
$sqlProfession = "SELECT profession, COUNT(*) as total FROM form GROUP BY profession";
$resultProfession = mysqli_query($conn, $sqlProfession);

// Create an array to hold profession chart data
$dataProfession = array();
$dataProfession[] = ['Profession', 'Total'];

while ($rowProfession = mysqli_fetch_assoc($resultProfession)) {
   $dataProfession[] = [$rowProfession['profession'], (int) $rowProfession['total']];
}

// Fetch data from database for status chart
$sqlStatus = "SELECT status, COUNT(*) as total FROM form GROUP BY status";
$resultStatus = mysqli_query($conn, $sqlStatus);

// Create an array to hold status chart data
$dataStatus = array();
$dataStatus[] = ['Status', 'Total'];

while ($rowStatus = mysqli_fetch_assoc($resultStatus)) {
   $dataStatus[] = [$rowStatus['status'], (int) $rowStatus['total']];
}

// Convert data arrays into JSON format
$jsonDataProfession = json_encode($dataProfession);
$jsonDataStatus = json_encode($dataStatus);
?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <title>Admin Panel</title>
   <script src="dashboard.js"></script>
   <script src="https://www.gstatic.com/charts/loader.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link href="dashboard.css" rel="stylesheet" type="text/css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body onload="nav_link(1)">
   <nav>
      <header>
         <div class="header_image">
            <a href="../../../Pages/Home/home.html">
               <img src="../../../Photos/wma-logo.png">
            </a>
         </div>

         <div class="profile_dock">
            <div class="profile_picture">
               <img src="../../../Photos/profile_placeholder.jpg">
            </div>
            <div class="profile_details">
               <h1>
                  <?php echo $username ?>
               </h1>
               <h3>
                  <?php echo $clearance ?>
               </h3>
            </div>
            <div class="profile_settings">
               <div class="dropdown">
                  <i class="fa-solid fa-gear"></i>
                  <div class="dropdown-content">
                     <a href="../../AdminCommands/logout.php"
                        onclick="return confirm('Are you sure you want to logout?');">
                        Logout
                     </a>
                     <a href="../AdminProfile/profile.php">Profile</a>
                     <a href="#">Signup</a>
                  </div>
               </div>
            </div>
         </div>
      </header>

      <div class="nav_options">
         <div class="nav_options_title">
            <h1>Applicant Reports</h1>
         </div>

         <div class="nav_links">
            <div class="dashboard" id="dashboard">
               <i class="fa-solid fa-gauge"></i>
               <a href="../Dashboard/dashboard.php">Dashboard</a>
            </div>
            <div class="charts" id="charts">
               <i class="fa-solid fa-chart-pie"></i>
               <a href="../Charts/charts.php">Charts</a>
            </div>
            <div class="file_manager" id="file_manager">
               <i class="fa-solid fa-folder"></i>
               <a href="../FileManager/filemanager.php">File Manager</a>
            </div>
         </div>
      </div>
   </nav>

   <main>
      <div class="main_title">
         <h1>GENERAL INFORMATION</h1>
      </div>

      <div class="applicant_dash">
         <div class="profession_chart" id="chart_div_profession" style="width: 500px; height: 275px;">
         </div>

         <div class="status_chart" id="chart_div_status" style="width: 500px; height: 275px;"></div>
      </div>
   </main>

   <script>
      google.charts.load('current', { 'packages': ['corechart'] });
      google.charts.setOnLoadCallback(drawProfessionChart);
      google.charts.setOnLoadCallback(drawStatusChart);

      function drawProfessionChart() {
         var jsonData = <?php echo $jsonDataProfession; ?>;
         var data = google.visualization.arrayToDataTable(jsonData);

         var options = {
            chartArea: {
               width: '75%',
               height: '70%'
            },
            legend: {
               position: 'right',
               alignment: 'center',
               textStyle: {
                  fontSize: 14,
                  color: 'white',
                  fontName: 'Arial'
               },
            },
            title: 'Applicant Professions',
            titleTextStyle: {
               bold: true,
               fontSize: 22,
               color: 'white',
               fontName: 'Arial'
            },
            pieHole: 0.8,
            pieSliceText: 'none',
            border: '1px solid white',
            backgroundColor: 'transparent',
         };
         var chart = new google.visualization.PieChart(document.getElementById('chart_div_profession'));
         chart.draw(data, options);
      }

      function drawStatusChart() {
         var jsonData = <?php echo $jsonDataStatus; ?>;
         var data = google.visualization.arrayToDataTable(jsonData);
         var options = {
            chartArea: {
               width: '75%',
               height: '70%'
            },
            legend: {
               position: 'right',
               alignment: 'center',
               textStyle: {
                  fontSize: 14,
                  color: 'white',
                  fontName: 'Arial'
               },
               itemStyle: {
                  borderWidth: 1,
                  borderColor: 'white'
               }
            },
            title: 'Applicant Status',
            titleTextStyle: {
               bold: true,
               fontSize: 22,
               color: 'white',
               fontName: 'Arial'
            },
            pieHole: 0.8,
            pieSliceText: 'none',
            border: '1px solid white',
            backgroundColor: 'transparent',
            colors: ['green', 'cyan', 'indigo', 'blueviolet', 'magenta', 'yellow', 'orange', 'red']
         };

         var chart = new google.visualization.PieChart(document.getElementById('chart_div_status'));
         chart.draw(data, options);
      }
   </script>
</body>

</html>