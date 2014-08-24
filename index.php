	<?php
	session_start();
	session_regenerate_id(true);
    require 'includes/config.php';
	require 'includes/functions.php';
    if (existLoggedUser()) {
        $username = $_SESSION['username'];
        $userId = $_SESSION['userId'];
    }
	require 'includes/header.php';

	if (isset($_SESSION['temp-username'])) {
    $username = $_SESSION['temp-username'];
	} else {
    	$username = '';
	}
    ?>


		<div id="asides">
			<aside>
				<?php if (existLoggedUser()) { ?>                
                    <header>User Panel</header>
                    <div id="hello-user">
                        <p>Hello, <?php echo $username . ' ' ?></p>
                        <hr>
                	<ul>
                	               	<li><a href="">POSTS</a></li>
                	               	<li><a href="add-post.php">ADD POST</a></li>
                	               	<li><a href="">ACCOUNT</a></li>
					</ul>               
                    <hr>
                    <a href="processing/logout.php">Logout</a>
                    </div>
                <?php } else { ?>
				<header>Log In</header>
				<div id="log_in">
						<div>Log In:</div>
						<form method="POST" action="processing/check-user.php" role="form">
                            <input type="text" name="username" placeholder="USERNAME" placeholder="username" required autocomplete="on" />
							<br>
							<input type="password" name="password" placeholder="PASSWORD" placeholder="password" required />
							<br>
							<input type="submit" value="Submit">
						</form>
						<br>
						<a href="#" onclick="openSignIn()">Don't have an account? Sign up!</a>
				</div>
				<div id="sign_up">
						<div>Sign Up:</div>
						<form method="POST" action="processing/check-user.php" role="form">
            <input id="username" type="text" name="username" required autocomplete="off" value="<?php echo $username; ?>" />
							
							<br>
            <input id="password" type="password" name="password" required />
							
							<br>
            <input id="reenter-password" type="password" name="reenter-password" required />
							
							<br>
							<input type="submit" value="Sign Up">
						</form>
				</div>
				<?php } ?>
			</aside>
			
			<aside>
				<header>Our Friends</header>
				<div id="friends_links">
					<ul>
						<li><a href="http://softuni.bg" target="_blank">Sofware University</a></li>
						<li><a href="http://chochev.eu" target="_blank">Chochev.eu</a></li>
						<li><a href="http://alexcondov.com" target="_blank">AlexCondov.com</a></li>
						<li><a href="">TBD</a></li>
						<li><a href="">TBD</a></li>
					</ul>
				</div>
			</aside>
		</div>
		<main id="index-main">
			<section>
					<header>Welcome!</header>
					<article>
						<header>Hello to Everyone</header>
						<p>
							Hello to everyone reading this! We are students from the Software University of Sofia 
                            (link is in the sidebar). We are currently taking a PHP Basics Course and this is our
                            small project.
						</p>
                        <p>
                            We are a team of seven young, motivated and talented prospects who are currently
                            starting their careers in the IT industry.
                        </p>
					</article>
                    <article>
                        <header>
                            What can you find here?
                        </header>
                        <p>
                            You can create a profile, or log in if you have one from the sidebar on the left. Then from the
                            navigation menu, you can visit the main part of the site - the forum.
                        </p>
                        <p>
                            On the contacts page you can see the people behind this incredible masterpiece, and responsible for all of its
                            bugs.
                        </p>
                        <p>
                            In Users you can find a ranking of the users of the forum, depending on their activity points.
                        </p>
                    </article>
			</section>
			
		
<?php
require 'includes/footer.php';
?>