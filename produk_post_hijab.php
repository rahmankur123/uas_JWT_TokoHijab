<?php
$ALLOW_ROLE = ["admin"];
require "middleware_hijab.php";

$data = json_decode(file_get_contents("php://input"), true);

echo json_encode([
 "message"=>"Produk berhasil ditambahkan",
 "produk"=>$data
]);