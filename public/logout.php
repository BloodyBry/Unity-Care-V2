<?php
require_once __DIR__ . "/../app/Core/Session.php";

Session::start();
Session::destroy();

header("Location: login.php");
exit;
