$(document).ready(function() {
	// Tent creation
	$('#create-tent').submit(function(event) {
        event.preventDefault();

        if ($('#info-alert').length != 0)
            $('div').remove('#info-alert');

		$.ajax({
			type: "POST",
			url: "/createtent",
			data: new FormData(this),
			contentType: false,
			processData: false,
			success: function () {
                $('#create-tent').after('<div class="alert alert-success" role="alert" id="info-alert"><h4>Палатка была успешно добавлена</h4><a href="/">Вернуться на главную страницу</a>');
			},
			error: function (msg) {
                $('#create-tent').after('<div class="alert alert-danger" role="alert" id="info-alert"><h4>Ошибка: </h4><a>'+ msg.responseJSON.message + '</a>');
			}
		});

	});

    // Tent details modal
    $('.details').click(function(event) {
        event.preventDefault();
        
		let id = $(this).data('id');

		$.ajax({
			type: 'GET',
			url: '/showtent/' + id,
			success: function (res) {
				$('#name').text(res.name);
				$('#type').text(res.type);
				$('#maximizedDimensions').text(res.maximizedDimensions + ' см');
				$('#minimizedDimensions').text(res.minimizedDimensions + ' см');
				$('#price').text(res.price + ' руб.');
				$('#description').text(res.description);
			},
			error: function (msg) {
				alert('Произошла ошибка: ' + msg.responseJSON.message);
			}
		});
	});

});