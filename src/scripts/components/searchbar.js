import PseudoGuid from "../commons/pseudo-guid";


class AjaxSearchbar {
    constructor(elem) {
        if (!elem) return;

        // Főbb elemek kijelölése
        this.elem = elem;
        this.form = this.elem.querySelector('.search-form');
        this.input = this.elem.querySelector('.input-field');
        this.loader = this.elem.querySelector('.loader-animation');
        this.resultContainer = this.elem.querySelector('.result-container');

        // Beállítások
        this.minChars = 3;
        this.ajaxUrl = '/wp-admin/admin-ajax.php';
        this.debounceTimeout = null;

        this.init();
    }

    init() {
        // Eseménykezelők bekötése (kontextus megtartásával)
        this.input.addEventListener('input', () => this.handleInput());
        this.input.addEventListener('focus', () => this.handleFocus());
        
        // A blur eseménynél timeout kell, hogy ha a találatra kattintanak, az még lefusson
        this.input.addEventListener('blur', (e) => this.handleBlur(e));

        // Globális scroll esemény az ablakon
        window.addEventListener('scroll', () => this.handleScroll(), { passive: true });

        // Form beküldés letiltása, ha csak az AJAX-ot akarjuk használni
        this.form.addEventListener('submit', (e) => e.preventDefault());
    }

    handleInput() {
        clearTimeout(this.debounceTimeout);
        const query = this.input.value.trim();

        if (query.length >= this.minChars) {
            // Debounce: várunk 300ms-ot a gépelés után, mielőtt lőjük az AJAX-ot
            this.debounceTimeout = setTimeout(() => this.search(query), 300);
        } else {
            this.hideResults();
        }
    }

    async search(query) {
        this.showLoader();

        // WordPress specifikus adatok összeállítása
        const formData = new FormData();
        formData.append('action', 'ajax_searchbar'); // A PHP oldali add_action-höz
        formData.append('s', query);

        try {
            const response = await fetch(this.ajaxUrl, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Hálózati hiba történt.');

            const html = await response.text();
            
            // Csak akkor jelenítjük meg, ha a felhasználó még mindig a mezőben van
            if (document.activeElement === this.input) {
                this.renderResults(html);
            }
        } catch (error) {
            console.error('Keresési hiba:', error);
        } finally {
            this.hideLoader();
        }
    }

    renderResults(html) {
        if (!html.trim()) {
            this.hideResults();
            return;
        }
        this.resultContainer.innerHTML = html;
        this.showResults();
    }

    handleFocus() {
        // Ha van benne elég karakter és van találat, fókuszkor újra megnyitjuk
        const query = this.input.value.trim();
        if (query.length >= this.minChars && this.resultContainer.innerHTML.trim() !== '') {
            this.showResults();
        }
    }

    handleBlur(e) {
        // Kis késleltetés (150ms), hogy ha a .result-container-en belüli linkre kattintanak,
        // akkor a kattintás esemény (click) hamarabb lefusson, mint hogy eltűnne a konténer.
        setTimeout(() => {
            this.hideResults();
        }, 150);
    }

    handleScroll() {
        // Ha elgördül az oldal, elrejtjük a találatokat
        this.hideResults();
    }

    // Segédfüggvények a láthatósághoz
    showResults() {
        this.resultContainer.style.display = 'block';
        // Opcionálisan adhatsz hozzá aktív CSS classt is animációhoz:
        this.resultContainer.classList.add('is-active');
    }

    hideResults() {
        this.resultContainer.style.display = 'none';
        this.resultContainer.classList.remove('is-active');
    }

    showLoader() {
        if (this.loader) this.loader.style.display = 'block';
    }

    hideLoader() {
        if (this.loader) this.loader.style.display = 'none';
    }
}



// Inicializálás a DOM betöltődése után
document.addEventListener('DOMContentLoaded', () => {

    const searchbarElements = document.querySelectorAll('.mex-ajax-searchbar');
    const myTemplate = document.createElement('template');
    
    const template = `<a href="" class="item">
        <img src="" alt="" class="image">
        <div class="info">
            <h4 class="title"></h4>
            <span class="qty"></span>
            <span class="price"></span>
        </div>
    </a>`;
    
    myTemplate.setAttribute('id', 'mex-search-result-template');
    myTemplate.innerHTML = template;
    
    document.body.prepend(myTemplate);
    
    searchbarElements.forEach( (elem) => {
        
        if ( elem.getAttribute('id') === null ) {
            elem.setAttribute('id' , PseudoGuid.GetNew() );
        }

        new AjaxSearchbar( document.getElementById(elem.getAttribute('id') ) );
    });
    
});
