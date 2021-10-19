-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Окт 19 2021 г., 11:37
-- Версия сервера: 5.7.32
-- Версия PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `laravel-training-project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author_user_id` int(11) NOT NULL,
  `name_chat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_chat` int(11) DEFAULT NULL,
  `chat_avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'img/demo/avatars/admin-f.png',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favorites` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `banned` int(11) DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'author'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chats`
--

INSERT INTO `chats` (`id`, `created_at`, `updated_at`, `author_user_id`, `name_chat`, `status_chat`, `chat_avatar`, `location`, `favorites`, `name`, `user_id`, `chat_id`, `banned`, `role`) VALUES
(1, NULL, '2021-09-28 01:51:04', 1, 'Наш чат  Номер  1', NULL, 'uploads/Ceujb1Ox3GrG5PbJNijV9FwQ9QedIGDaVbAwjWS0.jpg', '', NULL, 'Наш чат  Номер  1', 1, NULL, 0, 'author'),
(2, NULL, NULL, 1, 'Чат номер 1', NULL, 'uploads/nrLSsI9VkiOY02Oy7HM9sjZ18LH19ofTpFi9Yu3e.jpg', '', NULL, 'Чат номер 1', 1, NULL, NULL, 'author'),
(3, NULL, '2021-09-24 03:35:04', 1, 'Чат номер 1', NULL, 'uploads/ZJXEDXZjXY8lua0QY2wYKcuFZ4jh3ZwqYWjixyYm.jpg', '', NULL, 'Чат номер 1', 1, NULL, NULL, 'author'),
(4, NULL, '2021-09-26 03:04:57', 1, 'Чат номер 1', NULL, 'uploads/4HdaGORaWzyYaWqh7vhmwXC81QyWHtfAXQJookQY.jpg', '', '0', 'Чат номер 1', 1, NULL, 0, 'author'),
(6, NULL, '2021-09-24 03:41:51', 1, 'Чат номер 1', NULL, 'uploads/V3walcWZwStvZF9DKILsdGQVt9kx9kfwC8K92fJ3.jpg', '', NULL, 'Чат номер 1', 1, NULL, NULL, 'author'),
(7, NULL, '2021-09-24 03:44:18', 1, 'Чат номер 1', NULL, 'uploads/ycDahGGVmC2LxdZBCoH275r7B52HAFvfzuUjI8ur.jpg', '', NULL, 'Чат номер 1', 1, NULL, NULL, 'author'),
(9, NULL, '2021-09-25 04:18:19', 56, 'Чат крутого', NULL, 'img/demo/avatars/avatar-f.png', '', '0', 'Чат крутого', 56, NULL, 0, 'author');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentable_id` int(11) DEFAULT NULL,
  `banned` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `created_at`, `updated_at`, `user_id`, `comment`, `post_id`, `commentable_type`, `commentable_id`, `banned`) VALUES
