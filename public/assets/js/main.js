function showEmailField(){
	var value = $("#select-club").val();
	if (value){
		$("#form-froup-email").hide();
		$("#btn-export").html("Download CSV");
	} else {
		$("#form-froup-email").show();
		$("#btn-export").html("Request XML Report");
	}	
}

$(document).ready(function(){
	showEmailField();
	
	$(".input-date").mask('9999-99-99');
	
	$("#select-club").change(function(){
		showEmailField();
	})
})