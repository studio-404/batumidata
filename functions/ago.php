<?php if(!defined("DIR")){ exit(); }
class ago{
	public static function time($date,$granularity=2) {
	    // $date = strtotime($date);
	    $difference = time() - $date;
	    $periods = array('ათწლეულის' => 315360000,
	        'წლის' => 31536000,
	        'თვის' => 2628000,
	        'კვირის' => 604800, 
	        'დღის' => 86400,
	        'საათის' => 3600,
	        'წუთის' => 60,
	        'წამის' => 1);
	  
	    foreach ($periods as $key => $value) {
	        if ($difference >= $value) {
	            $time = floor($difference/$value);
	            $difference %= $value;
	            $retval .= ($retval ? ' ' : '').$time.' ';
	            $retval .= (($time > 1) ? $key.' ' : $key);
	            $granularity--;
	        }
	        if ($granularity == '0') { break; }
	    }
	    if((time() - $date) > 86400){
	    	$out = date("d-m-Y H:i:s",$date);
	    }else{
	    	$out = $retval.' წინ';
		}
	    return $out;      
	}
}
?>