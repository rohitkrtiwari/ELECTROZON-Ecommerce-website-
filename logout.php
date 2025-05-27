<?php
require('connection.inc.php');
session_start();
session_unset();

// destroy the session
session_destroy();
header('location:'.SITE_PATH.'login')
?>