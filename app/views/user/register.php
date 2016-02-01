<div id="wrapper">
	<main id="content" class="group" role="main">
		<article role="article" class="group">
	  		<header class="page-header group">
	    		<div class="hgroup">
	      			<h1>Register to CreamPHP</h1>
	     		</div>
	  		</header>
	  		<div class="article-container group">
	    		<div class="inner">
	      			<p>Already registered ? <?=$this->link('Login', array('controller'=>'user', 'action'=>'login') ); ?> now.</p>
					<hr>
					<h2 id="visual-style">Register</h2>
					<form method="post">
						<label>Email</label>
						<input type="text" name="email" id="email">
						<label>password</label>
						<input type="password" name="password" id="password">
						<input type="submit" id="login" name="login" value="Login">
					</form>
				</div>
			</div>
		</article>
	</main>
</div>


	<?php 
/*
echo "t=".$t." testVar=".$testVar;
 $this->loadElement('hello');
 echo '['.$this->link('home','homepage',array('99','hi') ).']';
 */
?>