<div class="row mb-3">
    <div class="col-lg-8">
        <form action="<?php echo BASEURL; ?>/penilaian" method="post">
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
                    <a href="<?php echo BASEURL; ?>/penilaian" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-users"></i> Daftar Siswa - Penilaian Harian</h3>
                </div>        
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th> <th style="width: 200px text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data['siswa'] as $siswa) : ?>
                        <tr>
                            <td><?php echo $no++; ?>.</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo BASEURL; ?>/img/<?php echo $siswa['foto']; ?>" class="rounded-circle mr-2" style="width: 30px; height: 30px; object-fit:cover;" alt="Foto">
                                    <strong><?php echo $siswa['nama_lengkap']; ?></strong>
                                </div>
                            </td>
                            <td>
                                <?php echo $siswa['nis']; ?>
                            </td>
                            <td>
                                <a href="<?php echo BASEURL; ?>/penilaian/input/<?php echo $siswa['id']; ?>" class="btn btn-success btn-sm btn-block">
                                    <i class="fas fa-edit"></i> Update Perkembangan
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>