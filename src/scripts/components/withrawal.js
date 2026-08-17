(($)=>{

    const $withrawalForms = $("form[name='mex-withrawal-form']");

    $withrawalForms.each(
        function(){

            $( this ).on( 'submit', function(e){
                e.preventDefault();
                console.log(e.currentTarget.parentElement.id);
            } );

        }
    );


})(jQuery)