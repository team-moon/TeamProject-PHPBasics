	<?php
	session_start();
	session_regenerate_id(true);
    require '../includes/config.php';
	require '../includes/functions.php';
    if (existLoggedUser()) {
        $username = $_SESSION['username'];
        $userId = $_SESSION['userId'];
    }
	require 'header.php';

	if (isset($_SESSION['temp-username'])) {
    $username = $_SESSION['temp-username'];
	} else {
    	$username = '';
	}
    ?>


		<div id="asides">
			<aside>
				<?php if (!existLoggedUser()) { ?>                
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
						<form action="" method="post">
							<input type="text" name="user_name" placeholder="User Name...">
							<br>
							<input type="password" name="password" placeholder="Password...">
							<br>
							<input type="submit" value="Submit">
						</form>
						<br>
						<a href="#" onclick="openSignIn()">Don't have an account? Sign up!</a>
				</div>
				<div id="sign_up">
						<div>Sign Up:</div>
						<form action="" method="post">
							<input type="text" name="sign_up_user_name" placeholder="User Name...">
							<br>
							<input type="password" name="sign_up_password" placeholder="Password...">
							<br>
							<input type="text" name="repeat_sign_up_password" placeholder="Repeat Password...">
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
						<li><a href="#">Sofware University</a></li>
						<li><a href="">TBD</a></li>
						<li><a href="">TBD</a></li>
						<li><a href="">TBD</a></li>
						<li><a href="">TBD</a></li>
					</ul>
				</div>
			</aside>
		</div>
		<main id="index-main">
			<section>
					<header>Hello!</header>
					<article>
						<header>Article Header</header>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
					</article>
					<article>
						<header>Article Header</header>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
					</article>
			</section>
			<section>
					<header>Hello!</header>
					<article>
						<header>Article Header</header>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
					</article>
					<article>
						<header>Article Header</header>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
					</article>
			</section>
			<section>
					<header>Hello!</header>
					<article>
						<header>Article Header</header>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
					</article>
					<article>
						<header>Article Header</header>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat modi fugit dolore libero, voluptas cum, 
							qui a et eos minus enim magnam 
							consectetur veritatis ab mollitia molestiae iure beatae tenetur?
						</p>
					</article>
			</section>
		
<?php
require 'footer.php';
?>