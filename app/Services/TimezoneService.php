<?php 

namespace App\Services;

class TimezoneService
{
	
	public function getTimeZoneFromIpAddress(){
	    $clientData = \Http::get('http://gd.geobytes.com/GetCityDetails');
	    $clientData = $clientData->json();
	    $clientsIpAddress = $clientData['geobytesipaddress'];
	    $clientInformation = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$clientsIpAddress));
	    $clientsLatitude = $clientInformation['geoplugin_latitude'];
	    $clientsLongitude = $clientInformation['geoplugin_longitude'];
	    $clientsCountryCode = $clientInformation['geoplugin_countryCode'];

	    $timeZone = $this->getNearestTimezone($clientsLatitude, $clientsLongitude, $clientsCountryCode) ;

	    return $timeZone;
	}

	public function getNearestTimezone($cur_lat, $cur_long, $country_code = '') {
	    $timezone_ids = ($country_code) ? \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $country_code)
	        : \DateTimeZone::listIdentifiers();

	    if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

	        $time_zone = '';
	        $tz_distance = 0;

	        //only one identifier?
	        if (count($timezone_ids) == 1) {
	            $time_zone = $timezone_ids[0];
	        } else {

	            foreach($timezone_ids as $timezone_id) {
	                $timezone = new \DateTimeZone($timezone_id);
	                $location = $timezone->getLocation();
	                $tz_lat   = $location['latitude'];
	                $tz_long  = $location['longitude'];

	                $theta    = $cur_long - $tz_long;
	                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat)))
	                    + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
	                $distance = acos($distance);
	                $distance = abs(rad2deg($distance));
	                // echo '<br />'.$timezone_id.' '.$distance;

	                if (!$time_zone || $tz_distance > $distance) {
	                    $time_zone   = $timezone_id;
	                    $tz_distance = $distance;
	                }

	            }
	        }
	        return  $time_zone;
	    }
	    return 'unknown';
	}


}