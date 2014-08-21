<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
	<script src="script.js"></script>
</head>
<body>
	<div id="wrapper">
		<header>
			<div id="logo">
				Team Moon's Awesome Forum
			</div>
			<nav>
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="posts.php">Forum</a></li>
					<li><a href="#">Contacts</a></li>
				</ul>
				<div id="search-box">
                    <form method="POST" action="search.php" role="form">
                        <input type="text" name="searchText" placeholder="SEARCH..." required />
                        <input type="submit" name="search" value="Search" />
                    </form>
                </div>
			</nav>
		</header>