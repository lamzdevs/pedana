<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="dashboardSection" class="content-section active">
    <h1>Dashboard Utama</h1>
    <div class="metric-cards">
        <div class="card metric-card total-nasabah">
            <i class="fa-solid fa-users"></i>
            <div class="card-info">
                <div class="value"><?= $total_nasabah ?></div>
                <div class="label">Total Nasabah Aktif</div>
            </div> 
        </div>
        <?php if ($role === 'staff' || !$role): ?>
            <div class="card metric-card new-entries">
                <i class="fa-solid fa-user-plus"></i>
                <div class="card-info">
                    <div class="value"><?= isset($new_entries) ? $new_entries : 0 ?></div>
                    <div class="label">Entri Nasabah Bulan Ini</div>
                </div>
            </div>
            <div class="card metric-card doc-pending">
                <i class="fa-solid fa-file-circle-exclamation"></i>
                <div class="card-info">
                    <div class="value"><?= isset($doc_pending) ? $doc_pending : 0 ?></div>
                    <div class="label">Dokumen Pending</div>
                </div>
            </div>
            <div class="card metric-card doc-error">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <div class="card-info">
                    <div class="value"><?= isset($doc_error) ? $doc_error : 0 ?></div>
                    <div class="label">Dokumen Bermasalah</div>
                </div>
            </div>
        <?php elseif ($role === 'supervisor'): ?>
            <div class="card metric-card" style="border-left: 5px solid #dc3545;">
                <i class="fa-solid fa-user-minus" style="color: #dc3545; background-color: #f8d7da;"></i>
                <div class="card-info">
                    <div class="value"><?= isset($nasabah_inactive) ? $nasabah_inactive : 0 ?></div>
                    <div class="label">Nasabah Tidak Aktif</div>
                </div>
            </div>
            <div class="card metric-card doc-pending">
                <i class="fa-solid fa-file-circle-exclamation"></i>
                <div class="card-info">
                    <div class="value"><?= isset($doc_pending) ? $doc_pending : 0 ?></div>
                    <div class="label">Dokumen Pending</div>
                </div>
            </div>
            <div class="card metric-card doc-approved" style="border-left: 5px solid #28a745;">
                <i class="fa-solid fa-file-circle-check" style="color: #28a745; background-color: #d4edda;"></i>
                <div class="card-info">
                    <div class="value"><?= isset($doc_approved_month) ? $doc_approved_month : 0 ?></div>
                    <div class="label">Dokumen Disetujui Bulan Ini</div>
                </div>
            </div>
        <?php elseif ($role === 'admin'): ?>
            <div class="card metric-card" style="border-left: 5px solid #dc3545;">
                <i class="fa-solid fa-user-minus" style="color: #dc3545; background-color: #f8d7da;"></i>
                <div class="card-info">
                    <div class="value"><?= isset($nasabah_inactive) ? $nasabah_inactive : 0 ?></div>
                    <div class="label">Nasabah Tidak Aktif</div>
                </div>
            </div>
            <div class="card metric-card total-users" style="border-left: 5px solid #17a2b8;">
                <i class="fa-solid fa-users-gear" style="color: #17a2b8; background-color: #d1ecf1;"></i>
                <div class="card-info">
                    <div class="value"><?= isset($total_pengguna) ? $total_pengguna : 0 ?></div>
                    <div class="label">Total Pengguna</div>
                </div>
            </div>
            <div class="card metric-card active-roles" style="border-left: 5px solid #28a745;">
                <i class="fa-solid fa-user-check" style="color: #28a745; background-color: #d4edda;"></i>
                <div class="card-info">
                    <div class="value"><?= isset($active_users) ? $active_users : 0 ?></div>
                    <div class="label">Akun Pengguna Aktif</div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="summary-area">
        <div class="card chart-card">
            <h2>Tren Entri Data Tahunan (<?= date('Y') ?>)</h2>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="entriDataChart"></canvas>
            </div>
        </div>
        <div class="card activity-card">
            <h2>Aktivitas Terbaru</h2>
            <ul class="activity-list">
                <?php if(empty($recent_activities)): ?>
                    <li style="font-size: 12px;"><span class="user-name" style="color: #666;">Belum ada aktivitas</span> untuk role ini.</li>
                <?php else: ?>
                    <?php foreach($recent_activities as $act): ?>
                        <li style="font-size: 12px; margin-bottom: 8px;">
                            <span class="user-name"><?= esc(ucfirst($act['role'])) ?> <?= esc($act['fullname']) ?></span> 
                            <?= esc($act['action']) ?> <?= esc($act['target_data'] ? '('.$act['target_data'].')' : '') ?>
                            <br><small style="color: #999; font-size: 10px;"><?= date('d/m/Y H:i', strtotime($act['created_at'])) ?></small>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('entriDataChart').getContext('2d');
        const chartData = <?= json_encode($chart_data) ?>;
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Nasabah',
                    data: chartData,
                    backgroundColor: '#023E8A',
                    borderRadius: 5,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: { family: "'Kodchasan', sans-serif" }
                        }
                    },
                    x: {
                        ticks: {
                            font: { family: "'Kodchasan', sans-serif" }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        titleFont: { family: "'Kodchasan', sans-serif" },
                        bodyFont: { family: "'Kodchasan', sans-serif" }
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>
