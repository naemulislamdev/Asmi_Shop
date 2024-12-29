-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2024 at 02:50 AM
-- Server version: 8.0.39-cll-lve
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cleandemo_organic_king`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uninstall_files` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int NOT NULL DEFAULT '0',
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shop_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `role_id`, `photo`, `password`, `status`, `remember_token`, `email_token`, `created_at`, `updated_at`, `shop_name`) VALUES
(1, 'Admin', 'admin@gmail.com', '01629552892', 0, '1556780563user.png', '$2y$10$bvMVG9qQG2H90HfR3Wj8aeyTTK4t1lypd1.1PgP/At8qdEDYThI3O', 1, 'qNidp65uoyyCDTUuMy9AaAs606PuY8qhlf7jKzjW55QGx3pLRujLOHLM7e8I', NULL, '2018-02-28 23:27:08', '2020-11-19 04:40:00', 'Genius Store'),
(89, 'Developer', 'developer@gmail.com', '34534534', 16, '1568863396user-admin.png', '$2y$10$u.93l4y6wOz6vq3BlAxvU.LuJ16/uBQ9s2yesRGTWUtLRiQSwoH1C', 1, '3czQhrw2MSwbZCdxwFj8ZSXfOjOJ1uB0pYnNW5yyQtMavYiG5PlmFetPqqj8', NULL, '2019-09-18 21:23:16', '2019-09-18 21:23:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_languages`
--

CREATE TABLE `admin_languages` (
  `id` int NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rtl` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_languages`
--

INSERT INTO `admin_languages` (`id`, `is_default`, `language`, `file`, `name`, `rtl`) VALUES
(1, 1, 'English', '1567232745AoOcvCtY.json', '1567232745AoOcvCtY', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_conversations`
--

CREATE TABLE `admin_user_conversations` (
  `id` int NOT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('Ticket','Dispute') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_user_conversations`
--

INSERT INTO `admin_user_conversations` (`id`, `subject`, `user_id`, `message`, `created_at`, `updated_at`, `type`, `order_number`) VALUES
(4, 'Hello', 22, 'Hello Desc', '2024-08-10 22:31:58', '2024-08-10 22:31:58', 'Ticket', NULL),
(5, 'asdfasdf', 22, 'asdfa', '2024-08-10 22:44:53', '2024-08-10 22:44:53', 'Ticket', 'asdfasdf'),
(6, 'adsfad', 22, 'asfasdf', '2024-08-10 23:26:22', '2024-08-10 23:26:22', 'Dispute', 'gTy81717315508'),
(7, 'mostofa', 22, 'test ticket', '2024-08-20 13:58:47', '2024-08-20 13:58:47', 'Ticket', NULL),
(8, 'mostofa', 22, 'test', '2024-08-20 14:04:12', '2024-08-20 14:04:12', 'Dispute', 'ZWMY1724136674'),
(9, 'ABCCCCCCCsdsdf', 22, 'zdfvdf', '2024-08-25 16:02:42', '2024-08-25 16:02:42', 'Ticket', NULL),
(10, 'asdfa', 49, 'dfasf', '2024-09-04 03:33:53', '2024-09-04 03:33:53', NULL, NULL),
(11, 'zmzmmz', 22, 'znmzmzm', '2024-10-16 11:46:57', '2024-10-16 11:46:57', 'Ticket', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_messages`
--

CREATE TABLE `admin_user_messages` (
  `id` int NOT NULL,
  `conversation_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_user_messages`
--

INSERT INTO `admin_user_messages` (`id`, `conversation_id`, `message`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 4, 'Hello Desc', 22, '2024-08-10 22:31:58', '2024-08-10 22:31:58'),
(5, 4, 'asdfasfd', NULL, '2024-08-10 22:38:22', '2024-08-10 22:38:22'),
(6, 4, 'asdfasd', 22, '2024-08-10 22:43:54', '2024-08-10 22:43:54'),
(7, 5, 'asdfa', 22, '2024-08-10 22:44:53', '2024-08-10 22:44:53'),
(8, 6, 'asfasdf', 22, '2024-08-10 23:26:22', '2024-08-10 23:26:22'),
(9, 6, 'asdfasdfasdf', 22, '2024-08-10 23:29:09', '2024-08-10 23:29:09'),
(10, 6, 'asdfasdfasdf', 22, '2024-08-10 23:29:38', '2024-08-10 23:29:38'),
(11, 6, 'asdfadf', NULL, '2024-08-10 23:29:50', '2024-08-10 23:29:50'),
(12, 7, 'test ticket', 22, '2024-08-20 13:58:47', '2024-08-20 13:58:47'),
(13, 8, 'test', 22, '2024-08-20 14:04:12', '2024-08-20 14:04:12'),
(14, 8, 'hi how are you', NULL, '2024-08-20 14:04:45', '2024-08-20 14:04:45'),
(15, 8, 'I\'m fine. and you?', 22, '2024-08-20 14:05:17', '2024-08-20 14:05:17'),
(16, 8, 'awsome', NULL, '2024-08-20 14:05:39', '2024-08-20 14:05:39'),
(17, 9, 'zdfvdf', 22, '2024-08-25 16:02:42', '2024-08-25 16:02:42'),
(18, 10, 'dfasf', NULL, '2024-09-04 03:33:53', '2024-09-04 03:33:53'),
(19, 4, 'jjj', 22, '2024-10-07 14:11:06', '2024-10-07 14:11:06'),
(20, 11, 'znmzmzm', 22, '2024-10-16 11:46:57', '2024-10-16 11:46:57');

-- --------------------------------------------------------

--
-- Table structure for table `affliate_bonuses`
--

CREATE TABLE `affliate_bonuses` (
  `id` bigint NOT NULL,
  `refer_id` int NOT NULL,
  `bonus` double NOT NULL DEFAULT '0',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `arrival_sections`
--

CREATE TABLE `arrival_sections` (
  `id` int NOT NULL,
  `title` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `header` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `up_sale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `arrival_sections`
--

INSERT INTO `arrival_sections` (`id`, `title`, `header`, `photo`, `up_sale`, `url`, `created_at`, `updated_at`) VALUES
(3, 'MEN COLLECTION', 'New Autumn Arrival 2021', '1730268496Banner04-minpng.png', 'SALE UP TO 30%', 'https://cleandemo.geniusocean.net/organic-king', '2022-02-01 03:03:51.000000', '2024-10-30 13:08:16.000000'),
(4, 'EXO TRAVEL BAGS', 'BAGS AND SHOES', '1730268480banner06-minpng.png', 'SALE UP TO 50%', 'https://cleandemo.geniusocean.net/organic-king', '2022-02-01 04:08:01.000000', '2024-10-30 13:08:00.000000'),
(7, 'NEW ARRIVALS', 'Casual Shoes', '1730268458banner05-minpng.png', 'SALE UP TO 70%', 'https://cleandemo.geniusocean.net/organic-king', '2022-02-01 04:08:01.000000', '2024-10-30 13:07:48.000000');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int NOT NULL,
  `attributable_id` int DEFAULT NULL,
  `attributable_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `input_name` varchar(255) DEFAULT NULL,
  `price_status` int NOT NULL DEFAULT '1' COMMENT '0 - hide, 1- show	',
  `details_status` int NOT NULL DEFAULT '1' COMMENT '0 - hide, 1- show	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_options`
--

CREATE TABLE `attribute_options` (
  `id` int NOT NULL,
  `attribute_id` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int NOT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Large','TopSmall','BottomSmall') NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `photo`, `link`, `type`, `title`, `text`) VALUES
(3, '166323530463png.png', 'https://www.google.com/', 'BottomSmall', 'Beauty Essintial Product', 'Turpis pulvinar amet sodales. Dui eget interdum molestie vivamus tempus.'),
(9, '166323053459png.png', '#', 'TopSmall', 'Natural Cream', 'Banner Image SALE UPTO 50%'),
(10, '166323056960png.png', '#', 'TopSmall', 'Banner Image SALE UPTO 50%', 'Hair Cares'),
(11, '166323058961png.png', '#', 'TopSmall', 'Natural Oils', 'Banner Image SALE UPTO 50%'),
(12, '166323061062png.png', '#', 'TopSmall', 'Organic Tea', 'Banner Image SALE UPTO 50%'),
(13, '166323062760png.png', '#', 'TopSmall', 'Organic Tea', 'Banner Image SALE UPTO 50%'),
(14, '166323064059png.png', '#', 'TopSmall', 'Organic Tea', 'Banner Image SALE UPTO 50%'),
(15, '166323532764png.png', '#', 'BottomSmall', 'Banner Image SALE UPTO 30% Beauty Essintial Product', 'Banner Image SALE UPTO 30% Beauty Essintial Product Turpis pulvinar amet sodales. Dui eget interdum molestie vivamus tempus.');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int UNSIGNED NOT NULL,
  `category_id` int NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `meta_tag` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `category_id`, `title`, `slug`, `details`, `photo`, `source`, `views`, `status`, `meta_tag`, `meta_description`, `tags`, `created_at`) VALUES
(12, 2, 'How to design effective arts?', 'how-to-design-effective-artsLUx6', '<div align=\"justify\">The recording starts with the patter of a summer squall. Later, a \r\ndrifting tone like that of a not-quite-tuned-in radio station \r\n                                        rises and for a while drowns out\r\n the patter. These are the sounds encountered by NASA’s Cassini \r\nspacecraft as it dove \r\n                                        the gap between Saturn and its \r\ninnermost ring on April 26, the first of 22 such encounters before it \r\nwill plunge into \r\n                                        atmosphere in September. What \r\nCassini did not detect were many of the collisions of dust particles \r\nhitting the spacecraft\r\n                                        it passed through the plane of \r\nthe ringsen the charged particles oscillate in unison.<br><br></div><h3 align=\"justify\">How its Works ?</h3>\r\n                                    <p align=\"justify\">\r\n                                        MIAMI — For decades, South \r\nFlorida schoolchildren and adults fascinated by far-off galaxies, \r\nearthly ecosystems, the proper\r\n                                        ties of light and sound and \r\nother wonders of science had only a quaint, antiquated museum here in \r\nwhich to explore their \r\n                                        interests. Now, with the \r\nlong-delayed opening of a vast new science museum downtown set for \r\nMonday, visitors will be able \r\n                                        to stand underneath a suspended,\r\n 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, \r\nmahi mahi, devil\r\n                                        rays and other creatures through\r\n a 60,000-pound oculus. <br></p><p align=\"justify\">Lens that will give the impression of seeing the fish from the bottom of\r\n a huge cocktail glass. And that’s just one of many\r\n                                        attractions and exhibits. \r\nOfficials at the $305 million Phillip and Patricia Frost Museum of \r\nScience promise that it will be a \r\n                                        vivid expression of modern \r\nscientific inquiry and exposition. Its opening follows a series of \r\nsetbacks and lawsuits and a \r\n                                        scramble to finish the \r\n250,000-square-foot structure. At one point, the project ran \r\nprecariously short of money. The museum\r\n                                        high-profile opening is \r\nespecially significant in a state s <br></p><p align=\"justify\"><br></p><h3 align=\"justify\">Top 5 reason to choose us</h3>\r\n                                    <p align=\"justify\">\r\n                                        Mauna Loa, the biggest volcano \r\non Earth — and one of the most active — covers half the Island of \r\nHawaii. Just 35 miles to the \r\n                                        northeast, Mauna Kea, known to \r\nnative Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea \r\nlevel. To them it repre\r\n                                        sents a spiritual connection \r\nbetween our planet and the heavens above. These volcanoes, which have \r\nbeguiled millions of \r\n                                        tourists visiting the Hawaiian \r\nislands, have also plagued scientists with a long-running mystery: If \r\nthey are so close together, \r\n                                        how did they develop in two \r\nparallel tracks along the Hawaiian-Emperor chain formed over the same \r\nhot spot in the Pacific \r\n                                        Ocean — and why are their \r\nchemical compositions so different? \"We knew this was related to \r\nsomething much deeper,\r\n                                        but we couldn’t see what,” said \r\nTim Jones.\r\n                                    </p>', '164543360916423090171560403662beautiful-brown-hair-casual-1989252jpgjpg.jpg', 'www.geniusocean.com', 30, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-04-06 22:04:20'),
(13, 3, 'Creating an Engaging E-Commerce Experience: Interactive Features That Drive Sales', 'creating-an-engaging-e-commerce-experience-interactive-features-that-drive-salesCLnQ', '<p>In the competitive world of e-commerce, providing a static and unremarkable shopping experience is no longer sufficient. To capture and retain customers, businesses need to offer an engaging and interactive experience that sets them apart. Interactive features can enhance user engagement, increase conversion rates, and drive sales by making the shopping process more immersive and enjoyable. Here’s how you can integrate interactive elements into your e-commerce site to create a compelling and effective shopping experience.</p><p><br></p><h4><strong>1. Interactive Product Visualizations</strong></h4><ul><li><strong>360-Degree Product Views</strong>: Allow customers to view products from all angles with 360-degree rotating images. This feature gives users a comprehensive view of the product, helping them make informed purchasing decisions and reducing the likelihood of returns.</li><li><strong>Zoom and Pan Options</strong>: Implement zoom and pan functionalities to enable customers to closely examine product details. High-resolution images and the ability to zoom in on fine details enhance the shopping experience and build confidence in product quality.</li></ul><h4><strong>2. Virtual Try-Ons and Augmented Reality (AR)</strong></h4><ul><li><strong>Virtual Try-Ons</strong>: Integrate virtual try-on technology for products like clothing, accessories, and cosmetics. Customers can see how items look on them or in their environment before making a purchase, enhancing their confidence and satisfaction.</li><li><strong>AR Experiences</strong>: Use AR to allow customers to visualize products in their own space, such as furniture or home decor items. AR experiences make it easier for customers to imagine how products will fit into their lives, leading to higher conversion rates.</li></ul><h4><strong>3. Personalized Recommendations</strong></h4><ul><li><strong>Dynamic Product Recommendations</strong>: Implement algorithms that provide personalized product recommendations based on user behavior, preferences, and past purchases. Dynamic recommendations increase the likelihood of cross-selling and upselling, driving additional sales.</li><li><strong>Tailored Content</strong>: Use personalization to display relevant content, such as blog posts or videos, based on customer interests and browsing history. This keeps users engaged and encourages them to explore more of what your site has to offer.</li></ul><h4><strong>4. Interactive Quizzes and Product Finders</strong></h4><ul><li><strong>Product Quizzes</strong>: Create interactive quizzes to help customers find products that match their needs and preferences. For example, a quiz can guide users to the right skincare products based on their skin type or suggest the perfect gift based on their answers.</li><li><strong>Product Finders</strong>: Develop interactive product finders that allow users to filter and sort products based on various criteria, such as size, color, or price range. This feature enhances the shopping experience by helping users quickly find what they’re looking for.</li></ul><h4><strong>5. Live Chat and Chatbots</strong></h4><ul><li><strong>Live Chat Support</strong>: Offer live chat support to provide real-time assistance to customers. Live chat enables users to get immediate answers to their questions, resolve issues quickly, and receive personalized recommendations from customer service representatives.</li><li><strong>AI-Powered Chatbots</strong>: Use AI-powered chatbots to handle routine inquiries, guide users through the shopping process, and provide product recommendations. Chatbots offer 24/7 support and improve the efficiency of customer service.</li></ul><h4><strong>6. Interactive Reviews and Ratings</strong></h4><ul><li><strong>User-Generated Content</strong>: Encourage customers to leave reviews, ratings, and photos of products they’ve purchased. Displaying user-generated content adds credibility and helps potential buyers make informed decisions.</li><li><strong>Review Filtering</strong>: Implement interactive features that allow users to filter reviews based on ratings, keywords, or specific product attributes. This makes it easier for customers to find relevant feedback and assess product quality.</li></ul><h4><strong>7. Gamification Elements</strong></h4><ul><li><strong>Loyalty Programs</strong>: Incorporate gamification into your loyalty program by offering rewards, badges, and challenges. Engaging users through gamified elements encourages repeat purchases and fosters brand loyalty.</li><li><strong>Contests and Giveaways</strong>: Host interactive contests or giveaways that require user participation, such as sharing content or completing certain actions. This drives engagement, increases brand visibility, and attracts new customers.</li></ul><h4><strong>8. Interactive Shopping Carts</strong></h4><ul><li><strong>Cart Preview and Editing</strong>: Allow users to preview and edit their shopping cart without leaving the current page. Features like quick add/remove buttons and real-time updates enhance the convenience of the checkout process.</li><li><strong>Price Calculation Tools</strong>: Implement interactive tools that calculate potential savings, shipping costs, or applicable discounts in real-time. This transparency helps users make informed purchasing decisions and increases the likelihood of completing a transaction.</li></ul><h4><strong>9. Virtual Store Tours</strong></h4><ul><li><strong>Immersive Experiences</strong>: Create virtual store tours or 3D walkthroughs that allow customers to explore your store\'s layout and product offerings online. Virtual tours provide an engaging way for users to experience your store and browse products as if they were physically present.</li></ul><h4><strong>10. Social Proof and Engagement</strong></h4><ul><li><strong>Live Social Feeds</strong>: Integrate live social media feeds that showcase user-generated content, such as photos or reviews, directly on your site. This real-time social proof builds trust and encourages users to engage with your brand.</li><li><strong>Social Sharing Buttons</strong>: Include easy-to-use social sharing buttons on product pages and content to allow users to share their favorite items with their networks. Social sharing increases brand visibility and can drive additional traffic and sales.</li></ul><h3><strong>Conclusion</strong></h3><p>Creating an engaging e-commerce experience requires leveraging interactive features that captivate users and enhance their shopping journey. By incorporating product visualizations, virtual try-ons, personalized recommendations, and other interactive elements, you can provide a more immersive and enjoyable experience that drives higher conversions and fosters customer loyalty. Continuously evaluate and optimize these features based on user feedback and emerging trends to stay ahead in the competitive e-commerce landscape.</p>', '1724235850121679480182124-apple-watch-7-with-overlay-mockup-perspective-02jpg.jpg', 'www.geniusocean.com', 64, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-05-06 22:04:36'),
(15, 8, 'From Click to Cart: Optimizing Your Checkout Process for Higher Conversions', 'from-click-to-cart-optimizing-your-checkout-process-for-higher-conversions2R1D', '<div align=\"justify\"><br></div><div align=\"justify\"><p>The checkout process is a critical juncture in the e-commerce journey. It\'s where potential customers make the final commitment to purchase, and any friction during this stage can lead to abandoned carts and lost sales. Optimizing your checkout process is essential for maximizing conversions and ensuring a smooth, seamless experience for your customers. Here’s how to enhance your checkout process and drive higher conversions from click to cart.</p><p><br></p><p><br></p><h4><strong>1. Simplify the Checkout Process</strong></h4><ul><li><strong>Streamlined Steps</strong>: Reduce the number of steps required to complete a purchase. Aim for a single-page checkout or a multi-step process that is clear and efficient. Minimize distractions and unnecessary information fields.</li><li><strong>Guest Checkout Option</strong>: Allow customers to complete their purchase without creating an account. Offer account creation as an optional step after the transaction is complete, rather than making it mandatory.</li></ul><h4><strong>2. Optimize Form Fields</strong></h4><ul><li><strong>Minimize Data Entry</strong>: Only request essential information needed to complete the purchase. Avoid asking for unnecessary details that could deter customers from finishing the checkout.</li><li><strong>Auto-Fill and Validation</strong>: Implement auto-fill features to pre-populate fields with known information and use real-time validation to ensure data accuracy. Clearly highlight any errors and provide corrective suggestions.</li></ul><h4><strong>3. Enhance Mobile Usability</strong></h4><ul><li><strong>Responsive Design</strong>: Ensure that your checkout process is mobile-friendly, with a responsive design that adapts to different screen sizes. Test on various devices to confirm that the experience is smooth and accessible.</li><li><strong>Touch-Friendly Elements</strong>: Design form fields, buttons, and links to be easily tappable on touchscreens. Avoid small, closely spaced elements that can be difficult to interact with on mobile devices.</li></ul><h4><strong>4. Provide Clear and Transparent Pricing</strong></h4><ul><li><strong>Upfront Costs</strong>: Display all costs, including shipping, taxes, and fees, early in the checkout process. Avoid unexpected charges at the final step, which can lead to cart abandonment.</li><li><strong>Shipping Options</strong>: Offer a range of shipping options, including expedited and standard delivery. Clearly outline delivery times and costs for each option.</li></ul><h4><strong>5. Implement Trust-Building Features</strong></h4><ul><li><strong>Security Badges</strong>: Display security badges and encryption symbols to reassure customers that their personal and payment information is secure. Highlight any certifications or compliance with industry standards.</li><li><strong>Return Policy and Guarantees</strong>: Clearly communicate your return policy and any satisfaction guarantees. This helps build trust and reduces the perceived risk of making a purchase.</li></ul><h4><strong>6. Offer Multiple Payment Options</strong></h4><ul><li><strong>Diverse Payment Methods</strong>: Provide a variety of payment options, including credit/debit cards, digital wallets (e.g., Apple Pay, Google Pay), and alternative payment methods (e.g., PayPal). This accommodates different customer preferences and enhances convenience.</li><li><strong>Save Payment Information</strong>: Allow customers to save their payment information for future purchases, making the checkout process faster and easier on repeat visits.</li></ul><h4><strong>7. Optimize the Review and Confirmation Page</strong></h4><ul><li><strong>Order Summary</strong>: Provide a clear and detailed order summary on the review page, including item descriptions, quantities, prices, and shipping information. Allow customers to easily make changes if needed.</li><li><strong>Confirmation Message</strong>: Display a confirmation message after the purchase is complete, and provide an order number and estimated delivery time. Send a confirmation email with all relevant details for customer records.</li></ul><h4><strong>8. Implement Real-Time Support</strong></h4><ul><li><strong>Live Chat</strong>: Offer live chat support during the checkout process to assist customers with any questions or issues. Ensure that support is easily accessible and responsive.</li><li><strong>Help and FAQs</strong>: Provide links to help articles and FAQs related to the checkout process, such as payment issues or shipping inquiries. This allows customers to find answers quickly without leaving the checkout page.</li></ul><h4><strong>9. A/B Test and Analyze Performance</strong></h4><ul><li><strong>Conduct A/B Tests</strong>: Regularly test different variations of your checkout process to determine which elements lead to higher conversion rates. Test aspects such as form layouts, button placements, and call-to-action text.</li><li><strong>Analyze Data</strong>: Use analytics tools to monitor key metrics related to the checkout process, such as abandonment rates, completion times, and conversion rates. Identify any patterns or issues that may be affecting performance.</li></ul><h4><strong>10. Continuously Improve Based on Feedback</strong></h4><ul><li><strong>Customer Surveys</strong>: Collect feedback from customers who have completed a purchase, asking about their checkout experience. Use this feedback to identify areas for improvement and make necessary adjustments.</li><li><strong>Monitor Trends</strong>: Stay updated on industry best practices and emerging trends in e-commerce checkout optimization. Implement new strategies and technologies that can enhance the checkout experience.</li></ul><div><br></div><h3><strong>Conclusion</strong></h3><p>Optimizing your checkout process is crucial for maximizing conversions and ensuring a positive shopping experience for your customers. By simplifying steps, enhancing mobile usability, providing transparent pricing, and offering multiple payment options, you can create a seamless and efficient checkout experience that reduces cart abandonment and drives higher sales. Regularly test and analyze your checkout process, and continuously improve based on customer feedback to stay ahead in the competitive e-commerce landscape.</p></div>', '17242348852148542995jpg.jpg', 'www.geniusocean.com', 19, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-07-03 06:02:53'),
(16, 2, 'Building a Mobile-Friendly E-Commerce Site: Why It Matters and How to Do It', 'building-a-mobile-friendly-e-commerce-site-why-it-matters-and-how-to-do-itMvUf', '<div align=\"justify\"><br></div><div align=\"justify\"><p>In today’s digital landscape, mobile commerce is no longer a trend—it\'s a fundamental aspect of online shopping. With a growing number of consumers using smartphones and tablets to make purchases, having a mobile-friendly e-commerce site is essential for business success. A mobile-friendly site ensures that users have a seamless shopping experience regardless of the device they use. This guide explains why mobile optimization matters and provides actionable tips on how to create a mobile-friendly e-commerce site.</p><p><br></p><p><br></p><h4><strong>Why Mobile-Friendliness Matters</strong></h4><ol><li><p><strong>Increasing Mobile Usage</strong></p><ul><li><strong>Growing Trends</strong>: Mobile devices account for a significant portion of internet traffic and e-commerce sales. According to recent statistics, mobile commerce (m-commerce) continues to grow, with mobile users often outpacing desktop users in online shopping.</li><li><strong>Convenience</strong>: Mobile shopping offers convenience, allowing users to browse and make purchases anytime and anywhere. A mobile-friendly site caters to this demand and enhances the overall shopping experience.</li></ul></li><li><p><strong>Improved User Experience</strong></p><ul><li><strong>Responsive Design</strong>: A mobile-friendly site ensures that your content is displayed optimally on smaller screens. This prevents issues like horizontal scrolling, zooming, and distorted layouts, leading to a better user experience.</li><li><strong>Faster Load Times</strong>: Mobile users expect quick load times. A mobile-optimized site is designed to load efficiently, reducing bounce rates and keeping users engaged.</li></ul></li><li><p><strong>SEO and Search Rankings</strong></p><ul><li><strong>Google’s Mobile-First Indexing</strong>: Google prioritizes mobile-friendly sites in its search rankings. A mobile-optimized site improves your chances of ranking higher in search engine results, driving more organic traffic to your site.</li><li><strong>Enhanced Visibility</strong>: Mobile-friendly sites are more likely to be shared and linked to from mobile devices, increasing your site’s visibility and potential for traffic.</li></ul></li><li><p><strong>Higher Conversion Rates</strong></p></li><ul><li><strong>Streamlined Shopping Experience</strong>: A mobile-friendly site provides a seamless shopping experience, which can lead to higher conversion rates. Users are more likely to complete purchases when they encounter fewer obstacles and a smoother checkout process.</li><li><strong>Reduced Cart Abandonment</strong>: Mobile optimization helps reduce cart abandonment by ensuring that users can easily navigate the checkout process and complete transactions on their mobile devices.</li></ul></ol><div><br></div><h4><strong>How to Build a Mobile-Friendly E-Commerce Site</strong></h4><ol><li><p><strong>Adopt Responsive Design</strong></p><ul><li><strong>Fluid Layouts</strong>: Use fluid grids and flexible images to ensure your site adjusts automatically to different screen sizes. Responsive design allows your site to provide an optimal viewing experience across various devices.</li><li><strong>CSS Media Queries</strong>: Implement CSS media queries to apply different styles and layouts based on the device’s screen size, resolution, and orientation. This ensures that your site looks and functions well on both smartphones and tablets.</li></ul></li><li><p><strong>Optimize Page Speed</strong></p><ul><li><strong>Compress Images</strong>: Optimize image sizes to reduce load times without compromising quality. Use formats like WebP or JPEG 2000 for better compression and faster loading.</li><li><strong>Minimize Code</strong>: Clean up and minify HTML, CSS, and JavaScript code to reduce file sizes and improve load times. Avoid unnecessary scripts and plugins that can slow down your site.</li></ul></li><li><p><strong>Design for Touchscreen Interaction</strong></p><ul><li><strong>Touch-Friendly Elements</strong>: Ensure that buttons, links, and form fields are large enough to be easily tapped on touchscreens. Avoid small, closely spaced elements that can be difficult for users to interact with.</li><li><strong>Avoid Hover Effects</strong>: Hover effects are not suitable for touchscreens. Design interactive elements that work well with taps and swipes.</li></ul></li><li><p><strong>Streamline Navigation</strong></p><ul><li><strong>Simplified Menus</strong>: Use a mobile-friendly navigation menu, such as a hamburger menu, to keep the site’s structure clean and accessible. Ensure that users can easily find key sections and products.</li><li><strong>Search Functionality</strong>: Implement a prominent and easy-to-use search feature that allows users to quickly locate products. Consider using voice search options for added convenience.</li></ul></li><li><p><strong>Optimize the Checkout Process</strong></p><ul><li><strong>One-Page Checkout</strong>: Simplify the checkout process by consolidating it into a single page or minimizing the number of steps required to complete a purchase. Make the process as smooth and efficient as possible.</li><li><strong>Auto-Fill and Payment Options</strong>: Enable auto-fill for form fields and provide multiple payment options, including mobile wallets like Apple Pay and Google Pay, to streamline transactions.</li></ul></li><li><p><strong>Test and Optimize</strong></p><ul><li><strong>Mobile Testing</strong>: Regularly test your site on various mobile devices and browsers to ensure it functions correctly. Use tools like Google’s Mobile-Friendly Test to identify and address any issues.</li><li><strong>User Feedback</strong>: Gather feedback from mobile users to identify pain points and areas for improvement. Implement changes based on user feedback to enhance the mobile shopping experience.</li></ul></li><li><p><strong>Focus on Accessibility</strong></p><ul><li><strong>Readable Text</strong>: Ensure that text is large enough to be easily read on mobile screens without zooming. Use high-contrast colors for better readability.</li><li><strong>Accessible Forms</strong>: Design forms that are easy to complete on mobile devices. Include clear labels and instructions, and provide input fields that are appropriate for the type of data being entered (e.g., date pickers for dates).</li></ul></li></ol><h3><strong>Conclusion</strong></h3><p>Building a mobile-friendly e-commerce site is essential for catering to the growing number of mobile shoppers and ensuring a positive user experience. By adopting responsive design, optimizing page speed, and streamlining navigation and checkout processes, you can create a site that performs well on all devices. Embrace mobile optimization as a core component of your e-commerce strategy and watch as it drives increased engagement, higher conversion rates, and greater customer satisfaction.</p></div>', '1724234775567jpg.jpg', 'www.geniusocean.com', 12, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-08-03 06:03:14'),
(17, 3, 'Maximizing Your E-Commerce Potential: Tips for Boosting Online Sales', 'maximizing-your-e-commerce-potential-tips-for-boosting-online-saleshq7g', '<p>In the competitive world of e-commerce, standing out and driving sales requires more than just having a great product. It involves leveraging effective strategies to attract customers, enhance their shopping experience, and convert visits into purchases. Whether you\'re a seasoned online retailer or just starting, these actionable tips will help you maximize your e-commerce potential and boost your online sales.</p><p><br></p><h4><strong>1. Optimize Your Website for User Experience (UX)</strong></h4><ul><li><strong>Streamlined Navigation</strong>: Ensure that your website is easy to navigate with a clear menu and intuitive search function. A well-organized site helps customers find what they’re looking for quickly.</li><li><strong>Mobile Responsiveness</strong>: With an increasing number of consumers shopping on mobile devices, it’s crucial that your site is mobile-friendly. Test your website’s design and functionality across various devices and screen sizes.</li><li><strong>Fast Loading Times</strong>: Slow-loading pages can lead to high bounce rates. Optimize images and leverage content delivery networks (CDNs) to enhance page speed and provide a seamless shopping experience.</li></ul><h4><strong>2. Enhance Product Descriptions and Imagery</strong></h4><ul><li><strong>High-Quality Images</strong>: Use high-resolution images that showcase your products from multiple angles. Include zoom features and videos if possible to provide a comprehensive view.</li><li><strong>Detailed Descriptions</strong>: Write clear, engaging product descriptions that highlight key features, benefits, and specifications. Use persuasive language to address potential customer questions and concerns.</li></ul><h4><strong>3. Implement Effective SEO Strategies</strong></h4><ul><li><strong>Keyword Research</strong>: Identify and use relevant keywords throughout your website, including product titles, descriptions, and meta tags. This will help improve your site’s visibility in search engine results.</li><li><strong>Content Marketing</strong>: Create valuable content related to your products or industry, such as blog posts, guides, and how-tos. This not only attracts organic traffic but also establishes your brand as an authority in your niche.</li></ul><h4><strong>4. Utilize Data-Driven Marketing</strong></h4><ul><li><strong>Analyze Customer Behavior</strong>: Use analytics tools to track visitor behavior, conversion rates, and other key metrics. Understanding how customers interact with your site allows you to make data-driven decisions to improve performance.</li><li><strong>Personalized Marketing</strong>: Implement personalized email marketing campaigns and retargeting ads based on user behavior and purchase history. Personalization helps build stronger connections with your customers and encourages repeat purchases.</li></ul><h4><strong>5. Offer Promotions and Incentives</strong></h4><ul><li><strong>Discounts and Coupons</strong>: Provide special offers, discounts, and coupon codes to attract new customers and encourage repeat business. Highlight these promotions prominently on your website and in marketing materials.</li><li><strong>Loyalty Programs</strong>: Establish a rewards program to incentivize customer loyalty. Offer points, discounts, or exclusive access to new products as part of your loyalty scheme.</li></ul><h4><strong>6. Streamline the Checkout Process</strong></h4><ul><li><strong>Simplified Checkout</strong>: Reduce the number of steps required to complete a purchase. Offer guest checkout options and minimize the amount of information customers need to provide.</li><li><strong>Multiple Payment Options</strong>: Provide a variety of payment methods, including credit/debit cards, digital wallets, and alternative payment options, to accommodate different preferences.</li></ul><h4><strong>7. Provide Exceptional Customer Service</strong></h4><ul><li><strong>Live Chat Support</strong>: Implement live chat to provide real-time assistance and address customer queries quickly. This helps reduce cart abandonment and improve overall satisfaction.</li><li><strong>Clear Return and Refund Policies</strong>: Ensure that your return and refund policies are easy to understand and accessible. Transparent policies build trust and encourage customers to make purchases with confidence.</li></ul><h4><strong>8. Leverage Social Proof and Reviews</strong></h4><ul><li><strong>Customer Reviews</strong>: Display customer reviews and ratings on product pages. Positive reviews act as social proof and can significantly influence purchasing decisions.</li><li><strong>Influencer Partnerships</strong>: Collaborate with influencers or industry experts to promote your products. Their endorsements can expand your reach and attract new customers.</li></ul><h4><strong>9. Invest in Paid Advertising</strong></h4><ul><li><strong>PPC Campaigns</strong>: Use pay-per-click (PPC) advertising on platforms like Google Ads to drive targeted traffic to your site. Optimize your ad campaigns to ensure they reach the right audience.</li><li><strong>Social Media Ads</strong>: Run targeted ads on social media platforms like Facebook, Instagram, and Pinterest to reach potential customers based on their interests and demographics.</li></ul><h4><strong>10. Continuously Test and Improve</strong></h4><ul><li><strong>A/B Testing</strong>: Regularly conduct A/B tests on various elements of your website, such as headlines, images, and call-to-action buttons, to determine what performs best.</li><li><strong>Customer Feedback</strong>: Collect and analyze customer feedback to identify areas for improvement. Use surveys and reviews to gain insights into your customers’ experiences and preferences.</li></ul><h3><strong>Conclusion</strong></h3><p>Maximizing your e-commerce potential involves a multifaceted approach that combines user experience optimization, effective marketing strategies, and exceptional customer service. By implementing these tips and continuously refining your approach, you can boost your online sales and create a successful e-commerce business that stands out in a crowded market. Embrace these strategies, stay adaptable, and watch your sales soar.</p>', '172423441616426jpg.jpg', 'www.geniusocean.com', 67, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 06:03:37'),
(18, 2, 'The Power of Personalization: Tailoring the Shopping Experience for Your Customers', 'the-power-of-personalization-tailoring-the-shopping-experience-for-your-customersOXFz', '<p>In an age where consumers are bombarded with countless shopping options, personalization has emerged as a key differentiator for e-commerce success. Tailoring the shopping experience to individual preferences not only enhances customer satisfaction but also drives higher engagement and conversions. This guide explores how personalization can transform your e-commerce strategy and provides actionable tips for creating a more customized shopping experience.</p><p><br></p><p><br></p><h4><strong>Why Personalization Matters</strong></h4><p>Personalization goes beyond simply addressing customers by their names. It involves curating a shopping experience that feels tailored to each individual’s preferences, behaviors, and needs. Here’s why personalization is crucial for your e-commerce business:</p><ul><li><strong>Increased Engagement</strong>: Personalized experiences capture customers’ attention and make them feel valued, leading to higher engagement and longer time spent on your site.</li><li><strong>Higher Conversion Rates</strong>: When customers see products and recommendations that match their interests, they’re more likely to make a purchase.</li><li><strong>Enhanced Customer Loyalty</strong>: Personalization fosters a sense of connection and loyalty, encouraging repeat business and customer retention.</li><li><strong>Competitive Advantage</strong>: Offering a personalized shopping experience sets you apart from competitors who may provide a more generic approach.</li></ul><div><br></div><h4><strong>Strategies for Personalizing the Shopping Experience</strong></h4><ol><li><p><strong>Leverage Customer Data</strong></p><ul><li><strong>Behavioral Tracking</strong>: Use analytics tools to track customers’ browsing and purchasing behaviors. This data helps you understand their preferences and tailor product recommendations accordingly.</li><li><strong>Purchase History</strong>: Analyze customers’ past purchases to suggest relevant products and offer personalized discounts or promotions based on their buying patterns.</li></ul></li><li><p><strong>Implement Personalized Product Recommendations</strong></p><ul><li><strong>Dynamic Recommendations</strong>: Display product recommendations on your website based on customers’ browsing history, previous purchases, and similar items. This makes it easier for customers to discover products they’re likely to be interested in.</li><li><strong>Cross-Selling and Upselling</strong>: Suggest complementary or higher-end products during the shopping process, such as “Customers who bought this also bought” or “Recommended for you” sections.</li></ul></li><li><p><strong>Utilize Email Personalization</strong></p><ul><li><strong>Segmented Campaigns</strong>: Create targeted email campaigns based on customer segments, such as new subscribers, repeat buyers, or cart abandoners. Tailor the content to each segment’s specific interests and behaviors.</li><li><strong>Personalized Offers</strong>: Send personalized offers, discounts, and product recommendations via email based on customers’ past interactions and preferences.</li></ul></li><li><p><strong>Create a Customized User Experience</strong></p><ul><li><strong>Dynamic Content</strong>: Personalize website content based on users’ location, behavior, or previous interactions. For example, display region-specific promotions or welcome messages based on user activity.</li><li><strong>Personalized Landing Pages</strong>: Design landing pages that cater to different customer segments or interests, ensuring that the content and offers are relevant to each user.</li></ul></li><li><p><strong>Offer Personalized Customer Service</strong></p><ul><li><strong>Live Chat and Support</strong>: Use live chat or virtual assistants to provide personalized support and recommendations in real-time. Utilize customer data to offer tailored solutions and responses.</li><li><strong>Proactive Outreach</strong>: Reach out to customers with personalized follow-ups based on their shopping history or feedback. This demonstrates that you value their business and are attentive to their needs.</li></ul></li><li><p><strong>Enhance the Checkout Experience</strong></p><ul><li><strong>One-Click Reordering</strong>: Enable one-click reordering for customers who frequently purchase the same items. This simplifies the process and enhances convenience.</li><li><strong>Customizable Options</strong>: Allow customers to personalize products, such as choosing colors, sizes, or adding custom text. This adds a personal touch to their purchases.</li></ul></li><li><p><strong>Gather and Act on Customer Feedback</strong></p><ul><li><strong>Surveys and Reviews</strong>: Collect feedback through surveys and product reviews to understand customers’ preferences and experiences. Use this information to refine your personalization strategies and address any issues.</li><li><strong>Feedback Loops</strong>: Implement feedback loops that allow customers to provide input on their personalized experience. This helps you continuously improve and adapt to their needs.</li></ul></li><li><p><strong>Leverage AI and Machine Learning</strong></p><ul><li><strong>Predictive Analytics</strong>: Utilize AI and machine learning algorithms to predict customer preferences and behavior. This enables more accurate and effective personalization, such as predicting what products customers are likely to be interested in next.</li><li><strong>Automated Personalization</strong>: Implement AI-driven tools to automate personalization efforts, such as generating personalized product recommendations and dynamic content based on user data.</li></ul></li></ol><h3><strong>Conclusion</strong></h3><p>The power of personalization lies in its ability to create a shopping experience that resonates with each individual customer. By leveraging customer data, offering tailored recommendations, and enhancing the overall user experience, you can build stronger connections with your audience, increase engagement, and drive higher conversions. Embrace personalization as a core component of your e-commerce strategy and watch as it transforms the way customers interact with your brand.</p>', '17242346162148199484jpg.jpg', 'www.geniusocean.com', 231, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 06:03:59'),
(20, 2, 'How to Create an Irresistible E-Commerce Website: Design and UX Tips', 'how-to-create-an-irresistible-e-commerce-website-design-and-ux-tipsiUJO', '<p>Creating an irresistible e-commerce website is crucial for attracting and retaining customers in today’s competitive online market. Your website’s design and user experience (UX) play a significant role in converting visitors into buyers and ensuring a seamless shopping experience. Here’s a comprehensive guide to designing an e-commerce website that stands out and keeps customers coming back for more.</p><p><br></p><h4><strong>1. Prioritize User-Centric Design</strong></h4><ul><li><strong>Understand Your Audience</strong>: Conduct research to understand your target audience’s preferences, behaviors, and needs. Tailor your website’s design and functionality to meet these needs and provide a personalized experience.</li><li><strong>Simplicity and Clarity</strong>: Keep the design clean and straightforward. Avoid clutter and ensure that essential elements, such as navigation menus and product categories, are easily accessible.</li></ul><h4><strong>2. Optimize Navigation and Search</strong></h4><ul><li><strong>Intuitive Navigation</strong>: Organize your website’s navigation in a logical manner, using clear and descriptive labels for categories and subcategories. Ensure that users can easily find what they’re looking for with minimal clicks.</li><li><strong>Effective Search Functionality</strong>: Implement a robust search feature with autocomplete suggestions and filters to help users quickly locate products. Make sure the search results are relevant and accurately reflect user queries.</li></ul><h4><strong>3. Focus on High-Quality Visuals</strong></h4><ul><li><strong>Professional Images</strong>: Use high-resolution images that showcase your products from multiple angles. Consider incorporating zoom functionality and videos to give customers a detailed view.</li><li><strong>Consistent Branding</strong>: Maintain a consistent visual style that aligns with your brand identity. This includes using a cohesive color scheme, typography, and imagery to create a unified and professional look.</li></ul><h4><strong>4. Enhance Product Pages</strong></h4><ul><li><strong>Detailed Descriptions</strong>: Provide comprehensive product descriptions that highlight key features, benefits, and specifications. Use persuasive language to address potential customer questions and encourage conversions.</li><li><strong>Customer Reviews and Ratings</strong>: Display customer reviews and ratings on product pages to build trust and provide social proof. Positive reviews can significantly influence purchasing decisions.</li></ul><h4><strong>5. Simplify the Checkout Process</strong></h4><ul><li><strong>Streamlined Checkout</strong>: Minimize the number of steps required to complete a purchase. Use a single-page checkout or a progress indicator to make the process as smooth as possible.</li><li><strong>Multiple Payment Options</strong>: Offer various payment methods, including credit/debit cards, digital wallets, and alternative payment options. This flexibility accommodates different customer preferences and improves conversion rates.</li></ul><h4><strong>6. Implement Responsive Design</strong></h4><ul><li><strong>Mobile Optimization</strong>: Ensure that your website is fully responsive and performs well on mobile devices. Test your site’s design and functionality across different screen sizes and devices to provide a seamless experience for all users.</li><li><strong>Touch-Friendly Elements</strong>: Design interactive elements, such as buttons and forms, to be easily tappable on touchscreens. Avoid small buttons or links that can be difficult to click on mobile devices.</li></ul><h4><strong>7. Incorporate Clear Calls to Action (CTAs)</strong></h4><ul><li><strong>Prominent CTAs</strong>: Use clear and compelling calls to action throughout your website to guide users towards desired actions, such as “Add to Cart,” “Buy Now,” or “Sign Up.”</li><li><strong>Visual Hierarchy</strong>: Make your CTAs stand out by using contrasting colors, bold fonts, or buttons with ample white space around them. Ensure that CTAs are easily visible and strategically placed.</li></ul><h4><strong>8. Provide Exceptional Customer Support</strong></h4><ul><li><strong>Live Chat and Help Desks</strong>: Offer live chat support or an easily accessible help desk to assist customers with any questions or issues they may have. Quick and effective support can enhance the overall shopping experience.</li><li><strong>Comprehensive FAQs</strong>: Create a detailed FAQ section to address common customer queries about shipping, returns, and product information. This helps reduce customer frustration and provides valuable information.</li></ul><h4><strong>9. Focus on Page Speed and Performance</strong></h4><ul><li><strong>Fast Loading Times</strong>: Optimize images, use caching, and implement a content delivery network (CDN) to improve your website’s loading speed. Slow-loading pages can lead to high bounce rates and negatively impact user experience.</li><li><strong>Performance Monitoring</strong>: Regularly monitor your website’s performance and conduct speed tests to identify and address any issues that may affect user experience.</li></ul><h4><strong>10. Use Analytics to Drive Improvement</strong></h4><ul><li><strong>Track User Behavior</strong>: Implement analytics tools to track user behavior, such as page views, click-through rates, and conversion rates. Analyzing this data helps you understand how users interact with your site and identify areas for improvement.</li><li><strong>A/B Testing</strong>: Conduct A/B tests on various elements of your website, such as headlines, images, and CTAs, to determine what works best for your audience. Use the insights gained to make data-driven design decisions.</li></ul><div><br></div><h3><strong>Conclusion</strong></h3><p>Creating an irresistible e-commerce website involves a blend of effective design, user-centric functionality, and continuous optimization. By prioritizing user experience, focusing on high-quality visuals, and streamlining the checkout process, you can build a website that not only attracts visitors but also converts them into loyal customers. Implement these tips to enhance your e-commerce site and provide a seamless, enjoyable shopping experience that keeps customers coming back.</p>', '17242345112150312314jpg.jpg', 'www.geniusocean.com', 18, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-08-03 06:03:14');
INSERT INTO `blogs` (`id`, `category_id`, `title`, `slug`, `details`, `photo`, `source`, `views`, `status`, `meta_tag`, `meta_description`, `tags`, `created_at`) VALUES
(21, 6, 'Behind the Scenes: How We Curate Our Fashion Collections', 'behind-the-scenes-how-we-curate-our-fashion-collectionsw4UK', '<p>At Genius Ocean, curating a fashion collection isn’t just about picking out stylish pieces; it’s an intricate process that involves creativity, trend analysis, and a keen understanding of our customers\' needs. Our goal is to offer collections that are not only on-trend but also resonate with our audience, reflecting both current fashion movements and timeless elegance. Here’s a glimpse behind the scenes of how we bring our fashion collections to life.</p><p><br></p><h4><strong>The Curating Process: From Concept to Collection</strong></h4><ol><li><p><strong>Trend Research and Analysis</strong></p><ul><li><strong>Fashion Shows and Runways</strong>: We closely follow global fashion weeks and runway shows to identify emerging trends and styles. This helps us stay ahead of the curve and incorporate the latest fashion innovations into our collections.</li><li><strong>Industry Reports and Forecasts</strong>: We analyze fashion industry reports and trend forecasts to understand what will be popular in the upcoming seasons. This data-driven approach ensures that our collections align with future trends.</li><li><strong>Social Media and Influencers</strong>: We monitor social media platforms and fashion influencers to capture real-time trends and gain insights into what our target audience is excited about.</li></ul></li><li><p><strong>Identifying Core Themes</strong></p><ul><li><strong>Seasonal Inspiration</strong>: Each collection is inspired by the season, whether it’s the vibrant hues of spring, the cozy textures of winter, or the fresh patterns of summer. We select themes that reflect the spirit of the time of year.</li><li><strong>Cultural and Artistic Influences</strong>: We draw inspiration from art, culture, and global aesthetics to create unique and meaningful collections. This might include historical references, contemporary art movements, or global fashion influences.</li></ul></li><li><p><strong>Selecting Fabrics and Materials</strong></p><ul><li><strong>Quality and Sustainability</strong>: We prioritize high-quality fabrics that not only look great but also feel comfortable and last longer. Sustainability is a key focus, so we choose materials that are eco-friendly and ethically sourced.</li><li><strong>Textile Innovations</strong>: We stay updated on new textile technologies and innovations, incorporating them into our collections to offer cutting-edge fashion solutions.</li></ul></li><li><p><strong>Design and Development</strong></p><ul><li><strong>In-House Design Team</strong>: Our talented in-house designers work tirelessly to create original designs that reflect our curated themes. They balance creativity with practicality, ensuring each piece is both stylish and wearable.</li><li><strong>Prototypes and Sampling</strong>: We produce prototypes and samples to test the fit, fabric, and overall design. This stage allows us to make necessary adjustments and ensure that every item meets our quality standards.</li></ul></li><li><p><strong>Feedback and Refinement</strong></p><ul><li><strong>Focus Groups and Customer Feedback</strong>: We gather feedback from focus groups and our loyal customers to refine our designs and ensure they meet the needs and preferences of our audience.</li><li><strong>Market Testing</strong>: We test select pieces in smaller markets or through limited releases to gauge customer reactions and make final adjustments before launching the full collection.</li></ul></li><li><p><strong>Final Selection and Production</strong></p><ul><li><strong>Finalizing Designs</strong>: Once designs are refined and approved, we finalize the collection and prepare for production. This involves coordinating with manufacturers and ensuring that all pieces are produced to our exact specifications.</li><li><strong>Quality Control</strong>: Rigorous quality control checks are conducted throughout the production process to ensure that every item in the collection meets our high standards of quality and craftsmanship.</li></ul></li><li><p><strong>Marketing and Launch</strong></p><ul><li><strong>Campaign Planning</strong>: We develop marketing campaigns that highlight the unique aspects of the collection and create buzz leading up to the launch. This includes photo shoots, social media promotions, and influencer partnerships.</li><li><strong>Launch Events and Promotions</strong>: We plan engaging launch events and promotional activities to showcase the collection and connect with our audience. These events are designed to create excitement and drive sales.</li></ul></li></ol><h3><strong>Conclusion</strong></h3><p>The process of curating a fashion collection is a meticulous and passionate endeavor, involving many steps from trend research to final production. At Genius Ocean, we are committed to bringing you collections that are not only fashionable but also resonate with your personal style. By blending creativity with careful planning and quality control, we ensure that every collection we launch is something you’ll love and cherish. We invite you to explore our collections and experience the result of our dedicated curation process firsthand.</p>', '172423392512006jpg.jpg', 'www.geniusocean.com', 45, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 06:03:37'),
(22, 4, 'Fashion on a Budget: How to Look Chic Without Breaking the Bank', 'fashion-on-a-budget-how-to-look-chic-without-breaking-the-bank40BL', '<div align=\"justify\"><p>Looking chic and stylish doesn’t have to come with a hefty price tag. With the right strategies, you can build a fashionable wardrobe that reflects your personal style while staying within your budget. Whether you’re saving for something special or simply want to be more mindful of your spending, there are plenty of ways to achieve a high-end look without overspending. This guide will show you how to maximize your wardrobe, shop smart, and make the most of what you already own.</p><p><br></p><h4><strong>Why Budget-Friendly Fashion Matters</strong></h4><p>Fashion is often seen as a luxury, but it doesn’t have to be. Embracing budget-friendly fashion allows you to express your style creatively without the guilt of overspending. It also encourages more thoughtful purchasing decisions, focusing on quality, versatility, and longevity rather than fleeting trends.</p><p>Key benefits of fashion on a budget:</p><ul><li><strong>Financial Freedom</strong>: Spend wisely on fashion, allowing you to save for other priorities.</li><li><strong>Creative Expression</strong>: Learn to style what you have and discover new combinations that work for you.</li><li><strong>Sustainable Choices</strong>: Focus on purchasing less but better, contributing to more sustainable fashion practices.</li></ul><div><br></div><h4><strong>Top Tips for Looking Chic on a Budget</strong></h4><ol><li><p><strong>Invest in Timeless Pieces</strong></p><ul><li>Prioritize classic, versatile items that never go out of style, such as a little black dress, a tailored blazer, or a pair of well-fitting jeans.</li><li>These pieces can be mixed and matched, dressed up or down, and worn in multiple settings.</li></ul></li><li><p><strong>Shop Smart: Look for Sales and Discounts</strong></p><ul><li>Take advantage of sales, discounts, and clearance events to snag high-quality items at a fraction of the cost.</li><li>Sign up for newsletters from your favorite stores to receive exclusive deals and notifications of upcoming sales.</li></ul></li><li><p><strong>Thrift and Vintage Shopping</strong></p><ul><li>Explore thrift stores, consignment shops, and online secondhand platforms to find unique, budget-friendly fashion treasures.</li><li>Vintage pieces often offer better quality than fast fashion, and you can discover one-of-a-kind items that stand out.</li></ul></li><li><p><strong>Embrace DIY and Upcycling</strong></p><ul><li>Get creative by upcycling old clothes into new designs or altering thrift store finds to fit your style.</li><li>Simple DIY projects like adding embellishments, distressing jeans, or turning a large shirt into a dress can give your wardrobe a fresh update.</li></ul></li><li><p><strong>Focus on Fit and Tailoring</strong></p><ul><li>A perfectly tailored piece can make even the most affordable clothing look high-end. Invest in tailoring to ensure your clothes fit you perfectly.</li><li>Pay attention to how clothing fits when trying it on—avoid anything that doesn’t flatter your shape, regardless of the price.</li></ul></li><li><p><strong>Accessorize Wisely</strong></p><ul><li>Accessories can transform a simple outfit into something chic and stylish. Invest in versatile accessories like scarves, belts, and jewelry that can be used in multiple ways.</li><li>Mix high and low pieces—pair inexpensive clothing with a statement accessory to elevate your look.</li></ul></li><li><p><strong>Create a Capsule Wardrobe</strong></p><ul><li>Build a capsule wardrobe with a few carefully chosen pieces that you can mix and match to create multiple outfits.</li><li>Focus on neutral colors and timeless silhouettes that allow for easy coordination and layering.</li></ul></li><li><p><strong>Shop Off-Season</strong></p><ul><li>Purchase clothing off-season when prices are significantly lower. For example, buy winter coats in spring and summer dresses in fall.</li><li>This strategy requires planning ahead, but it can save you a lot of money in the long run.</li></ul></li><li><p><strong>Be Selective with Trends</strong></p><ul><li>Instead of buying into every new trend, choose one or two that you really love and find affordable versions.</li><li>Focus on trends that align with your personal style, ensuring that even trendier pieces will have longevity in your wardrobe.</li></ul></li><li><p><strong>Take Care of Your Clothes</strong></p><ul><li>Properly caring for your clothing extends its lifespan, saving you money on replacements.</li><li>Follow care instructions, avoid over-washing, and store your items properly to keep them looking their best.</li></ul></li></ol><h3><strong><br></strong></h3><h3><strong>Conclusion</strong></h3><p>Fashion on a budget is all about being resourceful and intentional with your choices. By focusing on timeless pieces, shopping smart, and taking care of what you own, you can build a chic, stylish wardrobe without breaking the bank. Remember, looking good doesn’t have to cost a fortune—it’s about how you style what you have, make savvy purchases, and embrace your creativity. With these tips, you’ll be able to dress fashionably while staying financially savvy.</p></div>', '1724233653183023jpg.jpg', 'www.geniusocean.com', 102, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 06:03:59'),
(23, 7, 'From Office to Outing: Versatile Outfits for the Modern Woman', 'from-office-to-outing-versatile-outfits-for-the-modern-womanAwP2', '<div align=\"justify\"><p>In today’s dynamic world, women are constantly juggling multiple roles—professional, personal, and social. Whether you\'re powering through meetings at the office, catching up with friends over dinner, or attending a last-minute event, your wardrobe needs to keep up with your busy lifestyle. The modern woman values versatility in her wardrobe, seeking pieces that can seamlessly transition from the workplace to an evening out.</p><p>Gone are the days of rigid dress codes that confine you to one style throughout the day. Now, it’s all about flexibility, creativity, and maximizing your wardrobe\'s potential. With the right selection of versatile pieces, you can move effortlessly between different environments, looking polished and put-together no matter the occasion.</p><p>This guide is designed to help you build a collection of outfits that are both stylish and functional, allowing you to maintain your professional edge during the day while easily transforming your look for after-hours activities. Whether you’re heading from a boardroom to a bar or from your desk to a dinner date, these outfit ideas will ensure you’re always dressed appropriately and fashionably.</p><p><br></p><h4><strong>Why Versatile Outfits Matter</strong></h4><p>Versatile outfits are the backbone of a functional wardrobe. They save you from the stress of changing multiple times a day and allow you to seamlessly blend into different environments without compromising on style or professionalism.</p><p>Key benefits of versatile outfits:</p><ul><li><strong>Time-Saving</strong>: Less time spent on outfit changes means more time for what matters.</li><li><strong>Cost-Effective</strong>: Investing in multifunctional pieces reduces the need for separate work and casual wardrobes.</li><li><strong>Stylish Simplicity</strong>: Effortlessly maintain a polished appearance, whether at work or play.</li></ul><h4><strong>Top Versatile Pieces for Your Wardrobe</strong></h4><ol><li><p><strong>The Classic Blouse</strong></p><ul><li><strong>Office</strong>: Pair with tailored trousers or a pencil skirt for a professional look.</li><li><strong>Outing</strong>: Swap the bottoms for jeans or a midi skirt and add statement jewelry for a more relaxed vibe.</li></ul></li><li><p><strong>The Tailored Blazer</strong></p><ul><li><strong>Office</strong>: Wear over a blouse or dress for a structured, corporate appearance.</li><li><strong>Outing</strong>: Throw it over a graphic tee and jeans for an edgy, casual look. Add heels or flats depending on the occasion.</li></ul></li><li><p><strong>The Midi Dress</strong></p><ul><li><strong>Office</strong>: Opt for a fitted or A-line midi dress in a neutral color, paired with pumps and minimal accessories.</li><li><strong>Outing</strong>: Add a belt to cinch the waist, swap out the pumps for ankle boots, and throw on a leather jacket for an evening-ready ensemble.</li></ul></li><li><p><strong>The Pencil Skirt</strong></p><ul><li><strong>Office</strong>: A classic pencil skirt paired with a blouse and heels is a go-to professional outfit.</li><li><strong>Outing</strong>: Pair with a tucked-in casual top, like a fitted tee or a stylish knit, and switch to ankle boots or flats.</li></ul></li><li><p><strong>The Structured Handbag</strong></p><ul><li><strong>Office</strong>: A sleek, structured handbag is perfect for carrying work essentials like a laptop, documents, and more.</li><li><strong>Outing</strong>: The same bag can double as a chic accessory for a night out—just remove any office-related items and add your evening essentials.</li></ul></li><li><p><strong>Comfortable Flats</strong></p><ul><li><strong>Office</strong>: Choose a pair of polished loafers or ballet flats that complement your professional attire.</li><li><strong>Outing</strong>: These same flats can easily be worn with jeans or a casual dress, ensuring comfort without sacrificing style.</li></ul></li><li><p><strong>The Wrap Dress</strong></p><ul><li><strong>Office</strong>: A wrap dress in a solid color or subtle print can be worn with a blazer and heels for a polished, office-appropriate look.</li><li><strong>Outing</strong>: Ditch the blazer, add some bold accessories, and switch to strappy sandals or wedges for a look that\'s perfect for dinner or drinks.</li></ul></li><li><p><strong>The Versatile Jumpsuit</strong></p><ul><li><strong>Office</strong>: Choose a tailored jumpsuit in a neutral shade, paired with a belt and heels for a sophisticated work outfit.</li><li><strong>Outing</strong>: Transition to an evening look by adding a statement necklace, a bold lip color, and swapping heels for stylish flats or mules.</li></ul></li><li><p><strong>Statement Jewelry</strong></p><ul><li><strong>Office</strong>: Stick to minimalist pieces like stud earrings or a simple necklace to maintain a professional appearance.</li><li><strong>Outing</strong>: Layer on bold, statement pieces to instantly elevate your look for a night out.</li></ul></li><li><p><strong>The Chic Scarf</strong></p><ul><li><strong>Office</strong>: A silk scarf can add a touch of elegance to a work outfit when worn around the neck or tied to a handbag.</li><li><strong>Outing</strong>: Use the same scarf as a headband, hair tie, or even a belt to add a fashionable flair to your evening ensemble.</li></ul></li></ol><h3><strong>Tips for Seamless Transitions</strong></h3><ul><li><strong>Layering</strong>: Start with a versatile base (like a blouse and trousers) and layer on pieces that can easily be removed or added, depending on the setting.</li><li><strong>Shoes and Accessories</strong>: Keep a pair of flats and statement accessories in your bag or car for a quick switch-up.</li><li><strong>Neutral Palette</strong>: Stick to a neutral color palette that allows for easy mixing and matching of pieces.</li></ul><h3><strong>Conclusion</strong></h3><p>For the modern woman, versatility in fashion is key to navigating a busy schedule with confidence and style. By incorporating these adaptable pieces into your wardrobe, you can create effortlessly chic outfits that take you from the office to any outing with ease. Remember, the goal is to feel comfortable and look fabulous, no matter where your day—or night—takes you.</p></div>', '172423321616431jpg.jpg', 'www.geniusocean.com', 23, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-08-03 06:03:14'),
(24, 3, 'Eating Organic on a Budget: 5 Affordable Meal Ideas', 'eating-organic-on-a-budget-5-affordable-meal-ideaszG7P', '<ul><li><ul><li><strong>Description:</strong> An overview of organic food and its unique benefits over conventional food, focusing on the environmental, health, and ethical reasons to choose organic.</li><li><strong>Details:</strong><ul><li>Explain what \"organic\" means, with insights on USDA standards.</li><li>Address common concerns and myths about organic food.</li><li>Offer statistics and facts to illustrate the impact of organic farming on health and sustainability.</li></ul></li></ul></li><li><p><strong>Post Title:</strong> \"How to Decode Organic Labels\"</p><ul><li><strong>Description:</strong> A helpful guide on how to read and understand organic certifications, labels, and what they truly signify.</li><li><strong>Details:</strong><ul><li>Break down the USDA organic seal and the difference between 100% organic and \"made with organic\" labels.</li><li>Include visuals of common labels and explain what each certification (Non-GMO Project, Fair Trade, etc.) means.</li></ul></li></ul></li></ul><hr><h4>2. <strong>Organic Recipes</strong></h4><ul><li><p><strong>Post Title:</strong> \"Eating Organic on a Budget: 5 Affordable Meal Ideas\"</p><ul><li><strong>Description:</strong> Budget-friendly organic recipes that use simple, cost-effective ingredients for everyday meals.</li><li><strong>Details:</strong><ul><li>List recipes like a veggie stir-fry, bean chili, and oat breakfast bowls.</li><li>Offer tips on where to find affordable organic ingredients.</li><li>Suggest ways to meal prep and store organic produce for longer shelf life.</li></ul></li></ul></li><li><p><strong>Post Title:</strong> \"Seasonal Organic Produce: Fall Recipes You’ll Love\"</p><ul><li><strong>Description:</strong> Highlight recipes that use fresh fall organic produce like pumpkins, apples, and squash.</li><li><strong>Details:</strong><ul><li>Include recipes for a pumpkin soup, apple crisp, and roasted squash salad.</li><li>Share tips on selecting and storing organic seasonal ingredients.</li><li>Discuss the environmental benefits of seasonal eating.</li></ul></li></ul></li></ul><hr><h4>3. <strong>Sustainable Living Tips</strong></h4><ul><li><p><strong>Post Title:</strong> \"10 Easy Ways to Go Green in Your Kitchen\"</p><ul><li><strong>Description:</strong> Practical tips for creating a sustainable kitchen environment, from reducing plastic to composting food scraps.</li><li><strong>Details:</strong><ul><li>Offer tips on swapping single-use plastics for reusable alternatives, setting up a compost bin, and buying in bulk.</li><li>Provide a list of eco-friendly storage containers and biodegradable bags.</li></ul></li></ul></li><li><p><strong>Post Title:</strong> \"How to Reduce Food Waste: An Organic Guide\"</p><ul><li><strong>Description:</strong> A step-by-step guide on reducing food waste with an organic twist, emphasizing meal planning and composting.</li><li><strong>Details:</strong><ul><li>Describe ways to store fresh produce to extend shelf life.</li><li>Share recipes using leftovers to reduce waste.</li><li>Offer guidance on composting organic waste for gardening.</li></ul></li></ul></li></ul>', '1730270023Image31-minpng.png', 'www.geniusocean.com', 44, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 06:03:37'),
(25, 2, 'Your Ultimate Guide to Organic Food, Sustainable Living', 'your-ultimate-guide-to-organic-food-sustainable-livingvpjs', '<p><strong>Goal:</strong> To educate and inspire readers on the benefits of organic food and a sustainable lifestyle, offering tips, recipes, gardening advice, and product recommendations that align with eco-friendly and health-conscious values.</p><hr><h3><strong>Categories and Initial Blog Post Ideas</strong></h3><hr><h4>1. <strong>Organic Food Basics</strong></h4><ul><li><p><strong>Post Title:</strong> \"The Organic Difference: Why Choose Organic Food?\"</p><ul><li><strong>Description:</strong> An overview of organic food and its unique benefits over conventional food, focusing on the environmental, health, and ethical reasons to choose organic.</li><li><strong>Details:</strong><ul><li>Explain what \"organic\" means, with insights on USDA standards.</li><li>Address common concerns and myths about organic food.</li><li>Offer statistics and facts to illustrate the impact of organic farming on health and sustainability.</li></ul></li></ul></li><li><p><strong>Post Title:</strong> \"How to Decode Organic Labels\"</p></li><ul><li><strong>Description:</strong> A helpful guide on how to read and understand organic certifications, labels, and what they truly signify.</li><li><strong>Details:</strong></li><ul><li>Break down the USDA organic seal and the difference between 100% organic and \"made with organic\" labels.</li><li>Include visuals of common labels and explain what each certification (Non-GMO Project, Fair Trade, etc.) means.</li></ul></ul><li><li><p><strong>Post Title:</strong> \"Eating Organic on a Budget: 5 Affordable Meal Ideas\"</p><ul><li><strong>Description:</strong> Budget-friendly organic recipes that use simple, cost-effective ingredients for everyday meals.</li><li><strong>Details:</strong><ul><li>List recipes like a veggie stir-fry, bean chili, and oat breakfast bowls.</li><li>Offer tips on where to find affordable organic ingredients.</li><li>Suggest ways to meal prep and store organic produce for longer shelf life.</li></ul></li></ul></li><li><p><strong>Post Title:</strong> \"Seasonal Organic Produce: Fall Recipes You’ll Love\"</p><ul><li><strong>Description:</strong> Highlight recipes that use fresh fall organic produce like pumpkins, apples, and squash.</li><li><strong>Details:</strong><ul><li>Include recipes for a pumpkin soup, apple crisp, and roasted squash salad.</li><li>Share tips on selecting and storing organic seasonal ingredients.</li><li>Discuss the environmental benefits of seasonal eating.</li></ul></li></ul></li></li></ul>', '1730269727Image30-minpng.png', 'https://cleandemo.geniusocean.net/organic-king', 96, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 06:03:59');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`) VALUES
(2, 'Green Living', 'Green-Living'),
(3, 'Nature’s Pantry', 'Nature’s-Pantry'),
(4, 'Business Help', 'business-help'),
(5, 'Random Thoughts', 'random-thoughts'),
(6, 'Mechanical', 'mechanical'),
(7, 'Entrepreneurs', 'entrepreneurs'),
(8, 'Technology', 'technology');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `status`, `photo`, `image`, `is_featured`) VALUES
(21, 'Fruits', 'Fruits', 1, NULL, '1730199988fresh-red-ripe-apple-isolated-closeup-minjpg.jpg', 1),
(22, 'Vegetables', 'Vegetables', 1, NULL, '1730199980green-lettuce-with-word-lettuce-it-minjpg.jpg', 1),
(23, 'Cheese', 'Cheese', 1, NULL, '1730199971red-cabbage-isolated-white-background-minjpg.jpg', 1),
(24, 'Breads', 'Breads', 1, NULL, '1730199961orange-with-green-leaf-it-is-shown-minjpg.jpg', 1),
(25, 'Nuts n Seeds', 'Nuts-n-Seeds', 1, NULL, '1730199939view-delicious-healthy-cantaloupe-melon-minjpg.jpg', 1),
(26, 'Sauces', 'Sauces', 1, NULL, '1730200017group-fresh-red-raspberries-with-green-leaves-white-background-minjpg.jpg', 1),
(27, 'Bean Mixes', 'Bean-Mixes', 1, NULL, '1730200047grapes-isolated-minjpg.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `childcategories`
--

CREATE TABLE `childcategories` (
  `id` int NOT NULL,
  `subcategory_id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `childcategories`
--

INSERT INTO `childcategories` (`id`, `subcategory_id`, `name`, `slug`, `status`) VALUES
(56, 76, 'Red Apples', 'Red-Apples', 1),
(57, 76, 'Green Apples', 'Green-Apples', 1),
(58, 76, 'Asian Pears', 'Asian-Pears', 1),
(59, 78, 'Bartlett Pears', 'Bartlett-Pears', 1),
(60, 77, 'Watermelon', 'Watermelon', 1),
(61, 77, 'Cantaloupe', 'Cantaloupe', 1),
(62, 77, 'Honeydew', 'Honeydew', 1),
(63, 78, 'Red Grapes', 'Red-Grapes', 1),
(64, 78, 'Green Grapes', 'Green-Grapes', 1),
(65, 78, 'Concord Grapes', 'Concord-Grapes', 1),
(66, 78, 'Muscadine Grapes', 'Muscadine-Grapes', 1),
(67, 79, 'Spinach', 'Spinach', 1),
(68, 79, 'Swiss Chard', 'Swiss-Chard', 1),
(69, 79, 'Arugula', 'Arugula', 1),
(70, 80, 'Potatoes', 'Potatoes', 1),
(71, 80, 'Carrots', 'Carrots', 1),
(72, 80, 'Radishes', 'Radishes', 1),
(73, 81, 'Broccoli', 'Broccoli', 1),
(74, 81, 'Cauliflower', 'Cauliflower', 1),
(75, 81, 'Cabbage', 'Cabbage', 1),
(76, 81, 'Brussels Sprouts', 'Brussels-Sprouts', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint NOT NULL,
  `state_id` int NOT NULL,
  `city_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `country_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `city_name`, `status`, `country_id`) VALUES
(1, 15, 'Comilla', 1, 0),
(2, 14, 'Uttara', 1, 0),
(3, 14, 'Mirpur', 1, 0),
(4, 14, 'Gazipur', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int NOT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_user` int NOT NULL,
  `recieved_user` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `subject`, `sent_user`, `recieved_user`, `message`, `created_at`, `updated_at`) VALUES
(5, 'Hello', 13, 22, 'asdfasdf', '2024-09-03 03:54:34', '2024-09-03 03:54:34'),
(6, 'shhshsh', 22, 22, 'zssz', '2024-10-16 12:19:13', '2024-10-16 12:19:13'),
(7, 'sbbnns', 22, 13, 'sbnsnana', '2024-10-16 12:19:37', '2024-10-16 12:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `counters`
--

CREATE TABLE `counters` (
  `id` int NOT NULL,
  `type` enum('referral','browser') NOT NULL DEFAULT 'referral',
  `referral` varchar(255) DEFAULT NULL,
  `total_count` int NOT NULL DEFAULT '0',
  `todays_count` int NOT NULL DEFAULT '0',
  `today` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `counters`
--

INSERT INTO `counters` (`id`, `type`, `referral`, `total_count`, `todays_count`, `today`) VALUES
(1, 'referral', 'www.facebook.com', 6, 0, NULL),
(2, 'referral', 'geniusocean.com', 926, 0, NULL),
(3, 'browser', 'Windows 10', 7621, 0, NULL),
(4, 'browser', 'Linux', 258, 0, NULL),
(5, 'browser', 'Unknown OS Platform', 2868, 0, NULL),
(6, 'browser', 'Windows 7', 504, 0, NULL),
(7, 'referral', 'yandex.ru', 15, 0, NULL),
(8, 'browser', 'Windows 8.1', 556, 0, NULL),
(9, 'referral', 'www.google.com', 12, 0, NULL),
(10, 'browser', 'Android', 641, 0, NULL),
(11, 'browser', 'Mac OS X', 634, 0, NULL),
(12, 'referral', 'l.facebook.com', 4, 0, NULL),
(13, 'referral', 'codecanyon.net', 6, 0, NULL),
(14, 'browser', 'Windows XP', 2, 0, NULL),
(15, 'browser', 'Windows 8', 3, 0, NULL),
(16, 'browser', 'iPad', 6, 0, NULL),
(17, 'browser', 'Ubuntu', 10, 0, NULL),
(18, 'browser', 'iPhone', 53, 0, NULL),
(19, 'referral', 'www.sandbox.paypal.com', 8, 0, NULL),
(20, 'referral', 'baidu.com', 1, 0, NULL),
(21, 'referral', 'org.telegram.messenger', 3, 0, NULL),
(22, 'referral', 'm.facebook.com', 7, 0, NULL),
(23, 'referral', 'ravemodal-dev.herokuapp.com', 1, 0, NULL),
(24, 'referral', 'checkout.stripe.com', 3, 0, NULL),
(25, 'referral', '127.0.0.1', 40, 0, NULL),
(26, 'referral', 'ravesandboxapi.flutterwave.com', 1, 0, NULL),
(27, 'referral', '9geezy.com', 1, 0, NULL),
(28, 'referral', 'connect.facebook.net', 3, 0, NULL),
(29, 'referral', 'localhost', 2, 0, NULL),
(30, 'browser', 'Windows Server 2003/XP x64', 3, 0, NULL),
(31, 'referral', 'demo.geniusocean.com', 12, 0, NULL),
(32, 'referral', 'web.skype.com', 5, 0, NULL),
(33, 'referral', 'niko-home.com', 3, 0, NULL),
(34, 'referral', 'i-office.co', 2, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  `tax` double NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`, `tax`, `status`) VALUES
(1, 'AF', 'Afghanistan', 0, 1),
(2, 'AL', 'Albania', 0, 1),
(3, 'DZ', 'Algeria', 0, 1),
(4, 'DS', 'American Samoa', 0, 0),
(5, 'AD', 'Andorra', 0, 0),
(6, 'AO', 'Angola', 0, 0),
(7, 'AI', 'Anguilla', 0, 0),
(8, 'AQ', 'Antarctica', 0, 0),
(9, 'AG', 'Antigua and Barbuda', 0, 0),
(10, 'AR', 'Argentina', 0, 0),
(11, 'AM', 'Armenia', 0, 0),
(12, 'AW', 'Aruba', 0, 0),
(13, 'AU', 'Australia', 0, 1),
(14, 'AT', 'Austria', 0, 1),
(15, 'AZ', 'Azerbaijan', 0, 0),
(16, 'BS', 'Bahamas', 0, 0),
(17, 'BH', 'Bahrain', 0, 0),
(18, 'BD', 'Bangladesh', 5, 1),
(19, 'BB', 'Barbados', 0, 0),
(20, 'BY', 'Belarus', 0, 1),
(21, 'BE', 'Belgium', 0, 0),
(22, 'BZ', 'Belize', 0, 0),
(23, 'BJ', 'Benin', 0, 0),
(24, 'BM', 'Bermuda', 0, 0),
(25, 'BT', 'Bhutan', 0, 0),
(26, 'BO', 'Bolivia', 0, 0),
(27, 'BA', 'Bosnia and Herzegovina', 0, 0),
(28, 'BW', 'Botswana', 0, 0),
(29, 'BV', 'Bouvet Island', 0, 0),
(30, 'BR', 'Brazil', 0, 0),
(31, 'IO', 'British Indian Ocean Territory', 0, 0),
(32, 'BN', 'Brunei Darussalam', 0, 0),
(33, 'BG', 'Bulgaria', 0, 0),
(34, 'BF', 'Burkina Faso', 0, 0),
(35, 'BI', 'Burundi', 0, 0),
(36, 'KH', 'Cambodia', 0, 0),
(37, 'CM', 'Cameroon', 0, 0),
(38, 'CA', 'Canada', 0, 0),
(39, 'CV', 'Cape Verde', 0, 0),
(40, 'KY', 'Cayman Islands', 0, 0),
(41, 'CF', 'Central African Republic', 0, 0),
(42, 'TD', 'Chad', 0, 0),
(43, 'CL', 'Chile', 0, 0),
(44, 'CN', 'China', 0, 0),
(45, 'CX', 'Christmas Island', 0, 0),
(46, 'CC', 'Cocos (Keeling) Islands', 0, 0),
(47, 'CO', 'Colombia', 0, 0),
(48, 'KM', 'Comoros', 0, 0),
(49, 'CD', 'Democratic Republic of the Congo', 0, 0),
(50, 'CG', 'Republic of Congo', 0, 0),
(51, 'CK', 'Cook Islands', 0, 0),
(52, 'CR', 'Costa Rica', 0, 0),
(53, 'HR', 'Croatia (Hrvatska)', 0, 0),
(54, 'CU', 'Cuba', 0, 0),
(55, 'CY', 'Cyprus', 0, 0),
(56, 'CZ', 'Czech Republic', 0, 0),
(57, 'DK', 'Denmark', 0, 0),
(58, 'DJ', 'Djibouti', 0, 0),
(59, 'DM', 'Dominica', 0, 0),
(60, 'DO', 'Dominican Republic', 0, 0),
(61, 'TP', 'East Timor', 0, 0),
(62, 'EC', 'Ecuador', 0, 0),
(63, 'EG', 'Egypt', 0, 0),
(64, 'SV', 'El Salvador', 0, 0),
(65, 'GQ', 'Equatorial Guinea', 0, 0),
(66, 'ER', 'Eritrea', 0, 0),
(67, 'EE', 'Estonia', 0, 0),
(68, 'ET', 'Ethiopia', 0, 0),
(69, 'FK', 'Falkland Islands (Malvinas)', 0, 0),
(70, 'FO', 'Faroe Islands', 0, 0),
(71, 'FJ', 'Fiji', 0, 0),
(72, 'FI', 'Finland', 0, 0),
(73, 'FR', 'France', 0, 0),
(74, 'FX', 'France, Metropolitan', 0, 0),
(75, 'GF', 'French Guiana', 0, 0),
(76, 'PF', 'French Polynesia', 0, 0),
(77, 'TF', 'French Southern Territories', 0, 0),
(78, 'GA', 'Gabon', 0, 0),
(79, 'GM', 'Gambia', 0, 0),
(80, 'GE', 'Georgia', 0, 0),
(81, 'DE', 'Germany', 0, 1),
(82, 'GH', 'Ghana', 0, 0),
(83, 'GI', 'Gibraltar', 0, 0),
(84, 'GK', 'Guernsey', 0, 0),
(85, 'GR', 'Greece', 0, 0),
(86, 'GL', 'Greenland', 0, 0),
(87, 'GD', 'Grenada', 0, 0),
(88, 'GP', 'Guadeloupe', 0, 0),
(89, 'GU', 'Guam', 0, 0),
(90, 'GT', 'Guatemala', 0, 0),
(91, 'GN', 'Guinea', 0, 0),
(92, 'GW', 'Guinea-Bissau', 0, 0),
(93, 'GY', 'Guyana', 0, 0),
(94, 'HT', 'Haiti', 0, 0),
(95, 'HM', 'Heard and Mc Donald Islands', 0, 0),
(96, 'HN', 'Honduras', 0, 0),
(97, 'HK', 'Hong Kong', 0, 0),
(98, 'HU', 'Hungary', 0, 0),
(99, 'IS', 'Iceland', 0, 0),
(100, 'IN', 'India', 0, 1),
(101, 'IM', 'Isle of Man', 0, 0),
(102, 'ID', 'Indonesia', 0, 0),
(103, 'IR', 'Iran (Islamic Republic of)', 0, 0),
(104, 'IQ', 'Iraq', 0, 0),
(105, 'IE', 'Ireland', 0, 0),
(106, 'IL', 'Israel', 0, 0),
(107, 'IT', 'Italy', 0, 0),
(108, 'CI', 'Ivory Coast', 0, 0),
(109, 'JE', 'Jersey', 0, 0),
(110, 'JM', 'Jamaica', 0, 0),
(111, 'JP', 'Japan', 0, 0),
(112, 'JO', 'Jordan', 0, 0),
(113, 'KZ', 'Kazakhstan', 0, 0),
(114, 'KE', 'Kenya', 0, 0),
(115, 'KI', 'Kiribati', 0, 0),
(116, 'KP', 'Korea, Democratic People\'s Republic of', 0, 0),
(117, 'KR', 'Korea, Republic of', 0, 0),
(118, 'XK', 'Kosovo', 0, 0),
(119, 'KW', 'Kuwait', 0, 0),
(120, 'KG', 'Kyrgyzstan', 0, 0),
(121, 'LA', 'Lao People\'s Democratic Republic', 0, 0),
(122, 'LV', 'Latvia', 0, 0),
(123, 'LB', 'Lebanon', 0, 0),
(124, 'LS', 'Lesotho', 0, 0),
(125, 'LR', 'Liberia', 0, 0),
(126, 'LY', 'Libyan Arab Jamahiriya', 0, 0),
(127, 'LI', 'Liechtenstein', 0, 0),
(128, 'LT', 'Lithuania', 0, 0),
(129, 'LU', 'Luxembourg', 0, 0),
(130, 'MO', 'Macau', 0, 0),
(131, 'MK', 'North Macedonia', 0, 0),
(132, 'MG', 'Madagascar', 0, 0),
(133, 'MW', 'Malawi', 0, 0),
(134, 'MY', 'Malaysia', 0, 0),
(135, 'MV', 'Maldives', 0, 0),
(136, 'ML', 'Mali', 0, 0),
(137, 'MT', 'Malta', 0, 0),
(138, 'MH', 'Marshall Islands', 0, 0),
(139, 'MQ', 'Martinique', 0, 0),
(140, 'MR', 'Mauritania', 0, 0),
(141, 'MU', 'Mauritius', 0, 0),
(142, 'TY', 'Mayotte', 0, 0),
(143, 'MX', 'Mexico', 0, 0),
(144, 'FM', 'Micronesia, Federated States of', 0, 0),
(145, 'MD', 'Moldova, Republic of', 0, 0),
(146, 'MC', 'Monaco', 0, 0),
(147, 'MN', 'Mongolia', 0, 0),
(148, 'ME', 'Montenegro', 0, 0),
(149, 'MS', 'Montserrat', 0, 0),
(150, 'MA', 'Morocco', 0, 0),
(151, 'MZ', 'Mozambique', 0, 0),
(152, 'MM', 'Myanmar', 0, 0),
(153, 'NA', 'Namibia', 0, 0),
(154, 'NR', 'Nauru', 0, 0),
(155, 'NP', 'Nepal', 0, 0),
(156, 'NL', 'Netherlands', 0, 0),
(157, 'AN', 'Netherlands Antilles', 0, 0),
(158, 'NC', 'New Caledonia', 0, 0),
(159, 'NZ', 'New Zealand', 0, 0),
(160, 'NI', 'Nicaragua', 0, 0),
(161, 'NE', 'Niger', 0, 0),
(162, 'NG', 'Nigeria', 0, 1),
(163, 'NU', 'Niue', 0, 0),
(164, 'NF', 'Norfolk Island', 0, 0),
(165, 'MP', 'Northern Mariana Islands', 0, 0),
(166, 'NO', 'Norway', 0, 0),
(167, 'OM', 'Oman', 0, 0),
(168, 'PK', 'Pakistan', 0, 0),
(169, 'PW', 'Palau', 0, 0),
(170, 'PS', 'Palestine', 0, 0),
(171, 'PA', 'Panama', 0, 0),
(172, 'PG', 'Papua New Guinea', 0, 0),
(173, 'PY', 'Paraguay', 0, 0),
(174, 'PE', 'Peru', 0, 0),
(175, 'PH', 'Philippines', 0, 0),
(176, 'PN', 'Pitcairn', 0, 0),
(177, 'PL', 'Poland', 0, 0),
(178, 'PT', 'Portugal', 0, 0),
(179, 'PR', 'Puerto Rico', 0, 0),
(180, 'QA', 'Qatar', 0, 0),
(181, 'RE', 'Reunion', 0, 0),
(182, 'RO', 'Romania', 0, 0),
(183, 'RU', 'Russian Federation', 0, 1),
(184, 'RW', 'Rwanda', 0, 0),
(185, 'KN', 'Saint Kitts and Nevis', 0, 0),
(186, 'LC', 'Saint Lucia', 0, 0),
(187, 'VC', 'Saint Vincent and the Grenadines', 0, 0),
(188, 'WS', 'Samoa', 0, 0),
(189, 'SM', 'San Marino', 0, 0),
(190, 'ST', 'Sao Tome and Principe', 0, 0),
(191, 'SA', 'Saudi Arabia', 0, 0),
(192, 'SN', 'Senegal', 0, 0),
(193, 'RS', 'Serbia', 0, 0),
(194, 'SC', 'Seychelles', 0, 0),
(195, 'SL', 'Sierra Leone', 0, 0),
(196, 'SG', 'Singapore', 0, 0),
(197, 'SK', 'Slovakia', 0, 0),
(198, 'SI', 'Slovenia', 0, 0),
(199, 'SB', 'Solomon Islands', 0, 0),
(200, 'SO', 'Somalia', 0, 1),
(201, 'ZA', 'South Africa', 0, 0),
(202, 'GS', 'South Georgia South Sandwich Islands', 0, 0),
(203, 'SS', 'South Sudan', 0, 0),
(204, 'ES', 'Spain', 0, 0),
(205, 'LK', 'Sri Lanka', 0, 0),
(206, 'SH', 'St. Helena', 0, 0),
(207, 'PM', 'St. Pierre and Miquelon', 0, 0),
(208, 'SD', 'Sudan', 0, 0),
(209, 'SR', 'Suriname', 0, 0),
(210, 'SJ', 'Svalbard and Jan Mayen Islands', 0, 0),
(211, 'SZ', 'Swaziland', 0, 0),
(212, 'SE', 'Sweden', 0, 0),
(213, 'CH', 'Switzerland', 0, 0),
(214, 'SY', 'Syrian Arab Republic', 0, 0),
(215, 'TW', 'Taiwan', 0, 0),
(216, 'TJ', 'Tajikistan', 0, 0),
(217, 'TZ', 'Tanzania, United Republic of', 0, 0),
(218, 'TH', 'Thailand', 0, 0),
(219, 'TG', 'Togo', 0, 0),
(220, 'TK', 'Tokelau', 0, 0),
(221, 'TO', 'Tonga', 0, 0),
(222, 'TT', 'Trinidad and Tobago', 0, 0),
(223, 'TN', 'Tunisia', 0, 0),
(224, 'TR', 'Turkey', 0, 0),
(225, 'TM', 'Turkmenistan', 0, 0),
(226, 'TC', 'Turks and Caicos Islands', 0, 0),
(227, 'TV', 'Tuvalu', 0, 0),
(228, 'UG', 'Uganda', 0, 1),
(229, 'UA', 'Ukraine', 0, 0),
(230, 'AE', 'United Arab Emirates', 0, 0),
(231, 'GB', 'United Kingdom', 0, 1),
(232, 'US', 'United States', 0, 1),
(233, 'UM', 'United States minor outlying islands', 0, 0),
(234, 'UY', 'Uruguay', 0, 0),
(235, 'UZ', 'Uzbekistan', 0, 0),
(236, 'VU', 'Vanuatu', 0, 0),
(237, 'VA', 'Vatican City State', 2, 1),
(238, 'VE', 'Venezuela', 0, 1),
(239, 'VN', 'Vietnam', 0, 1),
(240, 'VG', 'Virgin Islands (British)', 0, 0),
(241, 'VI', 'Virgin Islands (U.S.)', 0, 1),
(242, 'WF', 'Wallis and Futuna Islands', 0, 1),
(243, 'EH', 'Western Sahara', 0, 1),
(244, 'YE', 'Yemen', 0, 1),
(245, 'ZM', 'Zambia', 5, 1),
(246, 'ZW', 'Zimbabwe', 36, 1);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint NOT NULL,
  `price` double NOT NULL,
  `times` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `coupon_type` varchar(255) DEFAULT NULL,
  `category` int DEFAULT NULL,
  `sub_category` int DEFAULT NULL,
  `child_category` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `price`, `times`, `used`, `status`, `start_date`, `end_date`, `coupon_type`, `category`, `sub_category`, `child_category`) VALUES
(1, 'eqwe', 1, 12.22, '990', 18, 1, '2019-01-15', '2026-08-20', NULL, NULL, NULL, NULL),
(2, 'sdsdsasd', 0, 11, NULL, 2, 1, '2019-05-23', '2022-05-26', NULL, NULL, NULL, NULL),
(3, 'werwd', 0, 22, NULL, 3, 1, '2019-05-23', '2023-06-08', NULL, NULL, NULL, NULL),
(4, 'asdasd', 1, 23.5, NULL, 1, 1, '2019-05-23', '2020-05-28', NULL, NULL, NULL, NULL),
(5, 'kopakopakopa', 0, 40, NULL, 3, 1, '2019-05-23', '2032-05-20', NULL, NULL, NULL, NULL),
(6, 'rererere', 1, 5, '665', 1, 1, '2019-05-21', '2022-05-26', 'category', 4, NULL, NULL),
(7, 'abcd', 1, 5, NULL, 0, 1, '2021-09-12', '2021-09-21', 'category', 4, NULL, NULL),
(8, '12345', 0, 34, NULL, 1, 1, '2021-12-15', '2021-12-30', 'category', 4, NULL, NULL),
(9, 'proco', 1, 10, NULL, 0, 1, '2022-01-03', '2022-01-10', 'category', 5, NULL, NULL),
(10, 'procoo', 0, 10, NULL, 4, 1, '2024-05-26', '2024-06-26', 'category', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int NOT NULL,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `sign`, `value`, `is_default`) VALUES
(1, 'USD', '$', 1, 1),
(4, 'BDT', '৳', 84.63, 0),
(6, 'EUR', '€', 0.89, 0),
(8, 'INR', '₹', 68.95, 0),
(9, 'NGN', '₦', 363.919, 0),
(10, 'BRL', 'R$', 4.02, 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_riders`
--

CREATE TABLE `delivery_riders` (
  `id` bigint NOT NULL,
  `order_id` int DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `rider_id` int DEFAULT NULL,
  `pickup_point_id` int DEFAULT NULL,
  `service_area_id` int DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_riders`
--

INSERT INTO `delivery_riders` (`id`, `order_id`, `vendor_id`, `rider_id`, `pickup_point_id`, `service_area_id`, `status`) VALUES
(10, 8, 13, 1, 2, 5, 'pending'),
(11, 7, 13, 1, 3, 5, 'pending'),
(12, 5, 13, 1, 4, 5, 'pending'),
(13, 2, 13, 1, 3, 5, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `deposit_number` varchar(255) DEFAULT NULL,
  `currency` blob,
  `currency_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double DEFAULT '0',
  `currency_value` double DEFAULT '0',
  `method` varchar(255) DEFAULT NULL,
  `txnid` varchar(255) DEFAULT NULL,
  `flutter_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `user_id`, `deposit_number`, `currency`, `currency_code`, `amount`, `currency_value`, `method`, `txnid`, `flutter_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 22, NULL, 0x24, 'USD', 20, 1, 'Paypal', '5HB63541N9371622P', NULL, 1, '2024-06-03 04:01:33', '2024-06-03 04:01:33'),
(2, 22, NULL, 0x24, 'USD', 20, 1, 'Stripe', 'pi_3PNXkBJlIV5dN9n7083YGBB0', NULL, 1, '2024-06-03 04:04:02', '2024-06-03 04:04:02'),
(3, 22, NULL, 0x24, 'USD', 20, 1, 'Authorize.net', '80019532304', NULL, 1, '2024-06-03 04:05:41', '2024-06-03 04:05:41'),
(4, 22, NULL, 0x24, 'USD', 20, 1, 'Flutterwave', '5812410', '6vxm1717409582', 1, '2024-06-03 04:13:02', '2024-06-03 04:13:27'),
(8, 22, 'RZP7iTk1717409938', 0xe282b9, 'INR', 0.29006526468455, 68.95, 'Razorpay', 'pay_OIFiUHQnvbmZ75', NULL, 1, '2024-06-03 04:18:58', '2024-06-03 04:19:19'),
(9, 22, NULL, 0x24, 'USD', 500, 1, 'Paypal', '4SB88894FL364091M', NULL, 1, '2024-08-25 12:03:09', '2024-08-25 12:03:09'),
(11, 22, NULL, 0x24, 'USD', 10, 1, 'Paypal', '4V350692MC825910V', NULL, 1, '2024-10-15 18:40:21', '2024-10-15 18:40:21'),
(13, 22, 'Ybf71730017928', 0x555344, 'USD', 100, 1, 'Stripe', 'pi_3QERunJlIV5dN9n70CWet1q5', NULL, 1, '2024-10-27 15:32:08', '2024-10-27 15:33:41'),
(14, 22, 'pZd61730021951', 0x555344, 'USD', 100, 1, 'Stripe', 'pi_3QESx9JlIV5dN9n71yfimG64', NULL, 1, '2024-10-27 16:39:11', '2024-10-27 16:40:11');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int NOT NULL,
  `email_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email_subject` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `email_body` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `email_type`, `email_subject`, `email_body`, `status`) VALUES
(1, 'new_order', 'Your Order Placed Successfully', '<p>Hello {customer_name},<br>Your Order Number is {order_number}<br>Your order has been placed successfully</p>', 1),
(2, 'new_registration', 'Welcome To Royal Cart', '<p>Hello {customer_name},<br>You have successfully registered to {website_title}, We wish you will have a wonderful experience using our service.</p><p>Thank You<br></p>', 1),
(3, 'vendor_accept', 'Your Vendor Account Activated', '<p>Hello {customer_name},<br>Your Vendor Account Activated Successfully. Please Login to your account and build your own shop.</p><p>Thank You<br></p>', 1),
(4, 'subscription_warning', 'Your subscrption plan will end after five days', '<p>Hello {customer_name},<br>Your subscription plan duration will end after five days. Please renew your plan otherwise all of your products will be deactivated.</p><p>Thank You<br></p>', 1),
(5, 'vendor_verification', 'Request for verification.', '<p>Hello {customer_name},<br>You are requested verify your account. Please send us photo of your passport.</p><p>Thank You<br></p>', 1),
(6, 'wallet_deposit', 'Balance Added to Your Account.', '<p>Hello {customer_name},<br>${deposit_amount} has been deposited in your account. Your current balance is ${wallet_balance}</p><p>Thank You<br></p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `title`, `details`) VALUES
(19, 'What steps does Genius Shop take to ensure product authenticity?', 'Genius Shop is committed to offering only genuine and authentic products to our customers. We work closely with our sellers to ensure that all items listed on our platform meet our strict quality and authenticity standards. Sellers are required to provide proof of authenticity for branded products, and we conduct regular audits to ensure compliance. Additionally, our customer review system allows shoppers to report any concerns about product authenticity. If a product is found to be counterfeit, we take immediate action, including removing the product from our platform and taking appropriate measures against the seller. Your trust is important to us, and we strive to create a marketplace where you can shop with confidence.<br>'),
(20, 'Does Genius Shop offer any promotions or discounts, and how can I find them?', 'Yes, Genius Shop frequently offers promotions, discounts, and special deals to enhance your shopping experience. You can find these promotions by visiting the \"Deals\" or \"Offers\" section on our website, where we regularly update the latest discounts available from various sellers. Additionally, by signing up for our newsletter, you can receive exclusive discount codes and be the first to know about upcoming sales events. Many sellers also offer seasonal promotions or discounts on specific product categories, so it’s a good idea to check back often to take advantage of these savings. You can also find promotional banners on the homepage that highlight ongoing deals.<br>'),
(21, 'Can I cancel my order on Genius Shop, and what are the conditions?', 'Yes, you can cancel your order on Genius Shop, but the ability to do so depends on the status of your order. If your order has not yet been processed or shipped, you can easily cancel it by logging into your account, going to your order history, and selecting the \"Cancel Order\" option next to the item you wish to cancel. If your order has already been shipped, cancellation may not be possible, and you may need to wait until you receive the item to initiate a return. It’s important to act quickly if you wish to cancel an order, as our sellers work hard to process and ship orders promptly. Please review the specific cancellation policy on the product page for more details.<br>'),
(22, 'What should I do if I receive a damaged or defective product?', 'If you receive a damaged or defective product, we understand how frustrating that can be, and we’re here to help resolve the issue quickly. First, we recommend taking photos of the damaged or defective item as evidence. Then, log in to your Genius Shop account and go to your order history. Select the item in question and choose the option to report an issue. You will be guided through the process of submitting your claim, which includes providing details about the damage or defect and uploading the photos you’ve taken. Our team will review your claim and, depending on the situation, arrange for a replacement, repair, or refund. We aim to make this process as smooth and hassle-free as possible.<br>'),
(23, 'How do I know if a seller on Genius Shop is trustworthy?', 'At Genius Shop, we prioritize creating a safe and reliable marketplace for our customers. To ensure that our sellers meet high standards, we thoroughly vet them during the registration process. Additionally, each seller on our platform has a rating based on customer reviews and feedback. When you view a product, you can see the seller’s rating, the number of transactions they’ve completed, and read reviews from previous customers. These ratings and reviews are valuable tools to help you assess the trustworthiness of a seller before making a purchase. If you ever have concerns about a seller, our customer support team is available to assist you.<br>'),
(24, 'How do I leave a review for a product on Genius Shop, and why is it important?', 'Leaving a review on Genius Shop is a great way to share your experience with other shoppers and help them make informed decisions. After you’ve received your purchase, you’ll receive an email inviting you to leave a review. Alternatively, you can log in to your Genius Shop account, go to your order history, and click on the product you wish to review. On the product page, you’ll find the option to rate the item and leave detailed feedback about your experience, including the product’s quality, value for money, and how it met your expectations. Your review is valuable not only to other shoppers but also to the sellers, as it helps them improve their products and services. Honest reviews contribute to a trustworthy and reliable marketplace.<br>'),
(25, 'Are there any shipping charges on Genius Shop, and how are they calculated?', 'Shipping charges on Genius Shop can vary depending on several factors, including the seller, the destination of the delivery, and the size or weight of the items purchased. Some sellers may offer free shipping on certain products or orders above a specific amount, while others may charge a nominal fee to cover shipping costs. During the checkout process, you will see the total shipping cost before completing your purchase, so there are no surprises. The shipping charges are calculated based on real-time rates from our logistics partners, ensuring that you receive the best possible service. You can also choose from different shipping options, such as standard or express delivery, depending on how quickly you need your items.<br>'),
(26, 'How do I contact Genius Shop customer support, and what kind of assistance is available?', '&nbsp;If you need assistance with anything related to your Genius Shop experience, our customer support team is here to help. You can reach out to us through the \"Contact Us\" page on our website, where you’ll find a form to submit your query. Additionally, we offer live chat support for immediate assistance with urgent matters. Whether you have questions about a product, need help with an order, or have concerns about a seller, our dedicated team is ready to provide the support you need. We strive to respond to all inquiries as quickly as possible, ensuring you have a smooth and satisfying shopping experience.<br>'),
(27, 'What is the return policy on Genius Shop, and how do I return a product?', 'The return policy on Genius Shop is designed to be as fair and straightforward as possible, though it may vary depending on the individual seller. Generally, most products can be returned within 14 days of receiving your order, provided they are unused and in their original packaging. To initiate a return, log in to your account, go to your order history, and select the item you wish to return. Follow the on-screen instructions to complete the return request, which may involve printing a return label and dropping the item off at a designated location. Once the return is received and inspected by the seller, your refund will be processed. Please note that certain items, like perishable goods or customized products, may not be eligible for return. Always check the specific return policy on the product page before making a purchase.<br>'),
(28, 'Can I track my order on Genius Shop, and how does the tracking process work?', '&nbsp;Yes, Genius Shop provides a comprehensive order tracking system to keep you informed every step of the way. Once your order has been processed and shipped, you will receive an email containing a tracking number. This tracking number can be used to monitor the progress of your delivery. Simply go to the \"Track Order\" section on our website, enter your tracking number, and you’ll be able to see real-time updates on your shipment’s location. You can also track your order through your account dashboard if you’re a registered user. This ensures you know exactly when to expect your package, and it provides peace of mind that your order is on its way.<br>'),
(29, 'What payment methods does Genius Shop accept, and are transactions secure?', 'Genius Shop accepts a variety of payment methods to make your shopping experience as convenient as possible. You can pay using major credit and debit cards, such as Visa, MasterCard, and American Express. We also accept payments through PayPal and other popular digital wallets. For added flexibility, we offer support for several regional payment methods depending on your location. All transactions on Genius Shop are secured using the latest encryption technologies, ensuring your payment information is safe and confidential. We also monitor transactions for any signs of fraud to protect our customers. Your financial security is a top priority for us.<br>'),
(30, 'How do I place an order on Genius Shop, and what should I know before purchasing?', 'Placing an order on Genius Shop is designed to be straightforward and user-friendly. First, browse through our extensive catalog of products, or use the search bar to find something specific. Once you’ve found an item you wish to purchase, click on it to view detailed information, including product descriptions, specifications, and customer reviews. If you’re satisfied with the item, select any necessary options (like size or color), and click \"Add to Cart.\" You can continue shopping or proceed directly to checkout. At checkout, you’ll be asked to provide your shipping details and select a payment method. Before completing your purchase, review your order to ensure everything is correct. After placing your order, you will receive an order confirmation via email, and you’ll be kept updated on its status until it arrives at your doorstep.<br>'),
(31, 'How can I become a seller on Genius Shop, and what are the requirements?', 'Becoming a seller on Genius Shop is a fantastic opportunity to reach a broad audience of potential customers. To join our community of sellers, click on the \"Sell with Us\" link found on our homepage. You will need to fill out a registration form with details about your business, including your business name, contact information, and the types of products you intend to sell. In addition, you will need to submit certain documents for verification purposes, such as proof of business registration and identity verification. Once your application is submitted, our team will review it to ensure it meets our standards. If approved, you’ll receive instructions on how to set up your store and start listing products. As a seller on Genius Shop, you’ll gain access to our robust platform tools that help manage inventory, process orders, and communicate with customers.<br>'),
(32, 'How do I create an account on Genius Shop and what are the benefits?', 'Creating an account on Genius Shop is simple and offers a range of benefits that enhance your shopping experience. To get started, click on the \"Sign Up\" button located at the top right corner of our homepage. You’ll be prompted to fill in some basic information, such as your name, email address, and a secure password. Once you’ve completed the registration, you can immediately start browsing and shopping. As a registered user, you’ll enjoy features like personalized recommendations, easy access to your order history, and the ability to save products to your wishlist for future purchase. Plus, you’ll be able to track your orders in real time and leave reviews on products you’ve purchased.<br>'),
(33, 'What is Genius Shop and how does it work?', 'Genius Shop is a dynamic multivendor eCommerce platform that brings together a diverse range of sellers and products, all under one virtual roof. Whether you\'re looking for the latest fashion trends, cutting-edge electronics, or unique home goods, you’ll find them here. Each vendor on Genius Shop manages their own store, allowing them to offer a wide variety of products with different styles, prices, and specialties. As a customer, you can browse through these offerings, compare products, and make purchases directly from the sellers, all through the Genius Shop interface. Our platform ensures a seamless shopping experience, from product discovery to payment and delivery.<br>');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_sellers`
--

CREATE TABLE `favorite_sellers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `vendor_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favorite_sellers`
--

INSERT INTO `favorite_sellers` (`id`, `user_id`, `vendor_id`) VALUES
(19, 22, 13);

-- --------------------------------------------------------

--
-- Table structure for table `fonts`
--

CREATE TABLE `fonts` (
  `id` int NOT NULL,
  `is_default` tinyint DEFAULT '0',
  `font_family` varchar(100) DEFAULT NULL,
  `font_value` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fonts`
--

INSERT INTO `fonts` (`id`, `is_default`, `font_family`, `font_value`) VALUES
(1, 1, 'Roboto', 'Roboto'),
(3, 0, 'Roboto Mono', 'Roboto+Mono'),
(4, 0, 'Libre Caslon Display', 'Libre+Caslon+Display'),
(5, 0, 'Pangolin', 'Pangolin'),
(6, 0, 'Dancing Script', 'Dancing+Script'),
(7, 0, 'Open Sans', 'Open+Sans');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `product_id`, `photo`) VALUES
(678, 430, '1730201322WMOLNosAjpg'),
(679, 430, '1730201322YZkJdsxWjpg'),
(680, 430, '1730201322SUTU8d7njpg'),
(681, 430, '1730201322bW9BFELDjpg'),
(682, 447, '1730260608uiSr4wX5.jpg'),
(683, 447, '1730260608TxFweXTw.jpg'),
(684, 447, '17302606088nVmVi2n.jpg'),
(685, 453, '1730260634lCiiI6zc.jpg'),
(686, 453, '1730260635MD1y5FRq.jpg'),
(687, 453, '1730260636QlIFgTGr.jpg'),
(688, 452, '1730260665Oaqs5kG8.jpg'),
(690, 452, '1730260670lfsLdIdl.jpg'),
(691, 452, '1730260671ADOkuXum.jpg'),
(692, 451, '1730260699Ha77gFiV.jpg'),
(693, 451, '1730260699jODCf4ln.jpg'),
(694, 451, '1730260700mHwUMnWn.jpg'),
(695, 450, '1730260719xDswEzYp.jpg'),
(696, 450, '17302607191Xd96Szp.jpg'),
(697, 450, '1730260719hjvilNYN.jpg'),
(698, 449, '1730260741zX1HXlOB.jpg'),
(699, 449, '1730260741VDvDG9Nr.jpg'),
(700, 449, '1730260742JThhVfD4.jpg'),
(701, 448, '17302607672I3zMVhP.jpg'),
(702, 448, '1730260768jV4bI59X.jpg'),
(703, 448, '1730260768owy5OLCV.jpg'),
(704, 446, '1730260831Cvu2THLX.jpg'),
(705, 446, '1730260831Tp1x9gRC.jpg'),
(706, 446, '17302608329IzIIzbu.jpg'),
(707, 445, '1730260994SLCA8GNp.jpg'),
(708, 445, '1730260994WXRP5Dch.jpg'),
(709, 445, '1730260995YEXwtrMk.jpg'),
(710, 444, '173026105921WkoB9K.jpg'),
(711, 444, '17302610600a3m5xUb.jpg'),
(712, 444, '1730261060rNlDLttV.jpg'),
(713, 443, '1730261125bnk5cgxJ.jpg'),
(714, 443, '1730261126HNKJxueD.jpg'),
(715, 443, '1730261126ULqAglCB.jpg'),
(716, 442, '1730261197z5Z6ggA8.jpg'),
(717, 442, '1730261197NcfeTMz8.jpg'),
(718, 442, '1730261198lCKirbj2.jpg'),
(719, 441, '1730261237jPQKUFcH.jpg'),
(720, 441, '1730261238eVRo9zey.jpg'),
(721, 441, '1730261238Dp4xz4Q9.jpg'),
(722, 440, '17302612921C3erzrR.jpg'),
(723, 440, '1730261292dbx43EQv.jpg'),
(724, 440, '1730261292eNbzVrYA.jpg'),
(725, 439, '17302613611WnydCZc.jpg'),
(726, 439, '1730261362rJeQilxa.jpg'),
(727, 439, '1730261362O61EzXg4.jpg'),
(728, 438, '1730261417pdbKQ7Af.jpg'),
(729, 438, '17302614180prAx7jp.jpg'),
(730, 438, '1730261419TGhknLgb.jpg'),
(731, 438, '1730261419w6PWHKwq.jpg'),
(732, 437, '1730261469RN3HTQX2.jpg'),
(733, 437, '1730261470CaxoctEj.jpg'),
(734, 437, '1730261470wz38sMlx.jpg'),
(735, 436, '1730261528quf3lJlq.jpg'),
(736, 436, '17302615287Qmq88KC.jpg'),
(737, 436, '1730261529rVkhWK7h.jpg'),
(738, 435, '173026163864RQehwL.jpg'),
(739, 435, '1730261639UifZjcTc.jpg'),
(740, 435, '1730261639RjXpL4L7.jpg'),
(741, 435, '1730261640acwum70x.jpg'),
(742, 434, '1730261712OJjcyLFk.jpg'),
(743, 434, '1730261712cC79mIxR.jpg'),
(744, 434, '1730261713lWd6ax8Q.jpg'),
(745, 433, '1730261783dHxhrGmj.jpg'),
(746, 433, '1730261784r0KjMVFY.jpg'),
(747, 433, '17302617856gS5GQtO.jpg'),
(748, 432, '1730261886JIg1xTF4.jpg'),
(749, 432, '17302618875g6nCwmW.jpg'),
(750, 432, '1730261888ZAzxwNJc.jpg'),
(751, 431, '1730261947xsZ2yMR8.jpg'),
(752, 431, '1730261947igRo5vkU.jpg'),
(753, 431, '1730261948h3GAefbB.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `generalsettings`
--

CREATE TABLE `generalsettings` (
  `id` bigint NOT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `colors` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loader` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_loader` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_talkto` tinyint(1) NOT NULL DEFAULT '1',
  `talkto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_language` tinyint(1) NOT NULL DEFAULT '1',
  `is_loader` tinyint(1) NOT NULL DEFAULT '1',
  `is_disqus` tinyint(1) NOT NULL DEFAULT '0',
  `disqus` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `guest_checkout` tinyint(1) NOT NULL DEFAULT '0',
  `currency_format` tinyint(1) NOT NULL DEFAULT '0',
  `withdraw_fee` double NOT NULL DEFAULT '0',
  `withdraw_charge` double NOT NULL DEFAULT '0',
  `shipping_cost` double NOT NULL DEFAULT '0',
  `mail_driver` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_host` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_port` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_encryption` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_user` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_pass` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_smtp` tinyint(1) NOT NULL DEFAULT '0',
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `is_currency` tinyint(1) NOT NULL DEFAULT '1',
  `is_affilate` tinyint(1) NOT NULL DEFAULT '1',
  `affilate_charge` int NOT NULL DEFAULT '0',
  `affilate_banner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fixed_commission` double NOT NULL DEFAULT '0',
  `percentage_commission` double NOT NULL DEFAULT '0',
  `multiple_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `multiple_packaging` tinyint NOT NULL DEFAULT '0',
  `vendor_ship_info` tinyint(1) NOT NULL DEFAULT '0',
  `reg_vendor` tinyint(1) NOT NULL DEFAULT '0',
  `footer_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyright_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyright` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin_loader` tinyint(1) NOT NULL DEFAULT '0',
  `is_verification_email` tinyint(1) NOT NULL DEFAULT '0',
  `wholesell` int NOT NULL DEFAULT '0',
  `is_capcha` tinyint(1) NOT NULL DEFAULT '0',
  `capcha_secret_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capcha_site_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_banner_404` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_banner_500` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_popup` tinyint(1) NOT NULL DEFAULT '0',
  `popup_background` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `breadcrumb_banner` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_secure` tinyint(1) NOT NULL DEFAULT '0',
  `is_report` tinyint(1) NOT NULL,
  `footer_logo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `show_stock` tinyint(1) NOT NULL DEFAULT '0',
  `is_maintain` tinyint(1) NOT NULL DEFAULT '0',
  `header_color` enum('light','dark') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'light',
  `maintain_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_buy_now` tinyint NOT NULL,
  `version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affilate_product` tinyint(1) NOT NULL DEFAULT '1',
  `verify_product` tinyint(1) NOT NULL DEFAULT '0',
  `page_count` int NOT NULL DEFAULT '0',
  `flash_count` int NOT NULL DEFAULT '0',
  `hot_count` int NOT NULL DEFAULT '0',
  `new_count` int NOT NULL DEFAULT '0',
  `sale_count` int NOT NULL DEFAULT '0',
  `best_seller_count` int NOT NULL DEFAULT '0',
  `popular_count` int NOT NULL DEFAULT '0',
  `top_rated_count` int NOT NULL DEFAULT '0',
  `big_save_count` int NOT NULL DEFAULT '0',
  `trending_count` int NOT NULL DEFAULT '0',
  `seller_product_count` int NOT NULL DEFAULT '0',
  `wishlist_count` int NOT NULL DEFAULT '0',
  `vendor_page_count` int NOT NULL DEFAULT '0',
  `min_price` double NOT NULL DEFAULT '0',
  `max_price` double NOT NULL DEFAULT '0',
  `post_count` tinyint(1) NOT NULL DEFAULT '0',
  `product_page` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `wishlist_page` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_contact_seller` tinyint(1) NOT NULL DEFAULT '0',
  `is_debug` tinyint(1) NOT NULL DEFAULT '0',
  `decimal_separator` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thousand_separator` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_cookie` tinyint(1) NOT NULL DEFAULT '0',
  `product_affilate` tinyint(1) NOT NULL DEFAULT '0',
  `product_affilate_bonus` int NOT NULL DEFAULT '0',
  `is_reward` int NOT NULL DEFAULT '0',
  `reward_point` int NOT NULL DEFAULT '0',
  `reward_dolar` int NOT NULL DEFAULT '0',
  `physical` tinyint NOT NULL DEFAULT '1',
  `digital` tinyint NOT NULL DEFAULT '1',
  `license` tinyint NOT NULL DEFAULT '1',
  `listing` tinyint NOT NULL DEFAULT '1',
  `affilite` tinyint NOT NULL DEFAULT '1',
  `partner_title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partner_text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `deal_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deal_details` varchar(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deal_time` date DEFAULT NULL,
  `deal_background` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'theme1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `generalsettings`
--

INSERT INTO `generalsettings` (`id`, `logo`, `favicon`, `title`, `colors`, `loader`, `admin_loader`, `is_talkto`, `talkto`, `is_language`, `is_loader`, `is_disqus`, `disqus`, `guest_checkout`, `currency_format`, `withdraw_fee`, `withdraw_charge`, `shipping_cost`, `mail_driver`, `mail_host`, `mail_port`, `mail_encryption`, `mail_user`, `mail_pass`, `from_email`, `from_name`, `is_smtp`, `is_comment`, `is_currency`, `is_affilate`, `affilate_charge`, `affilate_banner`, `fixed_commission`, `percentage_commission`, `multiple_shipping`, `multiple_packaging`, `vendor_ship_info`, `reg_vendor`, `footer_color`, `copyright_color`, `copyright`, `is_admin_loader`, `is_verification_email`, `wholesell`, `is_capcha`, `capcha_secret_key`, `capcha_site_key`, `error_banner_404`, `error_banner_500`, `is_popup`, `popup_background`, `breadcrumb_banner`, `invoice_logo`, `user_image`, `vendor_color`, `is_secure`, `is_report`, `footer_logo`, `show_stock`, `is_maintain`, `header_color`, `maintain_text`, `is_buy_now`, `version`, `affilate_product`, `verify_product`, `page_count`, `flash_count`, `hot_count`, `new_count`, `sale_count`, `best_seller_count`, `popular_count`, `top_rated_count`, `big_save_count`, `trending_count`, `seller_product_count`, `wishlist_count`, `vendor_page_count`, `min_price`, `max_price`, `post_count`, `product_page`, `wishlist_page`, `is_contact_seller`, `is_debug`, `decimal_separator`, `thousand_separator`, `is_cookie`, `product_affilate`, `product_affilate_bonus`, `is_reward`, `reward_point`, `reward_dolar`, `physical`, `digital`, `license`, `listing`, `affilite`, `partner_title`, `partner_text`, `deal_title`, `deal_details`, `deal_time`, `deal_background`, `theme`) VALUES
(1, '1730281140Blackpng.png', '1730281155FavIconpng.png', 'Genius-Shop', '#424a4d', '1564224328loading3.gif', '1564224329loading3.gif', 0, 'Cillum eu id enim aliquip aute ullamco anim. Culpa deserunt nostrud excepteur voluptate velit ipsum esse enim.', 1, 1, 0, 'junnun', 1, 1, 10, 5, 5, 'smtp', 'sandbox.smtp.mailtrap.io', '2525', 'TLS', '77c8df7c3e0779', '509dc95e1382f5', 'test@junnun.royalscripts.com', 'GeniusTest', 1, 1, 1, 1, 10, '15587771131554048228onepiece.jpeg', 5, 5, 1, 1, 1, 1, '#143250', '#02020c', 'COPYRIGHT © 2024. All Rights Reserved By GeniusOcean', 1, 0, 7, 1, '6LcnPoEaAAAAACV_xC4jdPqumaYKBnxz9Sj6y0zk', '6LcnPoEaAAAAAF6QhKPZ8V4744yiEnr41li3SYDn', '1566878455404.png', '1587792059error-500.png', 1, '1592369253banner.jpg', '1724480495Imagexxxxxpng.png', '1730281142Blackpng.png', '1567655174profile.jpg', '#666666', 0, 1, '1730281141Whitepng.png', 1, 0, 'light', '<div style=\"text-align: center;\"><font size=\"5\"><br></font></div><h1 style=\"text-align: center;\"><font size=\"6\">UNDER MAINTENANCE!</font></h1>', 1, '2.0', 1, 1, 12, 6, 12, 12, 12, 12, 12, 4, 4, 12, 3, 12, 12, 0, 1000000, 6, NULL, '12,24,36,48,60', 1, 1, '.', ',', 1, 1, 5, 1, 10, 15, 1, 1, 1, 1, 1, 'Our Partners', 'Cillum eu id enim aliquip aute ullamco anim. Culpa deserunt nostrud excepteur voluptate velit ipsum esse enim.', 'CLICK SHOP NOW FOR ALL DEAL OF THE PRODUCT', 'Donec condimentum Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras cursus pretium sapien, in pulvinar ipsum molestie id. Aliquam erat volutpat. Duis quam tellus, ullamcorper.....', '2025-06-18', '1730268778Group1000009322png.png', 'theme1');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `rtl` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `is_default`, `language`, `file`, `name`, `rtl`) VALUES
(1, 1, 'English', '1605519199OsGO7B86.json', '1605519199OsGO7B86', 0),
(4, 0, 'Hindi', '1723875883eJFDCK9u.json', '1723875883eJFDCK9u', 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `conversation_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_user` int DEFAULT NULL,
  `recieved_user` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `message`, `sent_user`, `recieved_user`, `created_at`, `updated_at`) VALUES
(10, 5, 'asdfasdf', 13, NULL, '2024-09-03 03:54:34', '2024-09-03 03:54:34'),
(12, 5, 'Hi', 13, NULL, '2024-10-01 05:37:06', '2024-10-01 05:37:06'),
(16, 6, 'zssz', 22, NULL, '2024-10-16 12:19:13', '2024-10-16 12:19:13'),
(17, 5, 'snznnz', 22, NULL, '2024-10-16 12:19:20', '2024-10-16 12:19:20'),
(18, 7, 'sbnsnana', 22, NULL, '2024-10-16 12:19:37', '2024-10-16 12:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `order_id` int UNSIGNED DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `conversation_id` int DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `order_id`, `user_id`, `vendor_id`, `product_id`, `conversation_id`, `is_read`, `created_at`, `updated_at`) VALUES
(35, NULL, 49, NULL, NULL, NULL, 1, '2024-09-04 02:11:37', '2024-09-30 14:35:48'),
(36, 19, NULL, NULL, NULL, NULL, 1, '2024-09-04 02:13:15', '2024-09-30 14:44:48'),
(37, 20, NULL, NULL, NULL, NULL, 1, '2024-09-30 13:52:36', '2024-09-30 14:44:48'),
(38, NULL, 50, NULL, NULL, NULL, 1, '2024-09-30 19:03:14', '2024-09-30 21:42:32'),
(39, NULL, 51, NULL, NULL, NULL, 1, '2024-10-01 19:09:34', '2024-10-02 00:45:38'),
(40, 21, NULL, NULL, NULL, NULL, 1, '2024-10-01 23:00:02', '2024-10-02 00:45:35'),
(41, 22, NULL, NULL, NULL, NULL, 1, '2024-10-06 18:36:22', '2024-10-07 13:58:16'),
(42, NULL, NULL, NULL, NULL, 4, 1, '2024-10-07 14:11:06', '2024-10-07 15:37:31'),
(43, 23, NULL, NULL, NULL, NULL, 1, '2024-10-08 15:05:52', '2024-10-08 15:27:30'),
(44, 24, NULL, NULL, NULL, NULL, 1, '2024-10-08 15:18:14', '2024-10-08 15:27:30'),
(45, 25, NULL, NULL, NULL, NULL, 1, '2024-10-10 18:42:04', '2024-10-10 18:55:16'),
(46, 26, NULL, NULL, NULL, NULL, 1, '2024-10-11 20:52:28', '2024-10-12 04:13:26'),
(47, 27, NULL, NULL, NULL, NULL, 1, '2024-10-13 17:07:49', '2024-10-15 12:32:52'),
(48, NULL, 52, NULL, NULL, NULL, 1, '2024-10-13 17:11:25', '2024-10-14 07:24:24'),
(49, 28, NULL, NULL, NULL, NULL, 0, '2024-10-15 16:11:04', '2024-10-15 16:11:04'),
(50, NULL, NULL, NULL, NULL, 11, 0, '2024-10-16 11:46:57', '2024-10-16 11:46:57'),
(51, 29, NULL, NULL, NULL, NULL, 0, '2024-10-19 17:45:39', '2024-10-19 17:45:39'),
(52, 30, NULL, NULL, NULL, NULL, 0, '2024-10-21 15:58:17', '2024-10-21 15:58:17'),
(53, 31, NULL, NULL, NULL, NULL, 0, '2024-10-21 15:59:26', '2024-10-21 15:59:26'),
(54, 32, NULL, NULL, NULL, NULL, 0, '2024-10-21 16:09:25', '2024-10-21 16:09:25'),
(55, 33, NULL, NULL, NULL, NULL, 0, '2024-10-21 16:11:27', '2024-10-21 16:11:27'),
(56, 34, NULL, NULL, NULL, NULL, 0, '2024-10-21 16:18:38', '2024-10-21 16:18:38'),
(57, 35, NULL, NULL, NULL, NULL, 0, '2024-10-21 16:20:00', '2024-10-21 16:20:00'),
(58, 36, NULL, NULL, NULL, NULL, 0, '2024-10-21 16:23:40', '2024-10-21 16:23:40'),
(59, 37, NULL, NULL, NULL, NULL, 0, '2024-10-21 16:24:14', '2024-10-21 16:24:14'),
(60, 38, NULL, NULL, NULL, NULL, 0, '2024-10-23 12:31:50', '2024-10-23 12:31:50'),
(61, 39, NULL, NULL, NULL, NULL, 0, '2024-10-23 17:26:37', '2024-10-23 17:26:37'),
(62, 40, NULL, NULL, NULL, NULL, 0, '2024-10-26 13:32:42', '2024-10-26 13:32:42'),
(63, 1, NULL, NULL, NULL, NULL, 0, '2024-10-26 16:47:33', '2024-10-26 16:47:33'),
(64, 2, NULL, NULL, NULL, NULL, 0, '2024-10-26 16:55:17', '2024-10-26 16:55:17'),
(65, 3, NULL, NULL, NULL, NULL, 0, '2024-10-27 15:30:00', '2024-10-27 15:30:00'),
(66, 4, NULL, NULL, NULL, NULL, 0, '2024-10-29 11:54:32', '2024-10-29 11:54:32'),
(67, 5, NULL, NULL, NULL, NULL, 0, '2024-10-30 17:33:18', '2024-10-30 17:33:18'),
(68, 6, NULL, NULL, NULL, NULL, 0, '2024-10-30 17:34:01', '2024-10-30 17:34:01'),
(69, 7, NULL, NULL, NULL, NULL, 0, '2024-10-30 17:34:54', '2024-10-30 17:34:54'),
(70, 8, NULL, NULL, NULL, NULL, 0, '2024-10-30 17:35:30', '2024-10-30 17:35:30'),
(71, 9, NULL, NULL, NULL, NULL, 0, '2024-10-30 17:46:04', '2024-10-30 17:46:04'),
(72, 10, NULL, NULL, NULL, NULL, 0, '2024-10-30 18:52:04', '2024-10-30 18:52:04'),
(73, 11, NULL, NULL, NULL, NULL, 0, '2024-10-30 18:55:21', '2024-10-30 18:55:21'),
(74, 12, NULL, NULL, NULL, NULL, 0, '2024-10-30 18:56:54', '2024-10-30 18:56:54'),
(75, 13, NULL, NULL, NULL, NULL, 0, '2024-10-30 19:02:42', '2024-10-30 19:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `cart` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalQty` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_amount` double NOT NULL,
  `txnid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `customer_email` varchar(255) NOT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `customer_country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `customer_city` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `customer_zip` varchar(255) DEFAULT NULL,
  `shipping_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `shipping_phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `shipping_zip` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `order_note` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `coupon_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_discount` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','processing','completed','declined','on delivery') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `affilate_user` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affilate_charge` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_sign` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_value` double NOT NULL,
  `shipping_cost` double NOT NULL DEFAULT '0',
  `packing_cost` double NOT NULL DEFAULT '0',
  `tax` double NOT NULL,
  `tax_location` varchar(191) DEFAULT NULL,
  `dp` tinyint(1) NOT NULL DEFAULT '0',
  `pay_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `vendor_shipping_id` text,
  `vendor_packing_id` text,
  `vendor_ids` varchar(255) DEFAULT NULL,
  `wallet_price` double NOT NULL DEFAULT '0',
  `is_shipping` tinyint NOT NULL DEFAULT '1',
  `shipping_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `packing_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `customer_state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` int NOT NULL DEFAULT '0',
  `affilate_users` text,
  `commission` double NOT NULL DEFAULT '0',
  `riders` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `cart`, `method`, `shipping`, `pickup_location`, `totalQty`, `pay_amount`, `txnid`, `charge_id`, `order_number`, `payment_status`, `customer_email`, `customer_name`, `customer_country`, `customer_phone`, `customer_address`, `customer_city`, `customer_zip`, `shipping_name`, `shipping_country`, `shipping_email`, `shipping_phone`, `shipping_address`, `shipping_city`, `shipping_zip`, `order_note`, `coupon_code`, `coupon_discount`, `status`, `created_at`, `updated_at`, `affilate_user`, `affilate_charge`, `currency_sign`, `currency_name`, `currency_value`, `shipping_cost`, `packing_cost`, `tax`, `tax_location`, `dp`, `pay_id`, `vendor_shipping_id`, `vendor_packing_id`, `vendor_ids`, `wallet_price`, `is_shipping`, `shipping_title`, `packing_title`, `customer_state`, `shipping_state`, `discount`, `affilate_users`, `commission`, `riders`) VALUES
(1, 22, '{\"totalQty\":1,\"totalPrice\":480,\"items\":{\"397944444\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"944444\",\"color_price\":0,\"stock\":1633,\"price\":480,\"item\":{\"id\":397,\"user_id\":\"0\",\"slug\":\"mid-range-mobile-with-48mp-ai-camera-6gb-ram-and-4000mah-fast-charging-gpg4357nx2\",\"name\":\"Mid-Range Mobile with 48MP AI Camera, 6GB RAM, and 4000mAh Fast Charging\",\"photo\":\"1724222448zAN9OphS.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":480,\"stock\":\"1634\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":[\"12\",\"50\",\"100\",\"200\",\"500\"],\"whole_sell_discount\":[\"2\",\"5\",\"10\",\"15\",\"20\"],\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":480,\"discount\":0,\"affilate_user\":null}}}', 'Stripe', NULL, NULL, '1', 489.6, 'pi_3QE6cBJlIV5dN9n719vxKtf6', NULL, 'aLg91729936053', 'Completed', 'user@gmail.com', 'User', 'Bangladesh', '+8801779888484', 'Test Address', 'Uttara', '1231', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-26 16:47:33', '2024-10-26 16:49:03', NULL, NULL, '$', 'USD', 1, 0, 0, 9.6, 'Dhaka', 0, NULL, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '[\"0\"]', 0, 1, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '14', NULL, 0, NULL, 0, NULL),
(2, 22, '{\"totalQty\":2,\"totalPrice\":658.25,\"items\":{\"427ff0000LocalsellerWarranty\":{\"user_id\":\"13\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"ff0000\",\"color_price\":0,\"stock\":4493,\"price\":178.25,\"item\":{\"id\":427,\"user_id\":\"13\",\"slug\":\"all-natural-organic-face-oil-with-jojoba-and-rosehip-30ml-masud151155\",\"name\":\"All-Natural Organic Face Oil with Jojoba and Rosehip \\u2013 30ml\",\"photo\":\"1724497056aUjkT7cx.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":178.25,\"stock\":\"4494\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":[\"100\",\"200\",\"400\",\"600\",\"800\",\"1200\",\"1800\",\"1500\",\"2500\",\"3500\",\"5600\"],\"whole_sell_discount\":[\"5\",\"8\",\"10\",\"12\",\"15\",\"18\",\"20\",\"25\",\"30\",\"35\",\"40\"],\"attributes\":\"{\\\"warranty_type\\\":{\\\"values\\\":[\\\"Local seller Warranty\\\"],\\\"prices\\\":[0],\\\"details_status\\\":1}}\"},\"license\":\"\",\"dp\":\"0\",\"keys\":\"warranty_type\",\"values\":\"Local seller Warranty\",\"item_price\":178.25,\"discount\":0,\"affilate_user\":null},\"397944444\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"944444\",\"color_price\":0,\"stock\":1632,\"price\":480,\"item\":{\"id\":397,\"user_id\":\"0\",\"slug\":\"mid-range-mobile-with-48mp-ai-camera-6gb-ram-and-4000mah-fast-charging-gpg4357nx2\",\"name\":\"Mid-Range Mobile with 48MP AI Camera, 6GB RAM, and 4000mAh Fast Charging\",\"photo\":\"1724222448zAN9OphS.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":480,\"stock\":\"1633\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":[\"12\",\"50\",\"100\",\"200\",\"500\"],\"whole_sell_discount\":[\"2\",\"5\",\"10\",\"15\",\"20\"],\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":480,\"discount\":0,\"affilate_user\":null}}}', 'Stripe', NULL, NULL, '2', 679.415, 'pi_3QE6jAJlIV5dN9n70kYxqP2K', NULL, 'ol3f1729936517', 'Completed', 'user@gmail.com', 'User', 'Bangladesh', '+8801779888484', 'Test Address', 'Uttara', '1231', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-26 16:55:17', '2024-10-26 16:56:18', NULL, NULL, '$', 'USD', 1, 5, 3, 13.165, 'Dhaka', 0, NULL, '\"{\\\"13\\\":\\\"7\\\",\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"13\\\":\\\"7\\\",\\\"0\\\":\\\"1\\\"}\"', '[\"13\",\"0\"]', 0, 1, '\"{\\\"13\\\":\\\"7\\\",\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"13\\\":\\\"6\\\",\\\"0\\\":\\\"1\\\"}\"', '14', NULL, 0, NULL, 0, NULL),
(3, 22, '{\"totalQty\":1,\"totalPrice\":480,\"items\":{\"397944444\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"944444\",\"color_price\":0,\"stock\":1631,\"price\":480,\"item\":{\"id\":397,\"user_id\":\"0\",\"slug\":\"mid-range-mobile-with-48mp-ai-camera-6gb-ram-and-4000mah-fast-charging-gpg4357nx2\",\"name\":\"Mid-Range Mobile with 48MP AI Camera, 6GB RAM, and 4000mAh Fast Charging\",\"photo\":\"1724222448zAN9OphS.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":480,\"stock\":\"1632\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":[\"12\",\"50\",\"100\",\"200\",\"500\"],\"whole_sell_discount\":[\"2\",\"5\",\"10\",\"15\",\"20\"],\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":480,\"discount\":0,\"affilate_user\":null}}}', 'Paypal', NULL, NULL, '1', 489.6, '7MP947800N809460K', NULL, 'E8qj1730017800', 'Completed', 'user@gmail.com', 'User', 'Bangladesh', '+8801779888484', 'Test Address', 'Uttara', '1231', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-27 15:30:00', '2024-10-27 15:31:04', NULL, NULL, '$', 'USD', 1, 0, 0, 9.6, 'Dhaka', 0, NULL, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '[\"0\"]', 0, 1, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '14', NULL, 0, NULL, 0, NULL),
(4, 22, '{\"totalQty\":2,\"totalPrice\":570,\"items\":{\"397944444\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"944444\",\"color_price\":0,\"stock\":1630,\"price\":480,\"item\":{\"id\":397,\"user_id\":\"0\",\"slug\":\"mid-range-mobile-with-48mp-ai-camera-6gb-ram-and-4000mah-fast-charging-gpg4357nx2\",\"name\":\"Mid-Range Mobile with 48MP AI Camera, 6GB RAM, and 4000mAh Fast Charging\",\"photo\":\"1724222448zAN9OphS.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":480,\"stock\":\"1631\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":[\"12\",\"50\",\"100\",\"200\",\"500\"],\"whole_sell_discount\":[\"2\",\"5\",\"10\",\"15\",\"20\"],\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":480,\"discount\":0,\"affilate_user\":null},\"405M15a9e8LocalsellerWarranty\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":\"2\",\"size_qty\":\"99\",\"size_price\":\"0\",\"size\":\"M\",\"color\":\"15a9e8\",\"color_price\":0,\"stock\":null,\"price\":90,\"item\":{\"id\":405,\"user_id\":\"0\",\"slug\":\"classic-leather-ankle-boots-with-block-heel-and-zip-closure-versatile-for-any-occasion-masud542544\",\"name\":\"Classic Leather Ankle Boots with Block Heel and Zip Closure \\u2013 Versatile for Any Occasion\",\"photo\":\"1724222065qOBnNoQo.png\",\"size\":[\"S\",\"XL\",\"M\"],\"size_qty\":[\"99\",\"96\",\"500\"],\"size_price\":[\"0\",\"0\",\"0\"],\"color\":\"\",\"price\":90,\"stock\":null,\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":[\"20\",\"50\",\"100\",\"150\",\"200\",\"400\",\"1000\"],\"whole_sell_discount\":[\"2\",\"5\",\"10\",\"15\",\"20\",\"25\",\"30\"],\"attributes\":\"{\\\"warranty_type\\\":{\\\"values\\\":[\\\"Local seller Warranty\\\",\\\"International Manufacturer Warranty\\\",\\\"International Seller Warranty\\\"],\\\"prices\\\":[0,0,0],\\\"details_status\\\":1}}\"},\"license\":\"\",\"dp\":\"0\",\"keys\":\"warranty_type\",\"values\":\"Local seller Warranty\",\"item_price\":90,\"discount\":0,\"affilate_user\":null}}}', NULL, NULL, NULL, '2', 581.4, NULL, NULL, 'Zdtj1730177672', 'Pending', 'user@gmail.com', 'User', 'Bangladesh', '+8801779888484', 'Test Address', 'Uttara', '1231', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-29 11:54:32', '2024-10-29 11:54:32', NULL, NULL, '$', 'USD', 1, 0, 0, 11.4, 'Dhaka', 0, NULL, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '[\"0\"]', 0, 1, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '14', NULL, 0, NULL, 0, NULL),
(5, 13, '{\"totalQty\":1,\"totalPrice\":204.5,\"items\":{\"430\":{\"user_id\":\"13\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"color_price\":0,\"stock\":null,\"price\":204.5,\"item\":{\"id\":430,\"user_id\":\"13\",\"slug\":\"organic-food-test-product-title-will-be-here-oc709305p9\",\"name\":\"Organic Food Test Product Title will be here 134\",\"photo\":\"17302620590pli91C4.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":204.5,\"stock\":null,\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null,\"minimum_qty\":null,\"stock_check\":\"0\",\"color_all\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":204.5,\"discount\":0,\"affilate_user\":\"0\"}}}', 'Cash On Delivery', NULL, 'Azampur', '1', 216.59, NULL, NULL, 'mSeF1730284398', 'Pending', 'vendor@gmail.com', 'Vendor', 'Bangladesh', '3453453345453411', NULL, 'Uttara', '1234', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-30 17:33:18', '2024-10-30 17:33:18', NULL, NULL, '$', 'USD', 1, 5, 3, 4.09, 'Dhaka', 0, NULL, '{\"13\":\"7\"}', '{\"13\":\"6\"}', '[\"13\"]', 0, 1, '{\"13\":\"7\"}', '{\"13\":\"6\"}', '14', NULL, 0, NULL, 0, NULL),
(6, 13, '{\"totalQty\":1,\"totalPrice\":120,\"items\":{\"453\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"color_price\":0,\"stock\":null,\"price\":120,\"item\":{\"id\":453,\"user_id\":\"0\",\"slug\":\"organic-food-test-product-title-will-be-here-oc709305p9s\",\"name\":\"Organic Food Test Product Title will be here\",\"photo\":\"1730262810w781nayq.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":120,\"stock\":null,\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null,\"minimum_qty\":null,\"stock_check\":\"0\",\"color_price\":\"\",\"color_all\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":120,\"discount\":0,\"affilate_user\":\"0\"}}}', 'Cash On Delivery', NULL, 'Azampur', '1', 122.4, NULL, NULL, '0uoi1730284441', 'Pending', 'vendor@gmail.com', 'Vendor', 'Bangladesh', '3453453345453411', NULL, 'Uttara', '1234', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-30 17:34:01', '2024-10-30 17:34:01', NULL, NULL, '$', 'USD', 1, 0, 0, 2.4, 'Dhaka', 0, NULL, '[\"1\"]', '[\"1\"]', '[\"0\"]', 0, 1, '[\"1\"]', '[\"1\"]', '14', NULL, 0, NULL, 0, NULL),
(7, 13, '{\"totalQty\":1,\"totalPrice\":94.25,\"items\":{\"435\":{\"user_id\":\"13\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"color_price\":0,\"stock\":null,\"price\":94.25,\"item\":{\"id\":435,\"user_id\":\"13\",\"slug\":\"organic-food-test-product-title-will-be-here-oc709305p9fr\",\"name\":\"Organic Food Test Product Title will be here\",\"photo\":\"1730261624tQx5tgxJ.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":94.25,\"stock\":null,\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null,\"minimum_qty\":null,\"stock_check\":\"0\",\"color_price\":\"\",\"color_all\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":94.25,\"discount\":0,\"affilate_user\":\"0\"}}}', 'Cash On Delivery', NULL, 'Azampur', '1', 104.135, NULL, NULL, 'gUK21730284494', 'Pending', 'vendor@gmail.com', 'Vendor', 'Bangladesh', '3453453345453411', NULL, 'Uttara', '1234', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-30 17:34:54', '2024-10-30 17:34:54', NULL, NULL, '$', 'USD', 1, 5, 3, 1.885, 'Dhaka', 0, NULL, '{\"13\":\"7\"}', '{\"13\":\"6\"}', '[\"13\"]', 0, 1, '{\"13\":\"7\"}', '{\"13\":\"6\"}', '14', NULL, 0, NULL, 0, NULL),
(8, 13, '{\"totalQty\":2,\"totalPrice\":409,\"items\":{\"430\":{\"user_id\":\"13\",\"qty\":2,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"stock\":null,\"price\":409,\"item\":{\"id\":430,\"user_id\":\"13\",\"slug\":\"organic-food-test-product-title-will-be-here-oc709305p9\",\"name\":\"Organic Food Test Product Title will be here 134\",\"photo\":\"17302620590pli91C4.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":204.5,\"stock\":null,\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null,\"color_all\":null,\"color_price\":\"\"},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":204.5,\"discount\":0,\"affilate_user\":0}}}', 'Cash On Delivery', NULL, 'Azampur', '2', 425.18, NULL, NULL, 'S0y51730284530', 'Pending', 'vendor@gmail.com', 'Vendor', 'Bangladesh', '3453453345453411', NULL, 'Uttara', '1234', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-30 17:35:30', '2024-10-30 17:35:30', NULL, NULL, '$', 'USD', 1, 5, 3, 8.18, 'Dhaka', 0, NULL, '{\"13\":\"7\"}', '{\"13\":\"6\"}', '[\"13\"]', 0, 1, '{\"13\":\"7\"}', '{\"13\":\"6\"}', '14', NULL, 0, NULL, 0, NULL),
(9, 22, '{\"totalQty\":1,\"totalPrice\":120,\"items\":{\"453\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"stock\":null,\"price\":120,\"item\":{\"id\":453,\"user_id\":\"0\",\"slug\":\"organic-food-test-product-title-will-be-here-oc709305p9s\",\"name\":\"Organic Food Test Product Title will be here\",\"photo\":\"1730262810w781nayq.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":120,\"stock\":null,\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null,\"color_all\":null,\"color_price\":\"\"},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":120,\"discount\":0,\"affilate_user\":0}}}', 'Cash On Delivery', NULL, 'Azampur', '1', 122.4, NULL, NULL, 'l0v81730285164', 'Pending', 'user@gmail.com', 'User', 'Bangladesh', '+8801779888484', 'Test Address', 'Uttara', '1231', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-30 17:46:04', '2024-10-30 17:46:04', NULL, NULL, '$', 'USD', 1, 0, 0, 2.4, 'Dhaka', 0, NULL, '[\"1\"]', '[\"1\"]', '[\"0\"]', 0, 1, '[\"1\"]', '[\"1\"]', '14', NULL, 0, NULL, 0, NULL),
(10, 22, '{\"totalQty\":2,\"totalPrice\":290,\"items\":{\"452\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"color_price\":0,\"stock\":9,\"price\":130,\"item\":{\"id\":452,\"user_id\":\"0\",\"slug\":\"organic-food-test-product-title-will-be-here-101-oc709305p9r\",\"name\":\"Organic Food Test Product Title will be here 101\",\"photo\":\"1730259850PTEfFrxB.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":130,\"stock\":\"10\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":130,\"discount\":0,\"affilate_user\":null},\"451\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"color_price\":0,\"stock\":19,\"price\":160,\"item\":{\"id\":451,\"user_id\":\"0\",\"slug\":\"organic-food-test-product-title-will-be-here-102-eafdsdfsdf\",\"name\":\"Organic Food Test Product Title will be here 102\",\"photo\":\"17302604206kknYrkg.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":160,\"stock\":\"20\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":160,\"discount\":0,\"affilate_user\":null}}}', NULL, NULL, NULL, '2', 295.8, NULL, NULL, 'FQJQ1730289124', 'Pending', 'user@gmail.com', 'User', 'Bangladesh', '+8801779888484', 'Test Address', 'Uttara', '1231', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-30 18:52:04', '2024-10-30 18:52:04', NULL, NULL, '$', 'USD', 1, 0, 0, 5.8, 'Dhaka', 0, NULL, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '[\"0\"]', 0, 1, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '14', NULL, 0, NULL, 0, NULL),
(11, 22, '{\"totalQty\":2,\"totalPrice\":290,\"items\":{\"452\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"color_price\":0,\"stock\":8,\"price\":130,\"item\":{\"id\":452,\"user_id\":\"0\",\"slug\":\"organic-food-test-product-title-will-be-here-101-oc709305p9r\",\"name\":\"Organic Food Test Product Title will be here 101\",\"photo\":\"1730259850PTEfFrxB.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":130,\"stock\":\"9\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":130,\"discount\":0,\"affilate_user\":null},\"451\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"color_price\":0,\"stock\":18,\"price\":160,\"item\":{\"id\":451,\"user_id\":\"0\",\"slug\":\"organic-food-test-product-title-will-be-here-102-eafdsdfsdf\",\"name\":\"Organic Food Test Product Title will be here 102\",\"photo\":\"17302604206kknYrkg.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":160,\"stock\":\"19\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":160,\"discount\":0,\"affilate_user\":null}}}', NULL, NULL, NULL, '2', 295.8, NULL, NULL, 'trWm1730289321', 'Pending', 'user@gmail.com', 'User', 'Bangladesh', '+8801779888484', 'Test Address', 'Uttara', '1231', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-30 18:55:21', '2024-10-30 18:55:21', NULL, NULL, '$', 'USD', 1, 0, 0, 5.8, 'Dhaka', 0, NULL, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '[\"0\"]', 0, 1, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '14', NULL, 0, NULL, 0, NULL),
(12, 22, '{\"totalQty\":2,\"totalPrice\":290,\"items\":{\"452\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"color_price\":0,\"stock\":7,\"price\":130,\"item\":{\"id\":452,\"user_id\":\"0\",\"slug\":\"organic-food-test-product-title-will-be-here-101-oc709305p9r\",\"name\":\"Organic Food Test Product Title will be here 101\",\"photo\":\"1730259850PTEfFrxB.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":130,\"stock\":\"8\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":130,\"discount\":0,\"affilate_user\":null},\"451\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"color_price\":0,\"stock\":17,\"price\":160,\"item\":{\"id\":451,\"user_id\":\"0\",\"slug\":\"organic-food-test-product-title-will-be-here-102-eafdsdfsdf\",\"name\":\"Organic Food Test Product Title will be here 102\",\"photo\":\"17302604206kknYrkg.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":160,\"stock\":\"18\",\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":160,\"discount\":0,\"affilate_user\":null}}}', 'Cash On Delivery', NULL, NULL, '2', 295.8, 'wQq9XxWpis89', NULL, 'ABO71730289414', 'Pending', 'user@gmail.com', 'User', 'Bangladesh', '+8801779888484', 'Test Address', 'Uttara', '1231', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-30 18:56:54', '2024-10-30 18:57:14', NULL, NULL, '$', 'USD', 1, 0, 0, 5.8, 'Dhaka', 0, NULL, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '[\"0\"]', 0, 1, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '14', NULL, 0, NULL, 0, NULL),
(13, 22, '{\"totalQty\":1,\"totalPrice\":120,\"items\":{\"453\":{\"user_id\":\"0\",\"qty\":1,\"size_key\":0,\"size_qty\":\"\",\"size_price\":\"\",\"size\":\"\",\"color\":\"\",\"color_price\":0,\"stock\":null,\"price\":120,\"item\":{\"id\":453,\"user_id\":\"0\",\"slug\":\"organic-food-test-product-title-will-be-here-oc709305p9s\",\"name\":\"Organic Food Test Product Title will be here\",\"photo\":\"1730262810w781nayq.png\",\"size\":\"\",\"size_qty\":\"\",\"size_price\":\"\",\"color\":\"\",\"price\":120,\"stock\":null,\"type\":\"Physical\",\"file\":null,\"link\":null,\"license\":\"\",\"license_qty\":\"\",\"measure\":null,\"whole_sell_qty\":\"\",\"whole_sell_discount\":\"\",\"attributes\":null},\"license\":\"\",\"dp\":\"0\",\"keys\":\"\",\"values\":\"\",\"item_price\":120,\"discount\":0,\"affilate_user\":null}}}', 'Cash On Delivery', NULL, NULL, '1', 122.4, '7W91P2dSlueL', NULL, 'zJ9F1730289762', 'Pending', 'user@gmail.com', 'User', 'Bangladesh', '+8801779888484', 'Test Address', 'Uttara', '1231', NULL, 'Bangladesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2024-10-30 19:02:42', '2024-10-30 19:02:55', NULL, NULL, '$', 'USD', 1, 0, 0, 2.4, 'Dhaka', 0, NULL, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '[\"0\"]', 0, 1, '\"{\\\"0\\\":\\\"1\\\"}\"', '\"{\\\"0\\\":\\\"1\\\"}\"', '14', NULL, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_tracks`
--

CREATE TABLE `order_tracks` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_tracks`
--

INSERT INTO `order_tracks` (`id`, `order_id`, `title`, `text`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pending', 'You have successfully placed your order.', '2024-05-31 23:24:28', '2024-05-31 23:24:28'),
(2, 2, 'Pending', 'You have successfully placed your order.', '2024-06-01 03:25:41', '2024-06-01 03:25:41'),
(3, 3, 'Pending', 'You have successfully placed your order.', '2024-06-01 21:52:28', '2024-06-01 21:52:28'),
(4, 4, 'Pending', 'You have successfully placed your order.', '2024-06-01 23:00:23', '2024-06-01 23:00:23'),
(5, 5, 'Pending', 'You have successfully placed your order.', '2024-06-01 23:23:57', '2024-06-01 23:23:57'),
(6, 6, 'Pending', 'You have successfully placed your order.', '2024-06-02 00:02:31', '2024-06-02 00:02:31'),
(7, 7, 'Pending', 'You have successfully placed your order.', '2024-06-02 00:08:00', '2024-06-02 00:08:00'),
(8, 8, 'Pending', 'You have successfully placed your order.', '2024-06-02 00:38:14', '2024-06-02 00:38:14'),
(9, 9, 'Pending', 'You have successfully placed your order.', '2024-06-02 02:05:09', '2024-06-02 02:05:09'),
(10, 10, 'Pending', 'You have successfully placed your order.', '2024-06-02 02:35:41', '2024-06-02 02:35:41'),
(11, 11, 'Pending', 'You have successfully placed your order.', '2024-06-02 03:00:12', '2024-06-02 03:00:12'),
(12, 12, 'Pending', 'You have successfully placed your order.', '2024-06-02 03:06:46', '2024-06-02 03:06:46'),
(13, 9, 'Processing', 'test', '2024-06-02 22:02:11', '2024-06-02 22:02:11'),
(14, 13, 'Pending', 'You have successfully placed your order.', '2024-08-10 04:55:40', '2024-08-10 04:55:40'),
(15, 14, 'Pending', 'You have successfully placed your order.', '2024-08-10 05:38:18', '2024-08-10 05:38:18'),
(16, 15, 'Pending', 'You have successfully placed your order.', '2024-08-10 05:42:57', '2024-08-10 05:42:57'),
(17, 9, 'Decline', 'Decline Your Order', '2024-08-10 21:29:15', '2024-08-10 21:29:15'),
(18, 16, 'Pending', 'You have successfully placed your order.', '2024-08-20 12:18:44', '2024-08-20 12:18:44'),
(19, 16, 'hhfghfghgfh', 'fghgfhghfg', '2024-08-20 12:25:02', '2024-08-20 12:25:02'),
(20, 16, 'Completed', 'trak note', '2024-08-20 13:27:10', '2024-08-20 13:27:10'),
(21, 17, 'Pending', 'You have successfully placed your order.', '2024-08-20 13:51:14', '2024-08-20 13:51:14'),
(22, 17, 'Completed', 'gfdgfgfdgfdgfg', '2024-08-20 13:52:54', '2024-08-20 13:52:54'),
(23, 18, 'Pending', 'You have successfully placed your order.', '2024-08-24 16:59:07', '2024-08-24 16:59:07'),
(24, 19, 'Pending', 'You have successfully placed your order.', '2024-09-04 02:13:15', '2024-09-04 02:13:15'),
(25, 19, 'Completed', 't', '2024-09-04 02:21:20', '2024-09-04 02:21:20'),
(26, 20, 'Pending', 'You have successfully placed your order.', '2024-09-30 13:52:36', '2024-09-30 13:52:36'),
(27, 21, 'Pending', 'You have successfully placed your order.', '2024-10-01 23:00:02', '2024-10-01 23:00:02'),
(28, 22, 'Pending', 'You have successfully placed your order.', '2024-10-06 18:36:22', '2024-10-06 18:36:22'),
(29, 23, 'Pending', 'You have successfully placed your order.', '2024-10-08 15:05:52', '2024-10-08 15:05:52'),
(30, 24, 'Pending', 'You have successfully placed your order.', '2024-10-08 15:18:14', '2024-10-08 15:18:14'),
(31, 25, 'Pending', 'You have successfully placed your order.', '2024-10-10 18:42:04', '2024-10-10 18:42:04'),
(32, 26, 'Pending', 'You have successfully placed your order.', '2024-10-11 20:52:28', '2024-10-11 20:52:28'),
(33, 27, 'Pending', 'You have successfully placed your order.', '2024-10-13 17:07:49', '2024-10-13 17:07:49'),
(34, 28, 'Pending', 'You have successfully placed your order.', '2024-10-15 16:11:04', '2024-10-15 16:11:04'),
(35, 29, 'Pending', 'You have successfully placed your order.', '2024-10-19 17:45:39', '2024-10-19 17:45:39'),
(36, 30, 'Pending', 'You have successfully placed your order.', '2024-10-21 15:58:17', '2024-10-21 15:58:17'),
(37, 31, 'Pending', 'You have successfully placed your order.', '2024-10-21 15:59:26', '2024-10-21 15:59:26'),
(38, 32, 'Pending', 'You have successfully placed your order.', '2024-10-21 16:09:25', '2024-10-21 16:09:25'),
(39, 33, 'Pending', 'You have successfully placed your order.', '2024-10-21 16:11:27', '2024-10-21 16:11:27'),
(40, 34, 'Pending', 'You have successfully placed your order.', '2024-10-21 16:18:38', '2024-10-21 16:18:38'),
(41, 35, 'Pending', 'You have successfully placed your order.', '2024-10-21 16:20:00', '2024-10-21 16:20:00'),
(42, 36, 'Pending', 'You have successfully placed your order.', '2024-10-21 16:23:40', '2024-10-21 16:23:40'),
(43, 37, 'Pending', 'You have successfully placed your order.', '2024-10-21 16:24:14', '2024-10-21 16:24:14'),
(44, 38, 'Pending', 'You have successfully placed your order.', '2024-10-23 12:31:50', '2024-10-23 12:31:50'),
(45, 39, 'Pending', 'You have successfully placed your order.', '2024-10-23 17:26:37', '2024-10-23 17:26:37'),
(46, 40, 'Pending', 'You have successfully placed your order.', '2024-10-26 13:32:42', '2024-10-26 13:32:42'),
(47, 1, 'Pending', 'You have successfully placed your order.', '2024-10-26 16:47:33', '2024-10-26 16:47:33'),
(48, 2, 'Pending', 'You have successfully placed your order.', '2024-10-26 16:55:17', '2024-10-26 16:55:17'),
(49, 3, 'Pending', 'You have successfully placed your order.', '2024-10-27 15:30:00', '2024-10-27 15:30:00'),
(50, 4, 'Pending', 'You have successfully placed your order.', '2024-10-29 11:54:32', '2024-10-29 11:54:32'),
(51, 5, 'Pending', 'You have successfully placed your order.', '2024-10-30 17:33:18', '2024-10-30 17:33:18'),
(52, 6, 'Pending', 'You have successfully placed your order.', '2024-10-30 17:34:01', '2024-10-30 17:34:01'),
(53, 7, 'Pending', 'You have successfully placed your order.', '2024-10-30 17:34:54', '2024-10-30 17:34:54'),
(54, 8, 'Pending', 'You have successfully placed your order.', '2024-10-30 17:35:30', '2024-10-30 17:35:30'),
(55, 9, 'Pending', 'You have successfully placed your order.', '2024-10-30 17:46:04', '2024-10-30 17:46:04'),
(56, 10, 'Pending', 'You have successfully placed your order.', '2024-10-30 18:52:04', '2024-10-30 18:52:04'),
(57, 11, 'Pending', 'You have successfully placed your order.', '2024-10-30 18:55:21', '2024-10-30 18:55:21'),
(58, 12, 'Pending', 'You have successfully placed your order.', '2024-10-30 18:56:54', '2024-10-30 18:56:54'),
(59, 13, 'Pending', 'You have successfully placed your order.', '2024-10-30 19:02:42', '2024-10-30 19:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `subtitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `user_id`, `title`, `subtitle`, `price`) VALUES
(1, 0, 'Default Packaging', 'Default packaging by store', 0),
(2, 0, 'Gift Packaging', 'Exclusive Gift packaging', 15),
(4, 22, 'Large box', 'Large box', 2),
(5, 22, 'Hi box', 'Hi box', 4),
(6, 13, 'Gift box', 'Gift box', 3),
(7, 13, 'Normal Box', 'Normal Box', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(500) DEFAULT NULL,
  `meta_tag` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `header` tinyint(1) NOT NULL DEFAULT '0',
  `footer` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `details`, `photo`, `meta_tag`, `meta_description`, `header`, `footer`) VALUES
(1, 'About Us', 'about', '<h2><strong>About Genius Shop</strong></h2><p>Welcome to <strong>Genius Shop</strong>, where the world of online shopping comes alive with endless possibilities! We are more than just an eCommerce platform; we are a thriving marketplace that connects buyers with a diverse range of sellers from all corners of the globe. Our mission is to create a space where shopping is not only convenient and secure but also exciting and rewarding.</p><h3><strong>Our Story</strong></h3><p>The story of Genius Shop began with a simple idea: to build a marketplace that bridges the gap between buyers and sellers, creating a seamless and enjoyable shopping experience for everyone involved. We recognized the growing demand for a platform that offers variety, quality, and reliability all in one place, and that’s how Genius Shop was born.</p><p>Founded by a team of passionate entrepreneurs and eCommerce enthusiasts, Genius Shop was designed to cater to the needs of modern shoppers. We envisioned a marketplace where customers could find everything they needed, from everyday essentials to rare and unique items, while ensuring that sellers had a platform to reach a wider audience. Today, Genius Shop stands as a testament to that vision, continuously growing and evolving to meet the needs of our global community.</p><h3><strong>Our Mission</strong></h3><p>At Genius Shop, our mission is simple: to revolutionize the way people shop online. We believe that shopping should be more than just a transaction—it should be an experience. That’s why we’ve created a platform that prioritizes the needs of our customers and sellers alike. Our goal is to provide a space where:</p><ul><li><p><strong>Variety Meets Quality:</strong> We bring together a wide range of sellers, each offering unique products that cater to different tastes, styles, and budgets. Whether you’re looking for the latest fashion, cutting-edge technology, or eco-friendly products, you’ll find it all on Genius Shop.</p></li><li><p><strong>Trust and Transparency:</strong> We understand that trust is key in the world of eCommerce. That’s why we’ve implemented stringent seller vetting processes and robust security measures to ensure that every transaction on our platform is safe and reliable.</p></li><li><p><strong>Community and Connection:</strong> Shopping on Genius Shop is about more than just buying products; it’s about connecting with sellers who share your values and interests. We aim to foster a community where buyers and sellers can interact, share feedback, and build lasting relationships.</p></li></ul><h3><strong>What Makes Us Different?</strong></h3><p>In a crowded online marketplace, Genius Shop stands out by offering a unique combination of features and benefits that are designed to enhance your shopping experience:</p><ul><li><p><strong>A Diverse Marketplace:</strong> Our platform hosts a wide array of sellers, each offering their own distinctive products. This diversity means that you can find everything you need, from everyday items to specialty goods, all in one place. With sellers from around the world, you have access to products that might not be available in your local market.</p></li><li><p><strong>Personalized Shopping Experience:</strong> We understand that every shopper is unique, which is why we’ve integrated advanced algorithms that provide personalized product recommendations based on your preferences and browsing history. This ensures that you always find items that match your taste and needs.</p></li><li><p><strong>Competitive Prices:</strong> By bringing together multiple vendors in one marketplace, Genius Shop creates a competitive environment that drives down prices and increases value for our customers. Sellers compete to offer the best deals, and you benefit from the savings.</p></li><li><p><strong>Commitment to Quality:</strong> Quality is at the heart of everything we do at Genius Shop. We work closely with our sellers to ensure that every product meets our high standards for quality and authenticity. When you shop with us, you can rest assured that you’re getting products that are built to last.</p></li><li><p><strong>Customer-Centric Policies:</strong> Your satisfaction is our top priority. That’s why we’ve developed customer-friendly policies that make shopping with us a breeze. From easy returns to responsive customer support, we’re here to make sure your experience is as smooth and enjoyable as possible.</p></li></ul><h3><strong>Our Values</strong></h3><p>At Genius Shop, our values are the foundation of our business and guide everything we do:</p><ul><li><p><strong>Integrity:</strong> We operate with honesty and transparency in all our dealings, ensuring that our customers and sellers can trust us to act in their best interests.</p></li><li><p><strong>Innovation:</strong> We are constantly innovating to improve our platform and provide a better experience for our users. From new features to enhanced security measures, we’re always looking for ways to stay ahead of the curve.</p></li><li><p><strong>Community:</strong> We believe in the power of community and strive to create a marketplace that brings people together. Whether you’re a buyer or a seller, you’re part of the Genius Shop family.</p></li><li><p><strong>Excellence:</strong> We are committed to excellence in everything we do, from the products we offer to the services we provide. Our goal is to exceed your expectations at every turn.</p></li></ul><h3><strong>Our Vision for the Future</strong></h3><p>As we look to the future, our vision for Genius Shop is clear: to become the go-to destination for online shopping worldwide. We plan to achieve this by continuously expanding our product offerings, enhancing our platform’s features, and growing our community of buyers and sellers. We also aim to be at the forefront of sustainable and ethical eCommerce, promoting products that are not only high-quality but also eco-friendly and socially responsible.</p><p>In the coming years, we will continue to invest in technology that makes shopping easier, faster, and more secure. We’re excited to introduce new innovations that will further personalize your shopping experience and make Genius Shop even more intuitive and user-friendly.</p><h3><strong>Join Us on Our Journey</strong></h3><p>At Genius Shop, we’re just getting started, and we’re thrilled to have you with us on this journey. Whether you’re a customer looking for great products or a seller wanting to reach a global audience, Genius Shop is the place for you. Together, we can build a marketplace that not only meets your needs but also inspires and excites you.</p><p>Thank you for being a part of the Genius Shop community. We look forward to serving you and helping you discover all that our marketplace has to offer.</p>', '164593825554png.png', NULL, NULL, 1, 1),
(2, 'Privacy & Policy', 'privacy', '<h2><strong>Privacy Policy</strong></h2><p><strong>Effective Date: [8-24-2024]</strong></p><p>At Genius Shop, we value your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, share, and protect your data when you use our platform. By using Genius Shop, you agree to the terms of this Privacy Policy. Please take a moment to read it carefully.</p><h3><strong>1. Information We Collect</strong></h3><p>We collect various types of information to provide and improve our services, ensure the security of our platform, and enhance your shopping experience.</p><h4><strong>a. Personal Information</strong></h4><ul><li><strong>Account Information:</strong> When you create an account with Genius Shop, we collect personal details such as your name, email address, phone number, and password.</li><li><strong>Payment Information:</strong> To process your transactions, we collect payment details such as your credit card number, billing address, and other related information. We do not store your payment information on our servers; it is securely handled by our third-party payment processors.</li><li><strong>Shipping Information:</strong> We collect your shipping address and contact information to fulfill your orders and ensure timely delivery.</li></ul><h4><strong>b. Non-Personal Information</strong></h4><ul><li><strong>Usage Data:</strong> We collect information about how you use our platform, including your browsing history, search queries, and interaction with products and services.</li><li><strong>Device Information:</strong> We gather details about the device you use to access Genius Shop, including IP address, browser type, operating system, and device identifiers.</li><li><strong>Cookies and Tracking Technologies:</strong> We use cookies, web beacons, and similar technologies to track your activity on our site, remember your preferences, and deliver personalized content and ads.</li></ul><h3><strong>2. How We Use Your Information</strong></h3><p>The information we collect is used for a variety of purposes, including:</p><ul><li><strong>Providing and Improving Our Services:</strong> We use your information to process transactions, fulfill orders, provide customer support, and enhance your overall shopping experience.</li><li><strong>Personalization:</strong> We use your data to tailor content, recommendations, and advertisements to your interests and preferences.</li><li><strong>Communication:</strong> We may use your contact information to send you updates, newsletters, marketing materials, and other communications related to Genius Shop. You can opt out of marketing communications at any time.</li><li><strong>Security and Fraud Prevention:</strong> We use your information to protect the integrity of our platform, prevent unauthorized access, and detect and combat fraudulent activities.</li><li><strong>Legal Compliance:</strong> We may use your data to comply with legal obligations, enforce our terms and conditions, and respond to legal requests or inquiries.</li></ul><h3><strong>3. How We Share Your Information</strong></h3><p>We do not sell your personal information to third parties. However, we may share your information with trusted partners and service providers for the following purposes:</p><ul><li><strong>Service Providers:</strong> We work with third-party companies to provide services such as payment processing, order fulfillment, shipping, customer support, and marketing. These service providers have access to your information only to perform specific tasks on our behalf and are obligated to protect your data.</li><li><strong>Sellers:</strong> When you make a purchase from a seller on Genius Shop, we share your relevant information, such as your shipping address and contact details, with the seller to facilitate order processing and delivery.</li><li><strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets, your information may be transferred to the new owner as part of the transaction.</li><li><strong>Legal Requirements:</strong> We may disclose your information if required by law or in response to a legal process, such as a court order, subpoena, or government request.</li></ul><h3><strong>4. Your Rights and Choices</strong></h3><p>You have several rights regarding your personal information, including:</p><ul><li><strong>Access and Update:</strong> You can access and update your account information at any time by logging into your Genius Shop account.</li><li><strong>Opt-Out:</strong> You can opt out of receiving marketing communications from us by following the unsubscribe link in our emails or adjusting your account settings.</li><li><strong>Data Portability:</strong> You have the right to request a copy of the personal information we hold about you in a structured, commonly used, and machine-readable format.</li><li><strong>Deletion:</strong> You can request the deletion of your account and personal information by contacting our customer support team. Please note that we may retain certain information as required by law or for legitimate business purposes.</li></ul><h3><strong>5. Data Security</strong></h3><p>We take the security of your personal information seriously and implement a variety of measures to protect it. These include encryption, access controls, and regular security audits. However, no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p><h3><strong>6. Cookies and Tracking Technologies</strong></h3><p>Genius Shop uses cookies and similar tracking technologies to enhance your experience on our platform. Cookies are small text files stored on your device that help us remember your preferences, track your activity, and deliver personalized content and ads.</p><p>You can manage your cookie preferences through your browser settings. However, disabling cookies may affect the functionality of our site and your ability to use certain features.</p><h3><strong>7. Third-Party Links</strong></h3><p>Our platform may contain links to third-party websites or services that are not operated by Genius Shop. We are not responsible for the privacy practices of these third parties, and we encourage you to review their privacy policies before providing any personal information.</p><h3><strong>8. International Data Transfers</strong></h3><p>Genius Shop operates globally, and your information may be transferred to and processed in countries outside of your own. We take steps to ensure that your data is treated securely and in accordance with this Privacy Policy, regardless of where it is processed.</p><h3><strong>9. Children\'s Privacy</strong></h3><p>Genius Shop is not intended for use by individuals under the age of 13, and we do not knowingly collect personal information from children under 13. If we become aware that we have collected information from a child under 13, we will take steps to delete that information promptly.</p><h3><strong>10. Changes to This Privacy Policy</strong></h3><p>We may update this Privacy Policy from time to time to reflect changes in our practices, legal requirements, or for other operational reasons. When we make changes, we will update the \"Effective Date\" at the top of this page and notify you through our platform or via email. We encourage you to review this Privacy Policy periodically to stay informed about how we protect your information.</p><h3><strong>11. Contact Us</strong></h3><p>If you have any questions or concerns about this Privacy Policy or our data practices, please contact us at:</p><p>Email: support@geniusshop.com<br></p><p><a rel=\"noopener\">Email: support@geniusshop.com</a></p>', '164593897354png.png', 'test,test1,test2,test3', 'Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 1, 1),
(3, 'Terms & Condition', 'terms', '<h2><strong>Terms &amp; Conditions</strong></h2><p><strong>Effective Date: [8-24-2024]</strong></p><p>Welcome to Genius Shop! These Terms &amp; Conditions govern your use of our website and services. By accessing or using Genius Shop, you agree to be bound by these terms. Please read them carefully before using our platform.</p><h3><strong>1. Acceptance of Terms</strong></h3><p>By accessing, browsing, or using Genius Shop, you agree to comply with and be bound by these Terms &amp; Conditions and our Privacy Policy. If you do not agree with any part of these terms, you should not use our platform.</p><h3><strong>2. Use of the Platform</strong></h3><h4><strong>a. Eligibility</strong></h4><p>To use Genius Shop, you must be at least 18 years old or have the legal capacity to form a binding contract in your jurisdiction. By using our platform, you represent and warrant that you meet these eligibility requirements.</p><h4><strong>b. Account Registration</strong></h4><p>To access certain features of Genius Shop, you may be required to create an account. You agree to provide accurate and complete information during the registration process and to keep your account information up to date. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p><h4><strong>c. Prohibited Activities</strong></h4><p>You agree not to engage in any of the following prohibited activities while using Genius Shop:</p><ul><li>Violating any applicable laws or regulations.</li><li>Engaging in fraudulent, deceptive, or misleading practices.</li><li>Infringing on the intellectual property rights of others.</li><li>Distributing viruses, malware, or other harmful software.</li><li>Using the platform to send unsolicited or unauthorized advertising or spam.</li><li>Interfering with the proper functioning of our platform or servers.</li><li>Creating multiple accounts for fraudulent purposes or to manipulate our platform.</li></ul><h3><strong>3. Seller and Buyer Responsibilities</strong></h3><h4><strong>a. Sellers</strong></h4><ul><li><strong>Product Listings:</strong> Sellers are responsible for accurately describing their products, including all relevant details such as price, condition, and availability. Sellers must comply with all applicable laws and regulations when listing products on Genius Shop.</li><li><strong>Order Fulfillment:</strong> Sellers are responsible for fulfilling orders promptly and in accordance with the terms specified in their product listings. Failure to fulfill orders may result in penalties or suspension of your seller account.</li><li><strong>Returns and Refunds:</strong> Sellers must clearly outline their return and refund policies in their product listings and honor these policies for all transactions.</li></ul><h4><strong>b. Buyers</strong></h4><ul><li><strong>Purchases:</strong> When making a purchase on Genius Shop, you agree to pay the total amount due, including any applicable taxes and shipping fees. All purchases are subject to the seller’s terms and conditions.</li><li><strong>Product Reviews:</strong> Buyers are encouraged to leave honest and constructive reviews of products and sellers. However, you agree not to post false, misleading, or defamatory reviews.</li><li><strong>Disputes:</strong> If you encounter any issues with a purchase, you agree to first attempt to resolve the issue directly with the seller. If a resolution cannot be reached, you may contact Genius Shop customer support for assistance.</li></ul><h3><strong>4. Payment and Fees</strong></h3><h4><strong>a. Payment Processing</strong></h4><p>Genius Shop partners with third-party payment processors to handle transactions securely. By making a purchase, you authorize Genius Shop and its payment processors to charge your payment method for the total amount due.</p><h4><strong>b. Fees</strong></h4><p>Genius Shop may charge fees for certain services, such as listing products, selling on the platform, or processing transactions. Any applicable fees will be disclosed to you before you use the service. Genius Shop reserves the right to change its fee structure at any time, with prior notice.</p><h4><strong>c. Taxes</strong></h4><p>You are responsible for determining and paying any taxes applicable to your transactions on Genius Shop. Genius Shop is not responsible for collecting or remitting any taxes on your behalf, except where required by law.</p><h3><strong>5. Intellectual Property</strong></h3><h4><strong>a. Ownership</strong></h4><p>All content on Genius Shop, including but not limited to text, graphics, logos, images, and software, is the property of Genius Shop or its licensors and is protected by intellectual property laws. You may not use, reproduce, or distribute any content from our platform without our prior written permission.</p><h4><strong>b. User-Generated Content</strong></h4><p>By submitting content to Genius Shop, including product listings, reviews, or comments, you grant us a non-exclusive, royalty-free, perpetual, and worldwide license to use, display, reproduce, and distribute your content on our platform and in our marketing materials.</p><h4><strong>c. Trademarks</strong></h4><p>All trademarks, service marks, and logos used on Genius Shop are the property of their respective owners. You may not use any trademarks or logos without the prior written consent of the owner.</p><h3><strong>6. Termination</strong></h3><h4><strong>a. Termination by You</strong></h4><p>You may terminate your account at any time by contacting Genius Shop customer support. Upon termination, you will remain responsible for any outstanding transactions or fees.</p><h4><strong>b. Termination by Us</strong></h4><p>Genius Shop reserves the right to suspend or terminate your account at any time, for any reason, including but not limited to violations of these Terms &amp; Conditions, fraudulent activity, or abuse of our platform. Upon termination, you will lose access to your account and any associated data.</p><h4><strong>c. Effect of Termination</strong></h4><p>Upon termination of your account, these Terms &amp; Conditions will continue to apply to any past use of the platform, and you will remain responsible for any obligations incurred prior to termination.</p><h3><strong>7. Disclaimers and Limitations of Liability</strong></h3><h4><strong>a. Disclaimers</strong></h4><p>Genius Shop provides the platform and all services on an \"as-is\" and \"as-available\" basis. We do not guarantee that the platform will be free from errors, interruptions, or security breaches. Genius Shop disclaims all warranties, express or implied, including but not limited to warranties of merchantability, fitness for a particular purpose, and non-infringement.</p><h4><strong>b. Limitation of Liability</strong></h4><p>To the maximum extent permitted by law, Genius Shop and its affiliates, officers, directors, employees, and agents will not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of the platform or services, even if we have been advised of the possibility of such damages. Our total liability to you for any claim arising out of or related to these Terms &amp; Conditions or your use of the platform will not exceed the amount paid by you to Genius Shop in the past 12 months.</p><h3><strong>8. Indemnification</strong></h3><p>You agree to indemnify, defend, and hold harmless Genius Shop and its affiliates, officers, directors, employees, and agents from and against any claims, liabilities, damages, losses, and expenses, including reasonable attorneys\' fees, arising out of or related to your use of the platform, your violation of these Terms &amp; Conditions, or your infringement of any third-party rights.</p><h3><strong>9. Governing Law and Dispute Resolution</strong></h3><h4><strong>a. Governing Law</strong></h4><p>These Terms &amp; Conditions are governed by and construed in accordance with the laws of [Insert Jurisdiction], without regard to its conflict of law principles.</p><h4><strong>b. Dispute Resolution</strong></h4><p>Any disputes arising out of or related to these Terms &amp; Conditions or your use of Genius Shop will be resolved through binding arbitration in accordance with the rules of the [Insert Arbitration Association]. The arbitration will take place in [Insert Location], and the decision of the arbitrator will be final and binding.</p><h3><strong>10. Changes to These Terms</strong></h3><p>Genius Shop reserves the right to update or modify these Terms &amp; Conditions at any time, with prior notice to you. Your continued use of the platform after any changes constitutes your acceptance of the revised terms. We encourage you to review these Terms &amp; Conditions periodically to stay informed of any updates.</p><h3><strong>11. Contact Us</strong></h3><p>If you have any questions or concerns about these Terms &amp; Conditions, please contact us</p>', '164593902254png.png', 't1,t2,t3,t4', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pagesettings`
--

CREATE TABLE `pagesettings` (
  `id` int UNSIGNED NOT NULL,
  `contact_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `phone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fax` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `site` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `best_seller_banner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `best_seller_banner_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `big_save_banner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `big_save_banner_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `best_seller_banner1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `best_seller_banner_link1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `big_save_banner1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `big_save_banner_link1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `big_save_banner_subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `big_save_banner_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `big_save_banner_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rightbanner1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rightbanner2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rightbannerlink1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rightbannerlink2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `home` tinyint(1) NOT NULL DEFAULT '0',
  `blog` tinyint(1) NOT NULL DEFAULT '0',
  `faq` tinyint(1) NOT NULL DEFAULT '0',
  `contact` tinyint(1) NOT NULL DEFAULT '0',
  `category` tinyint(1) NOT NULL DEFAULT '0',
  `arrival_section` tinyint(1) NOT NULL DEFAULT '1',
  `our_services` tinyint(1) NOT NULL DEFAULT '1',
  `slider` tinyint(1) NOT NULL DEFAULT '0',
  `partner` tinyint(1) NOT NULL DEFAULT '1',
  `top_big_trending` tinyint(1) NOT NULL DEFAULT '0',
  `top_banner` int NOT NULL DEFAULT '1',
  `large_banner` int NOT NULL DEFAULT '1',
  `bottom_banner` int NOT NULL DEFAULT '1',
  `best_selling` int NOT NULL DEFAULT '1',
  `newsletter` int NOT NULL DEFAULT '1',
  `deal_of_the_day` int NOT NULL DEFAULT '1',
  `best_sellers` tinyint NOT NULL DEFAULT '1',
  `third_left_banner` int NOT NULL,
  `popular_products` tinyint NOT NULL DEFAULT '1',
  `flash_deal` tinyint NOT NULL DEFAULT '1',
  `top_brand` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pagesettings`
--

INSERT INTO `pagesettings` (`id`, `contact_email`, `street`, `phone`, `fax`, `email`, `site`, `best_seller_banner`, `best_seller_banner_link`, `big_save_banner`, `big_save_banner_link`, `best_seller_banner1`, `best_seller_banner_link1`, `big_save_banner1`, `big_save_banner_link1`, `big_save_banner_subtitle`, `big_save_banner_title`, `big_save_banner_text`, `rightbanner1`, `rightbanner2`, `rightbannerlink1`, `rightbannerlink2`, `home`, `blog`, `faq`, `contact`, `category`, `arrival_section`, `our_services`, `slider`, `partner`, `top_big_trending`, `top_banner`, `large_banner`, `bottom_banner`, `best_selling`, `newsletter`, `deal_of_the_day`, `best_sellers`, `third_left_banner`, `popular_products`, `flash_deal`, `top_brand`) VALUES
(1, 'admin@geniusocean.com', '3584 Hickory Heights Drive , USA', '00 000 000 000', '00 000 000 000', 'admin@geniusocean.com', 'https://geniusocean.com/', '1639369899side-banner22png.png', 'http://google.com', '1639370813Bottom31png.png', 'http://google.com', '1639369899bottom3-bigg1png.png', 'http://google.com', '16632315121png.png', 'http://google.com', 'SPECIAL OFFER', 'Special Beauty Care Available', 'On purchases with your City Furniture Credit Card from 6/16/2021 – 7/6/2021.', '1573547281sm-banner.jpg', '1573547653sm-banner.jpg', 'https://codecanyon.net/user/geniusocean/portfolio', 'https://codecanyon.net/user/geniusocean/portfolio', 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int NOT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `photo`, `link`) VALUES
(7, '1571289583p1.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(8, '1571289601p2.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(9, '1571289608p3.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(10, '1571289614p4.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(11, '1571289621p5.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(12, '1571289627p6.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(13, '1571289634p7.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(14, '1571289642p8.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(15, '1571289650p9.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(16, '1571289657p10.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(18, '1571289669p12.jpg', 'https://codecanyon.net/user/geniusocean/portfolio'),
(19, '1571289675p13.jpg', 'https://codecanyon.net/user/geniusocean/portfolio');

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` int NOT NULL,
  `subtitle` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('manual','automatic') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'manual',
  `information` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keyword` varchar(191) DEFAULT NULL,
  `currency_id` varchar(191) NOT NULL DEFAULT '*',
  `checkout` int NOT NULL DEFAULT '1',
  `deposit` int NOT NULL DEFAULT '1',
  `subscription` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `subtitle`, `title`, `details`, `name`, `type`, `information`, `keyword`, `currency_id`, `checkout`, `deposit`, `subscription`) VALUES
(1, 'Pay with cash upon delivery.', 'Cash On Delivery', NULL, NULL, 'manual', NULL, 'cod', '*', 1, 0, 0),
(2, '(5 - 6 days)', 'Mobile Money', '<b>Payment Number: </b>69234324233423', NULL, 'manual', NULL, NULL, '*', 1, 1, 1),
(4, NULL, NULL, NULL, 'SSLCommerz', 'automatic', '{\"store_id\":\"geniu5e1b00621f81e\",\"store_password\":\"geniu5e1b00621f81e@ssl\",\"sandbox_check\":1,\"text\":\"Pay Via SSLCommerz.\"}', 'sslcommerz', '[\"4\"]', 1, 1, 1),
(6, NULL, NULL, NULL, 'Flutter Wave', 'automatic', '{\"public_key\":\"FLWPUBK_TEST-299dc2c8bf4c7f14f7d7f48c32433393-X\",\"secret_key\":\"FLWSECK_TEST-afb1f2a4789002d7c0f2185b830450b7-X\",\"text\":\"Pay via your Flutter Wave account.\"}', 'flutterwave', '[\"1\",\"9\"]', 1, 1, 1),
(7, NULL, NULL, NULL, 'Mercadopago', 'automatic', '{\"public_key\":\"TEST-6f72a502-51c8-4e9a-8ca3-cb7fa0addad8\",\"token\":\"TEST-6068652511264159-022306-e78da379f3963916b1c7130ff2906826-529753482\",\"sandbox_check\":1,\"text\":\"Pay Via MercadoPago\"}', 'mercadopago', '[\"1\"]', 1, 1, 1),
(8, NULL, NULL, NULL, 'Authorize.Net', 'automatic', '{\"login_id\":\"76zu9VgUSxrJ\",\"txn_key\":\"2Vj62a6skSrP5U3X\",\"sandbox_check\":1,\"text\":\"Pay Via Authorize.Net\"}', 'authorize.net', '[\"1\"]', 1, 1, 1),
(9, NULL, NULL, NULL, 'Razorpay', 'automatic', '{\"key\":\"rzp_test_xDH74d48cwl8DF\",\"secret\":\"cr0H1BiQ20hVzhpHfHuNbGri\",\"text\":\"Pay via your Razorpay account.\"}', 'razorpay', '[\"8\"]', 1, 1, 1),
(10, NULL, NULL, NULL, 'Mollie Payment', 'automatic', '{\"key\":\"test_5HcWVs9qc5pzy36H9Tu9mwAyats33J\",\"text\":\"Pay with Mollie Payment.\"}', 'mollie', '[\"1\",\"6\"]', 1, 1, 1),
(11, NULL, NULL, NULL, 'Paytm', 'automatic', '{\"merchant\":\"tkogux49985047638244\",\"secret\":\"LhNGUUKE9xCQ9xY8\",\"website\":\"WEBSTAGING\",\"industry\":\"Retail\",\"sandbox_check\":1,\"text\":\"Pay via your Paytm account.\"}', 'paytm', '[\"8\"]', 1, 1, 1),
(12, NULL, NULL, NULL, 'Paystack', 'automatic', '{\"key\":\"pk_test_162a56d42131cbb01932ed0d2c48f9cb99d8e8e2\",\"email\":\"junnuns@gmail.com\",\"text\":\"Pay via your Paystack account.\"}', 'paystack', '[\"9\"]', 1, 1, 1),
(13, NULL, NULL, NULL, 'Instamojo', 'automatic', '{\"key\":\"test_172371aa837ae5cad6047dc3052\",\"token\":\"test_4ac5a785e25fc596b67dbc5c267\",\"sandbox_check\":1,\"text\":\"Pay via your Instamojo account.\"}', 'instamojo', '[\"8\"]', 1, 1, 1),
(14, NULL, NULL, NULL, 'Stripe', 'automatic', '{\"key\":\"pk_test_UnU1Coi1p5qFGwtpjZMRMgJM\",\"secret\":\"sk_test_QQcg3vGsKRPlW6T3dXcNJsor\",\"text\":\"Pay via your Credit Card.\"}', 'stripe', '[\"1\"]', 1, 1, 1),
(15, NULL, NULL, NULL, 'Paypal', 'automatic', '{\"client_id\":\"AcWYnysKa_elsQIAnlfsJXokR64Z31CeCbpis9G3msDC-BvgcbAwbacfDfEGSP-9Dp9fZaGgD05pX5Qi\",\"client_secret\":\"EGZXTq6d6vBPq8kysVx8WQA5NpavMpDzOLVOb9u75UfsJ-cFzn6aeBXIMyJW2lN1UZtJg5iDPNL9ocYE\",\"sandbox_check\":1,\"text\":\"Pay via your PayPal account.\"}', 'paypal', '[\"1\"]', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pickups`
--

CREATE TABLE `pickups` (
  `id` int UNSIGNED NOT NULL,
  `location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pickups`
--

INSERT INTO `pickups` (`id`, `location`) VALUES
(2, 'Azampur'),
(3, 'Dhaka'),
(4, 'Kazipara'),
(5, 'Kamarpara'),
(6, 'Uttara');

-- --------------------------------------------------------

--
-- Table structure for table `pickup_points`
--

CREATE TABLE `pickup_points` (
  `id` bigint NOT NULL,
  `user_id` int DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pickup_points`
--

INSERT INTO `pickup_points` (`id`, `user_id`, `location`, `status`) VALUES
(2, 13, 'Uttara', 1),
(3, 13, 'MIRPUR', 1),
(4, 13, 'Savar', 1),
(5, 22, 'DHAKA', 1),
(6, 13, 'test', 1),
(7, 13, 'test12', 1),
(8, 13, 'adsfasd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `product_type` enum('normal','affiliate') NOT NULL DEFAULT 'normal',
  `affiliate_link` text,
  `user_id` int NOT NULL DEFAULT '0',
  `category_id` int UNSIGNED NOT NULL,
  `subcategory_id` int UNSIGNED DEFAULT NULL,
  `childcategory_id` int UNSIGNED DEFAULT NULL,
  `attributes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size_qty` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size_price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` double NOT NULL,
  `previous_price` double DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `stock` int DEFAULT NULL,
  `policy` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `views` int UNSIGNED NOT NULL DEFAULT '0',
  `tags` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` text,
  `colors` text,
  `product_condition` tinyint(1) NOT NULL DEFAULT '0',
  `ship` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_meta` tinyint(1) NOT NULL DEFAULT '0',
  `meta_tag` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `youtube` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Physical','Digital','License','Listing') NOT NULL,
  `license` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `license_qty` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `platform` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `licence_type` varchar(255) DEFAULT NULL,
  `measure` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `best` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `top` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_popular` int NOT NULL DEFAULT '0',
  `hot` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `latest` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `big` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `trending` tinyint(1) NOT NULL DEFAULT '0',
  `sale` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_discount` tinyint(1) NOT NULL DEFAULT '0',
  `discount_date` date DEFAULT NULL,
  `whole_sell_qty` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `whole_sell_discount` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_catalog` tinyint(1) NOT NULL DEFAULT '0',
  `catalog_id` int NOT NULL DEFAULT '0',
  `preordered` tinyint(1) NOT NULL DEFAULT '0',
  `minimum_qty` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_all` text,
  `color_price` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `stock_check` int NOT NULL DEFAULT '1',
  `cross_products` varchar(255) DEFAULT NULL,
  `popular` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `product_type`, `affiliate_link`, `user_id`, `category_id`, `subcategory_id`, `childcategory_id`, `attributes`, `name`, `slug`, `photo`, `thumbnail`, `file`, `size`, `size_qty`, `size_price`, `color`, `price`, `previous_price`, `details`, `stock`, `policy`, `status`, `views`, `tags`, `features`, `colors`, `product_condition`, `ship`, `is_meta`, `meta_tag`, `meta_description`, `youtube`, `type`, `license`, `license_qty`, `link`, `platform`, `region`, `licence_type`, `measure`, `featured`, `best`, `top`, `is_popular`, `hot`, `latest`, `big`, `trending`, `sale`, `created_at`, `updated_at`, `is_discount`, `discount_date`, `whole_sell_qty`, `whole_sell_discount`, `is_catalog`, `catalog_id`, `preordered`, `minimum_qty`, `color_all`, `color_price`, `stock_check`, `cross_products`, `popular`) VALUES
(430, 'oc709305P9dr', 'normal', NULL, 13, 21, 72, NULL, NULL, 'Organic Food Test Product Title will be here 134', 'organic-food-test-product-title-will-be-here-oc709305p9', '17302620590pli91C4.png', '1730262059NtkLxwqU.jpg', NULL, NULL, NULL, NULL, NULL, 190, 210, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', 100, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 3, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 17:32:13', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(431, 'oc709305P9yu', 'normal', NULL, 13, 21, 71, NULL, NULL, 'Organic Food Test Product Title will be here 130', 'organic-food-test-product-title-will-be-here-oc709305p9', '17302619356ENbf0bP.png', '1730261935pcP3lo9I.jpg', NULL, NULL, NULL, NULL, NULL, 120, 150, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', 100, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:31:03', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(432, 'oc709305P9ft', 'normal', NULL, 13, 22, 84, NULL, NULL, 'Organic Food Test Product Title will be here 129', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261878Yrv3Y7u7.png', '1730261878mzpJlB4n.jpg', NULL, NULL, NULL, NULL, NULL, 89, 99, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', 0, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, '2024-10-29 18:28:42', '2024-10-30 11:30:52', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(433, 'oc709305P9cxs', 'normal', NULL, 13, 22, 82, NULL, NULL, 'Organic Food Test Product Title will be here 128', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261776vO9P9Qpi.png', '1730261776nqG2giEY.jpg', NULL, NULL, NULL, NULL, NULL, 56, 62, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', 0, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:30:44', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(434, 'oc709305P9fdf', 'normal', NULL, 13, 22, 83, NULL, NULL, 'Organic Food Test Product Title will be here 126', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261702m2H8Xu4s.png', '1730261702Y3JbWxW1.jpg', NULL, NULL, NULL, NULL, NULL, 90, 140, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', 0, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 1, 0, 0, 0, '2024-10-29 18:28:42', '2024-10-30 11:30:07', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(435, 'oc709305P9fr', 'normal', NULL, 13, 27, NULL, 68, NULL, 'Organic Food Test Product Title will be here', 'organic-food-test-product-title-will-be-here-oc709305p9fr', '1730261624tQx5tgxJ.png', '1730261624yKfQeSgw.jpg', NULL, NULL, NULL, NULL, NULL, 85, 95, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', 0, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 6, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-11-01 11:03:12', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0),
(436, 'oc709305P9lo', 'normal', NULL, 0, 22, 81, 76, NULL, 'Organic Food Test Product Title will be here 122', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261521jhhbb4jJ.png', '1730261521J1GF376h.jpg', NULL, NULL, NULL, NULL, NULL, 84, 95, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:30:25', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(437, 'oc709305P9ki', 'normal', NULL, 0, 22, 84, NULL, NULL, 'Organic Food Test Product Title will be here 120', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261460IsOzD3IU.png', '1730261460s44r547S.jpg', NULL, NULL, NULL, NULL, NULL, 120, 150, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:29:57', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(438, 'oc709305P9nb', 'normal', NULL, 0, 22, 83, NULL, NULL, 'Organic Food Test Product Title will be here 119', 'organic-food-test-product-title-will-be-here-oc709305p9', '17302614067Ayrpy9S.png', '17302614060B7YpbHH.jpg', NULL, NULL, NULL, NULL, NULL, 50, 70, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:29:45', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1);
INSERT INTO `products` (`id`, `sku`, `product_type`, `affiliate_link`, `user_id`, `category_id`, `subcategory_id`, `childcategory_id`, `attributes`, `name`, `slug`, `photo`, `thumbnail`, `file`, `size`, `size_qty`, `size_price`, `color`, `price`, `previous_price`, `details`, `stock`, `policy`, `status`, `views`, `tags`, `features`, `colors`, `product_condition`, `ship`, `is_meta`, `meta_tag`, `meta_description`, `youtube`, `type`, `license`, `license_qty`, `link`, `platform`, `region`, `licence_type`, `measure`, `featured`, `best`, `top`, `is_popular`, `hot`, `latest`, `big`, `trending`, `sale`, `created_at`, `updated_at`, `is_discount`, `discount_date`, `whole_sell_qty`, `whole_sell_discount`, `is_catalog`, `catalog_id`, `preordered`, `minimum_qty`, `color_all`, `color_price`, `stock_check`, `cross_products`, `popular`) VALUES
(439, 'oc709305P9hv', 'normal', NULL, 0, 22, 82, NULL, NULL, 'Organic Food Test Product Title will be here 117', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261354AJDiCZ1O.png', '1730261354YwOegVcA.jpg', NULL, NULL, NULL, NULL, NULL, 120, 150, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, '2024-10-29 18:28:42', '2024-10-30 11:29:28', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(440, 'oc709305P9sx', 'normal', NULL, 0, 22, 81, 75, NULL, 'Organic Food Test Product Title will be here 116', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261280pLyN6XUY.png', '1730261280tTV5KiCT.jpg', NULL, NULL, NULL, NULL, NULL, 60, 99, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:26:52', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(441, 'oc709305P9sa', 'normal', NULL, 0, 22, 80, 71, NULL, 'Organic Food Test Product Title will be here 114', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261231bKfEIxKU.png', '1730261231XmyMeecf.jpg', NULL, NULL, NULL, NULL, NULL, 80, 100, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:26:40', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0),
(442, 'oc709305P9fd', 'normal', NULL, 0, 21, 72, NULL, NULL, 'Organic Food Test Product Title will be here 113', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261174Y77V2E5I.png', '1730261174SHE4sENE.jpg', NULL, NULL, NULL, NULL, NULL, 160, 180, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:26:29', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(443, 'oc709305P9fg', 'normal', NULL, 0, 21, 75, NULL, NULL, 'Organic Food Test Product Title will be here 112', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261115Xk3pkNyN.png', '17302611153PdkiPE8.jpg', NULL, NULL, NULL, NULL, NULL, 320, 350, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:26:15', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(444, 'oc709305P9wr', 'normal', NULL, 0, 21, 74, NULL, NULL, 'Organic Food Test Product Title will be here 111', 'organic-food-test-product-title-will-be-here-oc709305p9', '1730261051nV2tinn7.png', '17302610517TarHzun.jpg', NULL, NULL, NULL, NULL, NULL, 280, 300, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:26:06', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(445, 'oc709305P9ss', 'normal', NULL, 0, 25, NULL, NULL, NULL, 'Organic Food Test Product Title will be here 110', 'organic-food-test-product-title-will-be-here-110-oc709305p9ss', '1730260983jNo5ByJF.png', '1730260983FF15euyp.jpg', NULL, NULL, NULL, NULL, NULL, 320, 350, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-10-29 18:28:42', '2024-10-30 11:22:42', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0),
(446, 'oc709305P9we', 'normal', NULL, 0, 23, NULL, 65, NULL, 'Organic Food Test Product Title will be here 108', 'organic-food-test-product-title-will-be-here-108-oc709305p9we', '1730260824Ah6y9RZi.png', '1730260824wrynLlFq.jpg', NULL, NULL, NULL, NULL, NULL, 170, 200, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:25:56', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(447, 'oc709305P9kl', 'normal', NULL, 0, 21, 75, NULL, NULL, 'Organic Food Test Product Title will be here 107', 'organic-food-test-product-title-will-be-here-107-oc709305p9kl', '1730260593pldtSv4G.png', '1730260593OqaAygfQ.jpg', NULL, NULL, NULL, NULL, NULL, 120, 150, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:25:45', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1);
INSERT INTO `products` (`id`, `sku`, `product_type`, `affiliate_link`, `user_id`, `category_id`, `subcategory_id`, `childcategory_id`, `attributes`, `name`, `slug`, `photo`, `thumbnail`, `file`, `size`, `size_qty`, `size_price`, `color`, `price`, `previous_price`, `details`, `stock`, `policy`, `status`, `views`, `tags`, `features`, `colors`, `product_condition`, `ship`, `is_meta`, `meta_tag`, `meta_description`, `youtube`, `type`, `license`, `license_qty`, `link`, `platform`, `region`, `licence_type`, `measure`, `featured`, `best`, `top`, `is_popular`, `hot`, `latest`, `big`, `trending`, `sale`, `created_at`, `updated_at`, `is_discount`, `discount_date`, `whole_sell_qty`, `whole_sell_discount`, `is_catalog`, `catalog_id`, `preordered`, `minimum_qty`, `color_all`, `color_price`, `stock_check`, `cross_products`, `popular`) VALUES
(448, 'oc709305P9cv', 'normal', NULL, 0, 21, 72, NULL, NULL, 'Organic Food Test Product Title will be here 105', 'organic-food-test-product-title-will-be-here-105-oc709305p9cv', '1730260559ZWts4d2I.png', '1730260559VJBfT4o7.jpg', NULL, NULL, NULL, NULL, NULL, 220, 230, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:25:30', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(449, 'oc709305P9d', 'normal', NULL, 0, 21, 73, NULL, NULL, 'Organic Food Test Product Title will be here 104', 'organic-food-test-product-title-will-be-here-104-oc709305p9d', '1730260510DKVyoyB9.png', '1730260510piou7Bt1.jpg', NULL, NULL, NULL, NULL, NULL, 180, 200, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:25:23', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0),
(450, 'oc709305P9t', 'normal', NULL, 0, 21, 74, NULL, NULL, 'Organic Food Test Product Title will be here 103', 'organic-food-test-product-title-will-be-here-103-oc709305p9t', '1730260469V3VYAjkQ.png', '1730260469WUDM7uBc.jpg', NULL, NULL, NULL, NULL, NULL, 190, 220, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 1, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 11:25:16', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(451, 'eafdsdfsdf', 'normal', NULL, 0, 21, 73, NULL, NULL, 'Organic Food Test Product Title will be here 102', 'organic-food-test-product-title-will-be-here-102-eafdsdfsdf', '17302604206kknYrkg.png', '1730260420zhTHE76F.jpg', NULL, NULL, NULL, NULL, NULL, 160, 190, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', 17, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 2, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, '2024-10-29 18:28:42', '2024-10-30 18:56:54', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(452, 'oc709305P9r', 'normal', NULL, 0, 21, 76, 56, NULL, 'Organic Food Test Product Title will be here 101', 'organic-food-test-product-title-will-be-here-101-oc709305p9r', '1730259850PTEfFrxB.png', '1730259850jXCJ7s3z.jpg', NULL, NULL, NULL, NULL, NULL, 130, 150, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', 7, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 2, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 18:56:54', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0),
(453, 'oc709305P9s', 'normal', NULL, 0, 21, 77, 60, NULL, 'Organic Food Test Product Title will be here', 'organic-food-test-product-title-will-be-here-oc709305p9s', '1730262810w781nayq.png', '1730262810MppduuQJ.jpg', NULL, NULL, NULL, NULL, NULL, 120, 150, '<p>Bursting with flavor, these <strong>organic tomatoes</strong> are vine-ripened to perfection, bringing a naturally sweet and slightly tangy taste to any dish. Grown without synthetic pesticides or fertilizers, they’re a rich source of antioxidants, particularly lycopene, which supports heart health and boosts immunity.</p><p>Perfect for:</p><ul><li>Homemade sauces and salsas</li><li>Fresh salads and sandwiches</li><li>Roasting and grilling</li></ul><p><strong>Why Choose Organic?</strong>\r\nHandpicked at peak ripeness, these tomatoes ensure optimal flavor and nutritional value. By choosing organic, you’re supporting sustainable farming while enjoying cleaner, fresher produce for your family.</p>', NULL, '<h3>Buy Policy</h3><p><strong>1. Product Quality and Authenticity</strong><br>We guarantee that all products sold on our site are 100% organic, sourced from trusted suppliers, and meet the highest standards of quality. Our products are inspected and certified organic, ensuring freshness and purity for your peace of mind.</p><p><strong>2. Secure Payment Options</strong><br>We offer secure payment methods, including major credit cards, debit cards, and online payment gateways. All transactions are encrypted for your protection.</p><p><strong>3. Order Confirmation and Shipping</strong><br>Once you place an order, you will receive an order confirmation via email. Orders are typically processed within 1-2 business days, and shipping times may vary based on your location. For estimated delivery, please refer to our Shipping Policy.</p><hr><h3>Return Policy</h3><p><strong>1. Eligibility for Returns</strong><br>We accept returns on non-perishable items within <strong>30 days</strong> of purchase, provided that the item is unopened, unused, and in its original packaging. Unfortunately, due to the perishable nature of fresh produce, we cannot accept returns on fresh fruits, vegetables, and other perishable items.</p><p><strong>2. Damaged or Defective Products</strong><br>If your order arrives damaged, defective, or incorrect, please contact our Customer Support team within <strong>48 hours</strong> of delivery. We may require photos of the damaged item and packaging to process your claim.</p><p><strong>3. Return Process</strong><br>To initiate a return, please email us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> with your order number and reason for the return. Our team will guide you through the return process, including return shipping instructions.</p><p><strong>4. Refunds and Processing</strong><br>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. Approved refunds will be processed within <strong>7-10 business days</strong> back to your original payment method.</p><p><strong>5. Non-Returnable Items</strong><br>Items that are non-returnable include:</p><ul><li>Fresh produce and other perishable items</li><li>Opened or used food products</li><li>Gift cards and promotional items</li></ul><p><strong>6. Exchanges</strong><br>If you need to exchange a product, please contact our Customer Support. Exchanges are only accepted for non-perishable items in original condition.</p><p><strong>7. Customer Support</strong><br>For questions regarding returns, please contact us at <strong><a rel=\"noopener\">support@youremail.com</a></strong> or call <strong>[Customer Service Phone Number]</strong> during our business hours.</p>', 1, 5, NULL, NULL, '#000000', 0, '72hrs', 0, 'Organic,Food,OrganicFruits,fruits,vegetables', '\"Discover fresh, 100% organic foods, from fruits and vegetables to grains and snacks. Shop sustainably and enjoy pure, nutritious products delivered to your door.\"\r\n\r\n\"Shop our organic food store for premium fruits, vegetables, dairy, and pantry essentials. Certified organic and sustainably sourced for a healthier lifestyle.\"\r\n\r\n\"Explore a wide selection of organic food, including fresh produce, dairy, snacks, and more. Enjoy quality, sustainability, and convenience in every order.\"\r\n\r\n\"Your one-stop shop for organic food! Find farm-fresh produce, pantry staples, and delicious snacks that are pure, nutritious, and eco-friendly.\"\r\n\r\n\"Buy organic food online: fresh produce, grains, and snacks, all sustainably sourced and free from chemicals. Taste the difference of true organic quality.\"\r\n\r\nEach option is designed to attract users searching for clean, organic foods by highlighting product range, quality, and sustainability.', NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 1, 0, 1, 0, '2024-10-29 18:28:42', '2024-10-30 19:36:34', 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_clicks`
--

CREATE TABLE `product_clicks` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_clicks`
--

INSERT INTO `product_clicks` (`id`, `product_id`, `date`) VALUES
(1267, 430, '2024-10-29'),
(1268, 430, '2024-10-30'),
(1269, 451, '2024-10-30'),
(1270, 430, '2024-10-30'),
(1271, 453, '2024-10-30'),
(1272, 435, '2024-10-30'),
(1273, 452, '2024-10-30'),
(1274, 435, '2024-10-30'),
(1275, 435, '2024-10-30'),
(1276, 435, '2024-10-30'),
(1277, 453, '2024-10-30'),
(1278, 453, '2024-10-30'),
(1279, 453, '2024-10-30'),
(1280, 435, '2024-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rating` tinyint NOT NULL,
  `review_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `comment_id` int UNSIGNED NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int UNSIGNED NOT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint NOT NULL,
  `order_amount` double NOT NULL DEFAULT '0',
  `reward` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riders`
--

CREATE TABLE `riders` (
  `id` bigint NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fax` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_verify` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'No',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `state_id` int DEFAULT NULL,
  `city_id` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `balance` double DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riders`
--

INSERT INTO `riders` (`id`, `name`, `email`, `fax`, `zip`, `photo`, `password`, `email_verify`, `phone`, `address`, `location`, `email_token`, `country`, `state_id`, `city_id`, `status`, `balance`, `created_at`, `updated_at`) VALUES
(1, 'rider', 'rider@gmail.com', NULL, '1234', '1722147972auc-img4png.png', '$2y$10$oLoc49fhWrigz/sT87Y2C.WhLyfr9w2FEbXdU3on5.Wl2cox65j6i', 'Yes', '32434', 'dfasd', NULL, '0918f8dd5a200d445b0d97dd5ba4a318', 'Bangladesh', 14, 2, 0, 0, '2024-07-26 21:24:03', '2024-08-24 18:43:20'),
(2, 'Masud- Raider', 'masuduxi@gmail.com', NULL, NULL, '172449990521493848371jpg.jpg', '$2y$10$xYqlouFHemdVc.ksSia6ROKcDIBsYJcKReCHwTLecnPvmMWxoSdR.', 'Yes', '01792833800', 'DHaka', NULL, '6286fa8323d943bd368d3ecd40334c51', NULL, NULL, NULL, NULL, 0, '2024-08-24 18:44:24', '2024-08-24 18:45:05'),
(3, 'omer alamin', 'oalamin23@gmail.com', NULL, NULL, NULL, '$2y$10$LAmrBt7JIa6YlgAMGI8/6./EQt2FyZQIFMDAimkrJ8NdHnMog7ETO', 'Yes', '0555817278', 'saudi arabia', NULL, 'ad51935e724eaf58ce8a64de073fa483', NULL, NULL, NULL, 0, 0, '2024-09-30 19:21:58', '2024-10-10 18:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `rider_service_areas`
--

CREATE TABLE `rider_service_areas` (
  `id` bigint NOT NULL,
  `rider_id` int DEFAULT NULL,
  `city_id` int DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rider_service_areas`
--

INSERT INTO `rider_service_areas` (`id`, `rider_id`, `city_id`, `price`, `status`) VALUES
(2, 1, 1, 5, 1),
(4, 1, 4, 20, 1),
(5, 1, 2, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `section`) VALUES
(16, 'Manager', 'orders , categories , products , affilate_products , bulk_product_upload , product_discussion , set_coupons , customers , customer_deposits , vendors , vendor_subscriptions , vendor_verifications , vendor_subscription_plans , messages , general_settings , home_page_settings , menu_page_settings , payment_settings , social_settings , language_settings , seo_tools , subscribers'),
(17, 'Moderator', 'orders , products , customers , vendors , categories , blog , messages , home_page_settings , payment_settings , social_settings , language_settings , seo_tools , subscribers'),
(18, 'Staff', 'orders , products , vendors , vendor_subscription_plans , categories , blog , home_page_settings , menu_page_settings , language_settings , seo_tools , subscribers');

-- --------------------------------------------------------

--
-- Table structure for table `seotools`
--

CREATE TABLE `seotools` (
  `id` int UNSIGNED NOT NULL,
  `google_analytics` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `facebook_pixel` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keys` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seotools`
--

INSERT INTO `seotools` (`id`, `google_analytics`, `facebook_pixel`, `meta_keys`, `meta_description`) VALUES
(1, 'UA-137437974-1', 'UA-137437974-1', 'Genius,Ocean,Sea,Etc,SeaGenius', 'dsjhdeykfuyoty');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `user_id`, `title`, `details`, `photo`) VALUES
(10, 0, 'Manage Quality', 'Best Quality Gaurentee', '1667473770badgepng.png'),
(11, 0, 'Win $100 To Shop', 'Enter Now', '1667473742carts1png.png'),
(12, 0, 'Best Online Support', 'Hour: 10:00AM - 5:00PM', '1667473728customer-service-agentpng.png'),
(13, 0, 'Money Gurantee', 'With A 30 Days', '1667473683money-bagpng.png');

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `title` text,
  `subtitle` text,
  `price` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shippings`
--

INSERT INTO `shippings` (`id`, `user_id`, `title`, `subtitle`, `price`) VALUES
(1, 0, 'Free Shipping', '(10 - 12 days)', 0),
(2, 0, 'Express Shipping', '(5 - 6 days)', 10),
(5, 22, 'EMS', '8-15 Days', 26),
(7, 13, 'Basic', '7-10 Days', 5),
(8, 13, 'Standard', '4-7', 10),
(12, 13, 'Express', '3 Hours', 50);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int UNSIGNED NOT NULL,
  `subtitle_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `subtitle_size` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle_anime` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `title_size` varchar(50) DEFAULT NULL,
  `title_color` varchar(50) DEFAULT NULL,
  `title_anime` varchar(50) DEFAULT NULL,
  `details_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `details_size` varchar(50) DEFAULT NULL,
  `details_color` varchar(50) DEFAULT NULL,
  `details_anime` varchar(50) DEFAULT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `subtitle_text`, `subtitle_size`, `subtitle_color`, `subtitle_anime`, `title_text`, `title_size`, `title_color`, `title_anime`, `details_text`, `details_size`, `details_color`, `details_anime`, `photo`, `position`, `link`) VALUES
(15, 'Fresh from Nature', NULL, '#256a51', 'fadeIn', 'Pure & Organic!', NULL, '#256a51', 'fadeIn', 'Experience the goodness of fresh produce, handpicked and delivered to your door. We source products that are healthy for you and the planet.', NULL, '#000000', 'fadeIn', '1730268091Frame427318427-minpng.png', 'left', 'https://cleandemo.geniusocean.net/organic-king'),
(17, 'Dive In and Explore', NULL, '#256a51', NULL, 'Start Shopping Now!', NULL, '#000000', NULL, 'Explore our curated collections and find the perfect item that speaks to your style and needs. With just a click, begin your journey.', NULL, '#000000', NULL, '1730278447Frame427318428-minpng.png', NULL, 'https://cleandemo.geniusocean.net/organic-king');

-- --------------------------------------------------------

--
-- Table structure for table `socialsettings`
--

CREATE TABLE `socialsettings` (
  `id` int UNSIGNED NOT NULL,
  `facebook` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gplus` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkedin` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dribble` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_status` tinyint NOT NULL DEFAULT '1',
  `g_status` tinyint NOT NULL DEFAULT '1',
  `t_status` tinyint NOT NULL DEFAULT '1',
  `l_status` tinyint NOT NULL DEFAULT '1',
  `d_status` tinyint NOT NULL DEFAULT '1',
  `f_check` tinyint DEFAULT NULL,
  `g_check` tinyint DEFAULT NULL,
  `fclient_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fclient_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fredirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gclient_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gclient_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gredirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `socialsettings`
--

INSERT INTO `socialsettings` (`id`, `facebook`, `gplus`, `twitter`, `linkedin`, `dribble`, `f_status`, `g_status`, `t_status`, `l_status`, `d_status`, `f_check`, `g_check`, `fclient_id`, `fclient_secret`, `fredirect`, `gclient_id`, `gclient_secret`, `gredirect`) VALUES
(1, 'https://www.facebook.com/', 'https://plus.google.com/', 'https://twitter.com/', 'https://www.linkedin.com/', 'https://dribbble.com/', 1, 1, 1, 1, 1, 1, 1, '503140663460329', 'f66cd670ec43d14209a2728af26dcc43', 'https://dev.geniusocean.net/xcart/auth/facebook/callback', '904681031719-sh1aolu42k7l93ik0bkiddcboghbpcfi.apps.googleusercontent.com', 'yGBWmUpPtn5yWhDAsXnswEX3', 'https://dev.geniusocean.net/xcart/auth/google/callback');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `user_id`, `link`, `icon`, `status`) VALUES
(1, 0, 'https://www.facebook.com/', 'fab fa-facebook-f', 1),
(2, 0, 'https://twitter.com/', 'fab fa-twitter', 1),
(3, 0, 'https://linkedin.com/', 'fab fa-linkedin-in', 1),
(4, 0, 'https://www.google.com/', 'fab fa-google-plus-g', 1),
(5, 0, 'https://dribbble.com/', 'fab fa-dribbble', 1),
(6, 13, 'https://www.google.com/ss', 'fab fa-google', 1),
(7, 13, 'https://twitter.com/', 'fab fa-twitter', 1),
(8, 13, 'https://www.facebook.com/', 'fab fa-facebook', 1),
(9, 13, 'https://linkedin.com/', 'fab fa-linkedin', 1),
(10, 22, 'https://www.google.com/', 'fab fa-google', 1),
(12, 13, 'https://www.instagram.com/p/CgWO7-WKCsw/', 'fas fa-address-card', 1);

-- --------------------------------------------------------

--
-- Table structure for table `social_providers`
--

CREATE TABLE `social_providers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `provider_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint NOT NULL,
  `country_id` int NOT NULL DEFAULT '0',
  `state` varchar(111) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tax` double NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `owner_id` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `state`, `tax`, `status`, `owner_id`) VALUES
(2, 245, 'New Youk', 2, 1, 0),
(4, 246, 'Virginia', 4, 1, 0),
(5, 237, 'Sancta Sedes', 0, 1, 0),
(6, 246, 'Harare', 0, 1, 0),
(7, 245, 'Lusaka', 0, 1, 0),
(8, 244, 'Zinjibar', 0, 1, 0),
(9, 244, 'Mukalla', 0, 1, 0),
(10, 243, 'Smara', 0, 1, 0),
(11, 243, 'Hawza', 0, 0, 0),
(12, 242, 'Vaitupu', 0, 1, 0),
(13, 242, 'Leava', 0, 1, 0),
(14, 18, 'Dhaka', 2, 1, 0),
(15, 18, 'Comilla', 1, 1, 0),
(16, 1, 'Kabul', 0, 1, 0),
(17, 1, 'Kapisa', 0, 1, 0),
(18, 2, 'Fier', 0, 1, 0),
(19, 2, 'Korce', 0, 1, 0),
(20, 13, 'Victoria', 0, 1, 0),
(21, 13, 'Tasmania', 0, 1, 0),
(22, 14, 'Vienna', 0, 1, 0),
(23, 14, 'Styria', 0, 1, 0),
(24, 20, 'Brest Oblast', 0, 1, 0),
(25, 20, 'Vitebsk Oblast', 0, 1, 0),
(26, 100, 'Assam', 0, 1, 0),
(27, 100, 'Bihar', 0, 1, 0),
(28, 100, 'Bombay', 0, 1, 0),
(29, 183, 'Adygea', 0, 1, 0),
(30, 183, 'Buryatia', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `slug`, `status`) VALUES
(71, 21, 'Oranges', 'Oranges', 1),
(72, 21, 'Lemons', 'Lemons', 1),
(73, 21, 'Strawberries', 'Strawberries', 1),
(74, 21, 'Pineapples', 'Pineapples', 1),
(75, 21, 'Blueberries', 'Blueberries', 1),
(76, 21, 'Apples', 'Apples', 1),
(77, 21, 'Melon', 'Melon', 1),
(78, 21, 'Grapes', 'Grapes', 1),
(79, 22, 'Leafy Greens', 'Leafy-Greens', 1),
(80, 22, 'Root Vegetables', 'Root-Vegetables', 1),
(81, 22, 'Cruciferous Vegetables', 'Cruciferous-Vegetables', 1),
(82, 22, 'Squashes & Gourds', 'Squashes-n-Gourds', 1),
(83, 22, 'Tomatoes', 'Tomatoes', 1),
(84, 22, 'Herbs', 'Herbs', 1),
(85, 22, 'Stalk Vegetables', 'Stalk-Vegetables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`) VALUES
(8, 'shaon@gmail.com'),
(9, 'test@gmail.com'),
(10, 'shaoneel@gmail.com'),
(11, 'mojibur@gmail.com'),
(12, 'tretr@ter.d'),
(13, 'shaons@gmail.com'),
(14, 'shaon@gmail.coms'),
(15, 'junnuns@gmail.com'),
(16, 'admin@gmail.com'),
(17, 'user7@gmail.com'),
(18, 'farhadwts@gmail.com'),
(19, 'pronobsarker16@gmail.com'),
(20, 'shourav@gmail.com'),
(21, 'user@gmail.com'),
(22, 'seller@gmail.com'),
(23, 'teacher@gmail.com'),
(24, 'teacssher@gmail.com'),
(25, 'mdmasudrana852585@gmail.com'),
(26, 'masud.geniusocean@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `days` int NOT NULL,
  `allowed_products` int NOT NULL DEFAULT '0',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `title`, `price`, `days`, `allowed_products`, `details`) VALUES
(5, 'Standard', 60, 45, 25, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>'),
(6, 'Premium', 120, 90, 90, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>'),
(7, 'Unlimited', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>'),
(8, 'Basic', 0, 30, 0, '<ol><li>q345352sefasdfasd</li><li>asdf</li><li>asdfa</li><li>sdfasdf</li><li>asdf</li><li>asd</li><li>fasd</li><li>f</li></ol>');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `reward_point` double DEFAULT '0',
  `reward_dolar` double NOT NULL DEFAULT '0',
  `txn_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `amount` double DEFAULT '0',
  `currency_sign` blob,
  `currency_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_value` double NOT NULL DEFAULT '0',
  `method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txnid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'plus, minus',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `reward_point`, `reward_dolar`, `txn_number`, `amount`, `currency_sign`, `currency_code`, `currency_value`, `method`, `txnid`, `details`, `type`, `created_at`, `updated_at`) VALUES
(2, 22, 0, 0, 'bpF8893Brp', 20, 0x24, 'USD', 1, 'Paypal', '5HB63541N9371622P', 'Payment Deposit', 'plus', '2024-06-03 04:01:33', '2024-06-03 04:01:33'),
(3, 22, 0, 0, 'Ei8904201Y', 20, 0x24, 'USD', 1, 'Stripe', 'pi_3PNXkBJlIV5dN9n7083YGBB0', 'Payment Deposit', 'plus', '2024-06-03 04:04:02', '2024-06-03 04:04:02'),
(4, 22, 0, 0, NULL, 20, 0x24, 'USD', 1, 'Authorize.net', '80019532304', 'Payment Deposit', 'plus', '2024-06-03 04:05:41', '2024-06-03 04:05:41'),
(5, 22, 0, 0, 'Ogt9607bgN', 20, 0x24, 'USD', 1, 'Flutterwave', '5812410', 'Payment Deposit', 'plus', '2024-06-03 04:13:27', '2024-06-03 04:13:27'),
(6, 22, 0, 0, 'mN09959KNR', 0.29006526468455, 0xe282b9, 'INR', 68.95, 'Razorpay', 'pay_OIFiUHQnvbmZ75', 'Payment Deposit', 'plus', '2024-06-03 04:19:19', '2024-06-03 04:19:19'),
(11, 22, 0, 0, 'YPq2189Rza', 500, 0x24, 'USD', 1, 'Paypal', '4SB88894FL364091M', 'Payment Deposit', 'plus', '2024-08-25 12:03:09', '2024-08-25 12:03:09'),
(13, 22, 0, 0, 'Vuu2421Dv7', 10, 0x24, 'USD', 1, 'Paypal', '4V350692MC825910V', 'Payment Deposit', 'plus', '2024-10-15 18:40:21', '2024-10-15 18:40:21'),
(18, 22, 30, 45, 'A6A6090wbj', 45, 0x24, 'USD', 1, NULL, '0dW6090a4R', 'Reward Point Convert', 'plus', '2024-10-19 18:08:10', '2024-10-19 18:08:10'),
(19, 22, 0, 0, 'Xn3802184M', 100, 0x555344, 'USD', 1, 'Stripe', 'pi_3QERunJlIV5dN9n70CWet1q5', 'Payment Deposit', 'plus', '2024-10-27 15:33:41', '2024-10-27 15:33:41'),
(20, 22, 0, 0, 'lQj2011mrm', 100, 0x555344, 'USD', 1, 'Stripe', 'pi_3QESx9JlIV5dN9n71yfimG64', 'Payment Deposit', 'plus', '2024-10-27 16:40:11', '2024-10-27 16:40:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` int DEFAULT NULL,
  `city_id` int DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_provider` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0',
  `verification_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_verified` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `affilate_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `affilate_income` double NOT NULL DEFAULT '0',
  `shop_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `owner_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shop_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shop_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `reg_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shop_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shop_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shop_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `g_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `t_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `l_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_vendor` tinyint(1) NOT NULL DEFAULT '0',
  `f_check` tinyint(1) NOT NULL DEFAULT '0',
  `g_check` tinyint(1) NOT NULL DEFAULT '0',
  `t_check` tinyint(1) NOT NULL DEFAULT '0',
  `l_check` tinyint(1) NOT NULL DEFAULT '0',
  `mail_sent` tinyint(1) NOT NULL DEFAULT '0',
  `shipping_cost` double NOT NULL DEFAULT '0',
  `current_balance` double NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `ban` tinyint(1) NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `admin_commission` double NOT NULL DEFAULT '0',
  `reward` double NOT NULL DEFAULT '0',
  `email_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `photo`, `zip`, `city`, `country`, `state_id`, `city_id`, `address`, `phone`, `fax`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `is_provider`, `status`, `verification_link`, `email_verified`, `affilate_code`, `affilate_income`, `shop_name`, `owner_name`, `shop_number`, `shop_address`, `reg_number`, `shop_message`, `shop_details`, `shop_image`, `f_url`, `g_url`, `t_url`, `l_url`, `is_vendor`, `f_check`, `g_check`, `t_check`, `l_check`, `mail_sent`, `shipping_cost`, `current_balance`, `date`, `ban`, `balance`, `admin_commission`, `reward`, `email_token`) VALUES
(13, 'Vendor', '172449863143827598439863282516468658404389111216783442njpg.jpg', '1234', NULL, 'Bangladesh', 14, 2, NULL, '3453453345453411', '23123121', 'vendor@gmail.com', '$2y$10$.4NrvXAeyToa4x07EkFvS.XIUEc/aXGsxe1onkQ.Udms4Sl2W9ZYq', 'wYETkRwlCo03B4VCLHBB19EL3QUlSDps7up4UPQGvvaELtsbKI49zVUJfkdl', '2018-03-07 12:05:44', '2024-10-08 13:20:59', 0, 2, '$2y$10$oIf1at.0LwscVwaX/8h.WuSwMKEAAsn8EJ.9P7mWzNUFIcEBQs8ry', 'Yes', '$2y$10$oIf1at.0LwscVwaX/8h.WuSwMKEAAsn8EJ.9P7mWzNUFIcEBQs8rysdfsdfds', 4911.8, 'Test Stores', 'User', '43543534', 'Space Needle 400 Broad St, Seattles', 'asdasd', 'sdf', NULL, '171576858611145596211696846742png.png', NULL, NULL, NULL, NULL, 2, 0, 0, 0, 0, 1, 0, 803.25, '2024-11-07', 0, 0, 0, 0, NULL),
(22, 'User', '1725430197avatarpng.png', '1231', 'Test City', 'Bangladesh', 14, 2, 'Test Address', '+8801779888484', '34534534534', 'user@gmail.com', '$2y$10$5yvgZewDL.PUXz7DPAMsiuXC02Jidq04ormWrMzHDm/9GfLNvTUqm', 'P2GWaIPO9a4zcctng1Kz2ONSNWI5lvN2EZRBs1YFsx2xpsVucDtSkrTbTzlh', '2019-06-20 06:26:24', '2024-10-27 16:40:11', 0, 0, '1edae93935fba69d9542192fb854a80a', 'Yes', '8f09b9691613ecb8c3f7e36e34b97b80', 3994.431, 'Akeem Frederick', 'Sopoline Winters', '489', 'Sunt quasi alias mol', '884', 'Tenetur do perferend', NULL, '171576866311875262291696847114png.png', NULL, NULL, NULL, NULL, 2, 0, 0, 0, 0, 1, 0, 110, '2024-11-07', 0, 1030.2900652647, 0, 140, '778111dcc7c0ed6e625048f5bd8050df'),
(49, 'showrav Hasan', NULL, NULL, NULL, NULL, NULL, NULL, 'Tangail,Dhaka,Bangladesh', '017283320', NULL, 'user1@gmail.com', '$2y$10$wwtdyjC0fiJqRE5kzxlY4O53R.JiefIsSTEop4KwQ99P7zdcowt.W', NULL, '2024-09-04 02:11:37', '2024-09-04 02:11:37', 0, 0, '91fb756377de219c3d926716ca52b7b6', 'Yes', '2fce1dc8dcdc577729739c49bf72844e', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL),
(50, 'omer alamin', NULL, NULL, NULL, NULL, NULL, NULL, 'saudi arabia', '0555817278', NULL, 'oalamin23@gmail.com', '$2y$10$f1H0boABMpvAfiFTjnKO3uHTduSwa8PmZ.Op/BOWD2yxd3EehF.Zu', NULL, '2024-09-30 19:03:14', '2024-09-30 19:03:14', 0, 0, '92927b6cb4ad786ceee8c422b770eb85', 'Yes', 'aa891429605db3033b15f13397740d62', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL),
(51, 'Abdul Wahab', NULL, NULL, NULL, NULL, NULL, NULL, 'sdgghghsfdgasdfg', '0254555555', NULL, 'admin@gmail.com', '$2y$10$rKydy.6H5tncc01QBAOZ.OJJdgUuyoXFIsHIumisQf9zZrf32ZpnG', NULL, '2024-10-01 19:09:34', '2024-10-13 16:32:37', 0, 0, '49de7c86daeaf4cd41e77a08ec87b59e', 'Yes', 'b72e38ef6a774369c08ee0f2b24f31ad', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL),
(52, 'sium hossain', NULL, NULL, NULL, NULL, NULL, NULL, 'Dhaka-1212', '01905192544', NULL, 's@gmail.com', '$2y$10$u56s75Ag8A4bkXvNS6XxCOOLHmQaFKImpglb.tYAG0S9qBd0AZUJ.', NULL, '2024-10-13 17:11:25', '2024-10-14 07:36:14', 0, 0, '1f36d378f7c59af352a34952b8eb68ba', 'Yes', '11f6d6f5783c9c820eb1490b18613115', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 0, 0, NULL),
(53, 'farhad', NULL, NULL, NULL, 'Bangladesh', 14, 2, 'gdjcjckgg', '+8801779002301', NULL, 'farhadwts@gmail.com', '$2y$10$07mkNVDQONjvCEga/JIEKuzJWq2flGY8tq20sjLJ9MqPxZLUXi9se', NULL, '2024-10-16 11:40:35', '2024-10-16 11:40:35', 0, 0, NULL, 'Yes', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `user_id`, `order_number`, `is_read`, `created_at`, `updated_at`) VALUES
(16, 22, 'ZWMY1724136674', 0, '2024-08-20 13:51:14', '2024-08-20 13:51:14'),
(17, 131, 'ZWMY1724136674', 0, '2024-08-20 13:51:14', '2024-08-20 13:51:14'),
(18, 221, 'ZWMY1724136674', 0, '2024-08-20 13:51:14', '2024-08-20 13:51:14'),
(19, 13, 'ZW7o1725437595', 0, '2024-09-04 02:13:15', '2024-09-04 02:13:15'),
(20, 13, 'ajYN1727679156', 0, '2024-09-30 13:52:36', '2024-09-30 13:52:36'),
(21, 13, 'uQcG1727798402', 0, '2024-10-01 23:00:02', '2024-10-01 23:00:02'),
(22, 13, '9DOL1728214582', 0, '2024-10-06 18:36:22', '2024-10-06 18:36:22'),
(23, 13, 'XdOt1728374752', 0, '2024-10-08 15:05:52', '2024-10-08 15:05:52'),
(24, 13, 'c2LK1728654748', 0, '2024-10-11 20:52:28', '2024-10-11 20:52:28'),
(25, 13, 'Oz791728814069', 0, '2024-10-13 17:07:49', '2024-10-13 17:07:49'),
(26, 13, '9zZL1729334739', 0, '2024-10-19 17:45:39', '2024-10-19 17:45:39'),
(27, 13, 'f4TE1729502400', 0, '2024-10-21 16:20:00', '2024-10-21 16:20:00'),
(28, 13, 'BBdh1729502620', 0, '2024-10-21 16:23:40', '2024-10-21 16:23:40'),
(29, 13, 'pmH11729502654', 0, '2024-10-21 16:24:14', '2024-10-21 16:24:14'),
(30, 13, 'jaWo1729924362', 0, '2024-10-26 13:32:42', '2024-10-26 13:32:42'),
(31, 13, 'ol3f1729936517', 0, '2024-10-26 16:55:17', '2024-10-26 16:55:17'),
(32, 13, 'mSeF1730284398', 0, '2024-10-30 17:33:18', '2024-10-30 17:33:18'),
(33, 13, 'gUK21730284494', 0, '2024-10-30 17:34:54', '2024-10-30 17:34:54'),
(34, 13, 'S0y51730284530', 0, '2024-10-30 17:35:30', '2024-10-30 17:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `subscription_id` int NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_sign` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_value` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `days` int NOT NULL,
  `allowed_products` int NOT NULL DEFAULT '0',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Free',
  `txnid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flutter_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `payment_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_subscriptions`
--

INSERT INTO `user_subscriptions` (`id`, `user_id`, `subscription_id`, `title`, `currency_sign`, `currency_code`, `currency_value`, `price`, `days`, `allowed_products`, `details`, `method`, `txnid`, `charge_id`, `flutter_id`, `created_at`, `updated_at`, `status`, `payment_number`) VALUES
(84, 13, 5, 'Standard', '$', 'NGN', '1', 60, 45, 500, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>', 'Paystack', '242099342', NULL, NULL, '2019-10-10 02:35:29', '2019-10-10 02:35:29', 1, NULL),
(151, 13, 5, 'Standard', '$', 'USD', '1', 60, 45, 25, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>', 'Stripe', 'txn_1HlTPfJlIV5dN9n72gC9N5YJ', 'ch_1HlTPfJlIV5dN9n7dUMT6rYg', NULL, '2020-11-08 23:59:35', '2020-11-08 23:59:35', 1, NULL),
(152, 13, 5, 'Standard', '$', 'USD', '1', 60, 45, 25, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>', 'Paypal', '6KD881488A1277949', NULL, NULL, '2020-11-09 00:00:38', '2020-11-09 00:00:38', 1, NULL),
(153, 13, 5, 'Standard', '$', 'USD', '1', 60, 45, 25, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>', 'Paypal', '0R5121086C3908633', NULL, NULL, '2020-11-09 00:05:48', '2020-11-09 00:05:48', 1, NULL),
(154, 13, 5, 'Standard', '₦', 'NGN', '363.919', 60, 45, 25, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>', 'Paystack', '949523367', NULL, NULL, '2020-11-09 00:06:35', '2020-11-09 00:06:35', 1, NULL),
(155, 31, 5, 'Standard', '$', 'USD', '1', 60, 45, 25, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>', 'Free', NULL, NULL, NULL, '2020-11-09 02:00:24', '2020-11-09 02:00:24', 1, NULL),
(156, 22, 8, 'Basic', '$', 'USD', '1', 0, 30, 0, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>', 'Free', NULL, NULL, NULL, '2020-11-10 22:48:58', '2020-11-10 22:48:58', 1, NULL),
(157, 13, 7, 'Unlimited', '$', 'USD', '1', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'Free', NULL, NULL, NULL, '2020-11-11 00:22:09', '2020-11-11 00:22:09', 1, NULL),
(158, 13, 7, 'Unlimited', '$', 'USD', '1', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'Free', NULL, NULL, NULL, '2020-11-11 00:23:42', '2020-11-11 00:23:42', 1, NULL),
(159, 13, 7, 'Unlimited', '$', 'USD', '1', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'Molly', 'tr_GujuVzTkBB', NULL, NULL, '2021-09-11 22:00:44', '2021-09-11 22:00:44', 1, NULL),
(162, 22, 7, 'Unlimited', '৳', 'BDT', '84.63', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'SSLCommerz', 'SSLCZ_TXN_61b9c1097bc27', NULL, NULL, '2021-12-15 04:18:49', '2021-12-15 04:18:53', 1, NULL),
(163, 22, 7, 'Unlimited', '$', 'USD', '1', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'Stripe', 'txn_3K6ub5JlIV5dN9n70iNV3Ozl', 'ch_3K6ub5JlIV5dN9n70DG2D5OL', NULL, '2021-12-15 04:20:32', '2021-12-15 04:20:32', 1, NULL),
(164, 22, 7, 'Unlimited', '$', 'USD', '1', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'Stripe', 'txn_3K6ubRJlIV5dN9n70sRXFljG', 'ch_3K6ubRJlIV5dN9n70ckCrcKK', NULL, '2021-12-15 04:20:54', '2021-12-15 04:20:54', 1, NULL),
(165, 22, 7, 'Unlimited', '৳', 'BDT', '84.63', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'SSLCommerz', 'SSLCZ_TXN_61b9c1968d008', NULL, NULL, '2021-12-15 04:21:10', '2021-12-15 04:21:13', 1, NULL),
(166, 22, 7, 'Unlimited', '৳', 'BDT', '84.63', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'SSLCommerz', 'SSLCZ_TXN_61b9c212dc758', NULL, NULL, '2021-12-15 04:23:14', '2021-12-15 04:23:18', 1, NULL),
(167, 22, 7, 'Unlimited', '৳', 'BDT', '84.63', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'SSLCommerz', 'SSLCZ_TXN_61b9c2fc010c8', NULL, NULL, '2021-12-15 04:27:08', '2021-12-15 04:27:11', 1, NULL),
(168, 22, 7, 'Unlimited', '৳', 'BDT', '84.63', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'SSLCommerz', 'SSLCZ_TXN_61b9c31b72a00', NULL, NULL, '2021-12-15 04:27:39', '2021-12-15 04:27:42', 1, NULL),
(169, 22, 7, 'Unlimited', '৳', 'BDT', '84.63', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'SSLCommerz', 'SSLCZ_TXN_61b9c510f4116', NULL, NULL, '2021-12-15 04:36:01', '2021-12-15 04:36:04', 1, NULL),
(170, 22, 7, 'Unlimited', '৳', 'BDT', '84.63', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'SSLCommerz', 'SSLCZ_TXN_61b9c58ea2995', NULL, NULL, '2021-12-15 04:38:06', '2021-12-15 04:38:09', 1, NULL),
(171, 22, 7, 'Unlimited', '৳', 'BDT', '84.63', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'SSLCommerz', 'SSLCZ_TXN_61b9c5cc649ce', NULL, NULL, '2021-12-15 04:39:08', '2021-12-15 04:39:11', 1, NULL),
(172, 22, 5, 'Standard', '$', 'USD', '1', 60, 45, 25, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>', 'Stripe', 'txn_3KTjT0JlIV5dN9n70jJxJUry', 'ch_3KTjT0JlIV5dN9n70b9oPU0r', NULL, '2022-02-16 03:06:31', '2022-02-16 03:06:31', 1, NULL),
(173, 22, 8, 'Basic', '$', 'USD', '1', 0, 30, 0, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>', 'Free', NULL, NULL, NULL, '2022-09-21 02:11:49', '2022-09-21 02:11:49', 1, NULL),
(174, 22, 8, 'Basic', '$', 'USD', '1', 0, 30, 0, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>', 'Free', NULL, NULL, NULL, '2022-09-21 02:11:52', '2022-09-21 02:11:52', 1, NULL),
(175, 22, 7, 'Unlimited', '$', 'USD', '1', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'Stripe', 'pi_3O4yPOJlIV5dN9n70r3wrvTG', NULL, NULL, '2023-10-24 22:09:35', '2023-10-24 22:09:35', 1, NULL),
(176, 22, 7, 'Unlimited', '$', 'USD', '1', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'Stripe', 'pi_3O4yQGJlIV5dN9n70ZOHLiQb', NULL, NULL, '2023-10-24 22:10:28', '2023-10-24 22:10:28', 1, NULL),
(177, 22, 7, 'Unlimited', '$', 'USD', '1', 250, 365, 0, '<span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>', 'Paypal', '1EF267754X530482W', NULL, NULL, '2023-10-24 22:31:19', '2023-10-24 22:31:19', 1, NULL),
(178, 22, 8, 'Basic', '$', 'USD', '1', 0, 30, 0, '<ol><li>q345352sefasdfasd</li><li>asdf</li><li>asdfa</li><li>sdfasdf</li><li>asdf</li><li>asd</li><li>fasd</li><li>f</li></ol>', 'Free', NULL, NULL, NULL, '2024-10-07 14:11:25', '2024-10-07 14:11:25', 1, NULL),
(179, 22, 8, 'Basic', '$', 'USD', '1', 0, 30, 0, '<ol><li>q345352sefasdfasd</li><li>asdf</li><li>asdfa</li><li>sdfasdf</li><li>asdf</li><li>asd</li><li>fasd</li><li>f</li></ol>', 'Free', NULL, NULL, NULL, '2024-10-08 11:36:30', '2024-10-08 11:36:30', 1, NULL),
(180, 13, 8, 'Basic', '$', 'USD', '1', 0, 30, 0, '<ol><li>q345352sefasdfasd</li><li>asdf</li><li>asdfa</li><li>sdfasdf</li><li>asdf</li><li>asd</li><li>fasd</li><li>f</li></ol>', 'Free', NULL, NULL, NULL, '2024-10-08 13:20:59', '2024-10-08 13:20:59', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_orders`
--

CREATE TABLE `vendor_orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_id` int NOT NULL,
  `qty` int NOT NULL,
  `price` double NOT NULL,
  `order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','processing','completed','declined','on delivery') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor_orders`
--

INSERT INTO `vendor_orders` (`id`, `user_id`, `order_id`, `qty`, `price`, `order_number`, `status`, `created_at`) VALUES
(1, 13, 2, 1, 178.25, 'ol3f1729936517', 'pending', '2024-10-26 09:55:17'),
(2, 13, 5, 1, 204.5, 'mSeF1730284398', 'pending', '2024-10-30 10:33:18'),
(3, 13, 7, 1, 94.25, 'gUK21730284494', 'pending', '2024-10-30 10:34:54'),
(4, 13, 8, 2, 409, 'S0y51730284530', 'pending', '2024-10-30 10:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `verifications`
--

CREATE TABLE `verifications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `attachments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('Pending','Verified','Declined') DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `admin_warning` tinyint(1) NOT NULL DEFAULT '0',
  `warning_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `verifications`
--

INSERT INTO `verifications` (`id`, `user_id`, `attachments`, `status`, `text`, `admin_warning`, `warning_reason`, `created_at`, `updated_at`) VALUES
(10, 13, '17233654921567655174profilejpg.jpg,17233654921568889138banner2jpg.jpg', 'Verified', 'asdfasdf', 0, NULL, '2024-08-11 02:38:12', '2024-08-11 02:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

CREATE TABLE `withdraws` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iban` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `swift` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `amount` float DEFAULT NULL,
  `fee` float DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('pending','completed','rejected') NOT NULL DEFAULT 'pending',
  `type` enum('user','vendor','rider') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdraws`
--

INSERT INTO `withdraws` (`id`, `user_id`, `method`, `acc_email`, `iban`, `country`, `acc_name`, `address`, `swift`, `reference`, `amount`, `fee`, `created_at`, `updated_at`, `status`, `type`) VALUES
(1, 22, 'Paypal', 'teacher@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 9, 11, '2024-06-04 04:26:02', '2024-06-04 04:26:02', 'pending', 'user'),
(2, 22, 'Paypal', 'showrabhasan715@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 9, 11, '2024-06-04 04:26:16', '2024-06-04 04:28:47', 'completed', 'user'),
(3, 22, 'Bank', NULL, 'w5345', NULL, 'showrav Hasan', 'Munshinogor,Delduar,Tangail,Dhaka,Bangladesh', '52345', NULL, 9, 11, '2024-06-04 04:27:30', '2024-06-04 04:28:50', 'rejected', 'user'),
(4, 13, 'Paypal', 'showrabhasan75@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, -0.5, 10.5, '2024-08-11 09:52:49', '2024-08-11 09:53:24', 'rejected', 'user'),
(5, 13, 'Paypal', 'showrabhasan75@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 9, 11, '2024-08-11 09:53:38', '2024-08-11 09:54:55', 'rejected', 'user'),
(6, 13, 'Paypal', 'teacher@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 9, 11, '2024-08-11 09:55:04', '2024-08-11 09:55:12', 'completed', 'user'),
(7, 22, 'Paypal', 'hmshumon123@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 235.1, 22.9, '2024-08-20 06:43:18', '2024-08-20 06:46:32', 'rejected', 'user'),
(8, 22, 'Skrill', 'hmshumon123@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 256.95, 24.05, '2024-08-20 06:47:53', '2024-08-20 06:49:09', 'completed', 'user'),
(9, 13, 'Paypal', 'masud.geniusocean@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 9, 11, '2024-08-25 03:58:30', '2024-08-25 03:58:30', 'pending', 'vendor'),
(10, 13, 'Paypal', 'masud.geniusocean@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 9, 11, '2024-08-25 03:59:41', '2024-08-25 03:59:41', 'pending', 'vendor'),
(11, 13, 'Paypal', 'masud.geniusocean@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 9, 11, '2024-08-25 03:59:56', '2024-08-25 03:59:56', 'pending', 'vendor'),
(12, 13, 'Paypal', 'masud.geniusocean@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 37.5, 12.5, '2024-08-25 04:00:15', '2024-08-25 04:00:15', 'pending', 'vendor'),
(13, 22, 'Skrill', 'masud.geniusocean@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 9, 11, '2024-08-25 06:40:15', '2024-09-30 15:23:58', 'rejected', 'user'),
(14, 22, 'Paypal', 'showrabhasan715@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, -4.3, 10.3, '2024-09-03 08:51:59', '2024-09-30 15:23:50', 'completed', 'user'),
(15, 22, 'Paypal', 'user@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 85, 15, '2024-10-16 05:18:33', '2024-10-16 05:18:33', 'pending', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_languages`
--
ALTER TABLE `admin_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user_conversations`
--
ALTER TABLE `admin_user_conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user_messages`
--
ALTER TABLE `admin_user_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affliate_bonuses`
--
ALTER TABLE `affliate_bonuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arrival_sections`
--
ALTER TABLE `arrival_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_options`
--
ALTER TABLE `attribute_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `childcategories`
--
ALTER TABLE `childcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counters`
--
ALTER TABLE `counters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_riders`
--
ALTER TABLE `delivery_riders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorite_sellers`
--
ALTER TABLE `favorite_sellers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `generalsettings`
--
ALTER TABLE `generalsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_tracks`
--
ALTER TABLE `order_tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagesettings`
--
ALTER TABLE `pagesettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pickups`
--
ALTER TABLE `pickups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pickup_points`
--
ALTER TABLE `pickup_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `products` ADD FULLTEXT KEY `name` (`name`);
ALTER TABLE `products` ADD FULLTEXT KEY `attributes` (`attributes`);

--
-- Indexes for table `product_clicks`
--
ALTER TABLE `product_clicks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riders`
--
ALTER TABLE `riders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rider_service_areas`
--
ALTER TABLE `rider_service_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seotools`
--
ALTER TABLE `seotools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socialsettings`
--
ALTER TABLE `socialsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_providers`
--
ALTER TABLE `social_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_orders`
--
ALTER TABLE `vendor_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `admin_languages`
--
ALTER TABLE `admin_languages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_user_conversations`
--
ALTER TABLE `admin_user_conversations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin_user_messages`
--
ALTER TABLE `admin_user_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `affliate_bonuses`
--
ALTER TABLE `affliate_bonuses`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `arrival_sections`
--
ALTER TABLE `arrival_sections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `attribute_options`
--
ALTER TABLE `attribute_options`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `childcategories`
--
ALTER TABLE `childcategories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `counters`
--
ALTER TABLE `counters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `delivery_riders`
--
ALTER TABLE `delivery_riders`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `favorite_sellers`
--
ALTER TABLE `favorite_sellers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `fonts`
--
ALTER TABLE `fonts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=754;

--
-- AUTO_INCREMENT for table `generalsettings`
--
ALTER TABLE `generalsettings`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_tracks`
--
ALTER TABLE `order_tracks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pagesettings`
--
ALTER TABLE `pagesettings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pickups`
--
ALTER TABLE `pickups`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pickup_points`
--
ALTER TABLE `pickup_points`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=454;

--
-- AUTO_INCREMENT for table `product_clicks`
--
ALTER TABLE `product_clicks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1281;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riders`
--
ALTER TABLE `riders`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rider_service_areas`
--
ALTER TABLE `rider_service_areas`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `seotools`
--
ALTER TABLE `seotools`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `socialsettings`
--
ALTER TABLE `socialsettings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `social_providers`
--
ALTER TABLE `social_providers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `vendor_orders`
--
ALTER TABLE `vendor_orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
