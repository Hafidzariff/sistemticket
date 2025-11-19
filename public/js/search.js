// File: public/js/search.js

document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var searchValue = this.value.toLowerCase();

            // Panggil fungsi pencarian sesuai kebutuhan
            // Contohnya, sesuaikan dengan halaman yang sedang dibuka
            if (document.body.id === 'dashboard') {
                searchInDashboardTable(searchValue);
            } else if (document.body.id === 'produk') {
                searchInTable('produkTable', searchValue);
            } else if (document.body.id === 'alternatif') {
                searchInTable('alternatifTable', searchValue);
            } else if (document.body.id === 'kategori') {
                searchInTable('kategoriTable', searchValue);
            } else if (document.body.id === 'transaksigudang') {
                searchInTable('transaksiGudangTable', searchValue);
            } else if (document.body.id === 'transaksitoko') {
                searchInTable('transaksiTokoTable', searchValue);
            } else if (document.body.id === 'laporan') {
                searchInTable('laporanTable', searchValue);
            } else if (document.body.id === 'users') {
                searchInTable('usersTable', searchValue);
            } else if (document.body.id === 'setting') {
                // Sesuaikan jika diperlukan untuk halaman setting
            }
        });
    }
});

function searchInTable(tableId, keyword) {
    var tableRows = document.querySelectorAll('#' + tableId + ' tbody tr');

    tableRows.forEach(function (row) {
        var rowData = row.textContent.toLowerCase();

        // Tampilkan atau sembunyikan baris sesuai kriteria pencarian
        if (rowData.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Fungsi pencarian tambahan untuk halaman lainnya
function searchInDashboardTable(keyword) {
    // Implementasikan pencarian di dalam tabel dashboard
    // Sesuaikan dengan struktur tabel dan implementasi pencarian Anda
}

// Tambahkan fungsi serupa untuk halaman lain jika diperlukan
