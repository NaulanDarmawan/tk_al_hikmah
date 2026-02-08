<div class="row">
    <div class="col-md-6">
        <div class="card card-info card-outline shadow-sm" style="border-radius: 15px;">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-journal-whills mr-2 text-info"></i> Rekap Jurnal Harian Siswa
                </h3>
            </div>
            <div class="card-body">
                <form action="<?= BASEURL; ?>/laporan/harian_pdf" method="post" target="_blank">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Pilih Peserta Didik:</label>
                        <select name="id_siswa" class="form-control select2 shadow-sm" style="width: 100%; border-radius: 8px;" required>
                            <?php foreach($data['siswa'] as $s) : ?>
                                <option value="<?= $s['id']; ?>"><?= $s['nama_lengkap']; ?> (NIS: <?= $s['nis']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label class="font-weight-bold text-muted">Kelompok:</label>
                            <select name="kelompok" class="form-control shadow-sm" style="border-radius: 8px;">
                                <option value="A">Kelompok A</option>
                                <option value="B">Kelompok B</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="font-weight-bold text-muted">Mulai Tanggal:</label>
                            <input type="date" name="tgl_mulai" class="form-control shadow-sm" value="<?= date('Y-m-01'); ?>" style="border-radius: 8px;" required>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="font-weight-bold text-muted">Sampai Tanggal:</label>
                        <input type="date" name="tgl_selesai" class="form-control shadow-sm" value="<?= date('Y-m-d'); ?>" style="border-radius: 8px;" required>
                    </div>                    
                        <div class="">
                            <button type="submit" formaction="<?= BASEURL; ?>/laporan/harian_excel" class="btn btn-info btn-block shadow font-weight-bold py-3" style="border-radius: 12px;">
                                <i class="fas fa-file-excel mr-2"></i> CETAK LAPORAN
                            </button>
                        </div>                    
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card bg-light shadow-sm" style="border-radius: 15px; border: 2px dashed #17a2b8;">
            <div class="card-body text-center py-5">
                <i class="fas fa-info-circle fa-4x text-info mb-3"></i>
                <h4 class="font-weight-bold text-info">Informasi Jurnal</h4>
                <p class="text-muted px-3">
                    Gunakan fitur ini untuk mencetak rekapitulasi penilaian harian siswa beserta dokumentasi foto. Laporan ini dapat diberikan kepada orang tua murid sebagai laporan kemajuan berkala.
                </p>
                <div class="alert alert-warning mx-3 small">
                    <i class="fas fa-exclamation-triangle"></i> Pastikan rentang tanggal yang dipilih sudah memiliki data penilaian yang diinput.
                </div>
            </div>
        </div>
    </div>
</div>