<?php
session_start();
if (!$_SESSION["loggedin"] || $_SESSION["level"] != '1') {
    header("location:../index.php");
} else {
    header("location:../admin/dashboard.php");
}
