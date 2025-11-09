<?php
require __DIR__ . '/_auth.php';
session_destroy();
header('Location: login.php');
exit;
