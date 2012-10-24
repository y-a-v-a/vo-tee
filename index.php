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
		<meta charset="UTF-8">
		<meta name="author" content="Yet Another Visual Artist - www.y-a-v-a.org">
	</head>
	<body>
		<h1><a href="http://gli.tc/h" target="_blank"><img src="img/GLITCH_2112_small.gif" alt="GLITCH" /></a>&nbsp;<img src="error.jpg" alt="error" /><br>Vo-tee - T-shirt design upload and rating event</h1>
		<h2><a href="form.php">Upload your image</a></h2>
		<p>Specifications can be read here: <a href="http://gli.tc/h/nfo/tshirts.txt" target="_blank">http://gli.tc/h/nfo/tshirts.txt</a></p>
		<div id="collection">
		<?php foreach($imgs as $img) : ?>
			<div class="item <?php echo $img['createdBy']['good'] == false ? 'error' : '' ?>">
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
		<p>Legend: <img src="error.png" alt="error" /> = not according specs = not votable.</p>
		<address>&bull; COpyLEft 2012 &bull; Yet Another Visual Artist &bull; <a href="http://www.y-a-v-a.org" target="_blank">y-a-v-a.org</a> &bull; <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/" target="_blank">by-nc-sa</a> &bull; <a href="https://github.com/y-a-v-a/vo-tee" target="_blank">code on github</a> &bull;</address>
		<script src="lib.js"></script>
	</body>
</html>