(2, '2021-09-24 03:13:32', '2021-09-24 03:13:32', 1, 'Комментарий номер 2 к посту номер 4', 4, 'App\\Models\\Post', 4, NULL),
(3, '2021-09-24 03:14:38', '2021-09-26 14:25:32', 1, 'Комментарий к посту номер один к настоящему', 1, 'App\\Models\\Post', 1, 0),
(4, '2021-09-26 04:29:12', '2021-09-26 14:23:28', 1, 'tytytytyt', 1, 'App\\Models\\Post', 1, 0),
(6, '2021-09-26 04:53:12', '2021-09-26 04:53:12', 2, 'yyyyy', 4, 'App\\Models\\Post', 4, NULL),
(7, '2021-09-26 04:54:23', '2021-09-26 04:54:23', 2, 'Bbbbbbbbb', 5, 'App\\Models\\Post', 5, NULL),
(8, '2021-09-27 04:54:59', '2021-09-26 11:55:53', 1, 'BBBBbbbbbb', 5, 'App\\Models\\Post', 5, 1),
(9, '2021-09-28 04:59:17', '2021-09-26 04:59:17', 1, 'eererer', 5, 'App\\Models\\Post', 5, NULL),
(10, NULL, NULL, 1, 'NNNN TTTTT rrrrrr eeeeeeee', 5, NULL, NULL, NULL),
(12, NULL, NULL, 1, 'mnmnmnmnmmn', 1, NULL, NULL, NULL),
(16, NULL, NULL, 1, 'yuyyuyu', 2, NULL, NULL, NULL),
(17, NULL, NULL, 1, 'jjjjjjj', 1, NULL, NULL, NULL),
(23, '2021-10-18 06:18:36', '2021-10-18 06:18:36', 1, 'ророро', 7, NULL, NULL, NULL),
(24, '2021-10-18 11:08:34', '2021-10-18 11:08:34', 1, 'hjhhhhhhh', 5, NULL, NULL, NULL),
(25, '2021-10-19 05:56:54', '2021-10-19 05:56:54', 1, 'ИИИиииитит', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `imageable_id` int(11) NOT NULL,
  `imageable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `created_at`, `updated_at`, `image`, `user_id`, `post_id`, `imageable_id`, `imageable_type`, `chat_id`) VALUES
(1, '2021-09-24 03:10:06', '2021-09-24 03:10:06', 'uploads/92N39WJYcYD1bVDThbe1N86vfb72iQYko4ASkLX0.jpg', 1, 4, 4, 'App\\Models\\Post', NULL),
(2, '2021-09-26 04:54:15', '2021-09-26 04:54:15', 'uploads/kuksh_1200.webp', 2, 5, 5, 'App\\Models\\Post', NULL),
(3, '2021-09-26 04:54:15', '2021-09-26 04:54:15', 'uploads/kuksh_1200.webp', 2, 5, 5, 'App\\Models\\Post', NULL),
(4, '2021-09-26 04:54:15', '2021-09-26 04:54:15', 'uploads/kuksh_1200.webp', 2, 5, 5, 'App\\Models\\Post', NULL),
(6, '2021-09-26 04:54:15', '2021-09-26 04:54:15', 'uploads/kuksh_1200.webp', 2, 1, 5, 'App\\Models\\Post', NULL),
(8, '2021-09-26 04:54:15', '2021-09-26 04:54:15', 'uploads/kuksh_1200.webp', 1, 5, 5, 'App\\Models\\Post', NULL),
(9, '2021-09-26 04:54:15', '2021-09-26 04:54:15', 'uploads/kuksh_1200.webp', 1, 2, 5, 'App\\Models\\Post', NULL),
(10, '2021-10-15 07:00:22', '2021-10-15 07:00:22', 'uploads/166860_or.jpg', 1, 1, 1, 'App\\Model\\Post', NULL),
(11, '2021-10-15 07:00:52', '2021-10-15 07:00:52', 'uploads/20201117_170512 s 20 test 2.jpg', 1, 1, 1, 'App\\Model\\Post', NULL),
(12, '2021-10-15 07:17:00', '2021-10-15 07:17:00', 'uploads/Tas8EN166860_or.jpg', 1, 1, 1, 'App\\Model\\Post', NULL),
(13, '2021-10-15 07:21:17', '2021-10-15 07:21:17', 'uploads/ck4bJAimage_plane_red.png', 1, 1, 1, 'App\\Model\\Post', NULL),
(14, '2021-10-15 07:33:25', '2021-10-15 07:33:25', 'uploads/UqE5v6depositphotos_5497791-stock-photo-music-notes.jpg', 1, 1, 1, 'App\\Model\\Post', NULL),
(15, '2021-10-15 07:33:44', '2021-10-15 07:33:44', 'uploads/HNjfiUdepositphotos_5497791-stock-photo-music-notes.jpg', 1, 1, 1, 'App\\Model\\Post', NULL),
(23, '2021-10-18 07:57:16', '2021-10-18 07:57:16', 'uploads/rtNaEQJ2Glбумажный самолетик .jpeg', 1, 1, 1, 'App\\Model\\Post', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `infos`
--

CREATE TABLE `infos` (
  `id` int(10) UNSIGNED NOT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` text COLLATE utf8mb4_unicode_ci,
  `phone` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'img/demo/avatars/avatar-f.png',
  `user_id` int(11) NOT NULL,
  `infosable_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `infos`
--

INSERT INTO `infos` (`id`, `occupation`, `location`, `position`, `phone`, `status`, `avatar`, `user_id`, `infosable_id`, `created_at`, `updated_at`) VALUES
(1, 'Moscow', 'Moscow', 'manager', '9998877', 2, 'uploads/e3DRSQpxTDtype2.png', 1, 1, NULL, '2021-09-24 03:45:20'),
(2, 'Minsk', 'Minsk', 'provider', '8887766', 2, 'uploads/jfnbranTtja4Bbh3SoHvvdD0cKyk9QCMJUjNz9tx.png', 2, 2, NULL, '2021-09-24 03:46:07'),
(3, 'Rome', 'Rome', 'ingener', '7776655', 2, '', 3, 3, '2021-09-25 03:01:14', '2021-09-25 03:01:14'),
(4, 'London', 'London', 'manager', '6665544', 2, 'img/demo/avatars/avatar-f.png', 4, 4, '2021-09-27 02:27:28', '2021-09-27 02:27:28'),
(5, 'Paris', 'Paris', 'provider', '5554433', 1, 'img/demo/avatars/avatar-f.png', 5, 5, '2021-09-27 14:21:56', '2021-09-27 14:21:56'),
(6, 'Rabot', 'Locati', NULL, '99999999', 0, 'uploads/бумажный самолетик .jpeg', 6, 6, '2021-10-07 07:55:59', '2021-10-07 07:55:59'),
(159, 'Control', 'Bnbnbnbn', NULL, '987765434', 1, 'uploads/kuksh_1200.webp', 201, 201, '2021-10-10 11:02:12', '2021-10-10 11:02:12'),
(162, '', '', NULL, '', 0, 'uploads/20201117_170438 s20 test 1.jpg', 204, 204, '2021-10-11 13:36:56', '2021-10-11 13:36:56'),
(165, 'control4', 'control4', NULL, '98765432', 0, 'img/demo/avatars/avatar-f.png', 207, 207, '2021-10-12 05:33:33', '2021-10-12 05:33:33'),
(169, '', '', NULL, '', 0, 'img/demo/avatars/avatar-f.png', 0, 0, '2021-10-16 07:29:10', '2021-10-16 07:29:10'),
(170, 'bnbnbn', 'bnbnbnbnb', NULL, '989898989', 0, 'uploads/nk5OpBZIpptype2.png', 211, 211, '2021-10-19 08:17:48', '2021-10-19 08:17:48'),
(171, 'nbnbnbnbn', 'ghghghhghg', NULL, '8878787878', 0, 'uploads/8XooooC5ehtype2.png', 212, 212, '2021-10-19 08:22:18', '2021-10-19 08:22:18');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `messageable_id` int(11) NOT NULL,
  `messageable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `created_at`, `updated_at`, `message`, `user_id`, `chat_id`, `messageable_id`, `messageable_type`, `info_id`) VALUES
