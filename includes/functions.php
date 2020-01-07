<?php
//function to resize image
function resizeImage($name,$dir,$setwidth,$setheight){

//    get details and check for image type
	list($width, $height, $type) = getimagesize($name);
    if ($type !== false) {
            switch ($type) {
                case IMAGETYPE_JPEG:
                    $srcImg = imagecreatefromjpeg($name);
                    break;
                default:
                    return false;
            }
    }
    
//    if image type correct prepare to resize to the cordinate given from the function
	$scaleRatio = $width / $height;
    
//    series of if statment that check if the image need resize based on height and width
    if($width >= $setwidth && $height >= $setheight){
        if(($setwidth / $setheight) > $scaleRatio){
            $setwidth = $setheight * $scaleRatio;
        }else if(($setwidth / $setheight) == $scaleRatio){
            $setwidth = $setwidth;
            $setheight = $setheight;
        }else{
            $setheight = $setwidth / $scaleRatio;
        }
    }else{
        $setwidth = $width;
        $setheight = $height;
    }

//    if evrything is correct store image on directory
     $temp = imagecreatetruecolor($setwidth,$setheight);
     imagecopyresampled($temp,$srcImg,0,0,0,0,$setwidth,$setheight,$width,$height);
    if (!imagejpeg($temp, $dir, 90)) {
        return false;
    }
     imagedestroy($temp);
     imagedestroy($srcImg);
    return true;
}

?>