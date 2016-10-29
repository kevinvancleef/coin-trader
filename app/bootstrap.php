<?php
declare(strict_types = 1);

error_reporting(E_ALL);

mb_internal_encoding("utf-8");
mb_http_output("utf-8");

date_default_timezone_set("Europe/Amsterdam");

require(__DIR__ . "/../vendor/autoload.php");
