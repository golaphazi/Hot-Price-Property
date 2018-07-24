<html>
<head>
<title>Next Editor </title>
<link rel="stylesheet" href="<?= CSS_URL; ?>NextEditor/nextEditor.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
var editorID = <?= $id?>;
</script>
</head>
<body>
	<div id="textEditor">
		
		<div id="theRibbon">
			<button id="boldButton" title="Bold" type="button"> <b>B</b> </button>
			<button id="italicButton" title="Italic"  type="button"> <em>I</em> </button>
			<button id="underlineButton" title="Underline"  type="button"> <u>U</u> </button>
			
			<button id="leftButton" title="Left Align"  type="button"> <i class="fa fa-align-left"></i></button>
			<button id="centerButton" title="Center Align"  type="button"> <i class="fa fa-align-center"></i></button>
			<button id="rightButton" title="Right Align"  type="button"> <i class="fa fa-align-right"></i></button>
			<button id="orderedListButton" title="Number List"  type="button"> <i class="fa fa-list-ol"></i></button>
			<button id="unorderedListButton" title="Bulleted List"  type="button"> <i class="fa fa-list-ul"></i></button>
			<input type="color" id="fontColorButton" title="Change Font Color"/>
			<input type="color" id="highlightButton" title="Highlight Text"/>
			<button id="linkButton" title="Create Link"  type="button"> <i class="fa fa-link"></i> </button>
			<button id="unLinkButton" title="Remove Link"  type="button"> <i class="fa fa-chain-broken"></i> </button>

			<button id="imageButton" title="Insert Image"  type="button"> <i class="fa fa-image"></i> </button>	
			<select id="fontChanger">				
			</select>
			<select id="fontSizeChanger">
				<option>Size</option>				
			</select>
			
			<button id="undoButton" title="Undo the previous action" type="button"> &larr; </button>
			<button id="redoButton" title="Redo" type="button"> &rarr; </button>
			
		</div>
		<div id="richTextArea">
			<iframe id="theNEXTeditor" name="theNEXTeditor" frameborder="0"></iframe>
		</div>
	</div>

<script type="text/javascript" src="<?= JS_URL; ?>nextEditor/nextEditor.js"></script>
</body>
</html>
