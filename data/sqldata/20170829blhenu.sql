-- ecshop v2.x SQL Dump Program
-- http://localhost:8888
-- 
-- DATE : 2017-08-29 11:35:08
-- MYSQL SERVER VERSION : 5.6.35
-- PHP VERSION : 5.5.38
-- ECShop VERSION : v3.6.0
-- Vol : 1
DROP TABLE IF EXISTS `street_csv`;
CREATE TABLE `street_csv` (
  `csv_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `csv_title` varchar(255) NOT NULL,
  `csv_title_a` varchar(255) NOT NULL,
  `csv_upload` varchar(255) NOT NULL,
  `csv_click` int(10) NOT NULL,
  `csv_ip` text NOT NULL,
  PRIMARY KEY (`csv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `street_csv` ( `csv_id`, `csv_title`, `csv_title_a`, `csv_upload`, `csv_click`, `csv_ip` ) VALUES  ('831', '[09-16]淘宝数据包', '33333222', 'http://www.menskoko.com/data/csv/0_20130916avwiem.rar', '2', ',ther210');
INSERT INTO `street_csv` ( `csv_id`, `csv_title`, `csv_title_a`, `csv_upload`, `csv_click`, `csv_ip` ) VALUES  ('832', '[09-17]淘宝数据包', '33', 'http://www.menskoko.com/data/csv/0_20130917tnddlv.rar', '0', '');
INSERT INTO `street_csv` ( `csv_id`, `csv_title`, `csv_title_a`, `csv_upload`, `csv_click`, `csv_ip` ) VALUES  ('902', 'wewe', 'wwee', '0_20170829irywjo.zip', '0', '');
INSERT INTO `street_csv` ( `csv_id`, `csv_title`, `csv_title_a`, `csv_upload`, `csv_click`, `csv_ip` ) VALUES  ('900', 'we', 'sfewfewf', '0_20170829nfwuye.jpg', '0', '');
INSERT INTO `street_csv` ( `csv_id`, `csv_title`, `csv_title_a`, `csv_upload`, `csv_click`, `csv_ip` ) VALUES  ('901', '23232', '23223', '0_20170829zfjwab.zip', '1', '123');
INSERT INTO `street_csv` ( `csv_id`, `csv_title`, `csv_title_a`, `csv_upload`, `csv_click`, `csv_ip` ) VALUES  ('898', '233', '23232', '333', '0', '');
INSERT INTO `street_csv` ( `csv_id`, `csv_title`, `csv_title_a`, `csv_upload`, `csv_click`, `csv_ip` ) VALUES  ('899', 'sdfsdf', '', '', '0', '');
-- END ecshop v2.x SQL Dump Program 