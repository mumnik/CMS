<!-- BEGIN: main -->
    <!-- BEGIN: products -->	
        <table class="listing">
        <tr>
        	<td>
            	Title:
            </td>
            <td>
            	Price:
            </td>
            <Td>
            	Portfio:
            </Td>
            <td>
            	Edit:
            </td>
            <td>
            	Erase:
            </td>
        </tr>
        <!-- BEGIN: product -->
            <tr>
                <td>{title}</td>
                <td>{price}</td>
                <td><a href="index.php?module=products&action=images&nookid={nookid}"><!portfolio></a></td>
                <td><a href="index.php?module=products&action=editproduct&nookid={nookid}"><img height="16" width="16" alt="" src="{GL.base}/img/edit-icon.gif"/></a></td>
					<td><a href="index.php?module=products&action=eraseproduct&nookid={nookid}"><img height="16" width="16" alt="" src="{GL.base}/img/hr.gif"/></a></td>
            </tr>
        <!-- END: product -->
</table>
<!-- END: products -->	
<table>
        <tr>
            <td colspan="5" align="center"><br /><br />
                <div style="display:block; width:70px; height:25px; background-color:#5ab7ed;">
                    <a class="button" href="index.php?module=products&action=editproduct&nookid=">Create</a>
                </div>
            </td>
		</tr>
        </table>
    
    <div id="modformdiv"></div>
<!-- END: main -->