<?php
require 'pscan.php';

$scan = new pscandir();
$scan->changeExistingSizeByKey('thumb', array('folder_name'=>'changed-thumb', 'folder_size'=>800));
//$scan->deleteFolderByName('larg');
//$scan->addSize(array('folder_name'=>'new-petar', 'folder_size'=>200, 'crop'=>true));
//$scan->scanAndResize(__DIR__ . DIRECTORY_SEPARATOR);
echo '<pre>';
print_r($scan->scan(__DIR__ . DIRECTORY_SEPARATOR));
echo '</pre>';