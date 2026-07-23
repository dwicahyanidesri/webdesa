import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// -----------------------------------------------------------------------
// Validasi ukuran file di sisi browser (sebelum sempat dikirim ke server).
//
// PHP (khususnya server bawaan "php artisan serve") kadang langsung memutus
// koneksi kalau berkas yang diupload melebihi batas server (upload_max_filesize
// / post_max_size), sehingga halaman jadi kosong dan pesan error dari Laravel
// tidak sempat sampai ke browser sama sekali. Supaya pengguna SELALU dapat
// peringatan yang jelas, ukuran file dicek dulu di sini sebelum form dikirim.
// -----------------------------------------------------------------------
const MAX_UPLOAD_BYTES = 2 * 1024 * 1024; // 2MB, samakan dengan batas validasi di server

function formatUkuranFile(bytes) {
    if (bytes >= 1024 * 1024) {
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    return Math.round(bytes / 1024) + ' KB';
}

function evaluateForm(form) {
    if (!form) return;

    const adaYangInvalid = Array.from(form.querySelectorAll('input[type="file"][data-size-guard]'))
        .some((el) => el.dataset.sizeInvalid === '1');

    form.querySelectorAll('button[type="submit"]').forEach((btn) => {
        btn.disabled = adaYangInvalid;
        btn.classList.toggle('opacity-50', adaYangInvalid);
        btn.classList.toggle('cursor-not-allowed', adaYangInvalid);
    });
}

function attachFileSizeGuard(input) {
    if (input.dataset.sizeGuardAttached === '1') return;
    input.dataset.sizeGuardAttached = '1';
    input.dataset.sizeGuard = '1';

    const warning = document.createElement('p');
    warning.className = 'mt-1.5 text-xs font-medium text-red-600 hidden';
    input.insertAdjacentElement('afterend', warning);

    input.addEventListener('change', () => {
        const file = input.files && input.files[0];
        const form = input.closest('form');

        if (file && file.size > MAX_UPLOAD_BYTES) {
            warning.textContent = `Ukuran file (${formatUkuranFile(file.size)}) melebihi batas maksimal 2Mb. Silakan pilih file lain.`;
            warning.classList.remove('hidden');
            input.classList.add('border-red-400');
            input.dataset.sizeInvalid = '1';
            input.value = '';
        } else {
            warning.classList.add('hidden');
            input.classList.remove('border-red-400');
            input.dataset.sizeInvalid = '0';
        }

        evaluateForm(form);
    });
}

function initFileSizeGuards() {
    document.querySelectorAll('input[type="file"]').forEach(attachFileSizeGuard);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFileSizeGuards);
} else {
    initFileSizeGuards();
}
