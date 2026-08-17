(($)=>{

    let resizeTimer = null;    
    const $screenForm = $("form[id='mex-mediaquery-form']");

    $.fn.onScrollContent = function(scroll, scrollDownOffset = 500, scrollUpOffset = 300) {
        return this.each(function(){
            if(scroll >= scrollDownOffset) {
                if(!$(this).hasClass('scrolled')) {
                    $(this).addClass('scrolled');
                }
            } 
            else if(scroll <= scrollUpOffset){
                $(this).removeClass('scrolled');
            } 
            else {
                $(this).removeClass('scrolled');
            }
        });
    }

    $( window ).on( 'scroll' , function(){
        let scroll = $( window ).scrollTop();
        $('#mex-fab-jump-to-top').onScrollContent(scroll);
    });


    $( document ).on( 'click' , '#mex-fab-jump-to-top' , (event)=>{
        event.preventDefault();
        window.scrollTo({top:0, behavior: 'smooth'});

        return false;
    } );

    $( window ).on( 'resize' , function() {

        if (!$screenForm.length) return;
    
        clearTimeout(resizeTimer);
    
        resizeTimer = setTimeout(function() {
            
            let screen = $(window).width() >= 1196 ? 'desktop' : 'mobile';
            let $formInput = $screenForm.find('input[type="hidden"]');
    
            if ($formInput.val() !== screen) {
                $formInput.val(screen);
                $screenForm.trigger('submit');
            }
    
        }, 200);
    });


    
})(jQuery)

