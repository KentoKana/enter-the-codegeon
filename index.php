<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
require_once './controllers/user-controller.php';
require_once './controllers/stage-controller.php';

$vars = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));
if($vars[0]==='enter-the-codegeon') array_shift($vars);

if(count($vars) % 2 == 1)
{
  $page = $vars[0];
  array_shift($vars);
}
else
{
  $page = 'index';
}

for($i = 0; $i < count($vars); $i += 2)
{
  $_GET[$vars[$i]] = $vars[$i + 1];
}

include "./views/" . $page . '.php';
?>
