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
    <h1>Category</h1>
    <form method="post" action="index.php?module=categories&action=savecategory"> 
        <input type="hidden" name="nookid" value="{storeddata_nookid}" /> 
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
       <!-- BEGIN: parentselector -->
            <tr>
                <td>
                    Parent
                </td>
                <td colspan="2">
                    
                    <select name="category[parentid]">
                        <option value="0">---</option>
                        <!-- BEGIN: parentselectoroption -->
                        <option value="{nookid}" {selected}>{title}</option>
                        <!-- END: parentselectoroption -->
                    </select>
                </td>
            </tr>
       	<!-- END: parentselector -->
            <tr>
                <td colspan="3">
                    <input type="submit" onclick="javascript: if (!confirm('Are you sure?')){ return false; }"/>
                </td>
            </tr>
        </table>
        <!-- END: fields -->
    </form>
    
<!-- END: main -->