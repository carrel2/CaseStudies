$(function(){
	var selections = [];

	$('#addHotspot').on('click', function() {
		if( $('img#animal').data('selected') && $('input#name').val() != "" ) {
			var x1 = $('img#animal').data('x1');
			var rx1 = x1 / $('img#animal').width();

			var y1 = $('img#animal').data('y1');
			var ry1 = y1 / $('img#animal').height();

			var x2 = $('img#animal').data('x2');
			var rx2 = x2 / $('img#animal').width();

			var y2 = $('img#animal').data('y2');
			var ry2 = y2 / $('img#animal').height();

			var name = $('input#name').val().toLowerCase();
			$('input#name').val('');

			$('#hotspots').load('/courses/cs/addHotspot/' + $('img#animal').data('id') + '/' + name.replace(/ /g, "%20") + '/' + rx1 + '-' + ry1 + '-' + rx2 + '-' + ry2, function(r, s, x) {
				$('.' + name + ':not(:last)').remove();
				$('#image').append('<div class="hotspot ' + name.replace(/ /g, "-") + '" style="background: rgba(255,255,255,.4); position: absolute; top: ' + y1 + 'px; left: ' + x1 + 'px; height: ' + (y2 - y1) + 'px; width: ' + (x2 - x1) + 'px;"></div>');
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

	$('#image div.hotspot').each(function() {
		selections.push([[$(this).position().left, $(this).position().top], [$(this).position().left + $(this).width(), $(this).position().top + $(this).height()]]);
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
		parent: '#image',
		onSelectStart: function(img, selection) {
			for(s in selections) {
				if( selection.x1 > selections[s][0][0] && selection.y1 > selections[s][0][1] && selection.x2 < selections[s][1][0] && selection.y2 < selections[s][1][1] ) {
					inst.cancelSelection();
				}
			}
		},
		// onSelectChange: function(img, selection) {
		// 	var newX1, newX2, newY1, newY2;
		//
		// 	for(s in selections) {
		// 		if( selection.x1 <= selections[s][1][0] && selection.x2 > selections[s][1][0] && ( selection.y1 > selections[s][0][1] && selection.y1 < selections[s][1][1] || selection.y2 > selections[s][0][1] && selection.y2 < selections[s][1][1] ) ) {
		// 			newX1 = selections[s][1][0] + 1;
		// 		} else if( selection.x2 >= selections[s][0][0] && selection.x1 < selections[s][0][0] && ( selection.y1 > selections[s][0][1] && selection.y1 < selections[s][1][1] || selection.y2 > selections[s][0][1] && selection.y2 < selections[s][1][1] ) ) {
		// 			newX2 = selections[s][0][0] - 1;
		// 		} else if( selection.y1 <= selections[s][1][1] && selection.y2 > selections[s][1][1] && ( selection.x1 > selections[s][0][0] && selection.x1 < selections[s][1][0] || selection.x2 > selections[s][0][0] && selection.x2 < selections[s][1][0] ) ) {
		// 			newY1 = selections[s][1][1] + 1;
		// 		} else if( selection.y2 >= selections[s][0][1] && selection.y1 < selections[s][0][1] && ( selection.x1 > selections[s][0][0] && selection.x1 < selections[s][1][0] || selection.x2 > selections[s][0][0] && selection.x2 < selections[s][1][0] ) ) {
		// 			newY2 = selections[s][0][1] - 1;
		// 		}
		// 	}
		//
		// 	if( newX1 && !newX2 ) {
		// 		newX2 = newX1 + selection.width;
		// 	} else if( newX2 && !newX1 ) {
		// 		newX1 = (newX2 - selection.width >= 0) ? newX2 - selection.width : 0;
		// 	} else if( !newX1 && !newX2 ) {
		// 		newX1 = selection.x1;
		// 		newX2 = selection.x2;
		// 	}
		//
		// 	if( newY1 && !newY2 ) {
		// 		newY2 = newY1 + selection.height;
		// 	} else if( newY2 && !newY1 ) {
		// 		newY1 = (newY2 - selection.height >= 0) ? newY2 - selection.height : 0;
		// 	} else if( !newY1 && !newY2 ) {
		// 		newY1 = selection.y1;
		// 		newY2 = selection.y2;
		// 	}
		//
		// 	inst.setSelection( newX1, newY1, newX2, newY2 );
		//
		// 	inst.update();
		// },
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
