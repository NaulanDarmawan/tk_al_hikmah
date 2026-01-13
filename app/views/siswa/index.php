<div class="row">
    <div class="col-lg-12">
        <?php Flasher::flash(); ?>
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-6">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <form action="<?= BASEURL; ?>/siswa" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari Nama, NIS, atau NISN..." name="keyword" value="<?= $data['keyword']; ?>" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
                            <a href="<?= BASEURL; ?>/siswa" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-users mr-2"></i> Data Peserta Didik</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success shadow-sm" id="tombolTambahData" data-toggle="modal" data-target="#formModal">
                        <i class="fas fa-plus-circle mr-1"></i> Tambah Siswa Baru
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="tabelSiswa" class="table table-hover text-nowrap table-striped">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Foto</th>
                            <th>Identitas Lengkap</th>
                            <th>Kontak & Orang Tua</th>
                            <th>Alamat Domisili</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data['siswa'] as $siswa) : ?>
                            <tr>
                                <td class="align-middle text-center"><?= $no++; ?></td>
                                <td class="align-middle text-center">
                                    <div style="width: 55px; height: 55px; overflow: hidden; border-radius: 50%; border: 2px solid #ddd; margin: auto;">
                                        <img src="<?= BASEURL; ?>/img/<?= $siswa['foto']; ?>" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-primary font-weight-bold" style="font-size: 1.1rem;"><?= $siswa['nama_lengkap']; ?></span>
                                    <small class="badge badge-secondary ml-1"><?= $siswa['nama_panggilan']; ?></small> <br>
                                    <small class="text-muted">
                                        <i class="fas fa-id-badge mr-1"></i> NIS: <?= $siswa['nis']; ?> |
                                        JK: <?= ($siswa['jenis_kelamin'] == 'Laki-laki') ? 'L' : 'P'; ?> |
                                        Agama: <?= $siswa['agama']; ?>
                                    </small>
                                </td>
                                <td class="align-middle small">
                                    <strong>Ayah:</strong> <?= $siswa['nama_ayah']; ?><br>
                                    <strong>Ibu:</strong> <?= $siswa['nama_ibu']; ?><br>
                                    <span class="text-success font-weight-bold"><i class="fab fa-whatsapp"></i> <?= $siswa['hp_ortu']; ?></span>
                                </td>
                                <td class="align-middle small text-muted">
                                    <?= $siswa['alamat_jalan']; ?><br>
                                    Kec. <?= $siswa['kecamatan']; ?>, <?= $siswa['kab_kota']; ?>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASEURL; ?>/siswa/detail/<?= $siswa['id']; ?>" class="btn btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                        <a href="<?= BASEURL; ?>/siswa/ubah/<?= $siswa['id']; ?>" class="btn btn-warning text-white tampilModalUbah" data-toggle="modal" data-target="#formModal" data-id="<?= $siswa['id']; ?>" title="Edit"><i class="fas fa-pen"></i></a>
                                        <a href="<?= BASEURL; ?>/siswa/hapus/<?= $siswa['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data <?= $siswa['nama_lengkap']; ?>?');" title="Hapus"><i class="fas fa-trash"></i></a>
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
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="judulModalLabel"><i class="fas fa-user-plus mr-2"></i> Tambah Data Siswa</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <form action="<?= BASEURL; ?>/siswa/tambah" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="fotoLama" id="fotoLama">

                    <ul class="nav nav-tabs nav-justified" id="formSiswaTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active font-weight-bold" id="pribadi-tab" data-toggle="tab" href="#pribadi" role="tab"><i class="fas fa-user-circle mr-1"></i> Data Diri & Fisik</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="ortu-tab" data-toggle="tab" href="#ortu" role="tab"><i class="fas fa-users mr-1"></i> Orang Tua</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="alamat-tab" data-toggle="tab" href="#alamat" role="tab"><i class="fas fa-map-marked-alt mr-1"></i> Alamat Domisili</a>
                        </li>
                    </ul>

                    <div class="tab-content p-4" id="formSiswaTabContent">

                        <div class="tab-pane fade show active" id="pribadi" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required placeholder="Sesuai Akte Kelahiran">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_panggilan">Nama Panggilan</label>
                                                <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nisn">NISN</label>
                                                <input type="text" class="form-control" id="nisn" name="nisn">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nis">NIS <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nis" name="nis" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="tempat_lahir">Tempat Lahir</label>
                                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="anak_ke">Anak Ke-</label>
                                                <input type="number" class="form-control" id="anak_ke" name="anak_ke" min="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berat_badan">BB (Kg)</label>
                                                <input type="number" class="form-control" id="berat_badan" name="berat_badan">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tinggi_badan">TB (cm)</label>
                                                <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 text-center border-left">
                                    <label class="d-block">Foto Siswa</label>
                                    <img id="foto-preview" src="<?= BASEURL; ?>/img/default.jpg" class="img-thumbnail mb-2 shadow-sm" style="width: 160px; height: 190px; object-fit: cover;">
                                    <div class="custom-file text-left small">
                                        <input type="file" class="custom-file-input" id="foto" name="foto" onchange="previewImage(this)">
                                        <label class="custom-file-label" for="foto">Pilih file...</label>
                                    </div>
                                    <p class="text-xs text-muted mt-2">Format: JPG/PNG. Kompresi otomatis aktif.</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="ortu" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary mb-3">Identitas Ayah</h6>
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
                                    <h6 class="font-weight-bold text-primary mb-3">Identitas Ibu</h6>
                                    <div class="form-group">
                                        <label for="nama_ibu">Nama Lengkap Ibu</label>
                                        <input type="text" class="form-control" id="nama_ibu" name="nama_ibu">
                                    </div>
                                    <div class="form-group">
                                        <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                        <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="form-group bg-light p-3 border rounded">
                                        <label for="hp_ortu" class="text-success font-weight-bold"><i class="fab fa-whatsapp"></i> No. HP / WhatsApp Orang Tua (Aktif)</label>
                                        <input type="text" class="form-control form-control-lg border-success text-success font-weight-bold" id="hp_ortu" name="hp_ortu" placeholder="Contoh: 08123456789">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="alamat" role="tabpanel">
                            <div class="form-group">
                                <label for="alamat_jalan">Alamat Jalan / Gang / RT / RW</label>
                                <textarea class="form-control" id="alamat_jalan" name="alamat_jalan" rows="3" placeholder="Contoh: Jl. Merpati No. 12, RT. 05 RW. 02"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kab_kota">Kabupaten / Kota</label>
                                        <input type="text" class="form-control" id="kab_kota" name="kab_kota">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi</label>
                                        <input type="text" class="form-control" id="provinsi" name="provinsi">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kode_pos">Kode Pos</label>
                                        <input type="text" class="form-control" id="kode_pos" name="kode_pos">
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
    // Fitur Live Preview Foto Upload
    function previewImage(input) {
        const preview = document.querySelector('#foto-preview');
        const label = document.querySelector('.custom-file-label');

        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name; // Update nama file di label
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Reset preview saat tombol "Tambah" diklik (karena modal shared dengan Edit)
    document.querySelector('#tombolTambahData').addEventListener('click', function() {
        document.querySelector('#foto-preview').src = "<?= BASEURL; ?>/img/default.jpg";
        document.querySelector('.custom-file-label').textContent = "Pilih file...";
    });
</script>