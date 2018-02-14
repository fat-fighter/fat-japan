<?php

include("db_controls.php");

switch ($_POST['operation']) {
    case 'post':
        $word = db_quote($_POST['word'], $db);
        $meaning = db_quote($_POST['meaning'], $db);
        $kanji = db_quote($_POST['kanji'], $db);
        $category = db_quote($_POST['category'], $db);
        $tag = db_quote($_POST['tag'], $db);
        $uses = db_quote($_POST['usage'], $db);

        if (isset($_POST['id']) && $_POST['id'] != "") {
            $id = $_POST['id'];

            $query = "UPDATE Dictionary SET Word = $word, Meaning = $meaning, Kanji = $kanji, Category = $category, Tag = $tag, Uses = $uses WHERE WordId = $id";
            $result = db_query($query, $db);
        }
        else {
            $query = "INSERT INTO Dictionary (Word, Meaning, Kanji, Category, Tag, Uses) VALUES ($word, $meaning, $kanji, $category, $tag, $uses)";
            $result = db_query($query, $db);

            $id = db_select("SELECT Max(WordId) FROM Dictionary", $db);
            $id = $id[0]['Max(WordId)'];
        }

        if (!$result) {
            header("location: ../edit.php?error=true");
        }

//        header("location: ../edit.php?id=$id");
        header("location: ../edit.php");

        break;

    case 'load':
        if (isset($_POST['id']) && $_POST['id'] != "") {
            $query = "SELECT * FROM Dictionary WHERE WordId = " . $_POST['id'];
            $result = db_select($query, $db);
            if ($result) {
                echo json_encode($result[0]);
            }
            else {
                echo "false";
            }
            break;
        }

        if (isset($_POST['limit']) && intval($_POST['limit']) > 0) {
            $limit = $_POST['limit'];
        }
        else {
            $limit = 25;
        }

        if (isset($_POST['page']) && intval($_POST['page']) > 0) {
            $start = ($_POST['page'] - 1) * $limit;
        }
        else {
            $start = 0;
        }

        if (isset($_POST['category']) && $_POST['category'] != "") {
            $categories = explode(" ", $_POST['category']);
        }
        else {
            $categories = array("words", "kanji", "phrases", "verbs");
        }

        $addQuery = " ";
        if (isset($_POST['tag']) && $_POST['tag'] != "") {
            $addQuery = $addQuery . "AND Tag LIKE '%" . $_POST['tag'] . "%' ";
        }
        if (isset($_POST['query']) && $_POST['query'] != "") {
            $addQuery = $addQuery . "AND CONCAT_WS('|', `Word`, `Meaning`) LIKE '%" . str_replace(" ", "%", $_POST['query']) . "%'";
        }

        $dictionary = array();
        foreach ($categories as $category) {
            $query = "SELECT * FROM Dictionary WHERE Category = '$category' $addQuery LIMIT $start,$limit";
            $result = db_select($query, $db);
            if ($result) {
                $dictionary[] = array("Category" => $category, "Content" => $result);
            }
        }

        echo json_encode($dictionary);
        break;

    case 'delete':
        $result = db_query("DELETE FROM Dictionary WHERE WordId = " . $_POST['wordId'], $db);
        if (!$result) {
            echo "false";
        }

        break;

    case 'count':
        $addQuery = (isset($_POST['category']) && $_POST['category'] != "") ? "WHERE Category = " . $db -> quote($_POST['category']) : "";

        $query = "SELECT COUNT(*) FROM Dictionary $addQuery";
        $result = db_select($query, $db);

        echo (($result) ? $result[0]["COUNT(*)"] : false);

        break;
}
