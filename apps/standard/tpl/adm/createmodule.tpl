<!-- BEGIN: main -->

<div id="page-heading">
	<h1>Create Module</h1>
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
			
					<form action="index.php" method="post">
					<input type="hidden" name="action" value="proccesscreatemodule" />
					<table border="0" width="30%" cellpadding="0" cellspacing="0" id="id-form">
					<tr>
						<td>Module:</td>
						<td><input type="text" name="newmodule" id="id-form" class="inp-form" value="{nid}"></td>
					</tr>					
					<!-- BEGIN: langtitles -->
						<!-- BEGIN: langtitle -->
							<tr>
								<td>{lang}:</td>
								<td><input type="text" name="title[{lang}]" class="inp-form"></td>
							</tr>
						<!-- END: langtitle -->
					<!-- END: langtitles -->
					<tr>
						<td>Parent</td>
						<td>
						<!-- BEGIN: mselect -->
							<select name="parent" id="d" class="styledselect-day">
								<option value="">-</option>
								<!-- BEGIN: option -->
								<option value="{module}" {selected}>{title}</option>
								<!-- END: option -->
							</select>
						<!-- END: mselect -->
						</td>
					</tr>
					<!-- <tr>
						<td>Order:</td>
						<td><input type="text" name="index" class="inp-form" /></td>
					</tr> -->
					<tr>
						<td colspan="2" align="center">
							<input type="submit" value="OK" style="display:block; width:73px; height:29px">
						</td>
					</tr>
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