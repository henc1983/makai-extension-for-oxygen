import MexForms from '../commons/forms';

class LayoutForm extends MexForms {
    constructor(elem) {
        super(elem);

        if(!elem) return;
        
        
    }
}


document.addEventListener('DOMContentLoaded', () => {

    const layout = document.getElementById('mex-view-layout');

    new LayoutForm( layout );
    console.log("hello mi?");
});