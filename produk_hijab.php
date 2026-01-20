<?php
$ALLOW_ROLE = ["admin","staff", "customer", "akuntan"];
require "middleware_hijab.php";

// GET HIJAB -- SEMUA ROLE BISA MELAKUKAN
$produk = [
 ["id"=>1,"nama"=>"Hijab Pashmina","stok"=>50, "harga"=>55000],
 ["id"=>2,"nama"=>"Hijab Instan","stok"=>25, "harga"=>35000]
];

echo json_encode([
 "user"=>$GLOBALS["user"],
 "produk"=>$produk
]);