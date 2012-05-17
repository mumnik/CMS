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
 
	Date.firstDayOfWeek = 0;
	Date.format = 'dd.mm.yyyy';

 
	$(function() {
		$('.date-pick').datePicker();	
	});
</script>

<div id="page-heading">
	<h1>Edit news</h1>
</div>

<form method="post" action="index.php?module=news&action=savenews">
<input type="hidden" name="nookid" value="{storeddata_nookid}">

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
		
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr valign="top">
				<td>					
					<!-- start id-form -->
					<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
						<tr>
							<th valign="top">Date</td>
							<th valign="top">-</td>
							<td><input type="text" name="news[date]" value="{storeddata_date}"  class="inp-form" /></td>
						</tr>
					<!-- BEGIN: fields -->
						<!-- BEGIN: field -->
						<tr>
							<td>{title}</td>
							<td>{fieldlang}</td>
							<td>{input}</td>
						</tr>
						<!-- END: field -->
					<!-- END: fields -->
						<tr>
							<td colspan="3" align="center">
								<input type="submit" class="form-submit">
							</td>
						</tr>
					</table>
					
					<div class="clear"></div>
				</td>
				</tr>
			</table>
			
			<div class="clear"></div>
			
			</div>

		</div>
		<!--  end content-table-inner  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
</table>
</form>

<div class="clear">&nbsp;</div>

<!-- END: main -->