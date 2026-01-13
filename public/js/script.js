// Pastikan script ini dijalankan setelah DOM (halaman) siap
$(function() {
    
    // 1. Logika untuk Tombol TAMBAH
    // Saat tombol 'Tambah Data Siswa' diklik
    $('#tombolTambahData').on('click', function() {
        // Set judul modal
        $('#judulModalLabel').html('Tambah Data Siswa');
        // Ubah tombol submit
        $('.modal-footer button[type=submit]').html('Simpan Data');
        // Set action form ke method 'tambah'
        $('.modal-body form').attr('action', BASEURL + '/siswa/tambah');
        
        // Kosongkan semua field form
        $('#id').val('');
        $('#nama_lengkap').val('');
        $('#nama_panggilan').val('');
        $('#nisn').val('');
        $('#nis').val('');
        $('#jenis_kelamin').val('Laki-laki');
        $('#tempat_lahir').val('');
        $('#tanggal_lahir').val('');
        $('#agama').val('Islam');
        $('#anak_ke').val('');
        $('#berat_badan').val('');
        $('#tinggi_badan').val('');
        $('#nama_ayah').val('');
        $('#pekerjaan_ayah').val('');
        $('#nama_ibu').val('');
        $('#pekerjaan_ibu').val('');
        $('#hp_ortu').val('');
        $('#alamat_jalan').val('');
        $('#kecamatan').val('');
        $('#kab_kota').val('');
        $('#provinsi').val('');
        $('#kode_pos').val('');
        $('#fotoLama').val('');
        $('#foto-preview').attr('src', BASEURL + '/img/default.jpg');
    });


    // 2. Logika untuk Tombol UBAH
    // Saat tombol 'Ubah' (dengan class 'tampilModalUbah') diklik
    $('.tampilModalUbah').on('click', function() {
        
        // Set judul modal
        $('#judulModalLabel').html('Ubah Data Siswa');
        // Ubah tombol submit
        $('.modal-footer button[type=submit]').html('Ubah Data');
        // Set action form ke method 'ubah'
        $('.modal-body form').attr('action', BASEURL + '/siswa/ubah');

        // Ambil 'data-id' yang ada di tombol
        const id = $(this).data('id');
        
        // Lakukan request AJAX untuk mengambil data
        $.ajax({
            // 'BASEURL' adalah variabel global dari PHP
            url: BASEURL + '/siswa/getubahdata',
            data: {id : id},
            method: 'post',
            dataType: 'json',
            success: function(data) {
                // Isi semua field form dengan data yang didapat
                $('#id').val(data.id);
                $('#nama_lengkap').val(data.nama_lengkap);
                $('#nama_panggilan').val(data.nama_panggilan);
                $('#nisn').val(data.nisn);
                $('#nis').val(data.nis);
                $('#jenis_kelamin').val(data.jenis_kelamin);
                $('#tempat_lahir').val(data.tempat_lahir);
                $('#tanggal_lahir').val(data.tanggal_lahir);
                $('#agama').val(data.agama);
                $('#anak_ke').val(data.anak_ke);
                $('#berat_badan').val(data.berat_badan);
                $('#tinggi_badan').val(data.tinggi_badan);
                $('#nama_ayah').val(data.nama_ayah);
                $('#pekerjaan_ayah').val(data.pekerjaan_ayah);
                $('#nama_ibu').val(data.nama_ibu);
                $('#pekerjaan_ibu').val(data.pekerjaan_ibu);
                $('#hp_ortu').val(data.hp_ortu);
                $('#alamat_jalan').val(data.alamat_jalan);
                $('#kecamatan').val(data.kecamatan);
                $('#kab_kota').val(data.kab_kota);
                $('#provinsi').val(data.provinsi);
                $('#kode_pos').val(data.kode_pos);
                $('#fotoLama').val(data.foto);
                $('#foto-preview').attr('src', BASEURL + '/img/' + data.foto);
            }
        });
    });
    function bacaGambar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#foto-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#foto").change(function(){
        bacaGambar(this);
    });
});