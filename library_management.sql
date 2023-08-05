-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 04, 2023 lúc 05:19 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `library_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `book`
--
CREATE DATABASE library_management;
GO
USE library_management;
GO

CREATE TABLE `book` (
  `BookName` varchar(255) NOT NULL,
  `Author` varchar(100) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `PublicationYear` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `borrower` (
  `BorrowerName` varchar(255) DEFAULT NULL,
  `BookName` varchar(255) DEFAULT NULL,
  `BorrowDate` date DEFAULT NULL,
  `ReturnDate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `member` (
  `MemberName` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `book` (`BookName`, `Author`, `Category`, `PublicationYear`) VALUES
('Re:Zero ? Starting Life in Another World', 'Tappei Nagatsuki', 'Isekai, Adventure, Fantasy', 2012),
('Sword Art Online', 'Reki Kawahara', 'Isekai, Action, Adventure, Romance', 2009),
('Overlord', 'Kugane Maruyama', 'Isekai, Action, Adventure, Fantasy', 2010);

INSERT INTO `member` (`MemberName`, `Address`, `Email`, `Phone`) VALUES
('Nguyen Xuan Nam', 'Soc Son, Ha Noi', 'xuannam@edu.vn', '0123456789'),
('Nguyen Ha Trung Phong', 'Hai Duong, Viet Nam', 'trungphong@edu.vn', '0123456789');

INSERT INTO `borrower` (`BorrowerName`, `BookName`, `BorrowDate`, `ReturnDate`) VALUES
('Nguyen Xuan Nam', 'Sword Art Online', '2023-07-07', '2023-07-29'),
('Nguyen Ha Trung Phong', 'Re:Zero ? Starting Life in Another World', '2023-07-14', '2023-08-01');


-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `users` (`UserID`, `Username`, `Password`) VALUES
(1, 'admin', 'admin');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`BookName`);

--
-- Chỉ mục cho bảng `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`MemberName`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
