<!-- BEGIN: main -->
	
	<div id="page-heading">
		<h1>Edit/Create District</h1>
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
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
				<!-- BEGIN: district -->
				<form method="post" action="index.php?module=districts&action=processeditdistrict&districtid={id}">						
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Title:</a></th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Language:</a></th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Data:</a></th>
					</tr>
					<tr>
						<td>ID</td>
						<td></td>
						<td>{id}</td>
					</tr>
					<!-- BEGIN: title -->
					<tr>
						<td>Title</td>
						<td>{language}</td>
						<td><input type="text" name="data[title][{language}]" value="{title}"></td>						
					</tr>
					<!-- END: title -->
					</table>
					<input type="submit" value="Save">
				</form>					
				<!-- END: district --> 
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