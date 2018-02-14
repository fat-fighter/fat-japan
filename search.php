<?php
session_start();

$search = ($_GET['type'] == "1") ? false : true;

$categories = "";
$categories = (isset($_GET['category']) && $_GET['category'] != "") ? $_GET['category'] : "words kanji phrases verbs";

$categories = str_replace(" ", "+", $categories);
$categoriesCount = sizeof(explode("+", $categories));

$page_type = ($search) ? "search" : $categories;

if (!$search && ($categoriesCount != 1 || $categories == "words")) {
    $categoriesCount = 1;
    $categories = "words";
    $page_type = "dictionary";
}

if ($search && !isset($_GET['category'])) {
    $categories = "";
    $categoriesCount = 0;
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
    <script>

        var categories = "<?php echo $categories; ?>";
        var loadQuery = "operation=load&category=" + categories;
        var searchQuery = "<?php echo $search; ?>";

        <?php

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $limit = (isset($_GET['limit'])) ? $_GET['limit'] : 25;

        if ($search) {

            $tag = (isset($_GET['tag'])) ? $_GET['tag'] : "";
            $query = (isset($_GET['query'])) ? $_GET['query'] : "";

            echo "loadQuery += '&page=$page&limit=$limit&tag=$tag&query=$query';";
        }

        ?>

        var currentPage = <?php echo $page; ?>;
        var searchLimit = <?php echo $limit; ?>;

    </script>
    <script src="js/search.js"></script>
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
                            <td>Kanji</td>
                            <td>Tag</td>
                            <td>Usage</td>
                            <?php if ($_SESSION['admin'] == true) {
                                echo "<td>Admin</td>";
                            } ?>
                        </tr>
                        </thead>
                        <tr ng-repeat="word in category.Content">
                            <td class="serial-column">{{ word.Serial }}</td>
                            <td>{{ word.Word }}</td>
                            <td>{{ word.Meaning }}</td>
                            <td>{{ word.Kanji }}</td>
                            <td>{{ word.Tag }}</td>
                            <td>{{ word.Uses }}</td>
                            <?php if ($_SESSION['admin'] == true) {
                                echo "<td><a href='edit.php?id={{ word.WordId }}'><img class='admin-controls' src='img/edit.png'></a> <img class='admin-controls' src='img/delete.png' del-id='{{word.WordId}}' onclick='deleteWord(this)'></td>";
                            } ?>
                        </tr>
                    </table>
                </div>
            </div>
        <?php }

        if ($categoriesCount == 1) { ?>

            <div class="pagination" ng-controller="pageControl">
                <div>
                    <a href="{{ !(isDisabled.first) ? ('search.php?type=1&category=<?php echo $categories; ?>&page=' + 1 + '&limit=' + limit) : '#' }}">
                        <div class="first {{ (isDisabled.first) ? 'disabled' : '' }}">&lt;&lt;</div>
                    </a>
                    <a href="{{ !(isDisabled.prev) ? ('search.php?type=1&category=<?php echo $categories; ?>&page=' + (current-1) + '&limit=' + limit) : '#' }}">
                        <div class="prev {{ (isDisabled.prev) ? 'disabled' : '' }}">&lt;</div>
                    </a>

                    <a href="search.php?page={{ page }}&limit={{ limit }}" ng-repeat="page in pages" class="{{ (page==current) ? 'active' : '#' }}">
                        <div>{{ page }}</div>
                    </a>

                    <a href="{{ !(isDisabled.next) ? ('search.php?type=1&category=<?php echo $categories; ?>&page=' + (current+1) + '&limit=' + limit) : '#' }}">
                        <div class="next {{ (isDisabled.next) ? 'disabled' : '' }}">&gt;</div>
                    </a>
                    <a href="{{ !(isDisabled.last) ? ('search.php?type=1&category=<?php echo $categories; ?>&page=' + last + '&limit=' + limit) : '#' }}">
                        <div class="last {{ (isDisabled.last) ? 'disabled' : '' }}">&gt;&gt;</div>
                    </a>
                </div>
            </div>

        <?php } ?>
    </div>

</div>

</body>
</html>