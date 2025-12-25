// --- FUNGSI UTILITAS GLOBAL ---
const serviceFee = 2000; // Biaya layanan, dideklarasikan global
let cart = []; // State untuk menyimpan objek pesanan lengkap
let totalItemsInCart = 0; // State untuk melacak jumlah item

function formatRupiah(number) {
    // Fungsi untuk memformat angka ke mata uang Rupiah
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
}

// Fungsi untuk menampilkan item di Modal Keranjang
function renderCartItems() {
    // Ambil elemen DOM, pastikan mereka ada
    const cartItemsList = document.getElementById('cart-items-list');
    const subtotalPriceElement = document.getElementById('subtotal-price');
    const totalPriceElement = document.getElementById('total-price');
    
    let subtotal = 0;
    let htmlContent = '';

    if (cart.length === 0) {
        htmlContent = '<p class="empty-cart-message">Keranjang masih kosong. Silakan tambahkan menu favorit Anda!</p>';
    } else {
        cart.forEach((item) => {
            const itemTotal = item.totalItemPrice * item.quantity;
            subtotal += itemTotal;
            
            htmlContent += `
            <div class="cart-item">
                <div class="item-details-cart">
                    <p class="item-name-cart">${item.name}</p>
                    <p class="item-options">
                        ${item.sugar} | ${item.temp} 
                        ${item.notes ? `(Catatan: ${item.notes})` : ''}
                    </p>
                </div>
                <div class="item-quantity-control">
                    <span>x${item.quantity}</span>
                </div>
                <div class="item-price-cart">
                    ${formatRupiah(itemTotal)}
                </div>
            </div>
            `;
        });
    }

    // Update list item
    if (cartItemsList) cartItemsList.innerHTML = htmlContent;

    // Hitung dan update total
    const grandTotal = subtotal + serviceFee;
    if (subtotalPriceElement) subtotalPriceElement.textContent = formatRupiah(subtotal);
    if (totalPriceElement) totalPriceElement.textContent = formatRupiah(grandTotal);
}


