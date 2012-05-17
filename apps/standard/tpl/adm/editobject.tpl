<!-- BEGIN: main -->
	
	<div id="page-heading">
		<h1>Edit/Create Object</h1>
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
				
				<form method="post" action="index.php?module=objects&action=processedit&id={data.id}">						
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Title:</a></th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Language:</a></th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Data:</a></th>
					</tr>
					<tr>
						<td>ID:</td>
						<td></td>
						<td>{data.id}</td>
					</tr>
					<tr>
						<td>Type:</td>
						<td></td>
						<td>
							<select name="data[objecttype]">
								{typeoptions}
							</select>
						</td>
					</tr>
					<!-- BEGIN: description -->
					<tr>
						<td>Description: </td>
						<td>{language}</td>
						<td><textarea rows="5" cols="40" name="data[description][{lang}]">{description}</textarea></td>						
					</tr>
					<!-- END: description -->
					<tr>
						<td>
							City:
						</td>
						<td>
						</td>
						<td>
							<select name="data[cityid]">
								{cityoptions}
							</select>
						</td>
					</tr>
					<!-- BEGIN: street -->
					<tr>
						<td>Street:</td>
						<td>{language}</td>
						<td><input type="text" name="data[street][{lang}]" value="{street}"></td>						
					</tr>
					<!-- END: street -->
					<tr>
						<td>Housenumber: </td>
						<td>&nbsp;</td>
						<td>
							<input type="text" name="data[housenumber]" value="{data.housenumber}">
						</td>	
					</tr>
					<tr>
						<td>Rooms: </td>
						<td>&nbsp;</td>
						<td>
							<input type="text" name="data[rooms]" value="{data.rooms}">
						</td>	
					</tr>
					<tr>
						<td>Square: </td>
						<td>&nbsp;</td>
						<td>
							<input type="text" name="data[square]" value="{data.square}">
						</td>	
					</tr>
					<tr>
						<td>Floor: </td>
						<td>&nbsp;</td>
						<td>
							<input type="text" name="data[floor]" value="{data.floor}">
						</td>	
					</tr>
					<tr>
						<td>Series: </td>
						<td>&nbsp;</td>
						<td>
							<select name="data[series]">
								<option>-----</option>
								{seriesoptions}
							</select>
						</td>	
					</tr>
					<tr>
						<td>House type: </td>
						<td>&nbsp;</td>
						<td>
							<select name="data[htype]">
								<option>-----</option>
								{htypeoptions}
							</select>
						</td>	
					</tr>
					<tr>
						<td>Price: </td>
						<td>&nbsp;</td>
						<td>
							<input type="text" name="data[price]" value="{data.price}">
						</td>	
					</tr>
					</table>
					<input type="submit" value="Save">
				</form>					
				
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