/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : qmsystem

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-08-27 05:10:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admins`
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verification_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_email_verified` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `loginCount` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'Admin', 'admin@gmail.com', '2020-08-26 17:11:55', '', 'yes', '$2y$10$Hxud.f0X/N3xed6EugIEk.c2X9R5Mff7B.Q4hErcH7.ak7zrlzsli', null, '2020-08-27 01:31:38', '7', '2020-08-26 17:11:24', '2020-08-27 01:31:38');

-- ----------------------------
-- Table structure for `failed_jobs`
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------

-- ----------------------------
-- Table structure for `m_services`
-- ----------------------------
DROP TABLE IF EXISTS `m_services`;
CREATE TABLE `m_services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` bigint(20) unsigned NOT NULL,
  `estimatedtime` time DEFAULT NULL,
  `tokenstartfrom` int(5) DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validflg` bigint(20) unsigned NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_shop_id_foreign` (`shop_id`),
  CONSTRAINT `services_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `m_shops` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of m_services
-- ----------------------------
INSERT INTO `m_services` VALUES ('1', 'Repair Service', '1', '01:45:00', '1000', 'service2.jpg', 'Galaxyのラインナップから、あなたにピッタリのスマホがきっと見つかる！ 一歩先のテクノロジー. 最新のハイスペックスマホ. 高品質と革新的デザイン. 新しいスマホのカタチを. 毎日がもっと便利に楽しく.', '1', '2020-08-26 17:44:00', '2020-08-26 17:44:00');
INSERT INTO `m_services` VALUES ('2', 'Buying', '1', '03:01:00', '2000', 'buying.jpg', '「SHOWROOM-ライブ配信ならショールーム」のレビューをチェック、カスタマー評価を比較、スクリーンショットと詳細情報を確認することができます。iPhone、iPad、iPod touchでお楽しみください。', '1', '2020-08-26 17:48:19', '2020-08-26 17:49:07');
INSERT INTO `m_services` VALUES ('3', 'Lunch「昼食」', '2', '00:30:00', '3000', 'chuushoku2.jpg', '有名レストランの特別プラン多数！和食・日本料理のランチを予約するならオズモール。編集部が実際に足を運んで厳選した人気のグルメ・レストランを、口コミのランキングや予算、条件に合わせて検索できます。和食・日本料理のランチです', '1', '2020-08-26 18:04:44', '2020-08-26 18:05:39');
INSERT INTO `m_services` VALUES ('4', 'Dinner', '3', '01:30:00', '4000', 'dinner.jpg', 'オリンピックに向けて訪日旅行客も増え、欧米・アジア問わず外国の方と一緒に食事をする機会も多い今日この頃。旅行で訪れたお友達や出張のビジネスパートナーへ、日本でしか味わえない雰囲気などをたっぷり堪能してもらえるお店を紹介', '1', '2020-08-26 18:15:45', '2020-08-26 18:15:45');
INSERT INTO `m_services` VALUES ('5', 'Hair Styling', '4', '00:45:00', '5000', 'Hair Styling.jpeg', '日本一出世する理容室で髪を切ったら、島耕作も羨む出世街道がみえてきた. 瀧川丈太朗 2019年6月27日. 少子高齢化によって空前の売り手市場といわれている就職活動だが、ちょっと残念な研究結果が「産業能率大学 総合研究所」から発表', '1', '2020-08-26 18:24:38', '2020-08-26 18:24:38');
INSERT INTO `m_services` VALUES ('6', 'Hair Cut', '4', '00:30:00', '6000', 'Hair Cutting.jpg', '日本一出世する理容室で髪を切ったら、島耕作も羨む出世街道がみえてきた. 瀧川丈太朗 2019年6月27日. 少子高齢化によって空前の売り手市場といわれている就職活動だが、ちょっと残念な研究結果が「産業能率大学 総合研究所」から発表', '1', '2020-08-26 18:25:06', '2020-08-26 18:25:06');
INSERT INTO `m_services` VALUES ('7', 'Beard Trim', '4', '00:20:00', '7000', 's1.png', null, '0', '2020-08-26 19:03:56', '2020-08-26 19:04:08');

-- ----------------------------
-- Table structure for `m_shops`
-- ----------------------------
DROP TABLE IF EXISTS `m_shops`;
CREATE TABLE `m_shops` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validflg` bigint(20) unsigned NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shops_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of m_shops
-- ----------------------------
INSERT INTO `m_shops` VALUES ('1', 'mobile store', '10:30:00', '19:40:00', 'mobile store.jpg', '44,800円（税別）から。\r\n下取りを利用すると実質31,280円（税込）から1。\r\nオンラインで購入したSIMフリーモデルでも、今の電話番号と\r\n通信事業者のプランを引き継げます。条件が適用されます2。', '1', '2020-08-26 17:27:47', '2020-08-26 17:27:47');
INSERT INTO `m_shops` VALUES ('2', 'Restaurant', '09:00:00', '20:02:00', 'resutoran.jpg', '京都府で座敷のある日本料理・懐石・会席をお探しならヒトサラ。座敷でくつろぐご宴会、記念日や接待のご予約にオススメの飲食店をご紹介。', '1', '2020-08-26 18:02:38', '2020-08-26 18:02:38');
INSERT INTO `m_shops` VALUES ('3', 'Bar「居酒屋」', '07:15:00', '23:00:00', 'izakaya.jpeg', '居酒屋（いざかや）とは、酒類とそれに伴う料理を提供する飲食店で、日本式の飲み屋である。 バーやパブなどは洋風の店舗で洋酒を中心に提供しているのに対し、居酒屋は和風でビールやチューハイ・日本酒などを提供する店が多く、バーやパブに比べると料理の種類や量も多い。', '1', '2020-08-26 18:12:04', '2020-08-26 18:12:04');
INSERT INTO `m_shops` VALUES ('4', 'Saloon', '10:00:00', '20:30:00', 'saloon.jpg', '理容・理髪店（BARBER）の日本理容は、兵庫（神戸）大阪、尼崎から住之江区まで関西を中心に出店しているサロンです。創業から50年以上多くのお客様にご来店いただいているハイクオリティが人気の理容サロン。', '1', '2020-08-26 18:19:30', '2020-08-26 18:19:30');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `queues`
-- ----------------------------
DROP TABLE IF EXISTS `queues`;
CREATE TABLE `queues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queuedate` date DEFAULT NULL,
  `token_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicetime` time DEFAULT NULL,
  `customer` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_id` int(5) DEFAULT NULL,
  `shop_id` int(5) DEFAULT NULL,
  `service_status` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of queues
-- ----------------------------
INSERT INTO `queues` VALUES ('1', '2020-08-26', '1001', '01:45:00', 'User', 'user@gmail.com', '1', '1', '1', '2020-08-26 19:06:14', '2020-08-26 19:06:14');
INSERT INTO `queues` VALUES ('2', '2020-08-26', '3001', '00:30:00', 'User', 'user@gmail.com', '3', '2', '0', '2020-08-26 19:14:23', '2020-08-26 19:56:28');
INSERT INTO `queues` VALUES ('3', '2020-08-26', '4001', '01:30:00', 'User', 'user@gmail.com', '4', '3', '0', '2020-08-26 19:17:42', '2020-08-26 19:57:00');
INSERT INTO `queues` VALUES ('4', '2020-08-26', '5001', '00:45:00', 'User', 'user@gmail.com', '5', '4', '1', '2020-08-26 19:17:49', '2020-08-26 19:17:49');
INSERT INTO `queues` VALUES ('5', '2020-08-26', '6001', '00:30:00', 'User7', 'user7@gmail.com', '6', '4', '1', '2020-08-26 19:18:40', '2020-08-26 19:18:40');
INSERT INTO `queues` VALUES ('6', '2020-08-26', '3002', '00:30:00', 'User5', 'user5@gmail.com', '3', '2', '0', '2020-08-26 19:19:33', '2020-08-26 19:56:51');
INSERT INTO `queues` VALUES ('7', '2020-08-26', '4002', '01:30:00', 'User6', 'user6@gmail.com', '4', '3', '1', '2020-08-26 19:19:58', '2020-08-26 19:19:58');
INSERT INTO `queues` VALUES ('8', '2020-08-26', '6002', '00:30:00', 'User6', 'user6@gmail.com', '6', '4', '1', '2020-08-26 19:20:18', '2020-08-26 19:20:18');
INSERT INTO `queues` VALUES ('9', '2020-08-26', '2001', '03:01:00', 'User4', 'user4@gmail.com', '2', '1', '2', '2020-08-26 19:21:15', '2020-08-26 19:35:07');
INSERT INTO `queues` VALUES ('10', '2020-08-26', '2002', '03:01:00', 'User6', 'user6@gmail.com', '2', '1', '1', '2020-08-26 19:21:43', '2020-08-26 19:21:43');
INSERT INTO `queues` VALUES ('11', '2020-08-26', '3003', '00:30:00', 'User6', 'user6@gmail.com', '3', '2', '0', '2020-08-26 19:21:55', '2020-08-26 19:56:53');
INSERT INTO `queues` VALUES ('12', '2020-08-26', '6003', '00:30:00', 'User2', 'user2@gmail.com', '6', '4', '1', '2020-08-26 19:22:50', '2020-08-26 19:22:50');
INSERT INTO `queues` VALUES ('13', '2020-08-26', '5002', '00:45:00', 'User1', 'user1@gmail.com', '5', '4', '1', '2020-08-26 19:23:26', '2020-08-26 19:23:26');
INSERT INTO `queues` VALUES ('14', '2020-08-26', '5003', '00:45:00', 'User3', 'user3@gmail.com', '5', '4', '1', '2020-08-26 19:25:26', '2020-08-26 19:25:26');
INSERT INTO `queues` VALUES ('15', '2020-08-26', '3004', '00:30:00', 'User3', 'user3@gmail.com', '3', '2', '1', '2020-08-26 19:25:32', '2020-08-26 19:25:32');
INSERT INTO `queues` VALUES ('16', '2020-08-26', '1002', '01:45:00', 'User3', 'user3@gmail.com', '1', '1', '1', '2020-08-26 19:25:44', '2020-08-26 19:25:44');
INSERT INTO `queues` VALUES ('17', '2020-08-26', '4003', '01:30:00', 'User3', 'user3@gmail.com', '4', '3', '1', '2020-08-26 19:25:50', '2020-08-26 19:25:50');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `verification_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_email_verified` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `loginCount` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'User', 'user@gmail.com', '2020-08-27 04:14:09', '', 'yes', '$2y$10$NcCeLFN2Mwebo4JNTsFpT.rB4QjJ/pVJVQbugMT7iYXGJc2FLL0sS', null, '2020-08-27 00:44:09', '3', '2020-08-26 18:29:53', '2020-08-27 00:44:09');
INSERT INTO `users` VALUES ('2', 'User1', 'user1@gmail.com', '2020-08-27 04:23:17', null, 'yes', '$2y$10$NcCeLFN2Mwebo4JNTsFpT.rB4QjJ/pVJVQbugMT7iYXGJc2FLL0sS', null, '2020-08-27 00:53:17', '1', '2020-08-26 18:29:53', '2020-08-27 00:53:17');
INSERT INTO `users` VALUES ('3', 'User2', 'user2@gmail.com', '2020-08-27 04:22:38', null, 'yes', '$2y$10$NcCeLFN2Mwebo4JNTsFpT.rB4QjJ/pVJVQbugMT7iYXGJc2FLL0sS', null, '2020-08-27 00:52:38', '1', '2020-08-26 18:29:53', '2020-08-27 00:52:38');
INSERT INTO `users` VALUES ('4', 'User3', 'user3@gmail.com', '2020-08-27 04:25:18', null, 'yes', '$2y$10$NcCeLFN2Mwebo4JNTsFpT.rB4QjJ/pVJVQbugMT7iYXGJc2FLL0sS', null, '2020-08-27 00:55:18', '1', '2020-08-26 18:29:53', '2020-08-27 00:55:18');
INSERT INTO `users` VALUES ('5', 'User4', 'user4@gmail.com', '2020-08-27 04:33:50', null, 'yes', '$2y$10$NcCeLFN2Mwebo4JNTsFpT.rB4QjJ/pVJVQbugMT7iYXGJc2FLL0sS', null, '2020-08-27 01:03:50', '2', '2020-08-26 18:29:53', '2020-08-27 01:03:50');
INSERT INTO `users` VALUES ('6', 'User5', 'user5@gmail.com', '2020-08-27 04:19:21', null, 'yes', '$2y$10$NcCeLFN2Mwebo4JNTsFpT.rB4QjJ/pVJVQbugMT7iYXGJc2FLL0sS', null, '2020-08-27 00:49:21', '1', '2020-08-26 18:29:53', '2020-08-27 00:49:21');
INSERT INTO `users` VALUES ('7', 'User6', 'user6@gmail.com', '2020-08-27 04:21:33', null, 'yes', '$2y$10$NcCeLFN2Mwebo4JNTsFpT.rB4QjJ/pVJVQbugMT7iYXGJc2FLL0sS', null, '2020-08-27 00:51:33', '2', '2020-08-26 18:29:53', '2020-08-27 00:51:33');
INSERT INTO `users` VALUES ('8', 'User7', 'user7@gmail.com', '2020-08-27 04:30:27', null, 'yes', '$2y$10$NcCeLFN2Mwebo4JNTsFpT.rB4QjJ/pVJVQbugMT7iYXGJc2FLL0sS', null, '2020-08-27 01:00:27', '2', '2020-08-26 18:29:53', '2020-08-27 01:00:27');
