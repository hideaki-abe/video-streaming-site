<?php
include('config/db.php'); // データベース接続を読み込む

header('Content-Type: application/json'); // クライアントに対して、このリクエストがJSON形式のレスポンスを返すことを通知する

// リクエストメソッドがPOSTの場合に処理を行う
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comment_id']; // POSTされたコメントIDを取得
    $user_ip = $_SERVER['REMOTE_ADDR']; // 現在のユーザーのIPアドレスを取得（1つのIPアドレスあたり1つの「いいね」）
    $liked = $_POST['liked'] === 'true';  // 「いいね」の状態を取得（trueの場合は「いいね」を取り消す）

    // エラーハンドリング用のレスポンスデフォルト値
    $response = ['success' => false]; // 成功のデフォルト値をfalseに設定

    if ($liked) {
        // 「いいね」を取り消す場合の処理
        $sql = "DELETE FROM comment_likes WHERE comment_id = $comment_id AND ip_address = '$user_ip'"; // 既存の「いいね」を削除するSQLクエリ
        if ($conn->query($sql) === TRUE) {
            // 削除が成功した場合、成功レスポンスを返す
            $response['success'] = true;
            $response['action'] = 'unliked'; // 「いいね」を取り消したことを示す
        } else {
            // SQLエラーが発生した場合、エラーメッセージをレスポンスに含める
            $response['error'] = $conn->error;
        }
    } else {
        // 「いいね」を追加する場合の処理
        $sql = "INSERT INTO comment_likes (comment_id, ip_address) VALUES ($comment_id, '$user_ip')"; // 新しい「いいね」を追加するSQLクエリ
        if ($conn->query($sql) === TRUE) {
            // 挿入が成功した場合、成功レスポンスを返す
            $response['success'] = true;
            $response['action'] = 'liked'; // 「いいね」を追加したことを示す
        } else {
            // SQLエラーが発生した場合、エラーメッセージをレスポンスに含める
            $response['error'] = $conn->error;
        }
    }

    // 結果をJSON形式でクライアントに返す
    echo json_encode($response); // レスポンスをエンコードして出力
}
