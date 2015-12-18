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
var MESSAGE_OPERATION_DONE_EN = "Operation done successfully !";
var MESSAGE_OPERATION_DONE_GE = "ოპერაცია წარმატებით დასრულდა !";
var MESSAGE_OPERATION_ERROR_EN = "Error !";
var MESSAGE_OPERATION_ERROR_GE = "მოხდა შეცდომა !";

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

$(document).on("click","#update-profile",function(){
	var dlang = $(this).data("dlang");
	update_users_profile("self",dlang);
});

$(document).on("click","#update-profile-close",function(){
	var dlang = $(this).data("dlang");
	update_users_profile("home",dlang);
});



$(document).on("change","#profile-image",function(e){
	e.stopPropagation();
	e.preventDefault();
	var files = e.target.files;
	$(".file-size").fadeOut("slow"); 
	var noerror = false;
	var ex = files[0].name.split(".");
	var extLast = ex[ex.length - 1].toLowerCase();


	var reader = new FileReader();
    var image  = new Image();
    reader.readAsDataURL(files[0]); 
    reader.onload = function(_file) {
        image.src = _file.target.result; 
        image.onload = function() {
            var w = this.width,
                h = this.height,
                t = files[0].type,
                n = files[0].name,
                s = ~~(files[0].size/1024);
            if(w!=215 || h!=215 || s > 1024 || t != "image/jpeg"){
            	$(".file-size").fadeIn("slow");
            	var input = $("#profile-image");
            	input.replaceWith(input.val('').clone(true));
            	return false; 
            }
        };
        image.onerror= function() {
            $(".file-size").fadeIn("slow");
            var input = $("#profile-image");
            input.replaceWith(input.val('').clone(true));
			return false; 
        };    
    };

});


$(document).on("click","#add-catalogue",function(){
	var name = $("#titlex").val();
	var parent_idx = $("#parent_idx").val();
	var dlang = $(this).data("dlang");
	$(".overlay-loader").fadeIn("slow");
	$(".form-message-output").fadeOut("slow");
	if(name!=""){
		$.post(AJAX_REQUEST_URL, { addcatalogue:true, n:name, p:parent_idx }, function(result){
			if(result=="Done"){
				$(".overlay-loader").fadeOut("slow");
				if(dlang=="en"){
					$(".form-message-output").html(MESSAGE_OPERATION_DONE_EN).fadeIn("slow");
				}else{
					$(".form-message-output").html(MESSAGE_OPERATION_DONE_GE).fadeIn("slow");
				}
				$("#titlex").val('');
			}else{
				$(".overlay-loader").fadeOut("slow");
				if(dlang=="en"){
					$(".form-message-output").html(MESSAGE_OPERATION_ERROR_EN).fadeIn("slow");
				}else{
					$(".form-message-output").html(MESSAGE_OPERATION_ERROR_GE).fadeIn("slow");
				}
				$("#titlex").val('');
			}
		});
	}else{
		$(".overlay-loader").fadeOut("slow");
		$(".titlex-required").fadeIn("slow"); 
	}
});


$(document).on("click","#add-catalogue-close",function(){
	var name = $("#titlex").val();
	var parent_idx = $("#parent_idx").val();
	var dlang = $(this).data("dlang");
	$(".overlay-loader").fadeIn("slow");
	$(".form-message-output").fadeOut("slow");
	if(name!=""){
		$.post(AJAX_REQUEST_URL, { addcatalogue:true, n:name, p:parent_idx }, function(result){
			if(result=="Done"){
				location.href = SYSTEM_WELCOME_PAGE+"/"+dlang+"/katalogis-marTva";
			}else{
				$(".overlay-loader").fadeOut("slow");
				if(dlang=="en"){
					$(".form-message-output").html(MESSAGE_OPERATION_ERROR_EN).fadeIn("slow");
				}else{
					$(".form-message-output").html(MESSAGE_OPERATION_ERROR_GE).fadeIn("slow");
				}
				$("#titlex").val('');
			}
		});
	}else{
		$(".overlay-loader").fadeOut("slow");
		$(".titlex-required").fadeIn("slow"); 
	}
});

