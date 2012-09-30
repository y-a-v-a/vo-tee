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
	</head>
	<body>
		<h1>Vo-tee submission form</h1>
		<h2><a href="index.php">Go to overview</a></h2>
		<?php if ($handled === true): ?>
			<h2>Thanks for submitting the form!</h2>
		<?php endif; ?>
		<?php if(null !== Session::getSession()->getValue('msg')): ?>
			<?php echo Session::getSession()->getValue('msg'); ?>
		<?php endif; ?>
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="key" value="<?=$key?>" />
			Your design: <input type="file" name="design" accept="image/jpeg,image/tiff,image/vnd.adobe.photoshop,application/pdf,application/postscript" /><br/>
			<input type="text" name="name" placeholder="Your name" /><br/>
			<input type="text" name="url" placeholder="Your website" /><br/>
			<input type="text" name="email" placeholder="Your email address" /><br/>
			<input type="text" name="hometown" placeholder="Your hometown" /><br/>
			<input type="submit" value="Submit design!" />
		</form>
	</body>
</html>
<?php
Session::getSession()->unsetValue('msg');
?>