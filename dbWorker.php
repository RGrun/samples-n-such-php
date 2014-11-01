<?php

	//dbWorker 2.0
	//for Jasta 5 clan site
	
	interface dbConnectInfo {
		
		const HOST = "******"; 
		const USER = "*******";
		const PW = "*****";
		const DBNAME = "*******";
		
		public function doConnect();
	}
	
	class dbWorker implements dbConnectInfo {
	
		//constants from interface
		protected static $server = dbConnectInfo::HOST;
		protected static $db = dbConnectInfo::DBNAME;
		protected static $user = dbConnectInfo::USER;
		protected static $pass = dbConnectInfo::PW;
		protected $hookup;
		protected $connection;
		
		protected $masterEmail = "********"; 
		
		//returns active db connection
		public function doConnect() {
			$hookup = mysqli_connect(self::$server, self::$user, self::$pass, self::$db);
			if(mysqli_connect_error($hookup)) {	
				echo("Databse connection failure. Reason: " . mysqli_connect_error());
			}
			return $hookup;
		}
		
		public function __construct() {
			//establish connection to database
			$this->connection = $this->doConnect();
		}
		
		public function closeConnection() {
			mysqli_close($this->connection);
		}
		
		//query wrapper
		public function query($sql) {

			return mysqli_query($this->connection, $sql);
		}
		
		public function fetch_array($result, $assoc = true) {
			//if $assoc is true, returns associative array
			if($assoc) return mysqli_fetch_assoc($result);
			else return msqli_fetch_array($result);
		}
		
		public function buildPilotsTable($row) {
		
		
			extract($row);
			
			$rank = $this->findRank($rank, "name");
			
			$tr = "<tr><td>$userid</td><td>$country</td><td>$rank</td>" .
			"<td><a href='PHP/viewPilot.php?uid=$userid'>View Pilot</a></td></tr>";
			
			return $tr;
		}
		
		public function findStatusName($statusNow) {
		
			$worker = new dbWorker();
			
			$sql = "SELECT name FROM j5_status WHERE id='$statusNow'";
			$result = $worker->query($sql);
			
			$row = mysqli_fetch_array($result);
			
			return $row[0];
		
		}
		
		public function makeStatusSelector() {
		
			$worker = new dbWorker();
			
			$sql = "SELECT id, name FROM j5_status";
			
			$result = $worker->query($sql);
			$select = "<select name='newData' size='1'>";
			
			while($row = mysqli_fetch_assoc($result)) {
				
				$id = $row['id'];
				$name = $row['name'];
				
				$select .= "<option value='$id'>$name</option>";
			
			}
			
			$select .= "</select>";
			
			return $select;
		
		}
		
		public function findRank($rid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM j5_ranks WHERE id='$rid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		public function findStatus($sid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM j5_status WHERE id='$sid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		public function findMedal($mid, $requestedField) {
		
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM j5_medals WHERE id='$mid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		
		
		}
		
		public function findMedalImage($rank) {
			//takes rank as a string
			$medalImage = "";
			
			switch($rank) {
			
				case "Recruit":
				case "Flieger":
					$medalImage = "Flieger.png";
					break;
				case "Gefreiter":
					$medalImage = "Gefreiter.png";
					break;
				case "Unteroffizier":
					$medalImage = "Unteroffizier.png";
					break;
				case "Feldwebel":
					$medalImage = "Feldwebel.png";
					break;
				case "Hauptfeldwebel":
					$medalImage = "Feldwebel.png";
					break;
				case "Fahnrich":
					$medalImage = "Fahnrich.png";
					break;
				case "Leutnant":
					$medalImage = "Leutnant.png";
					break;
				case "Oberleutnant":
					$medalImage = "Oberleutnant.png";
					break;
				case "Stabshauptmann":
				case "Hauptmann":
					$medalImage = "Hauptmann.png";
					break;
				case "Staffelfuhrer":
					$medalImage = "Oberst.png";
					break;
			}
		
			return $medalImage;
		}
		
		public function requestUpdate($userId, $method, $newData) {
		
			date_default_timezone_set('America/Los_Angeles');
		
			$worker = new dbWorker();
			
			$now = date("Y-m-d H:i:s", time());
		
			$sql = "INSERT INTO changeRequests (field, content, user_id, dttm)" .
			" VALUES ('$method', '$newData', '$userId', '$now')";
			
			//echo $sql;
			
			$worker->query($sql);
			
			//send email to admin
			$to = $masterEmail;
			$subject = "Jasta5 Pilot Update Request";
			$message = "$userId has requested an update to their pilot profile. \r\n" .
			"They want to update thier $method. \r\n" .
			"To approve or reject this change, login to your Jasta5 Pilot page and go to the admin panel. \r\n";
			
			$headers = "From: Jasta5.org" . "\r\n";
			
			mail($to, $subject, $message, $headers);
		
		}
		
		public function requestMedal($userId, $medal) {
		
			date_default_timezone_set('America/Los_Angeles');
			
			$worker = new dbWorker();
			
			$now = date("Y-m-d H:i:s", time());
			
			$sql = "INSERT INTO medalRequests (user_id, medal_id, dttm) VALUES ('$userId', '$medal', '$now')";
			$worker->query($sql);
		
			//send email to admin
			$to = $masterEmail;
			$subject = "Jasta5 Pilot Medal Request";
			$message = "$userId has requested a medal. \r\n" .
			"To approve or reject this change, login to your Jasta5 Pilot page and go to the admin panel. \r\n";
			
			$headers = "From: Jasta5.org" . "\r\n";
			
			mail($to, $subject, $message, $headers);
			
		}
		
		

	}

?>