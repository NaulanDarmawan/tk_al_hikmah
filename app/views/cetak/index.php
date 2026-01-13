<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Filter Data Rapor Siswa</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="filter_ta" value="<?php echo $data['tahun_ajaran_aktif']; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select class="form-control" id="filter_semester">
                                <option value="I">Semester I</option>
                                <option value="II">Semester II</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" id="filter_kelas">
                                <option value="TK-A">TK-A</option>
                                <option value="TK-B">TK-B</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="keyword">Cari Siswa (Nama/NIS)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="filter_keyword" placeholder="Ketik nama...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="btn_cari_rapor">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hasil Pencarian Siswa</h3>
            </div>
            <div class="card-body p-0" id="hasil_pencarian_rapor">
                <p class="p-3 text-muted text-center">Silakan pilih filter dan klik "Cari" untuk menampilkan daftar siswa.</p>
            </div>
        </div>
    </div>
</div>