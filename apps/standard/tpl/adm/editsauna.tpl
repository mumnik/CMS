<!-- BEGIN: main -->
	<script type="text/javascript" src="{GL.base}/js/ckeditor/ckeditor.js"></script>

	<div id="page-heading">
		<h1>Sauna</h1>
	</div>

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
		<tr>
			<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
			<th class="topleft"></th>
			<td id="tbl-border-top">&nbsp;</td>
			<th class="topright"></th>
			<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
		</tr>
		<tr class="header">
			<td id="tbl-border-left"></td>
			<td>				
				<div id="content-table-inner">				
					<div id="table-content">
						<form method="post" action="index.php?module={adminmodule}&action=save">
							<input type="hidden" name="nookid" value="{storeddata_nookid}">
							<!-- BEGIN: fields -->
							<table border="0"  cellpadding="0" cellspacing="0" id="product-table" style="800px;">
								<tr>
									<td style="width: 120px;">
										<h1>Item:</h1>
									</td>
									<td  style="width: 80px;">
										<h1>Language:</h1>
									</td>
									<td style="width: 420px;">
										<h1>Input:</h1>
									</td>
								</tr>			
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
								<tr>
									<td colspan="3" align="center">
										<input type="submit" value="Save" />
									</td>
								</tr>
							</table>
							<!-- END: fields -->
						</form>    
					</div>
				</div>
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
	<script>
		CKEDITOR.replaceAll(
			{
				height: '200',
				contentsCss : '{GL.base}/css/style.css',
				filebrowserBrowseUrl : '{GL.base}/js/ckfinder/ckfinder.html',
				filebrowserFlashBrowseUrl : '{GL.base}/js//ckfinder/ckfinder.html?Type=Flash',
				filebrowserUploadUrl : '{GL.base}/js//ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				filebrowserImageUploadUrl : '{GL.base}/js//ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				filebrowserFlashUploadUrl : '{GL.base}/js//ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
				
			}
		);
	</script>	
<!-- END: main -->