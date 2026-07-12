<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>
<div id="laporanAnalisis" class="content-section active">
                    <h1>Laporan & Analisis</h1>
                    <div class="dashboard-grid">
                        <div class="stat-card blue">
                            <div class="stat-title">Total Nasabah</div>
                            <div class="stat-value"><?= isset($total_nasabah) ? $total_nasabah : 0 ?></div>
                        </div>
                        <div class="stat-card green">
                            <div class="stat-title">Nasabah Aktif</div>
                            <div class="stat-value"><?= isset($nasabah_aktif) ? $nasabah_aktif : 0 ?></div>
                        </div>
                        <div class="stat-card red">
                            <div class="stat-title">Diarsipkan</div>
                            <div class="stat-value"><?= isset($nasabah_arsip) ? $nasabah_arsip : 0 ?></div>
                        </div>
                    </div>

                    <div class="charts-grid">
                        <div class="card">
                            <div class="chart-header">
                                <h3>Komposisi Jenis Akun</h3>
                            </div>
                            <div style="height: 300px;">
                                <canvas id="chartJenisAkun"></canvas>
                            </div>
                        </div>

                        <div class="card">
                            <div class="chart-header">
                                <h3>Rasio Status Nasabah</h3>
                            </div>
                            <div style="height: 300px; max-width: 400px; margin: 0 auto;">
                                <canvas id="chartStatus"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Kodchasan', sans-serif";

    const dataJenisAkun = <?= json_encode($chart_jenis_akun ?? []) ?>;
    const dataStatus = <?= json_encode($chart_status ?? []) ?>;

    const jenisAkunLabels = dataJenisAkun.map(item => item.jenis_akun || 'Tidak Diketahui');
    const jenisAkunData = dataJenisAkun.map(item => item.total);

    const colorMap = {
        'Tabungan': '#28a745',
        'Deposito': '#17a2b8',
        'Giro': '#ffc107'
    };
    const jenisAkunColors = jenisAkunLabels.map(label => colorMap[label] || '#6c757d');

    const statusLabels = dataStatus.map(item => item.status || 'Tidak Diketahui');
    const statusData = dataStatus.map(item => item.total);

    const ctxJenisAkun = document.getElementById('chartJenisAkun').getContext('2d');
    new Chart(ctxJenisAkun, {
        type: 'pie',
        data: {
            labels: jenisAkunLabels,
            datasets: [{
                data: jenisAkunData,
                backgroundColor: jenisAkunColors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 40
                    }
                }
            }
        }
    });

    const ctxStatus = document.getElementById('chartStatus').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: ['#28a745', '#dc3545', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 40
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>
