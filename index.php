<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>FatJapan</title>

    <?php include('includes/fonts.php') ?>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<?php $page_type="home"; include("includes/header.php") ?>

<div id="search-section">
    <form action="search.php" method="post">
        <div class="title">What are you looking for?</div>
        <input type="text" placeholder="search something">
    </form>
</div>

<h1 class="links-heading">Explore the Knowledge Base</h1>

<div id="links-section">

    <div class="link-box">
        <div class="box-title">dictionary</div>
        <div class="box-desc">find words and their meanings</div>
    </div>

    <div class="link-box">
        <div class="box-title">kanji</div>
        <div class="box-desc">find kanji of words</div>
    </div>

    <div class="link-box">
        <div class="box-title">phrases</div>
        <div class="box-desc">find commonly used phrases</div>
    </div>

    <div class="link-box">
        <div class="box-title">verbs</div>
        <div class="box-desc">find verbs and their various forms</div>
    </div>

    <div class="link-box">
        <div class="box-title">search</div>
        <div class="box-desc">search for a word</div>
    </div>

<!--    <div class="link-box">-->
<!--        <div class="box-title">kanji</div>-->
<!--        <div class="box-desc">find words and their meanings</div>-->
<!--    </div>-->
<!---->
<!--    <div class="link-box">-->
<!--        <div class="box-title">phrases</div>-->
<!--        <div class="box-desc">find words and their meanings</div>-->
<!--    </div>-->
</div>

</body>
</html>