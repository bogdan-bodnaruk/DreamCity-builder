<?php
class captcha {
    public $keystring = '';

	public function captcha() {
        $alphabet = "0123456789abcdefghijklmnopqrstuvwxyz";
        $allowed_symbols = "23456789abcdegikpqsvxyz";
        $length = mt_rand(4, 6);
        $width = 120;
        $height = 60;
        $fluctuation_amplitude = 8;
        $foreground_color = array(mt_rand(0, 80), mt_rand(0, 80), mt_rand(0, 80));
        $background_color = array(mt_rand(220, 255), mt_rand(220, 255), mt_rand(220, 255));
        $font = imagecreatefrompng(dirname(__FILE__).'/font.png');
        $font_metrics = array();
        $symbol = 0;
        $reading_symbol = false;
        $period = mt_rand(750000,1200000)/10000000;
        $phases = mt_rand(0,31415926)/10000000;
        $ampl1 = mt_rand(330,420)/110;
        $ampl2 = mt_rand(330,450)/100;

        for($i=0;$i<$length;$i++){
            $this->keystring .= $allowed_symbols{mt_rand(0,strlen($allowed_symbols)-1)};
        }

        for($i=0;$i<imagesx($font) && $symbol<strlen($alphabet);$i++){
            if(!$reading_symbol && (imagecolorat($font, $i, 0) >> 24) !== 127){
                $font_metrics[$alphabet{$symbol}]=array('start'=>$i);
                $reading_symbol=true;
            } elseif ($reading_symbol && (imagecolorat($font, $i, 0) >> 24) == 127){
                $font_metrics[$alphabet{$symbol}]['end']=$i;
                $reading_symbol=false;
                $symbol++;
            }
        }

        $img = imagecreatetruecolor($width, $height);
        imagefilledrectangle($img, 0, 0, $width-1, $height-1, imagecolorallocate($img, 255, 255, 255));

        // draw text
        $x=1;
        $odd=mt_rand(0,1);
        for($i=0;$i<$length;$i++){
            $m=$font_metrics[$this->keystring{$i}];

            $y=(($i%2)*$fluctuation_amplitude - $fluctuation_amplitude/2)*$odd
                + mt_rand(-round($fluctuation_amplitude/3), round($fluctuation_amplitude/3))
                + ($height-imagesy($font)-1)/2;

            imagecopy($img, $font, $x-1, $y, $m['start'], 1, $m['end']-$m['start'], imagesy($font)-1);
            $x+=$m['end']-$m['start']-1;
        }

		//noise
		for($i=0;$i<(($height-30)*$x)*(1/6);$i++){
			imagesetpixel($img, mt_rand(0, $x-1), mt_rand(10, $height-15), imagecolorallocate($font, 255, 255, 255));
		}
		for($i=0;$i<(($height-30)*$x)*(1/30);$i++){
			imagesetpixel($img, mt_rand(0, $x-1), mt_rand(10, $height-15), imagecolorallocate($font, 0, 0, 0));
		}

		// credits. To remove, see configuration file
		$img2=imagecreatetruecolor($width, $height);
		$foreground=imagecolorallocate($img2, $foreground_color[0], $foreground_color[1], $foreground_color[2]);
		$background=imagecolorallocate($img2, $background_color[0], $background_color[1], $background_color[2]);
		imagefilledrectangle($img2, 0, 0, $width-1, $height-1, $background);
		imagefilledrectangle($img2, 0, $height, $width-1, $height+12, $foreground);

		for($x=0;$x<$width;$x++){
			for($y=0;$y<$height;$y++){
				$sx=$x+(sin($x*$period+$phases)+sin($y*$period+$phases))*$ampl1-$width/2+$x/2+1;
				$sy=$y+(sin($x*$period+$phases)+sin($y*$period+$phases))*$ampl2;

				if($sx<0 || $sy<0 || $sx>=$width-1 || $sy>=$height-1) {
					continue;
				} else {
					$color=imagecolorat($img, $sx, $sy) & 0xFF;
					$color_x=imagecolorat($img, $sx+1, $sy) & 0xFF;
					$color_y=imagecolorat($img, $sx, $sy+1) & 0xFF;
					$color_xy=imagecolorat($img, $sx+1, $sy+1) & 0xFF;
				}
                $frsx=$sx-floor($sx);
                $frsy=$sy-floor($sy);
                $newcolor=($color*(1-$frsx)*(1-$frsy)+$color_x*$frsx*(1-$frsy)+$color_y*(1-$frsx)*$frsy+$color_xy*$frsx*$frsy);

                $newcolor>255 ? $newcolor=255 : '';
                $newcolor=$newcolor/255;

                $newred = (1-$newcolor)*$foreground_color[0]+$newcolor*$background_color[0];
                $newgreen = (1-$newcolor)*$foreground_color[1]+$newcolor*$background_color[1];
                $newblue = (1-$newcolor)*$foreground_color[2]+$newcolor*$background_color[2];

				imagesetpixel($img2, $x, $y, imagecolorallocate($img2, $newred, $newgreen, $newblue));
			}
		}
		
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
		header('Cache-Control: no-store, no-cache, must-revalidate'); 
		header('Cache-Control: post-check=0, pre-check=0', FALSE); 
		header('Pragma: no-cache');
		header("Content-Type: image/jpeg");
		imagejpeg($img2, null, 90);
	}
}

$captcha = new captcha();
$_SESSION['captcha_keystring'] = $captcha->keystring;