<?php
include 'conf.php';

Session::getSession()->unsetValue('loaded');

$coll = new Collection();
$imgs = $coll->getAmountOf(8);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>vo-tee index</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	</head>
	<body>
		<h1>Vo-tee - T-shirt design upload and rating event</h1>
		<h2><a href="form.php">Upload your image</a></h2>
		<div id="collection">
		<?php foreach($imgs as $img) : ?>
			<div class="item">
				<?php echo '<img src="'.$img['htpath'].'" alt="" style="width: 240px;"/>' ."\n"; ?>
				<div class="label">
					<span class="amount" id="V<?php echo $img['id'] ?>"><?php echo $img['votecount'];?></span> vote(s) for <?php echo $img['createdBy']['name']; ?> from <?php echo $img['createdBy']['hometown']; ?>
					<div class="action">
						<span id="M<?php echo $img['id'] ?>">
						<?php if ($img['agentVoted'] == '0'): ?>
							<a class="vote" id="<?php echo $img['id'] ?>">Vote</a>
						<?php else: ?>
							Thanks for your vote.
						<?php endif; ?>
						</span>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
		<br style="clear:both;">
		<script src="lib.js"></script>
	</body>
</html>
