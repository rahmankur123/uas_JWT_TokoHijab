<?php
header("Content-Type: application/json");

$users = [
 ["username"=>"admin","password"=>"admin123","role"=>"admin"],
 ["username"=>"staff","password"=>"staff123","role"=>"staff"],
 ["username"=>"customer","password"=>"customer123","role"=>"customer"],
 ["username"=>"akuntan","password"=>"akuntan123","role"=>"akuntan"]
];

$data = json_decode(file_get_contents("php://input"), true);
$user = $data["username"] ?? "";
$pass = $data["password"] ?? "";

foreach($users as $u){
 if($u["username"]==$user && $u["password"]==$pass){
   $header = base64_encode(json_encode(["alg"=>"HS256","typ"=>"JWT"]));
   $payload = base64_encode(json_encode([
     "username"=>$u["username"],
     "role"=>$u["role"],
     "exp"=>time()+3600
   ]));
   $secret="jwtsecret";
   $signature = base64_encode(hash_hmac("sha256","$header.$payload",$secret,true));
   echo json_encode(["token"=>"$header.$payload.$signature"]);
   exit;
 }
}
echo json_encode(["error"=>"Login gagal"]);
?>