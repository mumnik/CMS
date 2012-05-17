<!-- BEGIN: main -->
<form method="post" action="index.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="addcountry">
    <table>
    <tr>
    	<td>
        	Type:
        </td>
        <td>
            <select name="country[type]">
                <option value="international">International</option>
                <option vakue="usa">USA</option>
            </select>
        </td>
    </tr>
    <tr>
    	<td>
        	Title:
        </td>
        <td>
            <input type="text" name="country[title]" />
        </td>
    </tr>
    <tr>
    	<td>
        	Flag:
        </td>
        <td>
            <input type="file" name="flag">
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        	<input type="submit" value="Save">
        </td>
    </tr>
    </table>
</form>
    <br>
    <!-- BEGIN: countries -->
    <table>
        <!-- BEGIN: country -->
            <tr>
                <td>
                    {title}
                </td>
                <td width="50px">
                    <img src="{GL.base}/gallery/flags/{flag}" />
                </td>
                <td>
                	<form method="post" action="index.php" name="frm_{id}">  
                    	<input type="hidden" name="action" value="savecountry" />
                		<input type="hidden" name="country[id]" value="{id}" />
                        <select name="country[type]" onChange="document.frm_{id}.submit();">
                            <option value="international" {international_select}>International</option>
                            <option value="usa" {usa_select}>USA</option>
                        </select>
                    </form>
                </td>                
                <td>
                	<form method="post" action="index.php">
                    	<input type="hidden" name="action" value="erasecountry">
                        <input type="hidden" name="country[id]" value="{id}">
                        <input type="hidden" name="action" value="erasecountry">
						<input type="submit" value="Erase" onClick="javascript: if (!confirm('Are you sure?')){ return false; }"> 
                    </form>
                </td>
                
            </tr>
        <!-- END: country -->
    </table>
    <!-- END: countries -->


<!-- END: main -->