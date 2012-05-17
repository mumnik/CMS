<!-- BEGIN: main -->

	<!-- BEGIN: gselect -->
	<form action="index.php?module=videogallery" method="post">
		<select name="galleryid">
			<option value="0"><!portfolio></option>
			<!-- BEGIN: option -->
			<option value="{galleryid}" {selected}>{title}</option>
			<!-- END: option -->		
		</select>
		<input type="submit" value="Go" />
	</form>
	<!-- END: gselect -->
	
	<!-- BEGIN: gallerytitleslist-->
	<form action="index.php?module=videogallery" method="post">		
		<input type="hidden" name="galleryid" value="{current_galleryid}" /><br />
		<input type="hidden" name="action" value="editvideogallery"  /><br />		
	Module:	<select name="module" disabled="disabled">
			<option {selected} value="">Choose module</option>
			<!-- BEGIN: module-->
				<option {selected} value="{module}">{title}</option>
			<!-- END: module-->
		</select><br />		
		<input type="submit" value="Change"  disabled="disabled"/>
	</form>
	<!-- END: gallerytitleslist-->
	
	<form action="index.php?module=newvideogallery" method="post">
		<input type="submit" value="New" />
	</form>

	
	<!-- BEGIN: uploadpics -->
	<br />
	<form enctype="multipart/form-data" action="index.php" method="post">	
	<table class="tableinfo">
	<tbody>
		<tr class="header">
			<td>
				Video url
			</td>
            <td>
            	Description
            </td>
			<td>
            	Preview
            </td>
            <td>
				Index
			</td>
			<td>
				enter
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="galleryid" value="{current_galleryid}" />
				<input type="hidden" name="action" value="addvideo" />
				<input type="text" name="video[url]" size="50" />
			</td>
            <td>
            	<input type="text" name="video[text]" value="" />
            </td>
            <td>
            	<input type="file" name="uploadedfile" value="" />
            </td>
			<td>
				<input type="text" name="video[index]" maxlength="4" size="4" value="0"/>
			</td>
			<td>
				<input type="submit" value="Save" />
			</td>
		</tr>
	</tbody>
	</table>
	</form>
	<!-- END: uploadpics -->

	<!-- BEGIN: pics -->
	<br />
		<table class="tableinfo">
			<tr>
			<!-- BEGIN: prow -->
				<td align="center" class="border">
					{url}<br />
                    <center>{text}</center><br />
                    <input type="text" value="{url_}"  size="50"/>
					<form action="index.php" method="post" id="delete-{videoid}">
						<input type="hidden" name="action" value="deletevideo">
						<input type="hidden" name="galleryid" value="{current_galleryid}">
						<input type="hidden" name="videoid" value="{videoid}">
						<input type="submit" onClick="javascript: if (!confirm('Are you sure?')){ return false; }" value="Delete">
                    </form>
					
				</td>
				{linebreak}
			<!-- END: prow -->
			</tr>
		</table>	
		
		
	<!-- END: pics -->
<!-- END: main -->