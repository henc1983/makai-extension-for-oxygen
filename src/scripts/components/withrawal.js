import PseudoGuid from "../commons/pseudo-guid";

class WithrawalForm {
    constructor(elem) {
        if(!elem) return;

        this.elem = elem;
        
        this.form = this.elem.querySelector('.return-form');
        
        this.lName = this.elem.querySelector('input[name="last_name"]');
        this.fName = this.elem.querySelector('input[name="first_name"]');
        this.email = this.elem.querySelector('input[name="email"]');
        this.orderNumber = this.elem.querySelector('input[name="order_number"]');
        this.products = this.elem.querySelector('input[name="products"]');
        
        this.triggerProduct = false;
        
        this.productWrapper = this.elem.querySelector('.products-wrapper');
        this.triggerBtn = this.elem.querySelectorAll('[data-trigger="products"]');
        this.radioBtns = this.elem.querySelectorAll('.radio-btn');
        this.loader = this.elem.querySelector('.loader-animation');
        this.notification = this.elem.querySelector('.notification-wrapper');

        this.init();
    }


    init() {
        this.form.addEventListener( 'submit' , (e) => this.onSubmit(e) );

        this.radioBtns.forEach(radio => {
            radio.addEventListener( 'change', (e)=>this.radioBtnChange(e) );
        });

    }
    
    async onSubmit(e) {
        e.preventDefault();
        this.showLoader();

        const formData = new FormData();
        formData.append('action', 'withrawal'); // A PHP oldali add_action-höz
        formData.append('last_name', this.lName.value );
        formData.append('first_name', this.fName.value );
        formData.append('order_number', this.orderNumber.value );
        formData.append('email', this.email.value );
        formData.append('return_scope', this.elem.querySelector('input:checked[name="return_scope"]').value );
        
        if( this.elem.querySelector('input:checked[name="return_scope"]').value === 'partial' ) {
            formData.append('products', this.products.value );
        }

        try {
            const response = await fetch("/wp-admin/admin-ajax.php", {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Network error.');
            
            const html = await response.json();
            
            if( html.data.response === 'ok' ) {
                this.notification.classList.remove('hidden');
                this.notification.classList.add('success');
                this.notification.querySelector('.title').innerHTML = html.data.message.title;
                this.notification.querySelector('.message').innerHTML = html.data.message.message;
            }
            
        } catch (error) {
            console.error('Request send error:', error);
        } finally {
            this.hideLoader();
            this.elem.querySelector('[type="submit"]').setAttribute('disabled', 'disabled')
        }

    }

    radioBtnChange(e) {
        this.radioBtns.forEach( (btn) => {
            btn.classList.remove('checked');
            btn.querySelector('.far').classList.remove('fa-circle-check');
            btn.querySelector('.far').classList.add('fa-circle-xmark');
        });

        const newBtn = e.target.closest('.radio-btn');
        newBtn.classList.add('checked');
        newBtn.querySelector('.far').classList.remove('fa-circle-xmark');
        newBtn.querySelector('.far').classList.add('fa-circle-check');
        
        if( newBtn.querySelector('[name="return_scope"]').value === 'partial' ) {
            this.productWrapper.classList.remove('hidden');
            this.products.setAttribute('required', 'required');
            this.products.value = '';

            return false;
        }

        this.productWrapper.classList.add('hidden');
        this.products.removeAttribute('required');

        return false;

    }


    showLoader() {
        this.loader.classList.add('show');
    }


    hideLoader() {
        this.loader.classList.remove('show');        
    }

}


document.addEventListener('DOMContentLoaded', () => {

    const withrawalElements = document.querySelectorAll('.mex-withrawal');
    
    
    withrawalElements.forEach( (elem) => {
        
        if ( elem.getAttribute('id') === null ) {
            elem.setAttribute('id' , PseudoGuid.GetNew() );
        }

        new WithrawalForm( document.getElementById(elem.getAttribute('id') ) );
    });
    
});