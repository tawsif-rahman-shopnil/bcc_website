
CREATE TABLE `certificates` (
  `certificate_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `appreciation` text NOT NULL,
  `category` enum('member','contest','volunteer') NOT NULL,
  `image_file` varchar(255) NOT NULL,
  `pdf_file` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cp_control`
--

CREATE TABLE `cp_control` (
  `cp_mrking_factor` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cp_control`
--

-- --------------------------------------------------------

--
-- Table structure for table `executive_panel`
--

CREATE TABLE `executive_panel` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `profile_picture` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `panel_number` int(11) NOT NULL,
  `linkedin_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `programmers_alliance`
--

CREATE TABLE `programmers_alliance` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `profile_picture` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL UNIQUE, 
  `name` varchar(100) NOT NULL,
  `std_id` varchar(16) NOT NULL,
  `password` varchar(100) NOT NULL,
  `topcoder_handle` varchar(255) DEFAULT NULL,
  `hackerrank_handle` varchar(255) DEFAULT NULL,
  `codeforces_handle` varchar(255) NOT NULL UNIQUE,
  `leetcode_handle` varchar(255) DEFAULT NULL,
  `codechef_handle` varchar(255) DEFAULT NULL,
  `perform_mark` int(2) NOT NULL DEFAULT 0,
  `rating` varchar(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `programmer_of_the_month`
--
CREATE TABLE `programmer_of_the_month` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `std_id` varchar(100) NOT NULL,
  `month` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reg_member`
--

CREATE TABLE `reg_member` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `std_id` varchar(16) NOT NULL UNIQUE,
  `fullname` varchar(100) NOT NULL,
  `dept` varchar(100) NOT NULL,
  `session` varchar(45) NOT NULL,
  `admityr` year(4) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `c_number` varchar(13) NOT NULL UNIQUE,
  `gender` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user` int(11) NOT NULL PRIMARY KEY,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `authorization` enum('SuperUser','Advisor','AGS/JS') NOT NULL DEFAULT 'SuperUser'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `workshop_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `workshop_pdf` varchar(255) NOT NULL,
  `register_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

