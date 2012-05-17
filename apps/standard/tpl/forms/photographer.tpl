<!-- BEGIN: main -->
	<script type="text/javascript" src="{GL.base}/js/tinymce/tiny_mce.js"></script>
	<script type="text/JavaScript" src="{GL.base}/js/scw.js"></script>
    <script language="javascript" type="text/javascript">
     tinyMCE.init({
		    theme : "advanced",
		    mode : "exact",
		    elements : "comments",
		    width : "544",
		    extended_valid_elements : "a[href|target|name]",
		    plugins : "table",
		    theme_advanced_buttons1_add : "fontsizeselect",
		    theme_advanced_buttons3_add_before : "tablecontrols,separator",
		    theme_advanced_toolbar_location : "top",
		    debug : false
     });  
    </script>
	
<form action="index.php" method="post">
<input type="hidden" name="model[type]" value="2" />
<input type="hidden" name="action" value="saveportfolio" />
<input type="hidden" name="portfolioid" value="{portfolioid}" />

<table>
<tbody>
	<tr>
    	<td><!pt_type></td>
    	<td>
			{pt_type}
        </td>
    </tr>
	<tr>
		<td><!index>:</td>
		<td>
			<input type="text" name="model[index]" value="{index}" />
		</td>
	</tr>
	<tr>
    	<td><!name></td>
    	<td><input type="text" name="model[name]" value="{name}" /></td>
    </tr>
	<tr>
    	<td><!surename></td>
    	<td><input type="text" name="model[surename]" value="{surename}" /></td>
    </tr>
	<tr>
    	<td><!phone></td>
    	<td><input type="text" name="model[phone]" value="{phone}" /></td>
    </tr>
	<tr>
    	<td><!email></td>
    	<td><input type="text" name="model[email]" value="{email}" /></td>
    </tr>
	<tr>
    	<td><!genre></td>
    	<td><input type="text" name="model[genre]" value="{genre}" /></td>
    </tr>
	<tr>
    	<td><!tags></td>
    	<td><input type="text" name="model[tags]" value="{tags}" /></td>
    </tr>
	<tr>
    	<td><!active></td>
    	<td><input type="checkbox" name="model[active]" {active_checked} value="1" /></td>
    </tr>
	<tr>
	   	<td colspan="2" align="left">
			<!comment>
		</td>
	<tr>
	   	<td colspan="2" align="left">
		<!-- BEGIN: comments -->
			<table class="tableinfo">
			<tbody>
				<!-- BEGIN: crow -->
				<tr>
					<td>{lang}</td>
					<td>
						{comment}
					</td>
				</tr>
				<!-- END: crow -->
			</tbody>
			</table>			
		<!-- END: comments-->
		</td>
    </tr>
	<tr>
    	<td colspan="2"><input type="submit" value="Save" /></td>
    </tr>
</tbody>
</table>
</form>
<!-- END: main -->