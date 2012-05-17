/*
 * Tabbed jQuery Plugin
 * http://nathansearles.com/tabbed/
 *
 * Copyright (c) 2010 Nathan Searles
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://docs.jquery.com/License
 *
 * @version 0.1
 */
if(typeof jQuery != "undefined") {
	jQuery(function($) {
		$.fn.extend({
			tabbed: function(options) {
				var settings = $.extend({}, $.fn.tabbed.defaults, options);
				return this.each(
					function() {
						if($.fn.jquery < "1.3.1") {return;}
						var $t = $(this);
						var o = $.metadata ? $.extend({}, settings, $t.metadata()) : settings;
						var tabs = $t.find("> ul li");
						var tabcontent = "."+o.tabcontent;
						var activeTab = 0, height = 0;
						$(tabcontent,$t).hide();
						$($("li:first",$t).addClass("active").css({display:"block"});
						$(tabcontent+":first",$t).show();
						$(tabs,$t).bind("click",function() {
							if ($(this).hasClass("active")) { return false; }
							$(tabs,$t).removeClass("active");
							$(this,$t).addClass("active");
							$(tabcontent,$t).hide();
							activeTab = $(this,$t).find("a").attr("href");
							$(activeTab,$t).fadeIn(o.speed,function(){removeFilter(this)});
							height = $(activeTab,$t).outerHeight();
							$(activeTab,$t).parent().css({"height":height});
							return false;
						});
					}
				);
			}
		});
		$.fn.tabbed.defaults = {
			tabcontent: "tabcontent", // class of tab content
			speed: 250 // speed of fade
		};
	});
	function removeFilter(element) {
		/* Fix for IE crap */
		if(element.style.removeAttribute){element.style.removeAttribute('filter');}
	}
}