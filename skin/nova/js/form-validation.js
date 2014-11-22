jQuery(document).ready(function($) {

	// hide messages 
	$("#error").hide();
	$("#success").hide();
	
	// on submit...
	$("#contactForm #submit").click(function() {
		$("#error").hide();
		
		//required:
		
		//name
		var name = $("input#Email").val();
		if(name == ""){
			$("#error").fadeIn().text("Vui lòng nhập Username");
			$("input#Email").focus();
			return false;
		}
		
		// email
		var Passwd = $("input#Passwd").val();
		if(Passwd == ""){
			$("#error").fadeIn().text("Vui lòng nhập Password");
			$("input#Passwd").focus();
			return false;
		}
		
	
    //return false;
});

});

