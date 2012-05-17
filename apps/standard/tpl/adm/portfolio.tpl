<!-- BEGIN: main -->	
	<!-- BEGIN: uploadpics -->
	<form enctype="multipart/form-data" action="index.php" method="post">	
	<table class="tableinfo">
	<tbody>
		<tr class="header">
			<td>
				Upload image
			</td>
            <td>
            	URL
            </td>
            <td>
            	Description
            </td>
			<td>
				Index
			</td>
            <td>
            	Main
            </td>
			<td>&nbsp;
				
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="portfolioid" value="{portfolioid}" />
				<input type="hidden" name="action" value="uploadimage" />
				<input type="file" name="uploadedfile" size="30" />
			</td>
            <td>
            	<input type="text" name="url" value=""  />
            </td>
            <td>
            	<input type="text" name="text" value="" />
            </td>
			<td>
				<input type="text" name="index" maxlength="4" size="4" value="0"/>
			</td>
            <td>
            	<input type="checkbox" name="main" />
            </td>
			<td>
				<input type="submit" value="upload" />
			</td>
		</tr>
	</tbody>
	</table>
	</form>
	<!-- END: uploadpics -->

	<!-- BEGIN: pics -->
	<br />
		<table class="tableinfo">
			<tr>
			<!-- BEGIN: prow -->
				<td align="center" class="border">
					<img src="{GL.base}/gallery/thumbs/{file}"><br />
                    {main}<br />
                    {index}<Br />
                    {text}
					<form action="index.php" method="post" id="delete-{file}">
						<input type="hidden" name="action" value="deleteimage">
						<input type="hidden" name="portfolioid" value="{portfolioid}">
						<input type="hidden" name="imageid" value="{imageid}">
					</form>
					<input type="button" onClick="javascript: if (confirm('Are you sure?')){ document.getElementById('delete-{file}').submit();}" value="Delete">
				</td>
				{linebreak}
			<!-- END: prow -->
			</tr>
		</table>	
		
		
	<!-- END: pics -->
<!-- END: main -->