$(document).on("click","#edit-catalogue",function(){
	var name = $("#titlex").val();
	var oldname = $("#titlex").data("oldname");
	var dlang = $(this).data("dlang");
	var param = urlParamiters();
	$(".overlay-loader").fadeIn("slow");
	$(".form-message-output").fadeOut("slow");
	if(name!=""){
		$.post(AJAX_REQUEST_URL, { editcatalogue:true, n:name, i:param["id"], old:oldname, lang:dlang }, function(result){
			if(result=="Done"){
				$(".overlay-loader").fadeOut("slow");
				if(dlang=="2"){
					$(".form-message-output").html(MESSAGE_OPERATION_DONE_EN).fadeIn("slow");
				}else{
					$(".form-message-output").html(MESSAGE_OPERATION_DONE_GE).fadeIn("slow");
				}
				$("#titlex").data('oldname',name);
			}else{
				$(".overlay-loader").fadeOut("slow");
				if(dlang=="2"){
					$(".form-message-output").html(MESSAGE_OPERATION_ERROR_EN).fadeIn("slow");
				}else{
					$(".form-message-output").html(MESSAGE_OPERATION_ERROR_GE).fadeIn("slow");
				}
				$("#titlex").val('');
			}
		});
	}else{
		$(".overlay-loader").fadeOut("slow");
		$(".titlex-required").fadeIn("slow"); 
	}
});

$(document).on("click","#edit-catalogue-close",function(){
	var name = $("#titlex").val();
	var oldname = $("#titlex").data("oldname");
	var dlang = $(this).data("dlang");
	var param = urlParamiters();
	$(".overlay-loader").fadeIn("slow");
	$(".form-message-output").fadeOut("slow");
	if(name!=""){
		$.post(AJAX_REQUEST_URL, { editcatalogue:true, n:name, i:param["id"], old:oldname, lang:dlang }, function(result){
			if(result=="Done"){
				var lanx = (dlang==2) ? "en" : "ge"; 
				location.href = SYSTEM_WELCOME_PAGE+"/"+lanx+"/katalogis-marTva";
			}else{
				$(".overlay-loader").fadeOut("slow");
				if(dlang=="2"){
					$(".form-message-output").html(MESSAGE_OPERATION_ERROR_EN).fadeIn("slow");
				}else{
					$(".form-message-output").html(MESSAGE_OPERATION_ERROR_GE).fadeIn("slow");
				}
				$("#titlex").val('');
			}
		});
	}else{
		$(".overlay-loader").fadeOut("slow");
		$(".titlex-required").fadeIn("slow"); 
	}
});

$(document).on("click",".remove-catalogue",function(){
	var dlang = $(this).data("dlang"); 
	var catid = $(this).data("catid"); 
	var lg = "";
	if(dlang=="en"){
		$(".modal-body").html("<p>Please wait...</p>"); 
		$(".dojobbutton").hide();
		lg = 2;
	}else{
		$(".modal-body").html("<p>მოთხოვნა იგზავნება...</p>"); 
		$(".dojobbutton").hide();
		lg = 1;
	}
	$('.bs-example-modal-sm').modal("show");

	$.post(AJAX_REQUEST_URL, { checkmodelitem:true, ci:catid, lang:lg }, function(result){
		if(result=="Exists"){
			if(dlang=="en"){
				$(".modal-body").html("<p>You cant remove item !</p>");
			}else{
				$(".modal-body").html("<p>თქვენ არ გაქვთ მონაცემის წაშლის უფლება !</p>"); 
			}
		}else{
			if(dlang=="en"){
				$(".modal-body").html("<p>Would you like to delete item ?</p>"); 	
				$(".dojobbutton").text("Yes").fadeIn("slow");			
			}else{
				$(".modal-body").html("<p>გნებავთ წაშალოთ მონაცემი ?</p>"); 
				$(".dojobbutton").text("დიახ").fadeIn("slow");
			}
			$(".dojobbutton").data("removecatalogue",catid);
			
		}
	});

	 
});

