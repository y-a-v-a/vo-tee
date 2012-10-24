/**
 * jQuery.scroll.loader
 * Dual licensed under MIT and GPL.
 * Date: 10/21/2009
 *
 * @description Auto load content when the user has scrolled towards the bottom
 * @author Jim Yi
 * @version 0.1
 *
 * @id jQuery.fn.scrollLoader
 * @param {Object} settings Hash of settings, loadContent (function) is required.
 * @return {jQuery} Returns the same jQuery object for chaining.
 *
 */
(function($){
	$.fn.scrollLoader = function(options) {

		var defaults = {
			ratio: .05, // how close to the scrollbar is to the bottom before triggering a load
			loadContent: function() {} // function to call when the scrollbar has reached the threshold
		};

		var options = $.extend(defaults, options);

		return this.each(function() {
			var obj = this;
			var enabled = true;

			/* bind some custom events */
			$(obj).bind("enableLoad", function() {
				enabled = true;
			});
			$(obj).bind("disableLoad", function() {
				enabled = false;
			});
			$(obj).bind("manualLoad", function() {
				options.loadContent.call();
			});

			$(obj).bind("scroll", function() {
				if (enabled) {
					var scrollHeight, scrollPosition;
					if (obj == window) {
						scrollHeight = $(document).height();
					}
					else {
						scrollHeight = $(obj)[0].scrollHeight;
					}
					scrollPosition = $(obj).height() + $(obj).scrollTop();
					if ( (scrollHeight - scrollPosition) / scrollHeight <= options.ratio) {
						options.loadContent.call();
					}
				}
			});

			return false;
		});
	};
})(jQuery);



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
					if (data[i].createdBy.good  == false) {
					    div1.addClass('error');
					}
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
				$(window).trigger("enableLoad");
				return true;
			}
			return false;
		});
	}
	
	$('.vote').click(handleClick);
    
    $(window).load(function() {
      $(window).scrollLoader({
        loadContent: function() {
            $(window).trigger("disableLoad");
            handleScroll(4);
        }, ratio : 0.1
        });
    });
	
	
})(jQuery);