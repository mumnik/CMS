<!-- BEGIN: main -->
	<table>
		<tbody>
	<!-- BEGIN: gselect -->
			<tr>
				<td><!{portfolio_name}>:</td>
				<td>
					<form action="index.php" method="post">
						<input type="hidden" name="module" value="portfolios" />

						<select name="portfolioid" onChange="javascript: submit();">
							<option value="0"><!select_portfolio></option>
							<!-- BEGIN: option -->
							<option value="{portfolioid}" {selected}>{surename}, {name}</option>
							<!-- END: option -->
						</select>
					</form>
				</td>
			</tr>
	<!-- END: gselect -->
		</tbody>
	</table>


	
	<!-- BEGIN: uploadpics -->
	<h2>{surename} {name} </h2>
	<form enctype="multipart/form-data" action="index.php" method="post">	
	<table class="tableinfo">
	<tbody>
		<tr class="header">
			<td>
				Upload image
			</td>
			<td>
				Index
			</td>
			<td>
				Main
			</td>
			<td>
				enter
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="portfolioid" value="{current_portfolioid}" />
				<input type="hidden" name="action" value="uploadimage" />
				<input type="file" name="uploadedfile" size="30" />
			</td>
			<td>
				<input type="text" name="index" maxlength="4" size="4" value="0" />
			</td>
			<td>
				<input type="checkbox" name="main" value="1" />
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
					<a href="{GL.base}/gallery/original/{file}" target="_blank"><img src="{GL.base}/gallery/icons_72/{file}" alt="{index}" border="0"/></a>
					<br />{index} {main}
					<form action="index.php" method="post" id="delete_{imageid}">
						<input type="hidden" name="action" value="deleteimage">
						<input type="hidden" name="portfolioid" value="{current_portfolioid}">
						<input type="hidden" name="file" value="{file}">
						<input type="hidden" name="imageid" value="{imageid}">
						<input type="hidden" name="module" value="{GL.module}">
					</form>
					<input type="button" onClick="javascript: if (confirm('Are you sure?')){ document.getElementById('delete_{imageid}').submit();}" value="Delete">
				</td>
				{linebreak}
			<!-- END: prow -->
			</tr>
		</table>	
		
		
	<!-- END: pics -->
<!-- END: main -->