$(document).on("click",".remove-user",function(){
	var userid = $(this).data("userid"); 
	var dlang = $(this).data("dlang"); 
	var lg = "";
	if(userid && dlang){
		if(dlang=="en"){
			$(".modal-body").html("<p>Would you like to delete item ?</p>"); 	
			$(".dojobbutton").text("Yes").fadeIn("slow");			
		}else{
			$(".modal-body").html("<p>გნებავთ წაშალოთ მონაცემი ?</p>"); 
			$(".dojobbutton").text("დიახ").fadeIn("slow");
		}
		$('.bs-example-modal-sm').modal("show");
		$(".dojobbutton").data("removeuser",userid);
	}
});


$(document).on("click",".dojobbutton",function(){
	var removecatalogue = $(this).data("removecatalogue");
	var removeuser = $(this).data("removeuser");
	if(removecatalogue){
		$('.bs-example-modal-sm').modal("hide");
		$(".overlay-loader").fadeIn("slow");
		$.post(AJAX_REQUEST_URL, { removeCatalogue:true, cidx:removecatalogue }, function(result){
			if(result=="Done"){
				location.reload();
			}else{
				$(".overlay-loader").fadeIn("hide");
				alert("Critical Error ! N1");				
			}
		});
	}else if(removeuser){
		$('.bs-example-modal-sm').modal("hide");
		$(".overlay-loader").fadeIn("slow");
		$.post(AJAX_REQUEST_URL, { removeuserx:true, uid:removeuser }, function(result){
			if(result=="Done"){
				location.reload();
			}else{
				$(".overlay-loader").fadeIn("hide");
				//alert("Critical Error ! N1");
				console.log("test");
			}
		});
	}
});

$(document).on("click",".up-catalog",function(){
	var idx = $(this).data("idx");
	var cid = $(this).data("cid");
	var position = $(this).data("position");
	$(".overlay-loader").fadeIn("slow");
	$.post(AJAX_REQUEST_URL, { changeposition:true, t:"up", i:idx, c:cid, p:position }, function(result){
		if(result=="Done"){
			location.reload();
		}
	});
});

$(document).on("click",".down-catalog",function(){
	var idx = $(this).data("idx");
	var cid = $(this).data("cid");
	var position = $(this).data("position");
	$(".overlay-loader").fadeIn("slow");
	$.post(AJAX_REQUEST_URL, { changeposition:true, t:"down", i:idx, c:cid, p:position }, function(result){
		if(result=="Done"){
			location.reload();
		}
	});
});


$(document).on("click","#add-user",function(){
	var username = $("#username").val();
	var password = $("#password").val();
	var user_type = $("#user_type").val();
	var namelname = $("#namelname").val();
	var dob = $("#dob").val();
	var mobile = $("#mobile").val();
	var email = $("#email").val();
	var address = $("#address").val();
	var dlang = $(this).data("dlang");
	var image = ($("#profile-image").val()) ? "true" : "false";
	$(".help-block").fadeOut("slow");
	if(username==""){
		$(".username-required").fadeIn("slow"); 
	}else if(password==""){
		$(".password-required").fadeIn("slow"); 
	}else if(namelname==""){
		$(".namelname-required").fadeIn("slow"); 
	}else if(mobile==""){
		$(".mobile-required").fadeIn("slow"); 
	}else if(email==""){
		$(".email-required").fadeIn("slow"); 
	}else{
		$(".overlay-loader").fadeIn("slow");
		$.post(AJAX_REQUEST_URL,{
			adduser:true,
			u:username, 
			p:password, 
			us:user_type, 
			n:namelname, 
			d:dob, 
			m:mobile, 
			e:email, 
			a:address, 
			i:image 
		},function(result){
			$(".overlay-loader").hide(); 
			if(image=="true"){
				$("#companyId").val(result);
				$("#profile-picture-form").submit();
			}else{
				if(result=="Done"){ 
					if(dlang=="ge"){
						$(".form-message-output").text(MESSAGE_OPERATION_DONE_GE).fadeIn("slow");
					}else{
						$(".form-message-output").text(MESSAGE_OPERATION_DONE_EN).fadeIn("slow");
					}
				}else{
					if(dlang=="ge"){
						$(".form-message-output").text(MESSAGE_OPERATION_ERROR_GE).fadeIn("slow");
					}else{
						$(".form-message-output").text(MESSAGE_OPERATION_ERROR_EN).fadeIn("slow");
					}
				}
			}
		});
	}
});


