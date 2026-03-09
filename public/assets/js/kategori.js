$(document).ready(function() {
    // A. Selector untuk menangkap klik tombol
    $('#btnSimpan').on('click', function() {
        let form = document.getElementById('kategoriForm'); //

        // JURUS 1: Check Validity (Cek apakah input Required sudah terisi)
        if (form.checkValidity()) {
            
            // JURUS 2: Proteksi Double Submit (Tombol didisable)
            $(this).prop('disabled', true);
            
            // JURUS 3: Aktifkan Spinner (Response proses berjalan)
            $('#btnText').text('Menyimpan...');
            $('#btnSpinner').removeClass('d-none');

            // JURUS 4: Submit Form secara manual via Javascript
            form.submit();

        } else {
            // JURUS 5 (TAMBAHAN): Munculkan Notifikasi Alert dulu!
            alert("Waduh Alisya! Masih ada data yang kosong nih, tolong dicek lagi ya! 😅");

            // JURUS 6: Tunjukkan input mana yang kosong (Balon browser)
            form.reportValidity();
        }
    });
});