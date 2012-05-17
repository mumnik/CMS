<!-- BEGIN: main -->
	
	<div id="page-heading">
		<h1>Cities</h1>
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

					<!-- BEGIN: cities -->
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Title:</a></th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Edit:</a></th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Erase:</a></th>
					</tr>				
					<!-- BEGIN: city -->
					<tr>
						<td>{title}</td>
						<td><a href="index.php?module=cities&action=editcity&cityid={id}" class="icon-1 info-tooltip"></a></td>
						<td><a href="index.php?module=cities&action=erasecity&cityid={id}" class="icon-2 info-tooltip"></a></td>
					</tr>
					<!-- END: city -->
					</table>

					<form method="post" action="index.php?module=cities&action=createcity">
						<table width="100">							
						<tr>
							<td colspan="4">
								<input type="submit" value="Create">
							</td>
						</tr>
						</table>
					</form>
					<!-- END: cities --> 
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