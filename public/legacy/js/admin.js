function confirmCancel(){
	return confirm('ACHTUNG: Alle Aenderungen werden verworfen!');
}

function confirmDelete(){
	return confirm("Moechten Sie den Datensatz loeschen?");
}

function goTo(goURL){
	document.location.href=base_url+goURL;
}

function jalert(message){
	$.fn.jQueryMsg({
                msg: message,
                msgClass: 'alert',
                fx: 'fade',
                speed: 1000
            });
}


$(document).ready(function() {
	
		$("#content .datepicker").datepicker(); //apply datepicker
		
		//-----------------------------------------------------------------------
		// Slider
		$('#slider').nivoSlider({ //apply nivoslider
		        effect:'fade', //Specify sets like: 'fold,fade,sliceDown'
		        animSpeed:200, //Slide transition speed
		        pauseTime:3000,
		        startSlide:0, //Set starting Slide (0 index)
		        directionNav:true, //Next & Prev
		        directionNavHide:false, //Only show on hover
		        controlNav:false, //1,2,3...
		        keyboardNav:true, //Use left & right arrows
		        pauseOnHover:true, //Stop animation while hovering
		        manualAdvance:true, //Force manual transitions
		        captionOpacity:0.8 //Universal caption opacity
		    });
		
		//-----------------------------------------------------------------------
		// Lightbox for jQuery
		 $('#content a.lightbox').lightBox({ //apply lightbox
				overlayBgColor: '#FFF',
				overlayOpacity: 0.7,
				imageLoading: '../img/blank.gif',
				containerResizeSpeed: 200,
				txtImage: 'Bild',
				txtOf: 'von'
		   }); 

		//-----------------------------------------------------------------------
		// WYSIWYG Editor
		$('#content .editor').ckeditor({
				toolbar:
				[
					['Cut','Copy','Paste','-','Undo','Redo','-','ShowBlocks','RemoveFormat','-','Source'],
					['Bold', 'Italic','-','Subscript','Superscript','-', 'NumberedList', 'BulletedList', '-','HorizontalRule','-', 'Link', 'Unlink', '-', 'Image'],
					['Format']

				],
				language : 'de',
				defaultLanguage : 'de',
				forcePasteAsPlainText : true,
				enterMode : CKEDITOR.ENTER_BR,
        		shiftEnterMode: CKEDITOR.ENTER_P
			},
			function() {
				CKFinder.setupCKEditor(this, '../../../non_ci/ckfinder/')
			}
		);
			

		//-----------------------------------------------------------------------
		//chars coutn + max chars for most common input fields
		/*$('.maxlength_4').jqEasyCounter({
				'maxChars': 4
		});
		$('.maxlength_50').jqEasyCounter({
				'maxChars': 50,
				'maxCharsWarning': 40
		});
		$('.maxlength_100').jqEasyCounter({
				'maxChars': 100,
				'maxCharsWarning': 80
		});*/
		
		//-----------------------------------------------------------------------
		
		//$('#tabMenu').tabify();
		
		$("#tabMenu").tabs(1)
		
		/* load "last saved tab"
		$("#tabMenu").tabs({
			cookie: {
				expires: 1
			}
		});*/
		

		$("#content .multiselect").multiselect();

		//-----------------------------------------------------------------------
		//deselect radio button on dblclick
        var allRadios = $('input[type=radio]')
        var radioChecked;
        var setCurrent = function(e) {
	                        var obj = e.target;
	                        radioChecked = $(obj).attr('checked');
             			}
        var setCheck = function(e){
						if (e.type == 'keypress' && e.charCode != 32) return false;
						var obj = e.target;
						if (radioChecked) 	$(obj).attr('checked', false);
						else 				$(obj).attr('checked', true);
					}
        $.each(allRadios, function(i, val){        
             var label = $('label[for=' + $(this).attr("id") + ']');
            
         $(this).bind('mousedown keydown', function(e){
                setCurrent(e);
            });
         label.bind('mousedown keydown', function(e){
                e.target = $('#' + $(this).attr("for"));
                setCurrent(e);
            });
         $(this).bind('click', function(e){
                setCheck(e);    
            });
        });
		//-----------------------------------------------------------------------
		
		$('.edit_publication').click(function(){
			$('.edit_publication_'+this.id).toggle();
			$('.edit_publication_form').append('<input type="hidden" name="pub_id[]" value="'+this.id+'" />');
		});
	
});