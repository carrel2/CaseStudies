var stack = [];

function updateCase() {
	var id = $('#default_title').val();

	$('#case').load('/courses/cs/getDescription/' + id, function() {
		moveFooter();
	});
}

function addCheckboxListener() {
	$('input[type=checkbox]').on('change', function() {
		var cb = $(this);
		var cost = $('#cost');

		var currentCost = Number(cost.text());
		var cbCost = Number(cb.attr('data-cost'));

		var isChecked = cb.prop('checked');

		if( isChecked ) {
			cost.text((currentCost + cbCost).toFixed(2));
		} else {
			cost.text((currentCost - cbCost).toFixed(2));
		}
	});
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

			stack.push([$(this).parent().index(), $(this).parent().parent().attr('id'), $(this).parent().clone(true), $(this).parent().prev('label').clone(true), id]);

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

	addRemoveButtonClickListener();
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

		if( array[0] - 1 <= 0 ) {
			$('#' + array[1]).prepend( $(array[2]) ).prepend( $(array[3]) );
		} else if( array[3].is('label') && array[0] > ($('#' + array[1]).children().length / 2) - 1 ) {
			$('#' + array[1]).append( $(array[3]) ).append( $(array[2]) );
		} else if( !array[3].is('label') && array[0] > $('#' + array[1]).children().length - 1 ) {
			$('#' + array[1]).append( $(array[3]) ).append( $(array[2]) );
		} else {
			$('#' + array[1]).children().eq(array[0]).before( $(array[3]) );
			$('#' + array[1]).children().eq(array[0]).before( $(array[2]) );
		}

		if( array[4].length ) {
			window.CKEDITOR.replace(array[4], {"toolbar":[["Cut","Copy","Paste","PasteText","PasteFromWord","-","Undo","Redo"],["Scayt"],["Link","Unlink"],["Table","SpecialChar"],["Maximize"],["Source"],"\/",["Bold","Italic","Strike","-","RemoveFormat"],["NumberedList","BulletedList","-","Outdent","Indent","-","Blockquote"],["Styles","Format","About"]],"autoParagraph":false,"language":"en"});
		}

		if( stack.length == 0 ) {
			$(this).hide();
		}
	});

	$('#caseInfo').load('/courses/cs/admin/getCase/' + id, function(responseTxt, statusTxt, xhr){
		$('.collection > div').each(function(i, e) {
			var t = $(this).parent().data('type');
			$(this).append('<button type="button" class="delete remove-button"></button>');
		});

		$('.collection.days > label').each(function() {
			$(this).text( "Day " + ( 1 + parseInt($(this).text()) ) );
		});

		moveSubmits();
		moveFooter();

		addRemoveButtonClickListener();
	});
}

function updateHotspots() {
	$('.hotspot').each(function() {
		$(this).on('click', function() {
			$.get('/courses/cs/update/' + $(this).attr('data-path'), function(data, s) {
				$('#checked').append(data);

				moveFooter();
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
		$('#caseInfo button[type=submit].button').remove();
	}
}

function moveFooter() {
	if( $(window).height() > $('body').height() + $('footer.footer').height() ) {
		$('footer.footer').css({"position":"absolute","bottom":"0","right":"0","left":"0"});
	} else {
		$('footer.footer').css("position", "initial");
	}
}

function updateSelects(type) {
	$('select.' + type).each(function() {
		var v = $(this).find(':selected').val();

		$('select.' + type + ' option[value="' + val + '"').addClass('is-hidden');
	});
}

function confirmDelete() {
	return confirm("This action cannot be undone!\n\nPress 'Ok' to continue.");
}

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

	try {
		var file = document.querySelectorAll('input[type=file]')[0];
		file.onchange = function(){
			if( file.files.length > 0 ) {
				document.getElementById('filename').innerHTML = file.files[0].name;
			}
		}
	} catch (e) {}

	moveFooter();
});
