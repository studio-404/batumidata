/* select START */
$(document).on("click",".selectelement",function(){
	var dlang = $(this).data("dlang"); 
	createSelectElement(dlang);
});

$(document).on("click",".edit-select-options",function(){

	var optionId = $(this).attr("data-uniqueclass"); 	
	$(".insert-options").attr("data-selectclassinsert",optionId); 

	/* color chnage active edit inputs START */
	$(".element-box").removeClass("has-error").addClass("has-warning");
	$(".element-box a").css("color","#f39c12"); 
	$("#"+optionId).removeClass("has-warning").addClass("has-error");
	$("#"+optionId+" a").css("color","#dd4b39"); 
	/* color chnage active edit inputs END */

	var options = '';
	$("#"+optionId+" select option").each(function(){
		var xy = $(this).text().replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
		if(xy!="" && xy!="option"){
			options += '<input type="text" class="form-control selectoptionspopup-item" value="'+xy+'" style="margin-top:5px;" />';
		}
	});
	$(".selectoptionspopup").html(options);
	$('.bs-example-modal-sm2').modal("show"); 
});

$(document).on("click",".selectoptionspopup-item-add",function(){
	var ins = '<input type="text" class="form-control selectoptionspopup-item" value="option" style="margin-top:5px;" />';
	$(".selectoptionspopup").append(ins);
});

