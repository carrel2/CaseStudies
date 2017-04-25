$(function(){
	$('#addHotspot').on('click', function() {
		if( $('img#animal').data('selected') && $('input#name').val() != "" ) {
			var x1 = $('img#animal').data('x1');
			var y1 = $('img#animal').data('y1');
			var x2 = $('img#animal').data('x2');
			var y2 = $('img#animal').data('y2');

			var name = $('input#name').val().toLowerCase();
			$('input#name').val('');

			$('#hotspots').load('/addHotspot/' + $('img#animal').data('id') + '/' + name + '/' + x1 + '.' + y1 + '.' + x2 + '.' + y2, function(r, s, x) {
				$('.' + name + ':not(:last)').remove();
				$('#image').append('<div class="hotspot ' + name + '" style="background: rgba(255,255,255,.4); position: absolute; top: ' + y1 + 'px; left: ' + x1 + 'px; height: ' + (y2 - y1) + 'px; width: ' + (x2 - x1) + 'px;"></div>');
				$('div.hotspot').each(function() {
					$(this).hover(function() {
						$('.' + $(this).attr('class').replace(' ', '.')).css({'border': 'solid 1px black', 'z-index': '3'});
					},
					function() {
						$('.' + $(this).attr('class').replace(' ', '.')).css({'border': '', 'z-index': ''});
					});
				});
			});
		}

		inst.cancelSelection();
	});

	$('div.hotspot').each(function() {
		$(this).hover(function() {
			$('.' + $(this).attr('class').replace(' ', '.')).css({'border': 'solid 1px black', 'z-index': '3'});
		},
		function() {
			$('.' + $(this).attr('class').replace(' ', '.')).css({'border': '', 'z-index': ''});
		});
	});

	var inst = $('img#animal').imgAreaSelect({
		instance: true,
		onSelectEnd: function(img, selection) {
				$('img#animal').data('x1', selection.x1);
				$('img#animal').data('y1', selection.y1);
				$('img#animal').data('x2', selection.x2);
				$('img#animal').data('y2', selection.y2);
				$('img#animal').data('selected', true);
				$('input#name').focus();
		}
	});
});
