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
		<h1>vo-tee submission form</h1>
		<?php if ($handled === true): ?>
			<h2>Thanks for submitting the form!</h2>
		<?php endif; ?>
		<?php if(null !== Session::getSession()->getValue('msg')): ?>
			<?php echo Session::getSession()->getValue('msg'); ?>
		<?php endif; ?>
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="key" value="<?=$key?>" />
			<input type="file" name="design" accept="image/jpeg,image/tiff,image/vnd.adobe.photoshop,application/pdf,application/postscript" /><br/>
			<input type="text" name="name" placeholder="your name" /><br/>
			<input type="text" name="url" placeholder="your website" /><br/>
			<input type="text" name="email" placeholder="your email address" /><br/>
			<input type="text" name="hometown" placeholder="your hometown" /><br/>
			<input type="submit" value="Send design!" />
		</form>
		<a href="index.php">Goto home</a>
	</body>
</html>
<?php
Session::getSession()->unsetValue('msg');
?>