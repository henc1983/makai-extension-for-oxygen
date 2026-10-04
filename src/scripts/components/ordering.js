import MexForms from '../commons/forms';

class LayoutForm extends MexForms {
    constructor(elem) {
        super(elem);

        if(!elem) return;
        
        
    }

    radioBtnChange(e) {
        this.radioBtns.forEach( (btn) => {
            btn.classList.remove('checked');
        });

        const newBtn = e.target.closest('.radio-btn');
        newBtn.classList.add('checked');

        this.form.submit();
    }
}



document.addEventListener('DOMContentLoaded', () => {

    const layout = document.querySelector('.mex-view-layout');
    const orderForm = document.querySelector('#woocommerce-ordering');

    if(layout) {
        new LayoutForm( layout );
    }

    if(orderForm) {
        const selection = orderForm.querySelector('select[name="mex-orderby"]');

        selection.onchange = (e) => {
            orderForm.submit();
        }
    }
});