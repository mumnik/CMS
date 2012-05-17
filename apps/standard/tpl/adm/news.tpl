<!-- BEGIN: main -->
<script language="javascript">	
	function erasemodule(module){
		answer = confirm("Are you sure?");
		if (answer){
			obj=document.createElement('form');
			obj.setAttribute('method', 'post');
			obj.setAttribute('action', 'index.php?module=news&action=erasenews&nookid={nookid}');
			document.getElementById('modformdiv').appendChild(obj);
			obj.submit();
		}
	}
</script>

<!--  start page-heading -->
<div id="page-heading">
	<h1>News</h1>
</div>
<!-- end page-heading -->

<!-- BEGIN: newslist -->
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
				<!--  start content-table-inner ...................................................................... START -->
				<div id="content-table-inner">
				
					<!--  start table-content  -->
					<div id="table-content">
					
						<!--  start product-table ................................ -->
						<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
						<tr>
							<th class="table-header-repeat line-left minwidth-1"><a href="">Date</a></th>
							<th class="table-header-repeat line-left minwidth-1"><a href="">Title</a></th>
							<th class="table-header-repeat line-left"><a href="">Gallery</a></th>
							<th class="table-header-repeat line-left"><a href="">Edit</a></th>
							<th class="table-header-repeat line-left"><a href="">Delete</a></th>
						</tr>
					<!-- BEGIN: news -->
						<tr {rowclass}>
							<td>{date}</td>
							<td>{title}</td>
							<td><a href="index.php?module=news&action=images&nookid={nookid}"><!portfolio></a></td>
							<td><a href="index.php?module=news&action=editnews&nookid={nookid}">en</a></td>
							<td><a href="javascript: erasemodule('{module}');" class="icon-2 info-tooltip"></a></td>
						</tr>
					<!-- END: news -->
						</table>
						<!--  end product-table................................... -->

					</div>
					
					<!-- start create module.................. -->
					<form action="index.php?module=news&action=editnews" method="post">
						<table width="100">
							<tr>
								<td align="center">
									<!--<div style="display:block; width:74px; height:30px">-->
										<!--<a class="submit-create" href="index.php?module=createmodule">Create</a>-->
										<input type="submit" value="Create" style="display:block; width:73px; height:29px" />
									<!--</div>-->
								</td>
							</tr>
						</table>
					</form>
					<!--  end create module................ -->
					
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
<!-- END: newslist -->

	<div id="modformdiv"></div>
<!-- END: main -->