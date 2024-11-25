-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 18, 2024 at 10:22 AM
-- Server version: 10.5.8-MariaDB-1:10.5.8+maria~focal
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pndevworks_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`, `email`, `auth_key`, `password_reset_token`) VALUES
(2, 'admin', '32ff9ee7e841b26a966870c144fdcaec', 'Administrator', 'admin@localhost', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `publisher` varchar(64) NOT NULL,
  `author` varchar(128) NOT NULL,
  `year` int(4) NOT NULL,
  `subject_id` varchar(16) NOT NULL,
  `isbn` varchar(17) NOT NULL,
  `language` varchar(32) NOT NULL,
  `numofpages` varchar(32) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(200) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `publisher`, `author`, `year`, `subject_id`, `isbn`, `language`, `numofpages`, `price`, `description`, `image_path`, `featured`, `created_at`, `updated_at`) VALUES
(14869, 'Kumpulan Soal Unik Matematika 2', 'Grasindo', 'Tobi Moektijono', 2013, 'L', '', 'Indonesia', '', '5.00', '', 'uploads/14905.jpg', 0, '2014-04-15 15:54:52', NULL),
(14870, 'The Unseen Colors: Photographic Journeys into the Lives of Chinese Indonesians from 1972-2001', 'Petra Press', 'Photographer Paul Piollet; Design & Layout by Aristarchus P. Kuntjara', 2014, 'H', '', 'English & Mandarin', '153', '29.50', 'Photo journalism on the everyday life of Chinese Indonesians (Tionghoa).', 'uploads/14906.jpg', 0, '2014-10-11 01:08:55', NULL),
(14871, 'Etnis tionghoa dalam sejarah pendidikan masyarakat kota Surabaya', 'Universitas Airlangga', 'Shinta Devi Ika Santhi Rahayu', 2013, 'DS611', '9786027982840', 'Indonesian', '312', '11.00', 'History of ethnic Chinese in Surabaya in the context of education.', 'uploads/14907.jpg', 0, '2014-10-11 01:15:40', NULL),
(14872, 'Kebudayaan Dayak: Aktualisasi dan transformasi', 'Institut Dayakologi', 'Paulus Florus', 2010, 'H', '9795532995', 'Indonesian', 'xxxvi + 226', '12.00', 'Editor: Paulus Florus, Stepanus Djuweng, John Bamba, Nico Andasputra, Kata Pengantar: Dr. Michael R. Dove', 'uploads/1422096596-14908.jpg', 1, '2015-01-24 05:49:56', NULL),
(14873, 'Sisi gelap Kalimantan Barat : perseteruan etnis Dayak-Madura 1997.', 'Institut Dayakologi', 'Institut Studi Arus Informasi', 1997, 'H', '9798933184', 'Indonesian', 'x + 422', '12.00', 'Indonesian press coverage of the Dayak-Madurese ethnic conflict in Kalimantan Barat, West Kalimantan, in 1997.\r\n', 'uploads/1422097088-14909.jpg', 1, '2015-01-24 05:58:08', NULL),
(14874, 'Tradisi lisan Dayak : yang tergusur dan terlupakan', 'Institut Dayakologi', 'Institut Dayakologi', 2003, 'H', '9799778808', 'Indonesian', 'xvi + 175', '12.00', 'Discussing oral history of the Dayak people in Kalimantan, Borneo.\r\n', 'uploads/1422097244-14910.jpg', 1, '2015-01-24 06:00:44', NULL),
(14875, 'Indonesian heritage', 'BAB Publishing Indonesia', 'BAB Publishing Indonesia', 2016, 'A', '', 'Indonesia', '999', '330.00', 'There is no single source to turn to for information on Indonesia\'s heritage: its culture, history and natural wealth. Specialised sources are available for all fof these subjects, but no series of books has succeeded in establishing itself as an authorative general reference on Indonesia. More than 400 academics and specialists, from Indonesia and elsewhere, have been contracted to advise on and contribute to the series, which has been developed under the general guidance of a distinguished editorial advisory committee.This 10 volumes will bring together research on a wide variety of topics which translated in Bahasa Indonesia. Indonesian Heritage (Bahasa Indonesia version) will reach an audience within Indonesia, but as well it will be a way for Indonesians to reach out, to educate young people and adults in the region.\r\n<br>SEJARAH AWAL. ISBN 979-8926-13-7. Pages: 152 pp\r\n<br>\r\nMANUSIA DAN LINGKUNGAN. ISBN 979-8926-14-5. Pages: 152 pp\r\n<br>\r\nSEJARAH MODERN AWAL. ISBN 979-8926-15-3. Pages: 148 pp\r\n<br>\r\nTETUMBUHAN. ISBN 979-8926-16-1. Pages: 144 pp\r\n<br>\r\nMARGASATWA. ISBN 979-8926-17-X. Pages: 144 pp\r\n<br>\r\nARSITEKTUR. ISBN 979-8926-18-8. Pages: 142 pp\r\n<br>\r\nSENI RUPA. ISBN 979-8926-19-6. Pages: 144 pp\r\n<br>\r\nSENI PERTUNJUKAN. ISBN 979-8926-20-X. Pages: 144 pp\r\n<br>\r\nAGAMA DAN KEPERCAYAAN. ISBN 979-8926-21-8. Pages: 144 pp\r\n<br>\r\nBAHASA DAN SASTRA. ISBN 979-8926-22-6­. Pages: 144 pp', 'uploads/1521457531-bab indonesian heritage.gif', 1, '2018-03-02 10:18:18', '2018-03-19 11:07:04'),
(14876, 'Ensiklopedia Antikorupsi', 'Borobudur Inspira Nusantara', 'Borobudur Inspira Nusantara', 2015, 'A', '', 'Indonesia', '999', '255.00', '5 volumes\r\n', 'uploads/1521457286-Ensiklopedia AntiKORUPSI.jpg', 1, '2018-03-02 10:22:54', '2018-03-19 11:01:26'),
(14877, 'Seni budaya & warisan Indonesia', 'Aku Bisa', 'Aku Bisa', 2014, 'A', '', 'Indonesia', '999', '425.00', '12 volumes. Penulis: Lily Turangan, dkk • ISBN: 978-602-7706-39-2 • 12 Jiiid/set, Edisi luks • Total 1.897 halaman • Ukuran 21,5 x 29 cm • Jenis kertas isi: Matt paper 150 gr • Jenis kertas cover: Board no. 30 • Art carton 190 gr • 3.800 lebih foto & gambar Full color\r\n\r\nSeni Budaya & Warisan Indonesia merupakan rangkaian corak dan karakter bangsa Indonesia, Keindahan dan keunikan kebudayaan alam Indonesia adalah kekayaan yang tak ternilai harganya.\r\n\r\nDengan Seni Budaya & Warisan Indonesia pembaca dapat semakin mengenal, kemudian mencintai tanah air Indonesia dengan segala keragamannya.\r\n\r\nDiawali dengan pembahasan mengenai sejarah awal di nusantara, pembaca diajak mengenal sejarah modern, Flora, Fauna, Olah raga & Permainan, Agama & Kepercayaan, Manusia & Lingkungan Budaya, Bahasa & Sastra, Arsitektur, Seni Nasional, Seni Pertunjukan serta Teknologi.\r\n', 'uploads/1521457134-seni budaya dan warisan indonesia.jpg', 1, '2018-03-02 10:24:09', '2018-03-19 10:58:54'),
(14878, 'Ensiklopedia Jawa Barat', 'Lentera Abadi', 'Lentera Abadi', 2011, 'A', '', 'Indonesia', '999', '255.00', 'Ensiklopedia Jawa Barat (8 jilid/set, hardcover, full color)', 'uploads/1521456989-ensiklopedia jawa barat.jpg', 1, '2018-03-02 10:24:52', '2018-03-19 10:56:29'),
(14880, 'Indonesian Gas Development Plans Series 2017', 'Petromindo', 'Ministry of Energy and Mineral Resources', 2017, 'A', '', 'Indonesia', '999', '135.00', 'The Ministry of Energy and Mineral Resources has recently released two important books and one regulation regarding gas industry in Indonesia, which are: 1) the Natural Gas Balance 2016-2035; 2) the Master Plan of National Natural Gas Infrastructure 2016-2030; and 3) Ministerial Decree No. 1750 K/20/MEM/2017 on allocation of natural gas for electricity sector. These books contain details of information on gas supply-demand forecast, gas transportation network and its associated infrastructure development plans.\r\n\r\nAccording to the master plan, by 2030 Indonesia will add a total of 6,989 kilometers gas pipeline network (open access & downstream dedicated), two large and four mini liquefaction plants, eight floating storage and regasification units (FSRUs), 72 land based regasification facilities, eight CNG plants, 24 gas stations, and six LPG plants and its distribution facilities.', 'uploads/1521455007-indonesia development series oil 2017.png', 1, '2018-03-19 10:22:06', '2018-03-19 10:23:27');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `name` varchar(64) COLLATE latin1_general_ci NOT NULL COMMENT 'Country name'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='List of countries. This table is static most of the time.';

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`name`) VALUES
('Afghanistan'),
('Akrotiri'),
('Albania'),
('Algeria'),
('American Samoa'),
('Andorra'),
('Angola'),
('Anguilla'),
('Antarctica'),
('Antigua and Barbuda'),
('Arctic Ocean'),
('Argentina'),
('Armenia'),
('Aruba'),
('Ashmore and Cartier Islands'),
('Atlantic Ocean'),
('Australia'),
('Austria'),
('Azerbaijan'),
('Bahamas, The'),
('Bahrain'),
('Bangladesh'),
('Barbados'),
('Belarus'),
('Belgium'),
('Belize'),
('Benin'),
('Bermuda'),
('Bhutan'),
('Bolivia'),
('Bosnia and Herzegovina'),
('Botswana'),
('Bouvet Island'),
('Brazil'),
('British Indian Ocean Territory'),
('British Virgin Islands'),
('Brunei'),
('Bulgaria'),
('Burkina Faso'),
('Burma'),
('Burundi'),
('Cambodia'),
('Cameroon'),
('Canada'),
('Cape Verde'),
('Cayman Islands'),
('Central African Republic'),
('Chad'),
('Chile'),
('China'),
('Christmas Island'),
('Clipperton Island'),
('Cocos (Keeling) Islands'),
('Colombia'),
('Comoros'),
('Congo, Democratic Republic of the'),
('Congo, Republic of the'),
('Cook Islands'),
('Coral Sea Islands'),
('Costa Rica'),
('Cote d\'Ivoire'),
('Croatia'),
('Cuba'),
('Cyprus'),
('Czech Republic'),
('Denmark'),
('Dhekelia'),
('Djibouti'),
('Dominica'),
('Dominican Republic'),
('East Timor'),
('Ecuador'),
('Egypt'),
('El Salvador'),
('Equatorial Guinea'),
('Eritrea'),
('Estonia'),
('Ethiopia'),
('Falkland Islands (Islas Malvinas)'),
('Faroe Islands'),
('Fiji'),
('Finland'),
('France'),
('French Polynesia'),
('French Southern and Antarctic Lands'),
('Gabon'),
('Gambia, The'),
('Gaza Strip'),
('Georgia'),
('Germany'),
('Ghana'),
('Gibraltar'),
('Greece'),
('Greenland'),
('Grenada'),
('Guam'),
('Guatemala'),
('Guernsey'),
('Guinea'),
('Guinea-Bissau'),
('Guyana'),
('Haiti'),
('Heard Island and McDonald Islands'),
('Holy See (Vatican City)'),
('Honduras'),
('Hong Kong'),
('Hungary'),
('Iceland'),
('Iles Eparses'),
('India'),
('Indian Ocean'),
('Indonesia'),
('Iran'),
('Iraq'),
('Ireland'),
('Isle of Man'),
('Israel'),
('Italy'),
('Jamaica'),
('Jan Mayen'),
('Japan'),
('Jersey'),
('Jordan'),
('Kazakhstan'),
('Kenya'),
('Kiribati'),
('Korea, North'),
('Korea, South'),
('Kuwait'),
('Kyrgyzstan'),
('Laos'),
('Latvia'),
('Lebanon'),
('Lesotho'),
('Liberia'),
('Libya'),
('Liechtenstein'),
('Lithuania'),
('Luxembourg'),
('Macau'),
('Macedonia'),
('Madagascar'),
('Malawi'),
('Malaysia'),
('Maldives'),
('Mali'),
('Malta'),
('Marshall Islands'),
('Mauritania'),
('Mauritius'),
('Mayotte'),
('Mexico'),
('Micronesia, Federated States of'),
('Moldova'),
('Monaco'),
('Mongolia'),
('Montenegro'),
('Montserrat'),
('Morocco'),
('Mozambique'),
('Namibia'),
('Nauru'),
('Navassa Island'),
('Nepal'),
('Netherlands'),
('Netherlands Antilles'),
('New Caledonia'),
('New Zealand'),
('Nicaragua'),
('Niger'),
('Nigeria'),
('Niue'),
('Norfolk Island'),
('Northern Mariana Islands'),
('Norway'),
('Oman'),
('Pacific Ocean'),
('Pakistan'),
('Palau'),
('Panama'),
('Papua New Guinea'),
('Paracel Islands'),
('Paraguay'),
('Peru'),
('Philippines'),
('Pitcairn Islands'),
('Poland'),
('Portugal'),
('Puerto Rico'),
('Qatar'),
('Romania'),
('Russia'),
('Rwanda'),
('Saint Helena'),
('Saint Kitts and Nevis'),
('Saint Lucia'),
('Saint Pierre and Miquelon'),
('Saint Vincent and the Grenadines'),
('Samoa'),
('San Marino'),
('Sao Tome and Principe'),
('Saudi Arabia'),
('Senegal'),
('Serbia'),
('Seychelles'),
('Sierra Leone'),
('Singapore'),
('Slovakia'),
('Slovenia'),
('Solomon Islands'),
('Somalia'),
('South Africa'),
('South Georgia and the South Sandwich Islands'),
('Southern Ocean'),
('Spain'),
('Spratly Islands'),
('Sri Lanka'),
('Sudan'),
('Suriname'),
('Svalbard'),
('Swaziland'),
('Sweden'),
('Switzerland'),
('Syria'),
('Taiwan'),
('Tajikistan'),
('Tanzania'),
('Thailand'),
('Togo'),
('Tokelau'),
('Tonga'),
('Trinidad and Tobago'),
('Tunisia'),
('Turkey'),
('Turkmenistan'),
('Turks and Caicos Islands'),
('Tuvalu'),
('Uganda'),
('Ukraine'),
('United Arab Emirates'),
('United Kingdom'),
('United States'),
('United States Pacific Island Wildlife Refuges'),
('Uruguay'),
('Uzbekistan'),
('Vanuatu'),
('Venezuela'),
('Vietnam'),
('Virgin Islands'),
('Wake Island'),
('Wallis and Futuna'),
('West Bank'),
('Western Sahara'),
('Yemen'),
('Zambia'),
('Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `institution` varchar(64) NOT NULL,
  `address` text NOT NULL,
  `country` varchar(64) NOT NULL,
  `joined_at` datetime NOT NULL,
  `lastlogin_at` datetime DEFAULT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `phone`, `institution`, `address`, `country`, `joined_at`, `lastlogin_at`, `auth_key`, `password_reset_token`) VALUES
(913, 'wiliantoi', 'c6aaf608bc69c39be1313bd921f7a40e', 'wilianto.indra@gmail.com', 'Wilianto', 'Indrawan', '08562288023', 'Unpar', 'TKI', 'Indonesia', '2015-01-24 05:14:07', NULL, '', ''),
(922, 'pascal', '40f52f2b65c228e00af38e53f892421a', 'pascal@unpar.ac.id', 'Pascal Alfadian', 'Nugroho, M.Comp', '082130741832', 'Unpar', 'Jl. Ciumbuleuit No. 94, Bandung', 'Indonesia', '2015-11-02 20:44:21', NULL, '', ''),
(927, 'pascaldnartworks', 'af488aa268bbf62248d846ca6722c1ec', 'pascal@dnartworks.co.id', 'Pascal Alfadian', 'Nugroho, Technical Director', '082130741832', 'DNArtworks', 'Jl. Mohammad Toha Dalam I No. 2A, Bandung', 'Indonesia', '2016-03-30 08:09:45', NULL, '', ''),
(1011, 'pascallive', '7a9984fd22b7e1811fa1d6ad8afe1179', 'pascalalfadian@live.com', 'Pascal Alfadian', 'Nugroho', '082130741832', 'Personal', 'The Internet', 'Indonesia', '2017-12-09 00:13:48', NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(125) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Jia Xiang Hometown', '<p>Indonesia Book Vendor is proud to offer our first serial title: Jia Xiang Hometown. You can access the serial\'s info here: <a href=\"http://www.indonesiabookvendor.com/bookdetails.php?bookid=14780\">http://www.indonesiabookvendor.com/bookdetails.php?bookid=14780</a>&nbsp;We will be adding more periodical titles to our collection. Of course, you can always request any Indonesia-published title from us and we\'ll get it for you.</p>', '2015-01-15 03:14:42', '2015-01-15 03:48:49'),
(3, 'Book Requests', 'Not only INDONESIA BOOK VENDOR offers You Indonesian books from our collection, IBV also accept requests for books that are currently not in our database. \r\nAs long as the books are published in Indonesia, we will find it and have it ready for you in no time.\r\nTake advantage of this excellent feature to enhance your Indonesian book collections.', '2008-06-16 10:16:01', NULL),
(4, 'Merry Christmas \\\'08 & Happy New Year \\\'09!', 'Enjoy the holidays!', '2008-12-24 19:03:29', NULL),
(5, 'Indonesia Book Vendor celebrating one year!', 'Indonesia Book Vendor was established December 2006. We have past our one year mark. Our major project currently is assisting University of Hawaii Manoa replace their Indonesian collection lost in a flood. We have sent more than 200 books and hundreds are more to come.', '2008-01-15 08:53:49', NULL),
(6, 'Indonesia Book Vendor Provides DVD', 'Not only we serve your Indonesian book needs, Indonesia Book Vendor also serve your needs and requests for other medias related to Indonesia.\r\nWith the Indonesian movie industry experiencing a renaissance, many quality films has been made. These films are accessible to the world audience via subtitle feature in DVD formats. \r\n\r\nIndonesia Book Vendor provides the newest and also classic Indonesian feature films and documentaries in DVD format for your enjoyment.', '2009-05-20 22:06:45', NULL),
(7, 'Indonesia Book Vendor in Association of Asian Studies Conference', 'We were present at the 2009 Association of Asian Studies Conference in Chicago, 26-29 March 2009.', '2009-03-05 11:53:35', NULL),
(8, 'Indonesia Book Vendor participates in GOMC', 'Approached by a team of graduate students from the University of Hawai\\\'i at Manoa, we have agreed to be a part of their participation at the 2010 Google Online Marketing Challenge.\r\nWe\\\'ll see what creative ways they come up with to market Indonesian publication through the web.\r\nThank you for selecting Indonesia Book Vendor!', '2010-04-20 11:34:45', NULL),
(9, 'INDOPRENEUR USA Competition 2011', 'We are through to the second round and will submit our business plan for an expansion starting in 2012.\r\nThis is an exciting opportunity for Indonesia Book Vendor and the materials we carry to expand our promotion and understanding of Indonesia.\r\n\r\nDetails:\r\nhttp://indopreneur-usa.mekar.biz/news/54/announcement-47-concept-papers-that-eligible-to-submit-their-business-plans-and-fact-sheets', '2011-12-15 21:47:03', NULL),
(10, 'INDOPRENEUR USA Competition 2011 Update', 'We are shortlisted (Top 15) to be invited to meet with potential investors in Jakarta. Final announcement will be made sometime next week. Cross fingers!\r\n\r\nDetails: \r\nhttp://indopreneur-usa.mekar.biz/news/58/announcement-15-candidates-that-will-be-further-selected-as-the-finalists-maximum-10', '2012-01-14 22:28:08', NULL),
(11, 'Jia Xiang Hometown', 'Indonesia Book Vendor is proud to offer our first serial title: Jia Xiang Hometown. You can access the serial\\\'s info here:\r\nhttp://www.indonesiabookvendor.com/bookdetails.php?bookid=14780\r\n\r\nWe will be adding more periodical titles to our collection. Of course, you can always request any Indonesia-published title from us and we\\\'ll get it for you.', '2014-01-27 16:31:53', NULL),
(12, 'IBV Makeover Coming Soon!', 'Another year has turned. INDONESIA BOOK VENDOR is entering its 8th year. Time sure flies! We are working revamping our website and shall be rolling out a new interface soon. Bare with us as we go through the transition. Cheers & Happy New Year 2015!', '2015-01-11 20:38:59', NULL),
(13, 'Welcome to our new  website!', '<p>INDONESIA BOOK VENDOR (IBV) is now in its second web iteration. Please let us know if there is anything we can improve to make you experience better. Remember, we are here to serve YOUR INDONESIAN PUBLICATION NEEDS!</p>', '2016-08-31 03:44:11', NULL),
(14, 'Contact us!', '<p>If you have any questions or request, please email us at contact@indonesiabookvendor.com!</p>', '2019-03-03 14:15:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `sent_date` datetime DEFAULT NULL,
  `cancel_date` datetime DEFAULT NULL,
  `notes` text NOT NULL,
  `total` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `customer_id`, `order_date`, `sent_date`, `cancel_date`, `notes`, `total`) VALUES
(2, 913, '2015-01-24 05:31:46', NULL, NULL, 'This is the second test', '19.00'),
(3, 913, '2015-01-24 05:33:35', NULL, NULL, 'This is the second test', '19.00'),
(14, 922, '2015-11-02 20:49:09', NULL, NULL, '', '12.00'),
(23, 927, '2016-03-30 08:10:18', NULL, NULL, '', '12.00'),
(44, 1011, '2017-12-09 00:14:28', NULL, NULL, '', '11.00'),
(45, 1011, '2017-12-09 00:18:04', NULL, NULL, '', '11.00');

-- --------------------------------------------------------

--
-- Table structure for table `order_line`
--

CREATE TABLE `order_line` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_line`
--

