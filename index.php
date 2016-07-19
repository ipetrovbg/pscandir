<?php
require 'pscan.php';

$scan = new pscandir();
$scan->setConfiqSmall(150);

$scan->scan(__DIR__ . DIRECTORY_SEPARATOR);