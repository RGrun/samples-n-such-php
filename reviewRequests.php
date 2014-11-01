<?php

	//reviewRequests.php
	//admin page for reviewing requests made by users
	//admins only
	
	require_once "dbWorker.php"; //database functions wrapper object
	require_once "html.php"; //misc. html-helper object
	
	date_default_timezone_set('America/Los_Angeles');
	
	session_start();
	
	$worker = new dbWorker();
	
	$html = new html();
	
	$userId = $_SESSION['userId'];
	$isAdmin = $_SESSION['isAdmin'];
	
	if(!$isAdmin) {
		//get out of here!
		header("Location: core.php");
		die();
	}
	
	//mechanism for approving requests
	if(isset($_GET['approve'])) {
	
		$changeId = $_GET['ch'];
		$userToChange = $_GET['uid'];
		
		
		$now = date("Y-m-d H:i:s", time());
		
		$sql = "UPDATE changeRequests SET approved='1', app_dttm='$now' WHERE ch_id='$changeId'";
		$worker->query($sql);
		
		$sql2 = "SELECT field, content FROM changeRequests WHERE ch_id='$changeId'";
		
		
		$result2 = $worker->query($sql2);
		$row2 = mysqli_fetch_assoc($result2);
		
		$newContent = $row2['content'];
		$fieldToChange = $row2['field'];
		
		if($fieldToChange == "Rank") {
		
			$sql5 = "SELECT rank FROM j5_pilots WHERE userid='$userToChange'";
			$result5 = $worker->query($sql5);
			$row5 = $worker->fetch_array($result5);
			
			$rank = $row5['rank'];
			
			if($rank < 16) {
				$rank++;
				
				$sql3 = "UPDATE j5_pilots SET rank='$rank' WHERE userid='$userToChange'";
				$worker->query($sql3);
			}
			header("Location: reviewRequests.php");
			die();
		
		}
		
		$sql3 = "UPDATE j5_pilots SET $fieldToChange='$newContent' WHERE userid='$userToChange'";

		$worker->query($sql3);
		
		header("Location: reviewRequests.php");
		die();
	}
	
	//mechanism for hiding requests
	if(isset($_GET['hide'])) {
		
		$changeToHide = $_GET['ch'];
		
		$sql4 = "UPDATE changeRequests SET hidden='1' WHERE ch_id='$changeToHide'";
		$worker->query($sql4);
		
		header("Location: reviewRequests.php");
		die();
	}
	
	$page = $html->makeHeader();
	
	$page .= "<p>These are changes that pilots have requested to thier profiles.</p><p>Approve or reject the changes with the appropriate button.</p>";
	
	$sql = "SELECT * from changeRequests WHERE approved='0' AND hidden='0'";
	$result = $worker->query($sql);
	
	$page .= "<div class='adminTable'>"; //open adminTable
	
	$page .= "<table>" .
	"<tr><th>Change ID</th><th>Change To</th><th>New Content</th><th>User</th><th>Date</th></tr>";
	
	while($row = mysqli_fetch_assoc($result)) {
	
		extract($row);
		
		$page .= "<tr><td>$ch_id</td><td>$field</td><td>$content</td><td>$user_id</td><td>$dttm</td>" .
		"<td><a href='reviewRequests.php?ch=$ch_id&uid=$user_id&field=$field&approve=1'>Approve</a></td>" .
		"<td><a href='reviewRequests.php?ch=$ch_id&uid=$user_id&hide=1'>Dismiss</a></td></tr>";
	
	}
	
	$page .= "</table></div>"; //close adminTable
	
	$page .= "<br/><br/><a href='core.php'>Back to profile</a>";
	
	$page .= $html->makeFooter();
	
	echo $page;
	
	
?>