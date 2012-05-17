<!-- BEGIN: main -->
	 <link rel="stylesheet" href='{GL.base}/css/datepicker.css' type="text/css">
	<script src="{GL.base}/js/jquery-1.3.2.min.js" type="text/javascript"></script>

	<script type="text/javascript" src="{GL.base}/js/tinymce/tiny_mce.js"></script>
	<script type="text/JavaScript" src="{GL.base}/js/date.js"></script>
    <script type="text/JavaScript" src="{GL.base}/js/jquery.datepicker.js"></script>
	<script language="javascript" type="text/javascript">
     tinyMCE.init({
		    theme : "advanced",
		    mode : "exact",
		    elements : "newsbody",
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
	 
	 	Date.firstDayOfWeek = 0;
	Date.format = 'dd.mm.yyyy';
 
	 
	$(function()
	{
		$('.date-pick').datePicker();	
	});
	 
    </script>
<form method="post" action="index.php?module=articles&action=savearticle">
<input type="hidden" name="nookid" value="{storeddata_nookid}">

<table>
<tr>
	<td>
		Title
	</td>
	<td>
		<input type="text" name="article[title]"  value="{storeddata_title}" size="64" />
	</td>
</tr>
<tr>
	<td valign="top">
		Body
	</td>
	<td>
		<textarea id="newsbody" name="article[body]" cols="60" rows="30">{storeddata_body}</textarea>
	</td>
</tr>
<tr>
	<td colspan="5" align="center">
		<input type="submit" value="Ok">
	</td>
</tr>
</table>
</form>
<!-- END: main -->