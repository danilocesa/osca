function submitAjaxForm(form, successFunction) {
	$.ajax({
		url: form.attr('action'),
		type: form.attr('method'),
		data: form.serialize(),
		success: successFunction,
		error : function(data) {
			console.debug(data);
			var json = data.responseJSON;
			// Remove previous errors
			form.find("div.error-message").remove();
			// Display errors
			for (var item in json){
				form.find("#" + item).after('<div class="error-message">' + json[item][0] + '</div>');
			}
		}
	});
}