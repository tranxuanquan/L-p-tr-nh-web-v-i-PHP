function openModal() {
  document.getElementById('checkout-modal').style.display = 'flex';
}

function closeModal() {
  document.getElementById('checkout-modal').style.display = 'none';
}

function updateTotal() {
  const totalElement = document.querySelector('.cart-summary-total span');
  if (!totalElement) {
    return;
  }

  let total = 0;
  document.querySelectorAll('.cart-item').forEach(item => {
    const qty = parseInt(item.querySelector('input[type="number"]').value) || 0;
    const priceText = item.querySelector('.cart-price').getAttribute('data-price');
    const price = parseInt(priceText.replace(/\D/g, '')) || 0;
    total += qty * price;
  });

  totalElement.textContent = total.toLocaleString('vi-VN') + '₫';
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.cart-item').forEach(item => {
    const priceEl = item.querySelector('.cart-price');
    if (priceEl && !priceEl.hasAttribute('data-price')) {
      priceEl.setAttribute('data-price', priceEl.textContent);
    }
    const qtyInput = item.querySelector('input[type="number"]');
    if (qtyInput) {
      qtyInput.addEventListener('input', updateTotal);
    }
  });
  updateTotal();
});
