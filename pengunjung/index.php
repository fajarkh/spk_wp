<?php
session_start();
if (!$_SESSION["loggedin"] || $_SESSION["level"] != '0') {
    header("location:../index.php");
} else {
    header("location:../pengunjung/dashboard.php");
}
