<?php

	//html.php
	//this is a utility class that provices basic html wrappers
	
	include_once "dbWorker.php";
	
	class html {
	
		private $worker;
		
		public function __construct() {
		
			//$this->worker = new dbWorker();
		
		}
	
		public function makeHeader() {
		
			//returns a fully working html header, ends with opening <body> tag
		
			$header = "<!DOCTYPE html>" .
			"<head>" .
			"<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />" .
			"<meta content='utf-8' http-equiv='encoding'>" .
			"<title>Jasta 5 Core System</title>" .
			"<link rel='stylesheet' type='text/css' href='/Jagdstaffeln_5/PHP/style.css'>" .
			"<script src='helpers.js'></script>";
			"</head>" .
			"<body>";
			
			// Report all PHP errors (see changelog)
			error_reporting(E_ALL);
			
			return $header;
		
		}
	
		public function makeFooter() {
		
			$footer = "</body></html>";
			return $footer;
		
		}
		
		public function medalSelect() {
		
			$worker = new dbWorker();
		
			$select = "<select name='newMedal' size='1'>";
			
			$select .= "<option disabled>---Certification Badges---</option>";
			
			$selectSql = "SELECT * FROM j5_medals WHERE category='1'";
			$selectResult = $worker->query($selectSql);
			while($selectRow = mysqli_fetch_assoc($selectResult)) {
			
				$value = $selectRow['id'];
				$name = $selectRow['name'];
				$select .= "<option value='$value'>$name</option>";
			
			}
			
			$select .= "<option disabled>---Campaign-Service Awards---</option>";
			
			$selectSql = "SELECT * FROM j5_medals WHERE category='2'";
			$selectResult = $worker->query($selectSql);
			while($selectRow = mysqli_fetch_assoc($selectResult)) {
			
				$value = $selectRow['id'];
				$name = $selectRow['name'];
				$select .= "<option value='$value'>$name</option>";
			
			}
			
			$select .= "<option disabled>---Jasta-Service Awards---</option>";
			
			$selectSql = "SELECT * FROM j5_medals WHERE category='3'";
			$selectResult = $worker->query($selectSql);
			while($selectRow = mysqli_fetch_assoc($selectResult)) {
			
				$value = $selectRow['id'];
				$name = $selectRow['name'];
				$select .= "<option value='$value'>$name</option>";
			
			}
			
			$select .= "<option disabled>---Bravery Medals---</option>";
			
			$selectSql = "SELECT * FROM j5_medals WHERE category='4'";
			$selectResult = $worker->query($selectSql);
			while($selectRow = mysqli_fetch_assoc($selectResult)) {
			
				$value = $selectRow['id'];
				$name = $selectRow['name'];
				$select .= "<option value='$value'>$name</option>";
			
			}
		
			$select .= "<option disabled>---Two-Seater Awards---</option>";
			
			$selectSql = "SELECT * FROM j5_medals WHERE category='5'";
			$selectResult = $worker->query($selectSql);
			while($selectRow = mysqli_fetch_assoc($selectResult)) {
			
				$value = $selectRow['id'];
				$name = $selectRow['name'];
				$select .= "<option value='$value'>$name</option>";
			
			}
			
			$select .= "<option disabled>---Balloon-Busting Medals---</option>";
			
			$selectSql = "SELECT * FROM j5_medals WHERE category='6'";
			$selectResult = $worker->query($selectSql);
			while($selectRow = mysqli_fetch_assoc($selectResult)) {
			
				$value = $selectRow['id'];
				$name = $selectRow['name'];
				$select .= "<option value='$value'>$name</option>";
			
			}
			
			$select .= "<option disabled>---Aerial-Combat Awards---</option>";
			
			$selectSql = "SELECT * FROM j5_medals WHERE category='7'";
			$selectResult = $worker->query($selectSql);
			while($selectRow = mysqli_fetch_assoc($selectResult)) {
			
				$value = $selectRow['id'];
				$name = $selectRow['name'];
				$select .= "<option value='$value'>$name</option>";
			
			}
			
			$select .= "</select>";
			
			return $select;
			
			
		
		}
	
		public function timezoneSelect() {
			$select = 	"<select name='newData' size='1'>
			<option value='-12'>(GMT-12:00) International Date Line West</option>
			<option value='-11'>(GMT-11:00) Midway Island, Samoa</option>
			<option value='-10'>(GMT-10:00) Hawaii</option>
			<option value='-9'>(GMT-09:00) Alaska</option>
			<option value='-8'>(GMT-08:00) Pacific Time (US & Canada)</option>
			<option value='-8'>(GMT-08:00) Tijuana, Baja California</option>
			<option value='-7'>(GMT-07:00) Arizona</option>
			<option value='-7'>(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
			<option value='-7'>(GMT-07:00) Mountain Time (US & Canada)</option>
			<option value='-6'>(GMT-06:00) Central America</option>
			<option value='-6'>(GMT-06:00) Central Time (US & Canada)</option>
			<option value='-6'>(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
			<option value='-6'>(GMT-06:00) Saskatchewan</option>
			<option value='-5'>(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
			<option value='-5'>(GMT-05:00) Eastern Time (US & Canada)</option>
			<option value='-5'>(GMT-05:00) Indiana (East)</option>
			<option value='-4'>(GMT-04:00) Atlantic Time (Canada)</option>
			<option value='-4'>(GMT-04:00) Caracas, La Paz</option>
			<option value='-4'>(GMT-04:00) Manaus</option>
			<option value='-4'>(GMT-04:00) Santiago</option>
			<option value='-3.5'>(GMT-03:30) Newfoundland</option>
			<option value='-3'>(GMT-03:00) Brasilia</option>
			<option value='-3'>(GMT-03:00) Buenos Aires, Georgetown</option>
			<option value='-3'>(GMT-03:00) Greenland</option>
			<option value='-3'>(GMT-03:00) Montevideo</option>
			<option value='-2'>(GMT-02:00) Mid-Atlantic</option>
			<option value='-1'>(GMT-01:00) Cape Verde Is.</option>
			<option value='-1'>(GMT-01:00) Azores</option>
			<option value='0'>(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
			<option value='0'>(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
			<option value='1'>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
			<option value='1'>(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
			<option value='1'>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
			<option value='1'>(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
			<option value='1'>(GMT+01:00) West Central Africa</option>
			<option value='2'>(GMT+02:00) Amman</option>
			<option value='2'>(GMT+02:00) Athens, Bucharest, Istanbul</option>
			<option value='2'>(GMT+02:00) Beirut</option>
			<option value='2'>(GMT+02:00) Cairo</option>
			<option value='2'>(GMT+02:00) Harare, Pretoria</option>
			<option value='2'>(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
			<option value='2'>(GMT+02:00) Jerusalem</option>
			<option value='2'>(GMT+02:00) Minsk</option>
			<option value='2'>(GMT+02:00) Windhoek</option>
			<option value='3'>(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
			<option value='3'>(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
			<option value='3'>(GMT+03:00) Nairobi</option>
			<option value='3'>(GMT+03:00) Tbilisi</option>
			<option value='3.5'>(GMT+03:30) Tehran</option>
			<option value='4'>(GMT+04:00) Abu Dhabi, Muscat</option>
			<option value='4'>(GMT+04:00) Baku</option>
			<option value='4'>(GMT+04:00) Yerevan</option>
			<option value='4.5'>(GMT+04:30) Kabul</option>
			<option value='5'>(GMT+05:00) Yekaterinburg</option>
			<option value='5'>(GMT+05:00) Islamabad, Karachi, Tashkent</option>
			<option value='5.5'>(GMT+05:30) Sri Jayawardenapura</option>
			<option value='5.5'>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
			<option value='5.75'>(GMT+05:45) Kathmandu</option>
			<option value='6'>(GMT+06:00) Almaty, Novosibirsk</option>
			<option value='6'>(GMT+06:00) Astana, Dhaka</option>
			<option value='6.5'>(GMT+06:30) Yangon (Rangoon)</option>
			<option value='7'>(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
			<option value='7'>(GMT+07:00) Krasnoyarsk</option>
			<option value='8'>(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
			<option value='8'>(GMT+08:00) Kuala Lumpur, Singapore</option>
			<option value='8'>(GMT+08:00) Irkutsk, Ulaan Bataar</option>
			<option value='8'>(GMT+08:00) Perth</option>
			<option value='8'>(GMT+08:00) Taipei</option>
			<option value='9'>(GMT+09:00) Osaka, Sapporo, Tokyo</option>
			<option value='9'>(GMT+09:00) Seoul</option>
			<option value='9'>(GMT+09:00) Yakutsk</option>
			<option value='9.5'>(GMT+09:30) Adelaide</option>
			<option value='9.5'>(GMT+09:30) Darwin</option>
			<option value='10'>(GMT+10:00) Brisbane</option>
			<option value='10'>(GMT+10:00) Canberra, Melbourne, Sydney</option>
			<option value='10'>(GMT+10:00) Hobart</option>
			<option value='10'>(GMT+10:00) Guam, Port Moresby</option>
			<option value='10'>(GMT+10:00) Vladivostok</option>
			<option value='11'>(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
			<option value='12'>(GMT+12:00) Auckland, Wellington</option>
			<option value='12'>(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
			<option value='13'>(GMT+13:00) Nuku'alofa</option>
		</select>";
		
			return $select;
		
		}
	
	
		public function pilotSelect() {
		
			$worker = new dbWorker();
		
			$sql = "SELECT userid FROM j5_pilots";
			
			$select = "<select name='newPilot' size='1'>";
			
			$result = $worker->query($sql);
			
			while($row = mysqli_fetch_array($result)) {
			
				$user = $row[0];
			
				$select .= "<option value='$user'>$user</option>";
			
			}
		
			$select .= "</select>";
			
			return $select;
		
		}
	
	}
	
	
	
?>