<?php if(!defined("DIR")){ exit(); }
class ex extends connection{
	
	function __construct($c){
		$this->requests($c);
	}

	public function requests($c){ 
		$super = array();
		$superNames = array("","id","name","category","contact","address","webpage","star","roomsnum","placenum");
		$row = 1;
		if (($handle = fopen("batumi.csv", "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        $num = count($data);
		       // echo "<p> $num fields in line $row: <br /></p>\n";
		        
		        $mmm = 1;
		        for ($c=0; $c < $num; $c++) {
		           $super[$row][$superNames[$mmm]] = $data[$c];
		           $mmm++;
		           if($mmm>9){ $mmm = 1; }
		        }
		        $row++;
		    }
		    fclose($handle);
		    echo "<pre>";
		    print_r($super);
		    echo "</pre>";
		}
	}
}