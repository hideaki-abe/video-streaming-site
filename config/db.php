<?php
// データベース接続情報
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "video_site";

// MySQLデータベース接続用オブジェクト作成
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラー処理
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
