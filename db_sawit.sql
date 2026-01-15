-- =====================================================
-- Database: db_sawit
-- Manajemen Perkebunan Kelapa Sawit
-- =====================================================

CREATE DATABASE IF NOT EXISTS `db_sawit`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `db_sawit`;

-- =====================================================
-- Tabel: users
-- =====================================================
CREATE TABLE `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'mandor') NOT NULL DEFAULT 'mandor',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_users_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Tabel: karyawan
-- =====================================================
CREATE TABLE `karyawan` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(100) NOT NULL,
    `nik` VARCHAR(20) NOT NULL,
    `jabatan` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_karyawan_nik` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Tabel: blok_lahan
-- =====================================================
CREATE TABLE `blok_lahan` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama_blok` VARCHAR(50) NOT NULL,
    `luas_hektar` DECIMAL(10,2) NOT NULL,
    `tahun_tanam` YEAR NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_blok_nama` (`nama_blok`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Tabel: hasil_panen
-- =====================================================
CREATE TABLE `hasil_panen` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tanggal` DATE NOT NULL,
    `blok_id` INT UNSIGNED NOT NULL,
    `karyawan_id` INT UNSIGNED NOT NULL,
    `berat_kg` DECIMAL(10,2) NOT NULL,
    `jumlah_tandan` INT UNSIGNED NOT NULL,
    `catatan` TEXT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_hasil_panen_tanggal` (`tanggal`),
    INDEX `idx_hasil_panen_blok` (`blok_id`),
    INDEX `idx_hasil_panen_karyawan` (`karyawan_id`),
    CONSTRAINT `fk_hasil_panen_blok` 
        FOREIGN KEY (`blok_id`) 
        REFERENCES `blok_lahan` (`id`) 
        ON DELETE RESTRICT 
        ON UPDATE CASCADE,
    CONSTRAINT `fk_hasil_panen_karyawan` 
        FOREIGN KEY (`karyawan_id`) 
        REFERENCES `karyawan` (`id`) 
        ON DELETE RESTRICT 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
