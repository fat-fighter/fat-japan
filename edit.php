<?php
session_start();

include("db/db_controls.php");

if ($_SESSION['admin'] != true) {
    header('location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>FatJapan</title>

    <?php include('includes/fonts.php') ?>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/edit.css">

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

<?php $page_type="admin"; include("includes/header.php") ?>

<div class="main-content">

    <div style="margin-bottom: 40px; height: 30px;">
        <form action="edit.php" method="get" style="float: left">
            <input type="text" name="id" value="<?php echo $_GET['id']; ?>" placeholder="Word Id">
            <input type="submit" value="Load Id" style="position: relative; top: 1px; padding: 10px 70px;">
        </form>
        <a href="edit.php" class="new-question-block"><span>+</span> Add new word</a>
    </div>

    <form action="db/content_controls.php" method="post" ng-controller="formControl">

        <select name="category" ng-options="option.tag for option in data.categories track by option.value" ng-model="data.selectedCategory"></select>

        <input type="hidden" name="id" value="{{ wordContent.WordId }}">

        <input type="hidden" name="operation" value="post">

        <div class="form-group">
            <input type="text" name="word" placeholder="Word" value="{{ wordContent.Word }}">
            <input type="text" name="tag" placeholder="Tag" value="{{ wordContent.Tag }}">
        </div>
        <div class="form-group">
            <input type="text" name="meaning" placeholder="Meaning" value="{{ wordContent.Meaning }}">
            <input type="text" name="kanji" placeholder="Kanji" value="{{ wordContent.Kanji }}">
        </div>

        <textarea name="usage" placeholder="Usage">{{ wordContent.Uses }}</textarea>

        <input type="submit" value="SUBMIT" class="extend">
    </form>


</div>

</body>
</html>