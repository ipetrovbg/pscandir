<?php
// include composer autoload
require 'vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

class pscandir
{

    private $_check_file = 'check';
    private $_folders = [
        array(
            'folder_name' => 'thumb',
            'folder_size' => 600,
            'crop' => true
        )
    ];

    public function scanAndResize($base = '', &$data = array())
    {

        $array = array_diff(scandir($base), array('.', '..')); # remove ' and .. from the array */

        foreach ($array as $item) {
            if (is_dir($base . $item)) {
                $data[$item] = $this->scanAndResize($base . $item . DIRECTORY_SEPARATOR, $data[$item]);
            } else {
                $data[] = $base . $item;
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $type = finfo_file($finfo, $base . $item);
                finfo_close($finfo);

                if ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif') {

                    foreach ($this->_folders as $folder) {
                        if (!is_dir($base . DIRECTORY_SEPARATOR . $folder['folder_name'])) {
                            if (!file_exists($base . DIRECTORY_SEPARATOR . $this->_check_file . '.txt')) {
                                if (!mkdir($base . DIRECTORY_SEPARATOR . $folder['folder_name'], 0777, true)) {
                                    die('Failed to create folders...');
                                } else {
                                    print "creating  \" " . $folder['folder_name'] . " \" folder \n";
                                    flush();

                                    $content = "";
                                    $fp = fopen($base . DIRECTORY_SEPARATOR . $folder['folder_name'] . DIRECTORY_SEPARATOR . $this->_check_file . '.txt', "wb");
                                    fwrite($fp, $content);
                                    fclose($fp);

                                    print "creating  \" check.txt \" into " . $folder['folder_name'] . " folder \n ";
                                    flush();
                                }
                            }

                            if (!file_exists($base . DIRECTORY_SEPARATOR . $this->_check_file . '.txt')) {
                                if (!file_exists($base . DIRECTORY_SEPARATOR . $folder['folder_name'] . DIRECTORY_SEPARATOR . $item)) {
                                    copy($base . $item, $base . DIRECTORY_SEPARATOR . $folder['folder_name'] . DIRECTORY_SEPARATOR . $item);

                                    print "copy file \" $base . $item  into " . $folder['folder_name'] . " folder \" \n";
                                    flush();

                                    $image = Image::make($base . DIRECTORY_SEPARATOR . $folder['folder_name'] . DIRECTORY_SEPARATOR . $item);
                                    if (array_key_exists('crop', $folder) && $image->width() > $folder['folder_size']) {

                                        $width = $image->width();
                                        $height = $image->height();

                                        if ($width > $height) {
                                            $newImage = $image->resize(null, $folder['folder_size'], function ($constraint) {
                                                $constraint->aspectRatio();
                                                $constraint->upsize();
                                            })->save();

                                            $newWidth = $newImage->width();
                                            $newImage->crop($folder['folder_size'], $folder['folder_size'], round(($newWidth - $folder['folder_size']) / 2), 0)->save();

                                        } else {
                                            $newImage = $image->resize($folder['folder_size'], null, function ($constraint) {
                                                $constraint->aspectRatio();
                                                $constraint->upsize();
                                            })->save();

                                            $newHeight = $newImage->height();
                                            $newImage->crop($folder['folder_size'], $folder['folder_size'], 0, round(($newHeight - $folder['folder_size']) / 2))->save();
                                        }

                                    } else {
                                        $image->resize(null, $folder['folder_size'], function ($constraint) {
                                            $constraint->aspectRatio();
                                            $constraint->upsize();
                                        })->save();
                                    }
                                    print "resize image \" $base . $item   \" into " . $folder['folder_name'] . " folder \n";
                                    flush();
                                }
                            }

                        } else {
                            if (!file_exists($base . DIRECTORY_SEPARATOR . $this->_check_file . '.txt')) {
                                if (!file_exists($base . DIRECTORY_SEPARATOR . $folder['folder_name'] . DIRECTORY_SEPARATOR . $item)) {
                                    copy($base . $item, $base . DIRECTORY_SEPARATOR . $folder['folder_name'] . DIRECTORY_SEPARATOR . $item);

                                    print "copy file \" $base . $item  into " . $folder['folder_name'] . " folder \" \n";
                                    flush();

                                    $image = Image::make($base . DIRECTORY_SEPARATOR . $folder['folder_name'] . DIRECTORY_SEPARATOR . $item);

                                    if (array_key_exists('crop', $folder) && $image->width() > $folder['folder_size']) {

                                        $width = $image->width();
                                        $height = $image->height();

                                        if ($width > $height) {
                                            $newImage = $image->resize(null, $folder['folder_size'], function ($constraint) {
                                                $constraint->aspectRatio();
                                                $constraint->upsize();
                                            })->save();

                                            $newWidth = $newImage->width();
                                            $newImage->crop($folder['folder_size'], $folder['folder_size'], round(($newWidth - $folder['folder_size']) / 2), 0)->save();

                                        } else {
                                            $newImage = $image->resize($folder['folder_size'], null, function ($constraint) {
                                                $constraint->aspectRatio();
                                                $constraint->upsize();
                                            })->save();

                                            $newHeight = $newImage->height();
                                            $newImage->crop($folder['folder_size'], $folder['folder_size'], 0, round(($newHeight - $folder['folder_size']) / 2))->save();
                                        }

                                    } else {
                                        $image->resize(null, $folder['folder_size'], function ($constraint) {
                                            $constraint->aspectRatio();
                                            $constraint->upsize();
                                        })->save();
                                    }


                                    print "resize image \" $base . $item \" into " . $folder['folder_name'] . " folder \n";
                                    flush();
                                }
                            }
                        }
                    }
                }
            }

        }
        return $data; // return the $data array

    }

    public function scan($base = '', &$data = array())
    {
        $array = array_diff(scandir($base), array('.', '..')); # remove ' and .. from the array */

        foreach ($array as $item) {
            if (is_dir($base . $item)) {
                $data[$item] = $this->scan($base . $item . DIRECTORY_SEPARATOR, $data[$item]);
            } else {
                $data[] = $base . $item;
            }

        }

        return $data; // return the $data array
    }

    public function getConfiqCheckFile()
    {
        return $this->_check_file;
    }


    public function getFolders()
    {
        return $this->_folders;
    }

    public function deleteFolderByKey($key)
    {
        if ($key) {
            unset($this->_folders[$key]);
        }
    }

    public function deleteFolderByName($folder_name)
    {
        foreach ($this->_folders as $key => $folder) {
            if ($folder['folder_name'] == $folder_name) {
                unset($this->_folders[$key]);
            }
        }
    }

    public function addSize($array)
    {
        if (is_array($array)) {
            if (array_key_exists('folder_name', $array) && array_key_exists('folder_size', $array)) {
                array_push($this->_folders, $array);
            }
        } else {
            echo "Incorect format for addSize method. Must be array('folder_name'=>'some-name', 'folder_size'=>500);";
        }
    }

    public function changeExistingSizeByKey($key, $new_size)
    {
        if ($key && $new_size) {
            if (is_array($new_size)) {
                foreach ($this->_folders as $k => $folder) {
                    if ($folder['folder_name'] == $key) {
                        if (array_key_exists('folder_name', $new_size) && array_key_exists('folder_size', $new_size)) {
                            $this->_folders[$k]['folder_name'] = $new_size['folder_name'];
                            $this->_folders[$k]['folder_size'] = $new_size['folder_size'];
                        }
                    }
                }
            } else {
                echo "In changeExistingSizeByKey() second parameter must be array";
            }
        } else {
            echo "changeExistingSizeByKey() require 2 parameters. Key as string and New size as array";
        }
    }
}


