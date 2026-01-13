</div>
</section>
</div>
<!-- <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Versi</b> 1.0.0
    </div>
    <strong>Hak Cipta &copy; <?php echo date('Y'); ?> <a href="#">Nama Sekolah Anda</a>.</strong> Dibuat dengan AdminLTE.
</footer> -->

</div>
<script src="<?php echo BASEURL; ?>/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BASEURL; ?>/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASEURL; ?>/adminlte/dist/js/adminlte.min.js"></script>
<script>
    const BASEURL = '<?php echo BASEURL; ?>';
</script>

<script src="<?php echo BASEURL; ?>/js/script.js"></script>

<script>
    if (document.getElementById('semester_input')) {

        function gantiKonteksRapor() {
            // 1. Ambil ID siswa
            const idSiswa = document.querySelector('input[name="id_siswa"]').value;

            // 2. Ambil nilai semester
            const semester = document.getElementById('semester_input').value;

            // 3. Ambil nilai TAHUN MULAI (cth: 2024)
            const ta_mulai = document.getElementById('tahun_ajaran_mulai').value;

            // 4. Buat string URL (cth: 2024-2025)
            const ta_akhir = parseInt(ta_mulai) + 1;
            const ta_url = ta_mulai + '-' + ta_akhir;

            // 5. Reload halaman ke URL baru
            window.location.href = BASEURL + '/rapor/input/' + idSiswa + '/' + semester + '/' + ta_url;
        }

        // Fungsi untuk update tampilan '.../2025'
        function updateTampilanTahun() {
            const ta_mulai = document.getElementById('tahun_ajaran_mulai').value;
            const ta_akhir = parseInt(ta_mulai) + 1;

            // Update teks span
            document.getElementById('tahun_ajaran_akhir').textContent = '/' + ta_akhir;

            // Update input hidden
            document.getElementById('tahun_ajaran').value = ta_mulai + '/' + ta_akhir;
        }

        // Pasang "pendengar" ke kedua dropdown
        document.getElementById('semester_input').addEventListener('change', gantiKonteksRapor);
        document.getElementById('tahun_ajaran_mulai').addEventListener('change', function() {
            // Saat tahun ajaran ganti:
            // 1. Update dulu tampilannya
            updateTampilanTahun();
            // 2. Baru reload halaman
            gantiKonteksRapor();
        });
    }
</script>
<script>
    // Cek apakah tombol #btn_cari_rapor ada di halaman ini
    if (document.getElementById('btn_cari_rapor')) {

        // Fungsi untuk memuat data
        function muatDataRapor() {
            // Tampilkan loading
            $('#hasil_pencarian_rapor').html('<p class="p-3 text-muted text-center">Mencari data...</p>');

            // Ambil semua nilai filter
            var keyword = $('#filter_keyword').val();
            var tahun_ajaran = $('#filter_ta').val();
            var semester = $('#filter_semester').val();
            var kelas = $('#filter_kelas').val();

            // Kirim via AJAX (POST) ke controller Cetak/getDaftarSiswa
            $.ajax({
                url: BASEURL + '/cetak/getDaftarSiswa',
                data: {
                    keyword: keyword,
                    tahun_ajaran: tahun_ajaran,
                    semester: semester,
                    kelas: kelas
                },
                method: 'post',
                success: function(data) {
                    // Masukkan hasil HTML dari 'ajax_daftar_siswa.php'
                    // ke dalam div #hasil_pencarian_rapor
                    $('#hasil_pencarian_rapor').html(data);
                }
            });
        }

        // Jalankan fungsi saat tombol "Cari" diklik
        $('#btn_cari_rapor').on('click', function() {
            muatDataRapor();
        });

        // (Opsional) Jalankan fungsi saat menekan Enter di search bar
        $('#filter_keyword').on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                muatDataRapor();
            }
        });
    }
</script>
</body>
</html>
</body>

</html>