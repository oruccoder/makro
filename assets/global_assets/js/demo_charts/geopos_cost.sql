-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 18 Eyl 2021, 11:22:26
-- Sunucu sürümü: 10.2.39-MariaDB
-- PHP Sürümü: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `makro_mk20`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `geopos_cost`
--

CREATE TABLE `geopos_cost` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `name` varchar(222) DEFAULT NULL,
  `loc` int(11) DEFAULT 5,
  `unit` varchar(222) DEFAULT 'Ad',
  `status` int(11) DEFAULT 1 COMMENT '1=Açık 0= Kapalı'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `geopos_cost`
--

INSERT INTO `geopos_cost` (`id`, `parent_id`, `name`, `loc`, `unit`, `status`) VALUES
(300, 11, 'USTA İŞİ', 5, '9', 1),
(299, 29, 'JEOLOJİ AXTARIŞ', 5, '9', 1),
(298, 33, 'Tərəzi Xidməti', 5, '9', 1),
(297, 160, 'SERVİS XİDMETİ', 5, '9', 1),
(296, 29, 'TIR', 5, '9', 1),
(295, 29, 'AVTOKRAN GİDERLERİ', 5, '9', 1),
(294, 29, ' EVAKUATR GİDERLERİ', 5, '9', 1),
(293, 11, 'İSTİLİK SİSTEMLƏRİNİN QURAŞDIRILMASI', 5, '9', 1),
(292, 35, 'TİBBİ XİDMƏT', 5, '9', 1),
(291, 29, 'Smeta İşlemleri', 5, '9', 1),
(290, 29, 'SANTEXNIK IŞLƏRİ', 5, '9', 1),
(289, 29, 'Dəmir reşotkanın düzəldilməsi', 5, '9', 1),
(288, 4, 'ARAÇ TADİLAT GİDERİ', 5, '9', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `geopos_cost`
--
ALTER TABLE `geopos_cost`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `geopos_cost`
--
ALTER TABLE `geopos_cost`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
