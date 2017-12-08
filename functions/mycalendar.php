<?php
class myCalendar{
	
	public $outMessage;

	function __construct($main_options){
		/* less important options */
		$secondary_options = array(
		"shell_space_symbol"=>"---", /* replace space for shell arg */
		"css"=>array(
			"msg"=>array(
				"padding"=>"0",
				"margin"=>"5px",
				"color"=>"red",
				"display"=>"block",
				"width"=>"100%",
				"text-align"=>"center"
			), /* message box */
			"calendar"=>array(
				"margin"=>"0px auto",
				"padding"=>"0px", 
				"width"=>"100%", 
				"font-family"=>"serif", 
				"border-top"=>"solid 4px #3c8dbc"
			), /* calendar box */
			"header"=>array(
				"line-height"=>"60px", 
				"position"=>"relative",
				"height"=>"40px", 
				"text-align"=>"center",
			), /* calendar header */
			"prev"=>array(
				"cursor"=>"pointer",
				"text-decoration"=>"none",
				"float"=>"left",
				"margin-left"=>"10px", 
				"color"=>"#787878"
			), /* prev month link */
			"title"=>array(
				"margin"=>"0px",
				"padding"=>"0px",
				"color"=>"#787878",
				"text-align"=>"center",
			), /* month and year text */
			"next"=>array(
				"cursor"=>"pointer",
				"text-decoration"=>"none",
				"color"=>"#787878",
				"float"=>"right",
				"margin-right"=>"10px"
			), /* next month link */
			"weekdays"=>array(
				"height"=>"40px", 
				"line-height"=>"40px", 
				"text-align"=>"center", 
				"color"=>"#ffffff", 
				"font-size"=>"14px", 
				"background-color"=>"#3c8dbc"
			), /* weekdayes */
			"days"=>array(
				"height"=>"80px", 
				"width"=>"120px",
				"font-size"=>"25px", 
				"background-color"=>"#ffffff",
				"color"=>"#000",
				"text-align"=>"center", 
				"position"=>"relative",
				"border"=>"solid 1px #dddddd"
			), /* days */
			"current_days"=>array(
				"height"=>"80px", 
				"width"=>"120px",
				"font-size"=>"25px", 
				"background-color"=>"#3c8dbc",
				"color"=>"#000",
				"text-align"=>"center", 
				"position"=>"relative",
				"border"=>"solid 1px #dddddd"
			), /* days */
			"days_number"=>array(
				"margin"=>"0px", 
				"padding"=>"0", 
				"width"=>"20px", 
				"height"=>"20px", 
				"font-size"=>"14px", 
				"position"=>"absolute", 
				"bottom"=>"5px", 
				"right"=>"5px",
				"background-color"=>"#3c8dbc",
				"color"=>"#ffffff",
				"z-index"=>"1",
				"text-align"=>"center"
			), /* days number */
			"form"=>array(
				"margin"=>"10px 0", 
				"padding"=>"0px"
			), /* add event form box */
			"form_title"=>array(
				"margin"=>"0px", 
				"padding"=>"20px 0 0 0",
				"width"=>"100%",
				"display"=>"block", 
				"color"=>"#3c8dbc"
			), /* add event form title */
			"label"=>array(
				"margin"=>"0px", 
				"padding"=>"10px 0px",
				"width"=>"100%",
				"display"=>"block", 
				"color"=>"#787878"
			), /* add event form labels */
			"input_text"=>array(
				"margin"=>"0px", 
				"padding"=>"0 5px",
				"width"=>"100%",
				"height"=>"30px", 
				"color"=>"#787878"
			), /* add event form input[type="text"] */
			"select"=>array(
				"margin"=>"0px", 
				"padding"=>"0 5px",
				"width"=>"100%",
				"height"=>"30px", 
				"line-height"=>"30px", 
				"color"=>"#787878"
			), /* add event form select */
			"input_submit"=>array(
				"margin"=>"15px 0 0 0"
			), /* add event form submit button */
			"eventBox"=>array(
				"margin"=>"2px", 
				"padding"=>"0px 3px",
				"color"=>"#ffffff",
				"font-size"=>"12px",
				"display"=>"inline-block",
				"cursor"=>"pointer"
			), /* event text box */
			"clear"=>array(
				"clear"=>"both"
			)
		));

		/* merge main and secondary options */
		$this->option = $main_options + $secondary_options;

		/* call request method */
		$this->post_request();
	}
    
