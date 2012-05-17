<!-- BEGIN: main -->

	<!-- BEGIN: articlelist -->
	

	<table cellpadding="0" cellspacing="0" class="listing">
	<tbody>
	<tr class="header">
		<th>Title</th>
		<th>Gallery</th>
		<th>Edit</th>
        <th>Delete</th>
	</tr>
	<!-- BEGIN: article -->
	<tr>
		<td>
            {title}

        </td>
		<td>
        	<a href="index.php?module=news&action=images&nookid={nookid}"><!portfolio></a>
		</td>
		<td>
            <a href="index.php?module=news&action=editnews&nookid={nookid}">en</a>
		</td>
		<td><a href="index.php?module=news&action=erasenews&nookid={nookid}"><img height="16" width="16" alt="" src="{GL.base}/img/hr.gif"/></a></td>

	</tr>		
	<!-- END: article -->	
	</tbody>
	</table>
	<!-- END: articlelist -->

	<table>
    <tbody>
    <tr>
        <td align="center" colspan="7">
            <div style="display: block; width: 70px; height: 25px; background-color: rgb(90, 183, 237);">
                            <a class="button" href="index.php?module=articles&action=createarticle">Create</a>            
            </div>
        </td>
    </tr>
    </tbody>
    </table>



	
	
<!-- END: main -->