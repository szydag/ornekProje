<?= $this->extend('app/layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .dashboard-layout {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    
    .dashboard-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 25px 45px rgba(0,0,0,0.1);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-layout">
    <div class="container mx-auto px-6 py-8">
        <!-- Dashboard Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Dashboard</h1>
            <p class="text-white/80">Hoş geldiniz! İşte sistem özetiniz.</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Toplam Eğitim İçeriği</h3>
                        <p class="text-3xl font-bold text-primary mt-2">1,234</p>
                    </div>
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center">
                        <i class="ki-filled ki-book text-2xl text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Aktif Kullanıcı</h3>
                        <p class="text-3xl font-bold text-success mt-2">567</p>
                    </div>
                    <div class="w-16 h-16 bg-success/10 rounded-full flex items-center justify-center">
                        <i class="ki-filled ki-users text-2xl text-success"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Bu Ay</h3>
                        <p class="text-3xl font-bold text-warning mt-2">89</p>
                    </div>
                    <div class="w-16 h-16 bg-warning/10 rounded-full flex items-center justify-center">
                        <i class="ki-filled ki-calendar text-2xl text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Görüntülenme</h3>
                        <p class="text-3xl font-bold text-danger mt-2">12.5K</p>
                    </div>
                    <div class="w-16 h-16 bg-danger/10 rounded-full flex items-center justify-center">
                        <i class="ki-filled ki-eye text-2xl text-danger"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="dashboard-card p-8">
            <?= $this->renderSection('dashboard_content') ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