	public function show(){
		/* Create important variables */ 	
		$this->dayLabels = $this->option['dayLabels'];
		$this->monthLabel = $this->option['monthLabel'];
		$this->naviHref = $this->option['slug'];  
        
		/* Check if set year request */
		if($this->requests('GET','year')){
			$year = $this->requests('GET','year');
		}else{
			$year = date("Y", time()); 
		}         
        
		/* Check if set month request */
		if($this->requests('GET','month')){
			$month = $this->requests('GET','month');
			if($month > 12){ $month = 12; }
			if($month <= 0){ $month = 1; }
		}else{
			$month = date("m",time());
		}                  
        
		/* Set some more vars */
		$this->currentYear = $year;
		$this->currentMonth = $month;
		$this->currentDay = 0;
		$this->daysInMonth = $this->daysInMonth($month, $year);  
        
		/* Calendar Starts */
		$content = sprintf(
			'<span style="%s">%s</span><table style="%s" cellpadding="0" cellspacing="1">
			<tr style="%s">
			<td colspan="7">%s</td>
			</tr>
			<tr>%s</tr>
			',
			$this->arrayToStyleOrOptions($this->option['css']['msg']),
			$this->outMessage, 
			$this->arrayToStyleOrOptions($this->option['css']['calendar']), 
			$this->arrayToStyleOrOptions($this->option['css']['header']), 
			$this->createNavi(),
			$this->createLabels()
		);

		$weeksInMonth = $this->weeksInMonth($month,$year);
		for( $i=0; $i<$weeksInMonth; $i++ ){
			$content .= '<tr>';
			for($j=1; $j<=7; $j++){
				$content .= $this->showDay($i*7+$j);
			}
			$content .= '</tr>';
		}

		if($this->option['addEvents']){
			$content .= sprintf(
				'<tr>
				<td colspan="7">
				<form action="%s" method="POST" style="%s">
				<label style="%s">%s</label>
				<label style="%s">%s: ( %s )</label>
				<input type="text" name="calendar_date" value="%s" style="%s" />
				<label style="%s">%s:</label>
				<input type="text" name="calendar_title" value="" style="%s" />
				<label style="%s">%s:</label>
				<select style="%s" name="calendar_color">%s</select>
				<input type="submit" class="btn btn-primary" name="calendar_submit" value="%s" style="%s" />
				</form>
				</td>
				</tr>',
				$this->option['slug'],
				$this->arrayToStyleOrOptions($this->option['css']['form']),
				$this->arrayToStyleOrOptions($this->option['css']['form_title']),
				$this->option['lang']['addEvent'],
				$this->arrayToStyleOrOptions($this->option['css']['label']),
				$this->option['lang']['date'],
				$this->option['lang']['dateFormat'],
				date("m-d-Y"), 
				$this->arrayToStyleOrOptions($this->option['css']['input_text']), 
				$this->arrayToStyleOrOptions($this->option['css']['label']),
				$this->option['lang']['addEventTitle'],
				$this->arrayToStyleOrOptions($this->option['css']['input_text']), 
				$this->arrayToStyleOrOptions($this->option['css']['label']),
				$this->option['lang']['color'],
				$this->arrayToStyleOrOptions($this->option['css']['select']),
				$this->arrayToStyleOrOptions($this->option['colors'], true),
				$this->option['lang']['submitTitle'],
				$this->arrayToStyleOrOptions($this->option['css']['input_submit']) 
			);
		}
		$content .= '</table>';	
		
		if($this->option['deleteEvents']){
			$content .= sprintf(
				'<script type="text/javascript">
				function del(f){ if(confirm("%s") == true){ location.href = "%s?del="+f;  } }
				</script>',
				$this->option['lang']['deleteEventQuestion'],
				$this->option['slug']
			);
		}

		return $content;   
	}

	private function post_request(){
		if(
			$this->requests('GET','del') && 
			$this->option['deleteEvents']
		){
			$file = sprintf(
				'%s/%s',
				$this->option['temp_files'], 
				$this->requests('GET','del')
			);
		
			$file = str_replace(
				array('../', './','%','$'),
				'',
				$file
			);
		
			if(file_exists($file)){
				@unlink($file);
				self::url($this->option['slug']);
			}else{
				$this->outMessage = "ფაილი ვერ მოიძებნა !";
			}
		}else if(
			$this->option['addEvents'] && 
			$this->requests('POST','calendar_date') && 
			$this->requests('POST','calendar_title') && 
			$this->requests('POST','calendar_color') 
		){
			$ck = explode("-", $this->requests('POST','calendar_date'));
			if(count($ck)==3 && $ck[0]<=9 && strlen($ck[0])==1){ $ck[0] = sprintf("0%s",$ck[0]); }
			if(count($ck)==3 && $ck[1]<=9 && strlen($ck[1])==1){ $ck[1] = sprintf("0%s",$ck[1]); }

			if(
				count($ck)==3 && 
				checkdate($ck[0],$ck[1],$ck[2])			
			){
				$cdate = sprintf(
					"%s-%s-%s",
					$ck[0],
					$ck[1],
					$ck[2]
				);
				
				$this->shell(
					"createdir", 
					array(
						$this->option['temp_files'], 
						$cdate
					)
				);
				
				$this->shell(
					"createfile",  
					array(
						$this->option['temp_files'],
						$cdate,
						$ck[1],
						str_replace(
							" ", 
							$this->option['shell_space_symbol'], 
							$this->requests('POST','calendar_title')
						), 
						$this->requests('POST','calendar_color')
					)
				);
			}else{
				$this->outMessage = $this->option['lang']['dateFormatErrorMsg'];
			}		
		}
	}

