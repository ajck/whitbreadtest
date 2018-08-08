$('#searchbtn').click(function(e)
{
$.ajax({
	type: 'POST',
	url: 'backend.php',
	data: { place: $('#place').val() },
	dataType: 'json',
	success: function (data)
		{
console.log(data); // FOR DEBUGGING

		},
	error: function (data)
		{
		console.log('Error:', data.responseText); // FOR DEBUGGING
		}
	});
});