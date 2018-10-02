var stack = [];

function updateCase() {
	var id = $('#default_title').val();
	var button = $('#default_start').parent().parent().clone();

	$('#case').load('/courses/cs/getDescription/' + id, function(response, status) {
		if( status == "success" ) {
			$(response).imagesLoaded().always(moveFooter);
			$('#default_start').parent().parent().remove();
			$('#case_description').after(button);
		} else {
			$('.icon i').removeClass('fa-spinner fa-pulse').addClass('fa-exclamation-triangle');
		}
	});
}

function addCheckboxListener() {
	$('input[type=checkbox]').on('change', function() {
		var cb = $(this);
		var cost = $('#cost');

		var currentCost = Number(cost.text()), weight = Number(cost.data('weight'));
		var cbCost;

		cbCost = Number(cb.attr('data-cost'));

		if(cb.data('use-weight') == 1) {
			cbCost *= weight;
		}

		var isChecked = cb.prop('checked');

		if( isChecked ) {
			cost.text((currentCost + cbCost).toFixed(2));
		} else {
			cost.text((currentCost - cbCost).toFixed(2));
		}
	});
}

function addHoverListener() {
	$('input[type=checkbox]').parent().hover(function() {
		if( $("#popup").length ) {
			return;
		}

		if( $(this).next("#popup").length ) {
			$("#popup").show();

			return;
		}

		var dose, interval, cost;

		dose = $(this).children().data('dosage');
		interval = $(this).children().data('interval');
		cost = parseFloat($(this).children().data('cost'));

		if($(this).children().data('use-weight') == 1) {
			cost *= parseFloat($('#cost').data('weight'));
		}

		$(this).after('<div id="popup" class="box is-italic" style="display:none;margin-top:0.75rem;position:absolute;z-index:1;"></div>');

		if(dose) {
			$("#popup").append('<div><span class="has-text-weight-semibold">Dosage:</span> ' + dose + '</div>');
		}

		if(interval) {
			$("#popup").append('<div><span class="has-text-weight-semibold">Interval:</span> ' + interval + '</div>');
		}

		$("#popup").append('<div><span class="has-text-weight-semibold">Client cost per day:</span> $' + cost.toFixed(2) + '</div>');

		$("#popup").show();
	}, function() {
		$("#popup").remove();
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

	moveFooter();
}

function scrollToView(element){
    var offset = element.offset().top;
    if(!element.is(":visible")) {
        element.css({"visibility":"hidden"}).show();
        var offset = element.offset().top;
        element.css({"visibility":"", "display":""});
    }

    var visible_area_start = $(window).scrollTop();
    var visible_area_end = visible_area_start + window.innerHeight;

    if(offset < visible_area_start || offset > visible_area_end){
         // Not in view so scroll to it
         $('html,body').animate({scrollTop: offset - window.innerHeight/3}, 1000);
         return false;
    }
    return true;
}

function checkForCKEDITORNotEmpty() {
	var emptyInstances = [];
	var container;

	for( instance in window.CKEDITOR.instances ) {
		instance = window.CKEDITOR.instances[instance];
		container = $(instance.container.$);

		if( container.prevAll('label.required').length && !instance.getData().length ) {
			emptyInstances.push(instance);

			if( !container.prev('.has-text-danger').length ) {
				container.before('<div class="is-size-7 has-text-weight-bold has-text-danger">This field is required.</div>');
			}
		}
	}

	if( emptyInstances.length ) {
		scrollToView($(emptyInstances[0].container.$));
		emptyInstances[0].focus();

		return false;
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

	$('#caseInfo').html("<div style='display:flex;justify-content:center;align-items:center;height:200px;'><span class='icon'><i class='fas fa-spinner fa-pulse'></i></span></div>")
		.load('/courses/cs/admin/getCase/' + id, function(responseTxt, statusTxt, xhr){
			$('.collection > div').each(function(i, e) {
				var t = $(this).parent().data('type');
				$(this).append('<button type="button" class="delete remove-button"></button>');
			});

			$('.collection.days > label').each(function() {
				$(this).text( "Day " + ( 1 + parseInt($(this).text()) ) );
			});

			$(responseTxt).imagesLoaded().always(moveFooter);

			moveSubmits();

			addRemoveButtonClickListener();

			checkForFileInputs();

			createLinkHierarchy();
		});
}

function updateHotspots() {
	$('.hotspot').each(function() {
		$(this).on('click', function() {
			$.get('/courses/cs/update/' + $(this).attr('data-path'), function(data, s) {
				$('#checked').append(data);

				$('#checked').imagesLoaded().always(moveFooter);
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

function submitNewCategory() {
	if( this.previousSibling.value == "" ) { return; }

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if( this.readyState == 4 && this.status == 200 ) {
			var selectContainer, holder;

			selectContainer = document.getElementById("animal_category").parentNode;
			holder = document.createElement("span");

			holder.innerHTML = this.responseText;
			selectContainer.innerHTML = holder.firstChild.firstChild.innerHTML;

			selectContainer.style.display = "";
			document.getElementById("add_category_container").style.display = "none";

			updateSelect();
		}
	}

	xhttp.open("GET", "/courses/cs/admin/category/add/" + this.previousSibling.value, true);
	xhttp.send();

	this.previousSibling.value = "";
}

function addNewCategory() {
	if( this.value != "add" ) { return; }

	this.parentNode.style.display = "none";
	this.value = this.options[0].value;

  var container = document.getElementById("add_category_container");

  if( container == null ) {
		container = document.createElement("DIV");
		container.id = "add_category_container";

		var input, submit, cancel;

		input = document.createElement("INPUT");
		input.type = "text";
		input.className = "input";

		submit = document.createElement("A");
		submit.className = "button";
		submit.innerHTML = "<span class='icon'><i class='fas fa-check'></i></span>";
		submit.onclick = submitNewCategory;

		cancel = document.createElement("A");
		cancel.className = "button";
		cancel.innerHTML = "<span class='icon'><i class='fas fa-times'></i></span>";
		cancel.onclick = function() {
			document.getElementById("add_category_container").style.display = "none";
			document.querySelectorAll("[data-id=category]")[0].parentNode.style.display = "";
			this.previousSibling.previousSibling.value = "";
		}

		container.appendChild(input);
		container.appendChild(submit);
		container.appendChild(cancel);

		this.parentNode.parentNode.appendChild(container);
	} else {
		container.style.display = "block";
	}
}

function updateSelect() {
	var select = document.querySelectorAll("[data-id=category]")[0];
	var option = document.createElement("OPTION");

	option.value = "add";
	option.innerHTML = "Add new category";

	select.appendChild(option);

	select.onchange = addNewCategory;
}

function checkForFileInputs() {
	try {
		var file = document.querySelectorAll('input[type=file]');

		for( var i = 0; i < file.length; i++ ) {
			var f = file[i];

			if( f.onchange == null ) {
				f.onchange = function(){
					if( this.files.length > 0 ) {
						this.parentNode.parentNode.lastChild.previousSibling.innerHTML = this.files[0].name;
					}
				}
			}

			if( f.dataset.sound ) {
				f.parentNode.parentNode.lastChild.previousSibling.innerHTML = f.dataset.sound;
			}
		}
	} catch (e) {}
}

function addLinksToHierarchy() {
	$('label[id=day_Z_label]').each(function(index) {
		var dIndex = index + 1;
		var id = $(this).attr('id');

		id = id[0].toUpperCase() + id.substring(1).replace('Z', dIndex);

		$(this).attr('id', id);

		$('#links').append('<p class="menu-label is-size-4">' + id.replace('_label', '').replace('_', ' ') + '</p><ul class="menu-list" data-id=' + id + '></ul>');

		var nestedLabels = $(this).next().children('label');

		if( nestedLabels.length != 0 ) {
			nestedLabels.each(function() {
				var nid = $(this).attr('id');

				nid = nid.replace('Z', dIndex);
				$(this).attr('id', nid);

				$('[data-id=' + id + ']').append('<li data-id=' + nid + '><a href=#' + $(this).attr('id') + '>' + $(this).text() + '</a></li>');

				$('[data-id=' + nid + ']').append('<ul></ul>');

				$(this).next().find('label[id]').each(function(i) {
						var val = $(this).parent().find('option:selected').text();

						$(this).attr('id', $(this).attr('id').replace('Z', dIndex).replace('Z', (i + 1)))

						$('[data-id=' + nid + '] ul').append('<li><a href=#' + $(this).attr('id') + '>' + val + ' ' + $(this).text() + '</a></li>');
				});
			});
		}
	});
}

function createLinkHierarchy() {
	$('#links').remove();
	$('section').append('<div id="links" class="menu" style="position: fixed; left: 0px; top: 0px; width: 200px; height: 100%; background: lightgrey; padding: 0.5rem; overflow: scroll; z-index: 35; display: none;"><ul class="menu-list"></ul></div>');
	$('#link_tab').animate({left: '0px'}, 'fast');

	addLinksToHierarchy();
}

function confirmDelete() {
	return confirm("This action cannot be undone!\n\nPress 'Ok' to continue.");
}

$(function() {
	$('.navbar-burger').on('click', function() {
		$(this).toggleClass('is-active');
		$('.navbar-menu').toggleClass('is-active');
	});

	$("body").imagesLoaded().always(moveFooter);
});
