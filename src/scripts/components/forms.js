document.querySelectorAll('input[name="return-scope"]').forEach((radio) => {
  radio.addEventListener('change', (e) => {
    const productsWrapper = document.getElementById('products-wrapper');
    const productsInput = document.getElementById('products');
    
    // Háttérszín osztályok frissítése a gombokon
    document.querySelectorAll('.radio-btn').forEach(btn => {
      btn.classList.remove('checked');
      btn.querySelector('.far').classList.remove('fa-circle-check');
      btn.querySelector('.far').classList.add('fa-circle-xmark');
    });
    const newBtn = e.target.closest('.radio-btn')
    newBtn.classList.add('checked');
    newBtn.querySelector('.far').classList.remove('fa-circle-xmark');
    newBtn.querySelector('.far').classList.add('fa-circle-check');

    // Termék mező mutatása/rejtése
    if (e.target.id === 'trigger-products') {
      productsWrapper.classList.remove('hidden');
      productsInput.setAttribute('required', 'required');
    } else {
      productsWrapper.classList.add('hidden');
      productsInput.removeAttribute('required');
      productsInput.value = '';
    }
  });
});

// Alapértelmezett állapot beállítása betöltéskor
document.addEventListener("DOMContentLoaded", () => {
  const triggerProducts = document.getElementById('trigger-products');
  if(!triggerProducts.checked) {
    document.getElementById('products-wrapper').classList.add('hidden');
  }
});