INSERT INTO `order_line` (`id`, `order_id`, `book_id`, `qty`, `price`) VALUES
(3, 2, 14869, 1, '5.00'),
(5, 3, 14869, 1, '5.00'),
(18, 14, 14873, 1, '12.00'),
(30, 23, 14874, 1, '12.00'),
(56, 44, 14871, 1, '11.00'),
(57, 45, 14871, 1, '11.00');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `title` varchar(125) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'About Us', '<p>Indonesia Book Vendor was established in 2006 as a book vendor specializing in journals, monographs, periodicals, and all other publications published in Indonesian and indigenous languages of Indonesia. IBV specifically addresses the need of University Libraries in the United States, Asia Pacific, and Europe. In general, we also cater to individual, governmental, private, and other institutional needs for books about Indonesia in various disciplines.</p>\r\n<h2>Our Products</h2>\r\n<p>Recently published books from Indonesia cover a wide range of topics including history, culture, social, politics, economics, human rights issues, law, travel industry, hobbies, novel, literature, textbooks, newspapers, magazines, bulletins, journals, and many more. Aside from books, IBV also offers DVD, VCD, VHS, CD, and CR-Rom about, related to, or made in Indonesia(n).</p>\r\n<p>Types of Publications:</p>\r\n<ul>\r\n<li>General</li>\r\n<li>Books (monograph) from 18th century until now.</li>\r\n<li>Magazines from 19th century until now.</li>\r\n<li>Newspapers from 19th century until now.</li>\r\n<li>Special</li>\r\n<li>Dissertations from 18th century until now.</li>\r\n<li>Ancient scriptures and manuscripts in regional languages.</li>\r\n<li>Maps from 12th century until now.</li>\r\n<li>Ancient paintings.</li>\r\n<li>Microfilms and microfiches.</li>\r\n<li>Collection in Braille language.</li>\r\n</ul>\r\n<p>IBV links to&nbsp;more than 2,000,000 volumes of publication and media spread nationally at public libraries, privately-owned libraries, and through publishers under the Indonesian Publishers Association (IKAPI).</p>\r\n<p>&nbsp;</p>', '0000-00-00 00:00:00', '2016-08-31 03:49:02'),
(2, 'FAQ', '<h1 style=\"box-sizing: border-box; margin: 23px 0px 11.5px; font-size: 26px; font-family: Roboto, \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-weight: 400; line-height: 1.1; color: #444444; letter-spacing: 0.100000001490116px;\">Frequently Asked Questions</h1>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 1em; color: #666666; font-family: Roboto, \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 13px; letter-spacing: 0.100000001490116px; line-height: 23.9980010986328px;\"><strong style=\"box-sizing: border-box;\">How do I search for books?</strong><br style=\"box-sizing: border-box;\" />You can search by entering a query in the top left quick search text box of the page. If you need more specific query such as the author, publisher, etc; use the \"Search Book\" menu item on the left. You can also browse for books by its subject, author, or publisher.</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 1em; color: #666666; font-family: Roboto, \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 13px; letter-spacing: 0.100000001490116px; line-height: 23.9980010986328px;\"><strong style=\"box-sizing: border-box;\">Do I need to create an account to search for books?</strong><br style=\"box-sizing: border-box;\" />You do not need to create an account if you want to browse our collection. However, an account is needed should you like to order from us.</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 1em; color: #666666; font-family: Roboto, \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 13px; letter-spacing: 0.100000001490116px; line-height: 23.9980010986328px;\"><strong style=\"box-sizing: border-box;\">I have registered, but I don\'t know the password to login to the page.</strong><br style=\"box-sizing: border-box;\" />When you register, a random password is generated and sent to your email for verification. You should check your email and login with that password. Then, we recommend you to change your password afterwards.</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 1em; color: #666666; font-family: Roboto, \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 13px; letter-spacing: 0.100000001490116px; line-height: 23.9980010986328px;\"><strong style=\"box-sizing: border-box;\">I\'m still stuck</strong><br style=\"box-sizing: border-box;\" />Please&nbsp;<a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/page/contact-us\">Contact Us</a>.</p>', '2015-01-10 10:15:39', '2015-03-08 11:54:30'),
(3, 'Sitemap', '<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 11.5px; color: #666666; font-family: Roboto, \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 13px; letter-spacing: 0.100000001490116px; line-height: 23.9980010986328px;\">\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/home/index\">Home/Main</a></li>\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/page/\">Browse</a>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;\">\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/browse/subject\">Browse by Subject</a></li>\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/browse/author\">Browse by Author</a></li>\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/browse/publisher\">Browse by Publisher</a></li>\r\n</ul>\r\n</li>\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/page/about-us\">About Us</a></li>\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/page/contact\">Contact</a></li>\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/page/faq\">Frequently Asked Questions</a></li>\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/news/index\">News</a></li>\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/cart/view\">Shopping Cart</a></li>\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/register/index\">Register</a></li>\r\n<li style=\"box-sizing: border-box;\"><a style=\"box-sizing: border-box; color: #ff6b00; text-decoration: none; transition: all 0.2s; -webkit-transition: all 0.2s; background-color: transparent;\" href=\"http://localhost:8080/indonesiabookvendor/apps/page/customer\">Login</a></li>\r\n</ul>', '2015-03-08 11:54:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` varchar(16) CHARACTER SET utf8 NOT NULL COMMENT 'The code of this subject according to Library of Congress Classification System',
  `name` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT 'The text representation of the subject'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='List of subjects in LC System';

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`) VALUES
('A', 'General Works'),
('B', 'Philosophy, Psychology, and Religion'),
('C', 'Auxiliary Sciences of History'),
('D', 'General and Old World History'),
('DS', 'History of Asia'),
('DS611', 'History of Indonesia'),
('F', 'History of America, British, Dutch, French, and Latin America'),
('G', 'Geography, Anthropology, and Recreation'),
('H', 'Social Sciences'),
('J', 'Political Science'),
('K', 'Law'),
('L', 'Education'),
('M', 'Music'),
('N', 'Fine Arts'),
('P', 'Language and Literature'),
('Q', 'Science'),
('R', 'Medicine'),
('S', 'Agriculture'),
('T', 'Technology'),
('U', 'Military Science'),
('V', 'Naval Science'),
('Z', 'Bibliography, Library Science, and General Information Resources');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_line`
--
ALTER TABLE `order_line`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14881;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1023;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `order_line`
--
ALTER TABLE `order_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `fk_book_subject` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_line`
--
ALTER TABLE `order_line`
  ADD CONSTRAINT `fk_book_orderline` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_orderline` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
