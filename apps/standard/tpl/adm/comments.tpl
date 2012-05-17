<!-- BEGIN: main -->
<script type="text/javascript" src="{GL.base}/js/tinymce/tiny_mce.js"></script>
<script type="text/JavaScript" src="{GL.base}/js/scw.js"></script>
<script language="javascript" type="text/javascript">
 tinyMCE.init({
		 	theme : "advanced",
		    mode : "exact",
		    elements : "modbody",
		    width : "544",
		    extended_valid_elements : "a[href|target|name]",
		    plugins : "table",
		    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap",			
		    theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
		    debug : false
 });  
</script>

	<!-- BEGIN: gselect -->
	<form action="index.php" method="post">
		<input type="hidden" name="module" value="comments" />
		<!comment>: 
		<select name="portfolioid" onChange="javascript: submit();">
			<option value="0"><!select_portfolio></option>
			<!-- BEGIN: option -->
			<option value="{portfolioid}" {selected}>{surename}, {name}</option>
			<!-- END: option -->		
		</select>
	</form>
	<!-- END: gselect -->
	
	<!-- BEGIN: editcomment -->
	<br />
	<form action="index.php" method="post">	
		<input type="hidden" name="action" value="savecomment" />
		<input type="hidden" name="commentid" value="{commentid}" />
		<input type="hidden" name="portfolioid" value="{portfolioid}" />
		<input type="hidden" name="comment[portfolioid]" value="{portfolioid}" />
	<table class="tableinfo">
	<tbody>
		<tr>
			<td><!language></td>
			<td>
				<select name="comment[lang]" {readonly} onchange="javascript: location.href = 'index.php?module=comments&portfolioid={portfolioid}&clang='+this.options[this.selectedIndex].value;">
					<!-- BEGIN: langs -->
					<option value="{lang}" {selected}>{lang}</option>
					<!-- END: langs -->
				</select>
			</td>
		</tr>
		<tr>
			<td><!comment></td>
			<td>
				<textarea id="comment" cols="30" rows="15" name="comment[comment]">{comment}</textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="submit" value="save" name="save" />
			</td>
		</tr>
	</tbody>
	</table>
	</form>
	<!-- END: editcomment -->

	<!-- BEGIN: comments -->
	<br />
		<table class="tableinfo">
		<tbody>
			<!-- BEGIN: crow -->
			<tr>
				<td>{lang}</td>
				<td>
					{comment}
				</td>
				<td>
					<a href="index.php?module=comments&portfolioid={portfolioid}&commentid={commentid}&clang={lang}"><!edit></a>
				</td>
			</tr>
			<!-- END: crow -->
		</tbody>
		</table>	
		
	<!-- END: comments-->
<!-- END: main -->