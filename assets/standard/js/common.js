	$(document).ready(function(){
		$("a[rel^='echoeslightbox']").colorbox({transition:'elastic', slideshowSpeed:9000, slideshowAuto:false, slideshow:true});
		$(".lboxvideo").colorbox({iframe:true, innerWidth:425, innerHeight:344});
		
		
		
	});
	
	
	ddsmoothmenu.init({
		mainmenuid: "smoothmenu1", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		//customtheme: ["#1c5a80", "#18374a"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	});
