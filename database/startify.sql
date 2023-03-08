-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 16, 2020 at 05:13 PM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `startify`
--

-- --------------------------------------------------------

--
-- Table structure for table `review_setting_tbl`
--

CREATE TABLE `review_setting_tbl` (
  `id` varchar(20) NOT NULL,
  `auto_publish` int(11) NOT NULL DEFAULT '1',
  `receive_email_for_review` int(11) NOT NULL DEFAULT '1',
  `receive_email_addr` varchar(255) NOT NULL,
  `review_headline` varchar(255) NOT NULL DEFAULT 'Customer Reviews',
  `show_form_on_load` int(11) DEFAULT NULL,
  `review_form_title` varchar(255) NOT NULL DEFAULT 'CUSTOMER REVIEW',
  `review_link` varchar(900) NOT NULL DEFAULT 'Write a review',
  `summary_with_no_review` varchar(255) NOT NULL DEFAULT 'No reviews yet',
  `report_as_inappropriate` varchar(255) NOT NULL DEFAULT 'Report as Inappropriate',
  `report_as_inappropriate_mgs` varchar(255) NOT NULL DEFAULT 'Reported as Inappropriate message',
  `author_email` varchar(255) NOT NULL,
  `author_email_help_msg` varchar(255) NOT NULL,
  `author_email_type` varchar(255) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_name_help_msg` varchar(255) NOT NULL,
  `author_name_type` varchar(255) NOT NULL,
  `review_rating` varchar(255) NOT NULL,
  `review_title` varchar(255) NOT NULL,
  `review_title_help_msg` varchar(255) NOT NULL,
  `review_body` varchar(255) NOT NULL,
  `review_body_help_msg` varchar(255) NOT NULL,
  `submit_button` varchar(255) NOT NULL,
  `success_msg` varchar(255) NOT NULL,
  `err_msg` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review_setting_tbl`
--

INSERT INTO `review_setting_tbl` (`id`, `auto_publish`, `receive_email_for_review`, `receive_email_addr`, `review_headline`, `show_form_on_load`, `review_form_title`, `review_link`, `summary_with_no_review`, `report_as_inappropriate`, `report_as_inappropriate_mgs`, `author_email`, `author_email_help_msg`, `author_email_type`, `author_name`, `author_name_help_msg`, `author_name_type`, `review_rating`, `review_title`, `review_title_help_msg`, `review_body`, `review_body_help_msg`, `submit_button`, `success_msg`, `err_msg`, `created_at`, `updated_at`) VALUES
('1', 1, 1, 'demo@demo.com', 'CUSTOMER REVIEW FORM', 1, 'CUSTOMER RE', 'Write a review', 'No Reviews Yet!', 'report_as_inappropriate', 'report_as_inappropriate_mgs', 'rashmifartode@gmail.com', 'write the help message', '', 'author name', 'author help message', '', 'rating', 'title', 'write the title', 'review body', 'help message', 'submit button', 'Thank you! Your review is submitted.', 'Error! Try again.', '2020-03-16 09:56:11', '2020-03-04 05:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `review_tbl`
--

CREATE TABLE `review_tbl` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `review_title` varchar(700) NOT NULL,
  `body_of_review` text NOT NULL,
  `reply` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `replied_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review_tbl`
--

INSERT INTO `review_tbl` (`id`, `product_id`, `product_title`, `state`, `name`, `email`, `rating`, `review_title`, `body_of_review`, `reply`, `created_at`, `replied_at`) VALUES
(1, 4586491773059, 'Vega Round Brush (Color May Vary)', 'flagged', 'john doe', 'j.doe@gmailcom', 4, 'Good Quality product', 'Lorem Ipsum is simply   since the 1500s', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters', '2020-03-16 11:25:27', NULL),
(2, 4579328426115, 'U.S. POLO ASSN.', 'unpublished', 'jay', 'jay@demo.com', 4, 'Where does it come from?', 'There are many variations of passages of Lorem Ipsum available,', 'The standard Lorem Ipsum passage, used since the 1500s', '2020-03-16 11:26:20', NULL),
(3, 4586508845187, 'Carolina Herrera Good Girl Eau de Parfum, 50ml', 'flagged', 'rekha', 'rekha@r.com', 1, 'awesome', 'Now that we have covered the routes let\'s create the Contacts controller that will be', 'Now that we have covered the routes let\'s ', '2020-03-16 11:24:59', NULL),
(4, 4579323478147, 'short sleeve shirt', 'flagged', 'jaya', 'jaya@hook.com', 3, 'Add the following code', 'Add the following codeAdd the following code', 'Add the following codeAdd the following codeAdd the following codeAdd the following codeAdd the following code', '2020-03-16 11:27:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tokenTable`
--

CREATE TABLE `tokenTable` (
  `id` int(11) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `shop` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokenTable`
--

INSERT INTO `tokenTable` (`id`, `access_token`, `shop`, `created_at`) VALUES
(1, '4adb9af4518910f4a0fcc1416ae7576b', 'myshopify.com', '2020-03-05 13:02:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `review_setting_tbl`
--
ALTER TABLE `review_setting_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_tbl`
--
ALTER TABLE `review_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokenTable`
--
ALTER TABLE `tokenTable`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `review_tbl`
--
ALTER TABLE `review_tbl`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tokenTable`
--
ALTER TABLE `tokenTable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
