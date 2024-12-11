<?php
session_start();
session_destroy();
header("Location: sivut/login_sivu.php");