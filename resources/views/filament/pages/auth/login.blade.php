<div class="fixed inset-0 min-h-screen w-full flex bg-[#FAF8F5] dark:bg-[#0B0F19] overflow-hidden">
    <!-- Left Form Section (45%) -->
    <div class="w-full lg:w-[45%] xl:w-[40%] flex flex-col justify-between p-6 sm:p-12 overflow-y-auto z-10 bg-white dark:bg-[#121826] shadow-xl border-r border-[#E7E2DA] dark:border-[#232B3B]">
        <!-- Brand Masthead in Login -->
        <div class="pt-2">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-3.5 h-3.5 rounded-sm bg-[#C8102E] inline-block shadow-sm"></span>
                <span class="font-serif font-black text-2xl tracking-tight text-gray-950 dark:text-white" style="font-family: 'Playfair Display', Georgia, serif;">
                    {{ config('brand.name', 'The Chronicle') }}
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-zinc-400 font-mono tracking-wider uppercase">
                Editorial Management Suite & Newsroom CMS
            </p>
        </div>

        <!-- Center Login Card -->
        <div class="my-auto py-8 max-w-sm w-full mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-serif font-black text-gray-900 dark:text-white tracking-tight">
                    Sign in to your newsroom
                </h1>
                <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">
                    Enter your authorized staff credentials to continue.
                </p>
            </div>

            <!-- Demo Access Notification Banner -->
            <div class="mb-6 p-3.5 rounded-lg bg-amber-50/80 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/40 text-xs text-amber-900 dark:text-amber-200">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>1-Click Demo Access Ready</span>
                </div>
                <p class="text-[11px] text-amber-800 dark:text-amber-300">
                    Pre-filled: <code class="font-mono font-bold bg-amber-100 dark:bg-amber-900/60 px-1 py-0.5 rounded">admin@demo.com</code> / <code class="font-mono font-bold bg-amber-100 dark:bg-amber-900/60 px-1 py-0.5 rounded">password</code>
                </p>
            </div>

            <!-- Filament Form -->
            <x-filament-panels::form id="form" wire:submit="authenticate">
                {{ $this->form }}

                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
                />
            </x-filament-panels::form>
        </div>

        <!-- Footer Info -->
        <div class="pt-6 border-t border-gray-100 dark:border-zinc-800 text-[11px] text-gray-400 flex items-center justify-between">
            <span>© 2026 The Chronicle Media Group</span>
            <a href="/" class="text-[#C8102E] hover:underline font-medium">← Back to Website</a>
        </div>
    </div>

    <!-- Right Photo Section (55%) -->
    <div class="hidden lg:flex lg:w-[55%] xl:w-[60%] relative bg-cover bg-center overflow-hidden"
         style="background-image: url('https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=1600&q=80');">
        <!-- Dark Vignette Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/30"></div>

        <!-- Editorial Content on Photo -->
        <div class="relative z-10 m-auto max-w-xl p-12 text-white">
            <div class="w-10 h-10 rounded-sm bg-[#C8102E] text-white flex items-center justify-center font-serif font-black text-xl mb-6 shadow-2xl">
                C
            </div>

            <blockquote class="text-2xl sm:text-3xl font-serif font-bold italic leading-snug mb-6 text-zinc-100" style="font-family: 'Playfair Display', Georgia, serif;">
                "Journalism that holds power to account, informs citizens, and preserves democratic integrity across the globe."
            </blockquote>

            <div class="pt-6 border-t border-white/20 flex items-center justify-between text-xs font-mono tracking-widest uppercase text-zinc-300">
                <span>NEW DELHI • INTERNATIONAL DESK</span>
                <span class="text-[#C8102E] font-bold">ESTABLISHED 2026</span>
            </div>
        </div>
    </div>
</div>

