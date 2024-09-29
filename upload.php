<?php
include('config/db.php');
include('includes/header.php');

// デバッグ用エラーレポート
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!-- 動画アップロード用のコンテナ -->
<div class="upload-container">
    <h1 class="upload-title">お題動画アップロード</h1>

    <!-- 動画アップロードフォーム -->
    <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">
        <!-- お題入力フィールド -->
        <div class="form-group">
            <label for="title">お題</label>
            <input type="text" id="title" name="title" placeholder="お題を入力してください" required>
        </div>

        <!-- 動画ファイルの選択フィールド -->
        <div class="form-group">
            <label for="video">動画ファイル選択</label>
            <input type="file" id="video" name="video" accept="video/*" required>
        </div>

        <!-- アップロードボタン -->
        <button type="submit" name="submit" class="upload-button">UPLOAD</button>
    </form>

    <?php
    // フォームがPOSTリクエストで送信された場合の処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // フォームから送信されたデータを取得
        $title = $conn->real_escape_string($_POST['title']);
        $video = $_FILES['video'];
        $target_dir = "videos/";

        // ファイルサイズ制限
        $maxFileSize = 100 * 1024 * 1024; // 100MB
        if ($video['size'] > $maxFileSize) {
            echo "<p class='error-message'>動画ファイルが大きすぎます。最大100MBまでです。</p>";
        } else {
            // 動画保存用ディレクトリが存在しない場合は新規作成
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true) && !is_dir($target_dir)) {
                    echo "<p class='error-message'>ディレクトリの作成に失敗しました。</p>";
                    exit;
                }
            }

            // 動画ファイルの保存先パスを設定
            $target_file = $target_dir . basename($video['name']);

            // ファイル形式のチェック（MIMEタイプ）
            $allowedTypes = ['video/mp4', 'video/webm', 'video/ogg'];
            if (!in_array($video['type'], $allowedTypes)) {
                echo "<p class='error-message'>対応している動画形式はMP4、WEBM、OGGのみです。</p>";
            } else {
                // ファイルをサーバーにアップロード
                if (move_uploaded_file($video['tmp_name'], $target_file)) {
                    $sql = "INSERT INTO videos (title, video_path) VALUES ('$title', '$target_file')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<p class='success-message'>動画がアップロードされました！</p>";
                    } else {
                        echo "<p class='error-message'>データベースへの保存に失敗しました: " . $conn->error . "</p>";
                    }
                } else {
                    echo "<p class='error-message'>動画のアップロードに失敗しました。</p>";
                }
            }
        }
    }
    ?>
</div>
<br><br><br><br><br><br><br><br><br>
<?php include('includes/footer.php'); ?>