$(document).on("click","#add-user-close",function(){
	var username = $("#username").val();
	var password = $("#password").val();
	var user_type = $("#user_type").val();
	var namelname = $("#namelname").val();
	var dob = $("#dob").val();
	var mobile = $("#mobile").val();
	var email = $("#email").val();
	var address = $("#address").val();
	var dlang = $(this).data("dlang");
	var image = ($("#profile-image").val()) ? "true" : "false";
	$(".help-block").fadeOut("slow");
	if(username==""){
		$(".username-required").fadeIn("slow"); 
	}else if(password==""){
		$(".password-required").fadeIn("slow"); 
	}else if(namelname==""){
		$(".namelname-required").fadeIn("slow"); 
	}else if(mobile==""){
		$(".mobile-required").fadeIn("slow"); 
	}else if(email==""){
		$(".email-required").fadeIn("slow"); 
	}else{
		$(".overlay-loader").fadeIn("slow");
		$.post(AJAX_REQUEST_URL,{
			adduser:true,
			u:username, 
			p:password, 
			us:user_type, 
			n:namelname, 
			d:dob, 
			m:mobile, 
			e:email, 
			a:address, 
			i:image 
		},function(result){
			$(".overlay-loader").hide(); 
			if(image=="true"){
				$("#typo").val("blank");
				$("#companyId").val(result);
				$("#profile-picture-form").submit();
			}else{
				if(result=="Done"){ 
					location.href = SYSTEM_WELCOME_PAGE+"/"+dlang+"/momxmareblis-marTva";
				}else{
					if(dlang=="ge"){
						$(".form-message-output").text(MESSAGE_OPERATION_ERROR_GE).fadeIn("slow");
					}else{
						$(".form-message-output").text(MESSAGE_OPERATION_ERROR_EN).fadeIn("slow");
					}
				}
			}
		});
	}
});


$(document).on("click","#edit-user",function(){
	var uidx = $(this).data("userid");
	var password = $("#password").val();
	var namelname = $("#namelname").val();
	var dob = $("#dob").val();
	var mobile = $("#mobile").val();
	var email = $("#email").val();
	var address = $("#address").val();
	var dlang = $(this).data("dlang");
	var image = ($("#profile-image").val()) ? "true" : "false";
	$(".help-block").fadeOut("slow");
	if(namelname==""){
		$(".namelname-required").fadeIn("slow"); 
	}else if(mobile==""){
		$(".mobile-required").fadeIn("slow"); 
	}else if(email==""){
		$(".email-required").fadeIn("slow"); 
	}else{
		$(".overlay-loader").fadeIn("slow");
		$.post(AJAX_REQUEST_URL,{
			edituser:true,
			userid:uidx, 
			p:password, 
			n:namelname, 
			d:dob, 
			m:mobile, 
			e:email, 
			a:address, 
			i:image 
		},function(result){
			$(".overlay-loader").hide(); 
			if(image=="true"){
				$("#profile-picture-form").submit();
			}else{
				if(result=="Done"){ 
					if(dlang=="ge"){
						$(".form-message-output").text(MESSAGE_OPERATION_DONE_GE).fadeIn("slow");
					}else{
						$(".form-message-output").text(MESSAGE_OPERATION_DONE_EN).fadeIn("slow");
					}
				}else{
					if(dlang=="ge"){
						$(".form-message-output").text(MESSAGE_OPERATION_ERROR_GE).fadeIn("slow");
					}else{
						$(".form-message-output").text(MESSAGE_OPERATION_ERROR_EN).fadeIn("slow");
					}
				}
			}
		});
	}
});


