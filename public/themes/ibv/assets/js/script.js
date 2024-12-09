$(document).ready(function(){
	$("#new-release-carousel, #best-seller-carousel").owlCarousel({
		items : 4,
		itemsDesktop : [1199,4],
		itemsDesktopSmall : [980,3],
		itemsTablet: [768,2],
		itemsTabletSmall: false,
		itemsMobile : false,
		navigation: true,
		navigationText : ['<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">Previous</span>', '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span>'],
	    autoPlay : true,
		stopOnHover : true,
		slideSpeed : 400,
	});

	$(window).scroll(function(){
    	var yPos = -($(window).scrollTop() / 5);
		var coords = '50% '+yPos+'px';
		if($('#search-block').length > 0) $('#search-block').css("background-position", coords);
		if($('#search-block-mini').length > 0) $('#search-block-mini').css("background-position", coords);
    })
	
	$(window).scroll(function(event){
		var y = $(this).scrollTop();
		var height = 0;
		if($("#search-block").length > 0){
			height = $('#search-block').position().top+$('#search-block').outerHeight(true);
		}
		if($("#search-block-mini").length > 0){
			height = $('#search-block-mini').position().top+$('#search-block-mini').outerHeight(true);
		}
		if(y <= height - 50){
			$('.navbar').addClass('navbar-default-transparent', 1000);
		}else{
			$('.navbar').removeClass('navbar-default-transparent', 1000);
		}
	});

	$("#grid-view-trigger").click(function(){
		showGridView(this);
	});

	$("#list-view-trigger").click(function(){
		showListView(this);
	});
});

function showListView(e){
		var disabled = $(e).hasClass("disabled");
		if(!disabled){
			$(e).addClass("disabled");
			$("div.product").slideUp();

			setTimeout(function(){
				$("#grid-view-trigger").removeClass("disabled");
				$("div.product").removeClass("product-grid").removeClass("col-xs-6 col-sm-4 col-md-4 col-lg-4");
				$("div.product").addClass("product-row").addClass("row");
				$("div.product-thumbnail").addClass("col-xs-4 col-lg-2");
				$("div.product-description").addClass("col-xs-8 col-lg-10");
				$("button.btn-view-detail-list").addClass("btn-view-detail-list").removeClass("btn-view-detail-grid");
				$("button.btn-add-to-cart-list").addClass("btn-add-to-cart-list").removeClass("btn-add-to-cart-grid");
				$("div.product").slideDown(1000);
			}, 500);

			//set cookie
		}
	}

function showGridView(e){
	var disabled = $(e).hasClass("disabled");
	if(!disabled){
		$(e).addClass("disabled");
		$("div.product").slideUp();

		setTimeout(function(){
			$("#list-view-trigger").removeClass("disabled");
			$("div.product").removeClass("product-row").removeClass("row");
			$("div.product").addClass("product-grid").addClass("col-xs-6 col-sm-4 col-md-4 col-lg-4");
			$("div.product-thumbnail").removeClass("col-xs-4 col-lg-2");
			$("div.product-description").removeClass("col-xs-8 col-lg-10");
			$("button.btn-view-detail-list").removeClass("btn-view-detail-list").addClass("btn-view-detail-grid");
			$("button.btn-add-to-cart-list").removeClass("btn-add-to-cart-list").addClass("btn-add-to-cart-grid");
			$("div.product").slideDown(1000);
		}, 500);

		//set cookie
	
	}
}