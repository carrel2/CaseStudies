function hotspot(coords, color) {
	this.coords = coords;
	this.color = color;
	this.active = false;

	this.drawDefault = function(ctx) {
		ctx.beginPath();
		ctx.moveTo(coords[0], coords[1]);

		coords.forEach(function(item, index) {
			if(index % 2 == 0) {
				ctx.lineTo(coords[index], coords[index+1]);
			}
		});

		ctx.closePath();
		ctx.fillStyle = "rgba(200,200,200,0.5)";
		ctx.fill();

		if( this.active ) {
			ctx.strokeStyle = "black";
			ctx.stroke();

			this.active = false;
		}
	}

	this.drawHidden = function(ctx) {
		ctx.beginPath();
		ctx.moveTo(coords[0], coords[1]);

		coords.forEach(function(item, index) {
			if(index % 2 == 0) {
				ctx.lineTo(coords[index], coords[index+1]);
			}
		});

		ctx.closePath();
		ctx.fillStyle = color;
		ctx.fill();
	}

	this.draw = function() {
		this.drawDefault($('#canvas-default')[0].getContext("2d"));
		this.drawHidden($('#canvas-hidden')[0].getContext("2d"));
	}
}

function componentToHex(c) {
  var hex = c.toString(16);
  return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
  return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

$(function(){
	$('#addHotspot').on('click', function() {
		var coords = $('textarea.canvas-area').val().split(",");

		if( coords.length > 4 ) {
			var name = $('input#name').val().toLowerCase();
			$('input#name').val('');

			coords.forEach(function(item, index) {
				if( index % 2 ) {
					coords[index] = item / $('canvas').height();
				} else {
					coords[index] = item / $('canvas').width();
				}
			});

			$.post('/addHotspot/' + $('textarea.canvas-area').data('id') + '/' + name.replace(/ /g, "%20"), {coords: coords}, function(r, s, x) {
				var hotspotDiv = $("#hotspots").find("div.hotspot." + name.replace(/ /g, '-'));
				var hList = $.data(document.body, "hotspots");

				if( hotspotDiv.length ) {
					var id = hotspotDiv.attr("id").split('-')[1];

					coords.forEach(function(item, index) {
	          if( index % 2 ) {
	            coords[index] = item * $('canvas').height();
	          } else {
	            coords[index] = item * $('canvas').width();
	          }
	        });

					hList[id - 1] = new hotspot(coords,"rgb(#,#,#)".replace(/#/g, id));

					hList[id - 1].draw();
				} else {
					var h = new hotspot(coords,"rgb(#,#,#)".replace(/#/g, hList.length + 1));

					hList.push(h);
					h.draw();

					$("#hotspots").html(r);
					hotspotDiv.attr("id", "hotspot-" + hList.length);
				}

				$.data(document.body, "hotspots", hList);
			});
		}
	});

	$('#canvas-default').on('mousemove', function(e) {
		var rect = this.getBoundingClientRect();
		var pos = {
			x: e.clientX - rect.left,
			y: e.clientY - rect.top
		};

		var rgb = document.getElementById("canvas-hidden").getContext("2d").getImageData(pos.x, pos.y, 1, 1);
		var id = rgb.data[0];

		if(id) {
			var h = hotspotList[id - 1];

			h.active = true;

			$("div.hotspot").not("#hotspot-" + id).css("border", "none");
			$("#hotspot-" + id).css("border", "solid 2px");
		} else {
			$("div.hotspot").css("border", "none");
		}
	});
});
