var PROTOCOL = "http://";
var SYSTEM_WELCOME_PAGE = PROTOCOL+document.domain;
var AJAX_REQUEST_URL = PROTOCOL+document.domain+"/en/ajax";
var MESSAGE_WAIT = "გთხოვთ დაიცადოთ...";
var MESSAGE_EMAIL_NOT_FILED = "გთხოვთ შეავსოთ ელ-ფოსტის ველი !";
var MESSAGE_PASSWORD_NOT_FILED = "გთხოვთ შეავსოთ პაროლის ველი !";
var MESSAGE_CAPTCHA_NOT_FILED = "გთხოვთ შეავსოთ დამცავი კოდის ველი !";
var MESSAGE_USER_IS_ROBOT = "გთხოვთ მონიშნოთ მომხმარებლი !";
var MESSAGE_SENDING = "მოთხოვნა იგზავნება...";
var MESSAGE_WRONG_CAPTCHA = "დამცავი კოდი არასწორია !";
var MESSAGE_NO_USER = "მომხმარებლის ელ-ფოსტა ან პაროლი არასწორია !";
var MESSAGE_SIGN_OUT_PROBLEM = "სისტემიდან გასვლა ვერ მოხერხდა !";

$(document).on("click","#login-button",function(){

	$(".text-red").text(MESSAGE_WAIT);
	$(".text-red").fadeIn("slow");
	var email = $("#login-email").val();
	var password = $("#login-password").val();
	var captcha = $("#login-captcha").val();
	var testuser = $(".icheckbox_square-blue").attr("aria-checked");

	if(email==""){
		$(".text-red").text(MESSAGE_EMAIL_NOT_FILED);
	}else if(password==""){
		$(".text-red").text(MESSAGE_PASSWORD_NOT_FILED);
	}else if(captcha==""){
		$(".text-red").text(MESSAGE_CAPTCHA_NOT_FILED);
	}else if(testuser!="true"){
		$(".text-red").text(MESSAGE_USER_IS_ROBOT);
	}else{
		$(".text-red").text(MESSAGE_SENDING);
		$.post(AJAX_REQUEST_URL,{ b_auth:"true", e:email, p:password, c:captcha  }, function(result){
			if(result=="Enter"){
				location.href = SYSTEM_WELCOME_PAGE+"/ge/welcome-system"; 
				return true;
			}else if(result=="wrongCaptcha"){
				$(".text-red").text(MESSAGE_WRONG_CAPTCHA);
			}else if(result=="NoUser"){
				$(".text-red").text(MESSAGE_NO_USER);
			}
		});
	}

});

$(document).on("click","#system-out",function(){
	$(".overlay-loader").fadeIn("slow");
	$.post(AJAX_REQUEST_URL,{ logout:"true" },function(result){
		if(result=="Out"){
			location.href = SYSTEM_WELCOME_PAGE;
		}else{
			alert(MESSAGE_SIGN_OUT_PROBLEM);
		}
	});
});