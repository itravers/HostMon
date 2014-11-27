-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2014 at 01:10 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hostmon`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_devices`
--

CREATE TABLE IF NOT EXISTS `active_devices` (
  `deviceId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `active_devices`
--

INSERT INTO `active_devices` (`deviceId`) VALUES
(2),
(3),
(5),
(6),
(7),
(9),
(10),
(12),
(38),
(39),
(40),
(41),
(42),
(44);

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
`id` int(11) NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL,
  `description` text NOT NULL,
  `timeStamp` text NOT NULL COMMENT 'Used by some settings'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`id`, `name`, `value`, `description`, `timeStamp`) VALUES
(1, 'debug', '0', 'Controls if the backend is in debug mode or not. In debug mode the console will display much more information.', ''),
(2, 'averageGoalTime', '60000', 'The time, in milliseconds, that we are aiming to have each record updated in. This will have an effect on the number of threads running in backend.', ''),
(3, 'startingThreads', '11', 'The number of threads the backend starts with. The thread number will change as the backend runs.', ''),
(4, 'maxThreads', '50', 'The maximum number of threads the backend will be able to run.', ''),
(5, 'threadRemovalCoefficient', '4', 'The Value that decides when threads are removed. The Lower the value the sooner an unneeded thread is removed.', ''),
(6, 'threadAddCoefficient', '10', 'The Value that decides when threads are added. The Higher the value the sooner a needed thread is added.', ''),
(7, 'runPerThreadCheck', '5', 'Every x amount of times a thread is run we check if we need to add or remove a thread.', ''),
(8, 'numPingRunsBeforeDBRecord', '20', 'The number of times we will ping before we make a call to the database.', ''),
(9, 'minuteRecordAgeLimit', '900000', 'The age each record in the minute table should get before being deleted. In Milliseconds.', ''),
(10, 'hourRecordAgeLimit', '14400000', 'The age each record in the hour table should get before being deleted. In Milliseconds.', ''),
(11, 'dayRecordAgeLimit', '345600000', 'The age each record in the day table should get before being deleted. In Milliseconds.', ''),
(12, 'weekRecordAgeLimit', '2419200000', 'The age each record in the week table should get before being deleted. In Milliseconds.', ''),
(13, 'newestPingMinutes', '300000', 'The amount of milliseconds we want to retrieve to average out new pings to add to hour table default was 5 minutes or 300000', ''),
(14, 'newestPingHours', '3600000', 'The amount of milliseconds we want to retrieve in order to average out pings to add to the day table default is 1 hour or 3600000 millis', ''),
(15, 'newestPingDays', '86400000', 'The amount of milliseconds we want to retrieve in order to average out pings to add to the day table default is 1 day or 86400000 millis', ''),
(16, 'newestPingWeeks', '604800000', 'The amount of milliseconds we want to retrieve in order to average out pings to add to the day table default is 1 week or 604800000 millis', ''),
(17, 'backendRunning', 'false', 'Used by the java backend to declare it is running. Used by php-ajax to show the user if it is running.', '1416962428'),
(18, 'installed', '1', 'Lets us know if we are already installed or not.', '');

-- --------------------------------------------------------

--
-- Table structure for table `day`
--

CREATE TABLE IF NOT EXISTS `day` (
`id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `time` text NOT NULL,
  `latency` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31888 ;

--
-- Dumping data for table `day`
--

INSERT INTO `day` (`id`, `ip`, `time`, `latency`) VALUES
(31734, 'two.com', '1416711750139', '0'),
(31735, 'news.com', '1416711748570', '592'),
(31736, 'gmail.com', '1416711747887', '611'),
(31737, 'hotmail.com', '1416711748722', '617'),
(31738, 'earlhart.com', '1416711747318', '671'),
(31739, 'digitalpath.net', '1416711747861', '651'),
(31740, 'chicosystems.com', '1416711745209', '630'),
(31741, 'bbc.co.uk', '1416716129337', '786'),
(31742, 'news.com', '1416715363841', '639'),
(31743, 'dishnetwork.com', '1416716133300', '632'),
(31744, 'speedtest.net', '1416716134644', '662'),
(31745, 'dishnetwork.net', '1416716133674', '595'),
(31746, 'dish.net', '1416716128879', '598'),
(31747, 'plesk.com', '1416715381717', '645'),
(31748, 'gmail.com', '1416715362342', '621'),
(31749, 'digitalpath.net', '1416715359302', '651'),
(31750, 'ufcrewards.com', '1416716136487', '579'),
(31751, 'two.com', '1416715362801', '0'),
(31752, 'facebook.com', '1416715373767', '721'),
(31753, 'reddit.com', '1416715376962', '667'),
(31754, 'directtv.com', '1416716131861', '675'),
(31755, 'twitter.com', '1416716140191', '695'),
(31756, 'hotmail.com', '1416715362501', '649'),
(31757, 'cmich.edu', '1416716138496', '651'),
(31758, 'earlhart.com', '1416715357820', '666'),
(31759, 'hbo.net', '1416716133858', '659'),
(31760, 'foxnews.com', '1416716132918', '670'),
(31761, 'evangel.edu', '1416716123502', '625'),
(31762, '7up.com', '1416715528407', '618'),
(31763, 'wargaming.net', '1416715533251', '621'),
(31764, 'chicosystems.com', '1416715359098', '637'),
(31765, 'he.net', '1416716135491', '677'),
(31766, 'news.com', '1416719270474', '695'),
(31767, 'dishnetwork.net', '1416719270719', '733'),
(31768, 'plesk.com', '1416719272274', '748'),
(31769, 'dish.net', '1416719271998', '652'),
(31770, 'digitalpath.net', '1416719264870', '717'),
(31771, 'ufcrewards.com', '1416719277260', '696'),
(31772, 'facebook.com', '1416719273751', '704'),
(31773, 'reddit.com', '1416719277913', '697'),
(31774, 'sparkfun.com', '1416719075557', '670'),
(31775, 'directtv.com', '1416719275345', '256'),
(31776, 'twitter.com', '1416719266641', '739'),
(31777, 'cmich.edu', '1416719271618', '710'),
(31778, 'evangel.edu', '1416719272498', '721'),
(31779, 'foxnews.com', '1416719278746', '679'),
(31780, 'youtube.com', '1416719081156', '684'),
(31781, '7up.com', '1416719269489', '674'),
(31782, 'chicosystems.com', '1416719266443', '690'),
(31783, 'bbc.co.uk', '1416719273548', '812'),
(31784, 'stanford.edu', '1416719079170', '656'),
(31785, 'dishnetwork.com', '1416719276113', '742'),
(31786, 'speedtest.net', '1416719274580', '699'),
(31787, 'imgur.com', '1416719076407', '711'),
(31788, 'gmail.com', '1416719275683', '691'),
(31789, 'comcast.net', '1416719081089', '719'),
(31790, 'two.com', '1416719275408', '0'),
(31791, '192.168.2.1', '1416717624302', '1'),
(31792, '184.21.246.255', '1416719080513', '1303'),
(31793, 'hotmail.com', '1416719271887', '723'),
(31794, 'hbo.net', '1416719273666', '691'),
(31795, 'earlhart.com', '1416719274757', '714'),
(31796, 'wargaming.net', '1416719278973', '701'),
(31797, 'he.net', '1416719272146', '715'),
(31798, 'news.com', '1416722605537', '766'),
(31799, 'plesk.com', '1416722599911', '792'),
(31800, 'dish.net', '1416722596726', '687'),
(31801, 'dishnetwork.net', '1416722604607', '769'),
(31802, 'digitalpath.net', '1416722600785', '770'),
(31803, 'ufcrewards.com', '1416722602085', '700'),
(31804, 'facebook.com', '1416722595452', '752'),
(31805, 'reddit.com', '1416722603535', '798'),
(31806, 'sparkfun.com', '1416722608712', '710'),
(31807, 'directtv.com', '1416722603098', '316'),
(31808, 'twitter.com', '1416722601782', '792'),
(31809, 'cmich.edu', '1416722600898', '711'),
(31810, 'foxnews.com', '1416722599412', '703'),
(31811, 'evangel.edu', '1416722602171', '721'),
(31812, '7up.com', '1416722591970', '736'),
(31813, 'youtube.com', '1416722602009', '733'),
(31814, 'chicosystems.com', '1416722601075', '758'),
(31815, 'bbc.co.uk', '1416722605269', '826'),
(31816, 'stanford.edu', '1416722602903', '701'),
(31817, 'dishnetwork.com', '1416722598136', '722'),
(31818, 'speedtest.net', '1416722603442', '720'),
(31819, 'imgur.com', '1416722601837', '742'),
(31820, 'gmail.com', '1416722601848', '761'),
(31821, 'comcast.net', '1416722600910', '746'),
(31822, 'two.com', '1416722603881', '0'),
(31823, '184.21.246.255', '1416722595789', '917'),
(31824, 'hotmail.com', '1416722600819', '752'),
(31825, 'hbo.net', '1416722596908', '700'),
(31826, 'earlhart.com', '1416722604961', '791'),
(31827, 'wargaming.net', '1416722604110', '705'),
(31828, 'he.net', '1416722609672', '793'),
(31829, 'news.com', '1416726249650', '761'),
(31830, 'plesk.com', '1416726243892', '825'),
(31831, 'dish.net', '1416726249099', '769'),
(31832, 'dishnetwork.net', '1416726251104', '724'),
(31833, 'digitalpath.net', '1416726250108', '843'),
(31834, 'ufcrewards.com', '1416726250116', '713'),
(31835, 'facebook.com', '1416726247626', '965'),
(31836, 'reddit.com', '1416726242199', '654'),
(31837, 'sparkfun.com', '1416726248422', '655'),
(31838, 'directtv.com', '1416726250853', '351'),
(31839, 'twitter.com', '1416726247774', '850'),
(31840, 'cmich.edu', '1416726249772', '787'),
(31841, 'evangel.edu', '1416726245581', '762'),
(31842, 'foxnews.com', '1416726243914', '773'),
(31843, 'youtube.com', '1416726241738', '695'),
(31844, '7up.com', '1416726241871', '856'),
(31845, 'chicosystems.com', '1416726241204', '734'),
(31846, 'bbc.co.uk', '1416726241737', '797'),
(31847, 'stanford.edu', '1416726247859', '746'),
(31848, 'dishnetwork.com', '1416726248214', '748'),
(31849, 'imgur.com', '1416726247340', '866'),
(31850, 'speedtest.net', '1416726249844', '742'),
(31851, 'gmail.com', '1416726245157', '838'),
(31852, 'comcast.net', '1416726244748', '824'),
(31853, 'two.com', '1416726246169', '0'),
(31854, '184.21.246.255', '1416726246992', '540'),
(31855, 'hotmail.com', '1416726246669', '760'),
(31856, 'earlhart.com', '1416726248093', '810'),
(31857, 'hbo.net', '1416726249635', '781'),
(31858, 'wargaming.net', '1416726244526', '714'),
(31859, 'he.net', '1416726241781', '852'),
(31860, 'stanford.edu', '1416798050510', '564'),
(31861, 'news.com', '1416798050052', '581'),
(31862, 'imgur.com', '1416798050001', '668'),
(31863, 'gmail.com', '1416798051648', '557'),
(31864, 'digitalpath.net', '1416798054053', '673'),
(31865, 'comcast.net', '1416798050353', '646'),
(31866, 'facebook.com', '1416798051518', '662'),
(31867, 'reddit.com', '1416798056968', '611'),
(31868, 'sparkfun.com', '1416798053822', '543'),
(31869, '184.21.246.255', '1416798050936', '860'),
(31870, 'hotmail.com', '1416798049891', '584'),
(31871, 'earlhart.com', '1416798055402', '681'),
(31872, 'youtube.com', '1416798054169', '645'),
(31873, 'chicosystems.com', '1416798047665', '609'),
(31874, 'stanford.edu', '1416801673960', '640'),
(31875, 'news.com', '1416801672390', '632'),
(31876, 'imgur.com', '1416801669364', '658'),
(31877, 'gmail.com', '1416801672890', '619'),
(31878, 'digitalpath.net', '1416801674681', '730'),
(31879, 'comcast.net', '1416801675032', '709'),
(31880, 'facebook.com', '1416801674486', '667'),
(31881, 'reddit.com', '1416801677608', '768'),
(31882, 'sparkfun.com', '1416801671856', '601'),
(31883, '184.21.246.255', '1416801674267', '957'),
(31884, 'hotmail.com', '1416801676378', '633'),
(31885, 'earlhart.com', '1416801670589', '716'),
(31886, 'youtube.com', '1416801668010', '689'),
(31887, 'chicosystems.com', '1416801671642', '607');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
`id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `ip`, `name`, `description`) VALUES
(1, 'google.com', 'GOOGLE', 'I''m pinging google'),
(2, 'facebook.com', 'FACEBOOK', 'This is facebook.'),
(3, 'reddit.com', 'REDDIT', 'this is reddit'),
(4, 'myspace.com', 'myspace', 'myspace is here'),
(5, 'gmail.com', 'Gmail Test', 'Development Test'),
(6, 'hotmail.com', 'HOTMAIL', 'Development Test'),
(7, 'digitalpath.net', 'DigitalPath', 'test'),
(8, 'digitalpath.com', 'DigitalPath INC.', ''),
(9, 'chicosystems.com', 'Chico Systems LLC', ''),
(10, 'news.com', 'NewsBoys', ''),
(11, 'digg.com', 'Digg Stuff', ''),
(12, 'earlhart.com', 'Earlhart Soap Works', ''),
(13, 'plesk.com', 'PLESK', ''),
(14, 'one.com', 'Uno One', ''),
(15, 'two.com', 'Two 2', ''),
(16, 'three.com', 'Three Men', ''),
(17, 'four.com', 'Four Times', ''),
(18, 'tiltservers.com', 'Tilt Servers LLC', ''),
(19, 'tiltservers.net', 'Tilt Servers LLC 2', ''),
(20, 'five.com', 'Fivers', ''),
(21, 'six.com', 'Sixtus', ''),
(22, 'seven.com', 'Se7en', ''),
(23, '7up.com', '7up Soda', ''),
(24, 'wargaming.net', 'UFC War Games', ''),
(25, 'hbo.net', 'HBO Networks', 'HBO Television.'),
(26, 'he.net', 'Hurricane Electric', 'Probably the Fremont datacenter.'),
(27, 'ufcrewards.com', 'UFC Rewards', 'It''s the UFC Rewards site.'),
(28, 'dishnetwork.net', 'Dish Networks', ''),
(29, 'dishnetwork.com', 'Dish Networks 2', ''),
(30, 'dish.net', 'Dish Networks 3', ''),
(31, 'directtv.com', 'Direct Tv', ''),
(32, 'bbc.co.uk', 'BBC News', ''),
(33, 'foxnews.com', 'Fox News', ''),
(34, 'speedtest.net', 'Speed Test Net.', ''),
(35, 'cmich.edu', 'C.M.U.', ''),
(36, 'evangel.edu', 'Evangel University', ''),
(37, 'twitter.com', 'Twitter', ''),
(38, 'stanford.edu', 'Stanford University', ''),
(39, 'comcast.net', 'Comcast 1', ''),
(40, 'imgur.com', 'Imgur', ''),
(41, 'sparkfun.com', 'Sparkfun', ''),
(42, 'youtube.com', 'Youtube', ''),
(43, '192.168.2.1', 'Router', ''),
(44, '184.21.246.255', 'Router 2', '');

-- --------------------------------------------------------

--
-- Table structure for table `hour`
--

CREATE TABLE IF NOT EXISTS `hour` (
`id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `time` text NOT NULL,
  `latency` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=382331 ;

-- --------------------------------------------------------

--
-- Table structure for table `minute`
--

CREATE TABLE IF NOT EXISTS `minute` (
`id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `time` text NOT NULL,
  `latency` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18431755 ;

--
-- Dumping data for table `minute`
--

INSERT INTO `minute` (`id`, `ip`, `time`, `latency`) VALUES
(18431515, 'stanford.edu', '1416962346733', 0),
(18431516, 'gmail.com', '1416962346733', 0),
(18431517, 'comcast.net', '1416962346733', 0),
(18431518, 'reddit.com', '1416962346733', 0),
(18431519, 'chicosystems.com', '1416962346733', 0),
(18431520, 'news.com', '1416962346733', 0),
(18431521, 'earlhart.com', '1416962346733', 0),
(18431522, 'digitalpath.net', '1416962346733', 0),
(18431523, 'hotmail.com', '1416962346733', 0),
(18431524, 'facebook.com', '1416962346733', 0),
(18431525, '184.21.246.255', '1416962346733', 0),
(18431526, 'imgur.com', '1416962347437', 0),
(18431527, 'sparkfun.com', '1416962347437', 0),
(18431528, 'comcast.net', '1416962347437', 0),
(18431529, 'gmail.com', '1416962347437', 0),
(18431530, 'chicosystems.com', '1416962347438', 0),
(18431531, 'youtube.com', '1416962347447', 0),
(18431532, 'reddit.com', '1416962347447', 0),
(18431533, 'news.com', '1416962347447', 0),
(18431534, 'facebook.com', '1416962347447', 0),
(18431535, 'sparkfun.com', '1416962347876', 0),
(18431536, 'chicosystems.com', '1416962347876', 0),
(18431537, 'stanford.edu', '1416962347861', 0),
(18431538, 'digitalpath.net', '1416962347447', 0),
(18431539, 'hotmail.com', '1416962347447', 0),
(18431540, 'news.com', '1416962349193', 0),
(18431541, 'youtube.com', '1416962349193', 0),
(18431542, 'chicosystems.com', '1416962349213', 0),
(18431543, 'reddit.com', '1416962349213', 0),
(18431544, 'stanford.edu', '1416962349503', 0),
(18431545, 'facebook.com', '1416962349503', 0),
(18431546, 'hotmail.com', '1416962349528', 0),
(18431547, 'sparkfun.com', '1416962349528', 0),
(18431548, 'digitalpath.net', '1416962349813', 0),
(18431549, 'news.com', '1416962349813', 0),
(18431550, 'youtube.com', '1416962349828', 0),
(18431551, 'chicosystems.com', '1416962349828', 0),
(18431552, 'facebook.com', '1416962350167', 0),
(18431553, 'reddit.com', '1416962350167', 0),
(18431554, 'stanford.edu', '1416962350172', 0),
(18431555, 'comcast.net', '1416962350711', 0),
(18431556, '184.21.246.255', '1416962350707', 0),
(18431557, 'earlhart.com', '1416962350707', 0),
(18431558, 'gmail.com', '1416962350707', 0),
(18431559, 'imgur.com', '1416962350707', 0),
(18431560, 'hotmail.com', '1416962350527', 0),
(18431561, 'news.com', '1416962350527', 0),
(18431562, 'sparkfun.com', '1416962350172', 0),
(18431563, 'facebook.com', '1416962352054', 0),
(18431564, 'chicosystems.com', '1416962352054', 0),
(18431565, 'digitalpath.net', '1416962352054', 0),
(18431566, 'reddit.com', '1416962352054', 0),
(18431567, 'news.com', '1416962352065', 0),
(18431568, 'gmail.com', '1416962352384', 0),
(18431569, 'stanford.edu', '1416962352429', 0),
(18431570, 'earlhart.com', '1416962352429', 0),
(18431571, 'hotmail.com', '1416962352429', 0),
(18431572, 'sparkfun.com', '1416962352429', 0),
(18431573, 'chicosystems.com', '1416962352677', 0),
(18431574, 'facebook.com', '1416962352822', 0),
(18431575, 'gmail.com', '1416962352965', 0),
(18431576, 'news.com', '1416962352850', 0),
(18431577, 'digitalpath.net', '1416962352822', 0),
(18431578, 'reddit.com', '1416962352822', 0),
(18431579, 'earlhart.com', '1416962354618', 0),
(18431580, 'stanford.edu', '1416962354678', 0),
(18431581, 'hotmail.com', '1416962354678', 0),
(18431582, 'sparkfun.com', '1416962354688', 0),
(18431583, 'hotmail.com', '1416962354698', 0),
(18431584, 'comcast.net', '1416962354708', 0),
(18431585, '184.21.246.255', '1416962354708', 0),
(18431586, 'youtube.com', '1416962354708', 0),
(18431587, 'imgur.com', '1416962354708', 0),
(18431588, 'hotmail.com', '1416962354881', 0),
(18431589, 'earlhart.com', '1416962355130', 0),
(18431590, 'imgur.com', '1416962355142', 0),
(18431591, 'sparkfun.com', '1416962355149', 0),
(18431592, 'stanford.edu', '1416962355149', 0),
(18431593, 'hotmail.com', '1416962355150', 0),
(18431594, 'hotmail.com', '1416962355150', 0),
(18431595, 'comcast.net', '1416962355496', 0),
(18431596, 'imgur.com', '1416962355441', 0),
(18431597, 'comcast.net', '1416962355188', 0),
(18431598, 'digitalpath.net', '1416962356702', 0),
(18431599, 'youtube.com', '1416962356707', 0),
(18431600, 'earlhart.com', '1416962356707', 0),
(18431601, 'news.com', '1416962356707', 0),
(18431602, 'facebook.com', '1416962357017', 0),
(18431603, 'sparkfun.com', '1416962357017', 0),
(18431604, 'hotmail.com', '1416962357017', 0),
(18431605, 'stanford.edu', '1416962357017', 0),
(18431606, 'hotmail.com', '1416962357307', 0),
(18431607, 'reddit.com', '1416962357307', 0),
(18431608, 'comcast.net', '1416962357307', 0),
(18431609, 'imgur.com', '1416962357307', 0),
(18431610, 'chicosystems.com', '1416962357705', 0),
(18431611, 'gmail.com', '1416962357705', 0),
(18431612, '184.21.246.255', '1416962357705', 0),
(18431613, 'news.com', '1416962358055', 0),
(18431614, 'digitalpath.net', '1416962358055', 0),
(18431615, 'youtube.com', '1416962358705', 0),
(18431616, '184.21.246.255', '1416962358705', 0),
(18431617, 'youtube.com', '1416962358340', 0),
(18431618, 'earlhart.com', '1416962358055', 0),
(18431619, 'facebook.com', '1416962359792', 0),
(18431620, 'stanford.edu', '1416962359792', 0),
(18431621, 'sparkfun.com', '1416962359792', 0),
(18431622, 'hotmail.com', '1416962359792', 0),
(18431623, 'earlhart.com', '1416962359797', 0),
(18431624, 'hotmail.com', '1416962360137', 0),
(18431625, 'reddit.com', '1416962360137', 0),
(18431626, 'imgur.com', '1416962360137', 0),
(18431627, 'gmail.com', '1416962360137', 0),
(18431628, 'sparkfun.com', '1416962360137', 0),
(18431629, 'youtube.com', '1416962364207', 0),
(18431630, '184.21.246.255', '1416962364207', 0),
(18431631, 'chicosystems.com', '1416962364207', 0),
(18431632, 'youtube.com', '1416962364207', 0),
(18431633, 'digitalpath.net', '1416962364207', 0),
(18431634, 'stanford.edu', '1416962364566', 0),
(18431635, 'comcast.net', '1416962364604', 0),
(18431636, 'comcast.net', '1416962364604', 0),
(18431637, 'facebook.com', '1416962364591', 0),
(18431638, 'stanford.edu', '1416962364591', 0),
(18431639, 'hotmail.com', '1416962366275', 0),
(18431640, 'earlhart.com', '1416962366275', 0),
(18431641, 'sparkfun.com', '1416962366285', 0),
(18431642, 'earlhart.com', '1416962366285', 0),
(18431643, 'sparkfun.com', '1416962366290', 0),
(18431644, 'gmail.com', '1416962366615', 0),
(18431645, 'news.com', '1416962366615', 0),
(18431646, 'digitalpath.net', '1416962366615', 0),
(18431647, 'hotmail.com', '1416962366955', 0),
(18431648, 'youtube.com', '1416962366990', 0),
(18431649, 'chicosystems.com', '1416962366990', 0),
(18431650, 'comcast.net', '1416962367293', 0),
(18431651, 'hotmail.com', '1416962367294', 0),
(18431652, 'stanford.edu', '1416962367566', 0),
(18431653, 'earlhart.com', '1416962367566', 0),
(18431654, 'reddit.com', '1416962367846', 0),
(18431655, 'facebook.com', '1416962367846', 0),
(18431656, 'imgur.com', '1416962369208', 0),
(18431657, '184.21.246.255', '1416962369208', 0),
(18431658, 'digitalpath.net', '1416962369432', 0),
(18431659, 'gmail.com', '1416962369432', 0),
(18431660, 'hotmail.com', '1416962369497', 0),
(18431661, 'hotmail.com', '1416962369497', 0),
(18431662, 'youtube.com', '1416962369737', 0),
(18431663, 'chicosystems.com', '1416962369737', 0),
(18431664, 'comcast.net', '1416962369792', 0),
(18431665, 'hotmail.com', '1416962369792', 0),
(18431666, 'stanford.edu', '1416962370037', 0),
(18431667, 'earlhart.com', '1416962370037', 0),
(18431668, 'earlhart.com', '1416962370077', 0),
(18431669, 'sparkfun.com', '1416962370077', 0),
(18431670, 'sparkfun.com', '1416962370360', 0),
(18431671, 'facebook.com', '1416962370360', 0),
(18431672, '184.21.246.255', '1416962374205', 0),
(18431673, 'reddit.com', '1416962374205', 0),
(18431674, 'digitalpath.net', '1416962374493', 0),
(18431675, 'gmail.com', '1416962374493', 0),
(18431676, 'hotmail.com', '1416962376514', 0),
(18431677, 'hotmail.com', '1416962376524', 0),
(18431678, 'news.com', '1416962376789', 0),
(18431679, 'imgur.com', '1416962376794', 0),
(18431680, 'chicosystems.com', '1416962377054', 0),
(18431681, 'youtube.com', '1416962377331', 0),
(18431682, 'sparkfun.com', '1416962377621', 0),
(18431683, '184.21.246.255', '1416962380706', 0),
(18431684, 'digitalpath.net', '1416962381019', 0),
(18431685, 'gmail.com', '1416962381299', 0),
(18431686, 'hotmail.com', '1416962381574', 0),
(18431687, 'hotmail.com', '1416962381854', 0),
(18431688, 'comcast.net', '1416962382194', 0),
(18431689, 'stanford.edu', '1416962383078', 0),
(18431690, 'earlhart.com', '1416962383518', 0),
(18431691, 'facebook.com', '1416962384032', 0),
(18431692, 'reddit.com', '1416962384385', 0),
(18431693, 'news.com', '1416962384767', 0),
(18431694, 'digitalpath.net', '1416962385080', 0),
(18431695, 'imgur.com', '1416962388492', 0),
(18431696, 'chicosystems.com', '1416962388732', 0),
(18431697, 'youtube.com', '1416962389049', 0),
(18431698, 'sparkfun.com', '1416962389349', 0),
(18431699, '184.21.246.255', '1416962392211', 0),
(18431700, 'gmail.com', '1416962392482', 0),
(18431701, 'hotmail.com', '1416962392772', 0),
(18431702, 'hotmail.com', '1416962393057', 0),
(18431703, 'comcast.net', '1416962393337', 0),
(18431704, 'stanford.edu', '1416962393623', 0),
(18431705, 'earlhart.com', '1416962393903', 0),
(18431706, 'facebook.com', '1416962394213', 0),
(18431707, 'reddit.com', '1416962394513', 0),
(18431708, 'news.com', '1416962394791', 0),
(18431709, 'digitalpath.net', '1416962395076', 0),
(18431710, 'imgur.com', '1416962395512', 0),
(18431711, 'chicosystems.com', '1416962395817', 0),
(18431712, 'youtube.com', '1416962396117', 0),
(18431713, 'sparkfun.com', '1416962396463', 0),
(18431714, '184.21.246.255', '1416962399705', 0),
(18431715, '184.21.246.255', '1416962405708', 0),
(18431716, 'gmail.com', '1416962405954', 0),
(18431717, 'hotmail.com', '1416962406231', 0),
(18431718, 'hotmail.com', '1416962406501', 0),
(18431719, 'comcast.net', '1416962406786', 0),
(18431720, 'stanford.edu', '1416962407059', 0),
(18431721, 'earlhart.com', '1416962407342', 0),
(18431722, 'facebook.com', '1416962407637', 0),
(18431723, 'reddit.com', '1416962407915', 0),
(18431724, 'news.com', '1416962408185', 0),
(18431725, 'digitalpath.net', '1416962408458', 0),
(18431726, 'imgur.com', '1416962408734', 0),
(18431727, 'chicosystems.com', '1416962409009', 0),
(18431728, 'youtube.com', '1416962409278', 0),
(18431729, 'sparkfun.com', '1416962409552', 0),
(18431730, '184.21.246.255', '1416962412704', 0),
(18431731, 'gmail.com', '1416962413012', 0),
(18431732, 'hotmail.com', '1416962413292', 0),
(18431733, 'hotmail.com', '1416962413643', 0),
(18431734, 'comcast.net', '1416962413955', 0),
(18431735, 'stanford.edu', '1416962416012', 0),
(18431736, 'earlhart.com', '1416962416282', 0),
(18431737, 'facebook.com', '1416962416552', 0),
(18431738, 'reddit.com', '1416962416817', 0),
(18431739, 'news.com', '1416962417090', 0),
(18431740, 'digitalpath.net', '1416962417370', 0),
(18431741, 'imgur.com', '1416962417640', 0),
(18431742, 'chicosystems.com', '1416962417919', 0),
(18431743, 'youtube.com', '1416962418202', 0),
(18431744, 'sparkfun.com', '1416962418501', 0),
(18431745, '184.21.246.255', '1416962421708', 0),
(18431746, '184.21.246.255', '1416962425705', 0),
(18431747, 'gmail.com', '1416962425980', 0),
(18431748, 'hotmail.com', '1416962426240', 0),
(18431749, 'hotmail.com', '1416962426526', 0),
(18431750, 'comcast.net', '1416962426801', 0),
(18431751, 'stanford.edu', '1416962427084', 0),
(18431752, 'earlhart.com', '1416962427350', 0),
(18431753, 'facebook.com', '1416962427614', 0),
(18431754, 'reddit.com', '1416962427884', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
`id` int(11) NOT NULL,
  `deviceID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `timestamp` text NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `deviceID`, `userID`, `timestamp`, `content`) VALUES
(1, 12, 1, '1407615812000', 'Customer has been experiencing intermittent problems with connecting. I''d like us to monitor this for the day.'),
(2, 12, 1, '1407616812000', 'This is continuing to have problems as of today.'),
(3, 12, 1, '1407617812000', 'Customer went off line again at midnight. It looks like it could be maintenance work with their ISP.'),
(4, 12, 2, '1407618812000', 'Logged in to test this just now. It''s looking good as of this time.'),
(6, 12, 1, '1407619912000', 'I called their ISP. Looks like they are on a wireless connection. Had their ISP do some rechanneling, latency went WAY WAY down.'),
(7, 12, 2, '1407620912000', 'Nope, they called up again this morning, they are still having problems.'),
(8, 12, 1, '1407622912000', 'I called back the customer.\r\nHad them turn their computer off and then back on again.\r\nEverything is working fine now. Why didn''t we think of this before.'),
(9, 12, 2, '1407624912000', 'That''s genius. Let''s monitor this for a little while longer. If it''s good by tomorrow we can stop worring about it.'),
(10, 12, 1, '1407634912000', 'Removing...'),
(12, 7, 1, '1409374477842', 'first'),
(13, 12, 1, '1409374558399', 'asdf'),
(14, 12, 1, '1409443785653', 'sdfhyiikihk'),
(15, 12, 1, '1409706238282', 'monitoring'),
(16, 5, 1, '1409706511533', 'Start monitoring this now.'),
(17, 12, 1, '1410211123271', 'notes'),
(18, 6, 1, '1416160800360', 'test'),
(19, 6, 1, '1416160911610', 'hi'),
(20, 6, 1, '1416160957082', 'test2'),
(21, 9, 1, '1416165066173', ''),
(22, 9, 1, '1416165066173', 'test'),
(23, 12, 1, '1416172578442', 'still watching this baby'),
(24, 5, 1, '1416251550985', 'it''s looking, really, pretty good.'),
(25, 12, 1, '1416513233288', 'test'),
(26, 5, 1, '1416549171847', 'this is a note'),
(27, 15, 1, '1416681857689', 'Device is offline.'),
(28, 5, 1, '1416804942284', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `notify_if_over_latency` int(11) NOT NULL,
  `notify_after_time_seconds` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `record_id`, `notify_if_over_latency`, `notify_after_time_seconds`) VALUES
(1, 1, 1, 250, 60);

-- --------------------------------------------------------

--
-- Table structure for table `timers`
--

CREATE TABLE IF NOT EXISTS `timers` (
`id` int(11) NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `timers`
--

INSERT INTO `timers` (`id`, `name`, `value`) VALUES
(3, 'fiveMinuteTimer', '1416962642424'),
(4, 'fifteenMinuteTimer', '1416963242609'),
(5, 'hourTimer', '1416965942854'),
(6, 'twelveHourTimer', '1417005543119'),
(7, 'dayTimer', '1417048743349'),
(8, 'fourtyEightHourTimer', '1417135143724'),
(9, 'weekTimer', '1417418867208');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `usr` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` text NOT NULL,
  `subscriptions` text NOT NULL,
  `admin_level` int(1) NOT NULL,
  `pass` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `regIP` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dt` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usr`, `email`, `subscriptions`, `admin_level`, `pass`, `regIP`, `dt`) VALUES
(1, 'itravers', 'isaac.a.travers@gmail.com', '', 10, '8b047144fb28065ed57512f8ab89eca5', '', '0000-00-00 00:00:00'),
(2, 'test', 'test@test.com', '', 0, '098f6bcd4621d373cade4e832627b4f6', '', '0000-00-00 00:00:00'),
(3, 'slack', 'confusedvirtuoso@gmail.com', '', 10, '8b047144fb28065ed57512f8ab89eca5', '', '0000-00-00 00:00:00'),
(4, 'test2', 'test2@test2.com', '', 9, '098f6bcd4621d373cade4e832627b4f6', '', '0000-00-00 00:00:00'),
(14, 'test3', '', '', 10, '098f6bcd4621d373cade4e832627b4f6', '', '0000-00-00 00:00:00'),
(15, 'zenrix', '', '', 2, '8b047144fb28065ed57512f8ab89eca5', '', '0000-00-00 00:00:00'),
(29, 'admin', '', '', 10, '8b047144fb28065ed57512f8ab89eca5', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `week`
--

CREATE TABLE IF NOT EXISTS `week` (
`id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `time` text NOT NULL,
  `latency` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1497 ;

--
-- Dumping data for table `week`
--

INSERT INTO `week` (`id`, `ip`, `time`, `latency`) VALUES
(1149, 'two.com', '1414602604352', '-1'),
(1150, 'digitalpath.com', '1414602604546', '61'),
(1151, 'digg.com', '1414602604760', '-1'),
(1152, 'news.com', '1414602604301', '2'),
(1153, 'one.com', '1414602603771', '106'),
(1154, 'plesk.com', '1414602603911', '45'),
(1155, 'gmail.com', '1414602603895', '40'),
(1156, 'hotmail.com', '1414602604323', '44'),
(1157, 'earlhart.com', '1414602604353', '36'),
(1158, 'digitalpath.net', '1414602603685', '62'),
(1159, 'chicosystems.com', '1414602604240', '0'),
(1160, 'two.com', '1414688989652', '-1'),
(1161, 'digitalpath.com', '1414688989180', '65'),
(1162, 'digg.com', '1414688989119', '-1'),
(1163, 'news.com', '1414688989241', '1'),
(1164, 'one.com', '1414688989788', '110'),
(1165, 'plesk.com', '1414688988813', '41'),
(1166, 'gmail.com', '1414688989140', '33'),
(1167, 'hotmail.com', '1414688989021', '34'),
(1168, 'earlhart.com', '1414688989273', '35'),
(1169, 'digitalpath.net', '1414688989432', '69'),
(1170, 'chicosystems.com', '1414688989516', '0'),
(1171, 'two.com', '1414775328052', '-1'),
(1172, 'digitalpath.com', '1414775327494', '87'),
(1173, 'digg.com', '1414775327968', '-1'),
(1174, 'news.com', '1414775327839', '2'),
(1175, 'one.com', '1414775326797', '113'),
(1176, 'plesk.com', '1414775327123', '62'),
(1177, 'gmail.com', '1414775327388', '37'),
(1178, 'hotmail.com', '1414775327502', '39'),
(1179, 'earlhart.com', '1414775328129', '34'),
(1180, 'digitalpath.net', '1414775327465', '80'),
(1181, 'chicosystems.com', '1414775327554', '0'),
(1182, 'digitalpath.com', '1414861764301', '64'),
(1183, 'two.com', '1414861764139', '-1'),
(1184, 'digg.com', '1414861764788', '-1'),
(1185, 'news.com', '1414861764048', '1'),
(1186, 'one.com', '1414861764172', '110'),
(1187, 'plesk.com', '1414861764342', '40'),
(1188, 'gmail.com', '1414861764059', '33'),
(1189, 'hotmail.com', '1414861763874', '32'),
(1190, 'earlhart.com', '1414861763921', '34'),
(1191, 'digitalpath.net', '1414861763866', '65'),
(1192, 'chicosystems.com', '1414861764101', '0'),
(1193, 'two.com', '1414948201231', '-1'),
(1194, 'digitalpath.com', '1414948200905', '64'),
(1195, 'digg.com', '1414948201783', '-1'),
(1196, 'news.com', '1414948200804', '1'),
(1197, 'one.com', '1414948200806', '110'),
(1198, 'plesk.com', '1414948200317', '40'),
(1199, 'gmail.com', '1414948200469', '33'),
(1200, 'hotmail.com', '1414948201093', '32'),
(1201, 'earlhart.com', '1414948201472', '34'),
(1202, 'digitalpath.net', '1414948200764', '65'),
(1203, 'chicosystems.com', '1414948200681', '0'),
(1204, 'two.com', '1415034637966', '-1'),
(1205, 'digitalpath.com', '1415034637386', '64'),
(1206, 'digg.com', '1415034637177', '-1'),
(1207, 'news.com', '1415034637579', '1'),
(1208, 'one.com', '1415034637751', '111'),
(1209, 'plesk.com', '1415034637398', '39'),
(1210, 'gmail.com', '1415034637541', '33'),
(1211, 'hotmail.com', '1415034637556', '32'),
(1212, 'earlhart.com', '1415034637554', '35'),
(1213, 'digitalpath.net', '1415034637302', '65'),
(1214, 'chicosystems.com', '1415034637750', '0'),
(1215, 'two.com', '1415121074616', '-1'),
(1216, 'digitalpath.com', '1415121074475', '64'),
(1217, 'digg.com', '1415121074901', '-1'),
(1218, 'news.com', '1415121074713', '1'),
(1219, 'one.com', '1415121074686', '108'),
(1220, 'plesk.com', '1415121074502', '40'),
(1221, 'gmail.com', '1415121074632', '21'),
(1222, 'hotmail.com', '1415121074561', '33'),
(1223, 'earlhart.com', '1415121074335', '35'),
(1224, 'digitalpath.net', '1415121074569', '66'),
(1225, 'chicosystems.com', '1415121074598', '0'),
(1226, 'two.com', '1415207500970', '-1'),
(1227, 'digitalpath.com', '1415207512802', '66'),
(1228, 'digg.com', '1415207501010', '-1'),
(1229, 'news.com', '1415207500012', '3'),
(1230, 'one.com', '1415207493326', '108'),
(1231, 'plesk.com', '1415207493432', '43'),
(1232, 'gmail.com', '1415207506442', '51'),
(1233, 'hotmail.com', '1415207480141', '57'),
(1234, 'earlhart.com', '1415207500227', '36'),
(1235, 'digitalpath.net', '1415207499890', '67'),
(1236, 'chicosystems.com', '1415207506392', '0'),
(1237, 'digitalpath.com', '1415293806253', '64'),
(1238, 'two.com', '1415293806803', '-1'),
(1239, 'digg.com', '1415293819807', '-1'),
(1240, 'news.com', '1415293806406', '1'),
(1241, 'one.com', '1415293799856', '108'),
(1242, 'plesk.com', '1415293806414', '40'),
(1243, 'gmail.com', '1415293806267', '60'),
(1244, 'hotmail.com', '1415293806050', '62'),
(1245, 'earlhart.com', '1415293806095', '36'),
(1246, 'digitalpath.net', '1415293806346', '66'),
(1247, 'chicosystems.com', '1415293799829', '0'),
(1248, 'two.com', '1415380237896', '-1'),
(1249, 'digitalpath.com', '1415380237422', '64'),
(1250, 'digg.com', '1415380237422', '-1'),
(1251, 'news.com', '1415380237520', '1'),
(1252, 'one.com', '1415380237706', '108'),
(1253, 'plesk.com', '1415380237605', '40'),
(1254, 'gmail.com', '1415380237015', '59'),
(1255, 'hotmail.com', '1415380237423', '61'),
(1256, 'earlhart.com', '1415380237352', '36'),
(1257, 'digitalpath.net', '1415380237207', '66'),
(1258, 'chicosystems.com', '1415380237627', '0'),
(1259, 'two.com', '1415466675305', '-1'),
(1260, 'digitalpath.com', '1415466674547', '64'),
(1261, 'digg.com', '1415466674778', '-1'),
(1262, 'news.com', '1415466674869', '2'),
(1263, 'one.com', '1415466674365', '109'),
(1264, 'plesk.com', '1415466674463', '39'),
(1265, 'gmail.com', '1415466674610', '19'),
(1266, 'hotmail.com', '1415466674918', '36'),
(1267, 'earlhart.com', '1415466674381', '37'),
(1268, 'digitalpath.net', '1415466674943', '65'),
(1269, 'chicosystems.com', '1415466674355', '0'),
(1270, 'two.com', '1415553112008', '-1'),
(1271, 'digitalpath.com', '1415553111613', '64'),
(1272, 'digg.com', '1415553111853', '-1'),
(1273, 'news.com', '1415553111431', '1'),
(1274, 'one.com', '1415553111275', '110'),
(1275, 'plesk.com', '1415553111300', '39'),
(1276, 'gmail.com', '1415553111309', '11'),
(1277, 'hotmail.com', '1415553111506', '32'),
(1278, 'earlhart.com', '1415553111863', '34'),
(1279, 'digitalpath.net', '1415553111299', '65'),
(1280, 'chicosystems.com', '1415553111452', '0'),
(1281, 'two.com', '1415639547867', '-1'),
(1282, 'digitalpath.com', '1415639546887', '66'),
(1283, 'digg.com', '1415639547830', '-1'),
(1284, 'news.com', '1415639547331', '2'),
(1285, 'one.com', '1415639546968', '164'),
(1286, 'plesk.com', '1415639547158', '42'),
(1287, 'gmail.com', '1415639546787', '13'),
(1288, 'hotmail.com', '1415639547206', '34'),
(1289, 'earlhart.com', '1415639547181', '38'),
(1290, 'digitalpath.net', '1415639547263', '66'),
(1291, 'chicosystems.com', '1415639547059', '0'),
(1292, 'two.com', '1415725984316', '-1'),
(1293, 'digitalpath.com', '1415725983729', '65'),
(1294, 'digg.com', '1415725984411', '-1'),
(1295, 'news.com', '1415725984066', '2'),
(1296, 'one.com', '1415725983444', '186'),
(1297, 'plesk.com', '1415725984028', '42'),
(1298, 'gmail.com', '1415725983695', '20'),
(1299, 'hotmail.com', '1415725983934', '33'),
(1300, 'earlhart.com', '1415725983214', '36'),
(1301, 'digitalpath.net', '1415725983671', '66'),
(1302, 'chicosystems.com', '1415725983936', '0'),
(1303, 'two.com', '1415812270383', '-1'),
(1304, 'digitalpath.com', '1415812269969', '64'),
(1305, 'digg.com', '1415812270385', '-1'),
(1306, 'news.com', '1415812269723', '6'),
(1307, 'one.com', '1415812270225', '186'),
(1308, 'plesk.com', '1415812270371', '40'),
(1309, 'gmail.com', '1415812270283', '37'),
(1310, 'hotmail.com', '1415812270128', '34'),
(1311, 'earlhart.com', '1415812269828', '40'),
(1312, 'digitalpath.net', '1415812270153', '66'),
(1313, 'chicosystems.com', '1415812270173', '0'),
(1314, 'two.com', '1415898708872', '-1'),
(1315, 'digitalpath.com', '1415898708452', '72'),
(1316, 'digg.com', '1415898709063', '-1'),
(1317, 'news.com', '1415898708689', '11'),
(1318, 'one.com', '1415898707530', '192'),
(1319, 'plesk.com', '1415898708315', '48'),
(1320, 'gmail.com', '1415898708507', '48'),
(1321, 'hotmail.com', '1415898708426', '55'),
(1322, 'earlhart.com', '1415898708764', '41'),
(1323, 'digitalpath.net', '1415898708422', '73'),
(1324, 'chicosystems.com', '1415898708344', '0'),
(1325, 'two.com', '1415985146473', '-1'),
(1326, 'digitalpath.com', '1415985145659', '64'),
(1327, 'digg.com', '1415985145995', '-1'),
(1328, 'news.com', '1415985145800', '1'),
(1329, 'one.com', '1415985145415', '185'),
(1330, 'plesk.com', '1415985145785', '40'),
(1331, 'gmail.com', '1415985145701', '51'),
(1332, 'hotmail.com', '1415985145699', '61'),
(1333, 'earlhart.com', '1415985145419', '34'),
(1334, 'digitalpath.net', '1415985144959', '65'),
(1335, 'chicosystems.com', '1415985145560', '0'),
(1336, 'two.com', '1416071584233', '-1'),
(1337, 'digitalpath.com', '1416071584181', '78'),
(1338, 'digg.com', '1416071584550', '-1'),
(1339, 'news.com', '1416071583769', '6'),
(1340, 'one.com', '1416071583634', '190'),
(1341, 'plesk.com', '1416071583642', '56'),
(1342, 'gmail.com', '1416071583820', '65'),
(1343, 'hotmail.com', '1416071583843', '72'),
(1344, 'earlhart.com', '1416071584054', '41'),
(1345, 'digitalpath.net', '1416071583751', '77'),
(1346, 'chicosystems.com', '1416071583582', '0'),
(1347, 'two.com', '1416159195782', '556'),
(1348, 'digitalpath.com', '1416159185019', '361'),
(1349, 'digg.com', '1416159184594', '542'),
(1350, 'news.com', '1416159195016', '331'),
(1351, 'one.com', '1416159194251', '477'),
(1352, 'plesk.com', '1416159184972', '341'),
(1353, 'gmail.com', '1416159201335', '376'),
(1354, 'hotmail.com', '1416159194919', '357'),
(1355, 'earlhart.com', '1416159194683', '358'),
(1356, 'digitalpath.net', '1416159184473', '375'),
(1357, 'chicosystems.com', '1416159187900', '328'),
(1358, 'digitalpath.com', '1416244946466', '658'),
(1359, 'two.com', '1416232304816', '0'),
(1360, 'digg.com', '1416232312864', '0'),
(1361, 'news.com', '1416244946514', '672'),
(1362, 'one.com', '1416235919525', '800'),
(1363, 'plesk.com', '1416235919614', '685'),
(1364, 'gmail.com', '1416244945780', '646'),
(1365, 'hotmail.com', '1416244938740', '665'),
(1366, 'earlhart.com', '1416244951490', '687'),
(1367, 'digitalpath.net', '1416244951796', '661'),
(1368, 'chicosystems.com', '1416244945828', '661'),
(1369, 'digitalpath.com', '1416331369751', '574'),
(1370, 'news.com', '1416331374451', '588'),
(1371, 'gmail.com', '1416331374863', '570'),
(1372, 'hotmail.com', '1416331369455', '579'),
(1373, 'earlhart.com', '1416331374443', '602'),
(1374, 'digitalpath.net', '1416331374648', '543'),
(1375, 'chicosystems.com', '1416331368298', '579'),
(1376, 'news.com', '1416719047614', '690'),
(1377, 'plesk.com', '1416720874448', '752'),
(1378, 'dishnetwork.net', '1416721065026', '705'),
(1379, 'dish.net', '1416721061675', '676'),
(1380, 'digitalpath.net', '1416719044585', '726'),
(1381, 'ufcrewards.com', '1416721066487', '672'),
(1382, 'facebook.com', '1416720872649', '785'),
(1383, 'reddit.com', '1416720875152', '704'),
(1384, 'sparkfun.com', '1416722644230', '678'),
(1385, 'directtv.com', '1416721065289', '399'),
(1386, 'twitter.com', '1416721064097', '769'),
(1387, 'cmich.edu', '1416721065196', '714'),
(1388, 'foxnews.com', '1416721063747', '706'),
(1389, 'evangel.edu', '1416721060938', '707'),
(1390, 'youtube.com', '1416722641634', '704'),
(1391, '7up.com', '1416720907934', '721'),
(1392, 'chicosystems.com', '1416719042605', '689'),
(1393, 'bbc.co.uk', '1416721062472', '805'),
(1394, 'stanford.edu', '1416722643310', '701'),
(1395, 'dishnetwork.com', '1416721063940', '711'),
(1396, 'imgur.com', '1416722641861', '773'),
(1397, 'speedtest.net', '1416721065627', '705'),
(1398, 'gmail.com', '1416719046583', '704'),
(1399, 'news.com', '1416719047614', '690'),
(1400, 'plesk.com', '1416720874448', '752'),
(1401, 'dishnetwork.net', '1416721065026', '705'),
(1402, 'dish.net', '1416721061675', '676'),
(1403, 'digitalpath.net', '1416719044585', '726'),
(1404, 'ufcrewards.com', '1416721066487', '672'),
(1405, 'facebook.com', '1416720872649', '785'),
(1406, 'reddit.com', '1416720875152', '704'),
(1407, 'sparkfun.com', '1416722644230', '678'),
(1408, 'directtv.com', '1416721065289', '399'),
(1409, 'twitter.com', '1416721064097', '769'),
(1410, 'cmich.edu', '1416721065196', '714'),
(1411, 'foxnews.com', '1416721063747', '706'),
(1412, 'evangel.edu', '1416721060938', '707'),
(1413, 'youtube.com', '1416722641634', '704'),
(1414, '7up.com', '1416720907934', '721'),
(1415, 'chicosystems.com', '1416719042605', '689'),
(1416, 'bbc.co.uk', '1416721062472', '805'),
(1417, 'stanford.edu', '1416722643310', '701'),
(1418, 'dishnetwork.com', '1416721063940', '711'),
(1419, 'imgur.com', '1416722641861', '773'),
(1420, 'speedtest.net', '1416721065627', '705'),
(1421, 'gmail.com', '1416719046583', '704'),
(1422, 'comcast.net', '1416722642249', '763'),
(1423, 'news.com', '1416719047614', '690'),
(1424, 'plesk.com', '1416720874448', '752'),
(1425, 'dishnetwork.net', '1416721065026', '705'),
(1426, 'dish.net', '1416721061675', '676'),
(1427, 'digitalpath.net', '1416719044585', '726'),
(1428, 'ufcrewards.com', '1416721066487', '672'),
(1429, 'facebook.com', '1416720872649', '785'),
(1430, 'reddit.com', '1416720875152', '704'),
(1431, 'sparkfun.com', '1416722644230', '678'),
(1432, 'directtv.com', '1416721065289', '399'),
(1433, 'twitter.com', '1416721064097', '769'),
(1434, 'cmich.edu', '1416721065196', '714'),
(1435, 'foxnews.com', '1416721063747', '706'),
(1436, 'evangel.edu', '1416721060938', '707'),
(1437, 'youtube.com', '1416722641634', '704'),
(1438, 'news.com', '1416719047614', '690'),
(1439, 'plesk.com', '1416720874448', '752'),
(1440, 'dishnetwork.net', '1416721065026', '705'),
(1441, 'dish.net', '1416721061675', '676'),
(1442, 'digitalpath.net', '1416719044585', '726'),
(1443, 'ufcrewards.com', '1416721066487', '672'),
(1444, 'facebook.com', '1416720872649', '785'),
(1445, 'reddit.com', '1416720875152', '704'),
(1446, 'sparkfun.com', '1416722644230', '678'),
(1447, 'directtv.com', '1416721065289', '399'),
(1448, 'twitter.com', '1416721064097', '769'),
(1449, 'cmich.edu', '1416721065196', '714'),
(1450, 'foxnews.com', '1416721063747', '706'),
(1451, 'evangel.edu', '1416721060938', '707'),
(1452, 'youtube.com', '1416722641634', '704'),
(1453, '7up.com', '1416720907934', '721'),
(1454, 'chicosystems.com', '1416719042605', '689'),
(1455, 'bbc.co.uk', '1416721062472', '805'),
(1456, 'stanford.edu', '1416722643310', '701'),
(1457, 'dishnetwork.com', '1416721063940', '711'),
(1458, 'imgur.com', '1416722641861', '773'),
(1459, 'speedtest.net', '1416721065627', '705'),
(1460, 'gmail.com', '1416719046583', '704'),
(1461, 'comcast.net', '1416722642249', '763'),
(1462, 'two.com', '1416719047679', '0'),
(1463, '192.168.2.1', '1416717624302', '1'),
(1464, '184.21.246.255', '1416722641098', '920'),
(1465, 'news.com', '1416719047614', '690'),
(1466, 'plesk.com', '1416720874448', '752'),
(1467, 'dishnetwork.net', '1416721065026', '705'),
(1468, 'dish.net', '1416721061675', '676'),
(1469, 'digitalpath.net', '1416719044585', '726'),
(1470, 'ufcrewards.com', '1416721066487', '672'),
(1471, 'facebook.com', '1416720872649', '785'),
(1472, 'reddit.com', '1416720875152', '704'),
(1473, 'sparkfun.com', '1416722644230', '678'),
(1474, 'directtv.com', '1416721065289', '399'),
(1475, 'twitter.com', '1416721064097', '769'),
(1476, 'cmich.edu', '1416721065196', '714'),
(1477, 'foxnews.com', '1416721063747', '706'),
(1478, 'evangel.edu', '1416721060938', '707'),
(1479, 'youtube.com', '1416722641634', '704'),
(1480, '7up.com', '1416720907934', '721'),
(1481, 'chicosystems.com', '1416719042605', '689'),
(1482, 'bbc.co.uk', '1416721062472', '805'),
(1483, 'stanford.edu', '1416722643310', '701'),
(1484, 'dishnetwork.com', '1416721063940', '711'),
(1485, 'imgur.com', '1416722641861', '773'),
(1486, 'speedtest.net', '1416721065627', '705'),
(1487, 'gmail.com', '1416719046583', '704'),
(1488, 'comcast.net', '1416722642249', '763'),
(1489, 'two.com', '1416719047679', '0'),
(1490, '192.168.2.1', '1416717624302', '1'),
(1491, '184.21.246.255', '1416722641098', '920'),
(1492, 'hotmail.com', '1416719046119', '700'),
(1493, 'hbo.net', '1416721063516', '707'),
(1494, 'earlhart.com', '1416719046589', '730'),
(1495, 'wargaming.net', '1416720915215', '685'),
(1496, 'he.net', '1416721064772', '759');

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE IF NOT EXISTS `year` (
`id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `time` text NOT NULL,
  `latency` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=268 ;

--
-- Dumping data for table `year`
--

INSERT INTO `year` (`id`, `ip`, `time`, `latency`) VALUES
(1, 'digitalpath.com', '1406417036175', '641'),
(2, 'news.com', '1406417037999', '644'),
(3, 'hbo.com', '1406417035147', '-1'),
(4, 'fightnight.com', '1406417038667', '-1'),
(5, 'news.net', '1406417039821', '-1'),
(6, 'myspace.com', '1406417034978', '629'),
(7, 'hello.org', '1406417039670', '-1'),
(8, 'gmail.com', '1406417037402', '635'),
(9, 'xnxx.com', '1406417035256', '-1'),
(10, 'hello.com', '1406417040902', '-1'),
(11, 'xhamster.com', '1406417034031', '731'),
(12, 'facebook.com', '1406417037169', '671'),
(13, 'microsoft.com', '1406417046164', '-1'),
(14, 'hello.net', '1406417041824', '-1'),
(15, 'reddit.com', '1406417036153', '644'),
(16, 'google.com', '1406417038137', '641'),
(17, 'new.com', '1406417036866', '643'),
(18, 'w3schools.com', '1406417029249', '-1'),
(19, 'hotmail.com', '1406417037392', '654'),
(20, 'youtube.com', '1406417038539', '633'),
(21, 'new.net', '1406417037151', '-1'),
(22, 'digitalpath.com', '1406684655800', '327'),
(23, 'digg.com', '1406685749251', '-1'),
(24, 'news.com', '1406683492877', '293'),
(25, 'three.com', '1406686835458', '456'),
(26, 'myspace.com', '1406683486579', '285'),
(27, 'news.net', '1406423892758', '-1'),
(28, 'plesk.com', '1406686126902', '336'),
(29, 'tiltservers.com', '1406686126496', '279'),
(30, 'digitalpath.net', '1406684711868', '338'),
(31, 'facebook.com', '1406683483074', '345'),
(32, 'reddit.com', '1406684044470', '315'),
(33, 'one.com', '1406686126170', '460'),
(34, 'youtube.com', '1406423890480', '640'),
(35, 'new.net', '1406423890477', '-1'),
(36, 'seven.com', '1406686126991', '288'),
(37, 'chicosystems.com', '1406685749551', '280'),
(38, 'five.com', '1406686127001', '-1'),
(39, 'fightnight.com', '1406423889989', '-1'),
(40, 'hbo.com', '1406423889798', '-1'),
(41, 'hello.org', '1406423889350', '-1'),
(42, 'gmail.com', '1406684032041', '288'),
(43, 'xnxx.com', '1406423888869', '-1'),
(44, 'hello.com', '1406423888531', '-1'),
(45, 'xhamster.com', '1406423890284', '757'),
(46, 'four.com', '1406686126876', '350'),
(47, 'two.com', '1406686126535', '-1'),
(48, 'microsoft.com', '1406423890184', '-1'),
(49, 'hello.net', '1406423889039', '-1'),
(50, 'tiltservers.net', '1406686126971', '0'),
(51, 'new.com', '1406423890335', '643'),
(52, 'google.com', '1406683864597', '285'),
(53, 'six.com', '1406686126381', '289'),
(54, 'w3schools.com', '1406423888527', '-1'),
(55, 'hotmail.com', '1406684032226', '332'),
(56, 'earlhart.com', '1406685297945', '0'),
(57, 'digitalpath.com', '1407293190229', '83'),
(58, 'digg.com', '1407249962437', '-1'),
(59, 'news.com', '1407249962269', '19'),
(60, 'five.com', '1407293188159', '-1'),
(61, 'three.com', '1407249961521', '183'),
(62, 'plesk.com', '1407249963617', '78'),
(63, 'myspace.com', '1407249960969', '15'),
(64, 'gmail.com', '1407249963520', '23'),
(65, 'tiltservers.com', '1407293189333', '0'),
(66, 'digitalpath.net', '1407293190309', '86'),
(67, 'four.com', '1407293188075', '89'),
(68, 'two.com', '1407249961281', '-1'),
(69, 'facebook.com', '1407249960798', '69'),
(70, 'tiltservers.net', '1407293188134', '0'),
(71, 'reddit.com', '1407249963613', '35'),
(72, 'one.com', '1407249965784', '185'),
(73, 'google.com', '1407249964644', '23'),
(74, 'six.com', '1407293191435', '21'),
(75, 'hotmail.com', '1407249964813', '64'),
(76, 'earlhart.com', '1407249961001', '0'),
(77, 'chicosystems.com', '1407249961112', '0'),
(78, 'seven.com', '1407293190138', '18'),
(79, 'two.com', '1407898056442', '-1'),
(80, 'digitalpath.com', '1407898055769', '77'),
(81, 'digg.com', '1407898056440', '-1'),
(82, 'news.com', '1407898055428', '18'),
(83, 'one.com', '1407898055448', '184'),
(84, 'plesk.com', '1407898055736', '73'),
(85, 'gmail.com', '1407898055626', '25'),
(86, 'hotmail.com', '1407898055711', '63'),
(87, 'earlhart.com', '1407898055733', '31'),
(88, 'digitalpath.net', '1407898055352', '81'),
(89, 'chicosystems.com', '1407898055709', '0'),
(90, 'digitalpath.com', '1408596901462', '64'),
(91, 'two.com', '1408596900794', '-1'),
(92, 'digg.com', '1408596901142', '-1'),
(93, 'news.com', '1408596900564', '18'),
(94, 'one.com', '1408596901402', '184'),
(95, 'plesk.com', '1408596900267', '67'),
(96, 'gmail.com', '1408596901603', '62'),
(97, 'hotmail.com', '1408596901401', '64'),
(98, 'earlhart.com', '1408596900232', '34'),
(99, 'digitalpath.net', '1408596900540', '69'),
(100, 'chicosystems.com', '1408596901563', '0'),
(101, 'two.com', '1409201784034', '-1'),
(102, 'digitalpath.com', '1409201783464', '64'),
(103, 'digg.com', '1409201783925', '-1'),
(104, 'news.com', '1409201783343', '11'),
(105, 'one.com', '1409201783187', '184'),
(106, 'plesk.com', '1409201783417', '56'),
(107, 'gmail.com', '1409201783205', '59'),
(108, 'hotmail.com', '1409201783125', '62'),
(109, 'earlhart.com', '1409201783465', '34'),
(110, 'digitalpath.net', '1409201783034', '67'),
(111, 'chicosystems.com', '1409201783018', '0'),
(112, 'digitalpath.com', '1409806669257', '64'),
(113, 'two.com', '1409806670898', '-1'),
(114, 'digg.com', '1409806669693', '-1'),
(115, 'news.com', '1409806669264', '1'),
(116, 'one.com', '1409806667018', '183'),
(117, 'plesk.com', '1409806668225', '57'),
(118, 'gmail.com', '1409806671269', '60'),
(119, 'hotmail.com', '1409806668106', '63'),
(120, 'earlhart.com', '1409806667995', '35'),
(121, 'digitalpath.net', '1409806669258', '68'),
(122, 'chicosystems.com', '1409806668088', '0'),
(123, 'two.com', '1410411546715', '-1'),
(124, 'digitalpath.com', '1410411546014', '63'),
(125, 'digg.com', '1410411546660', '-1'),
(126, 'news.com', '1410411546234', '1'),
(127, 'one.com', '1410411545896', '185'),
(128, 'plesk.com', '1410411545966', '58'),
(129, 'gmail.com', '1410411545997', '60'),
(130, 'hotmail.com', '1410411545950', '62'),
(131, 'earlhart.com', '1410411545980', '35'),
(132, 'digitalpath.net', '1410411546106', '66'),
(133, 'chicosystems.com', '1410411546119', '0'),
(134, 'digitalpath.com', '1411016428981', '64'),
(135, 'two.com', '1411016434912', '-1'),
(136, 'digg.com', '1411016432762', '-1'),
(137, 'news.com', '1411016431161', '1'),
(138, 'one.com', '1411016431024', '175'),
(139, 'plesk.com', '1411016432418', '60'),
(140, 'gmail.com', '1411016433435', '67'),
(141, 'hotmail.com', '1411016431201', '62'),
(142, 'earlhart.com', '1411016432242', '35'),
(143, 'digitalpath.net', '1411016431201', '66'),
(144, 'chicosystems.com', '1411016432317', '0'),
(145, 'two.com', '1411621320349', '-1'),
(146, 'digitalpath.com', '1411621319500', '64'),
(147, 'digg.com', '1411621320209', '-1'),
(148, 'news.com', '1411621319614', '1'),
(149, 'one.com', '1411621319346', '172'),
(150, 'plesk.com', '1411621319454', '50'),
(151, 'gmail.com', '1411621319501', '59'),
(152, 'hotmail.com', '1411621319490', '63'),
(153, 'earlhart.com', '1411621319634', '34'),
(154, 'digitalpath.net', '1411621319594', '66'),
(155, 'chicosystems.com', '1411621319598', '0'),
(156, 'digitalpath.com', '1412226211707', '66'),
(157, 'two.com', '1412226211526', '-1'),
(158, 'digg.com', '1412226209250', '-1'),
(159, 'news.com', '1412226212023', '2'),
(160, 'one.com', '1412226211477', '173'),
(161, 'plesk.com', '1412226208680', '42'),
(162, 'gmail.com', '1412226211838', '39'),
(163, 'hotmail.com', '1412226209769', '42'),
(164, 'earlhart.com', '1412226212124', '35'),
(165, 'digitalpath.net', '1412226211832', '68'),
(166, 'chicosystems.com', '1412226212968', '0'),
(167, 'two.com', '1412831096716', '-1'),
(168, 'digitalpath.com', '1412831096280', '66'),
(169, 'digg.com', '1412831096512', '-1'),
(170, 'news.com', '1412831096324', '3'),
(171, 'one.com', '1412831096068', '176'),
(172, 'plesk.com', '1412831096342', '42'),
(173, 'gmail.com', '1412831096281', '15'),
(174, 'hotmail.com', '1412831096235', '34'),
(175, 'earlhart.com', '1412831096573', '36'),
(176, 'digitalpath.net', '1412831096172', '67'),
(177, 'chicosystems.com', '1412831096245', '0'),
(178, 'two.com', '1413435989853', '-1'),
(179, 'digitalpath.com', '1413435988070', '68'),
(180, 'digg.com', '1413435988704', '-1'),
(181, 'news.com', '1413435988211', '9'),
(182, 'one.com', '1413435988324', '128'),
(183, 'plesk.com', '1413435988090', '44'),
(184, 'gmail.com', '1413435988105', '16'),
(185, 'hotmail.com', '1413435988296', '36'),
(186, 'earlhart.com', '1413435988182', '39'),
(187, 'digitalpath.net', '1413435988102', '71'),
(188, 'chicosystems.com', '1413435988261', '0'),
(189, 'two.com', '1414040872964', '-1'),
(190, 'digitalpath.com', '1414040874442', '86'),
(191, 'digg.com', '1414040873964', '-1'),
(192, 'news.com', '1414040874530', '21'),
(193, 'one.com', '1414040876856', '122'),
(194, 'plesk.com', '1414040873317', '73'),
(195, 'gmail.com', '1414040873383', '60'),
(196, 'hotmail.com', '1414040875596', '64'),
(197, 'earlhart.com', '1414040874649', '60'),
(198, 'digitalpath.net', '1414040872330', '83'),
(199, 'chicosystems.com', '1414040877759', '0'),
(200, 'two.com', '1414645763872', '-1'),
(201, 'digitalpath.com', '1414645763605', '71'),
(202, 'digg.com', '1414645764011', '-1'),
(203, 'news.com', '1414645763569', '4'),
(204, 'one.com', '1414645763617', '111'),
(205, 'plesk.com', '1414645763499', '60'),
(206, 'gmail.com', '1414645763398', '45'),
(207, 'hotmail.com', '1414645763517', '48'),
(208, 'earlhart.com', '1414645763633', '39'),
(209, 'digitalpath.net', '1414645763435', '70'),
(210, 'chicosystems.com', '1414645763662', '0'),
(211, 'two.com', '1415250655592', '-1'),
(212, 'digitalpath.com', '1415250657147', '64'),
(213, 'digg.com', '1415250657515', '-1'),
(214, 'news.com', '1415250655183', '1'),
(215, 'one.com', '1415250652948', '108'),
(216, 'plesk.com', '1415250653969', '40'),
(217, 'gmail.com', '1415250656084', '40'),
(218, 'hotmail.com', '1415250651774', '46'),
(219, 'earlhart.com', '1415250654990', '35'),
(220, 'digitalpath.net', '1415250655042', '65'),
(221, 'chicosystems.com', '1415250655091', '0'),
(222, 'two.com', '1415855540357', '-1'),
(223, 'digitalpath.com', '1415855539812', '68'),
(224, 'digg.com', '1415855540372', '-1'),
(225, 'news.com', '1415855539896', '4'),
(226, 'one.com', '1415855539536', '183'),
(227, 'plesk.com', '1415855539883', '44'),
(228, 'gmail.com', '1415855539798', '39'),
(229, 'hotmail.com', '1415855539872', '48'),
(230, 'earlhart.com', '1415855539743', '38'),
(231, 'digitalpath.net', '1415855539703', '68'),
(232, 'chicosystems.com', '1415855539775', '0'),
(233, 'digitalpath.com', '1416288158108', '616'),
(234, 'digg.com', '1416232312864', '0'),
(235, 'news.com', '1416595937005', '672'),
(236, 'dish.net', '1416721061675', '676'),
(237, 'plesk.com', '1416640048642', '740'),
(238, 'dishnetwork.net', '1416721065026', '705'),
(239, 'digitalpath.net', '1416595935624', '690'),
(240, 'ufcrewards.com', '1416721066487', '672'),
(241, 'facebook.com', '1416720872649', '785'),
(242, 'reddit.com', '1416720875152', '704'),
(243, 'sparkfun.com', '1416722644230', '678'),
(244, 'one.com', '1416235919525', '800'),
(245, 'directtv.com', '1416721065289', '399'),
(246, 'twitter.com', '1416721064097', '769'),
(247, 'cmich.edu', '1416721065196', '714'),
(248, 'foxnews.com', '1416721063747', '706'),
(249, 'evangel.edu', '1416721060938', '707'),
(250, 'youtube.com', '1416722641634', '704'),
(251, '7up.com', '1416720907934', '721'),
(252, 'chicosystems.com', '1416575414091', '666'),
(253, 'bbc.co.uk', '1416721062472', '805'),
(254, 'stanford.edu', '1416722643310', '701'),
(255, 'dishnetwork.com', '1416721063940', '711'),
(256, 'imgur.com', '1416722641861', '773'),
(257, 'speedtest.net', '1416721065627', '705'),
(258, 'gmail.com', '1416575417829', '672'),
(259, 'comcast.net', '1416722642249', '763'),
(260, 'two.com', '1416556800058', '0'),
(261, '192.168.2.1', '1416717624302', '1'),
(262, '184.21.246.255', '1416722641098', '920'),
(263, 'hotmail.com', '1416431784771', '648'),
(264, 'earlhart.com', '1416431790840', '673'),
(265, 'hbo.net', '1416721063516', '707'),
(266, 'wargaming.net', '1416720915215', '685'),
(267, 'he.net', '1416721064772', '759');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_devices`
--
ALTER TABLE `active_devices`
 ADD UNIQUE KEY `deviceId` (`deviceId`);

--
-- Indexes for table `configuration`
--
ALTER TABLE `configuration`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `day`
--
ALTER TABLE `day`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hour`
--
ALTER TABLE `hour`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minute`
--
ALTER TABLE `minute`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timers`
--
ALTER TABLE `timers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week`
--
ALTER TABLE `week`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `year`
--
ALTER TABLE `year`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `configuration`
--
ALTER TABLE `configuration`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `day`
--
ALTER TABLE `day`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31888;
--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `hour`
--
ALTER TABLE `hour`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=382331;
--
-- AUTO_INCREMENT for table `minute`
--
ALTER TABLE `minute`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18431755;
--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `timers`
--
ALTER TABLE `timers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `week`
--
ALTER TABLE `week`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1497;
--
-- AUTO_INCREMENT for table `year`
--
ALTER TABLE `year`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=268;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
