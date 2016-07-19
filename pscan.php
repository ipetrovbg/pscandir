<?php
// include composer autoload
require 'vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

class pscandir {

	private $_confiq_larg 	= 1080;
	private $_confiq_thumb 	= 500;
	private $_confiq_small 	= 150;

	public function setConfiqLarg($value){
		$this->_confiq_larg = $value;
	}

	public function setConfiqThumb($value){
		$this->_confiq_thumb = $value;
	}

	public function setConfiqSmall($value){
		$this->_confiq_small = $value;
	}

	public function scan($base='', &$data=array()){

	$array = array_diff(scandir($base), array('.', '..')); # remove ' and .. from the array */
	$counter = 0;
	foreach ($array as $item) {
		if(is_dir($base . $item)){
			$data[$item] = $this->scan($base . $item. DIRECTORY_SEPARATOR, $data[$item]);
		}else{
			$data[] = $base . $item;
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$type = finfo_file($finfo, $base . $item);
			finfo_close($finfo);

			if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif'){
				if(!is_dir($base . DIRECTORY_SEPARATOR . 'larg')){
					if(!file_exists($base . DIRECTORY_SEPARATOR . 'check.txt')){
						if (!mkdir($base . DIRECTORY_SEPARATOR . 'larg', 0777, true)) {
							    die('Failed to create folders...');
						}else{
							print "create directory \"larg\" \n";
    						flush();
							$content = "";
							$fp = fopen( $base . DIRECTORY_SEPARATOR . 'larg' . DIRECTORY_SEPARATOR . "check.txt","wb");
							fwrite($fp,$content);
							fclose($fp);

							print "create file \"check.txt\" \n";
    						flush();
						}
					}
					
					if(!file_exists($base . DIRECTORY_SEPARATOR . 'check.txt')){
						if(!file_exists($base . DIRECTORY_SEPARATOR . 'larg' . DIRECTORY_SEPARATOR . $item)){
							copy($base . $item, $base . DIRECTORY_SEPARATOR . 'larg' . DIRECTORY_SEPARATOR . $item);
							print "copy file \" $base . $item  into larg folder \" \n ";
    						flush();
							$image = Image::make($base . DIRECTORY_SEPARATOR . 'larg' . DIRECTORY_SEPARATOR . $item);
							$image->resize(null, $this->_confiq_larg, function ($constraint) {
							    $constraint->aspectRatio();
							    $constraint->upsize();
							})->save();
						}
					}

				}else{
					if(!file_exists($base . DIRECTORY_SEPARATOR . 'check.txt')){
						if(!file_exists($base . DIRECTORY_SEPARATOR . 'larg' . DIRECTORY_SEPARATOR . $item)){
							copy($base . $item, $base . DIRECTORY_SEPARATOR . 'larg' . DIRECTORY_SEPARATOR . $item);

							print "copy file \" $base . $item  into larg folder \" \n";
    						flush();

							$image = Image::make($base . DIRECTORY_SEPARATOR . 'larg' . DIRECTORY_SEPARATOR . $item);
							$image->resize(null, $this->_confiq_larg, function ($constraint) {
							    $constraint->aspectRatio();
							    $constraint->upsize();
							})->save();
						}
					}
				}

				if(!is_dir($base . DIRECTORY_SEPARATOR . 'thumb')){
					if(!file_exists($base . DIRECTORY_SEPARATOR . 'check.txt')){
						if (!mkdir($base . DIRECTORY_SEPARATOR . 'thumb', 0777, true)) {
							    die('Failed to create folders...');
						}else{
							print "creating  \" thumb \" folder \n";
    						flush();

							$content = "";
							$fp = fopen( $base . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . "check.txt","wb");
							fwrite($fp,$content);
							fclose($fp);

							print "creating  \" check.txt \" into thumb folder \n ";
    						flush();
						}
					}
					
					if(!file_exists($base . DIRECTORY_SEPARATOR . 'check.txt')){
						if(!file_exists($base . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $item)){
							copy($base . $item, $base . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $item);

							print "copy file \" $base . $item  into thumb folder \" \n";
    						flush();

							$image = Image::make($base . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $item);
							$image->resize(null, $this->_confiq_thumb, function ($constraint) {
							    $constraint->aspectRatio();
							    $constraint->upsize();
							})->save();
							print "resize image \" $base . $item   \" into thumb folder \n";
    						flush();
						}
					}

				}else{
					if(!file_exists($base . DIRECTORY_SEPARATOR . 'check.txt')){
						if(!file_exists($base . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $item)){
							copy($base . $item, $base . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $item);

							print "copy file \" $base . $item  into thumb folder \" \n";
    						flush();

							$image = Image::make($base . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $item);
							$image->resize(null, $this->_confiq_thumb, function ($constraint) {
							    $constraint->aspectRatio();
							    $constraint->upsize();
							})->save();
							print "resize image \" $base . $item \" into thumb folder \n";
    						flush();
						}
					}
				}



				if(!is_dir($base . DIRECTORY_SEPARATOR . 'small')){
					if(!file_exists($base . DIRECTORY_SEPARATOR . 'check.txt')){
						if (!mkdir($base . DIRECTORY_SEPARATOR . 'small', 0777, true)) {
							    die('Failed to create folders...');
						}else{

							print "create directory \" small \" \n";
    						flush();

							$content = "";
							$fp = fopen( $base . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR . "check.txt","wb");
							fwrite($fp,$content);
							fclose($fp);

							print "create \" check.txt \" file \n";
    						flush();
						}
					}
					
					if(!file_exists($base . DIRECTORY_SEPARATOR . 'check.txt')){
						if(!file_exists($base . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR . $item)){
							copy($base . $item, $base . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR . $item);

							print "copying \" $base . $item \" image \n";
    						flush();

							$image = Image::make($base . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR . $item);

							$width = $image->width();
							$height = $image->height();

							if($width > $height){
								$newImage = $image->resize(null, $this->_confiq_small, function ($constraint) {
								    $constraint->aspectRatio();
								    $constraint->upsize();
								})->save();

								$newWidth = $newImage->width();
								$newImage->crop($this->_confiq_small, $this->_confiq_small, round(($newWidth - $this->_confiq_small)/2), 0)->save();

							}else{
								$newImage = $image->resize($this->_confiq_small, null, function ($constraint) {
								    $constraint->aspectRatio();
								    $constraint->upsize();
								})->save();

								$newHeight = $newImage->height();
								$newImage->crop($this->_confiq_small, $this->_confiq_small, 0, round(($newHeight - $this->_confiq_small)/2) )->save();
							}
						}
					}

				}else{
					if(!file_exists($base . DIRECTORY_SEPARATOR . 'check.txt')){
						if(!file_exists($base . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR . $item)){
							copy($base . $item, $base . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR . $item);
							$image = Image::make($base . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR . $item);

							$width = $image->width();
							$height = $image->height();

							if($width >= $height){
								$newImage = $image->resize(null, $this->_confiq_small, function ($constraint) {
								    $constraint->aspectRatio();
								    $constraint->upsize();
								})->save();

								$newWidth = $newImage->width();
								$newImage->crop($this->_confiq_small, $this->_confiq_small,  round(($newWidth - $this->_confiq_small)/2), 0)->save();

							}else{
								$newImage = $image->resize($this->_confiq_small, null, function ($constraint) {
								    $constraint->aspectRatio();
								    $constraint->upsize();
								})->save();

								$newHeight = $newImage->height();
								$newImage->crop($this->_confiq_small, $this->_confiq_small, 0, round(($newHeight - $this->_confiq_small)/2) )->save();
							}

							
						}
					}
				}
								
			}
		}

		$counter++;
	}
	return $data; // return the $data array

	}

}


