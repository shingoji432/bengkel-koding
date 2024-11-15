<?php

session_start();
unset($_SESSION['user']);
header("document.location=index.php?page=loginUser.php");