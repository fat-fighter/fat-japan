<?php

$header_links = array("home"=>"index.php", "dictionary"=>"search.php?type=1&category=words", "phrases"=>"search.php?type=1&category=phrases", "verbs" => "search.php?type=1&category=verbs", "references" => "reference.php", "search" => "search.php?type=0");

if ($_SESSION['admin'] == true) {
    $header_links["admin"] = "edit.php";
    $header_links["logout"] = "logout.php";
}

?>

<link rel="stylesheet" href="css/header.css">

<header>
    <div class="sections">
        <?php
            foreach (array_keys($header_links) as $key) {
                if ($key == $page_type) {
                    $class = "active";
                }
                else {
                    $class = "";
                }
                echo "<a href='" . $header_links["$key"] . "' class='$class'><span class='section'>$key</span></a>";
            }
        ?>
    </div>
    <div class="logo">F<span>J</span></div>
</header>