	private function createNavi(){
		$nextMonth = $this->currentMonth == 12 ? 1 : intval($this->currentMonth)+1;
		$nextYear = $this->currentMonth == 12 ? intval($this->currentYear)+1 : $this->currentYear;
		$preMonth = $this->currentMonth == 1 ? 12 : intval($this->currentMonth)-1;
		$preYear = $this->currentMonth == 1 ? intval($this->currentYear)-1 : $this->currentYear;
        
		$title = sprintf(
			'%s %s',
			$this->currentYear, 
			$this->monthLabel[(int)$this->currentMonth - 1]
		);
        
		$out = sprintf(
			'<table width="100&#37;" cellspacing="0" cellpadding="0">
			<tr>
			<td width="25&#37;"><a style="%s" href="%s?month=%02d&year=%s">%s</a></td>
			<td width="50&#37;"><div style="%s">%s</div></td>
			<td width="25&#37;"><a style="%s" href="%s?month=%02d&year=%s">%s</a></td>
			</tr>
			</table>',
			$this->arrayToStyleOrOptions($this->option['css']['prev']), 
			$this->naviHref, 
			$preMonth, 
			$preYear, 
			$this->option['lang']['prevTitle'],
			$this->arrayToStyleOrOptions($this->option['css']['title']), 
			$title, 
			$this->arrayToStyleOrOptions($this->option['css']['next']), 
			$this->naviHref, 
			$nextMonth, 
			$nextYear,
			$this->option['lang']['nextTitle']
		);

		return $out;
	}

	private function createLabels(){  
		$content = '';
		foreach($this->dayLabels as $index => $label){
			$content .= sprintf(
				'<td style="%s">%s</td>', 
				$this->arrayToStyleOrOptions($this->option['css']['weekdays']), 
				$label
			);
		}
		return $content;
	}

	private function showDay($cellNumber){
		if($this->currentDay==0){
			$firstDayOfTheWeek = date(
				'N',
				strtotime(
					$this->currentYear.'-'.$this->currentMonth.'-01'
				)
			);
			
			if(intval($cellNumber) == intval($firstDayOfTheWeek)){
				$this->currentDay = 1;
			}
		}
         
		if(($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth)){
			$this->currentDate = date(
				'Y-m-d', 
				strtotime(
					$this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)
				)
			);
			$cellContent = $this->currentDay;
			$this->currentDay++;
		}else{
			$this->currentDate = null;
			$cellContent = null;
		}
		$addEventDiv = " ";
		if(!empty($cellContent)){
			if($cellContent<=9){ $dayf = "0".$cellContent; }
			else{ $dayf = $cellContent; }
			
			$o = $this->currentMonth."-".$dayf."-".$this->currentYear;
			if(!empty($this->getEventsFiles($o))){
				$file_array = $this->getEventsFiles($o); 
				foreach ($file_array as $f) {
					$file_path = sprintf(
						'%s/%s/%s.json',
						$this->option['temp_files'], 
						$o, 
						$f
					);
					$fileget = json_decode(file_get_contents($file_path),true);
					$delfilepath = sprintf(
						'%s/%s.json',
						$o,
						$f
					);
					$addEventDiv .= sprintf(
						'<span style="%s; background-color:%s" onclick="del(\'%s\')">%s</span>',
						$this->arrayToStyleOrOptions($this->option['css']['eventBox']),
						$fileget['color'],
						$delfilepath,
						str_replace($this->option['shell_space_symbol']," ",$fileget['title'])
					);
				}      			
			}
		}
    	
