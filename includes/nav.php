<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?> - Ready to Read</title>
		<link href="css/general.css" rel="stylesheet">
		<script src="js/modernizr-2.0.6.js"></script>
		<script src="js/respond.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Chango' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width">
	</head>
	<body>
		<div class="top"></div>
			<header>
				<div class="logo"><span id="top-header">&nbsp;Ready&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="to">to</span>Read!</span></div>
				<nav>
					<ul>
						<li<?php if ($page == 'home') { ?> class="current"<?php } ?>><a href="index.php">Home</a></li>
						<li<?php if ($page == 'getstarted') { ?> class="current"<?php } ?>><a href="getstarted.php">Get started</a></li>
						<li<?php if ($page == 'facts') { ?> class="current"<?php } ?>><a href="facts.php">Facts</a></li>
						<li<?php if ($page == 'about') { ?> class="current"<?php } ?>><a href="about.php">About</a></li>
					</ul>
				</nav>
			</header>