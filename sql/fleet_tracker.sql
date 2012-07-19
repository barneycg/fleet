--
-- Table structure for table `fleet_tracking`
--

DROP TABLE IF EXISTS `fleet_tracking`;
CREATE TABLE `fleet_tracking` (
  `fleet_id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `char_name` varchar(255) NOT NULL,
  `corp_name` varchar(255) DEFAULT NULL,
  `ship_type` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fleet_id`,`char_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `fleets`
--

DROP TABLE IF EXISTS `fleets`;
CREATE TABLE `fleets` (
  `fleet_id` int(11) NOT NULL AUTO_INCREMENT,
  `fleet_name` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`fleet_id`,`timestamp`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
