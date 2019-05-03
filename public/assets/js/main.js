$(document).ready(function(){
	// console.log("OOO");
    // $( "#hiddenField" ).datepicker({
      // showOn: "button",
        // buttonText: "day"
    // });
	
	$("#inputAlterarData").datepicker($.datepicker.regional["pt-BR"]);
	$("#btnAlterarData").click(function(){
		$("#inputAlterarData").datepicker('show');
	});
})