<?php

$parts = explode(DIRECTORY_SEPARATOR, PATH_BASE);

// Defines.
define('DS', 					DIRECTORY_SEPARATOR);
define('PATH_ROOT',          	implode(DIRECTORY_SEPARATOR, $parts));
define('PATH_SITE',          	PATH_ROOT);
define('PATH_CONFIGURATION', 	PATH_ROOT);
define('PATH_COMPONENTS', 		PATH_ROOT . DS . 'components');