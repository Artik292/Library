<?php

/* logout user and send him to first page */

session_start();
unset($_SESSION['user_name']);
header('Location: index.php');
