<?php

ob_start();
require_once PATH_CONFIGURATION . '/configuration.php';
ob_end_clean();

use DoyouWatch\Config;
// System configuration.

// Set the error_reporting
switch (Config::getInstance()->get('error_reporting'))
{
	case 'default':
	case '-1':
		break;

	case 'none':
	case '0':
		error_reporting(0);

		break;

	case 'simple':
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		ini_set('display_errors', 1);

		break;

	case 'maximum':
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		break;

	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);

		break;

	default:
		error_reporting(Config::getInstance()->get('error_reporting'));
		ini_set('display_errors', 1);

		break;
}