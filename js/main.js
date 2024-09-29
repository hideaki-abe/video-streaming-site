document.addEventListener('DOMContentLoaded', function () {
    // 「いいね」ボタンのクリックイベント
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.getAttribute('data-comment-id');  // クリックされたコメントのID取得
            const liked = this.getAttribute('data-liked') === 'true';  // 現在「いいね」されているか確認

            // デバッグ用
            console.log(`Comment ID: ${commentId}, Liked: ${liked}`);

            // AJAXリクエストで「いいね」情報をサーバーに送信
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'like.php', true);  // POSTリクエストサーバー送信
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');  // リクエストヘッダー設定
            xhr.onload = () => {
                if (xhr.status === 200) {  // 正常なレスを受け取った場合
                    try {
                        const response = JSON.parse(xhr.responseText);  // レスポンスをJSONとしてパース
                        if (response.success) {
                            const likeCountSpan = this.parentElement.querySelector('.like-count');  // いいねのカウント要素取得
                            // 「いいね」された場合と取り消された場合
                            if (response.action === 'liked') {
                                this.textContent = '取消す';  // ボタンのテキストを「取消す」に変更
                                this.setAttribute('data-liked', 'true'); 
                            } else {
                                this.textContent = 'いいね';  // ボタンのテキストを「いいね」に戻す
                                this.setAttribute('data-liked', 'false'); 
                            }
                            // いいねカウント更新
                            likeCountSpan.textContent = parseInt(likeCountSpan.textContent) + (response.action === 'liked' ? 1 : -1);
                        } else {
                            // エラーメッセージ表示
                            console.error('エラー:', response.error);
                        }
                    } catch (e) {
                        // JSONパースエラーが発生した場合
                        console.error('JSONのパースエラー:', e);
                    }
                }
            };
            // リクエストデータとして「コメントID」と「いいね」状態を送信
            xhr.send(`comment_id=${commentId}&liked=${liked}`);
        });
    });

    // スライダーボタンの動作を設定
    const sliders = document.querySelectorAll('.video-slider');  // すべてのスライダーを取得
    sliders.forEach(slider => {
        const leftButton = slider.parentElement.querySelector('.slider-button.left');  // 左スライドボタンを取得
        const rightButton = slider.parentElement.querySelector('.slider-button.right');  // 右スライドボタンを取得

        // 左ボタンがクリックされたときのスライド動作
        leftButton?.addEventListener('click', () => {
            slider.scrollBy({ left: -300, behavior: 'smooth' });  // 300px左にスクロール
        });

        // 右ボタンがクリックされたときのスライド動作
        rightButton?.addEventListener('click', () => {
            slider.scrollBy({ left: 300, behavior: 'smooth' });  // 300px右にスクロール
        });
    });

    // デバッグ用
    console.log('スライダー要素:', sliders);
    sliders.forEach(slider => {
        console.log('左ボタン:', slider.parentElement.querySelector('.slider-button.left'));
        console.log('右ボタン:', slider.parentElement.querySelector('.slider-button.right'));
    });

    // 動画クリック時に動画詳細ページへの遷移設定
    const videoItems = document.querySelectorAll('.video-item');  // 全ての動画アイテム取得

    videoItems.forEach(item => {
        const videoLink = item.querySelector('a');  // 動画アイテム内のリンク取得
        const videoElement = item.querySelector('video');  // 動画要素を取得

        if (videoLink && videoElement) {
            // 動画クリック時にリンク先へ遷移
            videoElement.addEventListener('click', function () {
                window.location.href = videoLink.href;  // リンク先のURLに遷移
            });
        }
    });
});


// スライダーボタン動作設定（再定義）
const sliders = document.querySelectorAll('.video-slider');  // スライダー要素再取得
sliders.forEach(slider => {
    const leftButton = slider.parentElement.querySelector('.slider-button.left');  // 左ボタン取得
    const rightButton = slider.parentElement.querySelector('.slider-button.right');  // 右ボタン取得

    // 左ボタンクリック時スライド動作
    leftButton?.addEventListener('click', () => {
        slider.scrollBy({ left: -300, behavior: 'smooth' });  // 300px左にスクロール
    });

    // 右ボタンクリック時スライド動作
    rightButton?.addEventListener('click', () => {
        slider.scrollBy({ left: 300, behavior: 'smooth' });  // 300px右にスクロール
    });
});

// デバッグ用
console.log('スライダー要素:', sliders);
sliders.forEach(slider => {
    console.log('左ボタン:', slider.parentElement.querySelector('.slider-button.left'));
    console.log('右ボタン:', slider.parentElement.querySelector('.slider-button.right'));
});
