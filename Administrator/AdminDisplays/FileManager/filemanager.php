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

$dir = "../..//ApplicantFiles/";
$folders = array_filter(glob($dir . '*'), 'is_dir');
$selected_folder = isset($_GET['folder']) ? htmlspecialchars($_GET['folder']) : null;

if ($selected_folder) {
   $files = array_filter(glob($dir . $selected_folder . '/*.{pdf,doc,docx,txt}', GLOB_BRACE), 'is_file');
}

function downloadFile($file)
{
   if (file_exists($file)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="' . basename($file) . '"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file));
      readfile($file);
      exit;
   }
}

?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <title>Admin Panel</title>
   <script src="filemanager.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link href="filemanager.css" rel="stylesheet" type="text/css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body onload="nav_link(3)">
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
         <h1>File Management Page</h1>
      </div>
      <div class="manager_display">
         <div class="applicant_folder">
            <?php foreach ($folders as $folder): ?>
               <div class="folder_link">
                  <a href="?folder=<?php echo basename($folder); ?>"
                     class="<?php echo ($selected_folder && $selected_folder === basename($folder)) ? 'active' : ''; ?>">
                     <i class="fa-regular fa-folder "></i>
                     <p class="<?php echo ($selected_folder && $selected_folder === basename($folder)) ? 'active' : ''; ?>">
                        <?php echo basename($folder); ?>
                     </p>
                  </a>
               </div>
            <?php endforeach; ?>
         </div>
         <div class="selected_folder">
            <?php if ($selected_folder): ?>
               <div class="folder_title">
                  <h2>Files in <?php echo $selected_folder; ?>
                  </h2>
               </div>
               <?php if (count($files)): ?>
               <div class="folder_container">
                  <?php foreach ($files as $file): ?>
                     <div class="file_display">
                        <i class="icon fa fa-folder" id="folder_icon"></i>
                        <a class="file_name" href="<?php echo $file; ?>" download><?php echo basename($file); ?></a>
                     </div>
                  <?php endforeach; ?>
               </div>
               <?php else: ?>
                  <p>No files found.</p>
               <?php endif; ?>
            <?php endif; ?>
         </div>
      </div>

   </main>


</body>

</html>