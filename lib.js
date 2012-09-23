(function($) {
    var handleClick = function handleClick() {
	    var design = this.id || '';
        $.getJSON('vote.php', { design : design }).done(function(data) {
            if (data === 'false') {
                return false;
            }
            var count = $('#V' + data.id);
            if (!!count) {
                count.text(data.votecount);
            }
            if (data.agentVoted === '1') {
                $('#' + data.id).detach();
                console.log($('#M' + data.id));
                $('#M' + data.id).text('You\'re vote is added!');
            }
        });
	}
	
	$(document).scroll(function() {
		var windowSize = $(window).height();
		if (($(document).outerHeight() - 30) <= (windowSize + $(document.body).scrollTop())) {
			$.getJSON('ajax.php').done(function(data) {
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						var div1, div2, img, span1, span2;
						div1 = $('<div>').attr('class','item');
						div2 = $('<div>').attr('class','label');
						div2.text('Total votes: ');
						span1 = $('<span>').attr('id', 'V' + data[i]['id']).text(data[i]['votecount']);
						div2.append(span1).append($('<br>'));
						span2 = $('<span>').attr('id','M'+data[i]['id']);
						if (data[i]['agentVoted'] == '1') {
						    span2.text('You\'ve voted already!');
						} else {
						    var anchor = $('<a>').attr('class', 'vote').attr('id', data[i]['id']).text('Vote!');
						    anchor.click(handleClick);
						    span2.append(anchor);
						}
						div2.append(span2);
						img = $('<img>').attr('src', data[i]['htpath']).attr('style','width: 240px');
						div1.append(img).append(div2);
						$('#collection').append(div1);
					}
					return true;
				}
				return false;
			});
		}
	});
	
	$('.vote').click(handleClick);
	
})(jQuery);