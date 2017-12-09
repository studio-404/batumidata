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

if($("#message_count").length && $("#notification_count").length){
	var interval = setInterval(function(){
		$.post(AJAX_REQUEST_URL, { checknotification:true }, function(r){
			if(r!="Error" && /^[\],:{}\s]*$/.test(r.replace(/\\["\\\/bfnrtu]/g, '@').
	replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
	replace(/(?:^|:|,)(?:\s*\[)+/g, '')))
			{
				var obj = JSON.parse(r); 
				var notification_count = parseInt($("#notification_count").text());
				var message_count = parseInt($("#message_count").text());
				var cobject = obj.length;
				if(cobject>0){
					var type = ""; 
					var newN = 0;
					var newM = 0;
					var notification_html = '';
					var message_html = '';
					/*
					
					*/
					var l = $("#system-language").text();
					var x = 0;
					for (var i = obj.length - 1; i >= 0; i--) {
						type = obj[i].type;
						//console.log(type);
						if(type=="notification"){
							var go = '';
							if(obj[i].url!="" && typeof(obj[i].url)!="undefined" && obj[i].url!=null){
								var sp = obj[i].url.split("::"); 
								if(l=="EN"){
									go = sp[0];
								}else{
									go = sp[1];
								}
							}
							newN++; // 2
							notification_html += '<li>';
							notification_html += '<ul class="menu">';
							notification_html += '<li>';
							notification_html += '<a href="'+go+'">';
							notification_html += '<div class="pull-left">';
							if(obj[i].userspicture==""){
								notification_html += '<img src="/template/dist/img/avatar04.png" class="img-circle" alt="User Image" width="40" height="40" />';
							}else{
								notification_html += '<img src="/files/usersimage/'+obj[i].userspicture+'" class="img-circle" alt="User Image" width="40" height="40" />';	
							}						
							notification_html += '</div>';
							
							notification_html += "<h4>"+obj[i].usersnamelname+"</h4>";
							if(l=="EN"){
								notification_html += "<p>"+obj[i].description_ge+"</p>";
							}else{
								notification_html += "<p>"+obj[i].description_en+"</p>";
							}					
							notification_html += '</a>';
							notification_html += '</li>';
							notification_html += '</ul>';
							notification_html += '</li>';
						}else{
							var go = '';
							if(obj[i].url!="" && typeof(obj[i].url)!="undefined" && obj[i].url!=null){
								var sp = obj[i].url.split("::"); 
								if(l=="EN"){
									go = sp[0];
								}else{
									go = sp[1];
								}
							}
							if(x==0){
								message_html += '<li><ul class="menu">';
							}
							message_html += '<li>';
							message_html += '<a href="'+go+'">';
							message_html += '<div class="pull-left">';
							if(obj[i].userspicture==""){
								message_html += '<img src="/template/dist/img/avatar04.png" class="img-circle" alt="User Image" width="40" height="40" />';
							}else{
								message_html += '<img src="/files/usersimage/'+obj[i].userspicture+'" class="img-circle" alt="User Image" width="40" height="40" />';	
							}	
							//message_html += '<img src="" class="img-circle" alt="User Image">';
							
							message_html += '</div>';
							message_html += '<h4>';
							message_html += obj[i].usersnamelname;
							message_html += '</h4>';

							if(l=="EN"){
								message_html += "<p>"+obj[i].description_ge+"</p>";
							}else{
								message_html += "<p>"+obj[i].description_en+"</p>";
							}
							// message_html += ' <p>Why not buy a new awesome theme?</p>';

							message_html += '</a>';
							message_html += '</li>'; 
							if(x==0){
								message_html += '</ul></li>'; 
							}
							newM++; // 1
							x++;
						}
					};

					if(l=="EN"){
						notification_html += '<li class="footer"><a href="#">ნახე მეტი</a></li>'; 
						message_html += '<li class="footer"><a href="'+SYSTEM_WELCOME_PAGE+'/ge/mailbox/inbox">ნახე მეტი</a></li>'; 
					}else{
						notification_html += '<li class="footer"><a href="#">Read more</a></li>'; 
						message_html += '<li class="footer"><a href="'+SYSTEM_WELCOME_PAGE+'/en/mailbox/inbox">Read more</a></li>'; 
					}
					if(newN!=notification_count){
						$("#notification_count").text(newN); 
						var audio = new Audio('/files/audio/glass.mp3?v=1');
						audio.play();
						$(".notification_html").html(notification_html);
					}

					if(newM!=message_count){
						$("#message_count").text(newM); 
						var audio2 = new Audio('/files/audio/glass5.mp3?v=1');
						audio2.play();
						$(".message_html").html(message_html);
					}

				}
			}
		});
		
	}, 1000);
}

$(document).on("click",".messageseen",function(){
	var m = $("#message_count").text(); 
	if(m!="0"){
		$.post(AJAX_REQUEST_URL, { messageseen:true }, function(result){
			if(result=="Done"){
				$("#message_count").text("0");
			}
		});
	}
});

$(document).on("click","#notificationseen",function(){
	var m = $("#notification_count").text(); 
	if(m!="0"){
		$.post(AJAX_REQUEST_URL, { notification_count:true }, function(result){
			if(result=="Done"){
				$("#notification_count").text("0");
			}
		});
	}
});

/*
typeof(valuex) == "undefined" || valuex==null
*/
$(document).on("change",".select-catalog",function(){
	var valuex = $(this).val();
	var loader = '<i class="glyphicon glyphicon-refresh fa-spin" style="font-size:22px;"></i>';
	$(".insert-form").html(loader).fadeIn(); 
	if(valuex==""){
		$(".insert-form").html('<p>ფორმა ვერ მოიძებნა !</p>');
	}else{
		$.post(AJAX_REQUEST_URL, { loadcatalogform:true, v:valuex }, function(result){
			$(".insert-form").html(result);
		});
	}
});

$(document).on("click",".filter-data",function(){
	var param = urlParamiters();
	var type = new Array();
	var val = new Array();
	var attach = new Array();
	var att = '';
	var pricefrom = $("#pricefrom").val();
	var priceto = $("#priceto").val();

	var priceseasonfrom = $("#priceseasonfrom").val();
	var priceseasonto = $("#priceseasonto").val();


	$(".form-input-seach").each(function(){
		if($(this).attr("data-type")=="text" || $(this).attr("data-type")=="select"){
			att = $(this).attr("data-attach").split(" ");
			type.push($(this).attr("data-type"));
			attach.push(att[0]);
			val.push($(this).val());
		}else if($(this).attr("data-type")=="date"){
			att = $(this).attr("data-attach").split(" ");
			type.push($(this).attr("data-type"));
			attach.push(att[0]);
			var valuex = replaceAll($(this).val(), "/", "-");
			val.push(valuex);
		}else if($(this).attr("data-type")=="checkbox"){
			if($(this).is(':checked')){
				att = $(this).attr("data-attach").split(" ");
				type.push($(this).attr("data-type"));
				attach.push(att[0]);
				val.push($(this).val());
			}
		}
	});
	var url = "?idx="+param["idx"]+"&pricefrom="+pricefrom+"&priceto="+priceto+"&priceseasonfrom="+priceseasonfrom+"&priceseasonto="+priceseasonto+"&filter=true";
	for (var i = 0; i < type.length; i++) {
		if(type[i]=="text" || type[i]=="date" || type[i]=="select"){
			url += "&"+attach[i]+"=" + encodeURIComponent(val[i]);
		}else{
			url += "&"+attach[i]+"[]=" + encodeURIComponent(val[i]);
		}
	}
	console.log(url);
	location.href = url;	
});

function replaceAll(str, find, replace) {
  return str.replace(new RegExp(find, 'g'), replace);
}

$(document).on("click","#add-catalogue-nouser",function(){
	var mcat = $("#mcat").val();
	var mainpagecategory = new Array(); 
	mainpagecategory.push(mcat);
	var valueArray = new Array();
	var nameArray = new Array();
	var importantArray = new Array();
	var dbcolumn = new Array();
	var columnArray = new Array();
	var checkedArray = new Array();
	var typeArray = new Array();
	$(".catalog-add-form-data .form-input").each(function(){
		$(".insert-form").html('<p>მოთხოვნა მუშავდება ...</p>');
		var type = $(this).attr("data-type"); 
		if(type=="text"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="select"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="checkbox"){
			valueArray.push($(this).val());
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			if($(this).is(':checked')){
				checkedArray.push("yes");	
			}else{
				checkedArray.push("no");	
			}			
		}else if(type=="date"){
			valueArray.push($(this).val());
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="textarea"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}
	});
	
	$.post(AJAX_REQUEST_URL, { 
		addCatalogItem:true, 
		ta:JSON.stringify(typeArray), 
		va:JSON.stringify(valueArray), 
		na:JSON.stringify(nameArray), 
		ca:JSON.stringify(columnArray), 
		ca2:JSON.stringify(checkedArray), 
		ia:JSON.stringify(importantArray), 
		macat:JSON.stringify(mainpagecategory) 
	}, function(result){
		$(".overlay-loader").fadeOut("slow");
		if(result!=""){
			console.log(result);
			$(".insert-form").html('<p>მონაცემი წარმატებით დაემატა !</p>');
			window.scrollTo(0,0);			
		}else{
			alert("Error: 3001");
		}
	});
});

$(document).on("click","#add-blocked-ip",function(){
	var ip = $("#ip").val(); 
	var dlang = $(this).data("dlang");
	if(typeof(ip)=="undefined" || ip==null || ip==""){
		$(".ip-required").fadeIn("slow");
		return false;
	}else{
		$(".overlay-loader").fadeIn("slow");
		$.post(AJAX_REQUEST_URL, { addblockedip:true, i:ip }, function(result){
			$(".overlay-loader").fadeOut("slow");
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
		});
	}
});

//
$(document).on("click","#add-blocked-ip-close",function(){
	var ip = $("#ip").val(); 
	var dlang = $(this).data("dlang");
	if(typeof(ip)=="undefined" || ip==null || ip==""){
		$(".ip-required").fadeIn("slow");
		return false;
	}else{
		$(".overlay-loader").fadeIn("slow");
		$.post(AJAX_REQUEST_URL, { addblockedip:true, i:ip }, function(result){
			$(".overlay-loader").fadeOut("slow");
			if(result=="Done"){
				location.href = PROTOCOL+document.domain+"/"+dlang+"/dablokili-momxmareblebi";			
			}else{
				if(dlang=="ge"){
					$(".form-message-output").text(MESSAGE_OPERATION_ERROR_GE).fadeIn("slow");
				}else{
					$(".form-message-output").text(MESSAGE_OPERATION_ERROR_EN).fadeIn("slow");
				}
			}
		});
	}
});

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
			console.log(result);
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

$(document).on("click","#add-catalogue-item",function(){
	var dbcolumn = '';
	var typeArray = new Array();
	var valueArray = new Array();
	var nameArray = new Array();
	var columnArray = new Array();
	var checkedArray = new Array();
	var importantArray = new Array();
	var mainpagecategory = $("#mainpagecategory").val();
	var param = urlParamiters(); 
	var parent = param['parent'];

	$(".catalog-add-form-data .form-input").each(function(){
		$(".overlay-loader").fadeIn("slow");
		var type = $(this).attr("data-type");

		if(type=="text"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="select"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="checkbox"){
			valueArray.push($(this).val());
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			if($(this).is(':checked')){
				checkedArray.push("yes");	
			}else{
				checkedArray.push("no");	
			}			
		}else if(type=="file"){
			
		}else if(type=="date"){
			valueArray.push($(this).val());
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="dateandtimerange"){
			var dtrangeValue = String($("#"+$(this).attr("data-hiddenname")).val());
			valueArray.push(dtrangeValue);
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="textarea"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}

		
	});
	
	$.post(AJAX_REQUEST_URL, { 
		addCatalogItem:true, 
		ta:JSON.stringify(typeArray), 
		va:JSON.stringify(valueArray), 
		na:JSON.stringify(nameArray), 
		ca:JSON.stringify(columnArray), 
		ca2:JSON.stringify(checkedArray), 
		ia:JSON.stringify(importantArray), 
		macat:JSON.stringify(mainpagecategory), 
		p:parent 
	}, function(result){
		$(".overlay-loader").fadeOut("slow");
		if(result!=""){
			$("#monacemisdamatebaform").append('<input type="hidden" name="gallery_idx_post" value="'+result+'" />');
			var file_length = $(".catalog-add-form-data input[type='file']").length;
			if(file_length > 0){
				$("#monacemisdamatebaform").submit();
			}
			
			var l = $("#system-language").text();
			if(l=="EN"){
				$(".form-message-output").html("<p>"+MESSAGE_OPERATION_DONE_GE+"</p>").fadeIn("slow");
			}else{
				$(".form-message-output").html("<p>"+MESSAGE_OPERATION_DONE_EN+"</p>").fadeIn("slow");
			}
			$("input[type='text']").val("");
			$("textarea").val("");
			$("input[type='checkbox']").removeAttr('checked');
			$("select").val(0);
			window.scrollTo(0,0);
			
		}else{
			alert("Error: 3001");
		}
	});
});



$(document).on("click","#add-catalogue-item-close",function(){
	var dbcolumn = '';
	var typeArray = new Array();
	var valueArray = new Array();
	var nameArray = new Array();
	var columnArray = new Array();
	var checkedArray = new Array();
	var importantArray = new Array();
	var mainpagecategory = $("#mainpagecategory").val();
	var param = urlParamiters(); 
	var parent = param['parent'];

	$(".catalog-add-form-data .form-input").each(function(){
		$(".overlay-loader").fadeIn("slow");
		var type = $(this).attr("data-type"); 
		if(type=="text"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="select"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="checkbox"){
			valueArray.push($(this).val());
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			if($(this).is(':checked')){
				checkedArray.push("yes");	
			}else{
				checkedArray.push("no");	
			}			
		}else if(type=="file"){
			
		}else if(type=="date"){
			valueArray.push($(this).val());
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="dateandtimerange"){
			var dtrangeValue = String($("#"+$(this).attr("data-hiddenname")).val());
			valueArray.push(dtrangeValue);
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="textarea"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}
	});
	
	$.post(AJAX_REQUEST_URL, { 
		addCatalogItem:true, 
		ta:JSON.stringify(typeArray), 
		va:JSON.stringify(valueArray), 
		na:JSON.stringify(nameArray), 
		ca:JSON.stringify(columnArray), 
		ca2:JSON.stringify(checkedArray), 
		ia:JSON.stringify(importantArray), 
		macat:JSON.stringify(mainpagecategory), 
		p:parent 
	}, function(result){
		$(".overlay-loader").fadeOut("slow");
		if(result!=""){
			$("#monacemisdamatebaform").append('<input type="hidden" name="gallery_idx_post" value="'+result+'" />');
			$("#monacemisdamatebaform").append('<input type="hidden" name="close_after_add" value="1" />');
			var file_length = $(".catalog-add-form-data input[type='file']").length;
			if(file_length > 0){
				$("#monacemisdamatebaform").submit();
			}else{
				var LANG = ($("#system-language").text()=="EN") ? "ge" : "en";
				location.href = SYSTEM_WELCOME_PAGE+"/"+LANG+"/welcomesystem";
			}
			
			var l = $("#system-language").text();
			if(l=="EN"){
				$(".form-message-output").html("<p>"+MESSAGE_OPERATION_DONE_GE+"</p>").fadeIn("slow");
			}else{
				$(".form-message-output").html("<p>"+MESSAGE_OPERATION_DONE_EN+"</p>").fadeIn("slow");
			}
			$("input[type='text']").val("");
			$("textarea").val("");
			$("input[type='checkbox']").removeAttr('checked');
			$("select").val(0);
			window.scrollTo(0,0);
			
		}else{
			alert("Error: 3001");
		}
	});
});

/* EDIT start */
$(document).on("click","#edit-catalogue-item",function(){
	var dbcolumn = '';
	var typeArray = new Array();
	var valueArray = new Array();
	var nameArray = new Array();
	var columnArray = new Array();
	var checkedArray = new Array();
	var importantArray = new Array();
	var mainpagecategory = $("#mainpagecategory").val();
	var param = urlParamiters(); 
	var parent = param["parent"]; 

	$(".catalog-add-form-data .form-input").each(function(){
		$(".overlay-loader").fadeIn("slow");
		var type = $(this).attr("data-type"); 
		if(type=="text"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="select"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="checkbox"){
			valueArray.push($(this).val());
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			if($(this).is(':checked')){
				checkedArray.push("yes");	
			}else{
				checkedArray.push("no");	
			}			
		}else if(type=="file"){
			
		}else if(type=="date"){
			valueArray.push($(this).val());
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="dateandtimerange"){
			var dtrangeValue = String($("#"+$(this).attr("data-hiddenname")).val());
			valueArray.push(dtrangeValue);
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="textarea"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}
	});
	var param = urlParamiters();
	var l = $("#system-language").text();
	var dlang = (l=="EN") ? "1" : "2";
	var dlang2 = (l=="EN") ? "ge" : "en";
	$.post(AJAX_REQUEST_URL, { 
		editCatalogItem:true, 
		editidx:param["idx"],
		edit_language:dlang,
		ta:JSON.stringify(typeArray), 
		va:JSON.stringify(valueArray), 
		na:JSON.stringify(nameArray), 
		ca:JSON.stringify(columnArray), 
		ca2:JSON.stringify(checkedArray), 
		ia:JSON.stringify(importantArray), 
		macat:JSON.stringify(mainpagecategory), 
		p:parent 
	}, function(result){
		$(".overlay-loader").fadeOut("slow");
		if(result=="Done"){
			$("#monacemisdamatebaform").append('<input type="hidden" name="gallery_idx_post" value="'+param["idx"]+'" />');
			var file_length = $(".catalog-add-form-data input[type='file']").length;
			if(file_length > 0){
				$("#monacemisdamatebaform").submit();
			}else{
				if(l=="EN"){
					$(".form-message-output").html("<p>"+MESSAGE_OPERATION_DONE_GE+"</p>").fadeIn("slow");
				}else{
					$(".form-message-output").html("<p>"+MESSAGE_OPERATION_DONE_EN+"</p>").fadeIn("slow");
				}
				
				var gotourl = SYSTEM_WELCOME_PAGE+"/"+dlang2+"/monacemis-redaqtireba?parent="+mainpagecategory+"&idx="+param["idx"]+"&back="+param["back"];
				location.href = gotourl; 
			}			
			
		}else{
			alert("Error: 3001");
		}
	});
});
/* EDIT end */


$(document).on("click","#edit-catalogue-item-close",function(){
	var gotourl = $(this).attr("data-back");
	var dbcolumn = '';
	var typeArray = new Array();
	var valueArray = new Array();
	var nameArray = new Array();
	var columnArray = new Array();
	var checkedArray = new Array();
	var importantArray = new Array();
	var mainpagecategory = $("#mainpagecategory").val();
	var param = urlParamiters(); 
	var parent = param["parent"]; 

	$(".catalog-add-form-data .form-input").each(function(){
		$(".overlay-loader").fadeIn("slow");
		var type = $(this).attr("data-type"); 
		if(type=="text"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="select"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="checkbox"){
			valueArray.push($(this).val());
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			if($(this).is(':checked')){
				checkedArray.push("yes");	
			}else{
				checkedArray.push("no");	
			}			
		}else if(type=="file"){
			
		}else if(type=="date"){
			valueArray.push($(this).val());
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="dateandtimerange"){
			var dtrangeValue = String($("#"+$(this).attr("data-hiddenname")).val());
			valueArray.push(dtrangeValue);
			nameArray.push($(this).attr("data-name"));
			typeArray.push($(this).attr("data-type"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}else if(type=="textarea"){
			valueArray.push($(this).val());
			typeArray.push($(this).attr("data-type"));
			nameArray.push($(this).attr("data-name"));
			importantArray.push($(this).attr("data-important"));
			dbcolumn = $(this).attr("data-attach").split(" ");
			columnArray.push(dbcolumn[0]);
			checkedArray.push("no");
		}
	});
	var param = urlParamiters();
	var l = $("#system-language").text();
	var dlang = (l=="EN") ? "1" : "2";
	var dlang2 = (l=="EN") ? "ge" : "en";
	$.post(AJAX_REQUEST_URL, { 
		editCatalogItem:true, 
		editidx:param["idx"],
		edit_language:dlang,
		ta:JSON.stringify(typeArray), 
		va:JSON.stringify(valueArray), 
		na:JSON.stringify(nameArray), 
		ca:JSON.stringify(columnArray), 
		ca2:JSON.stringify(checkedArray), 
		ia:JSON.stringify(importantArray), 
		macat:JSON.stringify(mainpagecategory), 
		p:parent 
	}, function(result){
		$(".overlay-loader").fadeOut("slow");
		if(result=="Done"){
			$("#monacemisdamatebaform").append('<input type="hidden" name="gallery_idx_post" value="'+param["idx"]+'" />');
			var file_length = $(".catalog-add-form-data input[type='file']").length;
			if(file_length > 0){
				$("#monacemisdamatebaform").submit();
			}else{
				location.href = gotourl; 
			}			
			
		}else{
			alert("Error: 3001");
		}
	});
});


$(document).on("click",".makemedouble",function(){
	var doubleid = $(this).attr("data-doubleid"); 
	var filename = $(this).attr("data-filename"); 
	var fileaccept = $(this).attr("data-fileaccept"); 
	var file = '<input class="form-control form-input" type="file" name="'+filename+'" value="" accept="'+fileaccept+'" />';
	$("#"+doubleid).append(file);
});


function upload(file,typesx){
	var fileName = file.name;
	var ex = fileName.split(".");
	var extLast = ex[ex.length - 1].toLowerCase();

	xhr = new XMLHttpRequest();
	// initiate request
	var par = urlParamiters();
	xhr.open('post','/en/ajaxupload?token='+par['token'],true);
	//set header

	var rforeign = /[^\u0000-\u007f]/;
	if (rforeign.test(file.name)) {
	  alert("File name error !");
	  return false;
	}
	
	xhr.setRequestHeader('Content-Type','multipart/form-data');
	xhr.setRequestHeader('X-File-Name',file.name);
	xhr.setRequestHeader('X-File-Size',file.size);
	xhr.setRequestHeader('X-File-Type',file.type);
	if(extLast!="jpeg" && extLast!="jpg" && extLast!="png" && extLast!="gif"){
		alert("Please drop jpeg, jpg, gif or png file !");
		$('#img').html('<p>No Image</p>');
		return false;
	}

	//send file
	xhr.send(file);

	xhr.upload.addEventListener("progress",function(e){
		var progress = (e.loaded / e.total) * 100;
		$('#progress-bar').css({'width': progress+"%"});
	},true);

	xhr.onreadystatechange = function(e){
		if(xhr.readyState == 4){
			if(xhr.status == 200){
				var res = xhr.responseText;
				if(res!=2){  
					$('#img').html('<img src="/'+res+'" width="100%" /><div class="close" onclick="removePreFile()"><i class="fa fa-times"></i></div>'); 
					var files_pre = res.split("/files/");
					$("#background").val('/files_pre/'+files_pre);
				}
			}
		}
	}

}

$(document).on("change","#catalog-image", function(e){
	 e.preventDefault();
     var fileInput = document.getElementById('catalog-image');
     var file = fileInput.files[0];     
     $(".user-image").attr("src", URL.createObjectURL(e.target.files[0])); 
     console.log(URL.createObjectURL(e.target.files[0]));
});

$(document).on("click","#add-catalogue",function(e){
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
			}
			$("#catalog-form").submit();
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

$(document).on("click",".loadimagesrc",function(){
	var imagesrc = $(this).attr("data-imagesrc");
	modalOpen("#bs-example-xx","image",imagesrc);
});

$(document).on("click",".delete-document",function(){
	var imgIdx = $(this).attr("data-imageidx");
	modalOpen("#bs-example-xx","delete",imgIdx);
});

$(document).on("click",".deleteDocumentx",function(){
	var docidx = $(this).attr("data-docidx");
	$("#bs-example-xx").modal("hide");
	$(".overlay-loader").fadeIn("slow");
	$.post(AJAX_REQUEST_URL, { deleteGalleryItem:true, i:docidx }, function(r){
		if(r=="Done"){
			$(".overlay-loader").fadeOut("slow");
			location.reload();
		}else{
			alert("Error: 4005");
		}
	});
});

function modalOpen(ele,type,data){
	if(type=="image"){
		$(".modal-header").hide();
		$(".modal-footer").hide();
		$(".modal-dialog").removeClass("modal-sm");
		$(".insertimage_popup").html("<img src=\""+data+"\" alt=\"\" style=\"width:100%\" />"); 
	}else if(type=="delete"){
		$(".modal-header").show();
		$(".modal-footer").show();
		$(".modal-dialog").addClass("modal-sm");
		$(".deleteDocumentx").attr("data-docidx",data);
		var dlang = $("#system-language").text();
		if(dlang=="EN"){
			$(".insertimage_popup").html("გნებავთ წაშალოთ ფაილი ?");
		}else{
			$(".insertimage_popup").html("Would you like to delete do ?");
		}		
	}
	$(ele).modal("show");
}



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
	var removeformelement = $(this).data("removeformelement");
	var removemessage= $(this).data("removemessage");
	var msgid= $(this).data("msgid");
	var retrn = $(this).data("retrn"); 
	if(typeof(removecatalogue) != "undefined" && removecatalogue!="" && removecatalogue!=null){
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
	}else if(typeof(removeuser) != "undefined" && removeuser!="" && removeuser!=null){
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
	}else if(typeof(removemessage) != "undefined" && removemessage!="" && removemessage!=null){
		var dlang = $(this).data("dlang");		
		$(".bs-example-modal-sm").modal("toggle");
		$(".overlay-loader").fadeIn("slow");

		$.post(AJAX_REQUEST_URL, { removemessage:true, rmi:removemessage }, function(result){ 
			$(".overlay-loader").fadeOut("slow");
			if(result=="Done"){
				location.href = PROTOCOL+document.domain+"/"+dlang+"/mailbox/inbox";
			}else{
				if(dlang=="ge"){
					$(".modal-body").html("<p>მონაცემის წაშლა ვერ მოხერხდა !</p>");
				}else{
					$(".modal-body").html("<p>Could not delete data !</p>");
				}
				$(".modal-footer").hide();
				$(".bs-example-modal-sm").modal("toggle");
			}
		});
	}else if(typeof(msgid) != "undefined" && msgid!="" && msgid!=null){
		var dlang = $(this).data("dlang");		
		$(".bs-example-modal-sm").modal("toggle");
		$(".overlay-loader").fadeIn("slow");

		$.post(AJAX_REQUEST_URL, { removemessage:true, rmi:msgid }, function(result){ 
			$(".overlay-loader").fadeOut("slow");
			if(result=="Done"){
				if(typeof(retrn)!="undefined" && retrn!="" && retrn!=null){
					location.href = PROTOCOL+document.domain+"/"+dlang+"/mailbox/sent";
				}else{
					location.href = PROTOCOL+document.domain+"/"+dlang+"/mailbox/inbox";
				}
			}else{
				if(dlang=="ge"){
					$(".modal-body").html("<p>მონაცემის წაშლა ვერ მოხერხდა !</p>");
				}else{
					$(".modal-body").html("<p>Could not delete data !</p>");
				}
				$(".modal-footer").hide();
				$(".bs-example-modal-sm").modal("toggle");
			}
		});
	}
});

$(document).on("change","#showitems",function(){
	var val = $(this).val();
	var param = urlParamiters();
	if(!param["pn"]){ param["pn"] = 1; }
	if(!param["parentidx"]){ var parentidx = ""; }else{ var parentidx = "parentidx="+param["parentidx"]+"&"; }
	var urltogo = "?"+parentidx+"idx="+param["idx"]+"&pn=1&sw="+val;
	location.href = urltogo;
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


/* Save Form Function START */
$(document).on("click","#save-form",function(){
	$(".overlay-loader").fadeIn("slow");
	var update_language = $("#update_language").val();
	var type = new Array();
	var dlang = new Array();
	var label = new Array();
	var name = new Array();
	var database = new Array();
	var important = new Array();	
	var fileformat = new Array();
	var multiple = new Array();	
	var list = new Array();
	var filter = new Array();
	var dataOption = new Array();
	var dataCheckbox = new Array();
	var val = new Array();
	var params = urlParamiters();
	var subcategoryadd = $("#subcategoryadd").val(); 

	$(".interface .element-box").each(function(index, value){
		type.push($(this).attr("data-elemtype").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		dlang.push($(this).attr("data-dlang").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		label.push($(this).attr("data-elemlabel").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		name.push($(this).attr("data-elemname").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		database.push($(this).attr("data-database").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		important.push($(this).attr("data-important").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		list.push($(this).attr("data-list").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		filter.push($(this).attr("data-filter").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		var selectOptions = new Array();
		var selectCheckbox = new Array();
		if($(this).attr("data-elemvalue")){
			val.push($(this).attr("data-elemvalue").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		}else{
			val.push($(this).attr("data-elemvalue"));
		}

		if($(this).attr("data-elemtype")=="file"){
			fileformat.push($(this).attr("data-fileformatx").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
			multiple.push($(this).attr("data-maltiupload").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));	
		}else{
			fileformat.push($(this).attr("data-fileformatx"));
			multiple.push($(this).attr("data-maltiupload"));
		}

		//console.log(type+" ");
		if($(this).attr("data-elemtype")=="select"){			
			$("select option",this).each(function(subindex, subvalue){
				var v = subvalue.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
				selectOptions.push(v);
			});
		}else if($(this).attr("data-elemtype")=="checkbox"){			
			$(".checkbox input[type='checkbox']",this).each(function(subindex, subvalue){
				var v = subvalue.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
				selectCheckbox.push(v);
			});
		}
		dataOption.push(selectOptions); 
		dataCheckbox.push(selectCheckbox); 
	});
	
	$.post(AJAX_REQUEST_URL, { 
		createform:true, 
		update_lang:update_language, 
		subcat:subcategoryadd,  
		catId:params["parent"], 
		t:JSON.stringify(type),  
		lang:JSON.stringify(dlang),  
		l:JSON.stringify(label),  
		n:JSON.stringify(name),  
		d:JSON.stringify(database),  
		i:JSON.stringify(important),  
		li:JSON.stringify(list),  
		f:JSON.stringify(filter),  
		v:JSON.stringify(val),  
		dop:JSON.stringify(dataOption),  
		dch:JSON.stringify(dataCheckbox),  
		ff:JSON.stringify(fileformat),  
		mp:JSON.stringify(multiple) 
	}, function(result){
		console.log(result);
		if(result=="Done"){
			location.reload();
		}
	});

});

$(document).on("click","#save-form-close",function(){
	var ddll = $(this).data("dlang");
	$(".overlay-loader").fadeIn("slow");
	var update_language = $("#update_language").val();
	var type = new Array();
	var dlang = new Array();
	var label = new Array();
	var name = new Array();
	var database = new Array();
	var important = new Array();
	var fileformat = new Array();
	var multiple = new Array();
	var list = new Array();
	var filter = new Array();
	var dataOption = new Array();
	var dataCheckbox = new Array();
	var val = new Array();
	var params = urlParamiters();
	var subcategoryadd = $("#subcategoryadd").val(); 
	$(".interface .element-box").each(function(index, value){
		type.push($(this).attr("data-elemtype").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		dlang.push($(this).attr("data-dlang").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		label.push($(this).attr("data-elemlabel").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		name.push($(this).attr("data-elemname").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		database.push($(this).attr("data-database").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		important.push($(this).attr("data-important").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		list.push($(this).attr("data-list").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		filter.push($(this).attr("data-filter").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		var selectOptions = new Array();
		var selectCheckbox = new Array();
		if($(this).attr("data-elemvalue")){
			val.push($(this).attr("data-elemvalue").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
		}else{
			val.push($(this).attr("data-elemvalue"));
		}

		if($(this).attr("data-elemtype")=="file"){
			fileformat.push($(this).attr("data-fileformatx").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
			multiple.push($(this).attr("data-maltiupload").replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));	
		}else{
			fileformat.push($(this).attr("data-fileformatx"));
			multiple.push($(this).attr("data-maltiupload"));
		}
		
		//console.log(type+" ");
		if($(this).attr("data-elemtype")=="select"){			
			$("select option",this).each(function(subindex, subvalue){
				var v = subvalue.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
				selectOptions.push(v);
			});
		}else if($(this).attr("data-elemtype")=="checkbox"){			
			$(".checkbox input[type='checkbox']",this).each(function(subindex, subvalue){
				var v = subvalue.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
				selectCheckbox.push(v);
			});
		}
		dataOption.push(selectOptions); 
		dataCheckbox.push(selectCheckbox); 
	});
	
	$.post(AJAX_REQUEST_URL, { 
		createform:true, 
		update_lang:update_language, 
		subcat:subcategoryadd, 
		catId:params["parent"], 
		t:JSON.stringify(type),  
		lang:JSON.stringify(dlang),  
		l:JSON.stringify(label),  
		n:JSON.stringify(name),  
		d:JSON.stringify(database),  
		i:JSON.stringify(important),  
		li:JSON.stringify(list),  
		f:JSON.stringify(filter),  
		v:JSON.stringify(val),  
		dop:JSON.stringify(dataOption),  
		dch:JSON.stringify(dataCheckbox), 
		ff:JSON.stringify(fileformat),  
		mp:JSON.stringify(multiple)  
	}, function(result){
		console.log(result);
		if(result=="Done"){
			if(ddll==1){ var dl = "ge"; }
			else{ var dl = "en"; }
			location.href = SYSTEM_WELCOME_PAGE + "/" + dl + "/katalogis-marTva";
		}
	});

});
/* Save Form Function END */


$(document).on("click",".add-database-column",function(){
	//database-option-list
	var dbList = '';
	$(".database-column-list li a").each(function(index, value){
		dbList += '<option value="'+$(this).attr("data-databasecolumnname")+'">'+$(this).text()+'</option>';
	});
	$("#database-option-list").html(dbList); 
	$('#bs-example-modal-sm4').modal("show");
});

$(document).on("click",".add-database-button",function(){
	var after = $("#database-option-list").val();
	var columntype = $("#column-type").val(); 
	var columnname = $("#column-name").val();

	$('#bs-example-modal-sm4').modal("hide");
	$(".overlay-loader").fadeIn("slow");
	$.post(AJAX_REQUEST_URL, { adddatabasecolumn:true, a:after, ct:columntype, cn:columnname },function(result){
		if(result=="Done"){
			location.reload();
		}else{
			alert("Error");
			location.reload();
		}
	});
});

$(document).on("click",".chnage-delete-column",function(){
	var databasecolumnname = $(this).attr("data-databasecolumnname");
	var databasecolumntype = $(this).attr("data-databasecolumntype");
	$("#edit-column-name").val(databasecolumnname);
	$("#edit-column-name").attr("data-editcolumnnameold",databasecolumnname);
	if(databasecolumntype=="int(11)"){
		$("#edit-column-type").val(1);	
		$("#edit-column-name").attr("data-editcolumndatatype","INT");
	}else if(databasecolumntype=="varchar(255)"){
		$("#edit-column-type").val(2);	
		$("#edit-column-name").attr("data-editcolumndatatype","VARCHAR");
	}else if(databasecolumntype=="text"){
		$("#edit-column-type").val(3);	
		$("#edit-column-name").attr("data-editcolumndatatype","TEXT");
	}else if(databasecolumntype=="longtext"){
		$("#edit-column-type").val(4);	
		$("#edit-column-name").attr("data-editcolumndatatype","LONGTEXT");
	}	
});

$(document).on("click",".edit-database-button",function(){
	var editcolumnnameold = $("#edit-column-name").attr("data-editcolumnnameold");
	var editcolumndatatype = $("#edit-column-name").attr("data-editcolumndatatype");
	var editcolumnname = $("#edit-column-name").val();
	var editaction = $("#edit-action").val();
	$('.bs-example-modal-sm5').modal("hide");
	$(".overlay-loader").fadeIn("slow");
	$.post(AJAX_REQUEST_URL, {
		updatedatabasecolumn:true, 
		ecno:editcolumnnameold, 
		ecn:editcolumnname, 
		datatype:editcolumndatatype, 
		ect:editaction 
	},function(result){
		console.log(result);
		if(result=="Done"){
			location.reload();
		}else{
			alert("Error");
			location.reload();
		}
	});
});

$(document).on("click",".give-permision",function(){
	var param = urlParamiters();
	var dlang = $(this).attr("data-dlang");
	if(param["idx"]!=null && typeof(param["idx"]) !="undefined"){
		idx_send = param["idx"];
	}else{
		idx_send = param["view"];
	}
	$.post(AJAX_REQUEST_URL, { givepermision:true, p:param["view"], i:idx_send }, function(result){
		if(result=="Done"){
			location.href = SYSTEM_WELCOME_PAGE + "/"+dlang+"/nebarTvis-micema";
		}
	});
});

$(document).on("click",".give-permision-table",function(){
	var dlang = $(this).attr("data-dlang");
	var view = $(this).attr("data-view");
	$.post(AJAX_REQUEST_URL, { givepermision:true, p:view }, function(result){
		if(result=="Done"){
			location.href = SYSTEM_WELCOME_PAGE + "/"+dlang+"/nebarTvis-micema";
		}
	});
});

$(document).on("click",".remove-permision",function(){
	var param = urlParamiters();
	var dlang = $(this).attr("data-dlang");
	$.post(AJAX_REQUEST_URL, { removepermision:true, p:param["view"] }, function(result){
		if(result=="Done"){
			location.href = SYSTEM_WELCOME_PAGE + "/"+dlang+"/nebarTvis-micema";
		}
	});
});

$(document).on("click",".deleteUnpublishData",function(){
	var id = $(this).attr("data-id");
	$("#bs-example-xx").modal("show");
	$(".deleteUnsuportedItem").attr("data-id",id);
});

//
$(document).on("click",".deleteUnsuportedItem",function(){
	var id = $(this).attr("data-id");
	$(".overlay-loader").fadeIn("slow");
	$("#bs-example-xx").fadeOut("slow");
	$.post(AJAX_REQUEST_URL, { removeUnpublished:true, i:id },function(r){
		if(r=="Done"){
			location.reload();
		}else{
			alert("Error ");
		}
	});
});


/* Functions START */
$(document).on("click",".reloadMe",function(){
	location.reload();
});


$(document).on("click",".gotoUrl",function(){
	var g = $(this).data("goto");
	location.href = g;
});

$(document).on("click",".sendmessage", function(){
	var LANG = $(this).attr("data-dlang");
	var selectusers = $("#selectusers").val();
	var subject = $("#subject").val();
	var draft = $(this).attr("data-draft");
	var message = tinyMCE.activeEditor.getContent();

	var attach = ($("#attach").val()=="false") ? "zero" : "true";
	$(".overlay-loader").fadeIn("slow");	
	if(selectusers=="" || typeof(selectusers)=="undefined" || selectusers==null){
		if(LANG=="ge"){
			$(".messagebodytext").html("<p>გთხოვთ აირჩიოთ მომხმარებელი !</p>");
		}else{
			$(".messagebodytext").html("<p>Please choose user !</p>");
		}
		$(".overlay-loader").fadeOut("slow");
		$("#bs-example-xx").modal("show");
	}else if(subject=="" || typeof(subject)=="undefined" || subject==null){
		if(LANG=="ge"){
			$(".messagebodytext").html("<p>სათაურის ველი სავალდებულოა !</p>");
		}else{
			$(".messagebodytext").html("<p>Subject field is required !</p>");
		}
		$(".overlay-loader").fadeOut("slow");
		$("#bs-example-xx").modal("show");
	}else if(message=="" || typeof(message)=="undefined" || message==null){
		if(LANG=="ge"){
			$(".messagebodytext").html("<p>შეტყობინების ველი სავალდებულოა !</p>");
		}else{
			$(".messagebodytext").html("<p>Message field is required !</p>");
		}
		$(".overlay-loader").fadeOut("slow");
		$("#bs-example-xx").modal("show");
	}else{
		$.post(AJAX_REQUEST_URL, { sendmessage:true, u:JSON.stringify(selectusers), s:subject, m:message, a:attach, d:draft }, function(result){
			if(result=="Error" || result==""){
				if(LANG=="ge"){
					$(".messagebodytext").html("<p>გაგზავნისას მოხდა შეცდომა !</p>");
				}else{
					$(".messagebodytext").html("<p>Error !</p>");
				}
			}else{
				if(attach=="zero"){
					if(draft!="yes"){
						if(LANG=="ge"){
							$(".messagebodytext").html("<p>შეტყობინება წარმატებით გაიგზავნა !</p>");
						}else{
							$(".messagebodytext").html("<p>Message sent !</p>");
						}
						var goafterdone = PROTOCOL+document.domain+"/"+LANG+"/mailbox/sent";
					}else{
						if(LANG=="ge"){
							$(".messagebodytext").html("<p>შეტყობინება წარმატებით შეინახა მონახაზში !</p>");
						}else{
							$(".messagebodytext").html("<p>Message saved in draft !</p>");
						}
						var goafterdone = PROTOCOL+document.domain+"/"+LANG+"/mailbox/draft";
					}

					$('#bs-example-xx').on('hidden.bs.modal', function () {
					 	location.href = goafterdone; 
					});

					$(".overlay-loader").fadeOut("slow");
					$("#bs-example-xx").modal("show");
				}else{
					$("#insert_id").val(result);
					if(draft=="yes"){
						$("#ifdruft").val("true");
					}
					$("#fileupload").submit();
				}
			}
		});
	}
});

$(document).on("click",".remove-message",function(){
	var l = $(this).attr("data-dlang");
	var i = $(this).attr("data-msgid");
	var r = $(this).attr("data-retrn");
	//var id = $(this).attr("data-id");
	
	$(".dojobbutton").attr("data-msgid",i);
	$(".dojobbutton").attr("data-dlang",l);	
	$(".dojobbutton").attr("data-retrn",r);	
	if(l=="ge"){
		$(".this-ismessage").html("<p>გნებავთ წაშალოთ მონაცემი ?</p>");
		$(".dojobbutton").text("წაშლა");
	}else{
		$(".this-ismessage").html("<p>Would you like delete item ?</p>");
		$(".dojobbutton").text("Delete");
	}
	$(".bs-example-modal-sm").modal("show");
});

$(document).on("change", "#attachment", function(){
	var files = $(this).get(0).files;
	var LANG = ($("#system-language").text=="EN") ? 'ge' : 'en';
	var xsize = 0;
	for (i = 0; i < files.length; i++)
	{
		xsize += files[i].size;
	}
	console.log(xsize); 

	if(xsize > 64000000){
		if(LANG=="ge"){
			$(".messagebodytext").html("<p>ფაილის / ფაილების ზომა აღემატება დასაშვებს !</p>");
		}else{
			$(".messagebodytext").html("<p>File / Files size is too big  !</p>");
		}
		$("#bs-example-xx").modal("show");
	}else{
		$("#attach").val("true");	
	}
});

$(document).on("click",".deleteMailboxMessage",function(){ 
	var id = $(this).attr("data-msgid");
	var LANG = $(this).attr("data-dlang");
	if(LANG=="ge"){
		$(".modal-body").html("<p>გნებავთ მონაცემის წაშლა ?</p>");
		$(".dojobbutton").text("წაშლა");
	}else{
		$(".modal-body").html("<p>Would you like ?</p>");
		$(".dojobbutton").text("Delete");
	}
	$(".dojobbutton").attr("data-removemessage",id); 
	$(".dojobbutton").attr("data-dlang",LANG); 
	$(".bs-example-modal-sm").modal("toggle");
});

var call = 0;
$(document).on("click",".reloadprotect",function(){
	$.post(AJAX_REQUEST_URL, { 
      	reloadImage:true
      }, function(result){
      	if(result=="Done"){
      		var pro = PROTOCOL+document.domain+"/protect.php?v="+call;
      		$(".protectimage").attr("src",pro);
      	}
      });
      call++;
});

//
$(document).on("click","#add-new-event",function(){
	 var etitle = $("#etitle").val();
	var estart_date = $("#estart_date").val();
	var eend_date = $("#eend_date").val();
	var eaddress = $("#eaddress").val();
	var eprice = $("#eprice").val();
	var ecurrency = $("#ecurrency").val();
	var edescription = $("#edescription").val();

      $.post(AJAX_REQUEST_URL, { 
      	addNewEvent:true, 
      	etitle: etitle, 
      	estart_date: estart_date, 
      	eend_date: eend_date, 
      	eaddress: eaddress, 
      	eprice: eprice, 
      	ecurrency: ecurrency, 
      	edescription: edescription 
      }, function(result){
      	if(result=="Done"){
      		$("#messagex").html("Done");
      		location.reload();
      	}
      });
});

$(document).on("click",".removeEvent",function(){
	var id = $(this).attr("data-id");
	$("#bs-example-xx").modal("show");
	$(".removeEventTrue").attr("data-id",id);
});

$(document).on("click",".removeEventTrue",function(){
	var id = $(this).attr("data-id");
	$.post(AJAX_REQUEST_URL, { 
		removeEvent:true, 
		id: id
	}, function(result){
		if(result == "Done"){
			location.reload();
		}
	});
});

$(document).on("click",".editEvent",function(){
	var id = $(this).attr("data-id");
	var lang = $(this).attr("data-lang");
	$.post(AJAX_REQUEST_URL, { 
		selectOneEvent:true, 
		id: id,
		lang_id:lang
	}, function(result){
		var obj = $.parseJSON(result);

		$("#eidx").val(obj.idx);
		$("#elang").val(obj.lang);
		$("#etitle").val(obj.title);
		$("#estart_date").val(obj.start_date);
		$("#eend_date").val(obj.end_date);
		$("#eaddress").val(obj.address);
		$("#eprice").val(obj.price);		
		$("#ecurrency").val(obj.currency).trigger("change");
		$("#edescription").val(obj.description);

		$("#add-new-event").text("რედაქტირება");
		$("#add-new-event").attr("id","edit-new-event");
		$("#remove"+obj.idx).remove();
	});
});

$(document).on("click","#edit-new-event",function(){
	var eidx = $("#eidx").val();
	var elang = $("#elang").val();
	var etitle = $("#etitle").val();
	var estart_date = $("#estart_date").val();
	var eend_date = $("#eend_date").val();
	var eaddress = $("#eaddress").val();
	var eprice = $("#eprice").val();
	var ecurrency = $("#ecurrency").val();
	var edescription = $("#edescription").val();

      $.post(AJAX_REQUEST_URL, { 
      	editNewEvent:true, 
      	eidx: eidx, 
      	elang: elang, 
      	etitle: etitle, 
      	estart_date: estart_date, 
      	eend_date: eend_date, 
      	eaddress: eaddress, 
      	eprice: eprice, 
      	ecurrency: ecurrency, 
      	edescription: edescription 
      }, function(result){
      	if(result=="Done"){
      		$("#messagex").html("Done");
      		location.reload();
      	}
      });
});

$(document).on("click","#send_catalog_list",function(){
	var send_parentidx = $("#send_parentidx").val();
	var lang_id = $("#lang_id").val();
	var send_idx = $("#send_idx").val();
	var send_email = $("#send_email").val();
	var send_text = $("#send_text").val();
	$(".send_message_output").html("Please wait...");
      $.post(AJAX_REQUEST_URL, { 
      	sendcataloglist:true, 
      	lang_id: lang_id, 
      	send_parentidx: send_parentidx, 
      	send_idx: send_idx, 
      	send_email: send_email, 
      	send_text: send_text  
      }, function(result){
      	$(".send_message_output").html(result);
      	if(result=="Done"){
      		setTimeout(function(){
      			location.reload();	
      		}, 2000);
      	}
      });
});


function animateLeft(clas){
	$(".hiddenSlide").animate({"left":"100%"}, "fast");
	$(clas+" .hiddenSlide").animate({"left":"0px"}, "slow");
}

function popupCatalogItem(idx, cataloglist, lang_id){
	$("#bs-example-catakigitem").modal("show"); 
	$.post(AJAX_REQUEST_URL, { 
		selectCatalogItemData:true, 
		idx: idx, 
		cataloglist:cataloglist, 
		lang_id:lang_id
	}, function(result){
		var obj = $.parseJSON(result);
		$(".catalogItemRows").html(obj.table);	

		$(".filterEmptyTdsAjax tr").each(function(){
	       var td = $("td", this).html(); 
	       if(td==""){ $(this).hide(); }
	    });		
	});
}

function select_current_day_events(date, lang_id){
	$(".event_lists").html("Please Wait...");
	$.post(AJAX_REQUEST_URL, { 
		selectAllEvents:true, 
		date: date, 
		lang_id:lang_id
	}, function(result){
		var obj = $.parseJSON(result);
		var html = "";
		if(obj.length){			
			for(var i = 0; i<obj.length; i++){
				html += "<div class=\"box box-success\" id=\"remove"+obj[i].idx+"\">";
				html += "<div class=\"box-header with-border\">";
				html += "<h3 class=\"box-title\">"+obj[i].title+"</h3>";
				html += "<div class=\"box-tools pull-right\">";
				html += "<button type=\"button\" class=\"btn btn-box-tool editEvent\" data-id=\""+obj[i].idx+"\" data-lang=\""+obj[i].lang+"\"><i class=\"fa fa-pencil-square-o\"></i></button>";
				html += "<button type=\"button\" class=\"btn btn-box-tool removeEvent\" data-id=\""+obj[i].idx+"\"><i class=\"fa fa-times\"></i></button>";
				html += "</div>";
				html += "</div>";
				html += "<div class=\"box-body\">";
				html += obj[i].description;
				html += "</div>";
				html += "</div>";
			}
			$(".event_lists").html(html);
		}
	});
}

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

function printList(){
	var url = document.location;
	window.open(url+"&print=true&sw=100000000", '_blank');
}

function OrderByMe(th, lb){
	$(".thLabel").css("color","#333");
	$(th).css("color","red");
	var url = document.location.toString();
	var rep = replaceUrlParam(url, "order", lb);
	var rep2 = replaceUrlParam(rep, "orderType", "ASC");
	location.href = rep2;
}

function replaceUrlParam(url, paramName, paramValue){
    if(paramValue == null)
        paramValue = '';
    var pattern = new RegExp('\\b('+paramName+'=).*?(&|$)')
    if(url.search(pattern)>=0){
        return url.replace(pattern,'$1' + paramValue + '$2');
    }
    return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue 
}