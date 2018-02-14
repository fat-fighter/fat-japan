<!DOCTYPE html>
<html>
<head>
    <title>FatJapan</title>

    <?php include('includes/fonts.php') ?>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/edit.css">
    <link rel="stylesheet" href="css/reference.css">

    <script>
        var setId = false;

        <?php if (isset($_GET['id']) && $_GET['id'] != "") {
            echo "setId = true;";
            echo "var id = " . $_GET['id'] . ";";
        } ?>
    </script>

    <script src="js/angular.min.js"></script>
    <script src="js/common.js"></script>
    <script src="js/edit.js"></script>
</head>
<body ng-app="app">

<?php $page_type = "references"; include("includes/header.php");

switch ($_GET['page']) {
    case "calendar":
        include("ref/calendar.php");
        break;
    case "scripts":
        include("ref/scripts.php");
        break;
    default: ?>
        <div class="main-content">
            <div class="title">
                REFERENCES
            </div>

            <ul class="reference-list" ng-controller="referenceControl">
                <li ng-repeat="page in pages">
                    <a href="reference.php?page={{ page }}">
                        {{ page }}
                    </a>
                </li>
            </ul>
        </div>

        <script type="text/javascript">

            var app = angular.module('app', []);
            app.controller('referenceControl', function($scope) {
                $scope.pages = [
                    "calendar",
                    "scripts"
                ];
            });

        </script>

<?php }

?>
