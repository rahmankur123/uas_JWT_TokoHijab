<?php
header("Content-Type: application/json");

/* ======================
   AMBIL AUTH HEADER
   ====================== */
$headers = getallheaders();
$auth = $headers["Authorization"] ?? "";

if (!$auth) {
    http_response_code(401);
    echo json_encode([
        "status" => false,
        "message" => "Token kosong"
    ]);
    exit;
}

/* ======================
   AMBIL TOKEN
   ====================== */
$token = str_replace("Bearer ", "", $auth);
$parts = explode(".", $token);

if (count($parts) !== 3) {
    http_response_code(401);
    echo json_encode([
        "status" => false,
        "message" => "Token tidak valid"
    ]);
    exit;
}

list($header, $payload, $signature) = $parts;
$secret = "jwtsecret";

/* ======================
   VERIFIKASI SIGNATURE
   ====================== */
$verify = base64_encode(
    hash_hmac("sha256", "$header.$payload", $secret, true)
);

if ($verify !== $signature) {
    http_response_code(401);
    echo json_encode([
        "status" => false,
        "message" => "Signature token salah"
    ]);
    exit;
}

/* ======================
   DECODE PAYLOAD
   ====================== */
$data = json_decode(base64_decode($payload), true);

if (!$data || !isset($data["exp"])) {
    http_response_code(401);
    echo json_encode([
        "status" => false,
        "message" => "Payload token tidak valid"
    ]);
    exit;
}

/* ======================
   CEK EXPIRED
   ====================== */
if ($data["exp"] < time()) {
    http_response_code(401);
    echo json_encode([
        "status" => false,
        "message" => "Token sudah kadaluarsa"
    ]);
    exit;
}

/* ======================
   CEK ROLE (ADMIN)
   ====================== */
if (isset($ALLOW_ROLE)) {
    if (!in_array($data["role"], $ALLOW_ROLE)) {
        http_response_code(403);
        echo json_encode([
            "status" => false,
            "message" => "Error - hanya admin yang bisa mengakses fitur ini"
        ]);
        exit;
    }
}

/* ======================
   SIMPAN DATA USER
   ====================== */
$GLOBALS["user"] = $data;
