<?php
session_start();

$_SESSION['admin'] = false;

session_destroy();

header("location: index.php");