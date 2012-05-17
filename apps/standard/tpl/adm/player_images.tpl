<!-- BEGIN: main -->
	
   
	<br />
	<form enctype="multipart/form-data" action="index.php?module={GL.module}&action=uploadimage" method="post">	
	<table class="tableinfo">
	<tbody>
		<tr class="header">
			<td>
				Upload image
			</td>
<!--            <td>
            	URL
            </td> -->
<!--            <td>
            	Description
            </td> -->
<!-- 			<td>
				Index
			</td> -->
            <td>
            	Main
            </td>
			<td>
				enter
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="nookid" value="{storeddata_nookid}" />				
				<input type="file" name="uploadedfile" size="30" />
			</td>
           <!-- <td>
            	<input type="text" name="url" value=""  />
            </td> -->
            <td>
<!--            	<input type="text" name="text" value="" />
            </td>-->
			<td>
				<input type="text" name="index" maxlength="4" size="4" value="0"/>
			</td> 
            <td>
				<input type="checkbox" name="main" value="1" />
			</td>
			<td>
				<input type="submit" value="upload" />
			</td>
		</tr>
	</tbody>
	</table>
	</form>
	
    
  

	<!-- BEGIN: pics -->
	<br />
		<table class="tableinfo">
			<tr>
			<!-- BEGIN: prow -->
				<td align="center" class="border">
					<div style="height:80px">
                        <a href="{GL.base}/gallery/original/{file}" target="_blank"><img src="{GL.base}/gallery/adminthumbs/{file}" alt="{index}" border="0"/></a>
                    </div>
					<br />Index: {index} ; {main}<br />
					<form action="index.php?module={GL.module}&action=eraseimage" method="post">
						<input type="hidden" name="returnnookid" value="{storeddata_nookid}">
						<input type="hidden" name="file" value="{file}">
						<input type="hidden" name="nookid" value="{nookid}">
						<input type="submit"  value="Delete" onClick="javascript: if (!confirm('Are you sure?')){ return false; }">
                    </form>
					<!-- onClick="javascript: if (!confirm('Are you sure?')){ return false; }" -->
				</td>
				{1linebreak}
			<!-- END: prow -->
			</tr>
		</table>			
	<!-- END: pics -->
    
  
    
<!-- END: main -->