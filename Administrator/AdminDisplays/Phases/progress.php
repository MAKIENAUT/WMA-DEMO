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

if (isset($_POST['update'])) {
   $status = $_POST['status'];
   $id = $_POST['id'];

   $sql = "UPDATE `form` SET `status`='$status' WHERE `id`='$id'";

   $result = $conn->query($sql);
   if ($result == TRUE) {
      header('Location: ../Dashboard/dashboard.php');
   } else {
      echo "Error:" . $sql . "<br />" . $conn->error;
   }
}

if (isset($_GET['id'])) {
   $id = $_GET['id'];
   $sql = "SELECT * FROM `form` WHERE `id`='$id'";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         $fullname = $row['lastname'] . ', ' . $row['firstname'];
         $status = $row['status'];
         $id = $row['id'];
      }
      ?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
         <meta charset="utf-8">
         <title>Admin Panel</title>
         <script src="progress.js"></script>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
            integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
         <link href="progress.css" rel="stylesheet" type="text/css">
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
               <h1>UPDATE APPLICANT PROGRESS</h1>
            </div>

            <form action="" method="post">
               <fieldset>
                  <legend>Applicant Status:</legend>
                  <label class="applicant_name">
                     Name: <b> &nbsp
                        <?php echo $fullname ?>
                     </b>
                  </label>
                  <br />
                  <div class="wrapper">
                     <input type="hidden" name="id" value="<?php echo $id; ?>">

                     <input 
                        id="option-1" 
                        type="radio" 
                        name="status" 
                        value="PHASE_1" 
                        <?php
                           if ($status == 'PHASE_1') {
                              echo "checked";
                           }
                        ?>
                     />
                     <input 
                        id="option-2" 
                        type="radio" 
                        name="status" 
                        value="PHASE_1A" 
                        <?php
                           if ($status == 'PHASE_1A') {
                              echo "checked";
                           }
                        ?>
                     />
                     <input 
                        id="option-3" 
                        type="radio" 
                        name="status" 
                        value="PHASE_2" 
                        <?php
                           if ($status == 'PHASE_2') {
                              echo "checked";
                           }
                        ?>
                     />
                     <input 
                        id="option-4" 
                        type="radio" 
                        name="status" 
                        value="PHASE_3" 
                        <?php
                           if ($status == 'PHASE_3') {
                              echo "checked";
                           }
                        ?>
                     />
                     <input 
                        id="option-5" 
                        type="radio" 
                        name="status" 
                        value="PHASE_4" 
                        <?php
                           if ($status == 'PHASE_4') {
                              echo "checked";
                           }
                        ?>
                     />
                     <input 
                        id="option-6" 
                        type="radio" 
                        name="status" 
                        value="PHASE_5" 
                        <?php
                           if ($status == 'PHASE_5') {
                              echo "checked";
                           }
                        ?>
                     />
                     <input 
                        id="option-7" 
                        type="radio" 
                        name="status" 
                        value="PHASE_6" 
                        <?php
                           if ($status == 'PHASE_6') {
                              echo "checked";
                           }
                        ?>
                     />
                     <input 
                        id="option-8" 
                        type="radio" 
                        name="status" 
                        value="PHASE_7" 
                        <?php
                           if ($status == 'PHASE_7') {
                              echo "checked";
                           }
                        ?>
                     />

                     <label for="option-1" class="option option-1">
                        <div class="dot"></div>
                        <span>PHASE 1</span>
                     </label>
                     <label for="option-2" class="option option-2">
                        <div class="dot"></div>
                        <span>PHASE 1A</span>
                     </label>
                     <label for="option-3" class="option option-3">
                        <div class="dot"></div>
                        <span>PHASE 2</span>
                     </label>
                     <label for="option-4" class="option option-4">
                        <div class="dot"></div>
                        <span>PHASE 3</span>
                     </label>
                     <label for="option-5" class="option option-5">
                        <div class="dot"></div>
                        <span>PHASE 4</span>
                     </label>
                     <label for="option-6" class="option option-6">
                        <div class="dot"></div>
                        <span>PHASE 5</span>
                     </label>
                     <label for="option-7" class="option option-7">
                        <div class="dot"></div>
                        <span>PHASE 6</span>
                     </label>
                     <label for="option-8" class="option option-8">
                        <div class="dot"></div>
                        <span>PHASE 7</span>
                     </label>
                  </div>

                  <input type="submit" value="UPDATE" name="update" />
               </fieldset>
            </form>
         </main>
      </body>

      </html>
      <?php
   } else {
      header('Location: admin.php');
   }
}
?>