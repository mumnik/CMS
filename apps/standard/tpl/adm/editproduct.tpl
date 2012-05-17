<!-- BEGIN: main -->
	<script type="text/javascript" src="{GL.base}/js/tinymce/tiny_mce.js"></script>
    <script type="text/javascript" src="{GL.base}/js/tinymce/plugins/tinybrowser/tb_tinymce.js.php"></script>
    <script language="javascript" type="text/javascript">
      tinyMCE.init({
		    theme : "advanced",
		    mode : "exact",
		    elements : "{textareas}",
		    width : "544",
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
    <h1>Product</h1>
    <form method="post" action="index.php?module=products&action=saveproduct">
        <input type="hidden" name="nookid" value="{storeddata_nookid}">
		<!-- BEGIN: fields -->
        <table>
        	<!-- BEGIN: field -->
            <tr style="border-bottom: 1px solid #000">
                <td>
                    {title}
                </td>
                <td>
                    {fieldlang}
                </td>
                <td>
                    {input}
                </td>
            </tr>
            <!-- END: field -->
            <!-- BEGIN: categories -->
            <tr>
            	<td>
                	Category:
                </td>
                <td>
                	-
                </td>
                <td>                	
                     <select name="product[categoryid]">
                        <option value="0">---</option>
                        <!-- BEGIN: category -->
                        <option value="{nookid}" {selected}>{title}</option>
                        <!-- END: category -->
                    </select>
                </td>
            </tr>
            <!-- END: categories -->
        	<tr>
                <td colspan="3" align="center">
                    <input type="submit" value="Save" />
                </td>
        	</tr>
        </table>
        <!-- END: fields -->
    </form>  
  
  
   <form method="post" action="index.php?module=products&action=saveproduct">
        <input type="hidden" name="nookid" value="{storeddata_nookid}">
        <table>
       
        <tr>
        	<td>
            	Related:
            </td>       
            <td>
            	<!-- BEGIN: related -->
                <select multiple="multiple" name="relatednooks[]" style="width:400px; height:200px">
                	<!-- BEGIN: option -->
                    <option value="{related_nookid}" {related_selected}>{related_title}</option>
                    <!-- END: option -->
                </select>
                <!-- END: related -->
            </td>     
        </tr>
        <tr>
        	<td colspan="2" align="center">
            	<input type="submit" value="Save" />
            </td>
        </tr>
      
        </table>
    </form>
    <hr />
    
<!-- END: main -->