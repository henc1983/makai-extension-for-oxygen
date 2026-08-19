



(($)=>{

    const $withrawalForms = $('form[name="return-form"]');

    $withrawalForms.each(
        function(){

            $( this ).on( 'submit', async function(e){
                e.preventDefault();
                

                const formData = new FormData();
                formData.append('action', 'withrawal'); // A PHP oldali add_action-höz
                formData.append('last_name', '');
                formData.append('first_name', '');
                formData.append('order_number', '');
                formData.append('email', '');
                formData.append('return_scope', '');
                formData.append('products', '');


                try {
                    const response = await fetch("/wp-admin/admin-ajax.php", {
                        method: 'POST',
                        body: formData
                    });

                    if (!response.ok) throw new Error('Hálózati hiba történt.');

                    const html = await response.text();
                    
                } catch (error) {
                    console.error('Küldési hiba:', error);
                } finally {
                    // this.hideLoader();
                }

            } );

        }
    )


})(jQuery)