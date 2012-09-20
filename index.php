<?php
include 'conf.php';

$coll = new Collection();
$imgs = $coll->getAmountOf(3);

?>
<!doctype html>
<html>
	<head>
		<title>vo-tee index</title>
	</head>
	<link rel="stylesheet" href="style.css" type="text/css" />
	<body>
		<h1>Vo-tee - T-shirt design upload and rating event</h1>
		<h2><a href="form.php">Upload your image</a></h2>
		<?php foreach($imgs as $img) : ?>
			<div class="item">
				<?php echo '<img src="'.$img.'" alt="" style="width: 240px;"/>' ."\n"; ?>
				<div class="label">Vote!</div>
			</div>
		<?php endforeach; ?>
	</body>
</html>
<?php
Session::getSession()->unsetValue('loaded');
?>