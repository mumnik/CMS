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
	 
	 	Date.firstDayOfWeek = 0;
	Date.format = 'dd.mm.yyyy';
 
	 
	$(function()
	{
		$('.date-pick').datePicker();	
	});
	 
    </script>
<form method="post" action="index.php?module=events&action=saveevents">
<input type="hidden" name="nookid" value="{storeddata_nookid}">

<table>


<tr>
	<td>
		Date
	</td>	
	<td>
		<input type="text" name="events[date]" value="{storeddata_date}" class="date-pick" />		
	</td>
</tr>
<tr>
	<td>
		Time
	</td>	
	<td>
		<input type="text" name="events[time]" value="{storeddata_time}"/>		
	</td>
</tr>
<tr>
	<td valign="top">
		Type
	</td>
	<td>
		<select id="type" name="events[type]">
		  <option value = "Sconto Team">Sconto Team</option>
		  <option value = "Sconto Sia">Sconto Sia</option>
		  <option value = "Other">Other</option>
		</select>
	</td>
</tr>
<!-- BEGIN: fields -->
    <!-- BEGIN: field -->

    <tr style="border-bottom: 1px solid #000">
        <td>
            {title}
        </td>
        <td>
            {fieldlang}
        </td>
        <td>
            {input}
        </td>
    </tr>
    <!-- END: field -->
<!-- END: fields -->

<tr>
	<td colspan="5" align="center">
		<input type="submit" value="Ok" onclick="">
	</td>
</tr>
</table>

</form>
<!-- END: main -->