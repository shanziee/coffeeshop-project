<script>
    // PERUBAHAN DISINI: Menambahkan parameter initialData
    function menuApp(initialData) {
        return {
            cart: [],
            activeTab: 'minuman',
            searchQuery: '',

            isModalOpen: false,
            isDetailModalOpen: false,
            showReceipt: false,

            isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},

            selectedMenu: null,
            detailQuantity: 1,
            detailSugar: '100%',

            receiptItems: [],
            receiptTotal: 0,
            receiptSubTotal: 0,
            receiptTax: 0,
            receiptDate: '',
            orderId: '',

            // PERUBAHAN DISINI: Menggunakan data dari database
            menus: initialData,

            get filteredMenus() {
                return this.menus.filter(menu => {
                    const matchesCategory = menu.category === this.activeTab;
                    const matchesSearch = menu.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                    return matchesCategory && matchesSearch;
                });
            },

            openDetail(menu) {
                this.selectedMenu = menu;
                this.detailQuantity = 1;
                this.detailSugar = '100%';
                this.isDetailModalOpen = true;
            },

            addToCartFromDetail() {
                if (!this.selectedMenu) return;

                const cartItem = {
                    ...this.selectedMenu,
                    quantity: this.detailQuantity,
                    sugar: this.selectedMenu.category === 'minuman' ? this.detailSugar : null,
                    cartId: Date.now() + Math.random()
                };

                this.cart.push(cartItem);
                this.isDetailModalOpen = false;
                this.isModalOpen = true;
            },

            removeItem(cartId) {
                this.cart = this.cart.filter(item => item.cartId !== cartId);
            },

            get totalItems() { return this.cart.reduce((sum, i) => sum + i.quantity, 0); },
            get subTotal() { return this.cart.reduce((sum, i) => sum + (i.price * i.quantity), 0); },
            get tax() { return this.subTotal * 0.1; },
            get grandTotal() { return this.subTotal + this.tax; },

            formatCurrency(val) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
            },

            async processPayment() {
                if (!this.isLoggedIn) {
                    alert('Silakan Login terlebih dahulu!');
                    window.location.href = '/login';
                    return;
                }

                const orderData = {
                    total_price: this.grandTotal,
                    items: this.cart.map(item => ({
                        id: item.id,
                        price: item.price,
                        quantity: item.quantity,
                        name: item.name + (item.sugar ? ` (${item.sugar})` : '')
                    }))
                };

                try {
                    const response = await fetch("{{ route('checkout.process') }}", {
                        method: "POST",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify(orderData)
                    });
                    const data = await response.json();
                    if (data.snap_token) {
                        window.snap.pay(data.snap_token, {
                            onSuccess: (result) => { this.generateReceipt(result); },
                            onPending: (result) => { alert("Menunggu pembayaran!"); },
                            onError: (result) => { alert("Pembayaran gagal!"); },
                            onClose: () => { alert("Anda menutup popup."); }
                        });
                    } else { alert("Gagal mendapatkan Token Pembayaran."); }
                } catch (error) {
                    console.error(error);
                    alert("Terjadi kesalahan sistem.");
                }
            },

            generateReceipt(result) {
                this.receiptItems = JSON.parse(JSON.stringify(this.cart));
                this.receiptSubTotal = this.subTotal;
                this.receiptTax = this.tax;
                this.receiptTotal = this.grandTotal;
                this.receiptDate = new Date().toLocaleString('id-ID');
                this.orderId = result.order_id;
                this.isModalOpen = false;
                this.showReceipt = true;
                this.cart = [];
            },

            closeReceipt() {
                this.showReceipt = false;
            }
        };
    }
</script>
