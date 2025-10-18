<?= $this->extend('app/layouts/main') ?>

<?= $this->section('content') ?>
    <div class="dashboard-section">
        <h2>Dashboard</h2>
        <p>İşte dashboard sayfanız!</p>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Toplam Kullanıcı</h3>
                <div class="stat-number">1,234</div>
                <div class="stat-change positive">+12%</div>
            </div>
            
            <div class="stat-card">
                <h3>Toplam Sipariş</h3>
                <div class="stat-number">567</div>
                <div class="stat-change positive">+8%</div>
            </div>
            
            <div class="stat-card">
                <h3>Gelir</h3>
                <div class="stat-number">₺45,678</div>
                <div class="stat-change negative">-3%</div>
            </div>
            
            <div class="stat-card">
                <h3>Dönüşüm Oranı</h3>
                <div class="stat-number">3.2%</div>
                <div class="stat-change positive">+0.5%</div>
            </div>
        </div>
        
        <div class="recent-activity">
            <h3>Son Aktiviteler</h3>
            <div class="activity-list">
                <div class="activity-item">
                    <span class="activity-icon">👤</span>
                    <span class="activity-text">Yeni kullanıcı kaydı: Ahmet Yılmaz</span>
                    <span class="activity-time">2 saat önce</span>
                </div>
                <div class="activity-item">
                    <span class="activity-icon">📦</span>
                    <span class="activity-text">Yeni sipariş: #12345</span>
                    <span class="activity-time">4 saat önce</span>
                </div>
                <div class="activity-item">
                    <span class="activity-icon">💰</span>
                    <span class="activity-text">Ödeme alındı: ₺1,250</span>
                    <span class="activity-time">6 saat önce</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid #007bff;
        }
        
        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .stat-change {
            font-size: 14px;
            font-weight: 500;
        }
        
        .stat-change.positive {
            color: #28a745;
        }
        
        .stat-change.negative {
            color: #dc3545;
        }
        
        .recent-activity {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        
        .activity-list {
            margin-top: 15px;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f1f3f4;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            font-size: 20px;
            margin-right: 15px;
        }
        
        .activity-text {
            flex: 1;
        }
        
        .activity-time {
            color: #666;
            font-size: 14px;
        }
    </style>
<?= $this->endSection() ?>
