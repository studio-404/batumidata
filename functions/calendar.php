<?php if(!defined("DIR")){ exit(); } 
class calendar extends connection
{
	public $geomonth; 
	public $engmonth; 
	public $rusmonth; 

	public $date;
	public $day;
	public $month;
	public $year;

	public $Cday;
	public $Cmonth;
	public $Cyear;

	public $getYear;
	public $getMonth;

	public function __construct()
	{
		$this->geomonth = array("January"=>"იანვარი", "February"=>"თებერვალი", "March"=>"მარტი", "April"=>"აპრილი", "May"=>"მაისი", "June"=>"ივნისი", "July"=>"ივლისი", "August"=>"აგვისტო", "September"=>"სექტემბერი", "October"=>"ოქტომბერი", "November"=>"ნოემბერი", "December"=>"დეკემბერი");
		$this->rusmonth = array("January"=>"январь", "February"=>"февраль", "March"=>"март", "April"=>"апрель", "May"=>"май", "June"=>"июнь", "July"=>"июль", "August"=>"август", "September"=>"сентябрь", "October"=>"октябрь", "November"=>"ноябрь", "December"=>"декабрь");

		$this->date = time();
		$this->day = date('d', $this->date); 
		if(isset($_GET['month'])){
			$this->month = 	$_GET['month'];
		}else{
			$this->month = date('m', $this->date);
		}

		if(isset($_GET['year'])){
			$this->year = $_GET['year'];
		}else{
			$this->year = date('Y', $this->date);
		}
		
		

		$this->Cday = date('d', $this->date);
		$this->Cmonth = date('m', $this->date);
		$this->Cyear = date('Y', $this->date);
	}

