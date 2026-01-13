<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Input Rapor: <strong><?php echo $data['siswa']['nama_lengkap']; ?></strong>
                </h3>
                <div class="card-tools">
                    <span class="badge badge-primary">
                        Semester <?php echo $data['semester']; ?>
                        Tahun <?php echo $data['tahun_ajaran_full']; ?>
                    </span>
                </div>
            </div>

            <form action="<?php echo BASEURL; ?>/rapor/simpan" method="post" enctype="multipart/form-data">

                <input type="hidden" name="id_siswa" value="<?php echo $data['siswa']['id']; ?>">
                <input type="hidden" name="id_rapor" value="<?php echo $data['rapor']['id']; ?>">

                <div class="card-body">
                    <h5>Data Kelas dan Absensi</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <select class="form-control" id="kelas" name="kelas" required>
                                    <option value="TK-A" <?php echo ($data['kelas'] == 'TK-A') ? 'selected' : ''; ?>>TK-A</option>
                                    <option value="TK-B" <?php echo ($data['kelas'] == 'TK-B') ? 'selected' : ''; ?>>TK-B</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tahun_ajaran_mulai">Tahun Ajaran</label>
                                <div class="input-group">
                                    <select class="form-control" id="tahun_ajaran_mulai">
                                        <?php
                                        // Buat 5 opsi tahun, misal 2023 s/d 2027
                                        $tahun_sekarang = intval($data['tahun_mulai']);
                                        for ($i = $tahun_sekarang - 2; $i <= $tahun_sekarang + 3; $i++) {
                                            $selected = ($i == $data['tahun_mulai']) ? 'selected' : '';
                                            echo "<option value='{$i}' {$selected}>{$i}</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="tahun_ajaran_akhir">
                                            /<?php echo intval($data['tahun_mulai']) + 1; ?>
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" id="tahun_ajaran" name="tahun_ajaran"
                                    value="<?php echo $data['tahun_ajaran_full']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="semester">Semester</label>
                                <select class="form-control" id="semester_input" name="semester" required>
                                    <option value="I" <?php echo ($data['semester'] == 'I') ? 'selected' : ''; ?>>Semester I</option>
                                    <option value="II" <?php echo ($data['semester'] == 'II') ? 'selected' : ''; ?>>Semester II</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sakit">Sakit (Hari)</label>
                                <input type="number" class="form-control" id="sakit" name="sakit" value="<?php echo $data['rapor']['sakit']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="izin">Izin (Hari)</label>
                                <input type="number" class="form-control" id="izin" name="izin" value="<?php echo $data['rapor']['izin']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="alpha">Alpha (Hari)</label>
                                <input type="number" class="form-control" id="alpha" name="alpha" value="<?php echo $data['rapor']['alpha']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nama_wali_kelas">Nama Guru Kelas</label>
                                <input type="text" class="form-control" id="nama_wali_kelas" name="nama_wali_kelas"
                                    value="<?php echo $data['rapor']['nama_wali_kelas']; ?>"
                                    placeholder="Masukkan nama guru kelas..." required>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="card-body">
                    <h5>Deskripsi Capaian Pembelajaran</h5>
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#tab-agama">1. Nilai Agama & Budi Pekerti</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#tab-jati-diri">2. Jati Diri</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#tab-steam">3. Literasi & STEAM</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#tab-p5">4. Projek P5 / Kokurikuler</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#tab-ortu">5. Refleksi Orang Tua</a>
                                </li> -->
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-agama" role="tabpanel">
                                    <div class="form-group">
                                        <label>Narasi Nilai Agama dan Budi Pekerti</label>
                                        <textarea name="narasi_agama" class="form-control" rows="5"><?php echo $data['rapor']['narasi_agama']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Foto Kegiatan (Nilai Agama)</label>
                                        <?php if (!empty($data['rapor']['foto_agama'])): ?>
                                            <div class="mb-2">
                                                <img id="preview_foto_agama" src="<?php echo BASEURL; ?>/img/rapor/<?php echo $data['rapor']['foto_agama']; ?>" alt="Foto Agama" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                            </div>
                                        <?php else: ?>
                                            <div class="mb-2">
                                                <img id="preview_foto_agama" src="#" alt="Preview Foto" style="max-width: 200px; height: auto; display: none;" class="img-thumbnail">
                                            </div>
                                        <?php endif; ?>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_agama" name="foto_agama" accept="image/*">
                                            <label class="custom-file-label" for="foto_agama">Pilih file foto...</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-jati-diri" role="tabpanel">
                                    <div class="form-group">
                                        <label>Narasi Jati Diri</label>
                                        <textarea name="narasi_jati_diri" class="form-control" rows="5"><?php echo $data['rapor']['narasi_jati_diri']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Foto Kegiatan (Jati Diri)</label>
                                        <?php if (!empty($data['rapor']['foto_jati_diri'])): ?>
                                            <div class="mb-2">
                                                <img id="preview_foto_jati_diri" src="<?php echo BASEURL; ?>/img/rapor/<?php echo $data['rapor']['foto_jati_diri']; ?>" alt="Foto Jati Diri" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                            </div>
                                        <?php else: ?>
                                            <div class="mb-2">
                                                <img id="preview_foto_jati_diri" src="#" alt="Preview Foto" style="max-width: 200px; height: auto; display: none;" class="img-thumbnail">
                                            </div>
                                        <?php endif; ?>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_jati_diri" name="foto_jati_diri" accept="image/*">
                                            <label class="custom-file-label" for="foto_jati_diri">Pilih file foto...</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-steam" role="tabpanel">
                                    <div class="form-group">
                                        <label>Narasi Dasar Literasi dan STEAM</label>
                                        <textarea name="narasi_literasi_steam" class="form-control" rows="5"><?php echo $data['rapor']['narasi_literasi_steam']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Foto Kegiatan (Literasi & STEAM)</label>
                                        <?php if (!empty($data['rapor']['foto_literasi_steam'])): ?>
                                            <div class="mb-2">
                                                <img id="preview_foto_literasi_steam" src="<?php echo BASEURL; ?>/img/rapor/<?php echo $data['rapor']['foto_literasi_steam']; ?>" alt="Foto STEAM" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                            </div>
                                        <?php else: ?>
                                            <div class="mb-2">
                                                <img id="preview_foto_literasi_steam" src="#" alt="Preview Foto" style="max-width: 200px; height: auto; display: none;" class="img-thumbnail">
                                            </div>
                                        <?php endif; ?>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_literasi_steam" name="foto_literasi_steam" accept="image/*">
                                            <label class="custom-file-label" for="foto_literasi_steam">Pilih file foto...</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-p5" role="tabpanel">
                                    <div class="form-group">
                                        <label>Narasi Projek Penguatan Profil Pelajar Pancasila (P5) / Kokurikuler</label>
                                        <textarea name="narasi_p5" class="form-control" rows="5"><?php echo $data['rapor']['narasi_p5']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Foto Kegiatan (P5)</label>
                                        <?php if (!empty($data['rapor']['foto_p5'])): ?>
                                            <div class="mb-2">
                                                <img id="preview_foto_p5" src="<?php echo BASEURL; ?>/img/rapor/<?php echo $data['rapor']['foto_p5']; ?>" alt="Foto P5" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                            </div>
                                        <?php else: ?>
                                            <div class="mb-2">
                                                <img id="preview_foto_p5" src="#" alt="Preview Foto" style="max-width: 200px; height: auto; display: none;" class="img-thumbnail">
                                            </div>
                                        <?php endif; ?>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_p5" name="foto_p5" accept="image/*">
                                            <label class="custom-file-label" for="foto_p5">Pilih file foto...</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-ortu" role="tabpanel">
                                    <div class="form-group">
                                        <label>Refleksi Orang Tua / Wali</label>
                                        <textarea name="refleksi_ortu" class="form-control" rows="5"><?php echo $data['rapor']['refleksi_ortu']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data Rapor
                    </button>
                    <a href="<?php echo BASEURL; ?>/rapor" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function bacaGambar(input, idPreview) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById(idPreview).src = e.target.result;
                document.getElementById(idPreview).style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('foto_agama').addEventListener('change', function() {
        bacaGambar(this, 'preview_foto_agama');
        // Update label
        var fileName = this.files[0].name;
        this.nextElementSibling.innerHTML = fileName;
    });

    document.getElementById('foto_jati_diri').addEventListener('change', function() {
        bacaGambar(this, 'preview_foto_jati_diri');
        var fileName = this.files[0].name;
        this.nextElementSibling.innerHTML = fileName;
    });

    document.getElementById('foto_literasi_steam').addEventListener('change', function() {
        bacaGambar(this, 'preview_foto_literasi_steam');
        var fileName = this.files[0].name;
        this.nextElementSibling.innerHTML = fileName;
    });

    document.getElementById('foto_p5').addEventListener('change', function() {
        bacaGambar(this, 'preview_foto_p5');
        var fileName = this.files[0].name;
        this.nextElementSibling.innerHTML = fileName;
    });
</script>