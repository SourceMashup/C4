<!DOCTYPE html>
<link rel="stylesheet" href="/_config/_assets/_css/dbCreate.css">
<title>Database Creator</title>
<?php
//ini_set('display_errors', 1);
$showForms = true;
$message = -1;

function inputData($message){
	$errMessages = array(
	array("Not all fields were filled out","Make sure that you specified a database, host (server name), a user to connect to that server and that users password"),
	array("Failed to connect to database","We could not connect to the database.  Does the database exist?  We need to connect to an existing database. Does the User have access to the database?"),
	array("Failed to execute setup querys","We had some trouble executing the setup querys.  Does the user have full permission to the database?"),
	array("Failed to create _config.php file","We could not write the config file to store the database information you provided.  Do we have permission to write to the _config directory?")
	);
	?>
<form action="/dbCreate.php" method="post">
<?php
	if($message >= 0)
	{
		echo "<msg><strong>ERROR: </strong>" . $errMessages[$message][0] . "<more>" . $errMessages[$message][1] . "</more><span></span></msg>";
	}
?>
<div id='heading'><span></span><h1>Database Setup</h1></div>
<h3>Before you start, we need some things from you</h3>
<p>Please set up an empty Mysql database to use this software and we will take care of the rest!</p>
<input type="textbox" name="dbname" value="" placeholder="Database Name" autocomplete='off'>

<input type="textbox" name="dbhost" value="localhost" placeholder="Database Host">

<input type="textbox" name="dbuser" value="" placeholder="Database User Name" autocomplete='off'>

<input type="password" name="dbpass" value="" placeholder="Database Password" autocomplete='off'>

<input type="submit" name="testdb" value="Submit">
</form>

	<?php
}


if(isset($_POST['dbname']) && isset($_POST['dbhost']) && isset($_POST['dbuser']) && isset($_POST['dbpass']))
{
	$showForms = false;

	$goodParms=true;
	$connStat=true;
	if(empty($_POST['dbpass'])){
		$goodParms=false;
	}
	if(empty($_POST['dbuser'])){
		$goodParms=false;
	}
	if(empty($_POST['dbhost'])){
		$goodParms=false;
	}
	if(empty($_POST['dbname'])){
		$goodParms=false;
	}




	if($goodParms){
		$dbconn = new mysqli($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'],$_POST['dbname']);
		if(!$dbconn->connect_error)
		{

			$drop_SITE_Table = "DROP TABLE IF EXISTS SITE;";
		 	$create_SITE_Table = "
				CREATE TABLE SITE (
	  				ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	  				CONFIG VARCHAR(4000) NOT NULL DEFAULT '{}'
				);
			";


			$drop_URLS_Table = "DROP TABLE IF EXISTS URLS;";
		 	$create_URLS_Table = "
				CREATE TABLE URLS (
	  				ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	  				URL VARCHAR(300) NOT NULL,
	  				REFERENCE_URL VARCHAR(300) DEFAULT NULL,
	  				REDIRECT_URL VARCHAR(300) DEFAULT NULL,
	  				LANDING_SITE TINYINT(1) NOT NULL DEFAULT '0',
	  				FILE VARCHAR(300) DEFAULT NULL
	  			)

			";

			$drop_CONTENT_Table = "DROP TABLE IF EXISTS CONTENT;";
		 	$create_CONTENT_Table = "
				CREATE TABLE CONTENT (
	  				ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	  				NAME VARCHAR(300) NOT NULL,
	  				CONTENT VARCHAR(4000) NOT NULL
				);
			";
			if($dbconn->query($drop_SITE_Table) === FALSE)
			{
				$message = 2;
				$showForms = true;
			}
			if($dbconn->query($create_SITE_Table) === FALSE)
			{
				$message = 2;
				$showForms = true;
			}
			if($dbconn->query($drop_URLS_Table) === FALSE)
			{
				$message = 2;
				$showForms = true;
			}
			if($dbconn->query($create_URLS_Table) === FALSE)
			{
				$message = 2;
				$showForms = true;
			}
			if($dbconn->query($drop_CONTENT_Table) === FALSE)
			{
				$message = 2;
				$showForms = true;
			}
			if($dbconn->query($create_CONTENT_Table) === FALSE)
			{
				$message = 2;
				$showForms = true;
			}
			if(!$showForms){
				$fileTxt = "<?php\n\r" . '$dbName' . " = '" . $_POST['dbname'] . "';\n\r" . '$dbHost' . " = '" . $_POST['dbhost'] . "';\n\r" . '$dbUser' . " = '" . $_POST['dbuser'] . "';\n\r" . '$dbPass' . " = '" . $_POST['dbpass'] . "';\n\r?>";
				if(file_put_contents($site->root() . DIRECTORY_SEPARATOR . "_config" . DIRECTORY_SEPARATOR . "_config.php", $fileTxt, LOCK_EX) === false)
				{
					$message = 3;
					$showForms = true;
				}
			}
			if(!$showForms){
				?>
				<div id="message">
					<div>
						<h1>Looks like we are all set up here!</h1>
						<p>Happy Developing!</p>
						<a href="/">Documentation</a>
					</div>
				</div>
				<?php
			}
		}else{
			$message = 1;
			$showForms = true;
		}
	}
	else{
		$message = 0;
		$showForms = true;
	}

}


if($showForms)
{

	inputData($message);
}



?>
