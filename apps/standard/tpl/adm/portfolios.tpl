<!-- BEGIN: main -->
<script language="javascript">
	function changeportfoliostat(portfolioid){
		var stat = document.getElementById('stat_'+portfolioid).checked;
		var obj=document.createElement('form');
		obj.setAttribute('method', 'post');
		obj.setAttribute('action', 'index.php');

		var module=document.createElement('input');
		module.setAttribute('type', 'hidden');
		module.setAttribute('name', 'module');
		module.setAttribute('value','{GL.module}');
		obj.appendChild(module);

		var action=document.createElement('input');
		action.setAttribute('type', 'hidden');
		action.setAttribute('name', 'action');
		action.setAttribute('value','changeportstat');
		obj.appendChild(action);
		
		var mode=document.createElement('input');
		mode.setAttribute('type', 'hidden');
		mode.setAttribute('name', 'active');		
		mode.setAttribute('value', (stat==true)?'1':'0');
		obj.appendChild(mode);
		
		var id=document.createElement('input');
		id.setAttribute('type', 'hidden');
		id.setAttribute('name', 'portfolioid');
		id.setAttribute('value', portfolioid);
		
		obj.appendChild(id);
		document.getElementById('modformdiv').appendChild(obj);
		obj.submit();
	}
	
	function eraseportfolio(portfolioid){
		answer = confirm("Are you sure?");
		if (answer){
			obj=document.createElement('form');
			obj.setAttribute('method', 'post');
			obj.setAttribute('action', 'index.php?module={GL.module}');

			id = document.createElement('input');
			id.setAttribute('name', 'portfolioid');
			id.setAttribute('type', 'hidden');
			id.setAttribute('value', portfolioid);
			
			action = document.createElement('input');
			action.setAttribute('type', 'hidden');
			action.setAttribute('name', 'action');
			action.setAttribute('value', 'eraseportfolio');
			obj.appendChild(id);
			obj.appendChild(action);
			document.getElementById('modformdiv').appendChild(obj);
			obj.submit();
		}
	}
	
	function editportfolio(portfolioid){
		obj=document.createElement('form');
		obj.setAttribute('method', 'post');
		obj.setAttribute('action', 'index.php');
		id = document.createElement('input');
		id.setAttribute('name', 'portfolioid');
		id.setAttribute('type', 'hidden');
		id.setAttribute('value', portfolioid);
		
		action = document.createElement('input');
		action.setAttribute('type', 'hidden');
		action.setAttribute('name', 'module');
		action.setAttribute('value', 'editportfolio');
		
		portfoliotype = document.createElement('input');
		portfoliotype.setAttribute('type', 'hidden');
		portfoliotype.setAttribute('name', 'portfoliotype');
		portfoliotype.setAttribute('value', '{portfoliotype}');
		
		obj.appendChild(id);
		obj.appendChild(action);
		obj.appendChild(portfoliotype);
		document.getElementById('modformdiv').appendChild(obj);
		obj.submit();
	}
</script>
	<!-- BEGIN: table -->
<table>
    <tr>
		<td colspan="9" align="center">
			<br /><div style="display:block; width:70px; height:25px; background-color:#5ab7ed;">
				<a class="button" href="index.php?module=editportfolio&portfoliotype={portfoliotype}">Create</a>
			</div><br />
		</td>

	</tr>
</table>
	<table cellpadding="0" cellspacing="0" class="listing" width="100%">
	<tbody>

		<tr class="header">
			<th><!active></th>
			<th><!surename></th>
			<th><!name></th>
			<th><!model></th>
			<!-- <td><!phone></th> -->
			<th><!portfolio></th>
		           <th><!edit></th>          
			<th>Erase</th>
	</tr>
	<!-- BEGIN: row -->
	<tr>
		<td align="center">		
			<input type="checkbox" {active_checked} onclick="javascript: changeportfoliostat('{portfolioid}');" id="stat_{portfolioid}" />
		</td>
		<td>{surname}</td>
		<td>{name}</td>
		<td><img src="{mainpic}" /></td>
		<!-- <td>{phone}</td>-->
		<td>
			<a href="index.php?module=portfolios&portfolioid={portfolioid}"><!portfolio></a>
		</td>
		<td><a href="javascript: editportfolio('{portfolioid}');"><img height="16" width="16" alt="" src="{GL.base}/img/edit-icon.gif"/></a></td>
		<td><a href="javascript: eraseportfolio('{portfolioid}');"><img height="16" width="16" alt="" src="{GL.base}/img/hr.gif"/></a></td>
	</tr>
	<!-- END: row -->
	</tbody>
	</table>
	<!-- END: table -->
	<div id="modformdiv"></div>
<!-- END: main -->