<div class="row">
    <div class="col-lg-12">
        <?php Flasher::flash(); ?>
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-8">
        <form action="<?php echo BASEURL; ?>/rapor" method="post">
            <div class="input-group">
                <input type="text" class="form-control"
                    placeholder="Cari nama siswa, NIS, atau NISN..."
                    name="keyword"
                    value="<?php echo $data['keyword']; ?>"
                    autocomplete="off">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="<?php echo BASEURL; ?>/rapor" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <?php if ($data['konteks_terakhir']) : ?>
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i>
        Konteks terakhir yang digunakan:
        <strong>Kelas <?php echo $data['konteks_terakhir']['kelas']; ?> |
            Semester <?php echo $data['konteks_terakhir']['semester']; ?> |
            TA: <?php echo $data['konteks_terakhir']['tahun_ajaran']; ?></strong>
        Form input siswa berikutnya akan diisi otomatis dengan data ini.
    </div>
<?php endif; ?> -->


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pilih Siswa untuk Input Rapor</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php foreach ($data['siswa'] as $siswa) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <img src="<?php echo BASEURL; ?>/img/<?php echo $siswa['foto']; ?>" width="50" height="50" class="rounded-circle mr-3">
                                <?php echo $siswa['nama_lengkap']; ?> (<?php echo $siswa['nis']; ?>)
                            </div>
                            <div>
                                <a href="<?php echo BASEURL; ?>/rapor/input/<?php echo $siswa['id']; ?>"
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Kelola Rapor
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>