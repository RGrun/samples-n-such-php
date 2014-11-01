<?php

	//physicians.php
	//page with doctors list
	
	require_once "html.php"; //import html utils
	require_once "dbWorker.php"; //import dbWorker
	
	$html = new html();
	$worker = new dbWorker();
	
	//create header
	$header = $html->makeHeader("Physicians | University of Vermont Urologists");
	
	//create nav
	$nav = $html->makeNav();
	
	//title header section, Univ. of Vermont Dept. of Urology
	$titleHeader = "<div id='titleHeaderDiv'>" .
	'<h2>Our Physicians</h2>' .
	"</div>";
	
	//generate body 
	$body = "<div class='bodyContent'>";
	
	$body .= "<h3>Select a doctor to learn more about them:</h3>";
	
	$body .= "</div>";
	
	$teasers = "<div class='teasersBody'>";
	
	$teasers .= $worker->generateDoctorTeasers(); //create doctor teasers here 
	
	$teasers .= "</div>";
	
	
	//generate footer area
	$footer = "<div class='footerContent'>" .
	"<h5>Website by <a href='http://www.r3software.org'>r3 Software</a></h5>" .
	"</div>";
	
	//assemble page
	$page = $header . $titleHeader . $nav .  $body . $teasers . $footer . $html->makeFooter();
	
	echo $page;


?>
