function updateCase() {
	var id = $('#default_title').val();

	$('#case').load('/getDescription/' + id);
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
	$(holder).children('div:last-child').append('<button type="button" class="remove-button">Remove ' + t + '</button>');

	$('.remove-button').each(function() {
		$(this).on('click', function() {
			$(this).parent().remove();
		});
	});

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

	$('#caseInfo').load('/getCase/' + id, function(responseTxt, statusTxt, xhr){
		$('.collection > div').each(function(i, e) {
			var t = $(this).parent().data('type');
			$(this).append('<button type="button" class="remove-button">Remove ' + t + '</button>');
		});

		$('.remove-button').each(function() {
			$(this).on('click', function() {
				$(this).parent().remove();
			});
		});
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
