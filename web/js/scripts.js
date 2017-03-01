// @TODO update to use jquery
function updateCase() {
	var xhttp = new XMLHttpRequest();
	var id = document.getElementById("default_title").value;

	xhttp.onreadystatechange = function() {
		if( this.readyState == 4 && this.status == 200 ) {
			document.getElementById("case").innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "/getDescription/" + id, true);
	xhttp.send();
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

function updateAdminCase() {
	var $id = $('#admin_case').val();

	$('#caseInfo').load('/getCase/' + $id, function(responseTxt, statusTxt, xhr){
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
