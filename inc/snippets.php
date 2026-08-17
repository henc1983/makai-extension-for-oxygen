<?php



namespace MakaiExtensions\Snippets;



add_action( 'wp_body_open' , '\MakaiExtensions\Snippets\mediaquery_helper_html' , -1 );




function mediaquery_helper_html() {    
    
    $value = $_SESSION['mex_screen_size'] ?? 'desktop';

    ob_start();

    ?>
		<form id="mex-mediaquery-form" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']) ?>">
			<input type="hidden" name="mex-screen-size" value="<?php esc_attr_e( $value )?>">
		</form>
		<script id="mex-mediaquery-form-check-script">
			(function($){
				const $screenForm = $("form[id='mex-mediaquery-form']");
				
				if (!$screenForm.length) return;
				
				let screen = $(window).width() >= 1196 ? 'desktop' : 'mobile';
				let $formInput = $screenForm.find('input[type="hidden"]');
		
				if ($formInput.val() !== screen) {
					$formInput.val(screen);
					$screenForm.trigger('submit');
				}

				$( window ).on( 'load' , function(){
					$('#mex-mediaquery-form-check-script').remove();
				} );
			})(jQuery);
		</script>
    <?php

    $html = ob_get_contents();
    ob_end_clean();

    echo \MakaiExtensions\Functions\compress_html( $html );
}