(4, '2021-09-26 14:55:36', '2021-09-26 14:55:36', 'bnbbnbnb', 1, 9, 9, 'App\\Models\\Chat', 56),
(5, '2021-09-26 14:55:42', '2021-09-26 14:55:42', 'bnbnbnbnbn', 1, 9, 9, 'App\\Models\\Chat', 56),
(6, '2021-09-26 14:56:17', '2021-09-26 14:56:17', 'hjhjhjhjhjh', 2, 9, 9, 'App\\Models\\Chat', 56),
(7, '2021-09-26 14:57:07', '2021-09-26 14:57:07', 'bnbnbn', 2, 9, 9, 'App\\Models\\Chat', 56),
(8, '2021-09-26 15:17:12', '2021-09-26 15:17:12', 'nbbnbnnbnbn bnbnbnbn hhhghghhghg ytytyyytyty hhhghhghhhggh fggfggggfggggf 5656655565656 dffdffffdfdfff hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 2, 9, 9, 'App\\Models\\Chat', 56),
(9, '2021-09-26 15:19:44', '2021-09-26 15:19:44', 'bbbbnbbnnbbnbnnnnnnnnb bnbbnnbnnnnbnbn bnnnnnnnnbnnnbnbnbnbnbnbnbnn bnbnnbnbnbnnbnbnbnnnnbnbnbnnb bnbnbnbnbnnbnbnbnnbnn nnnbnbnbnbnbnnbnbnbnbnbnbn bnbnbnbnbnbnbnbnbnbnbnbnbnbnb', 2, 9, 9, 'App\\Models\\Chat', 56),
(10, '2021-09-26 15:21:50', '2021-09-26 15:21:50', 'bbbbnbbnnbbnbnnnnnnnnb bnbbnnbnnnnbnbn bnnnnnnnnbnnnbnbnbnbnbnbnbnn bnbnnbnbnbnnbnbnbnnnnbnbnbnnb bnbnbnbnbnnbnbnbnnbnn nnnbnbnbnbnbn bbnbnbnbnbn nbnbnnbnb nnbnbnbnnb', 2, 9, 9, 'App\\Models\\Chat', 56);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2014_10_12_000000_create_users_table', 1),
(14, '2014_10_12_100000_create_password_resets_table', 1),
(15, '2019_08_19_000000_create_failed_jobs_table', 1),
(16, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(17, '2021_08_28_161335_create_posts_table', 1),
(18, '2021_08_28_161437_create_infos_table', 1),
(19, '2021_08_31_063832_create_socials_table', 1),
(20, '2021_09_09_085753_create_chats_table', 1),
(21, '2021_09_09_085818_create_messages_table', 1),
(22, '2021_09_15_135652_create_userlists_table', 1),
(23, '2021_09_15_135814_create_images_table', 1),
(24, '2021_09_15_150503_create_comments_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_post` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_post` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'img/demo/avatars/avatar-f.png',
  `title_post` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `favorites` int(11) DEFAULT NULL,
  `postable_id` int(11) NOT NULL,
  `banned` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `info_id` int(11) NOT NULL,
  `social_id` int(11) NOT NULL,
  `c` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `search_post` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `created_at`, `updated_at`, `user_id`, `text`, `name_post`, `avatar_post`, `title_post`, `favorites`, `postable_id`, `banned`, `post_id`, `info_id`, `social_id`, `c`, `search_post`) VALUES
(1, '2021-09-24 03:01:53', '2021-09-26 03:06:52', 1, 'Vbbbn fhfhhfhfh post1', 'Post1', 'uploads/F9vLEf21Wzpaper-airplane-5.png', 'Post 1 ', 0, 1, 0, 1, 1, 1, 'c_1', 'один пост номер 1'),
(2, '2021-09-24 03:03:44', '2021-09-24 03:03:44', 1, 'Содержание поста номер два', 'Пост номер 2', 'uploads/8SLC2bfhJrLA9lyybOczKAWTspgqIMAKz4tUpQQA.jpg', 'Заголовок поста номер 2', 1, 1, 1, 2, 1, 1, 'c_2', 'два пост номер 2'),
(3, '2021-09-24 03:08:26', '2021-09-24 03:08:26', 1, 'Содержание поста номер три', 'Пост номер 3', 'uploads/bfJlAoIrNNeHWzQqODYwoXEHlUFUNctmwlrn1AWn.jpg', 'Заголовок поста номер 3', 0, 1, NULL, 3, 1, 1, 'c_3', 'пост номер 3'),
(4, '2021-09-24 03:10:06', '2021-09-24 03:10:06', 1, 'Содержание поста номер четыре', 'Пост номер 4', 'uploads/7JBsDy7REAuJLS2dFoYu4zANioH7Z6HpuAyABEeH.jpg', 'Заголовок поста номер 4', 1, 1, NULL, 4, 1, 1, 'c_4', 'пост номер 4'),
(5, '2021-09-26 04:54:15', '2021-09-26 04:54:15', 2, 'Содержание поста номер 5', 'Пост номер 5', 'uploads/kuksh_1200.webp', 'Заголовок поста номер 5', 0, 2, 0, 5, 2, 2, 'c_4', 'пост номер 5'),
(6, NULL, NULL, 1, 'bnb', 'post6', 'img/demo/avatars/avatar-f.png', 'bnb', NULL, 0, 0, NULL, 1, 1, '0', 'post6'),
(7, '2021-10-16 08:40:43', '2021-10-16 08:40:43', 1, 'bnb', 'post7', 'img/demo/avatars/avatar-f.png', 'bnb', NULL, 7, 0, 7, 1, 1, 'c_7', 'post7'),
(8, '2021-10-16 08:46:19', '2021-10-16 08:46:19', 1, 'bnb', 'post8', 'img/demo/avatars/avatar-f.png', 'bnb', NULL, 8, 0, 8, 1, 1, 'c_8', 'post8');

-- --------------------------------------------------------

--
-- Структура таблицы `socials`
--

CREATE TABLE `socials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `telegram` text COLLATE utf8mb4_unicode_ci,
  `vk` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `socials`
--

INSERT INTO `socials` (`id`, `telegram`, `vk`, `instagram`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'otto', 'otto', 'otto', 1, '2021-09-25 07:58:54', '2021-09-25 07:59:27'),
(2, 'viky', 'viky', 'viky', 2, '2021-09-25 07:58:54', '2021-09-25 07:59:27'),
(3, 'vladi', 'vladi', 'vladi', 3, '2021-09-27 17:21:56', '2021-09-27 17:21:56'),
(4, 'Morzav', 'Morzav', 'Morzav', 4, '2021-09-25 06:01:14', '2021-09-25 06:01:14'),
(5, 'sandra', 'sandra', 'sandra', 5, '2021-09-27 05:27:28', '2021-09-27 05:27:28'),
(6, 'Tele', 'Vk', 'Inst', 6, '2021-10-07 10:55:59', '2021-10-07 10:55:59'),
(149, '', 'control', '', 201, '2021-10-10 14:02:12', '2021-10-10 14:02:12'),
(152, '', '', '', 204, '2021-10-11 16:36:56', '2021-10-11 16:36:56'),
(155, '', '', '', 207, '2021-10-12 08:33:33', '2021-10-12 08:33:33'),
(159, '', '', '', 0, '2021-10-16 10:29:10', '2021-10-16 10:29:10'),
(160, '', '', '', 211, '2021-10-19 11:17:48', '2021-10-19 11:17:48'),
(161, 'cvcvcvc', 'vbvbvbv', 'cvcvcvcv', 212, '2021-10-19 11:22:18', '2021-10-19 11:22:18');

-- --------------------------------------------------------

--
-- Структура таблицы `userlists`
--

CREATE TABLE `userlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `info_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `userlistable_id` int(11) DEFAULT NULL,
  `userlistable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_chat` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favorites` int(11) DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `userlists`
--

INSERT INTO `userlists` (`id`, `created_at`, `updated_at`, `info_id`, `user_id`, `chat_id`, `userlistable_id`, `userlistable_type`, `status_chat`, `name`, `favorites`, `role`) VALUES
(19, NULL, '2021-09-25 04:16:09', 56, 2, 9, 9, 'App\\Models\\Chat', NULL, 'Чат крутого', NULL, 'participant'),
(20, '2021-09-25 03:54:23', '2021-09-25 03:54:23', 56, 56, 9, 9, 'App\\Models\\Chat', NULL, 'Чат крутого', NULL, 'author'),
(21, NULL, '2021-09-28 01:54:10', 1, 1, 1, 1, 'App\\Models\\Chat', NULL, 'Наш чат  Номер  1', NULL, 'moderator'),
(22, NULL, NULL, 56, 56, 1, 1, 'App\\Models\\Chat', NULL, 'Наш чат  Номер  1', NULL, 'participant');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `info_id` int(11) DEFAULT NULL,
  `social_id` int(11) DEFAULT NULL,
  `c` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `search` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `admin`, `remember_token`, `created_at`, `updated_at`, `info_id`, `social_id`, `c`, `search`) VALUES
(1, 'Otto222', 'otto@otto', '2021-09-24 11:42:02', '$2y$10$Xcx12RjGaiHFotbNgpklTu0b.7x0q.gfM7D7Rsd1BS0AE4TQaohR6', 1, NULL, NULL, NULL, 1, 1, 'c_1', 'otto'),
(2, 'Viky', 'viky@viky', '2021-09-24 12:57:28', '$2y$10$1dDzilC2Mr2P1UVcgna1Ne1tXOgCQE9H2mse4SpDA87/If4P4TOcC', 0, NULL, NULL, '2021-09-24 12:57:28', 2, 2, 'c_2', 'viky'),
(3, 'Morzav', 'morzav@morzav', '2021-09-25 03:02:11', '$2y$10$SBjrYDTvvhsRMp3Wf9YJOOirYk1JpGCN1ygUx4EWZWyIdkbWNiv2m', 1, NULL, '2021-09-25 03:01:14', '2021-09-25 03:02:11', 3, 3, 'c_3', 'morzav'),
(4, 'Sandra', 'sandra@sandra', '2021-09-27 02:28:52', '$2y$10$Wza07TEqTb2kDYth.FIlrOGmK533nU8frbMeLUo/icF59IiobmZV6', NULL, NULL, '2021-09-27 02:27:28', '2021-09-27 02:28:52', 4, 4, 'c_4', 'sandra'),
(5, 'Vladi', 'vladi@vladi', '2021-09-27 14:22:54', '$2y$10$GuW2Wo/jVbjmu0mrAb1bPOQKtLNaen4aXrZlDGXz/uimRNXcPCcky', NULL, NULL, '2021-09-27 14:21:56', '2021-09-27 14:22:54', 5, 5, 'c_5', 'vladi'),
(6, 'User22', 'myemai@mail.ru', NULL, '$2y$10$YFrURM6MzzyIoxaPlqwAWe7C/z276e289yhZuVEQvPRMxawR/ZB9.', 0, NULL, '2021-10-07 07:55:59', '2021-10-07 07:55:59', 6, 6, 'c_6', 'user22'),
(201, 'Control', 'control@mail.ru', NULL, '$2y$10$V3IOJzaNDeTJOxX2mN/JwO2iExjcLUUZSAKAzfVx3OQTRKh1cc3zW', 0, NULL, '2021-10-10 11:02:12', '2021-10-10 11:02:12', 159, 149, NULL, NULL),
(204, 'control2', 'control2@mail.ru', NULL, '$2y$10$4Np3FHVzKw.Cw5cCzDN3RelDy9QBaU9.Kh03WyrP1vi.JovPPstju', 1, NULL, '2021-10-11 13:36:56', '2021-10-11 13:36:56', 162, 152, NULL, NULL),
(207, 'coontrol4', 'control4@mail.ru', NULL, '$2y$10$Uw5sG0EbbjfKr2722h2yu.RiP6BamsChBcWKuSwO2OHEngRO/j8Fi', NULL, NULL, '2021-10-12 05:33:33', '2021-10-12 05:33:33', 165, 155, NULL, NULL),
(211, 'yjdjt222bzvz', 'bnbnbn@mail.ru', NULL, '$2y$10$kJnR4ox..AnnZMTrsHcqb.UCi9nLDSwj0QjBoNXh7QqM42O.xvoVe', 0, NULL, '2021-10-19 08:17:48', '2021-10-19 08:17:48', 170, 160, NULL, NULL),
(212, 'nbnbb43434', 'nnbnbnbnbnnb@mail.ru', NULL, '$2y$10$JQB3xbgFd7O1PkkJbsLUo.42Yayq2FpAH0a5m7XZ9gd39rIDu5F7K', 0, NULL, '2021-10-19 08:22:18', '2021-10-19 08:22:18', 171, 161, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `infos`
--
ALTER TABLE `infos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `userlists`
--
ALTER TABLE `userlists`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `infos`
--
ALTER TABLE `infos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `socials`
--
ALTER TABLE `socials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT для таблицы `userlists`
--
ALTER TABLE `userlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

