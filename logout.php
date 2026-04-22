<?php
session_start();
session_unset();
session_destroy();

// redirect after logout
header("Location: /adrenax/pages/login.php");
exit();
?>