$( document ).ready(function() {
	var navFixed = $('header');
	$(window).scroll(function () {
		var hnTop = navFixed.offset().top; 
		var hnLeft = navFixed.offset().left; 
		var hnWidth = navFixed.width(); 
		var windowWidth = $(window).width(); 
		if(windowWidth>1199){
			if ($(window).scrollTop() > 0) {
				navFixed.css("position","fixed").css("top",0).css("left",hnLeft).css("z-index",99).css("width",hnWidth+30);
			} else {
				navFixed.css("position","relative").css("top","auto").css("left","auto").css("width","auto");
			}
		}
	});
});