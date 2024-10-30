(function() {
	if (!document.body.contains(document.getElementById("nstla_setavatar"))) return;
	
	
	var img = document.getElementById("nstla_avatarimg");
	var input = document.getElementById("nstla_avatarinput");

	var imagepicker = wp.media({
		library : {
			type : "image"
		},
		multiple: false
	});


	document.getElementById("nstla_setavatar").addEventListener("click", function() {
		if (imagepicker) {
			imagepicker.open();
		}
	});

	imagepicker.on("select", function() {
		var image = imagepicker.state().get("selection").first().toJSON();
		img.setAttribute("src", image.url);
		input.setAttribute("value", image.url);
		input.setAttribute("avatarid", image.id);
	});

	imagepicker.on("open", function() {
		var id = input.getAttribute("avatarid");
		if (id) {
			var selection = imagepicker.state().get("selection");
			attachment = wp.media.attachment(id);
			attachment.fetch();
			selection.add(attachment ? [attachment] : []);
		}
	});

	if (document.body.contains(document.getElementById("nstla_deleteavatar"))) {
		document.getElementById("nstla_deleteavatar").addEventListener("click", function() {
			var url = input.getAttribute("gravatarurl");
			img.setAttribute("src", url);
			input.setAttribute("value", url);
		});
	}

})();