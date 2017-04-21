var stack = [];

function updateCase() {
	var id = $('#default_title').val();

	$('#case').load('/getDescription/' + id);
}

function addRemoveButtonClickListener() {
	$('.remove-button').each(function() {
		$(this).hover(function() {
			$(this).prev().css({'transition': 'box-shadow .5s','border-radius': '4px','box-shadow': '0px 0px 30px'});
		},
		function() {
			$(this).prev().css({'border-radius': '','box-shadow': ''});
		});
		$(this).on('click', function() {
			stack.push([$(this).parent().parent().attr('id'), $(this).prev().attr('style', '').parent().html()]);
			$(this).parent().slideUp(function() {
				$(this).remove();
			});
		});
	});
}

function addButtonClickListener(e) {
	holder = $(e).parent().prev().children('.collection');

	holder.data('index', holder.children('div').length);

	var t = holder.data('type');
	var prototype = holder.data('prototype');
	var index = holder.data('index');
	var newForm = prototype.replace(new RegExp('__' + t.replace(' ', '-') + '__', 'g'), index);

	newForm = newForm.replace(/label__/g, '');

	holder.append(newForm);
	holder.find('label').remove(':contains(' + index + ')');
	$(holder).children('div:last-child').append('<button type="button" class="remove-button">&#x2e3</button>');

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

	$('#undo').on('click', function() {
		var array = stack.pop();

		$('#' + array[0]).append('<div>' + array[1] + '</div>');
		addRemoveButtonClickListener();
	});

	$('#caseInfo').load('/getCase/' + id, function(responseTxt, statusTxt, xhr){
		$('.collection > div').each(function(i, e) {
			var t = $(this).parent().data('type');
			$(this).append('<button type="button" class="remove-button">&#x2e3</button>');
		});

		addRemoveButtonClickListener();
	});
}

function updateHotspots() {
	$('.hotspot').each(function() {
		$(this).on('click', function() {
			$.get('/update/' + $(this).data('path'), function(data, s) {
				$('#checked').append(data);
			});
		});
	});
}

function confirmDelete() {
	return confirm("This action cannot be undone!\n\nPress 'Ok' to continue.");
}
