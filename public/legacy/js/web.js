function removeItem(id) {
	order = jQuery.grep(order, function(value) {
		return value != (id);
	});
	
	jQuery("#"+id).remove();
}

debugArr = [];

$(document).ready(function() {
	
	
		//-----------------------------------------------------------------------
		// Lightbox for jQuery
		$('#content_wrapper .lightbox').lightBox({ //apply lightbox
			overlayBgColor: '#FFF',
			overlayOpacity: 0.7,
			imageLoading: '../img/blank.gif',
			containerResizeSpeed: 200,
			txtImage: 'Bild',
			txtOf: 'von'
		});
		   
		//this highlights the current navigation points
		if($('#nav_sub_'+nav_top_current).length) $('#nav_top_'+nav_top_current).addClass('nav_top_curr');
		if($('#nav_sub_'+nav_sub_current).length) $('#nav_sub_'+nav_sub_current).addClass('nav_sub_curr');
		
		
		if($('#showcase_list').length){ //if the showcase is loaded, trigger click on the first element to display its content
			$("#showcase_list li:first").click();
		}
		
		$("#showForm").click(function() {
			$("#formConcern").toggle();	return false;	
		});
		
		order = [];
		
		$(".showPubForm").click(function(e) {
			e.preventDefault();
			
			if (order == undefined) {
				order = [];
			}
			
			if ($.inArray($(this).attr("pid"), order) == -1) {
				order.push($(this).attr("pid"));
				$("#publicationBasket").append('<div id="'+$(this).attr("pid")+'"><input type="hidden" name="order_items[]" value="'+$(this).attr("title")+'" />- '+$(this).attr("title")+' (<a href="javascript:;" onclick="removeItem(\''+$(this).attr("pid")+'\')" title="Artikel entfernen" alt="Artikel entfernen">Entfernen</a>)</div>');
			}
			
			// add items to basket
			$("#formPublication").show();	
		});		
		
		
		$("a").focus(function(){ 
			$(this).blur();
		});
		
		$(".toggleVersion").click(function(e){
			e.preventDefault();
			$("#about_video_en").show();
		});
		
		var img_height     = $("#home_image").find("img").height();
		var content_height = $("#home_content").height() + $("#home_footer").height();
		if (img_height < content_height) {
			$("#home_image").css("min-height", "500px");
		}
		
		// display images randomly (aobut us)
		var images = $("#about_image img");
		var count  = images.length;
		if (images != undefined && count > 0) {
			var random = Math.ceil(Math.random()*count)-1; 
			$("#about_image img").css("display", "none");
			$(images[random]).show();
		}
		
		$(".js-partner-entry").each(function(key,val){
			if ($(this).find(".image").html() == "&nbsp;" || $(this).find(".right").html() == "&nbsp;") {
				$(this).remove();
			}
		});		
	
});




function showcaseLoadMainImage(OBJEKTE_ID,newImage,newTitle,newTechnique) {
	if(!newImage) return;
	$('#showcase_image img').attr('src',newImage+'|format=object_preview');
	$('#showcase_image #showcase_image_link').attr('href','web/artists/object/'+OBJEKTE_ID); //image link
	$('#showcase_image #showcase_image_details').attr('href','web/artists/object/'+OBJEKTE_ID); //text link
	$('#showcase_image #showcase_image_title').html('<strong>'+newTitle +'</strong><br />'+ newTechnique);
}

function editorWindow(contentName) {
	 window.open('admin/editor/edit/'+contentName, "Editor_"+contentName, "width=800,height=700,resizable=yes");
}