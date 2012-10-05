<?php
require 'conf.php';

$handled = false;

if (isset($_POST['key'])) {
	$handled = FormHandler::getInstance()->handle();
}
$key = FormHandler::getKey();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>vo-tee form</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta charset="UTF-8">
		<meta name="author" content="Yet Another Visual Artist - www.y-a-v-a.org">
	</head>
	<body>
		<h1>Vo-tee submission form</h1>
		<h2><a href="index.php">Go to overview</a></h2>
		<div class="container">
		<?php if ($handled === true): ?>
			<h2>Thanks for submitting the form!</h2>
		<?php endif; ?>
		<?php if(null !== Session::getSession()->getValue('msg')): ?>
			<?php echo Session::getSession()->getValue('msg'); ?>
		<?php endif; ?>
		<form id="application" method="post" enctype="multipart/form-data">
			<input type="hidden" name="key" value="<?=$key?>" />
			Your design: <input class="required" type="file" name="design" accept="image/jpeg,image/tiff,image/vnd.adobe.photoshop,application/pdf,application/postscript" /><br/>
			<input type="text" class="required" name="name" placeholder="Your name" /><br/>
			<input type="text" class="url" name="url" placeholder="Your website" /><br/>
			<input type="text" class="required email" name="email" placeholder="Your email address" /><br/>
			<input type="text" class="required" name="hometown" placeholder="Your hometown" /><br/>
			<input type="submit" value="Submit design!" />
		</form>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
		<script src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
		<script>
			jQuery('#application').validate();
		</script>
		<address>&bull; COpyLEft 2012 &bull; Yet Another Visual Artist &bull; <a href="http://www.y-a-v-a.org" target="_blank">y-a-v-a.org</a> &bull; <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/" target="_blank">by-nc-sa</a> &bull; <a href="https://github.com/y-a-v-a/vo-tee" target="_blank">code on github</a> &bull;</address>
	</body>
</html>
<?php
Session::getSession()->unsetValue('msg');
?>