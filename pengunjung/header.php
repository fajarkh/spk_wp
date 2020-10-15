<?php
include "../includes/config.php";

$config = new Config();
$db = $config->getConnection();

function convertDate($date)
{
    $day = substr($date, 8, 2);
    $month = substr($date, 5, 2);
    $year = substr($date, 0, 4);
    if ($month == '01') {
        $month = "Jan";
    }
    if ($month == '02') {
        $month = "Feb";
    }
    if ($month == '03') {
        $month = "Mar";
    }
    if ($month == '04') {
        $month = "Apr";
    }
    if ($month == '05') {
        $month = "May";
    }
    if ($month == '06') {
        $month = "Jun";
    }
    if ($month == '07') {
        $month = "Jul";
    }
    if ($month == '08') {
        $month = "Aug";
    }
    if ($month == '09') {
        $month = "Sep";
    }
    if ($month == '10') {
        $month = "Oct";
    }
    if ($month == '11') {
        $month = "Nov";
    }
    if ($month == '12') {
        $month = "Dec";
    }

    return $day . ' ' . $month . ', ' . $year;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>SPK Rekomendasi Ikan Lele</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet" />

    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" type='text/css' />

    <!-- Custom styles for this template -->
    <!-- <link href="assets/css/blog.css" rel="stylesheet"> -->

</head>

<body>

    <div class="wrapper">
        <div class="sidebar" data-color="azure" data-image="assets/img/sidebar-6.jpg">

            <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="#" class="simple-text">
                        SPK Rekomendasi Ikan Lele
                    </a>
                </div>

                <ul class="nav">
                    <li>
                        <a href="dashboard.php">
                            <i class="pe-7s-graph"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="berita.php">
                            <i class="pe-7s-news-paper"></i>
                            <p>Seputar Ikan Lele</p>
                        </a>
                    </li>
                    <li class="active-pro">
                        <a href="#">
                            <i class="pe-7s-close"></i>
                            <p>Keluar</p>
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-default navbar-fixed">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Dashboard</a>
                    </div>
                    <div class="collapse navbar-collapse">
                    </div>
                </div>
            </nav>