// ===============================================
// MAIN LOGIC - DOMContentLoaded
// ===============================================
document.addEventListener('DOMContentLoaded', () => {
    
    // --- Deklarasi Elemen DOM ---
    const splashScreen = document.getElementById('splash-screen');
    const mainContent = document.getElementById('main-content');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const menuItems = document.querySelectorAll('.menu-item');
    
    // Elemen Modal Kustomisasi
    const orderModal = document.getElementById('order-modal');
    const closeBtn = orderModal ? orderModal.querySelector('.close-btn') : null;
    const modalItemName = document.getElementById('modal-item-name');
    const modalItemPrice = document.getElementById('modal-item-price');
    const addToCartBtn = document.getElementById('add-to-cart-btn');

    // Elemen Keranjang & Checkout
    const floatingCart = document.getElementById('floating-cart');
    const cartCount = document.getElementById('cart-count');
    const checkoutModal = document.getElementById('checkout-modal');
    const checkoutCloseBtn = checkoutModal ? checkoutModal.querySelector('.checkout-close') : null; 
    const paymentModal = document.getElementById('payment-modal');
    const paymentCloseBtn = paymentModal ? paymentModal.querySelector('.payment-close') : null;
    const checkoutBtn = document.getElementById('checkout-btn'); 
    const placeOrderBtn = document.getElementById('place-order-btn'); 
    const finalTotalDisplay = document.getElementById('final-total-display'); 
    

    // ===============================================
    // 1. LOGIKA SPLASH SCREEN
    // ===============================================
    setTimeout(() => {
        if (splashScreen) splashScreen.classList.add('fade-out');
        if (mainContent) mainContent.classList.remove('hidden');
        
        setTimeout(() => {
            if (splashScreen) splashScreen.style.display = 'none';
        }, 800);

    }, 2000); 


    // ===============================================
    // 2. LOGIKA FILTER MENU
    // ===============================================
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.getAttribute('data-filter');

            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            menuItems.forEach(item => {
                if (filter === 'semua' || item.classList.contains(filter)) {
                    item.style.display = 'block'; 
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // ===============================================
    // 3. LOGIKA MODAL KUSTOMISASI (ORDER MODAL)
    // ===============================================
    
    // 3.1. Membuka Modal saat Item Diklik
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            const name = this.getAttribute('data-name');
            const price = this.getAttribute('data-price');
            
            if (modalItemName) modalItemName.textContent = name;
            if (modalItemPrice) modalItemPrice.textContent = formatRupiah(price);
            
            if (orderModal) orderModal.classList.remove('hidden');
        });
    });
    
    // 3.2. Menutup Modal Kustomisasi
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            if (orderModal) orderModal.classList.add('hidden');
        });
    }
    
    // 3.3. Menutup Modal Kustomisasi (Click di luar)
    window.addEventListener('click', (event) => {
        if (event.target === orderModal) {
            if (orderModal) orderModal.classList.add('hidden');
        }
    });

    // 4. LOGIKA TAMBAH KE KERANJANG (ADD TO CART)
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', () => {
            const itemPriceString = modalItemPrice.textContent.replace(/[^\d]/g, '');
            const basePrice = parseInt(itemPriceString);

            const sugarInput = document.querySelector('input[name="sugar"]:checked');
            const tempInput = document.querySelector('input[name="temp"]:checked');

            const itemName = modalItemName.textContent;
            const sugarLevel = sugarInput ? sugarInput.value : 'N/A';
            const temp = tempInput ? tempInput.value : 'N/A';
            const notes = document.getElementById('order-notes').value;
            
            const tempCost = temp === 'ice' ? 2000 : 0; 

            // 1. TAMBAHKAN ITEM KE ARRAY KERANJANG
            const newItem = {
                name: itemName,
                basePrice: basePrice,
                sugar: sugarLevel,
                temp: temp,
                tempCost: tempCost,
                totalItemPrice: basePrice + tempCost,
                notes: notes,
                quantity: 1
            };
            cart.push(newItem);
            
            // 2. UPDATE STATE DAN TAMPILAN KERANJANG
            totalItemsInCart = cart.length;
            if (cartCount) cartCount.textContent = totalItemsInCart;
            if (floatingCart) floatingCart.classList.remove('hidden-cart'); 
            
            // 3. TUTUP MODAL
            alert(`Pesanan ${itemName} ditambahkan ke keranjang! Total item: ${totalItemsInCart}`);
            if (orderModal) orderModal.classList.add('hidden');
        });
    }

    // ===============================================
    // 5. LOGIKA KLIK FLOATING CART (MEMBUKA CHECKOUT MODAL)
    // ===============================================
    
    if (floatingCart) {
        floatingCart.addEventListener('click', () => {
            if (totalItemsInCart > 0) {
                renderCartItems(); 
                if (checkoutModal) checkoutModal.classList.remove('hidden');
            } else {
                alert('Keranjang Anda masih kosong.');
            }
        });
    }

    // 6. LOGIKA KLIK TOMBOL "BAYAR SEKARANG" (CHECKOUT MODAL -> PAYMENT MODAL)
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            const finalPriceString = totalPriceElement.textContent;
            
            if (finalTotalDisplay) finalTotalDisplay.textContent = finalPriceString;
            
            if (checkoutModal) checkoutModal.classList.add('hidden');
            if (paymentModal) paymentModal.classList.remove('hidden');
        });
    }

    // 7. LOGIKA KLIK TOMBOL "KONFIRMASI PESANAN" (PLACE ORDER)
    if (placeOrderBtn) {
        placeOrderBtn.addEventListener('click', () => {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const tableNumberInput = document.getElementById('table-number');
            const tableNumber = tableNumberInput ? tableNumberInput.value : '';

            if (!tableNumber) {
                alert("Mohon masukkan Nomor Meja Anda.");
                return;
            }

            // SIMULASI PENGIRIMAN PESANAN
            console.log("Pesanan dikonfirmasi dan dikirim.");
            alert(`Pesanan Diterima! Nomor Meja: ${tableNumber}. Metode: ${selectedMethod}. Kami akan siapkan pesanan Anda. Terima kasih!`);
            
            // Reset state dan tutup modal
            cart = [];
            totalItemsInCart = 0;
            if (cartCount) cartCount.textContent = '0';
            if (floatingCart) floatingCart.classList.add('hidden-cart');
            if (paymentModal) paymentModal.classList.add('hidden');
        });
    }

    // 8. LOGIKA MENUTUP MODAL (CHECKOUT & PAYMENT)
    if (checkoutCloseBtn) {
        checkoutCloseBtn.addEventListener('click', () => {
            if (checkoutModal) checkoutModal.classList.add('hidden');
        });
    }

    if (paymentCloseBtn) {
        paymentCloseBtn.addEventListener('click', () => {
            if (paymentModal) paymentModal.classList.add('hidden');
        });
    }

    // Menutup Modal saat mengklik di luar area modal (Checkout)
    window.addEventListener('click', (event) => {
        if (event.target === checkoutModal) {
            if (checkoutModal) checkoutModal.classList.add('hidden');
        }
        // Menutup Modal saat mengklik di luar area modal (Payment)
        if (event.target === paymentModal) {
            if (paymentModal) paymentModal.classList.add('hidden');
        }
    });

});