$(document).on("click","#edit-user-close",function(){
	var uidx = $(this).data("userid");
	var password = $("#password").val();
	var namelname = $("#namelname").val();
	var dob = $("#dob").val();
	var mobile = $("#mobile").val();
	var email = $("#email").val();
	var address = $("#address").val();
	var dlang = $(this).data("dlang");
	var image = ($("#profile-image").val()) ? "true" : "false";
	$(".help-block").fadeOut("slow");
	if(namelname==""){
		$(".namelname-required").fadeIn("slow"); 
	}else if(mobile==""){
		$(".mobile-required").fadeIn("slow"); 
	}else if(email==""){
		$(".email-required").fadeIn("slow"); 
	}else{
		$(".overlay-loader").fadeIn("slow");
		$.post(AJAX_REQUEST_URL,{
			edituser:true,
			userid:uidx, 
			p:password, 
			n:namelname, 
			d:dob, 
			m:mobile, 
			e:email, 
			a:address, 
			i:image 
		},function(result){
			$(".overlay-loader").hide(); 
			if(image=="true"){
				$("#typo").val("blank");
				$("#profile-picture-form").submit();
			}else{
				if(result=="Done"){ 
					location.href = SYSTEM_WELCOME_PAGE+"/"+dlang+"/momxmareblis-marTva";
				}else{
					if(dlang=="ge"){
						$(".form-message-output").text(MESSAGE_OPERATION_ERROR_GE).fadeIn("slow");
					}else{
						$(".form-message-output").text(MESSAGE_OPERATION_ERROR_EN).fadeIn("slow");
					}
				}
			}
		});
	}
});


/* Functions START */
$(document).on("click",".reloadMe",function(){
	location.reload();
});


$(document).on("click",".gotoUrl",function(){
	var g = $(this).data("goto");
	location.href = g;
});


function update_users_profile(type,dlang){
	var namelname = $("#namelname").val(); 
	var dob = $("#dob").val(); 
	var mobile = $("#mobile").val(); 
	var email = $("#email").val(); 
	var address = $("#address").val();  

	$(".overlay-loader").fadeIn("slow");
	$(".help-block").fadeOut("slow");
	if(namelname==""){
		$(".overlay-loader").fadeOut("slow");
		$(".namelname-required").fadeIn("slow");
		return false;
	}else if(mobile==""){
		$(".overlay-loader").fadeOut("slow");
		$(".mobile-required").fadeIn("slow");
		return false;
	}else if(email==""){
		$(".overlay-loader").fadeOut("slow");
		$(".email-required").fadeIn("slow");
		return false;
	}else{
		$.post(AJAX_REQUEST_URL,{ updateUserProfile:true, n:namelname, d:dob, m:mobile, e:email, a:address, lang:dlang  },function(result){
			if($("#profile-image").val() != ""){
				$("#typo").val(type);
				$("#profile-picture-form").submit();
			}else{
				if(type=="home"){
					location.href = SYSTEM_WELCOME_PAGE+"/ge/welcome-system";
				}else{
					$(".form-message-output").html("<p>"+result+"</p>").fadeIn("slow");
					$(".overlay-loader").fadeOut("slow");
				}
			}
		});
	}	
}

function urlParamiters()
{
	var query_string = new Array();
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		if (typeof query_string[pair[0]] === "undefined") {
		  query_string[pair[0]] = pair[1];
		} else if (typeof query_string[pair[0]] === "string") {
		  var arr = [ query_string[pair[0]], pair[1] ];
		  query_string[pair[0]] = arr;
		} else {
			if(query_string.length){
		  		query_string[pair[0]].push(pair[1]);
			}else{
				query_string[pair[0]] = '';
			}
		}
	} 
	return query_string;		
}