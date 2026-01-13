<style>
    /* Styling untuk Upload Foto */
    .upload-ui-container {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto;
    }

    .upload-box {
        width: 100%;
        height: 100%;
        border: 2px dashed #ccc;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background: #f8f9fa;
        transition: all 0.3s;
    }

    .upload-box:hover {
        border-color: #007bff;
        background: #e9ecef;
    }

    .upload-box.state-filled {
        border: 2px solid #ddd;
        padding: 0;
        position: relative;
    }

    .upload-box.state-filled img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
    }

    .remove-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        background: red;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.2s;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .upload-ui-container:hover .remove-btn {
        opacity: 1;
    }

    .hidden-input {
        display: none;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="callout callout-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5><i class="fas fa-user-graduate"></i> <?php echo $data['siswa']['nama_lengkap']; ?></h5>
                    <p class="mb-0 text-muted">
                        NIS: <?php echo $data['siswa']['nis']; ?> | 
                        Update Terakhir: <?php echo date('d F Y'); ?>
                    </p>
                    <input type="hidden" id="id_siswa_aktif" value="<?php echo $data['siswa']['id']; ?>">
                </div>
                <div class="d-flex align-items-center">
                    <div class="form-group mb-0 mr-3 d-flex align-items-center">
                        <select class="form-control form-control-sm font-weight-bold border-info" id="pilih_kelompok">
                            <option value="A" <?php echo ($data['kelompok_aktif'] == 'A') ? 'selected' : ''; ?>>Kelompok A</option>
                            <option value="B" <?php echo ($data['kelompok_aktif'] == 'B') ? 'selected' : ''; ?>>Kelompok B</option>
                        </select>
                    </div>
                    
                    <button class="btn btn-primary btn-lg" form="formPenilaian">
                        <i class="fas fa-save"></i> Simpan Perkembangan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="<?php echo BASEURL; ?>/penilaian/simpan" method="post" id="formPenilaian" enctype="multipart/form-data">
    <input type="hidden" name="id_siswa" value="<?php echo $data['siswa']['id']; ?>">
    <input type="hidden" name="kelompok" value="<?php echo $data['kelompok_aktif']; ?>">
    <input type="hidden" name="tanggal" value="<?php echo date('Y-m-d'); ?>">

    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#tab-agama">Nilai Agama & Budi Pekerti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#tab-jati">Jati Diri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#tab-steam">Literasi & STEAM</a>
                </li>
            </ul>
        </div>
        
        <div class="card-body p-0">
            <div class="tab-content">
                
                <?php 
                    // Mapping ID Tab ke Key Data di Controller
                    $tabs = [
                        'tab-agama' => 'AGAMA', 
                        'tab-jati' => 'JATI_DIRI', 
                        'tab-steam' => 'STEAM'
                    ];
                ?>

                <?php foreach ($tabs as $id_tab => $key_data) : ?>
                    <div class="tab-pane fade <?php echo ($id_tab == 'tab-agama') ? 'show active' : ''; ?>" id="<?php echo $id_tab; ?>" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th style="width: 40%; vertical-align: middle;">Indikator Capaian (Kelompok <?php echo $data['kelompok_aktif']; ?>)</th>
                                        <th class="text-center" style="width: 8%; background:#ffcccc; vertical-align: middle;">BB</th>
                                        <th class="text-center" style="width: 8%; background:#ffeeba; vertical-align: middle;">MB</th>
                                        <th class="text-center" style="width: 8%; background:#d4edda; vertical-align: middle;">BSH</th>
                                        <th class="text-center" style="width: 8%; background:#c3e6cb; vertical-align: middle;">BSB</th>
                                        <th class="text-center" style="width: 15%; vertical-align: middle;">Foto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $list_sub_elemen = $data['indikator'][$key_data] ?? [];
                                    ?>
                                    
                                    <?php foreach ($list_sub_elemen as $sub_judul => $list_indikator) : ?>
                                        <tr class="bg-light">
                                            <td colspan="6"><strong><?php echo $sub_judul; ?></strong></td>
                                        </tr>

                                        <?php foreach ($list_indikator as $indikator) : ?>
                                            <?php 
                                                $id_indikator = $indikator['id'];
                                                $deskripsi = $indikator['deskripsi'];
                                                
                                                // Cek nilai terakhir
                                                $nilai_terakhir = '';
                                                $foto_terakhir = '';
                                                if (isset($data['nilai_terbaru'][$id_indikator])) {
                                                    $nilai_terakhir = $data['nilai_terbaru'][$id_indikator]['nilai'];
                                                    $foto_terakhir = $data['nilai_terbaru'][$id_indikator]['foto'];
                                                }
                                            ?>
                                            <tr>
                                                <td><?php echo $deskripsi; ?></td>
                                                
                                                <?php $nilai_options = ['BB', 'MB', 'BSH', 'BSB']; ?>
                                                <?php foreach ($nilai_options as $opt) : ?>
                                                    <td class="text-center">
                                                        <input type="radio" 
                                                               name="nilai[<?php echo $id_indikator; ?>]" 
                                                               value="<?php echo $opt; ?>" 
                                                               style="transform: scale(1.5);"
                                                               <?php echo ($nilai_terakhir == $opt) ? 'checked' : ''; ?>>
                                                    </td>
                                                <?php endforeach; ?>

                                                <td class="text-center">
                                                    <div class="upload-ui-container" id="container_<?php echo $id_indikator; ?>">
                                                        <!-- Input File Hidden -->
                                                        <input type="file" class="hidden-input" 
                                                               id="foto_<?php echo $id_indikator; ?>" 
                                                               name="foto[<?php echo $id_indikator; ?>]" 
                                                               accept="image/*"
                                                               onchange="previewImage(this, <?php echo $id_indikator; ?>)">
                                                        
                                                        <!-- Input Hidden untuk Signal Hapus -->
                                                        <input type="hidden" name="hapus_foto[<?php echo $id_indikator; ?>]" id="hapus_foto_<?php echo $id_indikator; ?>" value="0">
                                                        
                                                        <!-- State 1: Empty (Upload Icon) -->
                                                        <div class="upload-box state-empty <?php echo $foto_terakhir ? 'd-none' : ''; ?>" 
                                                             id="empty_<?php echo $id_indikator; ?>"
                                                             onclick="document.getElementById('foto_<?php echo $id_indikator; ?>').click()">
                                                            <i class="fas fa-camera icon-upload"></i>
                                                            <span style="font-size: 10px; color: #999; position: absolute; bottom: 5px;">Browse</span>
                                                        </div>

                                                        <!-- State 2: Filled (Preview) -->
                                                        <div class="upload-box state-filled <?php echo $foto_terakhir ? '' : 'd-none'; ?>" 
                                                             id="filled_<?php echo $id_indikator; ?>">
                                                            <img src="<?php echo $foto_terakhir ? BASEURL . '/img/penilaian/' . $foto_terakhir : ''; ?>" 
                                                                 id="preview_<?php echo $id_indikator; ?>"
                                                                 class="preview-img" 
                                                                 onclick="window.open(this.src, '_blank')"
                                                                 title="Klik untuk memperbesar">
                                                            
                                                            <!-- Tombol Hapus -->
                                                            <div class="remove-btn" onclick="removePhoto(<?php echo $id_indikator; ?>)">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
        
        <div class="card-footer">
            <div class="row">
                <div class="col-md-12">
                    <strong>Keterangan:</strong><br>
                    <span class="badge" style="background:#ffcccc; color:#333;">BB</span> : Belum Berkembang &nbsp;|&nbsp; 
                    <span class="badge" style="background:#ffeeba; color:#333;">MB</span> : Mulai Berkembang &nbsp;|&nbsp;
                    <span class="badge" style="background:#d4edda; color:#333;">BSH</span> : Berkembang Sesuai Harapan &nbsp;|&nbsp;
                    <span class="badge" style="background:#c3e6cb; color:#333;">BSB</span> : Berkembang Sangat Baik
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Logic Switcher Kelompok
        const selectKelompok = document.getElementById('pilih_kelompok');
        const idSiswa = document.getElementById('id_siswa_aktif').value;

        selectKelompok.addEventListener('change', function() {
            const kelompokPilih = this.value;
            window.location.href = BASEURL + '/penilaian/input/' + idSiswa + '/' + kelompokPilih;
        });
    });

    // 2. Logic Preview Image
    function previewImage(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                // Set src preview
                document.getElementById('preview_' + id).src = e.target.result;
                
                // Sembunyikan empty state, tampilkan filled state
                document.getElementById('empty_' + id).classList.add('d-none');
                document.getElementById('filled_' + id).classList.remove('d-none');
                
                // Reset signal hapus karena user upload baru
                document.getElementById('hapus_foto_' + id).value = '0';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // 3. Logic Remove Photo
    function removePhoto(id) {
        // Reset input file
        document.getElementById('foto_' + id).value = '';
        
        // Reset src preview (optional)
        document.getElementById('preview_' + id).src = '';
        
        // Tampilkan empty state, sembunyikan filled state
        document.getElementById('empty_' + id).classList.remove('d-none');
        document.getElementById('filled_' + id).classList.add('d-none');
        
        // Set signal hapus menjadi 1
        document.getElementById('hapus_foto_' + id).value = '1';
    }
</script>