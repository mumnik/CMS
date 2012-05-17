<!-- BEGIN: main -->
	<script>
		function pathsubmit(f){
			document.getElementById('pathtogo').value+=f;
			document.frmgo.submit();
		}
	</script>
	
	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Upload</h1>
	</div>
	<!-- end page-heading -->
	
	<!-- BEGIN: table -->
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
			<!--  start content-table-inner ...................................................................... START -->
			<div id="content-table-inner">

				<!--  start table-content  -->
				<div id="table-content">			

					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr class="header">
						<td colspan="4">{path}</td>
					</tr>
					<!-- BEGIN: row -->
					<tr>
						<td>{href}</td>				
						<td>{size}</td>
						<td>{delete}</td>
						<td>{rename}</td>			
					</tr>
					<!-- END: row -->
					<tr>
						<td colspan="4">
							<div style="display:none" id="makedir">
								<form action="index.php?module=makedir" method="post">
									<input type="hidden" name="path" value="{path}">
									Directory name:<input type="text" name="filename">
									<input type="submit" value="OK">
								</form>
								<input type="button" onclick="javascript: document.getElementById('makedir').style.display='none';" value="Cancel">
							</div>			
							<div id="uploadfile" style="display:none">
								<form action="index.php?module=uploadfile" method="post" enctype="multipart/form-data">
									<input type="hidden" name="path" value="{path}">
									Browse:<input type="file" name="filename">
									<input type="submit" value="OK">
								</form>
								<input type="button" onclick="javascript: document.getElementById('uploadfile').style.display='none';" value="Cancel">			
							</div>		
						</td>
					</tr>
					<tr>
						<td>
							<input type="button" onclick="javascript: document.getElementById('makedir').style.display='block';" value="New directory">
						</td>
						<td>
							<input type="button" onclick="javascript: document.getElementById('uploadfile').style.display='block';" value="Upload">
						</td>
					</tr>
					</table>
				
				</div>
				<!--  end table-content  -->
		
				<div class="clear"></div>
		 
			</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>
		

	<!-- END: table -->
	<form action="index.php?module=uploads" name="frmgo" method="post">
		<input type="hidden" name="path" id="pathtogo" value="{path}/">
	</form>
<!-- END: main -->