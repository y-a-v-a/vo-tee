var busy = false;
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
                $('#M' + data.id).html('<span class="added">Your vote is added!</span>');
            }
        });
	}
	
	var handleScroll = function handleScroll(amount) {
	    var amount = parseInt(amount) || 1;
	    $.getJSON('ajax.php', { amount : amount }).done(function(data) {
			if (data.length > 0) {
				for (var i = 0; i < data.length; i++) {
					var div1, div2, img, span1, span2;
					div1 = $('<div>').attr('class','item');
					div2 = $('<div>').attr('class','label');
					div3 = $('<div>').attr('class','action');
					span1 = $('<span>').attr('class', 'amount').attr('id', 'V' + data[i]['id']).text(data[i]['votecount']);
					div2.append(span1);
					div2.append(' vote(s) for ' + data[i].createdBy.name + ' from ' + data[i].createdBy.hometown);
					span2 = $('<span>').attr('id','M'+data[i]['id']);
					if (data[i]['agentVoted'] == '1') {
					    span2.text('Thanks for your vote');
					} else {
					    var anchor = $('<a>').attr('class', 'vote').attr('id', data[i]['id']).text('Vote');
					    anchor.click(handleClick);
					    span2.append(anchor);
					}
					div3.append(span2);
					div2.append(div3);
					img = $('<img>').attr('src', data[i]['htpath']).attr('style','width: 240px');
					div1.append(img).append(div2);
					$('#collection').append(div1);
				}
				busy = false;
				return true;
			}
			return false;
		});
	}
	
	var shouldFetch = function shouldFetch() {
	    var windowSize = $(window).height();
		return ($(document).outerHeight() - 30) <= (windowSize + $(document.body).scrollTop());
	}
	
	$(document).scroll(function() {
	    if (!!shouldFetch()) {
	        if (busy == false) {
		        busy = true;
                handleScroll(2);
		    }
	    }
	});
	
	$('.vote').click(handleClick);
	
    if (!!shouldFetch()) {
        if (busy == false) {
	        busy = true;
            handleScroll(4);
	    }
    }
	
	
})(jQuery);