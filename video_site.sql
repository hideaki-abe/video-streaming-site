-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-09-29 09:54:55
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `video_site`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`id`, `video_id`, `comment`, `created_at`) VALUES
(39, 17, 'テストテストテストテストテスト', '2024-09-28 12:22:08'),
(40, 17, 'テストテストテストテストテスト', '2024-09-28 12:22:50'),
(41, 17, 'テストテストテストテストテスト', '2024-09-28 12:22:55'),
(42, 17, 'テストテストテストテストテスト', '2024-09-28 12:23:06'),
(43, 17, 'テストテストテストテストテスト', '2024-09-28 12:23:20'),
(44, 18, 'テストテストテストテストテスト', '2024-09-28 12:27:36'),
(45, 18, 'テストテストテストテストテスト', '2024-09-28 12:27:39'),
(46, 19, 'テストテストテストテストテスト', '2024-09-28 12:28:32'),
(47, 19, 'テストテストテストテストテスト', '2024-09-28 12:28:34'),
(48, 18, 'テストテストテストテストテスト', '2024-09-28 12:28:53'),
(49, 20, 'テストテストテストテストテスト', '2024-09-28 12:30:09'),
(50, 20, 'テストテストテストテストテスト', '2024-09-28 12:30:11'),
(51, 19, 'テストテストテストテストテスト', '2024-09-28 12:30:22'),
(52, 18, 'テストテストテストテストテスト', '2024-09-28 12:30:48'),
(53, 21, 'テストテストテストテストテスト', '2024-09-28 12:32:28'),
(54, 21, 'テストテストテストテストテスト', '2024-09-28 12:32:30'),
(55, 20, 'テストテストテストテストテスト', '2024-09-28 12:32:41'),
(56, 19, 'テストテストテストテストテスト', '2024-09-28 12:32:57'),
(59, 22, 'テストテストテストテストテスト', '2024-09-28 12:36:09'),
(60, 22, 'テストテストテストテストテスト', '2024-09-28 12:36:12'),
(61, 21, 'テストテストテストテストテスト', '2024-09-28 12:36:20'),
(62, 20, 'テストテストテストテストテスト', '2024-09-28 12:36:29'),
(63, 20, 'テストテストテストテストテスト', '2024-09-28 12:36:53'),
(64, 19, 'テストテストテストテストテスト', '2024-09-28 12:37:32'),
(65, 18, 'テストテストテストテストテスト', '2024-09-28 12:37:45'),
(66, 24, 'テストテストテストテストテスト', '2024-09-28 12:38:50'),
(67, 24, 'テストテストテストテストテスト', '2024-09-28 12:38:53'),
(69, 22, 'テストテストテストテストテスト', '2024-09-28 12:39:12'),
(70, 21, 'テストテストテストテストテスト', '2024-09-28 12:39:25'),
(71, 25, 'テストテストテストテストテスト', '2024-09-28 12:40:08'),
(72, 25, 'テストテストテストテストテスト', '2024-09-28 12:40:12'),
(73, 24, 'テストテストテストテストテスト', '2024-09-28 12:40:25'),
(75, 22, 'テストテストテストテストテスト', '2024-09-28 12:40:47'),
(76, 21, 'テストテストテストテストテスト', '2024-09-28 12:40:57'),
(77, 22, 'テストテストテストテストテスト', '2024-09-28 12:41:09'),
(82, 25, 'テストテストテストテストテスト', '2024-09-28 12:43:28'),
(83, 24, 'テストテストテストテストテスト', '2024-09-28 12:43:40'),
(85, 24, 'テストテストテストテストテスト', '2024-09-28 12:44:14'),
(92, 25, 'テストテストテストテストテスト', '2024-09-28 12:48:03'),
(93, 28, 'テストテストテストテストテスト', '2024-09-28 12:56:59'),
(94, 28, 'テストテストテストテストテスト', '2024-09-28 12:57:03'),
(95, 29, 'テストテストテストテストテスト', '2024-09-28 12:57:31'),
(96, 29, 'テストテストテストテストテスト', '2024-09-28 12:57:34'),
(97, 28, 'テストテストテストテストテスト', '2024-09-28 12:58:01'),
(98, 29, 'テストテストテストテストテスト', '2024-09-28 12:58:18');

-- --------------------------------------------------------

--
-- テーブルの構造 `comment_likes`
--

CREATE TABLE `comment_likes` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `comment_likes`
--

INSERT INTO `comment_likes` (`id`, `comment_id`, `ip_address`, `created_at`) VALUES
(154, 43, '::1', '2024-09-28 12:23:24'),
(155, 41, '::1', '2024-09-28 12:23:26'),
(156, 39, '::1', '2024-09-28 12:23:29'),
(158, 67, '::1', '2024-09-28 12:44:11'),
(160, 83, '::1', '2024-09-28 12:44:26'),
(161, 66, '::1', '2024-09-28 12:44:29'),
(168, 77, '::1', '2024-09-28 12:45:21'),
(169, 69, '::1', '2024-09-28 12:45:23'),
(170, 59, '::1', '2024-09-28 12:45:25'),
(176, 48, '::1', '2024-09-28 12:46:41'),
(177, 44, '::1', '2024-09-28 12:46:43'),
(178, 76, '::1', '2024-09-28 12:46:55'),
(179, 61, '::1', '2024-09-28 12:46:56'),
(180, 53, '::1', '2024-09-28 12:46:58'),
(181, 63, '::1', '2024-09-28 12:47:10'),
(182, 55, '::1', '2024-09-28 12:47:11'),
(183, 49, '::1', '2024-09-28 12:47:12'),
(185, 92, '::1', '2024-09-28 12:48:05'),
(186, 72, '::1', '2024-09-28 12:48:07'),
(187, 97, '::1', '2024-09-28 12:58:04'),
(188, 93, '::1', '2024-09-28 12:58:05'),
(189, 98, '::1', '2024-09-28 12:58:21'),
(190, 95, '::1', '2024-09-28 12:58:22');

-- --------------------------------------------------------

--
-- テーブルの構造 `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `video_path` varchar(255) NOT NULL,
  `thumbnail_path` varchar(255) DEFAULT '',
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `videos`
--

INSERT INTO `videos` (`id`, `title`, `video_path`, `thumbnail_path`, `upload_date`) VALUES
(17, '心配させて', 'videos/心配させて.mp4', '', '2024-09-28 12:18:51'),
(18, '感動させて', 'videos/感動とさせて.mp4', '', '2024-09-28 12:27:20'),
(19, '微妙な気持ちにさせて', 'videos/微妙な気持ちにさせて.mp4', '', '2024-09-28 12:28:22'),
(20, '喜ばせて', 'videos/喜ばせて.mp4', '', '2024-09-28 12:29:53'),
(21, 'ワクワクさせて', 'videos/ワクワクさせて.mp4', '', '2024-09-28 12:32:21'),
(22, 'キュンとさせて', 'videos/キュンとさせて.mp4', '', '2024-09-28 12:35:04'),
(24, '不安にさせて', 'videos/不安にさせて.mp4', '', '2024-09-28 12:38:38'),
(25, '怒らせて', 'videos/怒らせて.mp4', '', '2024-09-28 12:39:53'),
(28, '笑わせて', 'videos/笑わせて.mp4', '', '2024-09-28 12:56:51'),
(29, '泣かせて', 'videos/泣かせて.mp4', '', '2024-09-28 12:57:23');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`);

--
-- テーブルのインデックス `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- テーブルのインデックス `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- テーブルの AUTO_INCREMENT `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- テーブルの AUTO_INCREMENT `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `comment_likes_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
