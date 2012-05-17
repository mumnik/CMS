<!-- BEGIN: main -->
	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Nooks</h1>
	</div>
	<!-- end page-heading -->

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
				
				
					<table border="0" width="30%" cellpadding="0" cellspacing="0" id="product-table">
					<form method="post" action="index.php?module=nooks&action=savenooktype">
						<input type="hidden" name="nookid" value="{nookid}">
					   
						<tr>
							<th class="table-header-repeat line-left minwidth-1"><a href="">Title:</a></th>
							<td colspan="4"><input type="text" name="nook[title]" value="{title}"></td>
						</tr>
						
						<!-- BEGIN: nookfields -->
							<!-- BEGIN: nookfield -->
							<tr>
								<td>
									<input type="text" name="nook[fields][{field}][title]" value="{field}" style="margin-right: 10px;">
								</td>
								<td>
									<select name="nook[fields][{field}][type]" style="margin-right: 10px;">
										{datatypeselectoroptions}
									</select>
								</td>
								<td>
									<input type="text" name="nook[fields][{field}][defaultvalue]" value="{defaultvalue}" style="margin-right: 10px;">
								</td>
								<td>
									<select name="nook[fields][{field}][langdependent]" style="margin-right: 10px;">
										{langdependentselectoroptions}
									</select>
								</td>
								<td>
									<a href="index.php?module=nooks&action=erasenookfield&fieldid={id}"  class="icon-2 info-tooltip"></a>
								</td>
							</tr>
							<!-- END: nookfield -->
						<!-- END: nookfields -->
						<tr>
							<td colspan="5">
								<input type="submit" value="Save">
							</td>
						</tr>	
					</form>
					<tr>
						<td colspan="5">&nbsp;</td>
					</tr>
					<form method="post" action="index.php?module=nooks&action=createnookfield">
						<input type="hidden" name="nookid" value="{nookid}">
						<tr>
							<td>
								<input type="text" name="field[title]" />
							</td>
							<td>
								<select name="field[type]">{datatypeselectoroptionsclean}</select>
							</td>
							<td >
								<input type="text" name="field[defaultvalue]">
							</td>
							<td colspan="2">
								<select name="field[langdependent]">
									{langdependentselectoroptionsclean}
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="5">
								<input type="submit" value="Create">
							</td>
						</tr>
					</form>
					</table>
		
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