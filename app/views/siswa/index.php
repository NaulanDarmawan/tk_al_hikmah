<div class="row">
    <div class="col-lg-12">
        <?php Flasher::flash(); ?>
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-8">
        <form action="<?php echo BASEURL; ?>/siswa" method="post">
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
                    <a href="<?php echo BASEURL; ?>/siswa" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Siswa TK</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" id="tombolTambahData" data-toggle="modal" data-target="#formModal">
                        <i class="fas fa-plus"></i> Tambah Data Siswa
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="tabelSiswa" class="table table-hover text-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Foto</th>
                            <th style="width: 15%">NIS</th>
                            <th>Nama Lengkap</th>
                            <th style="width: 15%">Kelas</th>
                            <th style="width: 20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data['siswa'] as $siswa) : ?>
                            <tr>
                                <td class="align-middle"><?= $no++; ?></td>
                                <td class="align-middle text-center">
                                    <div style="width: 60px; height: 60px; overflow: hidden; border-radius: 50%; margin: 0 auto; border: 2px solid #dee2e6;">
                                        <img src="<?= BASEURL; ?>/img/<?= $siswa['foto']; ?>"
                                            alt="<?= $siswa['nama_lengkap']; ?>"
                                            style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                    </div>
                                </td>
                                <td class="align-middle font-weight-bold text-muted"><?= $siswa['nis']; ?></td>
                                <td class="align-middle">
                                    <?= $siswa['nama_lengkap']; ?>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-info p-2"><?= $siswa['kelas']; ?></span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASEURL; ?>/siswa/detail/<?= $siswa['id']; ?>" class="btn btn-primary" title="Detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="<?= BASEURL; ?>/siswa/ubah/<?= $siswa['id']; ?>" class="btn btn-warning tampilModalUbah text-white" data-toggle="modal" data-target="#formModal" data-id="<?= $siswa['id']; ?>" title="Ubah">
                                            <i class="fas fa-pen"></i> Edit
                                        </a>
                                        <a href="<?= BASEURL; ?>/siswa/hapus/<?= $siswa['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data <?= $siswa['nama_lengkap']; ?>?');" title="Hapus">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
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


<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="judulModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulModalLabel">Tambah Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo BASEURL; ?>/siswa/tambah" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="fotoLama" id="fotoLama">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Data Diri Siswa</h5>
                            <hr>
                            <div class="form-group"> <label for="nama_lengkap">Nama Lengkap</label> <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_panggilan">Nama Panggilan</label>
                                <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan">
                            </div>
                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Nomor Induk Siswa Nasional">
                            </div>
                            <div class="form-group">
                                <label for="nis">NIS (Nomor Induk Sekolah)</label>
                                <input type="text" class="form-control" id="nis" name="nis" placeholder="Nomor internal sekolah" required>
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                            </div>
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
                            <div class="form-group">
                                <label for="anak_ke">Anak Ke-</label>
                                <input type="number" class="form-control" id="anak_ke" name="anak_ke" min="1">
                            </div>
                            <div class="form-group">
                                <label for="berat_badan">Berat Badan (Kg)</label>
                                <input type="number" class="form-control" id="berat_badan" name="berat_badan" min="1">
                            </div>
                            <div class="form-group">
                                <label for="tinggi_badan">Tinggi Badan (cm)</label>
                                <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" min="1">
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto Siswa</label>

                                <div class="mt-2 mb-2">
                                    <img id="foto-preview" src="<?php echo BASEURL; ?>/img/default.jpg" class="img-thumbnail" alt="Preview Foto" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                                <input type="file" class="form-control-file" id="foto" name="foto">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5>Data Orang Tua & Alamat</h5>
                            <hr>
                            <div class="form-group">
                                <label for="nama_ayah">Nama Ayah</label>
                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah">
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah">
                            </div>
                            <div class="form-group">
                                <label for="nama_ibu">Nama Ibu</label>
                                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu">
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu">
                            </div>
                            <div class="form-group">
                                <label for="hp_ortu">No. HP Ortu</label>
                                <input type="number" class="form-control" id="hp_ortu" name="hp_ortu">
                            </div>
                            <div class="form-group">
                                <label for="alamat_jalan">Alamat Jalan</label>
                                <textarea class="form-control" style="margin-bottom: 30px;" id="alamat_jalan" name="alamat_jalan" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="kecamatan">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan">
                            </div>
                            <div class="form-group">
                                <label for="kab_kota">Kab/Kota</label>
                                <input type="text" class="form-control" id="kab_kota" name="kab_kota">
                            </div>
                            <div class="form-group">
                                <label for="provinsi">Provinsi</label>
                                <input type="text" class="form-control" id="provinsi" name="provinsi">
                            </div>
                            <div class="form-group">
                                <label for="kode_pos">Kode Pos</label>
                                <input type="text" class="form-control" id="kode_pos" name="kode_pos">
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>