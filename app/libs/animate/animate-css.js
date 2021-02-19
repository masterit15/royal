//Animate CSS + WayPoints javaScript Plugin
//Example: $(".element").animated("zoomInUp");
//Author URL: http://webdesign-master.ru
(function($) {
	$.fn.animated = function(inEffect, timeOut=0) {
		$(this).each(function() {
			var ths = $(this);
			ths.css("opacity", "0").addClass("animate__animated").waypoint(function(dir) {
				if (dir === "down") {
					setTimeout(()=>{
						ths.addClass(inEffect).css("opacity", "1");
					}, timeOut)
				};
			}, {
				offset: "90%"
			});

		});
	};
})(jQuery);