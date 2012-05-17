<!-- BEGIN: main -->

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Words</h1>
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

				<!-- BEGIN: table -->
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tbody>
				<tr>
					<td colspan="5" align="center">
						Language: <form method="post" action="index.php?module=words">
							<select name="lang">
								{langoptions}
							</select>
							<input type="submit" value="Go">
						</form>
					</td>
				</tr>
				<tr>
					<td colspan="5" align="center">			
							New Word:
					</td>
				</tr>
				<tr>
					<td colspan="5" align="center">			
			<!--		<div id="newword" style="display:none">-->
						<div id="newword">
							<form method="post" action="index.php">
							<input type="hidden" name="action" value="saveword" />
							String:	<input type="text" name="word[string]" id="string">
							Data:	<input type="text" name="word[data]" id="data">
								<input type="hidden" name="word[lang]" value="{lang}">
								<input type="submit" value="Create">
							</form>
							 <input type="button" value="Cancel" onClick="javascript: document.getElementById('word').value='';document.getElementById('data').value=''; document.getElementById('newword').style.display='none';document.getElementById('nbutton').style.display='block';">
						</div>
			<!--
						<div id="nbutton" style="display:block">
							<input type="button" value="New" onClick="document.getElementById('newword').style.display='block';document.getElementById('nbutton').style.display='none';">
						</div>
			-->
						</td>
					</tr>
				
				<tr class="header">
					<td>ID</td>
					<td>String</td>
					<td>Value</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<!-- BEGIN: row -->
				<tr>
					<td>{wordid}</td>
					<td>{string}</td>
					<td>{data}</td>
					<td>{edit}</td>
					<td>
						<form action="index.php" method="post" name="frm{wordid}erase">
							<input type="hidden" name="action" value="deleteword">
							<input type="hidden" name="wordid" value="{wordid}">	
							<input type="hidden" name="lang" value="{lang}">				
						</form>
						<input type="button" value="Erase" onClick="javascript: if (confirm('Are you sure?')){ document.frm{wordid}erase.submit();
						}">
					</td>
				</tr>
				<!-- END: row -->
				</tbody>
				</table>
				<!-- END: table -->
				
			</div>
			<!--  end content-table  -->
			
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