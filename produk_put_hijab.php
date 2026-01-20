<?php
$ALLOW_ROLE = ["admin","staff"];
require "middleware_hijab.php";

$data = json_decode(file_get_contents("php://input"), true);

echo json_encode([
 "message"=>"Stok berhasil diperbarui",
 "data"=>$data
]);