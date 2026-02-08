<div class="row">
    <div class="col-lg-12">
        <?php Flasher::flash(); ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-child mr-2 text-primary"></i> Manajemen Data Peserta Didik
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary shadow-sm" id="tombolTambahData" data-toggle="modal" data-target="#formModal">
                        <i class="fas fa-plus-circle mr-1"></i> Tambah Siswa Baru
                    </button>
                </div>
            </div>

            <div class="card-body p-3">
                <table id="tabelSiswa" class="table table-hover table-bordered table-striped w-100">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 7%">Foto</th>
                            <th style="width: 23%">Identitas Siswa</th>
                            <th style="width: 15%">Kesehatan & Fisik</th>
                            <th style="width: 20%">Orang Tua & Kontak</th>
                            <th style="width: 15%">Domisili</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data['siswa'] as $siswa) : ?>
                            <tr>
                                <td class="align-middle text-center font-weight-bold"><?= $no++; ?></td>
                                <td class="align-middle text-center">
                                    <div class="elevation-1" style="width: 60px; height: 60px; overflow: hidden; border-radius: 50%; border: 2px solid #fff; margin: auto;">
                                        <img src="<?= BASEURL; ?>/img/<?= $siswa['foto']; ?>" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-primary font-weight-bold" style="font-size: 1.1rem;"><?= $siswa['nama_lengkap']; ?></span>
                                    <span class="badge badge-info ml-1"><?= $siswa['nama_panggilan']; ?></span><br>
                                    <small class="text-muted">
                                        <strong>NIS:</strong> <?= $siswa['nis']; ?> | <strong>NISN:</strong> <?= $siswa['nisn'] ?: '-'; ?><br>
                                        <strong>JK:</strong> <?= $siswa['jenis_kelamin']; ?> | <strong>Agama:</strong> <?= $siswa['agama']; ?><br>
                                        <i class="fas fa-map-marker-alt mr-1"></i> <?= $siswa['tempat_lahir']; ?>, <?= date('d/m/Y', strtotime($siswa['tanggal_lahir'])); ?>
                                    </small>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span>Berat:</span> <span class="badge badge-secondary"><?= $siswa['berat_badan']; ?> Kg</span>
                                    </div>
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span>Tinggi:</span> <span class="badge badge-secondary"><?= $siswa['tinggi_badan']; ?> cm</span>
                                    </div>
                                    <div class="d-flex justify-content-between small">
                                        <span>Anak Ke:</span> <span class="badge badge-secondary"><?= $siswa['anak_ke']; ?></span>
                                    </div>
                                </td>
                                <td class="align-middle small">
                                    <strong><i class="fas fa-user-tie mr-1"></i> Ayah:</strong> <?= $siswa['nama_ayah']; ?><br>
                                    <strong><i class="fas fa-user-friends mr-1"></i> Ibu:</strong> <?= $siswa['nama_ibu']; ?><br>
                                    <a href="https://wa.me/62<?= ltrim($siswa['hp_ortu'], '0'); ?>" target="_blank" class="text-success font-weight-bold">
                                        <i class="fab fa-whatsapp"></i> <?= $siswa['hp_ortu']; ?>
                                    </a>
                                </td>
                                <td class="align-middle small text-muted">
                                    <?= $siswa['alamat_jalan']; ?>, <?= $siswa['kecamatan']; ?>, <?= $siswa['kab_kota']; ?>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group">
                                        <a href="<?= BASEURL; ?>/siswa/detail/<?= $siswa['id']; ?>" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                        <a href="<?= BASEURL; ?>/siswa/ubah/<?= $siswa['id']; ?>" class="btn btn-sm btn-warning text-white tampilModalUbah" data-toggle="modal" data-target="#formModal" data-id="<?= $siswa['id']; ?>" title="Edit"><i class="fas fa-pen"></i></a>
                                        <a href="<?= BASEURL; ?>/siswa/hapus/<?= $siswa['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data <?= $siswa['nama_lengkap']; ?>?');" title="Hapus"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="judulModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="judulModalLabel">Tambah Data Siswa</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-0">
                <form action="<?= BASEURL; ?>/siswa/tambah" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="fotoLama" id="fotoLama">

                    <div class="card card-primary card-tabs border-0 shadow-none mb-0">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs nav-justified" id="formTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active font-weight-bold" id="pribadi-tab" data-toggle="pill" href="#pribadi" role="tab"><i class="fas fa-id-card-alt mr-1"></i> Data Siswa</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="ortu-tab" data-toggle="pill" href="#ortu" role="tab"><i class="fas fa-users mr-1"></i> Orang Tua</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="alamat-tab" data-toggle="pill" href="#alamat" role="tab"><i class="fas fa-home mr-1"></i> Domisili</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="pribadi" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 font-group">
                                                    <label for="nama_panggilan">Nama Panggilan</label>
                                                    <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan">
                                                </div>
                                                <div class="col-md-6 font-group">
                                                    <label for="agama">Agama</label>
                                                    <select class="form-control" id="agama" name="agama">
                                                        <option value="Islam">Islam</option>
                                                        <option value="Kristen">Kristen</option>
                                                        <option value="Katolik">Katolik</option>
                                                        <option value="Hindu">Hindu</option>
                                                        <option value="Buddha">Buddha</option>
                                                        <option value="Konghucu">Konghucu</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-6 form-group">
                                                    <label for="nis">NIS (Sekolah) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="nis" name="nis" required>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="nisn">NISN (Nasional)</label>
                                                    <input type="text" class="form-control" id="nisn" name="nisn">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                                        <option value="Laki-laki">Laki-laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label for="anak_ke">Anak Ke</label>
                                                    <input type="number" class="form-control" id="anak_ke" name="anak_ke">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label for="berat_badan">BB (Kg)</label>
                                                    <input type="number" class="form-control" id="berat_badan" name="berat_badan">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label for="tinggi_badan">TB (cm)</label>
                                                    <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center border-left">
                                            <label>Foto Siswa</label>
                                            <div class="mb-3">
                                                <img id="foto-preview" src="<?= BASEURL; ?>/img/default.jpg" class="img-thumbnail elevation-1" style="width: 100%; aspect-ratio: 3/4; object-fit: cover;">
                                            </div>
                                            <div class="custom-file text-left small">
                                                <input type="file" class="custom-file-input" id="foto" name="foto" onchange="previewImage(this)">
                                                <label class="custom-file-label" for="foto">Pilih...</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="ortu" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="font-weight-bold text-primary border-bottom pb-2">Identitas Ayah</h6>
                                            <div class="form-group">
                                                <label for="nama_ayah">Nama Lengkap Ayah</label>
                                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah">
                                            </div>
                                            <div class="form-group">
                                                <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                                <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah">
                                            </div>
                                        </div>
                                        <div class="col-md-6 border-left">
                                            <h6 class="font-weight-bold text-primary border-bottom pb-2">Identitas Ibu</h6>
                                            <div class="form-group">
                                                <label for="nama_ibu">Nama Lengkap Ibu</label>
                                                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu">
                                            </div>
                                            <div class="form-group">
                                                <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                                <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group bg-light p-3 border rounded shadow-sm">
                                                <label for="hp_ortu" class="text-success"><i class="fab fa-whatsapp"></i> No. HP Orang Tua (Aktif)</label>
                                                <input type="text" class="form-control" id="hp_ortu" name="hp_ortu" placeholder="08xxxxxxxxxx">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="alamat" role="tabpanel">
                                    <div class="form-group">
                                        <label for="alamat_jalan">Alamat Lengkap (Jalan/Gg/RT/RW)</label>
                                        <textarea class="form-control" id="alamat_jalan" name="alamat_jalan" rows="3"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="kecamatan">Kecamatan</label>
                                            <input type="text" class="form-control" id="kecamatan" name="kecamatan">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="kab_kota">Kabupaten / Kota</label>
                                            <input type="text" class="form-control" id="kab_kota" name="kab_kota">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="provinsi">Provinsi</label>
                                            <input type="text" class="form-control" id="provinsi" name="provinsi">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="kode_pos">Kode Pos</label>
                                            <input type="text" class="form-control" id="kode_pos" name="kode_pos">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm">SIMPAN DATA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview Image Logic
    function previewImage(input) {
        const preview = document.querySelector('#foto-preview');
        const label = document.querySelector('.custom-file-label');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Pastikan tombol tambah mereset foto ke default
    document.querySelector('#tombolTambahData').addEventListener('click', function() {
        document.querySelector('#foto-preview').src = "<?= BASEURL; ?>/img/default.jpg";
        document.querySelector('.custom-file-label').textContent = "Pilih...";
        document.getElementById('judulModalLabel').innerHTML = 'Tambah Data Siswa';
        document.querySelector('.modal-footer button[type=submit]').innerHTML = 'Simpan Data';
    });
</script>