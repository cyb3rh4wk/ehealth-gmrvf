$(document).ready(function()	{

	var counter = 6;
	var counter_med = 1;
	var $inputs = $("#pid #image_pid");

	//hide the take another photo button initially
	$('#new').hide();
	
	$inputs.keyup(function()	{
		$inputs.val($(this).val());
	});
	
	$(document).on('click', '#addSym', function(e)	{
		if(counter >= 10)	{
			alert("Limit reached!!!!");
			return false;
		}

		counter++;
		var newSym = $(document.createElement('div')).attr("id", 'sym' + counter);
		var symText = '<div class="row" id="sym' + counter + '"><div class="form-group col-lg-7"><input type="text" class="form-control" name="sym[]' + '" placeholder="Symptom ' + counter + '" /></div></div>';
		newSym.after().html(symText);
		newSym.appendTo("#sym_dynamic");

		e.preventDefault();
	});

	$(document).on('click', '#removeSym', function(e)	{

		if(counter == 2)	{
			alert("There must be atleast 2 Symptoms!!!!");
			return false;
		}

		$("#sym" + counter).remove();
		counter--;

	});
	
	$(document).on('click', '#addMed', function(e)	{
		counter_med++;
		var newMed = $(document.createElement('div')).attr("id", 'med' + counter_med);
		var medText = '<div class="row"><div class="col-lg-2"><div class="form-group"><input type="text" id="medicine_code' + counter_med + '" class="form-control" name="medicine_code[]" placeholder="Code" /></div></div><div class="col-lg-1"><span></span></div><div class="col-lg-4"><div class="form-group"><input type="text" id="medicine_name' + counter_med + '" class="form-control" name="medicine_name[]" placeholder="Name" /></div></div><div class="col-lg-1"><span></span></div><div class="col-lg-2"><div class="form-group"><input type="text" id="medicine_given' + counter_med + '" class="form-control" name="medicine_given[]" placeholder="###" /></div></div></div>';
		newMed.after().html(medText);
		newMed.appendTo("#med_dynamic");
		e.preventDefault();
	});

	$(document).on('click', '#removeMed', function(e)	{

		if(counter <= 1)	{
			alert("There must be atleast 1 Medicine!!!!");
			return false;
		}

		$("#med" + counter_med).remove();
		counter_med--;

	});

	$(document).on('change', '#image_upload_file', function () {
		var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');
		
		$('#image_upload_form').ajaxForm({
			beforeSend: function() {
				progressBar.fadeIn();
				var percentVal = '0%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			success: function(html, statusText, xhr, $form) {		
				obj = $.parseJSON(html);
				if(obj.status){		
					var percentVal = '100%';
					bar.width(percentVal)
					percent.html(percentVal);
					$("#imgArea>img").prop('src',obj.image_medium);			
				}else{
					alert(obj.error);
				}
			},
			complete: function(xhr) {
				progressBar.fadeOut();			
			}	
		}).submit();		
	});
	
	$("#pid").keyup(function () {
		var value = $(this).val();
		$("#image_pid").val(value);
	}).keyup();
});

function printPage()  {
	var printContent = document.getElementById("printArea").innerHTML;
	var originalContent = document.body.innerHTML;

	document.body.innerHTML = printContent;
	window.print();
	document.body.innerHTML = originalContent;
}