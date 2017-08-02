var stack = [];

$(function() {
	$('.navbar-burger').on('click', function() {
		$(this).toggleClass('is-active');
		$('.navbar-menu').toggleClass('is-active');
	});

	$('.tooltip').tooltipster({
		theme: 'tooltipster-borderless',
		side: 'right',
		delay: 100
	});
})

function updateCase() {
	var id = $('#default_title').val();

	$('#case').load('/getDescription/' + id);
}

function addRemoveButtonClickListener() {
	$('.remove-button').each(function() {
		$(this).off("click mouseout mouseover");
		$(this).on('click',function() {
			var editor = $(this).siblings("div.cke");
			var id = "";

			$(this).parent().attr('style', '');

			$(editor).each(function() {
				id = $(this).prev().attr('id');
				delete window.CKEDITOR.instances[id];
				$(this).remove();
			});

			stack.push([$(this).parent().index(), $(this).parent().parent().attr('id'), $(this).parent().clone(true), id]);

			$(this).parent().slideUp(function() {
				if( $(this).prev().is('label') ) {
					$(this).prev().remove();
				}
				$(this).remove();
			});

			$('#undo').show();
		});
		$(this).on('mouseenter', function() {
				$(this).parent().css({'transition': 'box-shadow .5s','border-radius': '4px','box-shadow': '0px 0px 30px'});
		});
		$(this).on('mouseleave', function() {
			$(this).parent().css({'border-radius': '','box-shadow': ''});
		});
	});
}

function addButtonClickListener(e) {
	holder = $(e).closest('div').prev();

	holder.data('index', holder.children('div').length);

	var t = holder.data('type');
	var prototype = holder.data('prototype');
	var index = holder.data('index');
	var newForm = prototype.replace(new RegExp('__' + t.replace(' ', '-') + '__', 'g'), index);

	newForm = newForm.replace(/label__/g, '');

	holder.append(newForm);

	if( t != "day" ) {
		holder.find('label').remove(':contains(' + index + ')');
	} else {
		holder.children(':last-child').prev('label').text( 'Day ' + ( index + 1 ) );
	}

	holder.children('div:last-child').append('<button type="button" class="delete remove-button"></button>');

	if( t == "hotspot" ) {
		updateSelects(t);
	}

	addRemoveButtonClickListener();

	if( $(e).text() == "Add day" ) {
		$('.dayNumber').each(function(i, element){
			$(element).val(i);
		});
	}
}

function updateAdminCase(id) {
	if( id === undefined ) {
		id = $('#admin_case').val();
	}

	if( $('#admin_case').val() != id ) {
		$('#admin_case').val(id);
	}

	for( instance in window.CKEDITOR.instances ) {
		delete window.CKEDITOR.instances[instance];
	}

	$('#undo').off('click');
	$('#undo').on('click', function() {
		var array = stack.pop();

		if( array[0] == 0 ) {
			$('#' + array[1]).prepend( $(array[2]) );
		} else if( array[0] > $('#' + array[1]).children().length - 1 ) {
			$('#' + array[1]).append( $(array[2]) );
		} else {
			$('#' + array[1]).children().eq(array[0]).before( $(array[2]) );
		}

		window.CKEDITOR.replace(array[3], {"toolbar":[["Cut","Copy","Paste","PasteText","PasteFromWord","-","Undo","Redo"],["Scayt"],["Link","Unlink"],["Table","SpecialChar"],["Maximize"],["Source"],"\/",["Bold","Italic","Strike","-","RemoveFormat"],["NumberedList","BulletedList","-","Outdent","Indent","-","Blockquote"],["Styles","Format","About"]],"autoParagraph":false,"language":"en"});

		if( stack.length == 0 ) {
			$(this).hide();
		}
	});

	$('#caseInfo').load('/getCase/' + id, function(responseTxt, statusTxt, xhr){
		$('.collection > div').each(function(i, e) {
			var t = $(this).parent().data('type');
			$(this).append('<button type="button" class="delete remove-button"></button>');
		});

		$('.collection.days > label').each(function() {
			$(this).text( "Day " + ( 1 + parseInt($(this).text()) ) );
		});

		moveSubmits();

		// if( $('#footer').children().length == 1 ) {
		// 	var form = $('form').attr('id');
		//
		// 	$('button[type=submit].button').each(function() {
		// 		$('#footer').append($(this));
		// 		$(this).attr('form', form);
		// 	});
		// } else {
		// 	$('#body button[type=submit].button').remove();
		// }

		addRemoveButtonClickListener();
	});
}

function updateHotspots() {
	$('.hotspot').each(function() {
		$(this).on('click', function() {
			$.get('/update/' + $(this).attr('data-path'), function(data, s) {
				$('#checked').append(data);
			});
		});
	});
}

function moveSubmits() {
	if( $('#footer .level-left').children().length == 0 ) {
		var form = $('form').attr('id');

		$('button[type=submit].button').each(function() {
			$('#footer .level-left').append($(this));
			$(this).attr('form', form).wrap('<div class="level-item"></div>');
		});
	} else {
		$('#body button[type=submit].button').remove();
	}
}

function updateSelects(type) {
	$.get("/getAnimalInfo/" + $('#case_animal').val() + "/" + type, function(data, status) {
		$('.collection select.' + type).each(function() {
			$(this).html(data);
		});
	});
}

function confirmDelete() {
	return confirm("This action cannot be undone!\n\nPress 'Ok' to continue.");
}
