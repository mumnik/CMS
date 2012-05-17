<!-- BEGIN: main -->
<script type="text/javascript" src="{GL.base}/js/tinymce/tiny_mce.js"></script>
<script type="text/JavaScript" src="{GL.base}/js/scw.js"></script>
<form action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="saveteam" />
<input type="hidden" name="portfolioid" value="{portfolioid}" />
<input type="hidden" name="model[type]" value="{portfoliotype}" />
<table class="tableinfo">
<tbody>	
	<tr>
		<td><!index>:</td>
		<td>
			<input type="text" name="model[index]" value="{index}" />
		</td>
	</tr>
	<tr>
    	<td>Name : </td>
    	<td><input type="text" name="model[name]" value="{name}" /></td>
    </tr>
	<tr>
    	<td>Surname: </td>
    	<td><input type="text" name="model[surname]" value="{surname}" /></td>
    </tr>
    <tr>
    	<td>Role: </td>
    	<td><input type="text" name="model[role]" value="{role}" /></td>
    </tr>
	<tr>
    	<td>Facebook: </td>
    	<td><input type="text" name="model[facebook]" value="{facebook}" /></td>
    </tr>	
	<tr>
    	<td>LinkedIn/URL:</td>
    	<td><input type="text" name="model[linkedin]" value="{linkedin}" /></td>
    </tr>
    <tr>
    	<td>Skype:</td>
    	<td><input type="text" name="model[skype]" value="{skype}" /></td>
    </tr>
	<tr>
    	<td>Phone:</td>
    	<td><input type="text" name="model[phone]" value="{phone}" /></td>
    </tr>

	<tr>
    	<td>Email:</td>
    	<td><input type="text" name="model[email]" value="{email}" /></td>
    </tr>	
    <tr>
    	<td>Note</td>
        <td><textarea name="model[note]">{note}</textarea></td>
    </tr>
     <tr>
    	<td>Note2</td>
        <td><textarea name="model[note2]">{note2}</textarea></td>
    </tr>
	<tr>
    	<td>Active:</td>
    	<td><input type="checkbox" name="model[active]" {active_checked} value="1" /></td>
    </tr>	
	<tr>
    	<td colspan="2" align="center">
			<br />
			<input type="submit" value="Save" />
			<br /><br />
		</td>
    </tr>
</tbody>
</table>
</form>
<!-- END: main -->