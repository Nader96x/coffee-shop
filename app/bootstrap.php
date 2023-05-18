<?php

require_once 'config/config.php';

require_once 'helpers/urlHelper.php';
require_once 'helpers/sessionHelper.php';
require_once 'helpers/authorization.php';


spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
});