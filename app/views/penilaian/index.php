<div class="row mb-3 align-items-center">
    <div class="col-md-6">
        <h4 class="text-muted"><i class="fas fa-calendar-check text-primary"></i> Penilaian Harian</h4>
    </div>
    <div class="col-md-6 text-right">
        <form action="<?= BASEURL; ?>/penilaian" method="post" class="d-inline-block">
            <div class="input-group shadow-sm" style="width: 250px;">
                <input type="date" name="tgl" class="form-control" value="<?= $data['tanggal_pilihan']; ?>" onchange="this.form.submit()">
            </div>
        </form>
    </div>
</div>

<div class="card card-primary card-outline card-outline-tabs shadow-sm">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="tabSiswa" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tab-a">Kelompok A</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab-b">Kelompok B</a></li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <?php foreach (['a' => 'A', 'b' => 'B'] as $id_tab => $kode) : ?>
                <div class="tab-pane fade <?= ($id_tab == 'a') ? 'show active' : ''; ?>" id="tab-<?= $id_tab; ?>">
                    <table class="table table-striped table-hover datatable-siswa" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Siswa</th>
                                <th class="text-center">NIS</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($data['siswa'] as $s) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><strong><?= $s['nama_lengkap']; ?></strong></td>
                                    <td class="text-center"><?= $s['nis']; ?></td>
                                    <td class="text-center">
                                        <span class="badge badge-pill <?= $s['status'] == 'Selesai' ? 'badge-success' : 'badge-warning' ?> px-3">
                                            <?= $s['status'] == 'Selesai' ? '✓ Selesai' : '⏳ Belum' ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= BASEURL; ?>/penilaian/input/<?= $s['id']; ?>/<?= $kode; ?>/<?= $data['tanggal_pilihan']; ?>" class="btn btn-primary btn-sm shadow-sm px-3">
                                            <i class="fas fa-edit"></i> Isi Nilai
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.datatable-siswa').DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
            }
        });
    });
</script>