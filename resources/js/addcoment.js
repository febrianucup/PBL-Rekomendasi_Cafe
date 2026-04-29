// Tunggu sampai DOM selesai dimuat
document.addEventListener('DOMContentLoaded', function () {
    const btnAdd = document.getElementById('btn-add-comment');
    const container = document.getElementById('comment-form-container');
    const btnClose = document.getElementById('btn-close-comment');

    if (btnAdd && container) {
        btnAdd.addEventListener('click', function () {
            // Menghapus class 'hidden' dari Tailwind agar muncul
            container.classList.remove('hidden');
            // Sembunyikan tombol 'Add Comment' agar tidak double
            btnAdd.classList.add('hidden');
        });
    }

    if (btnClose) {
        btnClose.addEventListener('click', function () {
            container.classList.add('hidden');
            btnAdd.classList.remove('hidden');
        });
    }
});
