function submitAjaxForm(form, successFunction) {
	$.ajax({
		url: form.attr('action'),
		type: form.attr('method'),
		data: form.serialize(),
		success: successFunction,
		error : function(data) {
			var json = JSON.parse(data.responseJSON);
			for (var item in json){
				form.find("input[name=\"" + item + "\"]").formError(json[item][0]);
			}
		}
	});
}