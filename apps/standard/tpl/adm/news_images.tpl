<!-- BEGIN: main -->

<div id="page-heading">
	<h1>Edit gallery</h1>
</div>

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
		<!--  start content-table-inner -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
   

					<form enctype="multipart/form-data" action="index.php?module=news&action=uploadimage" method="post">	
					<table class="tableinfo">
					<tbody>
						<tr class="header">
							<td>
								Upload image
							</td>
				<!--            <td>
								URL
							</td> -->
				<!--            <td>
								Description
							</td> -->
				<!-- 			<td>
								Index
							</td> -->
							<td>
								Main
							</td>
							<td>
								enter
							</td>
						</tr>
						<tr>
							<td>
								<input type="hidden" name="nookid" value="{storeddata_nookid}" />				
								<input type="file" name="uploadedfile" size="30" />
							</td>
						   <!-- <td>
								<input type="text" name="url" value=""  />
							</td> -->
							<td>
				<!--            	<input type="text" name="text" value="" />
							</td>-->
							<td>
								<input type="text" name="index" maxlength="4" size="4" value="0"/>
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
	
    
  

					<!-- BEGIN: pics -->
					<br />
						<table class="tableinfo">
							<tr>
							<!-- BEGIN: prow -->
								<td align="center" class="border">
									<div style="height:120px">
										<a href="{GL.base}/gallery/original/{file}" target="_blank"><img src="{GL.base}/gallery/thumbs/{file}" alt="{index}" border="0"/></a>
									</div>
									<br />Index: {index} <br/>
									Main: {main}<br />
									<form action="index.php?module={module}&action=eraseimage" method="post">
										<input type="hidden" name="returnnookid" value="{storeddata_nookid}">
										<input type="hidden" name="file" value="{file}">
										<input type="hidden" name="nookid" value="{nookid}">
										<input type="submit"  value="Delete" onClick="javascript: if (!confirm('Are you sure?')){ return false; }">
									</form>
									<!-- onClick="javascript: if (!confirm('Are you sure?')){ return false; }" -->
								</td>
								{1linebreak}
							<!-- END: prow -->
							</tr>
						</table>			
					<!-- END: pics -->
					

			</div>
			
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
  
    
<!-- END: main -->