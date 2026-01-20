<div class="row">
    <div class="col-lg-12">
        <?php Flasher::flash(); ?>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-calendar-check mr-2 text-primary"></i> Manajemen Penilaian Harian
                </h3>
                <div class="card-tools">
                    <form action="<?= BASEURL; ?>/penilaian" method="post" class="d-inline-block">
                        <div class="input-group shadow-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white border-0"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" name="tgl" class="form-control font-weight-bold"
                                value="<?= $data['tanggal_pilihan']; ?>" onchange="this.form.submit()">
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-header p-0 border-bottom-0 mx-3">
                <ul class="nav nav-tabs nav-justified" id="tabSiswa" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold py-3" data-toggle="pill" href="#tab-a"><i class="fas fa-layer-group mr-1"></i> KELOMPOK A</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold py-3" data-toggle="pill" href="#tab-b"><i class="fas fa-layer-group mr-1"></i> KELOMPOK B</a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-3">
                <div class="tab-content">
                    <?php foreach (['a' => 'A', 'b' => 'B'] as $id_tab => $kode_tab) : ?>
                        <div class="tab-pane fade <?= ($id_tab == 'a') ? 'show active' : ''; ?>" id="tab-<?= $id_tab; ?>">
                            <table class="table table-hover table-bordered table-striped w-100 datatable-penilaian">
                                <thead class="bg-primary text-white text-center">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 7%">Foto</th>
                                        <th style="width: 43%">Identitas Siswa</th>
                                        <th style="width: 25%">Status Penilaian (<?= date('d/m/Y', strtotime($data['tanggal_pilihan'])); ?>)</th>
                                        <th style="width: 20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($data['siswa'] as $s) :
                                        $statusSiswa = ($kode_tab == 'A') ? $s['status_A'] : $s['status_B'];
                                    ?>
                                        <tr>
                                            <td class="align-middle text-center font-weight-bold"><?= $no++; ?></td>
                                            <td class="align-middle text-center">
                                                <div class="elevation-1" style="width: 60px; height: 60px; overflow: hidden; border-radius: 50%; border: 2px solid #fff; margin: auto;">
                                                    <img src="<?= BASEURL; ?>/img/<?= $s['foto']; ?>" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-primary font-weight-bold" style="font-size: 1.1rem;"><?= $s['nama_lengkap']; ?></span><br>
                                                <small class="text-muted">
                                                    <strong>NIS:</strong> <?= $s['nis']; ?> | <strong>JK:</strong> <?= $s['jenis_kelamin']; ?>
                                                </small>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php if ($statusSiswa == 'Selesai') : ?>
                                                    <div class="badge badge-success shadow-sm" style="font-size: 1rem; padding: 10px 20px; border-radius: 30px;">
                                                        <i class="fas fa-check-circle mr-1"></i> SELESAI
                                                    </div>
                                                <?php else : ?>
                                                    <div class="badge badge-warning text-white shadow-sm" style="font-size: 1rem; padding: 10px 20px; border-radius: 30px;">
                                                        <i class="fas fa-clock mr-1"></i> BELUM DIISI
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="<?= BASEURL; ?>/penilaian/input/<?= $s['id']; ?>/<?= $kode_tab; ?>/<?= $data['tanggal_pilihan']; ?>"
                                                    class="btn btn-primary btn-lg shadow-sm font-weight-bold" style="border-radius: 10px; width: 100%;">
                                                    <i class="fas fa-edit mr-1"></i> ISI NILAI
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
    </div>
</div>

<script>
    // Gunakan window.onload agar script jalan SETELAH jQuery di footer dimuat
    window.onload = function() {
        if (window.jQuery) {
            $('.datatable-penilaian').DataTable({
                "responsive": true,
                "autoWidth": false,
                "pageLength": 10,
                "language": {
                    "search": "Cari Nama/NIS:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Siswa tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa",
                    "paginate": {
                        "next": "Lanjut",
                        "previous": "Kembali"
                    }
                }
            });
        }
    };
</script>