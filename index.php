<?php
include 'conf.php';

Session::getSession()->unsetValue('loaded');

$coll = new Collection();
$imgs = $coll->getAmountOf(4);

?>
<!doctype html>
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
				<?php echo '<img src="'.$img.'" alt="" style="width: 240px;"/>' ."\n"; ?>
				<div class="label">Vote!</div>
			</div>
		<?php endforeach; ?>
		</div>
		<br style="clear:both;">
		<script>
			(function($) {
				$(document).scroll(function() {
					var windowSize = $(window).height();
					if (($(document).outerHeight() - 30) <= (windowSize + $(document.body).scrollTop())) {
						$.getJSON('ajax.php').done(function(data) {
							if (data.length > 0) {
								for (var i = 0; i < data.length; i++) {
									var div1, div2, img;
									div1 = $('<div>').attr('class','item');
									div2 = $('<div>').attr('class','label');
									div2.text('Vote!');
									img = $('<img>').attr('src', data[i]).attr('style','width: 240px');
									div1.append(img).append(div2);
									$('#collection').append(div1);
								}
								return true;
							}
							return false;
						});
					}
				});
			})(jQuery);
		</script>
	</body>
</html>
