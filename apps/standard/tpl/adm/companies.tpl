<!-- BEGIN: main -->
<script type="text/javascript" src="{GL.base}/js/tinymce/tiny_mce.js"></script>
    <script type="text/javascript" src="{GL.base}/js/tinymce/plugins/tinybrowser/tb_tinymce.js.php"></script>
    <script language="javascript" type="text/javascript">
      tinyMCE.init({
		    theme : "advanced",
		    mode : "textareas",
		    
		    width : "277",
		    extended_valid_elements : "a[href|target|name]",
		    plugins : "table",
		    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap",	
		    theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
		    debug : false,
			file_browser_callback: "tinyBrowser"
      }); 
	  </script>
	<form method="post" action="index.php" enctype="multipart/form-data">
    	<input type="hidden" name="action" value="createcompany" />
        Title: <input type="text" name="company[title]" />
       	Logo: <input type="file" name="logo" />
        Country: <select name="company[countryid]">
        <!-- BEGIN: countries -->
            <!-- BEGIN: country -->
            <option value="{countryid}" {sel_country}>{countrytitle}</option>
            <!-- END: country -->
        <!-- END: countries -->
        </select>
      <br />
        
        Description: <textarea name="company[description]"></textarea>
        <input type="submit" value="Create" />
    </form>

<hr />
                	Country: <select name="company[countryid]">
                    	<!-- BEGIN: countries2 -->
                        	 <option value="0">Undefined</option>
                            <!-- BEGIN: country -->
                            <option value="{countryid}" {sel_country}>{countrytitle}</option>
                        	<!-- END: country -->
                        <!-- END: countries2 -->
                    </select>


	<!-- BEGIN: companies -->
    	<table>
        <!-- BEGIN: company -->
        	<form name="frm_{id}" method="post" enctype="multipart/form-data">
           		 <input type="hidden" name="companyid" value="{id}" />
            	<input type="hidden" name="action" value="savecompany" />
            <tr>
        		<td>
                	Title: <input type="text" name="company[title]" value="{title}" />
                </td>
                <td>
                	Logo: <img src="{GL.base}/gallery/companylogos/{logo}"><br />
                     <input type="file" name="logo" />
                </td>
                <td>
                	Country: <select name="company[countryid]">
                    	<!-- BEGIN: countries2 -->
                        	 <option value="0">Undefined</option>
                            <!-- BEGIN: country -->
                            <option value="{countryid}" {sel_country}>{countrytitle}</option>
                        	<!-- END: country -->
                        <!-- END: countries2 -->
                    </select>
                </td>
            </tr>
            <tr>   
                <td colspan="3">
                	Description: <textarea name="company[description]" >{description}</textarea>
                </td> 
            </tr>
            <tr>               
                <td colspan="3">
                	<input type="button" value="OK" onclick="javascript: if (confirm('Are you sure?')){ document.frm_{id}.submit(); }" />      
                    </form>                             
               
                	<form method="post" action="index.php" name="frm_{id}_erase">
                    	<input type="hidden" name="action" value="erasecompany">
                        <input type="hidden" name="company[id]" value="{id}">                        
						<input type="submit" value="Erase" onClick="javascript: if (!confirm('Are you sure?')){ return false; }"> 
                    </form>
                </td>
        	</tr>
            
        <!-- END: company -->
    	</table>
    <!-- END: companies -->
<!-- END: main -->