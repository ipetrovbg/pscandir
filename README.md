# pscandir
Scanning for images in directory and subdirectory and resizing it

The class make 3 different size of founded image (1080px, 500px and 150px). These are default value.
For change size of resizing image, just call setConfiqLarg(), setConfiqThumb(), setConfiqSmall().
`$scan = new pscandir();
$scan->setConfiqSmall(150);

$scan->scan(__DIR__ . DIRECTORY_SEPARATOR);`
Note that setConfiqSmall() is cropping founded image with set values (150x150px)!

Class work perfect with all image types.

Example in index.php
