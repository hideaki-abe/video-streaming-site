<?php include('config/db.php'); ?>
<?php include('includes/header.php'); ?>

<div class="container">
    <!-- メインタイトル -->
    <h1 class="site-title">ショート動画で一言</h1>

    <!-- 最新の動画セクション -->
    <section class="main-video-section">
        <h2>最新動画</h2>
        <div class="main-video">
            <?php
            // データベースから最新動画取得
            $sql = "SELECT * FROM videos ORDER BY upload_date DESC LIMIT 1";
            $result = $conn->query($sql); // クエリ実行

            // 結果がある場合は動画表示
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc(); // 結果を配列として取得
                $formatted_time = date("n/j H:i", strtotime($row['upload_date']));
                echo '
                <div class="video-item">
                    <a href="video.php?id=' . $row['id'] . '"> <!-- 動画の詳細ページへのリンク -->
                        <video class="thumbnail" controls> <!-- 動画プレイヤー -->
                            <source src="' . $row['video_path'] . '" type="video/mp4"> <!-- 動画ファイルのパス -->
                            お使いのブラウザでは動画を再生できません。 <!-- ブラウザ非対応時のメッセージ -->
                        </video>
                        <h3>' . $row['title'] . '</h3> <!-- 動画のタイトル -->
                    </a>
                    <p>投稿 ' . $formatted_time . '</p> <!-- 投稿日時を表示 -->
                </div>';
            }
            ?>
        </div>
    </section>

    <!-- 新着動画セクション -->
    <section class="slider-section">
        <h2>新着動画</h2>
        <div class="slider-wrapper">
            <button class="slider-button left">&lt;</button>
            <div class="video-slider">
                <?php
                // データベースから新着動画取得（10件）
                $sql = "SELECT * FROM videos ORDER BY upload_date DESC LIMIT 10";
                $result = $conn->query($sql); // クエリ実行

                // 結果がある場合は動画をループ表示
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $formatted_time = date("n/j H:i", strtotime($row['upload_date']));
                        echo '
                        <div class="video-item">
                            <a href="video.php?id=' . $row['id'] . '"> <!-- 動画の詳細ページへのリンク -->
                                <video class="thumbnail" controls> <!-- 動画プレイヤー -->
                                    <source src="' . $row['video_path'] . '" type="video/mp4"> <!-- 動画ファイルのパス -->
                                    お使いのブラウザでは動画を再生できません。 <!-- ブラウザ非対応時のメッセージ -->
                                </video>
                                <h3>' . $row['title'] . '</h3> <!-- 動画のタイトル -->
                            </a>
                            <p>投稿 ' . $formatted_time . '</p> <!-- 投稿日時を表示 -->
                        </div>';
                    }
                } else {
                    // 動画がない場合のメッセージ
                    echo "<p>動画がありません。</p>";
                }
                ?>
            </div>
            <button class="slider-button right">&gt;</button>
        </div>
    </section>

    <!-- 人気動画セクション -->
    <section class="slider-section">
        <h2>人気動画</h2>
        <div class="slider-wrapper">
            <button class="slider-button left">&lt;</button>
            <div class="video-slider">
                <?php
                // いいねの数に基づいて人気動画を取得
                $sql = "SELECT videos.*, COUNT(comment_likes.id) as like_count
                        FROM videos
                        LEFT JOIN comments ON videos.id = comments.video_id
                        LEFT JOIN comment_likes ON comments.id = comment_likes.comment_id
                        GROUP BY videos.id
                        ORDER BY like_count DESC, upload_date DESC LIMIT 10";
                $result = $conn->query($sql); // クエリ実行

                // 結果がある場合は動画をループ表示
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="video-item">
                            <a href="video.php?id=' . $row['id'] . '"> <!-- 動画の詳細ページへのリンク -->
                                <video class="thumbnail" controls> <!-- 動画プレイヤー -->
                                    <source src="' . $row['video_path'] . '" type="video/mp4"> <!-- 動画ファイルのパス -->
                                    お使いのブラウザでは動画を再生できません。 <!-- ブラウザ非対応時のメッセージ -->
                                </video>
                                <h3>' . $row['title'] . '</h3> <!-- 動画のタイトル -->
                            </a>
                            <p>いいね ' . $row['like_count'] . '</p> <!-- いいね数の表示 -->
                        </div>';
                    }
                } else {
                    echo "<p>動画がありません。</p>";
                }
                ?>
            </div>
            <button class="slider-button right">&gt;</button>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>

<?php // エラーレポートの有効化
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>