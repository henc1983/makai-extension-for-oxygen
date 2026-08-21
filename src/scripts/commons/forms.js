import MexNotification from "./notification";

export default class MexForms {
    constructor(elem) {
        this.elem = elem;
        this.form = this.elem.querySelector('.form');
        this.submitBtn = this.elem.querySelector('[type="submit"]');
        this.radioBtns = this.elem.querySelectorAll('.radio-btn');
        this.loader = this.elem.querySelector('.loader-animation');
        this.triggerBtn = this.elem.querySelectorAll('[data-trigger]');
        this.triggerPoint = false;
        
        this.init();
    }

    init() {
        this.form.removeEventListener( 'submit' , (e)=>this.onSubmit(e) );
        this.form.addEventListener( 'submit' , (e)=>this.onSubmit(e) );
        
        if( this.radioBtns.length < 1 ) return;
        this.radioBtns.forEach(radio => {
            radio.removeEventListener( 'change', (e)=>this.radioBtnChange(e) );
            radio.addEventListener( 'change', (e)=>this.radioBtnChange(e) );
        });
    }

    onSubmit(e) {
        e.preventDefault();
        this.showLoader();
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
    }

    showLoader() {
        this.loader.classList.add('show');
    }


    hideLoader() {
        this.loader.classList.remove('show');        
    }

    clearAll() {
        this.form.querySelectorAll('[type="text"], [type="email"], [type="password"]').forEach((text)=>{
            if(!text) return;
            text.value = '';
        });
        this.form.querySelectorAll('[type="checkbox"]').forEach((check)=>{
            if(!check) return;
            check.checked = false;
        });

        this.submitBtn.removeAttribute('disabled');
    }
}