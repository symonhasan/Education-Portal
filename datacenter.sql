-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 26, 2019 at 07:42 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datacenter`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `privacy` varchar(100) NOT NULL,
  `server_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `title`, `privacy`, `server_id`) VALUES
(2, 'Inroduction To C++', 'public', 1),
(3, 'Introduction To Java', 'invite', 1),
(4, 'Data Structure ', 'public', 2),
(5, 'Discrete Math', 'public', 1),
(6, 'Operating System', 'public', 3),
(7, 'Web Development', 'public', 4),
(8, 'Laravel Framework', 'public', 4);

-- --------------------------------------------------------

--
-- Table structure for table `class_post`
--

CREATE TABLE `class_post` (
  `class_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_post`
--

INSERT INTO `class_post` (`class_id`, `post_id`, `post`) VALUES
(5, 1, 'Hello Everyone This Is My First Post. Welcome to the class. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pulvinar mi eu mi iaculis venenatis. Nunc consequat diam malesuada quam ornare, in maximus elit auctor. Pellentesque massa purus, gravida quis odio in, congue viverra sapien. Class aptent taciti sociosqu ad litora torquent '),
(5, 2, 'nteger augue velit, interdum nec eros vitae, dictum elementum sem. Morbi fringilla iaculis odio, nec pulvinar mi imperdiet non. Aenean dolor ligula, finibus sit a'),
(5, 3, 'Hac habitasse platea dictumst quisque sagittis purus sit. Ultrices gravida dictum fusce ut placerat. Pulvinar mattis nunc sed blandit libero volutpat sed. Malesuada fames ac turpis egestas integer eget aliquet nibh. Pretium vulputate sapien nec sagittis aliquam malesuada. Orci sagittis eu volutpat odio facilisis. Eget lorem dolor sed viverra ipsum nunc aliquet bibendum. Viverra accumsan in nisl nisi scelerisque eu ultrices vitae auctor. Vivamus arcu felis bibendum ut tristique. Ut tristique et egestas quis. In massa tempor nec feugiat. Amet justo donec enim diam vulputate ut. Euismod nisi porta lorem mollis aliquam ut porttitor. Sed adipiscing diam donec adipiscing tristique. Enim ut tellus elementum sagittis vitae et leo duis.');

-- --------------------------------------------------------

--
-- Table structure for table `class_tag`
--

CREATE TABLE `class_tag` (
  `class_id` int(11) NOT NULL,
  `tag` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_tag`
--

INSERT INTO `class_tag` (`class_id`, `tag`) VALUES
(2, 'c'),
(2, 'programming'),
(3, 'java'),
(3, 'oop'),
(3, 'programming'),
(4, 'cse'),
(4, 'data'),
(4, 'programming'),
(4, 'structure'),
(5, 'cse'),
(5, 'discrete'),
(5, 'math'),
(6, 'cse'),
(6, 'linux'),
(6, 'os'),
(7, 'bootstrap'),
(7, 'cse'),
(7, 'css'),
(7, 'html'),
(7, 'php'),
(7, 'programming'),
(8, 'cse'),
(8, 'html'),
(8, 'php'),
(8, 'programming');

-- --------------------------------------------------------

--
-- Table structure for table `enroll_count`
--

CREATE TABLE `enroll_count` (
  `class_id` int(11) NOT NULL,
  `member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enroll_count`
--

INSERT INTO `enroll_count` (`class_id`, `member`) VALUES
(2, 0),
(3, 0),
(4, 1),
(5, 2),
(6, 1),
(7, 0),
(8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `enroll_user`
--

CREATE TABLE `enroll_user` (
  `class_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enroll_user`
--

INSERT INTO `enroll_user` (`class_id`, `server_id`) VALUES
(4, 4),
(5, 4),
(5, 5),
(6, 4),
(8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `forum_post`
--

CREATE TABLE `forum_post` (
  `class_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post` varchar(10000) DEFAULT NULL,
  `ask_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_post`
--

INSERT INTO `forum_post` (`class_id`, `post_id`, `post`, `ask_id`) VALUES
(5, 1, 'Hello Brother!! Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4),
(5, 2, 'Hello Rakibul!! Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 5),
(5, 3, 'Hello Dear Student!! Hac habitasse platea dictumst quisque sagittis purus sit. Ultrices gravida dictum fusce ut placerat. Pulvinar mattis nunc sed blandit libero volutpat sed. Malesuada fames ac turpis egestas integer eget aliquet nibh. ', 1),
(5, 4, 'In metus vulputate eu scelerisque felis imperdiet proin fermentum. Habitasse platea dictumst vestibulum rhoncus est pellentesque elit ullamcorper. Porttitor eget dolor morbi non arcu risus quis varius. Dui accumsan sit amet nulla facilisi. At augue eget arcu dictum varius duis at consectetur. Amet venenatis urna cursus eget nunc scelerisque viverra mauris. In iaculis nunc sed augue lacus viverra vitae congue eu. Odio tempor orci dapibus ultrices in iaculis nunc sed. ', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_handle`
--

CREATE TABLE `user_handle` (
  `server_id` int(11) NOT NULL,
  `f_handle` varchar(100) NOT NULL,
  `t_handle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_handle`
--

INSERT INTO `user_handle` (`server_id`, `f_handle`, `t_handle`) VALUES
(1, 'symonhs', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `server_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`server_id`, `first_name`, `last_name`, `email`, `contact_no`) VALUES
(1, 'Symon', 'Hasan', 'symon@mail.com', '01237896145'),
(2, 'Ashiqur', 'Rahman', 'ashiq@mail.com', '01237894567'),
(3, 'Jannatul Ferdosi', 'Kongkon', 'jfk@mail.com', '01297568741'),
(4, 'Rakibul', 'Islam', 'rakib@mail.com', '01214318971'),
(5, 'Ripon', 'Khan', 'ripon@mail.com', '012345679087');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `server_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`server_id`, `username`, `password`) VALUES
(1, 'user1', 'password1'),
(2, 'user2', 'password2'),
(3, 'user3', 'password3'),
(4, 'user4', 'password4'),
(5, 'user5', 'password5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_post`
--
ALTER TABLE `class_post`
  ADD PRIMARY KEY (`class_id`,`post_id`);

--
-- Indexes for table `class_tag`
--
ALTER TABLE `class_tag`
  ADD PRIMARY KEY (`class_id`,`tag`);

--
-- Indexes for table `enroll_count`
--
ALTER TABLE `enroll_count`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `enroll_user`
--
ALTER TABLE `enroll_user`
  ADD PRIMARY KEY (`class_id`,`server_id`);

--
-- Indexes for table `forum_post`
--
ALTER TABLE `forum_post`
  ADD PRIMARY KEY (`class_id`,`post_id`);

--
-- Indexes for table `user_handle`
--
ALTER TABLE `user_handle`
  ADD PRIMARY KEY (`server_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`server_id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`server_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enroll_count`
--
ALTER TABLE `enroll_count`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_tag`
--
ALTER TABLE `class_tag`
  ADD CONSTRAINT `ctFKc` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`);

--
-- Constraints for table `user_handle`
--
ALTER TABLE `user_handle`
  ADD CONSTRAINT `uhFKui` FOREIGN KEY (`server_id`) REFERENCES `user_info` (`server_id`);

--
-- Constraints for table `user_login`
--
ALTER TABLE `user_login`
  ADD CONSTRAINT `user_loginFKuser_info` FOREIGN KEY (`server_id`) REFERENCES `user_info` (`server_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
