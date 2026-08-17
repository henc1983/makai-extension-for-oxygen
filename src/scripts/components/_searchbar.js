import PseudoGuid from "../commons/pseudo-guid";


class AjaxSearchbar {
    constructor(element) {
        if (!element) return;

        // Főbb elemek kijelölése
        this.container = element;
        this.form = this.container.querySelector('.search-form');
        this.input = this.container.querySelector('.input-field');
        this.loader = this.container.querySelector('.loader-animation');
        this.resultContainer = this.container.querySelector('.result-container');

        // Beállítások
        this.minChars = 3;
        this.ajaxUrl = '/wp-admin/admin-ajax.php'; // Vagy egyéni REST API útvonal
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
        formData.append('post_type', this.form.querySelector('[name="post_type"]').value);

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
    const searchbarElement = document.querySelector('.mex-ajax-searchbar');
    if (searchbarElement) {
        new AjaxSearchbar(searchbarElement);
    }
});
