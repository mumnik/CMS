<!-- BEGIN: main -->

	<!-- BEGIN: playerslist -->
	

	<table cellpadding="0" cellspacing="0" class="listing">
	<tbody>
	<tr class="header">
	
		<th>Name</th>
		<th>Gallery</th>
		<th>Edit</th>
        <th>Delete</th>
	</tr>
	<!-- BEGIN: player -->
	<tr>
	
		<td>
            {name}
        </td>
		<td>
        	<a href="index.php?module=player&action=images&nookid={nookid}"><!portfolio></a>
		</td>
		<td>
            <a href="index.php?module=player&action=editplayer&nookid={nookid}">en</a>
		</td>
		<td><a href="index.php?module=player&action=eraseplayer&nookid={nookid}"><img height="16" width="16" alt="" src="{GL.base}/img/hr.gif"/></a></td>

	</tr>		
	<!-- END: player -->	
	</tbody>
	</table>
	<!-- END: playerslist -->

	<table>
    <tbody>
    <tr>
        <td align="center" colspan="7">
            <div style="display: block; width: 70px; height: 25px; background-color: rgb(90, 183, 237);">
                            <a class="button" href="index.php?module=player&action=editplayer">Create</a>            
            </div>
        </td>
    </tr>
    </tbody>
    </table>



	
	
<!-- END: main -->