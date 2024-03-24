<?php
require_once(__DIR__."/../config/settings.php");
session_start();

session_destroy();
header('Location: '.DEPLOY_PATH);
exit;

?>