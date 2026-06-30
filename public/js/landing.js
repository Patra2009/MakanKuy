// Category Filter
        document.querySelectorAll('.cat-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const category = this.dataset.category;
                const cards = document.querySelectorAll('.menu-card');

                cards.forEach(card => {
                    if (category === 'semua' || card.dataset.category === category) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.4s ease';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Search Menu
        document.getElementById('searchMenu').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.menu-card').forEach(card => {
                const name = card.dataset.name;
                card.style.display = name.includes(query) ? 'block' : 'none';
            });
        });

        // Order Modal
        const orderModal = document.getElementById('orderModal');
        const orderMenuId = document.getElementById('orderMenuId');
        const orderMenuName = document.getElementById('orderMenuName');
        const orderMenuDesc = document.getElementById('orderMenuDesc');
        const orderMenuPrice = document.getElementById('orderMenuPrice');
        const orderMenuStock = document.getElementById('orderMenuStock');
        const orderMenuImage = document.getElementById('orderMenuImage');
        const orderMenuPlaceholder = document.getElementById('orderMenuPlaceholder');
        const jumlahInput = document.getElementById('jumlah');
        const orderTotal = document.getElementById('orderTotal');
        const deliveryLatitude = document.getElementById('deliveryLatitude');
        const deliveryLongitude = document.getElementById('deliveryLongitude');
        const deliveryLocationText = document.getElementById('deliveryLocationText');
        const useCurrentLocation = document.getElementById('useCurrentLocation');
        const defaultDeliveryLocation = [-6.2, 106.816666];
        let activeMenuPrice = 0;
        let deliveryMap = null;
        let deliveryMarker = null;

        const formatRupiah = (value) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        };

        const updateOrderTotal = () => {
            const jumlah = Math.max(1, parseInt(jumlahInput.value || '1', 10));
            const max = parseInt(jumlahInput.max || '1', 10);
            jumlahInput.value = Math.min(jumlah, max);
            orderTotal.textContent = formatRupiah(activeMenuPrice * parseInt(jumlahInput.value, 10));
        };

        const updateDeliveryLocation = (lat, lng, shouldCenter = true) => {
            const fixedLat = Number(lat).toFixed(7);
            const fixedLng = Number(lng).toFixed(7);

            deliveryLatitude.value = fixedLat;
            deliveryLongitude.value = fixedLng;
            deliveryLocationText.textContent = `Titik dipilih: ${Number(lat).toFixed(5)}, ${Number(lng).toFixed(5)}`;

            if (!deliveryMap || !deliveryMarker) {
                return;
            }

            deliveryMarker.setLatLng([lat, lng]);

            if (shouldCenter) {
                deliveryMap.setView([lat, lng], 16);
            }
        };

        const initDeliveryMap = () => {
            if (!window.L) {
                deliveryLocationText.textContent = 'Map belum tersedia. Alamat tetap bisa dikirim.';
                return;
            }

            if (!deliveryMap) {
                const initialLocation = deliveryLatitude.value && deliveryLongitude.value
                    ? [Number(deliveryLatitude.value), Number(deliveryLongitude.value)]
                    : defaultDeliveryLocation;

                deliveryMap = L.map('deliveryMap', {
                    zoomControl: true,
                    attributionControl: false
                }).setView(initialLocation, 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(deliveryMap);

                deliveryMarker = L.marker(initialLocation, { draggable: true }).addTo(deliveryMap);
                deliveryMarker.on('dragend', function(event) {
                    const markerLocation = event.target.getLatLng();
                    updateDeliveryLocation(markerLocation.lat, markerLocation.lng, false);
                });

                deliveryMap.on('click', function(event) {
                    updateDeliveryLocation(event.latlng.lat, event.latlng.lng);
                });

                if (deliveryLatitude.value && deliveryLongitude.value) {
                    updateDeliveryLocation(deliveryLatitude.value, deliveryLongitude.value);
                }
            }

            setTimeout(() => deliveryMap.invalidateSize(), 150);
        };

        const openOrderModal = (card) => {
            activeMenuPrice = Number(card.dataset.price);

            orderMenuId.value = card.dataset.menuId;
            orderMenuName.textContent = card.dataset.title;
            orderMenuDesc.textContent = card.dataset.description || 'Tidak ada deskripsi menu.';
            orderMenuPrice.textContent = card.dataset.priceFormatted;
            orderMenuStock.textContent = `Stok ${card.dataset.stock}`;
            jumlahInput.max = card.dataset.stock;
            jumlahInput.value = 1;

            if (card.dataset.image) {
                orderMenuImage.src = card.dataset.image;
                orderMenuImage.alt = card.dataset.title;
                orderMenuImage.style.display = 'block';
                orderMenuPlaceholder.style.display = 'none';
            } else {
                orderMenuImage.removeAttribute('src');
                orderMenuImage.style.display = 'none';
                orderMenuPlaceholder.style.display = 'block';
            }

            updateOrderTotal();
            orderModal.classList.add('active');
            orderModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            initDeliveryMap();
            document.getElementById('nama_pelanggan').focus();
        };

        const closeOrderModal = () => {
            orderModal.classList.remove('active');
            orderModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        document.querySelectorAll('.menu-card').forEach(card => {
            card.addEventListener('click', () => openOrderModal(card));
        });

        document.querySelectorAll('.menu-card-add').forEach(btn => {
            btn.addEventListener('click', function(event) {
                event.stopPropagation();
                openOrderModal(this.closest('.menu-card'));
            });
        });

        document.querySelectorAll('[data-close-modal]').forEach(element => {
            element.addEventListener('click', closeOrderModal);
        });

        jumlahInput.addEventListener('input', updateOrderTotal);

        useCurrentLocation.addEventListener('click', function() {
            if (!navigator.geolocation) {
                deliveryLocationText.textContent = 'Browser tidak mendukung lokasi otomatis.';
                return;
            }

            deliveryLocationText.textContent = 'Mengambil lokasi Anda...';
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    updateDeliveryLocation(position.coords.latitude, position.coords.longitude);
                },
                function() {
                    deliveryLocationText.textContent = 'Lokasi otomatis gagal. Pilih titik dari map.';
                },
                { enableHighAccuracy: true, timeout: 8000 }
            );
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && orderModal.classList.contains('active')) {
                closeOrderModal();
            }
        });

        // Status Pesanan
        const statusModal = document.getElementById('statusModal');
        const openStatusModal = document.getElementById('openStatusModal');
        const statusForm = document.getElementById('statusForm');
        const statusResults = document.getElementById('statusResults');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const openCustomerStatusModal = () => {
            statusModal.classList.add('active');
            statusModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            document.getElementById('statusNoHp').focus();
        };

        const closeCustomerStatusModal = () => {
            statusModal.classList.remove('active');
            statusModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        const escapeHtml = (value) => {
            return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char]));
        };

        const renderStatusOrders = (orders) => {
            if (!orders.length) {
                statusResults.innerHTML = '<div class="status-empty">Pesanan tidak ditemukan untuk nomor tersebut.</div>';
                return;
            }

            statusResults.innerHTML = orders.map(order => {
                const items = order.items.map(item => `${escapeHtml(item.nama || 'Menu')} x${escapeHtml(item.jumlah)}`).join(', ');
                const address = order.alamat ? `<p><strong>Alamat:</strong> ${escapeHtml(order.alamat)}</p>` : '';

                return `
                    <div class="status-card">
                        <div class="status-card-head">
                            <span class="status-code">${escapeHtml(order.kode)}</span>
                            <span class="status-badge ${escapeHtml(order.status)}">${escapeHtml(order.status_label)}</span>
                        </div>
                        <p><strong>Tanggal:</strong> ${escapeHtml(order.tanggal || '-')}</p>
                        <p><strong>Pesanan:</strong> ${items || '-'}</p>
                        <p><strong>Total:</strong> ${escapeHtml(order.total)}</p>
                        ${address}
                    </div>
                `;
            }).join('');
        };

        openStatusModal.addEventListener('click', openCustomerStatusModal);

        document.querySelectorAll('[data-close-status]').forEach(element => {
            element.addEventListener('click', closeCustomerStatusModal);
        });

        statusForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            statusResults.innerHTML = '<div class="status-empty">Mencari pesanan...</div>';

            try {
                const response = await fetch(window.AppConfig.routes.pesananStatus, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        no_hp: document.getElementById('statusNoHp').value,
                        kode_pesanan: document.getElementById('statusKode').value
                    })
                });

                if (!response.ok) {
                    throw new Error('Gagal mencari pesanan');
                }

                const data = await response.json();
                renderStatusOrders(data.orders || []);
            } catch (error) {
                statusResults.innerHTML = '<div class="status-empty">Status belum bisa dimuat. Coba beberapa saat lagi.</div>';
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && statusModal.classList.contains('active')) {
                closeCustomerStatusModal();
            }
        });