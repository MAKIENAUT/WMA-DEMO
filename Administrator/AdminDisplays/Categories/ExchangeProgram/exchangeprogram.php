<?php
session_start();

// Include database configuration
require_once __DIR__ . '../../../../Database/config.php';

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['logged_in'])) {
   header('Location: ../../../../Login/login.php');
   exit;
}

$id = $_SESSION['id'];
$username = $_SESSION['username'];
$clearance = $_SESSION['clearance'];

// Define pagination variables
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Calculate offset based on current page
$offset = ($page - 1) * $limit;

// Retrieve data from database based on search query
$query = "SELECT * FROM form";
if (!empty($search)) {
   $search = mysqli_real_escape_string($conn, $search);
   $query .= " WHERE lastname LIKE '%$search%' OR 
                     firstname LIKE '%$search%' OR 
                     address LIKE '%$search%' OR 
                     country LIKE '%$search%' OR 
                     phone_number LIKE '%$search%' OR 
                     email LIKE '%$search%' OR 
                     profession LIKE '%$search%' OR 
                     status LIKE '%$search%'";
}
$query .= " ORDER BY id";
$query .= " LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
 
// Count total number of records
$count_query = "SELECT COUNT(*) AS count FROM form";
if (!empty($search)) {
   $search = mysqli_real_escape_string($conn, $search);
   $count_query .= " WHERE lastname LIKE '%$search%' OR 
                           firstname LIKE '%$search%' OR 
                           address LIKE '%$search%' OR 
                           country LIKE '%$search%' OR 
                           phone_number LIKE '%$search%' OR 
                           email LIKE '%$search%' OR 
                           profession LIKE '%$search%' OR 
                           status LIKE '%$search%'";
}
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_records = $count_data['count'];

// Calculate total pages
$total_pages = ceil($total_records / $limit);
?>
<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <title>Admin Panel</title>
   <script src="exchangeprogram.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link href="exchangeprogram.css" rel="stylesheet" type="text/css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body onload="nav_link(1)">
   <nav>
      <header>
         <div class="header_image">
            <a href="../../../../Pages/Home/home.html">
               <img src="../../../../Photos/wma-logo.png">
            </a>
         </div>

         <div class="profile_dock">
            <div class="profile_picture">
               <img src="../../../../Photos/profile_placeholder.jpg">
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
                     <a href="../../../AdminCommands/logout.php" 
                        onclick="return confirm('Are you sure you want to logout?');"
                     >
                        Logout
                     </a>
                     <a href="../../ProfileOptions/profileoptions.php">Profile</a>
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
         <h1>DASHBOARD</h1>
         <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="text" name="search" placeholder="Search..." onchange="this.form.submit();"
               value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>" />
            <button type="submit">SEARCH</button>
         </form>

      </div>

      <div class="tabular_view">
         <table>
            <thead>
               <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Address</th>
                  <th>Phone Number</th>
                  <th>Email Address</th>
                  <th>Profession</th>
                  <th>Status</th>
                  <th>File Directory</th>
                  <th>Actions </th>
               </tr>
            </thead>

            <tbody>
               <?php
               if (!empty($rows)) {
                  foreach ($rows as $row) {
                     ?>
                     <tr>
                        <td>
                           <?php 
                              echo htmlspecialchars($row['firstname'], ENT_QUOTES); 
                           ?>
                        </td>
                        <td>
                           <?php 
                              echo htmlspecialchars($row['lastname'], ENT_QUOTES); 
                           ?>
                        </td>
                        <td>
                           <?php 
                              echo  htmlspecialchars($row['address'], ENT_QUOTES) . ", ". 
                                    htmlspecialchars($row['country'], ENT_QUOTES); 
                           ?>
                        </td>
                        <td>
                           <?php 
                              echo htmlspecialchars($row['phone_number'], ENT_QUOTES); 
                           ?>
                        </td>
                        <td>
                           <?php 
                              echo htmlspecialchars($row['email'], ENT_QUOTES); 
                           ?>
                        </td>
                        <td>
                           <?php 
                              echo htmlspecialchars($row['profession'], ENT_QUOTES); 
                           ?>
                        </td>
                        <td class="status" 
                           <?php
                              if ($row['status'] == 'PHASE_1') {
                                 echo 'style="background-color: green;"';
                              } elseif ($row['status'] == 'PHASE_1A') {
                                 echo 'style="background-color: rgb(0, 255, 255, 0.7);"';
                              } elseif ($row['status'] == 'PHASE_2') {
                                 echo 'style="background-color: indigo;"';
                              } elseif ($row['status'] == 'PHASE_3') {
                                 echo 'style="background-color: blueviolet;"';
                              } elseif ($row['status'] == 'PHASE_4') {
                                 echo 'style="background-color: magenta;"';
                              } elseif ($row['status'] == 'PHASE_5') {
                                 echo 'style="background-color: gold;"';
                              } elseif ($row['status'] == 'PHASE_6') {
                                 echo 'style="background-color: orange;"';
                              } elseif ($row['status'] == 'PHASE_7') {
                                 echo 'style="background-color: red;"';
                              }
                           ?>
                        >
                           <a id="status" 
                              href="../Phases/progress.php?id=<?php echo $row['id']; ?>">
                              <?php echo $row['status']; ?>
                           </a>
                        </td>
                        <td>
                           <a href="../FileManager/filemanager.php?folder=<?php $foldername = str_replace("../ApplicantFiles/", "", $row['file']);  echo $foldername;?>">
                              <?php echo $row['file']; ?>
                           </a>
                        </td>
                        <td>
                           <a href="../../AdminCommands/delete.php?id=<?php echo $row['id'];
                           echo $row['file']; ?>"
                              onclick="return confirm('Are you sure you want to delete this item?');">
                              Delete
                           </a>
                        </td>
                     </tr>
                     <?php
                  }
               } else {
                  ?>
                  <tr>
                     <td colspan="9">No records found</td>
                  </tr>
                  <?php
               }
               ?>
            </tbody>
         </table>
      </div>
      <div class="pagination">
         <?php
         if ($total_pages > 1) {
            echo '<div class="pagination-buttons">';
            if ($page > 1) {
               echo '<button class="prev" onclick="location.href = \'' . htmlspecialchars($_SERVER['PHP_SELF'] . '?page=' . ($page - 1) . '&search=' . $search, ENT_QUOTES) . '\'">Prev</button>';
            } ?>

            <div class="active_pages">
               <?php
               for ($i = 1; $i <= $total_pages; $i++) {
                  echo '<button id="page-' . $i . '"';
                  if ($page === $i) {
                     echo ' class="active"';
                     echo ' style="color:gold;"';
                  }
                  echo ' onclick="location.href = \'' . htmlspecialchars($_SERVER['PHP_SELF'] . '?page=' . $i . '&search=' . $search, ENT_QUOTES) . '\'">' . $i . '</button>';
               }
               ?>
            </div>

            <?php
            if ($page < $total_pages) {
               echo '<button class="next" onclick="location.href = \'' . htmlspecialchars($_SERVER['PHP_SELF'] . '?page=' . ($page + 1) . '&search=' . $search, ENT_QUOTES) . '\'">Next</button>';
            }
            echo '</div>';
         }
         ?>
      </div>

   </main>
</body>
<script>
   // get the button for the active page
   const activeButton = document.querySelector('.active');

   // add a gold color style to the active button
   if (activeButton) {
      activeButton.style.color = 'gold';
   }
</script>

</html>