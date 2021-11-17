<?php

namespace App\Services;

use Carbon\Carbon;

class YahooFinanceParser {
	public static function getTable($ticker, $start="", $end=""){
        $cookies_url = "https://finance.yahoo.com/quote/%s/history?period1=%s&period2=%s&interval=1d&filter=history&frequency=1d";
		$cookies = storage_path("YahooFinanceReqCookies.txt");	
		
		if(strpos($start, "-")){
			$start = strtotime($start);
			$end = strtotime($end)+1;
		}
		$url = sprintf($cookies_url, $ticker, $start, $end);
		
		ini_set('pcre.backtrack_limit', '1048576');

	    $content  = self::getHTML($url, $cookies);

	    preg_match("/,\"HistoricalPriceStore\":(.*?}]),\"/", $content, $matches);

	    $data = (json_decode($matches[1]."}", 1));
	    $resp = array();
	    if($data && isset($data['prices'])){
	    	foreach($data['prices'] as $price){
	    		if(!isset($price['open'])){
	    			continue;
	    		}
	    		$resp[] = [
	    			"date" => Carbon::createFromTimestamp($price['date']),
	    			"open" => $price['open'],
	    			"high" => $price['high'],
	    			"low" => $price['low'],
	    			"close" => $price['close'],
	    			"adj_close" => $price['adjclose'],
	    			"volume" => $price['volume']
	    		];
	    	}
	    }

	    return $resp;
	}

	private static function getHTML($url="", $cookies){
		if(!$url){ 
            return false; 
        }
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_COOKIEFILE, $cookies); 
		curl_setopt($curl, CURLOPT_COOKIEJAR, $cookies); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0'); 
		curl_setopt($curl, CURLOPT_URL, $url);
		$html = curl_exec($curl);
		$curl_info = curl_getinfo($curl);
		curl_close($curl);

		if($curl_info['http_code']!=200){
			return false;
		}
		return $html;
	}
}