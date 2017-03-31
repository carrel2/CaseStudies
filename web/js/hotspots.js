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
				$('#image').append('<div class="' + name + '" style="background: rgba(255,255,255,.4); position: absolute; top: ' + y1 + 'px; left: ' + x1 + 'px; height: ' + (y2 - y1) + 'px; width: ' + (x2 - x1) + 'px;"></div>');
			});
		}
	});

	$('img#animal').imgAreaSelect({
		onSelectEnd: function(img, selection) {
				$('img#animal').data('x1', selection.x1);
				$('img#animal').data('y1', selection.y1);
				$('img#animal').data('x2', selection.x2);
				$('img#animal').data('y2', selection.y2);
				$('img#animal').data('selected', true);
		}
	});
});
