import PseudoGuid from "../commons/pseudo-guid";
import MexForms from "../commons/forms";
import MexNotification from "../commons/notification";

class SubscribeForm extends MexForms {
    constructor(elem) {
        super(elem);

        if(!elem) return;
        
        this.lName = this.elem.querySelector('input[name="last_name"]');
        this.fName = this.elem.querySelector('input[name="first_name"]');
        this.email = this.elem.querySelector('input[name="email"]');
    }


    init() {
        super.init();
    }

    
    async onSubmit(e) {
        super.onSubmit(e);

        const formData = new FormData();
        formData.append('action', 'subscribtion');
        formData.append('last_name', this.lName.value );
        formData.append('first_name', this.fName.value );
        formData.append('email', this.email.value );        

        try {
            const response = await fetch("/wp-admin/admin-ajax.php", {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Network error.');
            
            const html = await response.json();
            
            if( html.data.response === 'ok' ) {
                new MexNotification(html.data.message.title, html.data.message.message);
            }
            
        } catch (error) {
            console.error('Request send error:', error);
        } finally {
            this.hideLoader();
            this.submitBtn.setAttribute('disabled', 'disabled');
            setTimeout(()=>this.clearAll(),5000);
            
        }

    }
}


document.addEventListener('DOMContentLoaded', () => {

    const withrawalElements = document.querySelectorAll('.mex-subscribe-news-form');
    
    
    withrawalElements.forEach( (elem) => {
        
        if ( elem.getAttribute('id') === null ) {
            elem.setAttribute('id' , PseudoGuid.GetNew() );
        }

        new SubscribeForm( document.getElementById(elem.getAttribute('id') ) );
    });
    
});