		if(!empty($cellContent)){
			$daysStype = (
				date("d")==$cellContent && 
				date("m")==$this->currentMonth && 
				date("Y")==$this->currentYear
			) ? "current_days" : "days";

			$out = sprintf(
				'<td style="%s">%s<p style="%s">%s</p></td>',
				$this->arrayToStyleOrOptions($this->option['css'][$daysStype]),
				$addEventDiv,
				$this->arrayToStyleOrOptions($this->option['css']['days_number']),
				$cellContent
			);
		}else{
			$out = sprintf(
				'<td style="%s"></td>',
				$this->arrayToStyleOrOptions($this->option['css']['days'])
			);
		}

		return $out;
	}
     
	private function weeksInMonth($month=null,$year=null){
		if(null==($year)){
			$year =  date("Y", time()); 
		}
		
		if(null==($month)) {
			$month = date("m", time());
		}

		$daysInMonths = $this->daysInMonth($month, $year);
		$numOfweeks = ($daysInMonths % 7 == 0 ? 0 : 1) + intval($daysInMonths / 7);
		$monthEndingDay= date(
			'N',
			strtotime(
				$year.'-'.$month.'-'.$daysInMonths
			)
		);
		
		$monthStartDay = date(
			'N',
			strtotime(
				$year.'-'.$month.'-01'
			)
		);
         
		if($monthEndingDay<$monthStartDay){             
			$numOfweeks++;         
		}
         
		return $numOfweeks;
	}
 

	private function daysInMonth($month = null, $year = null){
		if(null == $year)
			$year =  date("Y", time()); 
		if(null == $month)
			$month = date("m", time());
		return date('t', strtotime($year.'-'.$month.'-01'));
	}

	private function requests($type,$item){
		if($type=="POST" && isset($_POST[$item])){
			return filter_input(INPUT_POST, $item);
		}else if($type=="GET" && isset($_GET[$item])){
			return filter_input(INPUT_GET, $item);
		}else{
			return '';
		}
	}

	private function getEventsFiles($date){
		$files = array(); 
		$dir = sprintf(
			'%s/%s', 
			$this->option['temp_files'],
			$date
		); 
    	
		if(is_dir($dir)){
			$command = sprintf(
				"cd %s/%s; ls",
				$this->option['temp_files'],
				$date
			);
			$output = shell_exec($command);
	    	
			if(!empty($output)){
				$files = explode(".json", $output);
				$files = array_filter(
					array_map(
						'trim', 
						$files
					)
				);
				return $files;
			}
		}
		return false;
	}

	private function shell($command, $arg){
		$validated = array_map(
			function($arg) { 
				return str_replace(
					array(';','|','&','$',' '), 
					array(''), 
					$arg
				);
			},
			$arg
		);

		if($this->isEnabled('shell_exec')) {
			switch($command){
				case 'createdir':
					if(is_array($validated) && is_dir($this->option['shell_files']) && is_dir($validated[0])){
						$command = sprintf(
							"sh %s/createdir.sh %s 2>&1",
							$this->option['shell_files'],
							implode(' ', $validated)
						);
						shell_exec($command);						
					}else{
						$this->outMessage = $this->option['lang']['errorMsg'];
					}
					break;
				case 'createfile':
					if(is_dir($validated[0])){
						$json = json_encode(array(
							"day"=>$validated[2],
							"title"=>$validated[3],
							"color"=>$validated[4]
						));
						$command = sprintf(
							"sh %s/createfile.sh %s %s %s %s 2>&1",
							$this->option['shell_files'], 
							$validated[0],
							$validated[1], 
							time(), 
							escapeshellarg($json)
						); 
						shell_exec($command);
						$this->outMessage = $this->option['lang']['eventAdded'];
					}else{
						$this->outMessage = $this->option['lang']['errorMsg'];
					}
				break;
			}
		}else{
			die("shell_exec is not enabled !");
		}
	}

	private function isEnabled($func) {
		return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
	}

	private static function url($url = ""){
		if(empty($url)){
			echo '<meta http-equiv="refresh" content="0"/>';
		}else{
			echo '<meta http-equiv="refresh" content="0; url='.$url.'"/>';
		}
		exit();
	}

	private function arrayToStyleOrOptions($array, $selectOptions = false){
		$output = '';
		$this->selectOptions = $selectOptions;
		try{
			if(is_array($array)){				
				$output = implode('; ', array_map(
					function ($v, $k) { 
						$sprintf = ($this->selectOptions) ? "<option value='%s'>%s</option>" : "%s:%s"; 
						return sprintf($sprintf, $k, $v); 
					},
					$array,
					array_keys($array)
				));
			}
		}catch(Exception $e){
			$this->outMessage = sprintf(
				'%s%s', 
				$this->option['lang']['errorMsg'],
				$e
			);
		}
		return $output;
	}
}
?>