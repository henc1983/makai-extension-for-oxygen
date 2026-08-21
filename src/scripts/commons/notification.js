export default class MexNotification {
    constructor(title, message, type = 'success', duration = 5000) {
        this.title = title;
        this.message = message;
        this.type = type;
        this.duration = duration;
        
        this.container = this._getOrCreateContainer();
        this.element = this._createMarkup();
        
        this._show();
    }

    // Létrehozza a közös külső konténert, ha még nincs a DOM-ban
    _getOrCreateContainer() {
        let container = document.getElementById('mex-notification-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'mex-notification-container';
            document.body.appendChild(container);
        }
        return container;
    }

    // Felépíti a megadott HTML struktúrát
    _createMarkup() {
        const wrapper = document.createElement('div');
        wrapper.className = `mex-notification-wrapper ${this.type} hidden`;

        wrapper.innerHTML = `
            <h3 class="title">${this.title}</h3>
            <p class="message">${this.message}</p>
            <div class="progressbar"></div>
        `;

        this.container.appendChild(wrapper);
        return wrapper;
    }

    // Megjelenítés és az időzítők indítása
    _show() {
        // Kis időzítés, hogy a "hidden" osztály levétele triggerelje a CSS transition-t
        setTimeout(() => {
            this.element.classList.remove('hidden');
            this._startProgressBar();
        }, 10);

        // Automatikus bezárás 10 másodperc után
        setTimeout(() => {
            this.close();
        }, this.duration);
    }

    // Progressbar csökkenésének animálása JS-ből linear szoftveres futással
    _startProgressBar() {
        const progressBar = this.element.querySelector('.progressbar');
        progressBar.style.transition = `transform ${this.duration}ms linear`;
        progressBar.style.transform = 'scaleX(1)';
        
        // Elindítjuk a csökkenést a skálázással (1-ről 0-ra)
        setTimeout(() => {
            progressBar.style.transform = 'scaleX(0)';
        }, 50);
    }

    // Bezárás animációval és a DOM elemek takarítása
    close() {
        this.element.classList.add('hidden');
        
        // Megvárjuk a CSS transition végét (.3s), mielőtt teljesen töröljük a DOM-ból
        setTimeout(() => {
            this.element.remove();
            
            // Ha ez volt az utolsó notification, a konténert is takaríthatjuk
            if (this.container.children.length === 0) {
                this.container.remove();
            }
        }, 300);
    }
}
