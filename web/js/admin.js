function addHotspot() {
	event.preventDefault();

	var holder = document.getElementById("case_hotspots");
	var prototype = holder.data("prototype");
	var index = holder.find(":input").length;
	var newForm = prototype.replace(/__name__/g, index);

	holder.data("index", index + 1);

	var div = document.createElement("DIV");

	div.append(newForm);
	holder.append(div);
}
