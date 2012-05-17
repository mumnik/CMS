<!-- BEGIN: main -->
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
					<!-- BEGIN: saunas -->	
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<!--<th class="table-header-check"><a id="toggle-all" ></a></th>-->
						
						<th class="table-header-repeat line-left minwidth-1"><a href="">Title</a></th>
						<th class="table-header-repeat line-left minwidth-4"><a href="">Images</a></th>
						<th class="table-header-repeat line-left minwidth-2"><a href="">Edit</a></th>
						<th class="table-header-repeat line-left minwidth-2" ><a href="">Erase</a></th>
					</tr>    
				<!-- BEGIN: sauna -->
					<tr>
						<td>{title}</td>                
						<td>
							<a href="index.php?module={adminmodule}&action=images&nookid={nookid}"><!portfolio></a>
						</td>
						<td>
							<a href="index.php?module={adminmodule}&action=edit&nookid={nookid}"><img src="images/shared/pencil_icon.png" alt="Edit module" title="Edit module"></a>
						</td>
						<td>
							<a href="index.php?module={adminmodule}&action=erase&nookid={nookid}"><img height="16" width="16" alt="" src="{GL.base}/img/hr.gif"/></a>
						</td>
					</tr>
				<!-- END: sauna -->
					</table>
				</div>
			</div>
		</td>
	</tr>
	</table>
	<!-- END: saunas -->	
	<table>
        <tr>
            <td colspan="5" align="center"><br /><br />
                <div style="display:block; width:70px; height:25px;">
					<form action="index.php" method="get">
					<input type="hidden" value="create" name="action">
					<input type="hidden" value="{adminmodule}" name="module">
						<table width="100">
							<tr>
								<td align="center">						
									<input type="submit" value="Create" style="display:block; width:73px; height:29px" />						
								</td>
							</tr>
						</table>
					</form>
                </div>
            </td>
		</tr>
    </table>    
    <div id="modformdiv"></div>
<!-- END: main -->