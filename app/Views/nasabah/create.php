<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="nasabahAdd" class="content-section active">
                    <h1>Tambah Nasabah Baru</h1>
                    <div class="card">
                        <form class="form-nasabah" action="<?= base_url('nasabah/store') ?>" method="POST">
                            <div class="form-group">
                                <label for="namaLengkap">Nama Lengkap:</label>
                                <input type="text" id="namaLengkap" name="nama_lengkap" required placeholder="Isi Nama Lengkap Sesuai KTP">
                            </div>
                            <div class="form-group">
                                <label for="jenisAkun">Jenis Akun:</label>
                                <select id="jenisAkun" name="jenis_akun" required>
                                    <option value="">Pilih Jenis Akun</option>
                                    <option value="Tabungan">Tabungan</option>
                                    <option value="Giro">Giro</option>
                                    <option value="Deposito">Deposito</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="noRekening">Nomor Rekening:</label>
                                <input type="text" id="noRekening" name="no_rekening" required placeholder="Masukkan 15 Digit Nomor Rekening">
                            </div>
                            <div class="form-group">
                                <label for="tanggalArsip">Tanggal Arsip:</label>
                                <input type="date" id="tanggalArsip" name="tanggal_arsip" required>
                            </div>
                            <button type="submit" class="submit-btn">Simpan Data Nasabah</button>
                        </form>
                    </div>
            </div>
        </div>

<script src="<?= base_url('js/nama-lengkap.js') ?>"></script>
<script src="<?= base_url('js/no-rek.js') ?>"></script>

<?= $this->endSection() ?>
