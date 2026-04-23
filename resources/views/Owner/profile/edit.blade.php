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
                <a href="#" class="text-sm text-muted px-2">Inventory</a>
                <a href="#" class="text-sm text-muted px-2">Staff</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="text-muted text-base">🔔</button>
            <button class="text-muted text-base">⚙️</button>
            <div class="w-8 h-8 rounded-full bg-[#D6C9BD] flex items-center justify-center text-xs font-semibold text-[#4A4037]">JS</div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <div class="max-w-2xl mx-auto px-6 py-8">

        <!-- BREADCRUMB -->
        <div class="flex items-center gap-2 text-[10px] uppercase tracking-[0.18em] text-muted mb-6">
            <a href="#" class="hover:text-dark transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-dark font-semibold">Add New Branch</span>
        </div>

        <!-- PAGE TITLE -->
        <h1 class="text-3xl font-semibold text-dark mb-2">Craft a New Experience</h1>
        <p class="text-xs text-muted mb-10 max-w-xs leading-relaxed">Define the atmosphere, location, and essence of your newest sensory destination.</p>

        <!-- SECTION 01: Identity -->
        <section class="mb-8">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-7 h-7 rounded-full bg-active text-white text-[11px] font-semibold flex items-center justify-center">01</span>
                <h2 class="text-base font-semibold text-dark">Identity</h2>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Cafe Name</label>
                    <input type="text" placeholder="e.g., The Velvet Bean"
                        class="w-full bg-white border border-border rounded-xl px-4 py-2.5 text-sm text-dark placeholder-[#B5AFA9] focus:outline-none focus:border-muted" />
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Tagline</label>
                    <input type="text" placeholder="Briefly describe the soul of the place..."
                        class="w-full bg-white border border-border rounded-xl px-4 py-2.5 text-sm text-dark placeholder-[#B5AFA9] focus:outline-none focus:border-muted" />
                </div>
            </div>
        </section>

        <!-- SECTION 02: Placement -->
        <section class="mb-8">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-7 h-7 rounded-full bg-active text-white text-[11px] font-semibold flex items-center justify-center">02</span>
                <h2 class="text-base font-semibold text-dark">Placement</h2>
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Location / Address</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-muted text-sm">📍</span>
                    <input type="text" placeholder="123 Sensory Lane, Art District"
                        class="w-full bg-white border border-border rounded-xl pl-10 pr-4 py-2.5 text-sm text-dark placeholder-[#B5AFA9] focus:outline-none focus:border-muted" />
                </div>
            </div>
        </section>

        <!-- SECTION 03: The Narrative -->
        <section class="mb-8">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-7 h-7 rounded-full bg-active text-white text-[11px] font-semibold flex items-center justify-center">03</span>
                <h2 class="text-base font-semibold text-dark">The Narrative</h2>
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-[0.18em] text-muted mb-1.5">Description</label>
                <textarea rows="5" placeholder="Share the history, the vibe, and the unique sensory elements guests can expect..."
                    class="w-full bg-white border border-border rounded-xl px-4 py-3 text-sm text-dark placeholder-[#B5AFA9] focus:outline-none focus:border-muted resize-none"></textarea>
            </div>
        </section>

        <!-- SECTION 04: Visual Gallery -->
        <section class="mb-10">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-7 h-7 rounded-full bg-active text-white text-[11px] font-semibold flex items-center justify-center">04</span>
                <h2 class="text-base font-semibold text-dark">Visual Gallery</h2>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-3" id="gallery-grid">

                <!-- Upload slot -->
                <div class="rounded-2xl border-2 border-dashed border-border bg-white aspect-square flex flex-col items-center justify-center cursor-pointer hover:bg-stat transition-colors" id="upload-slot" onclick="document.getElementById('file-input').click()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-muted mb-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="3" stroke="currentColor" fill="none"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8" />
                    </svg>
                    <span class="text-[10px] uppercase tracking-widest text-muted">Add Image</span>
                </div>
                <input type="file" id="file-input" accept="image/*" multiple class="hidden" onchange="handleImageUpload(event)" />

                <!-- Preview images -->
                <div class="relative group rounded-2xl overflow-hidden aspect-square">
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=400&q=80"
                        alt="cafe interior" class="w-full h-full object-cover" />
                    <button onclick="removeImage(this)" class="absolute top-2 right-2 w-5 h-5 bg-white rounded-full text-[10px] text-muted shadow flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                </div>

                <div class="relative group rounded-2xl overflow-hidden aspect-square">
                    <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=400&q=80"
                        alt="latte art" class="w-full h-full object-cover" />
                    <button onclick="removeImage(this)" class="absolute top-2 right-2 w-5 h-5 bg-white rounded-full text-[10px] text-muted shadow flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                </div>

            </div>
            <p class="text-[10px] text-muted">Upload up to 12 high-resolution images. Suggestions of mood, lighting, and texture.</p>
        </section>

        <!-- BOTTOM ACTIONS -->
        <div class="flex items-center gap-3 pb-12">
            <button class="bg-darkbrown text-white text-sm font-semibold rounded-full px-8 py-3.5 hover:bg-[#1e1a16] transition-colors">
                Establish Branch
            </button>
            <button class="bg-white border border-border text-dark text-sm font-semibold rounded-full px-8 py-3.5 hover:bg-stat transition-colors">
                Save Draft
            </button>
        </div>

    </div>

    <script>
        function handleImageUpload(event) {
            const files = Array.from(event.target.files);
            const grid = document.getElementById('gallery-grid');
            const uploadSlot = document.getElementById('upload-slot');

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'relative group rounded-2xl overflow-hidden aspect-square';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="uploaded" class="w-full h-full object-cover" />
                        <button onclick="removeImage(this)" class="absolute top-2 right-2 w-5 h-5 bg-white rounded-full text-[10px] text-muted shadow flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                    `;
                    grid.insertBefore(div, uploadSlot);
                };
                reader.readAsDataURL(file);
            });

            event.target.value = '';
        }

        function removeImage(btn) {
            btn.closest('.relative').remove();
        }
    </script>

</body>
</html>