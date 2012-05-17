<!-- BEGIN: main -->
	<script>
		function managenewcat(){
			rstat = document.getElementById('newcat').style.display;
			if (rstat=='none'){
				document.getElementById('newcat').style.display='block';
				document.getElementById('newcatbtn').value='Cancel';
			}else if(rstat=='block'){
				document.getElementById('newcat').style.display='none';
				document.getElementById('newcatbtn').value='New';
			}
		}
	</script>
	<!-- BEGIN: partnerscats -->
	<table>
		<tr>
			<td>id</td>
			<!-- BEGIN: langs -->
			<td>{lang}</td>
			<!-- END: langs -->
			<td>&nbsp;
			</td>
		</tr>
		<!-- BEGIN: category -->
		<tr>
			<td>
				{cat_id}
			</td>
			<!-- BEGIN: langs2 -->
			<td>
				{cat_value}
			</td>
			<!-- END: langs2 -->
			<td>
				<form method="post" name="frmcat_{cat_id}">
					<input type="hidden" name="action" value="erasepartnerscat" />
					<input type="hidden" name="id" value="{cat_id}" />
				</form>
				<input type="button" value="Erase" onClick="if (confirm('Are you sure?')){document.frmcat_{cat_id}.submit();}"/>
			</td>
		</tr>
		<!-- END: category -->
	</table>
	<!-- END: partnerscats -->	
	<!-- BEGIN: newcat -->
	<form method="post" id="newcatfrm" name="newcatfrm">
	<input type="hidden" name="action" value="newpartnerscat" />
	<table>
		<tr id="newcat" style="display:none" >			

			<td>
				<input type="text" name="id" />
			</td>
			<!-- BEGIN: langs3 -->
			<td>
				<input type="text" name="titles[{lang}]"/>
			</td>
			<!-- END: langs3 -->
			<td>
				<input type="submit" value="Create">
			</td>
			
		</tr>
	</table>
	</form>
	<input type="button" onclick="javasctipt: managenewcat();" value="New" id="newcatbtn">
	<!-- END: newcat -->

	<!-- BEGIN: table -->
	<table cellpadding="0" cellspacing="0" class="tableinfo">
	<tr class="header">
		<td>Brand</td>
		<td>Company</td>
		<td>Address</td>
		<td>Phones</td>		
		<td>Homepage</td>
		<td>Logo</td>
		<td>Category</td>
		<td>&nbsp;</td>
	</tr>	
		<!-- BEGIN: row -->
		<tr>
			<td>{brand}</td>
			<td>{seller}</td>
			<td>{address}</td>
			<td>{phones}</td>
			<td>{page}</td>
			<td>
				<img src="{logo}" alt="{logo}"/>
			</td>
			<td>
				<form method="post" name="partnercat_{id}">
					<input type="hidden" name="action" value="changepartnercat" />
					<input type="hidden" name="id" value="{id}"
					<select name="category" onChange="javascript: document.partnercat_{id}.submit();">{cat_options}</select>
				</form>
			</td>
			<td>
				<form action="index.php?module=deleteseller" method="post" name="frm{id}erase">
					<input type="hidden" name="id" value="{id}" />
				</form>
				<input type="button" value="Erase" onClick="javascript: if (confirm('Are you sure?')){ document.frm{id}erase.submit();}" />
			</td>
		</tr>
		<!-- END: row -->
	<tr>
		<td colspan="8" align="center">
			<div id="newpartner" style="display:none">		
				<form method="post" action="index.php?module=newseller">
					<table>
					<tr>
						<td>Brands:</td><td><textarea name="brand" id="brand"></textarea></td>
					</tr>
					<tr>
						<td>Seller:</td><td><input type="text" name="seller" id="seller" /></td>
					</tr>
					<tr>				
						<td>Address:</td><td><input type="text" name="address" id="address" /></td>
					</tr>
					<tr>
						<td>Phones:</td><td><input type="text" name="phones" id="phones" /></td>
					</tr>
					<tr>
						<td>URL:</td><td><input type="text" name="page" id="page" /></td>
					</tr>
					<tr>
						<td>Logo:</td><td><input type="text" name="logo" id="logo" /></td>					
					</tr>
					
					</table>
					<input type="submit" value="Create"><input type="hidden" name="lang" value="{lang}" />
				</form>
				<input type="button" value="Cancel" onclick="javascript: document.getElementById('newpartner').style.display='none';document.getElementById('nButton').style.display='block';		document.getElementById('brand').value='';document.getElementById('seller').value=''; document.getElementById('address').value='';document.getElementById('phones').value='';document.getElementById('page').value='';document.getElementById('logo').value='';" />
			</div>
			<div id="nButton" style="display:block">
				<input type="button" value="New" onclick="javascript: document.getElementById('newpartner').style.display='block';document.getElementById('nButton').style.display='none'; ">
			</div>
		</td>
	</tr>
	</table>
	<!-- END: table -->
	
<!-- END: main -->