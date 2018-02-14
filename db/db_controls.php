<?php

//$config = parse_ini_file('./config.php');
$db = mysqli_connect('localhost','fatFighter','fatFighter_1997','FatJapan');

function db_query($query, $dbc) {
    $result = mysqli_query($dbc, $query);
    return $result;
}

function db_select($query, $dbc) {
    $rows = array();
    $result = db_query($query, $dbc);
    $serial = 1;
    while ($row = mysqli_fetch_array($result)) {
        $row['Serial'] = $serial;
        $rows[] = $row;
        $serial = $serial + 1;
    }
    return $rows;
}

function db_error($dbc) {
    return mysqli_error($dbc);
}

function db_quote($value, $dbc) {
    $escape_value = mysqli_escape_string($dbc, $value);
    if (gettype($value) == "string") {
        return "'" . $escape_value . "'";
    }
    else {
        return $escape_value;
    }
}