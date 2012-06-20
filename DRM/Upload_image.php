<?php
// якщо наслідувати DRM то треба не забути про ckeditor upload image
class Upload_image {
	var $width, $height, $imageName, $direction;
	
	private function calculate($widthSrc, $heightSrc) {
		if($widthSrc>$heightSrc) {
			$height = round($heightSrc/($widthSrc/$this->width));
			$width = $height>$this->height ? round($widthSrc/($heightSrc/$this->height)) : '';
		} elseif($widthSrc<$heightSrc) {
			$width = round($widthSrc/($heightSrc/$this->width));
			$height = $width>$this->width ? round($heightSrc/($widthSrc/$this->width)) : '';
		};
		$width = empty($width) ? $this->width : $width;
		$height = empty($height) ? $this->width : $height;
		
		return $array = array($width, $height);
	}

	public function upload($folder, $tmpName) {
		$src = imagecreatefromjpeg($tmpName);
		$widthSrc = imagesx($src);
        $heightSrc = imagesy($src);
		list($widthDest, $heightDest) = $this->calculate($widthSrc, $heightSrc); 
	    if($this->width == $this->height) {
			$image = imagecreatetruecolor($this->width, $this->height) or die ('Can\'t connect GD lib!');;
			if($widthSrc>$heightSrc) {
				$marging = ((round($widthSrc-$heightSrc)/2)/$this->width)*50;
				imagecopyresampled($image, $src, 0, 0, $marging, 0, $this->width, $this->height, $heightSrc, $heightSrc);
			} elseif($widthSrc<$heightSrc) {
				$marging = ((round($heightSrc-$widthSrc)/2)/$this->height)*50;
				imagecopyresampled($image, $src, 0, 0, 0, $marging, $this->width, $this->height, $widthSrc, $widthSrc);
			} else {
				$marging = ((round($heightSrc-$widthSrc)/2)/$this->height)*50;
				imagecopyresampled($image, $src, 0, 0, 0, $marging, $this->width, $this->width, $widthSrc, $widthSrc);
			}
		} else {
			$image = imagecreatetruecolor($widthDest, $heightDest) or die ('Can\'t connect GD lib!');;
			imagecopyresampled($image, $src, 0, 0, 0, 0, $widthDest, $heightDest, $widthSrc, $heightSrc);
		}
	    //$image = $widthDest>300 ? $this->watermark($image) : $image;
		$copy = imagejpeg($image, $folder.'/'.md5($this->imageName).'.jpg', 100);
		imagedestroy($image);
        imagedestroy($src);
	}

	public function rotate($file) {
		$src = imagecreatefromjpeg($file);
		$widthSrc = imagesx($src);
        $heightSrc = imagesy($src);
        $image = imagecreatetruecolor($widthSrc, $heightSrc) or die ('Can\'t connect GD lib!');;
		imagecopy($image, $src, 0, 0, 0, 0, $widthSrc, $heightSrc);
		$image=imagerotate($image,$this->direction, 0);
		unlink($file);
		imagejpeg($image, $file, 100);
		imagedestroy($image);
		imagedestroy($src);
    }
	
	private function watermark($image) {
		$watermark = imagecreatefrompng(DCONF_WATERMARK_IMG);
		$width = imagesx($watermark);
		$height = imagesy($watermark);
		$destX = imagesx($image) - $width - 5; 
		$destY = imagesy($image) - $height - 5;
		imagecopymerge($image, $watermark, $destX, $destY, 0, 0, $width, $height, 90);
		return $image; 
	}
}