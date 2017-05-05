<?php
ini_set('session.gc_maxlifetime',(60*60*24*2)); 
ini_set('session.cookie_lifetime',(60*60*24*2));
include_once "common.php";

include_once $APP_PATH.APPLICATION."/App.php";
include_once $ENGINE_PATH."Utility/Debugger.php";
$logger = new Debugger();
$logger->setAppName(APPLICATION);
$logger->setDirectory($CONFIG['LOG_DIR']);
$app = new App();
$app->main();

print $app;
die();
?>
