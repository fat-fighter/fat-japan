<?php
session_start();

if (isset($_GET['category'])) {
    $categories = str_replace(" ", "+", $_GET['category']);
    if ($categories == "") {
        $categoriesCount = 0;
    }
    else {
        $categoriesCount = sizeof(explode("+", $categories));
    }
}
else {
    $categories = "";
    $categoriesCount = 0;
}

$tag = "";
if (isset($_GET['tag'])) {
    $tag = $_GET['tag'];
}

$query = "";
if (isset($_GET['query'])) {
    $query = $_GET['query'];
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
else {
    $page = 1;
}

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
}
else {
    $limit = 25;
}

if ($_GET['type'] == "1") {
    $page_type = $categories;
}
else {
    $page_type = "search";
}

if ($categories == "words") {
    $page_type = "dictionary";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>FatJapan</title>

    <?php include('includes/fonts.php') ?>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/search.css">

    <script src="js/angular.min.js"></script>
</head>
<body ng-app="app">

<?php include("includes/header.php"); ?>

<div class="main-content">

    <div class="filter">
        <form action="" method="get">
            <input type="hidden" value="0" name="type">
            <div class="form-group">
                <input type="text" placeholder="Query" name="query">
                <input type="text" placeholder="Tag" name="tag">
                <input type="text" placeholder="Category" name="category">
                <input type="submit" placeholder="Category">
            </div>
        </form>
    </div>


    <?php if ($categoriesCount != 0) {
        echo "<div id='loader'></div>";
    } ?>

    <div id="search-section">
        <?php if ($categoriesCount != 0) { ?>
            <div ng-controller="loadControl">

                <div ng-repeat="category in dictionary" class="category">
                    <div class="category-title">
                        {{ category.Category }}
                    </div>

                    <table class="category-table">
                        <thead>
                        <tr>
                            <td class="serial-column">Serial</td>
                            <td>Word</td>
                            <td>Meaning</td>
                            <td>Tag</td>
                            <td>Usage</td>
                            <?php if ($_SESSION['admin'] == true) {
                                echo "<td>Admin</td>";
                            } ?>
                        </tr>
                        </thead>
                        <tr ng-repeat="word in category.Content">
                            <td class="serial-column">{{ word.WordId }}</td>
                            <td>{{ word.Word }}</td>
                            <td>{{ word.Meaning }}</td>
                            <td>{{ word.Tag }}</td>
                            <td>{{ word.Usage }}</td>
                            <?php if ($_SESSION['admin'] == true) {
                                echo "<td><a href='edit.php?wordid={{ word.WordId }}'><img class='admin-controls' src='img/edit.png'></a> <img class='admin-controls' src='img/delete.png' del-id='{{word.WordId}}' onclick='deleteWord(this)'></td>";
                            } ?>
                        </tr>
                    </table>
                </div>
            </div>
        <?php }

        if ($categoriesCount == 1) { ?>

            <div class="pagination" ng-controller="pageControl">
                <div>
                    <a href="{{ !(isDisabled.first) ? ('words.php?page=' + 1 + '&limit=' + limit) : '' }}">
                        <div class="first {{ (isDisabled.first) ? 'disabled' : '' }}">&lt;&lt;</div>
                    </a>
                    <a href="{{ !(isDisabled.prev) ? ('words.php?page=' + (current-1) + '&limit=' + limit) : '' }}">
                        <div class="prev {{ (isDisabled.prev) ? 'disabled' : '' }}">&lt;</div>
                    </a>

                    <a href="search.php?page={{ page }}&limit={{ limit }}" ng-repeat="page in pages" class="{{ (page==current) ? 'active' : '' }}">
                        <div>{{ page }}</div>
                    </a>

                    <a href="{{ !(isDisabled.next) ? ('words.php?page=' + (current+1) + '&limit=' + limit) : '' }}">
                        <div class="next {{ (isDisabled.next) ? 'disabled' : '' }}">&gt;</div>
                    </a>
                    <a href="{{ !(isDisabled.last) ? ('words.php?page=' + last + '&limit=' + limit) : '' }}">
                        <div class="last {{ (isDisabled.last) ? 'disabled' : '' }}">&gt;&gt;</div>
                    </a>
                </div>
            </div>

        <?php } ?>
    </div>

</div>

<script>

    var currentPage = <?php echo $page; ?>;
    var searchLimit = <?php echo $limit; ?>;
    var categories = "<?php echo $categories; ?>";
    var tag = "<?php echo $tag; ?>";
    var query = "<?php echo $query; ?>";
    var searchQuery = <?php echo $_GET['type']; ?>;

    var app = angular.module('app', []);
    app.controller('loadControl', function($scope, $http) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "db/content_controls.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                $scope.dictionary = JSON.parse(xhr.responseText);
                document.getElementById("search-section").style.opacity = 1;
                document.getElementById("loader").style.opacity = 0;
                document.getElementById("loader").style.height = 0;
            }
        };

        if (searchQuery) {
            xhr.send("operation=load&category=" + categories + "&tag=" + tag + "&query=" + query);
        }
        else {
            xhr.send("operation=load&category=" + categories);
        }
    });

    app.controller('pageControl', function($scope, $http) {
        $http.get("./db/count.php")
            .then(function (response) {
                var l = (currentPage > 3) ? (currentPage - 3) : 1;
                var t = Math.ceil(parseInt(response.data) / searchLimit);

                if (currentPage > t || currentPage < 1) {
                    window.location = "search.php";
                }

                var r = (currentPage < t-3) ? (currentPage + 3) : t;
                var arr = [...Array(r-l+1).keys()].map(x => x+l);
                $scope.pages = arr;

                $scope.isDisabled = {"prev" : false, "next": false, "first" : false, "last" : false};
                if (currentPage == 1) {
                    $scope.isDisabled.prev = true;
                    $scope.isDisabled.first = true;
                }
                if (currentPage == t) {
                    $scope.isDisabled.next = true;
                    $scope.isDisabled.last = true;
                }

                $scope.limit = searchLimit;
                $scope.current = currentPage;
                $scope.last = t;
            });
    });

    function deleteWord(elem) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "db/content_controls.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 400) {
                console.log(xhr.responseText);
            }
        };

        xhr.send("operation=delete&wordId=" + elem.getAttributeNode("del-id").value);
    }

</script>

</body>
</html>