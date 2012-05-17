<!-- BEGIN: main -->
<form action="index.php" method="post">
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
    	<td><!active></td>
    	<td><input type="checkbox" name="model[active]" {model_active} /></td>
    </tr>
	<tr>
    	<td><!name></td>
    	<td><input type="text" name="model[name]" value="{model_name}" /></td>
    </tr>
	<tr>
    	<td><!surename></td>
    	<td><input type="text" name="model[surename]" value="{model_surename}" /></td>
    </tr>
<!-- BEGIN: models -->
	<tr>
    	<td><!age></td>
    	<td><input type="text" name="model[age]" value="{model_age}" /></td>
    </tr>
	<tr>
    	<td><!height></td>
    	<td><input type="text" name="model[height]" value="{model_height}" /></td>
    </tr>
	<tr>
    	<td><!size_top></td>
    	<td><input type="text" name="model[size_top]" value="{model_size_top}" /></td>
    </tr>
	<tr>
    	<td><!size_mid></td>
    	<td><input type="text" name="model[size_mid]" value="{model_size_mid}" /></td>
    </tr>
	<tr>
    	<td><!size_bot></td>
    	<td><input type="text" name="model[size_bot]" value="{model_size_bot}" /></td>
    </tr>
	<tr>
    	<td><!size_shoe></td>
    	<td><input type="text" name="model[size_shoe]" value="{model_size_shoe}" /></td>
    </tr>
	<tr>
    	<td><!color_eyes></td>
    	<td><input type="text" name="model[color_eyes]" value="{model_color_eyes}" /></td>
    </tr>
	<tr>
    	<td><!color_hair></td>
    	<td><input type="text" name="model[color_hair]" value="{model_color_hair}" /></td>
    </tr>
	<tr>
    	<td><!langs></td>
    	<td><input type="text" name="model[langs]" value="{model_langs}" /></td>
    </tr>
	<tr>
    	<td><!country></td>
    	<td><input type="text" name="model[country]" value="{model_country}" /></td>
    </tr>
	<tr>
    	<td><!city></td>
    	<td><input type="text" name="model[city]" value="{model_city}" /></td>
    </tr>
<!-- END: models -->
	<tr>
    	<td><!phone></td>
    	<td><input type="text" name="model[phone]" value="{model_phone}" /></td>
    </tr>
	<tr>
    	<td><!email></td>
    	<td><input type="text" name="model[email]" value="{model_email}" /></td>
    </tr>
	<tr>
    	<td><!portfolio_attachment></td>
    	<td>
			<input name="model[portfolio_file]" size="30" type="file" />
			<!-- BEGIN: attachment -->
				<a href="/attachments/{portfolio_file}" >{portfolio_file}</a>
				<input type="submit" value="delete_attachment" name="Delete">
			<!-- END: attachment -->

		</td>
    </tr>
	<tr>
    	<td><!comment></td>
    	<td>
			<textarea cols="40" rows="10" name="model[comment]">{model_comment}</textarea>
		</td>
    </tr>
	<tr>
    	<td colspan="2"><input type="submit" value="Save" /></td>
    </tr>
</tbody>
</table>
</form>
<!-- END: main -->