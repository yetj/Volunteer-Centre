-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 23 Lut 2020, 07:35
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `vc`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `actions`
--

CREATE TABLE `actions` (
  `id` mediumint(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description_short` text NOT NULL,
  `description_long` text,
  `logo` longblob NOT NULL,
  `logo_type` varchar(32) NOT NULL,
  `template_id` smallint(5) NOT NULL,
  `project_id` smallint(5) NOT NULL,
  `start` int(10) NOT NULL,
  `end` int(10) NOT NULL,
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `applications`
--

CREATE TABLE `applications` (
  `id` mediumint(8) NOT NULL,
  `project_id` mediumint(5) NOT NULL,
  `action_id` mediumint(5) NOT NULL,
  `date` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `feedback` text NOT NULL,
  `hash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `applications_comments`
--

CREATE TABLE `applications_comments` (
  `id` int(8) NOT NULL,
  `application_id` int(8) NOT NULL,
  `member_id` int(8) NOT NULL,
  `date` int(10) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `applications_reply`
--

CREATE TABLE `applications_reply` (
  `id` mediumint(12) NOT NULL,
  `application_id` mediumint(8) NOT NULL,
  `field_id` smallint(8) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `applications_votes`
--

CREATE TABLE `applications_votes` (
  `id` smallint(8) NOT NULL,
  `application_id` mediumint(8) NOT NULL,
  `member_id` mediumint(6) NOT NULL,
  `vote` int(5) NOT NULL,
  `date` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `global_templates`
--

CREATE TABLE `global_templates` (
  `id` smallint(5) NOT NULL,
  `name` varchar(128) NOT NULL,
  `img` blob NOT NULL,
  `img_type` varchar(32) NOT NULL,
  `parts` tinyint(3) NOT NULL,
  `html` text NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `global_templates`
--

INSERT INTO `global_templates` (`id`, `name`, `img`, `img_type`, `parts`, `html`, `deleted`) VALUES
(1, 'Jedna kolumna', 0x89504e470d0a1a0a0000000d4948445200000032000000320802000000915d1fe60000001974455874536f6674776172650041646f626520496d616765526561647971c9653c0000031869545874584d4c3a636f6d2e61646f62652e786d7000000000003c3f787061636b657420626567696e3d22efbbbf222069643d2257354d304d7043656869487a7265537a4e54637a6b633964223f3e203c783a786d706d65746120786d6c6e733a783d2261646f62653a6e733a6d6574612f2220783a786d70746b3d2241646f626520584d5020436f726520352e302d633036302036312e3133343334322c20323031302f30312f31302d31383a30363a34332020202020202020223e203c7264663a52444620786d6c6e733a7264663d22687474703a2f2f7777772e77332e6f72672f313939392f30322f32322d7264662d73796e7461782d6e7323223e203c7264663a4465736372697074696f6e207264663a61626f75743d222220786d6c6e733a786d703d22687474703a2f2f6e732e61646f62652e636f6d2f7861702f312e302f2220786d6c6e733a786d704d4d3d22687474703a2f2f6e732e61646f62652e636f6d2f7861702f312e302f6d6d2f2220786d6c6e733a73745265663d22687474703a2f2f6e732e61646f62652e636f6d2f7861702f312e302f73547970652f5265736f75726365526566232220786d703a43726561746f72546f6f6c3d2241646f62652050686f746f73686f70204353352220786d704d4d3a496e7374616e636549443d22786d702e6969643a32444543383835324237393331314538384232454535373544434630443746392220786d704d4d3a446f63756d656e7449443d22786d702e6469643a3244454338383533423739333131453838423245453537354443463044374639223e203c786d704d4d3a4465726976656446726f6d2073745265663a696e7374616e636549443d22786d702e6969643a3244454338383530423739333131453838423245453537354443463044374639222073745265663a646f63756d656e7449443d22786d702e6469643a3244454338383531423739333131453838423245453537354443463044374639222f3e203c2f7264663a4465736372697074696f6e3e203c2f7264663a5244463e203c2f783a786d706d6574613e203c3f787061636b657420656e643d2272223f3eee00f0400000008c4944415478daecd2210ec420104661661c828b20b8009e63730ace81c2d2dda634ddaca8a86840bc67fee0be84318688e82619e39c4b2989c85c4dceb9d6fa7b7bef3f0b14631c1e1db31d4dffbbdefb1f6b6fc7ae735bbae6c9c382050b162c58b060c182050b162c58b060c18205eb4596aa2ec792a3e99acb708eb53684305d564a69ad197ad657800100a8159cf120c9b74b0000000049454e44ae426082, 'image/png', 1, '<div class=\"container\">\r\n  <div class=\"row\">\r\n    <div class=\"col-sm\">\r\n      {%PART_1%}\r\n    </div>\r\n  </div>\r\n</div>', 0),
(2, 'Dwie kolumny', 0x89504e470d0a1a0a0000000d4948445200000032000000320802000000915d1fe60000001974455874536f6674776172650041646f626520496d616765526561647971c9653c0000031869545874584d4c3a636f6d2e61646f62652e786d7000000000003c3f787061636b657420626567696e3d22efbbbf222069643d2257354d304d7043656869487a7265537a4e54637a6b633964223f3e203c783a786d706d65746120786d6c6e733a783d2261646f62653a6e733a6d6574612f2220783a786d70746b3d2241646f626520584d5020436f726520352e302d633036302036312e3133343334322c20323031302f30312f31302d31383a30363a34332020202020202020223e203c7264663a52444620786d6c6e733a7264663d22687474703a2f2f7777772e77332e6f72672f313939392f30322f32322d7264662d73796e7461782d6e7323223e203c7264663a4465736372697074696f6e207264663a61626f75743d222220786d6c6e733a786d703d22687474703a2f2f6e732e61646f62652e636f6d2f7861702f312e302f2220786d6c6e733a786d704d4d3d22687474703a2f2f6e732e61646f62652e636f6d2f7861702f312e302f6d6d2f2220786d6c6e733a73745265663d22687474703a2f2f6e732e61646f62652e636f6d2f7861702f312e302f73547970652f5265736f75726365526566232220786d703a43726561746f72546f6f6c3d2241646f62652050686f746f73686f70204353352220786d704d4d3a496e7374616e636549443d22786d702e6969643a44394535303032434237393231314538424346334545373833464139394631382220786d704d4d3a446f63756d656e7449443d22786d702e6469643a4439453530303244423739323131453842434633454537383346413939463138223e203c786d704d4d3a4465726976656446726f6d2073745265663a696e7374616e636549443d22786d702e6969643a4439453530303241423739323131453842434633454537383346413939463138222073745265663a646f63756d656e7449443d22786d702e6469643a4439453530303242423739323131453842434633454537383346413939463138222f3e203c2f7264663a4465736372697074696f6e3e203c2f7264663a5244463e203c2f783a786d706d6574613e203c3f787061636b657420656e643d2272223f3ed8ba093b000000da4944415478daecd8a10e83301006605a87a8a9c637a9c0133cefd097e823f60d70e8fa1a140e58d7ac0904b12c1c5b4296ff3757cce5a35c1057140882206fc2721142745dc718a3b460acef7bef7d3a5755d5344d8c91a671ce8de3b83f6bade385586b731f63cc953e6ddbe63e3c97c72be43b9fe7391f9665b9f2edd6753db052c837ff8bf07b8e3c586081051658608105165860810516586081f5b72cac46ceb068ab408c3c589f599cd389db5c7e6b40f9d6ee0e23bfbf5e2e6559d6754ddecb7bef4308e92ca5544a917f81c3304cd35420e7f21460001aa1ae3db94bd8c20000000049454e44ae426082, 'image/png', 2, '<div class=\"container\">\r\n  <div class=\"row\">\r\n    <div class=\"col-sm\">\r\n      {%PART_1%}\r\n    </div>\r\n    <div class=\"col-sm\">\r\n      {%PART_2%}\r\n    </div>\r\n  </div>\r\n</div>', 0),
(3, 'Dwie kolumny i cała kolumna', 0x89504e470d0a1a0a0000000d4948445200000032000000320802000000915d1fe60000001974455874536f6674776172650041646f626520496d616765526561647971c9653c0000031869545874584d4c3a636f6d2e61646f62652e786d7000000000003c3f787061636b657420626567696e3d22efbbbf222069643d2257354d304d7043656869487a7265537a4e54637a6b633964223f3e203c783a786d706d65746120786d6c6e733a783d2261646f62653a6e733a6d6574612f2220783a786d70746b3d2241646f626520584d5020436f726520352e302d633036302036312e3133343334322c20323031302f30312f31302d31383a30363a34332020202020202020223e203c7264663a52444620786d6c6e733a7264663d22687474703a2f2f7777772e77332e6f72672f313939392f30322f32322d7264662d73796e7461782d6e7323223e203c7264663a4465736372697074696f6e207264663a61626f75743d222220786d6c6e733a786d703d22687474703a2f2f6e732e61646f62652e636f6d2f7861702f312e302f2220786d6c6e733a786d704d4d3d22687474703a2f2f6e732e61646f62652e636f6d2f7861702f312e302f6d6d2f2220786d6c6e733a73745265663d22687474703a2f2f6e732e61646f62652e636f6d2f7861702f312e302f73547970652f5265736f75726365526566232220786d703a43726561746f72546f6f6c3d2241646f62652050686f746f73686f70204353352220786d704d4d3a496e7374616e636549443d22786d702e6969643a46373145333445374237393331314538413433334246443145424541323832362220786d704d4d3a446f63756d656e7449443d22786d702e6469643a4637314533344538423739333131453841343333424644314542454132383236223e203c786d704d4d3a4465726976656446726f6d2073745265663a696e7374616e636549443d22786d702e6969643a4637314533344535423739333131453841343333424644314542454132383236222073745265663a646f63756d656e7449443d22786d702e6469643a4637314533344536423739333131453841343333424644314542454132383236222f3e203c2f7264663a4465736372697074696f6e3e203c2f7264663a5244463e203c2f783a786d706d6574613e203c3f787061636b657420656e643d2272223f3ebc254097000001174944415478daec97316a85401086dfae5a5828587b03055b415bf10a7a09afe611c40b888db5b58d56766a36e2bee4f1425264360f0dfc5f33b3cdf031bb2c33b71b0000fc0093c1b2ac344d196394128c354dd3f7fd9ebbae1b45911082665355d5344d8fb3e7794281a228649d3ccf55eac4712ceb7019de0ec83d5f964526ebbaaadcddb66d4f5a3be4cebf027ecd270f2d68410b5ad08216b4fe89166d347dad96a6699cd33b6718864c745d57b1d9359e6679dbb6932421cff26ddb7ecef2611892b5eaba1ec7111b166d21731c27cb3295e7f5279465390cc3e3ecfbbeb8005f17b2ede0f4bbfb6621c32f0f2d68410b5ad082d63de3fc725aece0fce9efc3e11e4cd30c82e074b3aeebe679c670fe4bde051800731a4201dee5ca520000000049454e44ae426082, 'image/png', 3, '<div class=\"container\">\r\n  <div class=\"row\">\r\n    <div class=\"col-sm\">\r\n      {%PART_1%}\r\n    </div>\r\n    <div class=\"col-sm\">\r\n      {%PART_2%}\r\n    </div>\r\n  </div>\r\n  <div class=\"row\">\r\n    <div class=\"col-sm\">\r\n      {%PART_3%}\r\n    </div>\r\n  </div>\r\n</div>', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs`
--

CREATE TABLE `logs` (
  `id` mediumint(6) NOT NULL,
  `member_id` mediumint(6) NOT NULL,
  `date` int(10) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `project_id` smallint(5) NOT NULL DEFAULT '0',
  `controller` varchar(64) NOT NULL,
  `action` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `members`
--

CREATE TABLE `members` (
  `id` mediumint(6) NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(256) NOT NULL,
  `joined` int(10) NOT NULL,
  `login_key` varchar(64) NOT NULL,
  `login_key_expire` int(10) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(5) NOT NULL,
  `access` tinyint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Zrzut danych tabeli `members`
--

INSERT INTO `members` (`id`, `email`, `name`, `joined`, `login_key`, `login_key_expire`, `password`, `salt`, `access`) VALUES
(1, 'mail@gmail.com', 'Administrator', 2147483647, '41872a354a58a8ba62fb1f3b90637310', 1582525516, 'a0ba4314f6996d6c3e9f944f60a6375cbb532fe9991c40f4eedfb9e405505393', 'unewe', 31);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pages`
--

CREATE TABLE `pages` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `project_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(30) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `system` tinyint(1) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  `hidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `pages`
--

INSERT INTO `pages` (`id`, `project_id`, `title`, `slug`, `content`, `system`, `sort`, `display`, `hidden`) VALUES
(1, 1, 'Witamy na wspaniałej stronie!', 'index', '<section class=\"jumbotron text-center\"><img style=\"width: 100%;\" src=\"../../../../../../img/volunteering.png\" /> <br /><br /><br />\r\n<h1 class=\"jumbotron-heading\">O projekcie</h1>\r\n<p class=\"lead text-muted\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<br /><br /><a href=\"../../../../../../global/index/page/show/register\"><button class=\"btn btn-success btn-lg\" type=\"button\">Zarejestruj się już teraz</button></a></section>', 1, 0, 1, 0),
(3, 1, 'Rejestracja projektu', 'register', '<section class=\"jumbotron text-center\">\r\n        <div class=\"container\">\r\n		  <img src=\"/img/volunteering.png\" style=\"width:100%\"/>\r\n          <br><br><br>\r\n		  <h1 class=\"jumbotron-heading\">Zasady i proces rejestracji</h1>\r\n          <p class=\"lead text-muted\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n        </div>\r\n      </section>\r\n\r\n\r\n      <!-- Marketing messaging and featurettes\r\n      ================================================== -->\r\n      <!-- Wrap the rest of the page in another container to center all the content. -->\r\n\r\n	  \r\n	  \r\n      <div class=\"container marketing\">\r\n			<h1 class=\"jumbotron-heading\">Formularz rejestracyjny</h1>\r\n			<br><br>\r\n			<form class=\"needs-validation\" novalidate>\r\n  <div class=\"form-row\">\r\n    <div class=\"col-md-4 mb-3\">\r\n      <label for=\"validationCustom01\">Login</label>\r\n      <input type=\"text\" class=\"form-control\" id=\"validationCustom01\" placeholder=\"Login\" value=\"\" required>\r\n      <div class=\"invalid-feedback\">\r\n        Wybrany login nie jest poprawny!\r\n      </div>\r\n      <div class=\"valid-feedback\">\r\n        Ok!\r\n      </div>\r\n    </div>\r\n    <div class=\"col-md-4 mb-3\">\r\n      <label for=\"validationEmail\">E-mail</label>\r\n      <div class=\"input-group\">\r\n        <div class=\"input-group-prepend\">\r\n          <span class=\"input-group-text\" id=\"inputGroupPrepend\">@</span>\r\n        </div>\r\n        <input type=\"email\" class=\"form-control\" id=\"validationEmail\" placeholder=\"E-mail\" aria-describedby=\"inputGroupPrepend\" required>\r\n        <div class=\"invalid-feedback\">\r\n          Wprowadzony adres e-mail nie jest poprawny!\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </div>\r\n  <div class=\"form-row\">\r\n    <div class=\"col-md-4 mb-3\">\r\n      <label for=\"validationCustom02\">Hasło</label>\r\n      <input type=\"password\" class=\"form-control\" id=\"validationCustom02\" placeholder=\"Hasło\" required>\r\n      <div class=\"invalid-feedback\">\r\n        Hasło nie spełnia podstawowych wymagań.\r\n      </div>\r\n    </div>\r\n    <div class=\"col-md-4 mb-3\">\r\n      <label for=\"validationCustom03\">Powtórz hasło</label>\r\n      <input type=\"password\" class=\"form-control\" id=\"validationCustom03\" placeholder=\"Powtórz hasło\" required>\r\n      <div class=\"invalid-feedback\">\r\n        Wprowadzone hasłą nie są takie same.\r\n      </div>\r\n    </div>\r\n  </div>\r\n  <div class=\"form-row\">\r\n    <div class=\"col-md-8 mb-3\">\r\n      <label for=\"validationCustom04\">Nazwa organizacji</label>\r\n      <input type=\"text\" class=\"form-control\" id=\"validationCustom04\" placeholder=\"Nazwa organizacji\" required>\r\n      <div class=\"invalid-feedback\">\r\n        Nazwa organizacji nie jest poprawna\r\n      </div>\r\n    </div>\r\n  </div>\r\n  <div class=\"form-row\">\r\n    <div class=\"col-md-8 mb-3\">\r\n      <label for=\"validationDescription\">Opis organizacji<br />\r\n	  <small class=\"text-muted font-italic\">Czym zajmuje się organizacja? Do jakich celów potrzebuje wolontaroiszy?<br />Im więcej szczegółów, tym łatwiej nam będzie zweryfikować czy pasuje ona do naszych standardów.</small></label>\r\n	  <textarea name=\"content\" class=\"form-control\" id=\"validationDescription\" placeholder=\"Opis organizacji\" required></textarea>\r\n      <div class=\"invalid-feedback\">\r\n        Opis organizacji jest zbyt krótki...\r\n      </div>\r\n    </div>\r\n  </div>\r\n  <div class=\"form-group\">\r\n    <div class=\"form-check\">\r\n      <input class=\"form-check-input\" type=\"checkbox\" value=\"\" id=\"invalidCheck\" required>\r\n      <label class=\"form-check-label\" for=\"invalidCheck\">\r\n        Potwierdzam, że zapoznałem się z <a href=\"#\">regulaminem</a> i <a href=\"#\">polityką prywatności<a/>.\r\n      </label>\r\n      <div class=\"invalid-feedback\">\r\n        Musisz potwierdzić, że zapoznałeś się z regulaminem i polityką prywatności\r\n      </div>\r\n    </div>\r\n  </div>\r\n  <div class=\"form-row\">\r\n    <div class=\"col-md-8 mb-3\">\r\n		<button class=\"btn btn-primary float-right\" type=\"submit\">Wyślij zgłoszenie</button>\r\n    </div>\r\n  </div>\r\n</form>\r\n\r\n<script>\r\n// Example starter JavaScript for disabling form submissions if there are invalid fields\r\n(function() {\r\n  \'use strict\';\r\n  window.addEventListener(\'load\', function() {\r\n    // Fetch all the forms we want to apply custom Bootstrap validation styles to\r\n    var forms = document.getElementsByClassName(\'needs-validation\');\r\n    // Loop over them and prevent submission\r\n    var validation = Array.prototype.filter.call(forms, function(form) {\r\n      form.addEventListener(\'submit\', function(event) {\r\n        if (form.checkValidity() === false) {\r\n          event.preventDefault();\r\n          event.stopPropagation();\r\n        }\r\n        form.classList.add(\'was-validated\');\r\n      }, false);\r\n    });\r\n  }, false);\r\n})();\r\n</script>\r\n\r\n        <hr class=\"featurette-divider\">\r\n', 1, 1, 1, 0),
(27, 1, 'Regulamin', 'regulamin', '<p style=\"text-align: center;\"><span style=\"font-size: 18pt;\"><strong>Regulamin</strong></span></p>\r\n<ol>\r\n<li style=\"text-align: left;\">Punkt pierwszy</li>\r\n<li style=\"text-align: left;\">Punkt drugi</li>\r\n<li style=\"text-align: left;\">Punkt trzeci</li>\r\n</ol>', 1, 3, 1, 1),
(30, 1, 'Polityka prywatności', 'polityka-prywatnosci', '<p>Polityka prywatności&nbsp;</p>', 1, 4, 1, 1),
(31, 1, 'Lista akcji', 'apply', '', 1, 2, 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projects`
--

CREATE TABLE `projects` (
  `id` smallint(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `logo` blob,
  `short_description` text,
  `long_description` text,
  `owner_id` mediumint(6) NOT NULL DEFAULT '0',
  `settings` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `projects`
--

INSERT INTO `projects` (`id`, `name`, `slug`, `logo`, `short_description`, `long_description`, `owner_id`, `settings`, `status`) VALUES
(1, 'Volunteer centre', 'global', '', 'Strona główna', 'Strona główna', 0, '', 1);
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projects_access`
--

CREATE TABLE `projects_access` (
  `project_id` smallint(5) NOT NULL,
  `member_id` mediumint(8) NOT NULL,
  `access` int(8) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projects_requests`
--

CREATE TABLE `projects_requests` (
  `id` smallint(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `long_description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `requester_name` varchar(32) NOT NULL,
  `requester_email` varchar(32) NOT NULL,
  `requester_contact` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `templates`
--

CREATE TABLE `templates` (
  `id` smallint(5) NOT NULL,
  `name` varchar(128) NOT NULL,
  `project_id` smallint(5) NOT NULL,
  `global_template_id` smallint(5) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `templates_fields`
--

CREATE TABLE `templates_fields` (
  `id` smallint(5) NOT NULL,
  `template_id` smallint(5) NOT NULL,
  `name` varchar(256) NOT NULL,
  `position` tinyint(3) NOT NULL,
  `type` varchar(32) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `defaults` text NOT NULL,
  `options` text NOT NULL,
  `hash` varchar(64) NOT NULL,
  `sort` int(6) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications_comments`
--
ALTER TABLE `applications_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `applications_reply`
--
ALTER TABLE `applications_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Indexes for table `applications_votes`
--
ALTER TABLE `applications_votes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_templates`
--
ALTER TABLE `global_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `slug` (`slug`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug_2` (`slug`),
  ADD KEY `slug` (`slug`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `projects_access`
--
ALTER TABLE `projects_access`
  ADD PRIMARY KEY (`project_id`,`member_id`) USING BTREE;

--
-- Indexes for table `projects_requests`
--
ALTER TABLE `projects_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates_fields`
--
ALTER TABLE `templates_fields`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `actions`
--
ALTER TABLE `actions`
  MODIFY `id` mediumint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `applications`
--
ALTER TABLE `applications`
  MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;
--
-- AUTO_INCREMENT dla tabeli `applications_comments`
--
ALTER TABLE `applications_comments`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `applications_reply`
--
ALTER TABLE `applications_reply`
  MODIFY `id` mediumint(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=478;
--
-- AUTO_INCREMENT dla tabeli `applications_votes`
--
ALTER TABLE `applications_votes`
  MODIFY `id` smallint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT dla tabeli `global_templates`
--
ALTER TABLE `global_templates`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `logs`
--
ALTER TABLE `logs`
  MODIFY `id` mediumint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
--
-- AUTO_INCREMENT dla tabeli `members`
--
ALTER TABLE `members`
  MODIFY `id` mediumint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT dla tabeli `pages`
--
ALTER TABLE `pages`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT dla tabeli `projects`
--
ALTER TABLE `projects`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `projects_requests`
--
ALTER TABLE `projects_requests`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `templates`
--
ALTER TABLE `templates`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT dla tabeli `templates_fields`
--
ALTER TABLE `templates_fields`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
