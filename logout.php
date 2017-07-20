<?php

/* logout user and send him to first page */

session_start();
unset($_SESSION['status']);
unset($_SESSION['user_id']);
header('Location: index.php');
