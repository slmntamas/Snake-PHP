<?php
session_start();
require("connect.php");

if (!isset($_SESSION["id"])) {
    echo json_encode(["status" => "error", "message" => "Nincs bejelentkezve"]);
    exit();
}


if (!isset($_POST["score"])) {
    echo json_encode(["status" => "error", "message" => "Nincs pontszám"]);
    exit();
}

$score = intval($_POST["score"]);
$userId = $_SESSION["id"];

$stmt = $kapcsolat->prepare("UPDATE user SET score = GREATEST(score, :score) WHERE id = :id");
$stmt->execute([
    "score" => $score,
    "id" => $userId
]);

echo json_encode(["status" => "success", "message" => "Pontszám mentve!"]);
?>