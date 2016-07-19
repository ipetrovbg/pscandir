# pscandir
Scanning for images in directory and subdirectory and resizing it

The class make one size of founded image (600px) with folder name "thumb". This is default value.
You can change this value and also can add new size.
```php
require 'pscan.php';
$scan = new pscandir();
$scan->changeExistingSizeByKey('thumb', array('folder_name'=>'changed-thumb', 'folder_size'=>800));$scan->scanAndResize(__DIR__ . DIRECTORY_SEPARATOR);
```

#Get all set sizes
```php
require 'pscan.php';
$scan = new pscandir();
print_r($scan->getFolders());
```

Class work perfect with all image types.

Example in index.php
