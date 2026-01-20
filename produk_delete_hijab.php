<?php
header("Content-Type: application/json");

$ALLOW_ROLE = ["admin"];
require "middleware_hijab.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? null;

if(!$id){
  echo json_encode(["error"=>"ID produk wajib"]);
  exit;
}

echo json_encode([
  "message" => "Produk berhasil dihapus",
  "id" => $id,
  "deleted_by" => $GLOBALS["user"]["username"]
]);