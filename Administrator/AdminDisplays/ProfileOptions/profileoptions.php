<?php
session_start();

// Include database configuration
require_once __DIR__ . '../../../Database/config.php';

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['logged_in'])) {
    header('Location: ../../../Login');
    exit;
}

$id = $_SESSION['id'];
$username = $_SESSION['username'];
$clearance = $_SESSION['clearance'];
?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <title>Admin Panel</title>
   <script src="profileoptions.js"></script>
   <script src="https://www.gstatic.com/charts/loader.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link href="profileoptions.css" rel="stylesheet" type="text/css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body>
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
                     <a href="../ProfileOptions/profileoptions.php">Profile</a>
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
         <h1>PROFILE SETTINGS</h1>
      </div>

      <div class="profile_view">
         
      </div>
   </main>
</body>

</html>