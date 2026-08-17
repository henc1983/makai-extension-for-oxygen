import PseudoGuid from "../commons/pseudo-guid";


class Dropdown {


    // Statikus tömb az összes létrehozott dropdown példány követésére
    static instances = [];




    constructor(id) {
        this.dropdown = document.getElementById(id);
        
        // Ha nem létezik az elem ezzel az ID-val, leállunk
        if (!this.dropdown) {
            return;
        }

        // Elmentjük a példányt a globális listába
        Dropdown.instances.push(this);
        
        this.init();
    }




    init() {
        const toggleBtn = this.dropdown.querySelector('.toggle');
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // Meggátolja a dokumentum szintű azonnali bezárást
                this.toggle();
            });
        }

        // Csak egyszer adjuk hozzá a globális kattintás figyelőt
        if (Dropdown.instances.length === 1) {
            document.addEventListener('click', () => Dropdown.closeAllAll());
        }
    }



    toggle() {
        const isOpen = this.dropdown.classList.contains('active');

        // Összes többi dropdown bezárása
        Dropdown.closeAllAll();

        // Ha ez a konkrét darab nem volt nyitva, most kinyitjuk
        if (!isOpen) {
            this.dropdown.classList.add('active');
        }
    }




    // Bezárja ezt a konkrét dropdown-t
    close() {
        this.dropdown.classList.remove('active');
    }




    // Statikus metódus az ÖSSZES létező példány bezárására
    static closeAllAll() {
        Dropdown.instances.forEach(instance => instance.close());
    }
}




document.addEventListener( 'DOMContentLoaded' , ()=>{
    document.querySelectorAll('.mex-dropdown').forEach( dropdown => {
        
        if ( dropdown.getAttribute('id') === null ) {
            dropdown.setAttribute( 'id' , PseudoGuid.GetNew() );
        }
        return new Dropdown(dropdown.getAttribute('id'));
    });
} );