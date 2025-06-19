<?php

namespace App\Models\Tools;

use Image;

class Tools{

	public static function DateFormat($date){
		return (!is_null($date)) ? date('Y-m-d', strtotime($date)) : null;
  }

  public static function UploadImage($files, $folder = '', $crop = false, $dim = 50){
      $path = 'images/'.$folder.'/'; // upload path
    	$img_name = date('YmdHis') . "." . $files->getClientOriginalExtension();
    	$files->move($path, $img_name); 

    	$img = Image::make(public_path($path.$img_name));
      if($crop){
        $path = public_path('images/'.$folder.'/crop/'.$img_name);
        $img->fit($dim);
      }
      else{
        $path = public_path('images/'.$folder.'/'.$img_name);
      }
    	
      $img->save($path);

    	return $img_name;
  }

  public static function slugify($text){
  	$text = preg_replace('~[^\pL\d]+~u', '-', $text);
  	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, '-');
		$text = preg_replace('~-+~', '-', $text);
		$text = strtolower($text);
		if (empty($text)) {
			return 'n-a';
		}
		return $text;
	}

  public static function dateDiff($date1, $date2 = null){
    if(is_null($date2)){
      $date2 = now();
    }
    $date1 = strtotime($date1);
    $date2 = strtotime($date2);
    $diff = abs($date1 - $date2);
    $retour = array();
 
    $tmp = $diff;
    $retour['second'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['second']) /60 );
    $retour['minute'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['minute'])/60 );
    $retour['hour'] = $tmp % 24;
 
    $tmp = floor( ($tmp - $retour['hour'])  /24 );
    $retour['day'] = $tmp;
 
    return $retour;
}

  



	  
}