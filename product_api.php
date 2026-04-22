<?php
include "../config/db.php";

$res = $conn->query("SELECT * FROM products");

$data = [];

while($row = $res->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);