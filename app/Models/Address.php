<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model{
    protected $table = 'address';

    public function getGeoposition(){
    	$opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
		$context = stream_context_create($opts);
		$address = urlencode($this->street).'+'.$this->numero.'+'.urlencode($this->city);
		$file = file_get_contents('http://nominatim.openstreetmap.org/search?q='.$address.'&format=json&polygon=1&addressdetails=1', false, $context);
		$geopos = json_decode($file, true);
		if(empty($geopos)){
			return null;
		}
		$geopos = $geopos[0];		
		return array('lat' => $geopos['lat'], 'lon' => $geopos['lon']);
    }

    public function setPosition(){
    	$position = $this->getGeoposition();
    	$this->latitude = $position['lat'];
    	$this->longitude = $position['lon'];
    	return $this;
    }

    public function formatage(){
        return $this->street.', '.$this->postal_code.' '.$this->city;
    }

    public static function getPositionCity($city){
        $opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
        $context = stream_context_create($opts);
        $file = file_get_contents('http://nominatim.openstreetmap.org/search?q='.urlencode($city).'&format=json&polygon=1&addressdetails=1', false, $context);
        $geopos = json_decode($file, true);
        if(empty($geopos)){
            return null;
        }
        $geopos = $geopos[0];       
        return array('lat' => $geopos['lat'], 'lon' => $geopos['lon']);
    }

    public static function getCitiesAround($city = 'Malmedy'){
        $pos = self::getPositionCity($city);
        $attr = 'node["place"="town"](around:10000,'.$pos['lat'].','.$pos['lon'].');node["place"="village"](around:10000,'.$pos['lat'].','.$pos['lon'].');';
        $overpass = 'http://overpass-api.de/api/interpreter?data=[out:json];('.$attr.');out;';

       
        $html = file_get_contents($overpass);
        $result = json_decode($html, true);
        $cities = array();
        foreach ($result['elements'] as $value) {
            $_city = $value['tags']['name'];
            array_push($cities, $_city);
        }        
        return array_diff($cities, [$city]);
    }
}