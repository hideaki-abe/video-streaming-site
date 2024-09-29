<?php include('config/db.php'); ?>
<?php include('includes/header.php'); ?>

<!-- 動画詳細コンテナ -->
<div class="video-detail-container">
    <?php
    // URLパラメータから動画IDを取得
    $video_id = $_GET['id'];

    // 動画情報を取得するためのSQLクエリを作成
    $sql = "SELECT * FROM videos WHERE id = $video_id"; // 動画IDに基づいて動画情報を取得
    $result = $conn->query($sql); // クエリを実行して結果を取得

    // クエリ結果が1件以上あれば動画情報を表示
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // 結果を連想配列として取得
        // 動画タイトルと動画プレイヤーを表示
        echo '
        <h1 class="video-title">お題：' . $row['title'] . '</h1> <!-- 動画タイトルを表示 -->
        <div class="video-wrapper">
            <video controls> <!-- 動画プレイヤー -->
                <source src="' . $row['video_path'] . '" type="video/mp4"> <!-- 動画ファイルのパスを指定 -->
                お使いのブラウザでは動画を再生できません。 <!-- ブラウザが動画をサポートしない場合のメッセージ -->
            </video>
        </div>';
    } else {
        // 動画が見つからない場合のエラーメッセージ
        echo "<p>動画が見つかりません。</p>";
    }
    ?>

    <!-- コメント並び替えオプション -->
    <div class="sort-comments">
        <h2>セリフ一覧</h2> <!-- コメントのリストのセクション -->
        <p>
            <!-- コメントの並び替えオプションリンク -->
            <a href="video.php?id=<?php echo $video_id; ?>&order_by=newest">新着順</a> |
            <a href="video.php?id=<?php echo $video_id; ?>&order_by=liked">いいね順</a>
        </p>
    </div>

    <!-- コメント表示エリア -->
    <div class="comment-display-wrapper">
        <?php
        // 並び替えオプションの設定
        $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'newest'; // GETパラメータがあれば取得、なければデフォルトで「新着順」

        // 並び替えオプションに応じたSQLクエリを作成
        if ($order_by === 'liked') {
            // 「いいね」順でコメントを取得するクエリ
            $sql_comments = "SELECT comments.*, COUNT(comment_likes.id) as like_count
                            FROM comments
                            LEFT JOIN comment_likes ON comments.id = comment_likes.comment_id
                            WHERE video_id = $video_id
                            GROUP BY comments.id
                            ORDER BY like_count DESC, created_at DESC"; // いいね数が多い順にソートし、同数の場合は新着順
        } else {
            // 新着順でコメントを取得するクエリ
            $sql_comments = "SELECT comments.*, (SELECT COUNT(*) FROM comment_likes WHERE comment_likes.comment_id = comments.id) as like_count
                            FROM comments
                            WHERE video_id = $video_id
                            ORDER BY created_at DESC"; // 作成日時が新しい順にソート
        }

        // コメントを取得して表示
        $comments_result = $conn->query($sql_comments); // コメントに対するSQLクエリを実行

        if ($comments_result->num_rows > 0) {
            // 取得したコメントを1件ずつループで表示
            while ($comment_row = $comments_result->fetch_assoc()) {
                $comment_id = $comment_row['id']; // コメントのIDを取得
                $like_count = $comment_row['like_count']; // いいねの数を取得
                $created_at = strtotime($comment_row['created_at']); // 投稿日時をUNIXタイムスタンプに変換
                $formatted_time = date('n/j H:i', $created_at); // 日付を M/D H:MM の形式にフォーマット

                // 現在のユーザーのIPアドレスを取得
                $user_ip = $_SERVER['REMOTE_ADDR']; // ユーザーのIPアドレスを取得して後でいいね状況を確認するために使用

                // ユーザーがこのコメントに「いいね」したかどうかを確認するクエリ
                $liked_sql = "SELECT * FROM comment_likes WHERE comment_id = $comment_id AND ip_address = '$user_ip'";
                $liked_result = $conn->query($liked_sql); // クエリを実行して結果を取得
                $liked = $liked_result->num_rows > 0; // いいねしているかどうかをチェック

                // いいねボタンのテキストを「いいね」か「取消す」で切り替え
                $like_button_text = $liked ? "取消す" : "いいね"; // 既にいいねしていれば「取消す」を表示

                // コメントの内容といいねボタン、投稿時間を表示
                echo '<div class="comment-item">';
                echo '<p>' . htmlspecialchars($comment_row['comment']) . '</p>'; // コメント内容をエスケープして表示
                echo '<div class="comment-info">';
                echo '<span>投稿 ' . $formatted_time . '</span>'; // フォーマット済みの投稿時間を表示
                echo '<div class="comment-likes">
                        <span>いいね: <span class="like-count">' . $like_count . '</span></span> <!-- いいねの数を表示 -->
                        <button class="like-button" data-comment-id="' . $comment_id . '" data-liked="' . $liked . '">' . $like_button_text . '</button> <!-- いいねボタン -->
                      </div>';
                echo '</div>';  // コメント情報の閉じタグ
                echo '</div>';  // コメント全体の閉じタグ
            }
        } else {
            // コメントがない場合のメッセージ
            echo "<p>セリフはまだありません。</p>";
        }
        ?>
    </div>

    <!-- セリフ投稿フォーム -->
    <div class="comment-section">
        <h2>セリフ投稿</h2> <!-- セリフ投稿フォームの見出し -->
        <form action="video.php?id=<?php echo $video_id; ?>" method="post">
            <textarea name="comment" rows="3" placeholder="セリフを入力してください" required></textarea><br> <!-- テキストエリア -->
            <button type="submit" class="submit-comment">POST</button> <!-- 送信ボタン -->
        </form>

        <?php
        // セリフが投稿された場合の処理
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
            $comment = $conn->real_escape_string($_POST['comment']); // 入力されたコメントをエスケープ
            $sql_insert = "INSERT INTO comments (video_id, comment) VALUES ($video_id, '$comment')"; // コメントをデータベースに挿入するSQLクエリ
            if ($conn->query($sql_insert) === TRUE) {
                echo "<p class='success-message'>セリフが投稿されました！</p>"; // 成功メッセージ
                // ページをリロードして新しいコメントを表示
                header("Location: video.php?id=$video_id");
            } else {
                // 投稿に失敗した場合のエラーメッセージ
                echo "<p class='error-message'>セリフの投稿に失敗しました。</p>";
            }
        }
        ?>
    </div>
</div>

<?php include('includes/footer.php'); ?> <!-- フッターを読み込み -->