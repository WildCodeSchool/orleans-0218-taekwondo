<?php
/**
 * This file define app constants .
 *
 * PHP version 7
 *
 * @author   WCS <contact@wildcodeschool.fr>
 *
 * @link     https://github.com/WildCodeSchool/simple-mvc
 */


define('APP_DEV', true);

// Model (for connexion data, see unversionned db.php)
// View
define('APP_VIEW_PATH', __DIR__ . '/../src/View/');
define('APP_CACHE_PATH', __DIR__ . '/../temp/cache/');

// Controller
define('APP_CONTROLLER_NAMESPACE', '\Controller\\');
define('APP_CONTROLLER_SUFFIX', 'Controller');

// Custom parameters
define('MAP_ACCESS_TOKEN', 'pk.eyJ1IjoidGFla3dvbmRvb2xpdmV0IiwiYSI6ImNqZmt3bGxhYTA5czgyeG43NzE5d2tucTIifQ.BZ5b1i4ZN9PMGbJ-1W4e3w');
define('BASE_ROOT', __DIR__ . '/../public');
define('UPLOADS_PATH', 'assets/uploads');
define('UPLOADS_PATH_EVENTS', '/assets/uploads/events/');
define('UPLOADS_PATH_OFFICES', '/assets/uploads/offices/');
define('ALLOWED_TYPES', ['jpg', 'jpeg', 'png']);
define('MAX_UPLOAD_SIZE', 1000000);

// SwiftMailer ans Google account paramters
define('APP_MAIL_HOST', '');
define('APP_MAIL_PORT', '');
define('APP_MAIL_SECURITY', '');
define('APP_MAIL_NAME', '');
define('APP_MAIL_PWD', '');
define('APP_MAIL_TO', '');
define('APP_MAIL_SUBJECT', '');
define('APP_CAPTCHA_SECRET_KEY', '');
define('APP_CAPTCHA_SITE_KEY', '');