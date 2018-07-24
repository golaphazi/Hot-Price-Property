
/*Set font */
var fontArrya = ["Arial", "Consolas", "Tahoma", "Monospace", "Cursive", "Sans-Serif", "Calibri"];
var fontHthl = document.getElementById('fontChanger');
for(fon = 0; fon < fontArrya.length; fon++){
	fontHthl.innerHTML += "<option value='"+fontArrya[fon]+"'> "+fontArrya[fon]+" </option>";
}

/** for font Family **/
var fonts = document.querySelectorAll("select#fontChanger > option");
for(var face = 0; face < fonts.length; face++){
	fonts[face].style.fontFamily = fonts[face].value;
}


/*set font size*/
var fontSiz = document.getElementById('fontSizeChanger');
for(var siz = 1; siz < 10; siz++){
	fontSiz.innerHTML += "<option value='"+siz+"'> "+siz+" </option>";
}

/*set font heading*/
/*
var fontHead = document.getElementById('headingChanger');
for(var head = 1; head < 7; head++){
	fontHead.innerHTML += "<option value='h"+head+"'> H"+head+" </option>";
}
*/
/** for iframe js**/
window.addEventListener("load", function(){
	
	pasteTextAreaData();
	
	var editor = theNEXTeditor.document;
	editor.designMode = "on";
	
	//var textID = document.getElementById(editorID);
	editorID.style.display = "none";
	//alert(editorID);
	
	/*For bold text*/
	boldButton.addEventListener("click", function(){
		editor.execCommand("Bold", false, null);
	}, false);
	
	/*For italic text*/
	italicButton.addEventListener("click", function(){
		editor.execCommand("Italic", false, null);
	}, false);
	
	/*Text underline*/
	underlineButton.addEventListener("click", function(){
		editor.execCommand("Underline", false, null);
	},false);
	
	/*Text left*/
	leftButton.addEventListener("click", function(){
		editor.execCommand("JustifyLeft", false, null);
	},false);
	
	/*Text Center*/
	centerButton.addEventListener("click", function(){
		editor.execCommand("JustifyCenter", false, null);
	},false);
	
	/*Text Right*/
	rightButton.addEventListener("click", function(){
		editor.execCommand("JustifyRight", false, null);
	},false);
	
	/*For Order list text*/
	orderedListButton.addEventListener("click", function(){
		editor.execCommand("InsertOrderedList", false, "newOL", + Math.round(Math.random() * 1000));
	}, false);
	
	/*For Un Order list text*/
	unorderedListButton.addEventListener("click", function(){
		editor.execCommand("InsertUnorderedList", false, "newUL", + Math.round(Math.random() * 1000));
	}, false);
	
	
	/*color text*/
	fontColorButton.addEventListener("change", function(event){
		editor.execCommand("ForeColor", false, event.target.value);
	}, false);
	
	/*back color text*/
	highlightButton.addEventListener("change", function(event){
		editor.execCommand("BackColor", false, event.target.value);
	}, false);
	
	/** For create link*/
	linkButton.addEventListener("click", function(){
		var url = prompt("Enter a URL", "http://");
		editor.execCommand("CreateLink", false, url);
	}, false);
	
	/*For unlick */
	unLinkButton.addEventListener("click", function(){
		editor.execCommand("Unlink", false, null);
	}, false);
	
	
	/*For image button*/
	imageButton.addEventListener("click", function(){
		var url = prompt("Enter a image URL", "http://");
		if(url.length > 5){
			var fileTypeArray = url;
			var fileType = fileTypeArray.split('.');
			var typeSelect = fileType[fileType.length - 1];
			if ($.inArray(typeSelect, ['jpeg', 'jpg', 'JEPG', 'JPG', 'png', 'PNG', 'GIF', 'gif']) != '-1') {
				editor.execCommand("insertImage", false, url);
			}else{
				alert("Invalid image format");
			}
		}
	}, false);
	
	/*For font family change*/
	fontChanger.addEventListener("change", function(event){
		editor.execCommand("FontName", false, event.target.value);
	}, false);
	
	/*For font size change*/
	fontSizeChanger.addEventListener("change", function(event){
		editor.execCommand("FontSize", false, event.target.value);
	}, false);
	

	/*For Paragraph */
	/*headingChanger.addEventListener("click", function(event){
		editor.execCommand("heading", false, event.target.value);
	}, false);
	
	*/
	
	/*For undo button */
	undoButton.addEventListener("click", function(){
		editor.execCommand("undo", false, null);
	}, false);
	
	/*For redo button */
	redoButton.addEventListener("click", function(){
		editor.execCommand("redo", false, null);
	}, false);
	
	
	
}, false);

/*********** text area paste data*******/
function pasteTextAreaData(){
	//var textArea = document.getElementById(editorID);
	//alert(textArea);
	window.frames['theNEXTeditor'].document.body.innerHTML = editorID.value;
}

theNEXTeditor.addEventListener("keyup", function(){
	copyTextArea();
}, false);

theNEXTeditor.addEventListener("mouseout", function(){
	copyTextArea();
}, false);

theNEXTeditor.addEventListener("click", function(){
	copyTextArea();
}, false);


    
function copyTextArea(){
	//var textArea = document.getElementById(editorID);
	editorID.innerHTML = window.frames['theNEXTeditor'].document.body.innerHTML;
}

var dataDev = '<span style="float:right; margin-right:3px; margin-top:3px; font-size:12px;" title="Develop by Golap Hazi - golaphazi@gmail.com"> <i class="fa fa-question"></i> </span>';
var table = document.getElementById("redoButton");
table.insertAdjacentHTML('afterend', dataDev);
