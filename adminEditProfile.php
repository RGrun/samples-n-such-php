<?php

	//adminEditProfile.php
	//allows admins to edit user profiles
	
	require_once "dbWorker.php";
	require_once "html.php";
	
	date_default_timezone_set('America/Los_Angeles');
	
	session_start();
	
	$worker = new dbWorker();
	
	$html = new html();
	
	$userId = $_SESSION['userId'];
	$isAdmin = $_SESSION['isAdmin'];
	
	$currentUser = $_GET['uid'];
	
	if(!$isAdmin) {
		//get out of here!
		header("Location: core.php");
		die();
	}
	
	if(isset($_GET['demote'])) {
		//demote this user
		$sql2 = "SELECT rank FROM j5_pilots WHERE userid='$currentUser'";
		$result2 = $worker->query($sql2);
		$row2 = $worker->fetch_array($result2);
		
		$rank = $row2['rank'];
		
		if($rank >= 2) {
			$rank--;
			
			$sql3 = "UPDATE j5_pilots SET rank='$rank' WHERE userid='$currentUser'";
			$worker->query($sql3);
		}
		header("Location: adminEditProfile.php?uid=$currentUser");
		die();
	
	
	}
	
	if(isset($_GET['promote'])) {
		//promote this user
		$sql2 = "SELECT rank FROM j5_pilots WHERE userid='$currentUser'";
		$result2 = $worker->query($sql2);
		$row2 = $worker->fetch_array($result2);
		
		$rank = $row2['rank'];
		
		if($rank < 12) {
			$rank++;
			
			$sql3 = "UPDATE j5_pilots SET rank='$rank' WHERE userid='$currentUser'";
			$worker->query($sql3);
		}
		header("Location: adminEditProfile.php?uid=$currentUser");
		die();
	
	}
	
	if(isset($_GET['admin'])) {
		
		if($_GET['admin'] == "yes") {
			$sql = "UPDATE j5_pilots SET admin='1' WHERE userid='$currentUser'";
		} else {
			$sql = "UPDATE j5_pilots SET admin='0' WHERE userid='$currentUser'";
		}
		$worker->query($sql);
		header("Location: adminEditProfile.php?uid=$currentUser");
		die();
	}
	
	//mechanism for deleting medal from user
	//untested
	if(isset($_GET['deleteMedal'])) {
	
		$medalToDelete = $_GET['mid'];
		$deleteSql = "DELETE FROM j5_pilotMedals WHERE pilot='$currentUser' AND type='$medalToDelete'";
		$worker->query($deleteSql);
	
	}
	
	$page = $html->makeHeader();
	
	$page .= "<h3>ADMIN EDITING MODE</h3>";
	
	$page .= "<p>As an admin, you can modify whatever you'd like about this pilot's profile.</p><p>Changes are permanent and immediate.</p>";
	
	$page .= "<div class='landingView'>"; //open landingView
	
	$page .= "<div class='currentInfo'>"; //open currentInfo
	
	//fetch data from db
	$currentInfoSql = "SELECT * FROM j5_pilots WHERE userid='$currentUser'";
	$currentInfoResult = $worker->query($currentInfoSql);
	$currentInfoRow = $worker->fetch_array($currentInfoResult);
	
	$email = $currentInfoRow['email'];
	$country = $currentInfoRow['country'];
	$timeZone = $currentInfoRow['timezone'];
	$rank = $currentInfoRow['rank'];
	$status = $currentInfoRow['status'];
	$imageURL = $currentInfoRow['image'];
	$dateJoined = $currentInfoRow['dateJoined'];
	$dob = $currentInfoRow['dateBirth'];
	$description = $currentInfoRow['description'];
	$killsGround = $currentInfoRow['killsGround'];
	$killsAir = $currentInfoRow['killsAir'];
	$killsBalloon = $currentInfoRow['killsBalloon'];
	$userIsAdmin = $currentInfoRow['admin'];
	$active = ($currentInfoRow['active'] == 1 ? "Yes" : "No");
	
	//build currentData forms
	$emailData = "<div id='emailData'>" .
	"<table>" .
	"<tr><td>Email: $email </td><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=email'>Edit</a></td></tr>" .
	"</table></div>";
	
	$countryData = "<div id='countryData'>" .
	"<table>" .
	"<tr><td>Country: $country </td><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=country'>Edit</a></td></tr>" .
	"</table></div>";
	
	$timeZoneData = "<div id='timeZoneData'>" .
	"<table>" .
	"<tr><td>Time Zone: GMT $timeZone </td><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=timezone'>Edit</a></td></tr>" .
	"</table></div>";
	
	$rank = $worker->findRank($rank, "name");
	$medalImage = $worker->findMedalImage($rank);
	
	$rankData = "<div id='rankData'>" .
	"<table>" .
	"<tr><td><img src='ranks/$medalImage' /></td><td>Rank: $rank </td></tr>" . 
	"</table></div>";
	
	$status = $worker->findStatus($status, "name");

	$statusData = "<div id='statusData'>" .
	"<table>" .
	"<tr><td>Status: $status </td><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=status'>Edit</a></td></tr>" .
	"</table></div>";
	
	$imageData = "<div id='imageData'>" .
	"<table>" .
	"<tr><td><img src='avatars/$imageURL' /></td></tr>
	<tr><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=image'>Change Image</a></td></tr>" .
	"</table></div>";
	
	$dateJoinedData = "<div id='dateJoinedData'>" .
	"<table>" .
	"<tr><td>Date Joined: $dateJoined </td></tr>" .
	"</table></div>";
	
	$dobData = "<div id='dobData'>" .
	"<table>" .
	"<tr><td>DOB: $dob </td><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=dob'>Edit</a></td></tr>" .
	"</table></div>";
	
	$descriptionData = "<div id='descriptionData'>" .
	"<table>" .
	"<tr><td>$description</td></tr><tr><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=description'>Edit Description</a></td></tr>" .
	"</table></div>";
	
	$killsGroundData = "<div id='killsGroundData'>" .
	"<table>" .
	"<tr><td>Kills Ground: $killsGround </td><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=killsGround'>Edit</a></td></tr>" .
	"</table></div>";
	
	$killsAirData = "<div id='killsAirData'>" .
	"<table>" .
	"<tr><td>Kills Air: $killsAir </td><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=killsAir'>Edit</a></td></tr>" .
	"</table></div>";
	
	$killsBalloonData = "<div id='killsBalloonData'>" .
	"<table>" .
	"<tr><td>Kills Balloon: $killsBalloon </td><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=killsBalloon'>Edit</a></td></tr>" .
	"</table></div>";
	
	$activeData = "<div id='activeData'>" .
	"<table>" .
	"<tr><td>Active?: $active </td><td><a href='adminEditPilotInfo.php?uid=$currentUser&mtd=active'>Edit</a></td></tr>" .
	"</table></div>";
	
	//build currentInfo
	
	$page .= "<div class='innerInfo'>"; //open innerInfo
	
	
	$page .=  $emailData . $imageData . $countryData . $timeZoneData . $statusData . $dateJoinedData . $dobData
	. $killsGroundData . $killsAirData . $killsBalloonData . $activeData . $rankData;
	
	$page .= "</div>"; //end innerInfo

	$page .= $descriptionData;
	
	
	$page .= "</div>"; //close currentInfo
	
	//begin requestInfo
	$page .= "<div class='requestInfo'>"; //open requestInfo
	
	$medalSelect = $html->medalSelect();
	
	$header = "<h3>Promote Pilot or make admin: </h3>";
	
	$promotionForm = "<a href='adminEditProfile.php?uid=$currentUser&promote=1'>Promote</a> <br/>";
	
	$demotionForm = "<a href='adminEditProfile.php?uid=$currentUser&demote=1'>Demote</a><br/>";
	
	if($userIsAdmin == 1) {
		$adminForm = "<a href='adminEditProfile.php?uid=$currentUser&admin=no'>Remove Admin Status</a>";
	} else {
		$adminForm = "<a href='adminEditProfile.php?uid=$currentUser&admin=yes'>Give Admin Status</a>";
	}
	
	$page .= "<div class='innerRequestInfo'>". $header . $demotionForm . $promotionForm . $adminForm . "</div>";
	
	$page .= "</div>"; //end requestInfo
	
	//begin medalsView
	$page .= "<div class='medalsInfo'>"; //open medalsView
	
	$page .= "<table>" . //begin medals table
	"<tr><h2>$currentUser's Medals</h2></tr>";
	
	$medalsSql = "SELECT type, dateAwarded, comment FROM j5_pilotMedals WHERE pilot='$currentUser' ORDER BY dateAwarded DESC";
	$medalsResult = $worker->query($medalsSql);
	while($medalsRow = mysqli_fetch_assoc($medalsResult)) {
	
		$type = $medalsRow['type'];
		$comment = $medalsRow['comment'];
	
		$sql2 = "SELECT * from j5_medals WHERE id='$type'";
		$result2 = $worker->query($sql2);
		$row2 = mysqli_fetch_assoc($result2);
		
		$name = $row2['name'];
		$badgeImageURL = $row2['image']; //will need to fix this
		$description = $row2['description'];
		$date = $medalsRow['dateAwarded'];
		
		$page .= "<tr><th>$name</th></tr>" .
		"<tr><td><img src='medals/$badgeImageURL' alt='$description' onclick='openWindow($type)'/></td><td>$comment</td></tr>" .
		"<tr><td>Awarded: $date</td></tr>";
	
	}
	
	$page .= "</table>"; //end medals table
	
	
	
	$page .= "</div>"; //end medalsView
	
	$page .= "</div>"; //close landingView
	
	$page .= $html->makeFooter();
	
	echo $page;
	
	
	
	
?>