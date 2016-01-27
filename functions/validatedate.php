<?php if(!defined("DIR")){ exit(); }
class validatedate{
	public static function val($date,$for)
	{
	    $d = DateTime::createFromFormat($for, $date);
	    return $d && $d->format($for) == $date;
	}
}
?>