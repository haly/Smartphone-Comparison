
--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) DEFAULT NULL,
  `pictureURL` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `productAttr`
--

DROP TABLE IF EXISTS `productAttr`;

CREATE TABLE `productAttr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prodFK` int(11) DEFAULT NULL,
  `Name` varchar(80) NOT NULL,
  `value` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pFK` (`prodFK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

