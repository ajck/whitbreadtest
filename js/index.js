$('#searchbtn').click(function(e)
{
if($('#alert').hasClass('nodisplay')) $('#alert').addClass('nodisplay'); // Hide alert if still showing from previous search
$.ajax({
	type: 'POST',
	url: 'backend.php',
	data: { place: $('#place').val() },
	dataType: 'json',
	success: function (data) {
console.log(data); // FOR DEBUGGING
		if(data.err) { // If there was a warning message within the Foursquare results
			$('#alert').removeClass('nodisplay').html(data.msg); // Activate the Bootstrap alert component and inject the message text
		}
		if(data.results) { // If there were results to process
			row_items = 0; // Item counter so we only inject 3 items per row
			$.each(data.results, function(index, result) { // Parse through results
				insert_str = ''; // Empty HTML string we're going to insert
				
				if(row_items == 0) insert_str = '<div class="row">'; // Start a new row if row item counter indicates it's at the start
				insert_str += '<div class="col-md-4">'; // Start a new item
				
				insert_str += '</div>'; // Terminate new item
				row_items++;
				if(row_items == 3) {
					row_items = 0; // Reset row item counter
					insert_str += '</div>'; // Terminate a row
				}
			});
		}
	},
	error: function (data) {
console.log('Error:', data.responseText); // FOR DEBUGGING
	}
	});
});