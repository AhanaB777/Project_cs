<?php
session_start();  // Start the session

// Destroy all session data
session_unset();  
session_destroy();  

// Redirect to the home page or login page
header("Location: index.php");  
exit();  
?>
