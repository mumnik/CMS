<!-- BEGIN: main -->
	 <link rel="stylesheet" href='{GL.base}/css/datepicker.css' type="text/css">
	<script src="{GL.base}/js/jquery.js" type="text/javascript"></script>

	<script type="text/javascript" src="{GL.base}/js/tinymce/tiny_mce.js"></script>
	<script type="text/JavaScript" src="{GL.base}/js/date.js"></script>
    <script type="text/JavaScript" src="{GL.base}/js/jquery.datepicker.js"></script>
	<script language="javascript" type="text/javascript">
     tinyMCE.init({
		    theme : "advanced",
		    mode : "exact",
		    elements : "{textareas}",
		    width : "544",
		    extended_valid_elements : "a[href|target|name]",
		    plugins : "table",
		    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
		    theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
		    debug : false
     });  
	</script>
	<form acion="index.php?module=gallery" method="post">
		<input type="hidden" name="action" value="creategallery">

			<table>
			<!-- BEGIN: titles -->
			<tr>
				<td>
				Title {lang}:
				</td>
				<td>					
                    <input type="text" name="gallery[title][{lang}]"/>                    
				</td>
				</tr>
			<!-- END: titles -->
            <!-- BEGIN: descriptions -->
			<tr>
				<td>
				Description {lang}:
				</td>
				<td>					
                    <textarea name="gallery[description][{lang}]" id="description_{lang}"/></textarea>                    
				</td>
				</tr>
			<!-- END: descriptions -->
			</table>

		<input type="submit" value="Create" />
	</form>

<!-- END: main -->