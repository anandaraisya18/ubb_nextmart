@if(session('success') || session('error'))

    <div
        id="global-alert-toast"
        class="fixed top-20 right-5 z-[100] transition-all duration-300"
    >

        <div class="flex items-center gap-3
                    bg-[#001840]
                    {{ session('error') ? 'border border-red-500/30' : 'border border-[#F5C400]/30' }}
                    text-white
                    px-5 py-4
                    rounded-xl
                    shadow-2xl">

            <div class="w-8 h-8 rounded-full
                        {{ session('error') ? 'bg-red-500/20 text-red-400' : 'bg-[#F5C400] text-[#001840]' }}
                        flex items-center justify-center">

                {{ session('error') ? '!' : '✓' }}

            </div>

            <div>

                <p class="text-sm font-semibold">
                    {{ session('error') ? 'Terjadi Kesalahan' : 'Berhasil' }}
                </p>

                <p class="text-xs text-white/60">
                    {{ session('error') ?? session('success') }}
                </p>

            </div>

            <button
                type="button"
                onclick="this.closest('#global-alert-toast')?.remove()"
                class="ml-2 text-white/50 hover:text-white"
                aria-label="Tutup"
            >
                ✕
            </button>

        </div>

    </div>

    <script>
        (() => {
            const initAlertToast = () => {
                const toast = document.getElementById('global-alert-toast');

                if (!toast || toast.dataset.timerStarted === 'true') return;

                toast.dataset.timerStarted = 'true';

                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-x-4');

                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAlertToast, { once: true });
            } else {
                initAlertToast();
            }
        })();
    </script>

@endif
