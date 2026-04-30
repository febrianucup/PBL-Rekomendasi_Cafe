<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Branch</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Instrument Sans', 'sans-serif'] },
                    colors: {
                        cream: '#F7F5F0',
                        dark: '#1B1B18',
                        muted: '#6B635A',
                        border: '#E3E3E0',
                        stat: '#F7F3EE',
                        brown: '#6B4F3B',
                        darkbrown: '#2C2720',
                        active: '#3F4C40',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream font-sans text-dark min-h-screen">

    <!-- TOP NAVBAR -->
    <nav class="flex items-center justify-between px-7 py-3.5 border-b border-border bg-cream">
        <div class="flex items-center gap-7">
            <span class="font-semibold text-sm">Sensory Editorial</span>
            <div class="flex gap-1">
                <a href="#" class="text-sm font-semibold text-dark border-b-2 border-dark pb-0.5 px-2">Branches</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="text-muted text-sm">🔔</button>
            <button class="text-muted text-sm">⚙️</button>
            <div class="w-8 h-8 rounded-full bg-[#D6C9BD] flex items-center justify-center text-xs font-semibold text-[#4A4037]">JS</div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <div class="max-w-2xl mx-auto px-6 py-8">

        <!-- BACK LINK -->
        <a href="{{ route('cafe.edit') }}" class="text-[11px] uppercase tracking-[0.18em] text-muted flex items-center gap-1 mb-5 hover:text-dark transition-colors">
            ← BACK TO BRANCHES
        </a>

        <!-- PAGE TITLE -->
        <h1 class="text-3xl font-semibold text-dark mb-1">Edit Cafe Owner</h1>
        <p class="text-xs text-muted mb-8 max-w-sm">Refine your café's presence. Update your story, operating rhythm, and sensory offerings for your community.</p>

        <!-- SECTION: General Information -->
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">General Information</h2>
            <div class="bg-white border border-border rounded-2xl p-5 space-y-4">

                <!-- Cafe Name -->
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Cafe Name</label>
                    <input type="text" value="Velvet & Vine"
                        class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                </div>

                <!-- Brand Editorial Description -->
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Brand Editorial Description</label>
                    <textarea rows="4"
                        class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted resize-none">Velvet & Vine is an artisanal retreat where the richness of boutique coffee meets the elegance of locally sourced botanicals. Founded in 2019, we specialize in sensory exploration through small-batch roasts and curated greenery.</textarea>
                </div>

                <!-- Establishment Type + Atmospheric Tag -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Establishment Type</label>
                        <div class="relative">
                            <select class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark appearance-none focus:outline-none focus:border-muted cursor-pointer">
                                <option>Artisan Café & Garden</option>
                                <option>Coffee Shop</option>
                                <option>Bistro</option>
                                <option>Bakery Café</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-muted text-xs pointer-events-none">▾</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Atmospheric Tag</label>
                        <div class="flex flex-wrap items-center gap-2 mt-1">
                            <span class="bg-[#E8E4DE] text-dark text-[11px] font-medium px-3 py-1 rounded-full">Quiet Study</span>
                            <span class="bg-active text-white text-[11px] font-medium px-3 py-1 rounded-full">Garden View</span>
                            <button class="text-[11px] text-muted border border-border rounded-full px-2.5 py-1 hover:bg-stat transition-colors">+ Add</button>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION: Opening Hours -->
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">Opening Hours</h2>
            <div class="bg-white border border-border rounded-2xl overflow-hidden">

                <!-- Mon-Fri -->
                <div class="flex items-center justify-between px-5 py-4 border-b border-border">
                    <span class="text-sm font-semibold text-dark w-24">Mon - Fri</span>
                    <div class="flex items-center gap-3 flex-1">
                        <input type="time" value="07:00"
                            class="bg-cream border border-border rounded-xl px-3 py-2 text-sm text-dark focus:outline-none w-32" />
                        <span class="text-muted text-sm">—</span>
                        <input type="time" value="19:00"
                            class="bg-cream border border-border rounded-xl px-3 py-2 text-sm text-dark focus:outline-none w-32" />
                    </div>
                </div>

                <!-- Saturday -->
                <div class="flex items-center justify-between px-5 py-4 border-b border-border">
                    <span class="text-sm font-semibold text-dark w-24">Saturday</span>
                    <div class="flex items-center gap-3 flex-1">
                        <input type="time" value="08:00"
                            class="bg-cream border border-border rounded-xl px-3 py-2 text-sm text-dark focus:outline-none w-32" />
                        <span class="text-muted text-sm">—</span>
                        <input type="time" value="21:00"
                            class="bg-cream border border-border rounded-xl px-3 py-2 text-sm text-dark focus:outline-none w-32" />
                    </div>
                </div>

                <!-- Sunday -->
                <div class="flex items-center justify-between px-5 py-4">
                    <span class="text-sm font-semibold text-dark w-24">Sunday</span>
                    <div class="flex items-center gap-3 flex-1">
                        <input type="time" value="09:00"
                            class="bg-cream border border-border rounded-xl px-3 py-2 text-sm text-dark focus:outline-none w-32" />
                        <span class="text-muted text-sm">—</span>
                        <input type="time" value="17:00"
                            class="bg-cream border border-border rounded-xl px-3 py-2 text-sm text-dark focus:outline-none w-32" />
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION: Contact Details -->
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">Contact Details</h2>
            <div class="bg-white border border-border rounded-2xl p-5 space-y-4">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Phone Number</label>
                        <input type="tel" value="+1 (885) 251-8501"
                            class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Email Address</label>
                        <input type="email" value="hello@velvetvine.com"
                            class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Address</label>
                    <input type="text" value="442 Artisan Way, Seattle, WA 98101"
                        class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                </div>

            </div>
        </section>

        <!-- SECTION: Location & Maps -->
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">Location & Maps</h2>
            <div class="bg-white border border-border rounded-2xl p-5 space-y-4">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Latitude</label>
                        <input type="text" placeholder="e.g., 47.6062" value="47.6062"
                            class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Longitude</label>
                        <input type="text" placeholder="e.g., -122.3321" value="-122.3321"
                            class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Google Maps Link</label>
                    <input type="url" placeholder="https://maps.google.com/maps?q=..." value="https://maps.google.com/maps?q=47.6062,-122.3321"
                        class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                    <p class="text-[10px] text-muted mt-2">Get this link from Google Maps by right-clicking on your location and selecting "Copy link"</p>
                </div>

            </div>
        </section>

        <!-- SECTION: Photo Gallery -->
        <section class="mb-8">
            <h2 class="text-base font-semibold text-dark mb-4">Photo Gallery</h2>
            <div class="bg-white border border-border rounded-2xl p-5">
                <div class="grid grid-cols-4 gap-3" id="photo-gallery">

                    <!-- Upload Area -->
                    <div class="relative group rounded-xl overflow-hidden aspect-square border-2 border-dashed border-border flex flex-col items-center justify-center cursor-pointer hover:bg-stat transition-colors" onclick="document.getElementById('photo-input').click()" id="upload-area">
                        <span class="text-lg text-muted">⊕</span>
                        <span class="text-[10px] text-muted mt-1 uppercase tracking-wider">Upload</span>
                        <input type="file" id="photo-input" accept="image/*" multiple style="display: none;" onchange="handlePhotoUpload(event)" />
                    </div>

                    <!-- Photo 1 -->
                    <div class="relative group rounded-xl overflow-hidden aspect-square">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=300&q=80"
                            alt="cafe" class="w-full h-full object-cover" />
                        <button type="button" onclick="removePhoto(this)" class="absolute top-1.5 right-1.5 w-5 h-5 bg-white rounded-full flex items-center justify-center text-[10px] text-muted shadow opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                    </div>

                    <!-- Photo 2 -->
                    <div class="relative group rounded-xl overflow-hidden aspect-square">
                        <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=300&q=80"
                            alt="latte" class="w-full h-full object-cover" />
                        <button type="button" onclick="removePhoto(this)" class="absolute top-1.5 right-1.5 w-5 h-5 bg-white rounded-full flex items-center justify-center text-[10px] text-muted shadow opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                    </div>

                    <!-- Photo 3 -->
                    <div class="relative group rounded-xl overflow-hidden aspect-square">
                        <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&w=300&q=80"
                            alt="coffee grinder" class="w-full h-full object-cover" />
                        <button type="button" onclick="removePhoto(this)" class="absolute top-1.5 right-1.5 w-5 h-5 bg-white rounded-full flex items-center justify-center text-[10px] text-muted shadow opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                    </div>

                </div>
                <p class="text-[10px] text-muted mt-3">Upload multiple images (recommended: at least 4-6 photos). Maximum 12 images.</p>
            </div>
        </section>

        <!-- SECTION: Featured Menu -->
        <section class="mb-10">
            <h2 class="text-base font-semibold text-dark mb-4">Featured Menu</h2>
            <div class="bg-white border border-border rounded-2xl overflow-hidden" id="menu-section">

                <div id="menu-list">
                    <!-- Menu Item 1 -->
                    <div class="menu-item flex items-center justify-between px-5 py-4 border-b border-border">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=100&q=80"
                                    alt="Velvet Latte" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-dark">The Velvet Latte</p>
                                <p class="text-xs text-muted">Signature espresso with lavender infused milk</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="menu-price text-sm font-semibold text-dark">Rp 65.000</span>
                            <button type="button" class="text-muted hover:text-red-500 transition-colors text-sm" onclick="removeMenuItem(this)">✕</button>
                        </div>
                    </div>

                    <!-- Menu Item 2 -->
                    <div class="menu-item flex items-center justify-between px-5 py-4 border-b border-border">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&w=100&q=80"
                                    alt="Emerald Tartine" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-dark">Emerald Tartine</p>
                                <p class="text-xs text-muted">Smashed avocado, radish and micro herbs</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="menu-price text-sm font-semibold text-dark">Rp 140.000</span>
                            <button type="button" class="text-muted hover:text-red-500 transition-colors text-sm" onclick="removeMenuItem(this)">✕</button>
                        </div>
                    </div>
                </div>

                <div id="new-menu-form" class="hidden px-5 py-4 border-b border-border space-y-3">
                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Menu Name</label>
                            <input type="text" id="menu-name" placeholder="Menu name"
                                class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                        </div>
                        <div class="col-span-12 md:col-span-5">
                            <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Description</label>
                            <input type="text" id="menu-description" placeholder="Short description"
                                class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" />
                        </div>
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Price (Rupiah)</label>
                            <input type="text" id="menu-price" placeholder="Rp 35.000"
                                class="w-full bg-cream border border-border rounded-xl px-4 py-2.5 text-sm text-dark focus:outline-none focus:border-muted" onblur="formatPriceInput(this)" />
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-3 items-end">
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Photo</label>
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="document.getElementById('menu-image-input').click()" class="bg-[#F2EEE7] border border-border text-dark text-sm font-semibold rounded-xl px-4 py-2.5 hover:bg-stat transition-colors">Upload Image</button>
                                <span id="menu-image-name" class="text-[10px] text-muted">No file chosen</span>
                            </div>
                            <input type="file" id="menu-image-input" accept="image/*" style="display: none;" onchange="handleMenuImageUpload(event)" />
                        </div>
                        <div class="col-span-12 md:col-span-8">
                            <div id="menu-image-preview" class="h-20 rounded-2xl border border-border bg-[#F7F5F0] flex items-center justify-center text-[10px] text-muted overflow-hidden">
                                Preview image akan muncul di sini
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="saveMenuItem()" class="bg-darkbrown text-white text-sm font-semibold rounded-full px-5 py-3 hover:bg-[#1e1a16] transition-colors">Add Menu</button>
                        <button type="button" onclick="toggleNewMenuForm(false)" class="bg-white border border-border text-dark text-sm font-semibold rounded-full px-5 py-3 hover:bg-stat transition-colors">Cancel</button>
                    </div>
                </div>

                <div class="flex items-center justify-center px-5 py-3.5 cursor-pointer hover:bg-stat transition-colors" onclick="toggleNewMenuForm(true)">
                    <span class="text-xs text-muted font-medium">+ add menu item</span>
                </div>

            </div>
        </section>

        <!-- BOTTOM ACTIONS -->
        <div class="flex items-center gap-3 pb-10">
            <button class="flex-1 bg-darkbrown text-white text-sm font-semibold rounded-full py-3.5 hover:bg-[#1e1a16] transition-colors">
                Publish Changes
            </button>
            <button class="bg-white border border-border text-dark text-sm font-semibold rounded-full px-8 py-3.5 hover:bg-stat transition-colors">
                Discard
            </button>
        </div>

    </div>

    <script>
        function handlePhotoUpload(event) {
            const files = Array.from(event.target.files);
            const gallery = document.getElementById('photo-gallery');
            const uploadArea = document.getElementById('upload-area');
            const currentPhotos = gallery.querySelectorAll('[class*="group"]').length - 1; // Exclude upload area
            
            // Limit to 12 photos total
            if (currentPhotos + files.length > 12) {
                alert('Maximum 12 photos allowed. You already have ' + currentPhotos + ' photos.');
                return;
            }

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const photoDiv = document.createElement('div');
                    photoDiv.className = 'relative group rounded-xl overflow-hidden aspect-square';
                    photoDiv.innerHTML = `
                        <img src="${e.target.result}" alt="cafe photo" class="w-full h-full object-cover" />
                        <button type="button" onclick="removePhoto(this)" class="absolute top-1.5 right-1.5 w-5 h-5 bg-white rounded-full flex items-center justify-center text-[10px] text-muted shadow opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                    `;
                    gallery.insertBefore(photoDiv, uploadArea.nextSibling);
                };
                reader.readAsDataURL(file);
            });

            // Reset input
            event.target.value = '';
        }

        function removePhoto(button) {
            button.closest('.relative').remove();
        }

        function toggleNewMenuForm(show) {
            const form = document.getElementById('new-menu-form');
            if (show) {
                form.classList.remove('hidden');
                document.getElementById('menu-name').focus();
            } else {
                form.classList.add('hidden');
                clearNewMenuFields();
            }
        }

        function formatPriceInput(input) {
            const formatted = formatRupiah(input.value);
            input.value = formatted;
        }

        function formatRupiah(value) {
            const angka = value.replace(/[^0-9]/g, '');
            if (!angka) return '';
            return 'Rp ' + angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function saveMenuItem() {
            const nameInput = document.getElementById('menu-name');
            const descInput = document.getElementById('menu-description');
            const priceInput = document.getElementById('menu-price');
            const imageInput = document.getElementById('menu-image-input');
            const name = nameInput.value.trim();
            const description = descInput.value.trim();
            const price = formatRupiah(priceInput.value.trim());
            const imagePreview = document.getElementById('menu-image-preview');
            const imageData = imagePreview.dataset.image || '';

            if (!name) {
                alert('Masukkan nama menu terlebih dahulu.');
                nameInput.focus();
                return;
            }
            if (!price) {
                alert('Masukkan harga menu dalam format Rupiah.');
                priceInput.focus();
                return;
            }

            const menuList = document.getElementById('menu-list');
            const menuItem = document.createElement('div');
            menuItem.className = 'menu-item flex items-center justify-between px-5 py-4 border-b border-border';
            menuItem.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl overflow-hidden ${imageData ? '' : 'bg-[#f5f1ec] flex items-center justify-center text-xs text-muted'}">
                        ${imageData ? `<img src="${escapeHtml(imageData)}" alt="menu image" class="w-full h-full object-cover" />` : 'IMG'}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-dark">${escapeHtml(name)}</p>
                        <p class="text-xs text-muted">${escapeHtml(description)}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="menu-price text-sm font-semibold text-dark">${escapeHtml(price)}</span>
                    <button type="button" class="text-muted hover:text-red-500 transition-colors text-sm" onclick="removeMenuItem(this)">✕</button>
                </div>
            `;
            menuList.appendChild(menuItem);
            toggleNewMenuForm(false);
        }

        function handleMenuImageUpload(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('menu-image-preview');
            const fileName = document.getElementById('menu-image-name');
            if (!file) {
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.innerHTML = `<img src="${escapeHtml(e.target.result)}" alt="menu preview" class="w-full h-full object-cover" />`;
                preview.dataset.image = e.target.result;
                fileName.textContent = file.name;
            };
            reader.readAsDataURL(file);
        }

        function removeMenuItem(button) {
            const menuItem = button.closest('.menu-item');
            if (menuItem) {
                menuItem.remove();
            }
        }

        function clearNewMenuFields() {
            document.getElementById('menu-name').value = '';
            document.getElementById('menu-description').value = '';
            document.getElementById('menu-price').value = '';
            document.getElementById('menu-image-input').value = '';
            const preview = document.getElementById('menu-image-preview');
            preview.innerHTML = 'Preview image akan muncul di sini';
            preview.dataset.image = '';
            document.getElementById('menu-image-name').textContent = 'No file chosen';
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }
    </script>

</body>
</html>