$(document).on("click",".insert-options",function(){
	var clsxx = $(this).attr("data-selectclassinsert");
	var inx = '';
	$(".selectoptionspopup input").each(function(){
		e = $(this).val();
		e = e.replace(/"/g, '');
		e = e.replace(/'/g, '');
		e = e.replace(/#/g, '');

		if(e!="" && e!="option"){
			inx += '<option value="'+e+'">'+e+'</option>';
		}
	});
	$("#"+clsxx+" select").html(inx);
	$('.bs-example-modal-sm2').modal("hide"); 
});

function createSelectElement(dlang){
	// var countMe = $(".element-box").length + 1;
	var countMe = $(this).attr("data-countme");
	if(!countMe){
		 $(this).attr("data-countme",1);
	}else{
		countMe = countMe + 1;
		$(this).attr("data-countme",countMe);
	}
	var uniqueClass = "elementuniqueselect"+countMe;

	var elem = '<div class="form-group has-warning element-box" id="'+uniqueClass+'" data-dlang="'+dlang+'" data-elemtype="select" data-elemlabel="Label Text" data-elemname="elemname" data-database="id" data-important="no" data-list="no" data-filter="no">';
	elem += '<label>Label Text</label>';
	elem += '<a href="javascript:void(0)" data-uniqueclass="'+uniqueClass+'" data-dlang="'+dlang+'" style="float:right; color:#f39c12; margin-left:5px;" class="remove-element"><i class="glyphicon glyphicon-remove"></i></a>';
	elem += '<a href="javascript:void(0)" data-uniqueclass="'+uniqueClass+'" style="float:right; margin-left:5px; color:#f39c12" onclick="editSelectElement(this)"><i class="glyphicon glyphicon-edit"></i></a>';
	elem += '<a href="javascript:void(0)" data-uniqueclass="'+uniqueClass+'" data-dlang="'+dlang+'" style="float:right; color:#f39c12;" class="edit-select-options"><i class="glyphicon glyphicon-th-list"></i></a>';
	elem += '<select class="form-control" name="elemname">';
	elem += '<option value="option">option</option>';
	elem += '</select>';
	elem += '</div>';
	$(".interface").append(elem);
} 


function editSelectElement(e){
	var uniqueClass = e.getAttribute("data-uniqueclass");
	/* color chnage active edit inputs START */
	$(".element-box").removeClass("has-error").addClass("has-warning");
	$(".element-box a").css("color","#f39c12"); 
	$("#"+uniqueClass).removeClass("has-warning").addClass("has-error");
	$("#"+uniqueClass+" a").css("color","#dd4b39"); 
	/* color chnage active edit inputs END */
	var getElemType = $("#"+uniqueClass).attr("data-elemtype").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemLabel = $("#"+uniqueClass).attr("data-elemlabel").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemName = $("#"+uniqueClass).attr("data-elemname").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemDatabase = $("#"+uniqueClass).attr("data-database").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemImportant = $("#"+uniqueClass).attr("data-important").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemList = $("#"+uniqueClass).attr("data-list").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemFilter= $("#"+uniqueClass).attr("data-filter").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	/* Type	*/
	var _input = '<div class="form-group"><label>Element Type:</label><select class="form-control" disabled="disabled"><option value="text">Text</option></select></div>';
	/* label */
	_input += '<div class="form-group"><label>Element Label:</label><input type="text" class="form-control" value="'+getElemLabel+'" onkeyup="bindLabel(this, \''+uniqueClass+'\')" /></div>';
	/* Name */
	_input += '<div class="form-group"><label>Element Name:</label><input type="text" class="form-control" value="'+getElemName+'" onkeyup="bindName(this, \''+uniqueClass+'\')" /></div>';
	
	/* Database attach */
	_input += '<div class="form-group"><label>Element Databaze</label>';
	_input += '<select class="form-control" onchange="bindDatabase(this, \''+uniqueClass+'\')">';
	var db = $(".database-column-list li");
	for(var x = 0; x<=(db.length-1); x++){
		var valdb = db.eq(x).text().replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
		if(getElemDatabase==valdb){
			_input += '<option value="'+valdb+'" selected="selected">'+valdb+'</option>';
		}else{
			_input += '<option value="'+valdb+'">'+valdb+'</option>';
		}
	}
	_input += '</select>';
	_input += '</div>';
	/* Importent */
	if(getElemImportant=="yes"){ var y = 'selected="selected"'; var n = ''; }
	else{ var n = 'selected="selected"'; var y = ''; }
	_input += '<div class="form-group"><label>Important:</label>';
	_input += '<select class="form-control" onchange="bindImportant(this, \''+uniqueClass+'\')">';
	_input += '<option value="yes" '+y+'>Yes</option>';
	_input += '<option value="no" '+n+'>No</option>';
	_input += '</select>';
	_input += '</div>';

	/* list */
	if(getElemList=="yes"){ var ly = 'selected="selected"'; var ln = ''; }
	else{ var ln = 'selected="selected"'; var ly = ''; }

	_input += '<div class="form-group"><label>List:</label>';
	_input += '<select class="form-control" onchange="bindList(this, \''+uniqueClass+'\')">';
	_input += '<option value="yes" '+ly+'>Yes</option>';
	_input += '<option value="no" '+ln+'>No</option>';
	_input += '</select>';
	_input += '</div>';

	/* Filter */
	if(getElemFilter=="yes"){ var fy = 'selected="selected"'; var fn = ''; }
	else{ var fn = 'selected="selected"'; var fy = ''; }
	_input += '<div class="form-group"><label>Filter:</label>';
	_input += '<select class="form-control" onchange="bindFilter(this, \''+uniqueClass+'\')">';
	_input += '<option value="yes" '+fy+'>Yes</option>';
	_input += '<option value="no" '+fn+'>No</option>';
	_input += '</select>';
	_input += '</div>';

	$(".options-box").html(_input); 
	
}


/* select END */

/* textarea START */
$(document).on("click",".inputtextareaelement",function(){
	var dlang = $(this).data("dlang"); 
	createTextareaElement(dlang);
});

function editTextareaElement(e){
	var uniqueClass = e.getAttribute("data-uniqueclass");
	/* color chnage active edit inputs START */
	$(".element-box").removeClass("has-error").addClass("has-warning");
	$(".element-box a").css("color","#f39c12"); 
	$("#"+uniqueClass).removeClass("has-warning").addClass("has-error");
	$("#"+uniqueClass+" a").css("color","#dd4b39"); 
	/* color chnage active edit inputs END */
	var getElemType = $("#"+uniqueClass).attr("data-elemtype").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemLabel = $("#"+uniqueClass).attr("data-elemlabel").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemName = $("#"+uniqueClass).attr("data-elemname").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemDatabase = $("#"+uniqueClass).attr("data-database").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemImportant = $("#"+uniqueClass).attr("data-important").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemList = $("#"+uniqueClass).attr("data-list").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemFilter= $("#"+uniqueClass).attr("data-filter").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	/* Type	*/
	var _input = '<div class="form-group"><label>Element Type:</label><select class="form-control" disabled="disabled"><option value="text">Text</option></select></div>';
	/* label	*/
	_input += '<div class="form-group"><label>Element Label:</label><input type="text" class="form-control" value="'+getElemLabel+'" onkeyup="bindLabel(this, \''+uniqueClass+'\')" /></div>';
	/* Name */
	_input += '<div class="form-group"><label>Element Name:</label><input type="text" class="form-control" value="'+getElemName+'" onkeyup="bindName(this, \''+uniqueClass+'\')" /></div>';
	/* Database attach */
	_input += '<div class="form-group"><label>Element Databaze</label>';
	_input += '<select class="form-control" onchange="bindDatabase(this, \''+uniqueClass+'\')">';
	var db = $(".database-column-list li");
	for(var x = 0; x<=(db.length-1); x++){
		var valdb = db.eq(x).text().replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
		if(getElemDatabase==valdb){
			_input += '<option value="'+valdb+'" selected="selected">'+valdb+'</option>';
		}else{
			_input += '<option value="'+valdb+'">'+valdb+'</option>';
		}
	}
	_input += '</select>';
	_input += '</div>';
	/* Importent */
	if(getElemImportant=="yes"){ var y = 'selected="selected"'; var n = ''; }
	else{ var n = 'selected="selected"'; var y = ''; }
	_input += '<div class="form-group"><label>Important:</label>';
	_input += '<select class="form-control" onchange="bindImportant(this, \''+uniqueClass+'\')">';
	_input += '<option value="yes" '+y+'>Yes</option>';
	_input += '<option value="no" '+n+'>No</option>';
	_input += '</select>';
	_input += '</div>';

	/* list */
	if(getElemList=="yes"){ var ly = 'selected="selected"'; var ln = ''; }
	else{ var ln = 'selected="selected"'; var ly = ''; }

	_input += '<div class="form-group"><label>List:</label>';
	_input += '<select class="form-control" onchange="bindList(this, \''+uniqueClass+'\')">';
	_input += '<option value="yes" '+ly+'>Yes</option>';
	_input += '<option value="no" '+ln+'>No</option>';
	_input += '</select>';
	_input += '</div>';

	/* Filter */
	if(getElemFilter=="yes"){ var fy = 'selected="selected"'; var fn = ''; }
	else{ var fn = 'selected="selected"'; var fy = ''; }
	_input += '<div class="form-group"><label>Filter:</label>';
	_input += '<select class="form-control" onchange="bindFilter(this, \''+uniqueClass+'\')">';
	_input += '<option value="yes" '+fy+'>Yes</option>';
	_input += '<option value="no" '+fn+'>No</option>';
	_input += '</select>';
	_input += '</div>';

	$(".options-box").html(_input); 
	
}

function createTextareaElement(dlang){
	// var countMe = $(".element-box").length + 1;
	var countMe = $(this).attr("data-countme");
	if(!countMe){
		 $(this).attr("data-countme",1);
	}else{
		countMe = countMe + 1;
		$(this).attr("data-countme",countMe);
	}
	var uniqueClass = "elementuniquetextarea"+countMe;

	var elem = '<div class="form-group has-warning element-box" id="'+uniqueClass+'" data-dlang="'+dlang+'" data-elemtype="textarea" data-elemlabel="Label Text" data-elemname="elemname" data-database="id" data-important="no" data-list="no" data-filter="no">';
	elem += '<label>Label Text</label>';
	elem += '<a href="javascript:void(0)" data-uniqueclass="'+uniqueClass+'" data-dlang="'+dlang+'" style="float:right; color:#f39c12; margin-left:5px;" class="remove-element"><i class="glyphicon glyphicon-remove"></i></a>';
	elem += '<a href="javascript:void(0)" data-uniqueclass="'+uniqueClass+'" style="float:right; color:#f39c12" onclick="editTextareaElement(this)"><i class="glyphicon glyphicon-edit"></i></a>';
	elem += '<textarea class="form-control" rows="3" name="elemname"></textarea>';
	elem += '</div>';
	$(".interface").append(elem);
}

/* textarea END */

/* input type text START */
$(document).on("click",".inputtextelement",function(){
	var dlang = $(this).data("dlang"); 
	createTextElement(dlang);
});

$(document).on("click",".remove-element",function(){
	var uniqueclass = $(this).data("uniqueclass"); 
	var dlang = $(this).data("dlang"); 
	var lg = "";
	if(uniqueclass && dlang){
		if(dlang=="2"){
			$(".this-ismessage").html("<p>Would you like to delete item ?</p>"); 	
			$(".dojobbutton").text("Yes").fadeIn("slow");			
		}else{
			$(".this-ismessage").html("<p>გნებავთ წაშალოთ მონაცემი ?</p>"); 
			$(".dojobbutton").text("დიახ").fadeIn("slow");
		}
		//$(".dojobbutton").attr("onclick",uniqueclass.toString());
		$(".dojobbutton").attr("onclick","removeMe('"+uniqueclass+"')");
		$('.bs-example-modal-sm').modal("show");
		
	}
});



function removeMe(cl){
	$("#"+cl).remove(); 
	$('.bs-example-modal-sm').modal("hide");
	$(".options-box").html("Empty"); 
	$(".element-box").removeClass("has-error").addClass("has-warning");
	$(".element-box a").css("color","#f39c12"); 
	return false;
}

function bindLabel(e,l){
	$("#"+l+" label").text(e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
	$("#"+l).attr("data-elemlabel",e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
	console.log(e.value);
}

function bindName(e,l){
	var latinChars = e.value.replace(/[^a-z]/g, "").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	e.value = latinChars;
	$("#"+l).attr("data-elemname",latinChars);
}

function bindPlaceholder(e,l){
	$("#"+l+" input").val(e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
	$("#"+l).attr("data-elemvalue",e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
	console.log(e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
}

function bindDatabase(e,l){
	$("#"+l).attr("data-database",e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
	console.log(e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));	
}

function bindImportant(e,l){
	$("#"+l).attr("data-important",e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
	console.log(e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));	
}

function bindList(e,l){
	$("#"+l).attr("data-list",e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
	console.log(e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));	
}

function bindFilter(e,l){
	$("#"+l).attr("data-filter",e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));
	console.log(e.value.replace(/"/g, '').replace(/'/g, '').replace(/#/g, ''));	
}

function editTextElement(e){
	var uniqueClass = e.getAttribute("data-uniqueclass");
	/* color chnage active edit inputs START */
	$(".element-box").removeClass("has-error").addClass("has-warning");
	$(".element-box a").css("color","#f39c12"); 
	$("#"+uniqueClass).removeClass("has-warning").addClass("has-error");
	$("#"+uniqueClass+" a").css("color","#dd4b39"); 
	/* color chnage active edit inputs END */
	var getElemType = $("#"+uniqueClass).attr("data-elemtype").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemLabel = $("#"+uniqueClass).attr("data-elemlabel").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemName = $("#"+uniqueClass).attr("data-elemname").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemValue = $("#"+uniqueClass).attr("data-elemvalue").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemDatabase = $("#"+uniqueClass).attr("data-database").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemImportant = $("#"+uniqueClass).attr("data-important").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemList = $("#"+uniqueClass).attr("data-list").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	var getElemFilter= $("#"+uniqueClass).attr("data-filter").replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
	/* Type	*/
	var _input = '<div class="form-group"><label>Element Type:</label><select class="form-control" disabled="disabled"><option value="text">Text</option></select></div>';
	/* label	*/
	_input += '<div class="form-group"><label>Element Label:</label><input type="text" class="form-control" value="'+getElemLabel+'" onkeyup="bindLabel(this, \''+uniqueClass+'\')" /></div>';
	/* Name */
	_input += '<div class="form-group"><label>Element Name:</label><input type="text" class="form-control" value="'+getElemName+'" onkeyup="bindName(this, \''+uniqueClass+'\')" /></div>';
	/* Placeholder */
	_input += '<div class="form-group"><label>Element Placeholder:</label><input type="text" class="form-control" value="'+getElemValue+'" onkeyup="bindPlaceholder(this, \''+uniqueClass+'\')" /></div>';
	/* Database attach */
	_input += '<div class="form-group"><label>Element Databaze</label>';
	_input += '<select class="form-control" onchange="bindDatabase(this, \''+uniqueClass+'\')">';
	var db = $(".database-column-list li");
	for(var x = 0; x<=(db.length-1); x++){
		var valdb = db.eq(x).text().replace(/"/g, '').replace(/'/g, '').replace(/#/g, '');
		if(getElemDatabase==valdb){
			_input += '<option value="'+valdb+'" selected="selected">'+valdb+'</option>';
		}else{
			_input += '<option value="'+valdb+'">'+valdb+'</option>';
		}
	}
	_input += '</select>';
	_input += '</div>';
	/* Importent */
	if(getElemImportant=="yes"){ var y = 'selected="selected"'; var n = ''; }
	else{ var n = 'selected="selected"'; var y = ''; }
	_input += '<div class="form-group"><label>Important:</label>';
	_input += '<select class="form-control" onchange="bindImportant(this, \''+uniqueClass+'\')">';
	_input += '<option value="yes" '+y+'>Yes</option>';
	_input += '<option value="no" '+n+'>No</option>';
	_input += '</select>';
	_input += '</div>';

	/* list */
	if(getElemList=="yes"){ var ly = 'selected="selected"'; var ln = ''; }
	else{ var ln = 'selected="selected"'; var ly = ''; }

	_input += '<div class="form-group"><label>List:</label>';
	_input += '<select class="form-control" onchange="bindList(this, \''+uniqueClass+'\')">';
	_input += '<option value="yes" '+ly+'>Yes</option>';
	_input += '<option value="no" '+ln+'>No</option>';
	_input += '</select>';
	_input += '</div>';

	/* Filter */
	if(getElemFilter=="yes"){ var fy = 'selected="selected"'; var fn = ''; }
	else{ var fn = 'selected="selected"'; var fy = ''; }
	_input += '<div class="form-group"><label>Filter:</label>';
	_input += '<select class="form-control" onchange="bindFilter(this, \''+uniqueClass+'\')">';
	_input += '<option value="yes" '+fy+'>Yes</option>';
	_input += '<option value="no" '+fn+'>No</option>';
	_input += '</select>';
	_input += '</div>';

	$(".options-box").html(_input); 
	
}

function createTextElement(dlang){
	// var countMe = $(".element-box").length + 1;
	var countMe = $(this).attr("data-countme");
	if(!countMe){
		 $(this).attr("data-countme",1);
	}else{
		countMe = countMe + 1;
		$(this).attr("data-countme",countMe);
	}
	var uniqueClass = "elementunique"+countMe;

	var elem = '<div class="form-group has-warning element-box" id="'+uniqueClass+'" data-dlang="'+dlang+'" data-elemtype="text" data-elemlabel="Label Text" data-elemname="elemname" data-elemvalue="Element Placeholder" data-database="id" data-important="no" data-list="no" data-filter="no">';
	elem += '<label>Label Text</label>';
	elem += '<a href="javascript:void(0)" data-uniqueclass="'+uniqueClass+'" data-dlang="'+dlang+'" style="float:right; color:#f39c12; margin-left:5px;" class="remove-element"><i class="glyphicon glyphicon-remove"></i></a>';
	elem += '<a href="javascript:void(0)" data-uniqueclass="'+uniqueClass+'" style="float:right; color:#f39c12" onclick="editTextElement(this)"><i class="glyphicon glyphicon-edit"></i></a>';
	
	elem += '<input type="text" class="form-control" name="elemname" value="Element Placeholder" />';
	elem += '</div>';
	$(".interface").append(elem);
}

/* input type text END */