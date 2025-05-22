<?php
session_start();              // Start the session
session_unset();              // Unset all session variables
session_destroy();            // Destroy the session

// Redirect to login or homepage
header("Location: login.php");
exit();
