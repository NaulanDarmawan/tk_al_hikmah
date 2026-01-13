<ul class="list-group list-group-flush">
    <?php if (empty($data['siswa_terfilter'])) : ?>
        <li class="list-group-item text-center text-danger">
            Data siswa tidak ditemukan untuk filter tersebut.
        </li>
    <?php endif; ?>

    <?php foreach ($data['siswa_terfilter'] as $siswa) : ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <img src="<?php echo BASEURL; ?>/img/<?php echo $siswa['foto']; ?>" width="50" height="50" class="rounded-circle mr-3">
                <?php echo $siswa['nama_lengkap']; ?> (<?php echo $siswa['nis']; ?>)
            </div>
            <div>
                <a href="<?php echo BASEURL; ?>/cetak/generatePdf/<?php echo $siswa['id_rapor']; ?>"
                    class="btn btn-danger btn-sm"
                    target="_blank">
                    <i class="fas fa-file-pdf"></i> Cetak Rapor (PDF)
                </a>
            </div>
        </li>
    <?php endforeach; ?>
</ul>