	public function index()
	{

		global $c;
        $conn = $this->conn($c); 
        $this->day_num = 1;
        $this->event_exists = array();
        $this->days_in_month = cal_days_in_month(0, $this->month, $this->year);
        while($this->day_num <= $this->days_in_month)
		{
			if($this->day_num<=9){ $this->day_num_show = "0".$this->day_num;  }
			else{ $this->day_num_show = $this->day_num; }
			$this->dayInTimeStamp = strtotime($this->day_num_show."-".$this->month."-".$this->year." 24:00:00");
			$sql = 'SELECT 
			`idx`
			FROM 
			`studio404_events` 
			WHERE 
			`start_date`<=:dayInTimeStamp AND 
			`end_date`>=:dayInTimeStamp AND 
			`lang`=:lang AND 
			`status`!=:status
	        ';
	        $prepare = $conn->prepare($sql); 
	        $prepare->execute(array(
				":status"=>1, 
				":dayInTimeStamp"=>$this->dayInTimeStamp, 
				":lang"=>LANG_ID
			));
	        if($prepare->rowCount()){
	        	$this->event_exists[$this->day_num] = $prepare->rowCount();
	        }else{
	        	$this->event_exists[$this->day_num] = 0;
	        }

			$this->day_num++;
	    }

	    // echo "<pre>";
	    // print_r($this->event_exists); 
	    // echo "</pre>";



		if(!isset($this->month) || !isset($this->year) || $this->month=="" || $this->year==""){
			exit();
		}
		if(isset($this->getMonth)){ $this->month=$this->getMonth; }
		if(isset($this->getYear)){ $this->year=$this->getYear; }

		$this->first_day = mktime(0, 0, 0, $this->month, 1, $this->year);
		$this->title = date('F',$this->first_day);
		
		$this->title = $this->geomonth[$this->title]; 
		$this->weekDayNames = array("ორშ","სამ","ოთხ","ხუთ","პარ","შაბ","კვი");
		

		$this->day_of_week = date('D', $this->first_day);

		switch($this->day_of_week)
		{
			case "Mon": $this->blank=0; break;
			case "Tue": $this->blank=1; break;
			case "Wed": $this->blank=2; break;
			case "Thu": $this->blank=3; break;
			case "Fri": $this->blank=4; break;
			case "Sat": $this->blank=5; break;
			case "Sun": $this->blank=6; break;
			default: exit;
		}

		$this->days_in_month = cal_days_in_month(0, $this->month, $this->year);

		$this->out = "<table border=\"1\" cellspacing=\"10\" cellpadding=\"10\" class=\"eventCalendar\">\n";

		$this->out .= "<tr>\n";
		$this->out .= "<td colspan=\"7\" id=\"title-calendar\">\n";

		if($this->month!=1)
		{ 
			$this->yy_month = $this->month-1; 
			$this->yy_year = $this->year; 
		}
		else
		{ 
			$this->yy_month = 12; 
			$this->yy_year = $this->year-1; 
		}

		if($this->month!=12)
		{ 
			$this->xx_month = $this->month+1; 
			$this->xx_year = $this->year; 
		}
		else
		{ 
			$this->xx_month = 1; 
			$this->xx_year = $this->year+1; 
		}

		/* onclick="hashx('')" */
		$this->out .= "<a href=\"?month=".$this->yy_month."&amp;year=".$this->yy_year."\" style=\"float:left\"><i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i></a>";
		$this->out .= $this->title." ".$this->year;		
		$this->out .= "<a href=\"?month=".$this->xx_month."&amp;year=".$this->xx_year."\" style=\"float:right\"><i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i></a>";

		$this->out .= "</td>\n";
		$this->out .= "</tr>\n";


		// $this->out .= "<tr>\n";
		// $this->out .= "<td colspan=\"7\">&nbsp;";
		// $this->out .= "</td>\n";
		// $this->out .= "</tr>\n";

		$this->out .= "<tr style=\"margin:5px 0px\">\n";
		$this->out .= sprintf("<th class=\"weekDay\">%s</th>\n", $this->weekDayNames[0]);
		$this->out .= sprintf("<th class=\"weekDay\">%s</th>\n", $this->weekDayNames[1]);
		$this->out .= sprintf("<th class=\"weekDay\">%s</th>\n", $this->weekDayNames[2]);
		$this->out .= sprintf("<th class=\"weekDay\">%s</th>\n", $this->weekDayNames[3]);
		$this->out .= sprintf("<th class=\"weekDay\">%s</th>\n", $this->weekDayNames[4]);
		$this->out .= sprintf("<th class=\"weekDay\">%s</th>\n", $this->weekDayNames[5]);
		$this->out .= sprintf("<th class=\"weekDay\">%s</th>\n", $this->weekDayNames[6]);
		$this->out .= "</tr>\n";

		$this->day_count = 1;

		/* Dayes  */ 
		$this->out .= "<tr>";
		while($this->blank > 0)
		{
			$this->out .= "<td></td>";
			$this->blank = $this->blank-1;
			$this->day_count++;
		}
		
		$this->day_num = 1;

		while($this->day_num <= $this->days_in_month)
		{
			$this->d = $this->day_num."-".$this->month."-". $this->year." 24:00:00";
			$this->to_time = strtotime($this->d);

			if($this->event_exists[$this->day_num]>0){
				$this->out .= sprintf(
					"<td class='day_numbers'><div>%s</div> <p class='events_box'><a href=\"javascript:void(0)\" class=\"label pull-right bg-green\" onclick=\"select_current_day_events('%s','%s')\">%s</a></p></td>", 
					$this->day_num, 
					$this->d,
					LANG_ID, 
					$this->event_exists[$this->day_num]
				); 
			}else{
				$this->out .= sprintf(
					"<td class='day_numbers'><div>%s</div></td>", 
					$this->day_num
				);
			}

			$this->day_num++;
			$this->day_count++;
			
			if($this->day_count>7)
			{
				$this->out .= "</tr><tr>";
				$this->day_count = 1;
			}
		}

		while($this->day_count > 1 && $this->day_count <= 7)
		{
			$this->out .= "<td></td>";
			$this->day_count++;
		}
		
		// $this->out .= "<tr>\n";
		// $this->out .= "<td colspan=\"7\">&nbsp;";
		// $this->out .= "</td>\n";
		// $this->out .= "</tr>\n";


		$this->out .= "</table>\n";

		return $this->out;
	}
}