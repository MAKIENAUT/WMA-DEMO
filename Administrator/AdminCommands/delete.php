<?php

include "../Database/config.php";

if (isset($_GET['id'])) {
   $user_id = $_GET['id'];
   $sql = "DELETE FROM `form` WHERE `id`='$user_id'";
   $user_file = substr($user_id, 1);
   $result = $conn->query($sql);
   if ($result == TRUE) {
      echo $user_id;
      echo $user_file;
      deleteAll($user_file);
      header('Location: ../Dashboard/dashboard.php');
   } else {
      echo "Error:" . $sql . "<br>" . $conn->error;
   }
}

function deleteAll($user_file)
{
   foreach (glob($user_file . '/*') as $file) {
      if (is_dir($file))
         deleteAll($file);
      else
         unlink($file);
   }
   rmdir($user_file);
}                                
?>