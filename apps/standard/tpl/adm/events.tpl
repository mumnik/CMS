<!-- BEGIN: main -->
	<!-- BEGIN: eventslist -->
	

	<table cellpadding="0" cellspacing="0" class="listing">
	<tbody>
	<tr class="header">
		<th>Date</th>
		<th>Time</th>
		<th>Title</th>
		<th>Type</th>
		<th>Edit</th>
                <th>Delete</th>
	</tr>
	<!-- BEGIN: events -->
	<tr>             
		<td>{date}</td>
		<td>{time}</td>
		<td>{title}</td>
		<td>{type}</td>

		<td>
	            <a href="index.php?module=events&action=editevents&nookid={nookid}">en</a>
		</td>
		<td><a href="index.php?module=events&action=eraseevents&nookid={nookid}"><img height="16" width="16" alt="" src="{GL.base}/img/hr.gif"/></a></td>

	</tr>		
	<!-- END: events -->	
	</tbody>
	</table>
	<!-- END: eventlist -->

	<table>
    <tbody>
    <tr>
        <td align="center" colspan="7">
            <div style="display: block; width: 70px; height: 25px; background-color: rgb(90, 183, 237);">
                            <a class="button" href="index.php?module=events&action=editevents">Create</a>            
            </div>
        </td>
    </tr>
    </tbody>
    </table>



	
	
<!-- END: main -->