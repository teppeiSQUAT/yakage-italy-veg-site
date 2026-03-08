-- Smash Balloon Instagram Feed: 不足テーブル作成（SBI_Db::create_tables 相当）
-- 実行後は削除してよい

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS wp_sbi_feeds (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  feed_name text NOT NULL,
  feed_title text NOT NULL,
  settings longtext NOT NULL,
  author bigint(20) unsigned NOT NULL DEFAULT 1,
  status varchar(255) NOT NULL DEFAULT '',
  last_modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY author (author)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS wp_sbi_feed_caches (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  feed_id varchar(255) NOT NULL DEFAULT '',
  cache_key varchar(255) NOT NULL DEFAULT '',
  cache_value longtext NOT NULL,
  cron_update varchar(20) NOT NULL DEFAULT 'yes',
  last_updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY feed_id (feed_id(191))
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS wp_sbi_sources (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  account_id varchar(255) NOT NULL DEFAULT '',
  account_type varchar(255) NOT NULL DEFAULT '',
  privilege varchar(255) NOT NULL DEFAULT '',
  access_token varchar(1000) NOT NULL DEFAULT '',
  username varchar(255) NOT NULL DEFAULT '',
  info text NOT NULL,
  error text NOT NULL,
  expires datetime NOT NULL DEFAULT '2037-12-30 00:00:00',
  last_updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  author bigint(20) unsigned NOT NULL DEFAULT 1,
  connect_type varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  KEY account_type (account_type(191)),
  KEY author (author)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
