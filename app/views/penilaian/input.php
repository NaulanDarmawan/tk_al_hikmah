<style>
    /* 1. TYPOGRAPHY: Super Ramah Mata Senior */
    .content-wrapper {
        background-color: #f0f2f5;
    }

    /* Font diperbesar secara global untuk teks utama */
    .deskripsi-text {
        font-size: 19px !important;
        /* Ukuran besar */
        font-weight: 800 !important;
        /* Sangat tebal/bold */
        color: #1a202c;
        line-height: 1.4;
        display: block;
        margin-bottom: 5px;
    }

    .sub-judul-text {
        font-size: 16px;
        font-weight: 700;
        color: #4a5568;
        text-transform: uppercase;
    }

    /* 2. TAB COLORS: Lebih Berwarna & Ceria */
    .nav-tabs .nav-link {
        color: #4a5568;
        border-radius: 12px 12px 0 0;
        margin-right: 5px;
        border: none;
        background: #e2e8f0;
    }

    /* Warna Tab Aktif Spesifik */
    #tab-link-AGAMA.active {
        background-color: #6366f1 !important;
        color: white !important;
    }

    /* Indigo */
    #tab-link-JATI_DIRI.active {
        background-color: #ec4899 !important;
        color: white !important;
    }

    /* Pink */
    #tab-link-STEAM.active {
        background-color: #10b981 !important;
        color: white !important;
    }

    /* Emerald */

    /* 3. RADIO EVALUATION: Kontras Tinggi */
    .eval-radio {
        display: none;
    }

    .eval-label {
        display: block;
        padding: 15px 5px;
        border-radius: 10px;
        border: 3px solid #cbd5e1;
        cursor: pointer;
        transition: 0.2s;
        font-weight: 900;
        color: #64748b;
        font-size: 14px;
    }

    /* Warna saat terpilih */
    .eval-radio:checked+.eval-label.bb {
        background: #fecaca;
        border-color: #dc2626;
        color: #991b1b;
    }

    .eval-radio:checked+.eval-label.mb {
        background: #fef08a;
        border-color: #ca8a04;
        color: #854d0e;
    }

    .eval-radio:checked+.eval-label.bsh {
        background: #bbf7d0;
        border-color: #16a34a;
        color: #14532d;
    }

    .eval-radio:checked+.eval-label.bsb {
        background: #bae6fd;
        border-color: #0284c7;
        color: #0c4a6e;
    }

    /* 4. PHOTO UI: Fix Bersandingan Icon & Preview */
    .upload-ui-container {
        position: relative;
        width: 85px;
        height: 85px;
        margin: 0 auto;
    }

    .upload-box {
        width: 100%;
        height: 100%;
        border: 3px dashed #cbd5e1;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background: #ffffff;
        transition: 0.3s;
        overflow: hidden;
    }

    .upload-box:hover {
        border-color: #6366f1;
        background: #f8fafc;
    }

    .upload-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Logic: Jika img tidak kosong, icon kamera harus d-none */
    .state-filled .icon-camera {
        display: none;
    }

    .state-empty img {
        display: none;
    }

    .remove-btn {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid white;
        z-index: 10;
    }

    /* 5. CARD & FOOTER */
    .card-rapor {
        border-radius: 20px;
        overflow: hidden;
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .legend-box {
        background: #ffffff;
        border-radius: 15px;
        border: 2px solid #e2e8f0;
        padding: 15px;
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="card card-rapor bg-white p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="mb-1 font-weight-bold text-dark"><i class="fas fa-child text-primary mr-2"></i> <?= $data['siswa']['nama_lengkap']; ?></h2>
                    <p class="mb-0 text-muted" style="font-size: 18px;">
                        NIS: <b><?= $data['siswa']['nis']; ?></b> | Kelompok: <span class="badge badge-pill badge-primary px-3"><?= $data['kelompok']; ?></span>
                    </p>
                </div>
                <div class="text-md-right mt-3 mt-md-0">
                    <label class="small font-weight-bold text-uppercase text-muted mb-1 d-block">Pilih Hari:</label>
                    <input type="date" id="tgl_picker" class="form-control form-control-lg font-weight-bold shadow-sm"
                        style="border-radius: 10px; border: 2px solid #6366f1; color: #6366f1;"
                        value="<?= $data['tanggal']; ?>" onchange="pindahTanggal(this.value)">
                </div>
            </div>
        </div>
    </div>
</div>

<form action="<?= BASEURL; ?>/penilaian/simpan" method="post" id="formPenilaian" enctype="multipart/form-data">
    <input type="hidden" name="id_siswa" value="<?= $data['siswa']['id']; ?>">
    <input type="hidden" name="kelompok" value="<?= $data['kelompok']; ?>">
    <input type="hidden" name="tanggal" value="<?= $data['tanggal']; ?>">

    <div class="card card-rapor card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0" style="background: #f8fafc;">
            <ul class="nav nav-tabs nav-justified" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active py-3 font-weight-bold" id="tab-link-AGAMA" data-toggle="pill" href="#tab-AGAMA">
                        <i class="fas fa-pray mr-2"></i> AGAMA & BUDI PEKERTI
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 font-weight-bold" id="tab-link-JATI_DIRI" data-toggle="pill" href="#tab-JATI_DIRI">
                        <i class="fas fa-heart mr-2"></i> JATI DIRI
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 font-weight-bold" id="tab-link-STEAM" data-toggle="pill" href="#tab-STEAM">
                        <i class="fas fa-lightbulb mr-2"></i> LITERASI & STEAM
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content">
                <?php foreach (['AGAMA', 'JATI_DIRI', 'STEAM'] as $kat) : ?>
                    <div class="tab-pane fade <?= ($kat == 'AGAMA') ? 'show active' : ''; ?>" id="tab-<?= $kat; ?>">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="text-center" style="background: #f1f5f9; color: #475569;">
                                    <tr>
                                        <th class="text-left py-4 px-4" style="width: 45%; font-size: 16px;">KRITERIA PENILAIAN</th>
                                        <th style="width: 85px;">BB</th>
                                        <th style="width: 85px;">MB</th>
                                        <th style="width: 85px;">BSH</th>
                                        <th style="width: 85px;">BSB</th>
                                        <th style="width: 130px;">FOTO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data['indikator'][$kat])) : ?>
                                        <?php foreach ($data['indikator'][$kat] as $sub_judul => $list) : ?>
                                            <tr style="background-color: #f8fafc;">
                                                <td colspan="6" class="py-3 px-4">
                                                    <span class="sub-judul-text"><i class="fas fa-bookmark mr-2 text-primary"></i> <?= $sub_judul; ?></span>
                                                </td>
                                            </tr>
                                            <?php foreach ($list as $i) :
                                                $id_i = $i['id'];
                                                $val = $data['nilai_existing'][$id_i] ?? '';
                                                $foto = $data['foto_existing'][$id_i] ?? '';
                                            ?>
                                                <tr>
                                                    <td class="align-middle px-4 py-4">
                                                        <span class="deskripsi-text"><?= $i['deskripsi']; ?></span>
                                                    </td>
                                                    <?php foreach (['BB', 'MB', 'BSH', 'BSB'] as $opt) : ?>
                                                        <td class="align-middle p-2 text-center">
                                                            <input type="radio" name="skala[<?= $id_i; ?>]" value="<?= $opt; ?>"
                                                                id="r_<?= $id_i . $opt; ?>" class="eval-radio" <?= ($val == $opt) ? 'checked' : ''; ?>>
                                                            <label for="r_<?= $id_i . $opt; ?>" class="eval-label <?= strtolower($opt); ?> shadow-sm"><?= $opt; ?></label>
                                                        </td>
                                                    <?php endforeach; ?>
                                                    <td class="align-middle text-center">
                                                        <div class="upload-ui-container">
                                                            <input type="file" name="foto[<?= $id_i; ?>]" id="f_<?= $id_i; ?>" class="d-none" onchange="previewImage(this, <?= $id_i; ?>)" accept="image/*">
                                                            <input type="hidden" name="hapus_foto[<?= $id_i; ?>]" id="h_<?= $id_i; ?>" value="0">

                                                            <div class="upload-box shadow-sm <?= $foto ? 'state-filled' : 'state-empty'; ?>" id="box_<?= $id_i; ?>" onclick="document.getElementById('f_<?= $id_i; ?>').click()">
                                                                <i class="fas fa-camera text-muted fa-2x icon-camera" style="<?= $foto ? 'display:none;' : '' ?>"></i>

                                                                <img src="<?= $foto ? BASEURL . '/img/penilaian/' . $foto : ''; ?>"
                                                                    id="prev_<?= $id_i; ?>"
                                                                    style="<?= $foto ? 'display:block; width:100%; height:100%; object-fit:cover;' : 'display:none;' ?>">
                                                            </div>

                                                            <div class="remove-btn <?= $foto ? '' : 'd-none'; ?>" id="btn_rm_<?= $id_i; ?>" onclick="removePhoto(event, <?= $id_i; ?>)">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-5">
        <div class="col-md-7">
            <div class="legend-box shadow-sm">
                <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-3">Keterangan Penilaian:</h5>
                <div class="row">
                    <div class="col-6">
                        <p class="mb-1"><span class="badge" style="background:#fecaca; color:#991b1b;">BB</span> : Belum Berkembang</p>
                        <p class="mb-1"><span class="badge" style="background:#fef08a; color:#854d0e;">MB</span> : Mulai Berkembang</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><span class="badge" style="background:#bbf7d0; color:#14532d;">BSH</span> : Berkembang Sesuai Harapan</p>
                        <p class="mb-1"><span class="badge" style="background:#bae6fd; color:#0c4a6e;">BSB</span> : Berkembang Sangat Baik</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 text-right d-flex align-items-center justify-content-end">
            <button type="submit" form="formPenilaian" class="btn btn-success btn-block shadow-lg py-4" style="border-radius: 20px; font-size: 22px; font-weight: 900;">
                <i class="fas fa-save mr-2"></i> SIMPAN PENILAIAN HARIAN
            </button>
        </div>
    </div>
</form>

<script>
    function pindahTanggal(tgl) {
        const idSiswa = "<?= $data['siswa']['id']; ?>";
        const kelompok = "<?= $data['kelompok']; ?>";
        window.location.href = `<?= BASEURL; ?>/penilaian/input/${idSiswa}/${kelompok}/${tgl}`;
    }

    function previewImage(input, id) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('prev_' + id);
                const box = document.getElementById('box_' + id);
                const removeBtn = document.getElementById('btn_rm_' + id);

                preview.src = e.target.result;
                preview.style.display = 'block';
                box.classList.remove('state-empty');
                box.classList.add('state-filled');
                removeBtn.classList.remove('d-none');
                document.getElementById('h_' + id).value = '0';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePhoto(event, id) {
        event.stopPropagation();
        const preview = document.getElementById('prev_' + id);
        const box = document.getElementById('box_' + id);
        const removeBtn = document.getElementById('btn_rm_' + id);
        const inputFile = document.getElementById('f_' + id);

        inputFile.value = '';
        preview.src = '';
        preview.style.display = 'none';
        box.classList.add('state-empty');
        box.classList.remove('state-filled');
        removeBtn.classList.add('d-none');
        document.getElementById('h_' + id).value = '1';
    }
</script>