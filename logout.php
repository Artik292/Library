<?php

/* logout user and send him to first page */

session_start();
unset($_SESSION['status']);
header('Location: index.php');
