<?php
require 'conf.php';

$handled = false;

if (isset($_POST['key'])) {
	$handled = FormHandler::getInstance()->handle();
}
$key = FormHandler::getKey();



?>
<!doctype html>
<html>
	<head>
		<title>vo-tee</title>
	</head>
	<body>
		vo-tee submission form<br>
		<?php if ($handled === true): ?>
			Thanks for submitting the form!<br>
		<?php endif; ?>
		<?php if(null !== Session::getSession()->getValue('msg')): ?>
			<?php echo Session::getSession()->getValue('msg'); ?>
		<?php endif; ?>
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="key" value="<?=$key?>" />
			<input type="file" name="design" accept="image/jpeg,image/tiff,image/vnd.adobe.photoshop,application/pdf,application/postscript" /><br/>
			<input type="text" name="name" placeholder="your name" /><br/>
			<input type="text" name="url" placeholder="your website" /><br/>
			<input type="text" name="email" placeholer="your email address" /><br/>
			<input type="text" name="hometown" placeholder="your hometown" /><br/>
			<input type="submit" value="Send design!" />
		</form>
	</body>
</html>
<?php
Session::getSession()->unsetValue('msg');
?>