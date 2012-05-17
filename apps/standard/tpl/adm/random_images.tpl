<!-- BEGIN: main -->

	<!-- BEGIN: uploadpics -->
	<br />
	<form enctype="multipart/form-data" action="index.php" method="post">	
	<table class="tableinfo">
	<tbody>
		<tr class="header">
			<td>
				Upload image
			</td>
			<td>
				enter
			</td>
		</tr>
		<tr>
			<td>				
				<input type="hidden" name="action" value="uploadrandimage" />
				<input type="file" name="uploadedfile" size="30" />
			</td>		
			<td>
				<input type="submit" value="upload" />
			</td>
		</tr>
	</tbody>
	</table>
	</form>
	<!-- END: uploadpics -->

	<!-- BEGIN: images -->
	<br />
		<table class="tableinfo"  border="1">
			<!-- BEGIN: image -->
			<tr>

				<td align="center" class="border">
					<img src="{GL.base}/gallery/randimages/{file}" alt="{imageid}" />
					<br />{index} {main}
					<form action="index.php" method="post" id="delete_{imageid}">
						<input type="hidden" name="action" value="deleteimage">					
						<input type="hidden" name="file" value="{file}">
						<input type="hidden" name="imageid" value="{imageid}">
						<input type="hidden" name="module" value="{GL.module}">
					</form>
					<input type="button" onClick="javascript: if (confirm('Are you sure?')){ document.getElementById('delete_{imageid}').submit();}" value="Delete">
				</td>
				{linebreak}

			</tr>
			<!-- END: image -->
		</table>			
	<!-- END: images -->
<!-- END: main -->