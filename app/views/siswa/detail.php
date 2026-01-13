<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="<?php echo BASEURL; ?>/siswa" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                <a href="#" class="btn btn-warning btn-sm float-right tampilModalUbah" data-toggle="modal" data-target="#formModal" data-id="<?php echo $data['siswa']['id']; ?>">
                    <i class="fas fa-edit"></i> Ubah Data Ini
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="<?php echo BASEURL; ?>/img/<?php echo $data['siswa']['foto']; ?>" class="img-fluid img-thumbnail" alt="Foto Siswa" style="width: 100%; object-fit: cover;">
                    </div>
                    <div class="col-md-9">
                        <h3><?php echo $data['siswa']['nama_lengkap']; ?></h3>
                        <h5 class="text-muted"><?php echo $data['siswa']['nama_panggilan']; ?></h5>
                        <hr>
                        <table class="table table-sm table-borderless" style="font-size: 0.95rem;">
                            <tbody>
                                <tr>
                                    <td style="width: 200px;"><strong>NISN / NIS</strong></td>
                                    <td>: <?php echo $data['siswa']['nisn']; ?> / <?php echo $data['siswa']['nis']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>TTL</strong></td>
                                    <td>: <?php echo $data['siswa']['tempat_lahir']; ?>, <?php echo date('d F Y', strtotime($data['siswa']['tanggal_lahir'])); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Kelamin</strong></td>
                                    <td>: <?php echo $data['siswa']['jenis_kelamin']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Agama</strong></td>
                                    <td>: <?php echo $data['siswa']['agama']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Anak Ke-</strong></td>
                                    <td>: <?php echo $data['siswa']['anak_ke']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Berat / Tinggi Badan</strong></td>
                                    <td>: <?php echo $data['siswa']['berat_badan']; ?> Kg / <?php echo $data['siswa']['tinggi_badan']; ?> cm</td>
                                </tr>

                                <tr style="height: 10px;">
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Ayah</strong></td>
                                    <td>: <?php echo $data['siswa']['nama_ayah']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Pekerjaan Ayah</strong></td>
                                    <td>: <?php echo $data['siswa']['pekerjaan_ayah']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Ibu</strong></td>
                                    <td>: <?php echo $data['siswa']['nama_ibu']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Pekerjaan Ibu</strong></td>
                                    <td>: <?php echo $data['siswa']['pekerjaan_ibu']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. HP Ortu</strong></td>
                                    <td>: <?php echo $data['siswa']['hp_ortu']; ?></td>
                                </tr>

                                <tr style="height: 10px;">
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat Jalan</strong></td>
                                    <td>: <?php echo $data['siswa']['alamat_jalan']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Kecamatan</strong></td>
                                    <td>: <?php echo $data['siswa']['kecamatan']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Kabupaten/Kota</strong></td>
                                    <td>: <?php echo $data['siswa']['kab_kota']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Provinsi</strong></td>
                                    <td>: <?php echo $data['siswa']['provinsi']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Kode Pos</strong></td>
                                    <td>: <?php echo $data['siswa']['kode_pos']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
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