<?php

// load composer dependencies
require '../vendor/autoload.php';
$env = file_get_contents("../.env");
$lines = explode("\n",$env);

foreach($lines as $line){
  preg_match("/([^#]+)\=(.*)/",$line,$matches);
  if(isset($matches[2])){
    putenv(trim($line));
  }
}

// Load our helpers
require_once '../app/helpers.php';

// Load our custom routes
require '../routes/web.php';

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::enableMultiRouteRendering(false);
// Start the routing
echo SimpleRouter::start();
