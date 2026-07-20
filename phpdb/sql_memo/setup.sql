-- type the command below in the terminal to execute this script!
-- sudo mysql -u root -p < setup.sql

--  DELETE
-- mysql -u root -p -e "USE crud_app; DELETE FROM answers;"
-- 既存テーブルをリセット
-- mysql -u root -p -e "USE crud_app; TRUNCATE TABLE answers;"
-- 


-- 1. データベースを作成する
CREATE DATABASE crud_app DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. rootユーザーのパスワードを「password」に設定する（ローカル開発用）
ALTER USER 'root'@'localhost' IDENTIFIED BY 'password';

-- 3. 権限を反映させる
FLUSH PRIVILEGES;

-- 4. 作成したデータベースに切り替える
USE crud_app;


CREATE TABLE `answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` text,
  `questionId` text,
  `answer` text,
  `comment` text,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);