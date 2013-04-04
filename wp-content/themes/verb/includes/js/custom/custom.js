jQuery(document).ready(function( $ ) { 
	
		//Search Toggle
		$(".search-toggle").click(function () {
			
			$(this).toggleClass("current-menu-item");
			$(".header .search-form").fadeToggle();
			
			return false;
		});
		
	
		
		//Footer Toggle
		$("#footer-inside").hide();
		$("#footer-toggle").click(function () {
			
			$("#footer-inside").fadeToggle();
			
			$(".icon-plus").toggleClass("icon-minus");
			
			$(this).toggleClass("footer-toggle-active");
			
			$("html, body").animate({
                scrollTop: $("#footer-inside").offset().top
            }, 500);
			
			return false;
		});
		
	
		
		//FitVids
		$(".fitvid").fitVids();	
	
	
	
		//Comments
		$("#comment-nav-below").hide();
		
		$(".commentlist,#respond").hide();
		
		$("#comments-title").click(function () {
		
			$("#comment-nav-below").fadeToggle();
	
			$(".commentlist,#respond").fadeToggle();
			
			$(this).toggleClass('comments-open');
			
			$('html, body').animate({
                scrollTop: $("#comments-title").offset().top
            }, 500);

			return false;
		});
		
		
		
		//Responsive Menu
		$('.nav').mobileMenu();
				
        $('select.select-menu').each(function(){
            var title = $(this).attr('title');
            if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
            $(this)
                .css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
                .after('<span class="select">' + title + '</span>')
                .change(function(){
                    val = $('option:selected',this).text();
                    $(this).next().text(val);
                    })
        });
	
});