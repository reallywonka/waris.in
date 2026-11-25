<div id="globalConfirmModal" 
     x-data="{
         isOpen: false,
         title: 'Konfirmasi Tindakan',
         message: 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
         buttonText: 'Ya, Lanjutkan',
         cancelText: 'Batal',
         color: 'rose',
         icon: 'trash',
         note: '',
         onConfirmCallback: null,

         open(options = {}) {
             this.title = options.title || 'Konfirmasi Tindakan';
             this.message = options.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
             this.buttonText = options.buttonText || 'Ya, Lanjutkan';
             this.cancelText = options.cancelText || 'Batal';
             this.color = options.color || 'rose';
             this.icon = options.icon || 'trash';
             this.note = options.note || '';
             this.onConfirmCallback = options.onConfirm || null;
             this.isOpen = true;
             document.body.classList.add('overflow-y-hidden');
         },

         close() {
             this.isOpen = false;
             this.onConfirmCallback = null;
             document.body.classList.remove('overflow-y-hidden');
         },

         confirmAction() {
             const cb = this.onConfirmCallback;
             this.close();
             if (typeof cb === 'function') {
                 cb();
             }
         }
     }" 
     x-cloak
     x-show="isOpen" 
     @open-confirm-dialog.window="open($event.detail)"
     @close-confirm-dialog.window="close()"
     @keydown.escape.window="close()"
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;"
     aria-labelledby="confirm-modal-title" 
     role="dialog" 
     aria-modal="true">
    
    <!-- Backdrop Blur Overlay -->
    <div x-show="isOpen"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="close()" 
         class="fixed inset-0 bg-waris-text/60 backdrop-blur-xs transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <!-- Card Popup Dialog -->
        <div x-show="isOpen"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-3xl bg-waris-surface text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-waris-surface-muted p-6 space-y-4">
            
            <div class="flex items-start space-x-3.5">
                <!-- Icon Badge Dinamis -->
                <div :class="{
                    'bg-waris-danger-soft text-waris-danger border-waris-danger-border': color === 'rose' || color === 'danger' || color === 'red',
                    'bg-waris-accent-soft text-waris-accent-text border-waris-accent-border': color === 'amber' || color === 'warning' || color === 'yellow',
                    'bg-waris-primary-soft text-waris-primary border-waris-primary-border': color === 'emerald' || color === 'success' || color === 'green',
                    'bg-waris-info-soft text-waris-info border-waris-info-border': color === 'blue' || color === 'info'
                }" class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 border mt-0.5">
                    <template x-if="icon === 'trash'">
                        <x-icon name="trash" class="w-5 h-5" />
                    </template>
                    <template x-if="icon === 'x' || icon === 'close'">
                        <x-icon name="x" class="w-5 h-5" />
                    </template>
                    <template x-if="icon === 'alert-triangle' || icon === 'alert'">
                        <x-icon name="alert-triangle" class="w-5 h-5" />
                    </template>
                    <template x-if="icon === 'check-circle' || icon === 'check'">
                        <x-icon name="check-circle" class="w-5 h-5" />
                    </template>
                    <template x-if="icon === 'lock'">
                        <x-icon name="lock" class="w-5 h-5" />
                    </template>
                    <template x-if="icon === 'info'">
                        <x-icon name="info" class="w-5 h-5" />
                    </template>
                    <template x-if="!['trash', 'x', 'close', 'alert-triangle', 'alert', 'check-circle', 'check', 'lock', 'info'].includes(icon)">
                        <x-icon name="help-circle" class="w-5 h-5" />
                    </template>
                </div>
                
                <div class="min-w-0 flex-1">
                    <h3 class="text-base font-black text-waris-text tracking-tight" id="confirm-modal-title" x-text="title">
                        Konfirmasi Tindakan
                    </h3>
                    <p class="text-xs text-waris-subtle mt-1 leading-relaxed" x-text="message">
                        Apakah Anda yakin ingin melanjutkan tindakan ini?
                    </p>
                </div>
            </div>

            <!-- Box Catatan / Peringatan Tambahan (Opsional) -->
            <div x-show="note && note.length > 0" 
                 :class="{
                     'bg-waris-danger-soft border-waris-danger-border text-waris-danger-text': color === 'rose' || color === 'danger' || color === 'red',
                     'bg-waris-accent-soft border-waris-accent-border text-waris-accent-text': color === 'amber' || color === 'warning' || color === 'yellow',
                     'bg-waris-primary-soft border-waris-primary-border text-waris-primary': color === 'emerald' || color === 'success' || color === 'green',
                     'bg-waris-info-soft border-waris-info-border text-waris-info-text': color === 'blue' || color === 'info'
                 }" 
                 class="p-3.5 rounded-2xl border text-[11px] leading-relaxed font-medium" 
                 x-text="note"></div>

            <!-- Tombol Aksi Bawah -->
            <div class="pt-2 flex items-center justify-end space-x-2">
                <button type="button" 
                        @click="close()" 
                        class="px-4 py-2.5 rounded-xl border border-waris-border text-xs font-bold text-waris-muted hover:bg-waris-surface-muted hover:text-waris-text transition-colors cursor-pointer">
                    <span x-text="cancelText">Batal</span>
                </button>

                <button type="button" 
                        @click="confirmAction()"
                        :class="{
                            'bg-waris-danger hover:bg-waris-danger-hover text-white': color === 'rose' || color === 'danger' || color === 'red',
                            'bg-waris-accent hover:bg-waris-accent-hover text-white': color === 'amber' || color === 'warning' || color === 'yellow',
                            'bg-waris-primary hover:bg-waris-primary-hover text-white': color === 'emerald' || color === 'success' || color === 'green',
                            'bg-waris-info hover:bg-waris-info/90 text-white': color === 'blue' || color === 'info'
                        }"
                        class="px-5 py-2.5 rounded-xl text-xs font-black shadow-2xs hover:shadow-xs transition-all active:scale-[0.98] cursor-pointer">
                    <span x-text="buttonText">Ya, Lanjutkan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        window.showConfirmDialog = function (options) {
            window.dispatchEvent(new CustomEvent('open-confirm-dialog', { detail: options || {} }));
        };

        window.closeConfirmDialog = function () {
            window.dispatchEvent(new CustomEvent('close-confirm-dialog'));
        };

        // Global Event Listener untuk Form dengan atribut [data-confirm]
        document.addEventListener('submit', function (event) {
            var form = event.target;
            if (!form || !form.hasAttribute('data-confirm')) {
                return;
            }

            if (form.getAttribute('data-confirmed') === 'true') {
                form.removeAttribute('data-confirmed');
                return true;
            }

            event.preventDefault();
            event.stopPropagation();

            var message = form.getAttribute('data-confirm');
            var title = form.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan';
            var buttonText = form.getAttribute('data-confirm-button') || 'Ya, Lanjutkan';
            var cancelText = form.getAttribute('data-confirm-cancel') || 'Batal';
            var color = form.getAttribute('data-confirm-color') || 'rose';
            var icon = form.getAttribute('data-confirm-icon') || 'trash';
            var note = form.getAttribute('data-confirm-note') || '';

            window.showConfirmDialog({
                title: title,
                message: message,
                buttonText: buttonText,
                cancelText: cancelText,
                color: color,
                icon: icon,
                note: note,
                onConfirm: function () {
                    form.setAttribute('data-confirmed', 'true');
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    } else {
                        form.submit();
                    }
                }
            });

            return false;
        }, true);

        // Global Event Listener untuk tombol/link dengan atribut [data-confirm]
        document.addEventListener('click', function (event) {
            var el = event.target.closest('[data-confirm]');
            if (!el || el.tagName === 'FORM') {
                return;
            }

            // Jika tombol submit di dalam form yang sudah memiliki data-confirm
            if (el.tagName === 'BUTTON' && el.type === 'submit' && el.form && el.form.hasAttribute('data-confirm')) {
                return;
            }

            // Jika tombol submit di dalam form tanpa data-confirm pada form
            if (el.tagName === 'BUTTON' && el.type === 'submit' && el.form) {
                if (el.form.getAttribute('data-confirmed') === 'true') {
                    el.form.removeAttribute('data-confirmed');
                    return;
                }

                event.preventDefault();
                event.stopPropagation();

                var message = el.getAttribute('data-confirm');
                var title = el.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan';
                var buttonText = el.getAttribute('data-confirm-button') || 'Ya, Lanjutkan';
                var cancelText = el.getAttribute('data-confirm-cancel') || 'Batal';
                var color = el.getAttribute('data-confirm-color') || 'rose';
                var icon = el.getAttribute('data-confirm-icon') || 'trash';
                var note = el.getAttribute('data-confirm-note') || '';

                window.showConfirmDialog({
                    title: title,
                    message: message,
                    buttonText: buttonText,
                    cancelText: cancelText,
                    color: color,
                    icon: icon,
                    note: note,
                    onConfirm: function () {
                        el.form.setAttribute('data-confirmed', 'true');
                        if (typeof el.form.requestSubmit === 'function') {
                            el.form.requestSubmit(el);
                        } else {
                            el.form.submit();
                        }
                    }
                });
                return;
            }

            // Jika elemen berupa link <a>
            if (el.tagName === 'A' && el.href) {
                event.preventDefault();
                event.stopPropagation();

                var message = el.getAttribute('data-confirm');
                var title = el.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan';
                var buttonText = el.getAttribute('data-confirm-button') || 'Ya, Lanjutkan';
                var cancelText = el.getAttribute('data-confirm-cancel') || 'Batal';
                var color = el.getAttribute('data-confirm-color') || 'emerald';
                var icon = el.getAttribute('data-confirm-icon') || 'check-circle';
                var note = el.getAttribute('data-confirm-note') || '';

                window.showConfirmDialog({
                    title: title,
                    message: message,
                    buttonText: buttonText,
                    cancelText: cancelText,
                    color: color,
                    icon: icon,
                    note: note,
                    onConfirm: function () {
                        window.location.href = el.href;
                    }
                });
            }
        }, true);
    })();
</script>
