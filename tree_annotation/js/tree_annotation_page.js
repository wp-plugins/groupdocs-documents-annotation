var groupdocs_annotation_error_counter = 0;

(function($) {
	$(function() {
		loadFileTree($);
	})
})(jQuery);
function strip_tags(str){
    return str.replace(/<\/?[^>]+>/gi, '');
};

function loadFileTree($){
	$('.aui-message').remove();
	groupdocs_keys_validation($);
	
	var private_key = $('#privateKey').val();
	var user_id = $('#userId').val();
	var parent = $("#groupdocsBrowser");
	var container = $("#groupdocsBrowserInner", parent);
	
	var opts = {
		script: 'tree_annotation/treeannotation.php?private_key=' + private_key + '&user_id=' + user_id,
		onTreeShow: function(){

		},
		onServerSuccess: function(){
			groupdocs_annotation_error_counter = 0;
			$("a", container).each(function() {
				var self = $(this);
				if(self.parent().hasClass("file")) {
				    document.getElementById('insert').disabled = false;
					self.click(function(e){
						e.preventDefault();
                        if($("a", container).attr('style', 'border')){
                            $("a", container).removeAttr('style')
                        }
                        self.css( 'border', '3px solid red' );
						var height = parseInt($('#height').val());
						var width =  parseInt($('#width').val());
                        var url = self.attr('rel');

                        if (( jQuery('#email').val() !=0 ) & ( jQuery('#email').val() ) !=null) {
                            var email = strip_tags(jQuery('#email').val());
                        }
                        if (jQuery("input[name='can_view']").is(":checked") == true) {

                            var can_view = "True";
                        } else {

                            var can_view = "False";
                        }
                        if (jQuery("input[name='can_annotate']").is(":checked") == true) {
                            var can_annotate="True";
                        } else {
                            var can_annotate = "False";
                        }

                        if (jQuery("input[name='can_download']").is(":checked") == true) {
                            var can_download = "True";
                        } else {
                            var can_download = "False";
                        }

                        if (jQuery("input[name='can_export']").is(":checked") == true) {
                            var can_export = "True" ;
                        } else {
                            var can_export = "False";
                        }
						$('#shortcode').val('[grpdocsannotation file="'+url+'" width="'+width+'" height="'+ height+'" email="'+email+'" can_view="'+can_view+'" can_annotate="'+can_annotate+' " can_download="'+can_download+'" can_export="'+can_export+'"]');
					})
				}
			});
		},
		onServerError: function(response) {
			groupdocs_annotation_error_counter += 1;
			if( groupdocs_annotation_error_counter < 3 ){
				loadFileTree($);
			}
			else {
				show_server_error($);
			}
		}
	};
	container.fileTree(opts);
}

function show_server_error($) {
	var message = "Uh oh, looks like we are currently experiencing difficulties with our API, please be so kind as to drop an email to <a href='mailto:support@groupdocs.com'>support@groupdocs.com</a> to let them know, thanks or <a href='#' onclick='loadFileTree(jQuery);return false'>click here</a> to try again.";
	$('#groupdocsBrowserInner').append($("<div class='aui-message warning'>" + message + "</div>"));
}

function groupdocs_keys_validation($) {
	var private_key = $('#privateKey');
	var user_id = $('#userId');
	var error_massage = $('#groupdocs_keys_error');
	var errors = 0;
	
	error_massage.hide();
	private_key.removeClass('error');
	user_id.removeClass('error');

	if( private_key.val() == '' ) {
		private_key.addClass('error');
		errors += 1;
	}
	if( user_id.val() == '') {
		user_id.addClass('error');
		errors += 1;
	}

	if( errors != 0 ) {
		$('#groupdocs_keys_error').show();
	}
}
