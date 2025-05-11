-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2025-05-11 12:34:38
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `grocery`
--

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 转存表中的数据 `cart`
--

INSERT INTO `cart` (`id`, `uid`, `pid`, `quantity`) VALUES
(11, 2, 12, 0),
(12, 0, 46, 0),
(15, 43, 47, 0),
(19, 42, 54, 0),
(20, 42, 53, 0),
(21, 0, 47, 0),
(22, 0, 99, 0),
(23, 46, 81, 0),
(24, 0, 82, 1),
(25, 0, 88, 1),
(34, 47, 94, 1),
(35, 50, 98, 1),
(36, 50, 96, 1);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `oplace` text NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `dstatus` varchar(10) NOT NULL DEFAULT 'no',
  `odate` date NOT NULL,
  `ddate` date NOT NULL,
  `delivery` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `uid`, `pid`, `quantity`, `oplace`, `mobile`, `dstatus`, `odate`, `ddate`, `delivery`) VALUES
(90, 47, 97, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +100php'),
(91, 47, 97, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +100php'),
(92, 47, 93, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +100php'),
(93, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(94, 47, 87, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(95, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(96, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(97, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(98, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(99, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(100, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(101, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(102, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(103, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(104, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(105, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(106, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(107, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(108, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(109, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(110, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(111, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(112, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(113, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(114, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(115, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(116, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(117, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(118, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(119, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(120, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(121, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(122, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(123, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(124, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(125, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(126, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(127, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(128, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(129, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(130, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(131, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(132, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(133, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(134, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(135, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(136, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(137, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(138, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(139, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(140, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(141, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(142, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(143, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(144, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(145, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(146, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(147, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(148, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(149, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(150, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(151, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(152, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(153, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(154, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(155, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(156, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(157, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(158, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(159, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(160, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(161, 47, 99, 1, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(162, 47, 87, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(163, 47, 96, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(164, 47, 83, 2, 'Um CGB', '123456', 'no', '2025-05-10', '0000-00-00', 'Express Delivery +$100'),
(165, 47, 94, 1, 'Um CGB', '123456', 'no', '2025-05-11', '0000-00-00', 'Standard Delivery'),
(166, 47, 94, 1, 'Um CGB', '123456', 'no', '2025-05-11', '0000-00-00', 'Standard Delivery'),
(167, 47, 94, 2, 'Um CGB', '123456', 'no', '2025-05-11', '0000-00-00', 'Express Delivery +$100'),
(168, 47, 94, 3, 'Um CGB', '123456', 'no', '2025-05-11', '0000-00-00', 'Express Delivery +$100'),
(169, 50, 98, 1, 'UM Cao', '178 1529 6450', 'no', '2025-05-11', '0000-00-00', 'Express Delivery +$100'),
(170, 50, 96, 1, 'UM Cao', '178 1529 6450', 'no', '2025-05-11', '0000-00-00', 'Express Delivery +$100'),
(171, 50, 98, 1, 'UM Cao', '178 1529 6450', 'no', '2025-05-11', '0000-00-00', 'Express Delivery +$100'),
(172, 50, 96, 1, 'UM Cao', '178 1529 6450', 'no', '2025-05-11', '0000-00-00', 'Express Delivery +$100');

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `pName` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `piece` int(11) NOT NULL,
  `description` text NOT NULL,
  `available` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `item` varchar(100) NOT NULL,
  `pCode` varchar(20) NOT NULL,
  `picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`id`, `pName`, `price`, `piece`, `description`, `available`, `category`, `type`, `item`, `pCode`, `picture`) VALUES
(77, 'Mega Sardines 155g set of 8pcs', 172, 8, 'Mega in tomato sauce w chili', 100, '', '', 'noodles', 'aa', '1539174914.png'),
(78, 'Argentina corned beef 260g set of  6pcs', 450, 6, 'Package foods from century', 100, '', '', 'noodles', 'bb', '1539176648.jpg'),
(79, 'Argentina Meatloaf 250g set of 6pcs', 350, 6, '250g set of 6', 100, '', '', 'noodles', 'cc', '1539176787.jpg'),
(80, 'Argentina Fiesta Sausage 175g 5pcs', 155, 5, '175g set of 5pcs', 100, '', '', 'noodles', 'dd', '1539176959.jpg'),
(81, 'Pork Maling luncheon 340g (2pcs)', 258, 2, '340g (2pcs)', 100, '', '', 'noodles', 'ee', '1539177153.jpg'),
(82, 'blueyellow-ligo-gata-style-sardines-155g-4pcs', 110, 4, '155g (set of 4pcs)', 100, '', '', 'noodles', 'ff', '1539177279.jpg'),
(83, 'Magic Sarap 4packs', 185, 4, '8g set of 4', 100, '', '', 'seasoning', 'qq', '1539232659.PNG'),
(84, 'Coke Mismo 300ml set of 24 pcs', 290, 24, '300 ml 24pcs', 100, '', '', 'drink', 'qwe', '1539403731.PNG'),
(85, 'Sprite Mismo 250ml 24pcs', 300, 24, '250ml 24pcs', 100, '', '', 'drink', 'qwer', '1539403840.PNG'),
(86, 'Kopiko Blanca Cream 30g set of 2', 160, 2, '30g set of 2packs', 100, '', '', 'drink', 'qwrt', '1539404335.jpg'),
(87, 'Milo 22g set of 2packs', 160, 24, '22g 2packs/24pcs', 100, '', '', 'drink', 'ryrty', '1539404929.jpg'),
(88, 'Coke 1.5L  5bottles', 290, 5, 'coke 1.5L 5B', 100, '', '', 'drink', 'mnb', '1539405194.jpg'),
(90, 'Wilkins 330ml    30bottles', 238, 30, '330ml /   30 bottles', 100, '', '', 'drink', 'ads', '1539405937.jpg'),
(91, 'Graham Crackers 200g 4set', 165, 4, '200g/4sets', 100, '', 'other', 'snack', 'asdaa', '1539447093.PNG'),
(92, 'MagicCreamsChoco 308g 5set', 320, 5, '308g/set of 5/11 packs', 100, '', 'other', 'snack', 'adf', '1539447263.PNG'),
(93, 'Nissin Butter 10gx12 3sets', 100, 3, '10g /     12packs      /3sets', 100, '', '', 'snack', 'gfhjgj', '1539447833.PNG'),
(94, 'Otap Bacolod sp 200g', 180, 1, '200g', 100, '', '', 'snack', 'lkfjd', '1539447955.PNG'),
(95, 'Presto Creams PeanutB 10packs/3sets', 190, 3, '10packs/3sets', 100, '', '', 'snack', 'lk', '1539448126.PNG'),
(96, 'gummy colas  4sets', 100, 4, 'gummy 4s', 100, '', '', 'sweet', 'po', '1539448238.PNG'),
(97, 'kitkat 4s', 110, 4, 'kitkat bars', 100, '', '', 'sweet', 'n', '1539448317.PNG'),
(98, 'Mr. mais sweet corn candy 106g 4s', 100, 4, '106g /4sets', 100, '', '', 'sweet', 'b', '1539448500.PNG'),
(99, 'Palmolive silky  12ml+conditioner 10ml/24s', 200, 24, 'shampoo12ml+conditioner10ml', 100, '', 'other', 'shampoo', 'r', '1539448680.PNG'),
(100, 'Palmolive shampoo aroma-vitality 13.5ml 48s', 270, 48, '13.5ml/48sets', 100, '', '', 'shampoo', 'v', '1539448775.PNG'),
(101, 'Palmolive shampoo antiDandruff 13.5ml 48s', 270, 100, '13.5ml/48sets', 100, '', '', 'shampoo', 'e', '1539448866.PNG'),
(102, 'joy dishwashing liquid 255ml 3sets', 400, 3, '255ml 3sets', 100, '', '', 'soap', 'a', '1539660576.PNG'),
(103, 'dove bar soap 3sets 100g', 220, 3, '3sets 100g', 100, '', '', 'soap', 'nl', '1539660980.PNG'),
(104, 'Bioderm soap 7sets 135g', 300, 7, '7sets 135g', 100, '', '', 'soap', 'ewr', '1539661097.PNG'),
(105, 'toilet paper', 100, 10, 'High-quality toilet paper', 100, '', '', 'hygiene', 'hyg1', '1539448866.png'),
(106, 'Cotton swab', 50, 100, 'Daily essential cotton swabs', 100, '', '', 'hygiene', 'hyg2', '1539448867.png'),
(107, 'Dental floss', 35, 1, 'Clean the gaps between teeth', 100, '', '', 'hygiene', 'hyg3', '1539448868.png');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(120) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirmCode` varchar(10) NOT NULL,
  `activation` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `mobile`, `address`, `password`, `confirmCode`, `activation`) VALUES
(44, 'Jo', 'Castaneda', 'joanmcastaneda@gmail.com', '09368790811', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '69a9dc1da83c4c3e58a5ecb7c9de78fa', '0', 'yes'),
(45, 'KO', 'KOOOO', 'ko@w.com', '123', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '25d55ad283aa400af464c76d713c07ad', '289477', 'no'),
(46, 'Czyke', 'Correa', 'czyke@yahoo.com', '09368790811', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '7c09a95be9c2e9612c2bda758fc17e42', '0', 'yes'),
(47, 'Zhihan', 'Yang', 'dc12799@umac.mo', '123456', 'Um CGB', 'e807f1fcf82d132f9bb018ca6738a19f', '0', 'yes'),
(48, 'Zhy', 'Yang', '1234567@gmail.com', '1234566', 'Um TSG', '25d55ad283aa400af464c76d713c07ad', '113793', 'no'),
(49, 'Zhyy', 'Yang', '12345678@gmail.com', '123456777', 'Um  TSG', '827ccb0eea8a706c4c34a16891f84e7b', '0', 'yes'),
(50, 'Hector', 'Yang', 'yangeleanore1@gmail.com', '178 1529 6450', 'UM Cao', '25f9e794323b453885f5181f1b624d0b', '0', 'yes');

--
-- 转储表的索引
--

--
-- 表的索引 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- 使用表AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
