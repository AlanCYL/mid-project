<?php
require_once("../db-connect.php");

$groups_id=$_GET["list"];

$sql="DELETE FROM groups WHERE groups_id='$groups_id'";


if ($conn->query($sql) === TRUE) {
    $url = "group-list.php";
    header("location: ".$url);
} else {
    echo "刪除資料錯誤: " . $conn->error;
}
?>