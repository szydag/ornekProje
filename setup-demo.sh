#!/bin/bash

echo "🚀 EduContent - Sunum Demo Kurulumu"
echo "======================================"
echo ""

# Docker container'larının çalıştığından emin ol
echo "📦 Docker container'larını kontrol ediliyor..."
if ! docker-compose ps | grep -q "Up"; then
    echo "⚠️  Docker container'ları çalışmıyor. Başlatılıyor..."
    docker-compose up -d
    echo "⏳ MySQL'in hazır olması bekleniyor (10 saniye)..."
    sleep 10
fi

echo "✅ Container'lar hazır!"
echo ""

# Migration'ları çalıştır
echo "🗄️  Veritabanı migration'ları çalıştırılıyor..."
docker-compose exec -T php php spark migrate
if [ $? -ne 0 ]; then
    echo "❌ Migration hatası! Lütfen kontrol edin."
    exit 1
fi

echo "✅ Migration'lar tamamlandı!"
echo ""

# Demo verilerini yükle
echo "📊 Demo verileri yükleniyor..."
docker-compose exec -T php php spark db:seed DemoDataSeeder
if [ $? -ne 0 ]; then
    echo "❌ Seeder hatası! Lütfen kontrol edin."
    exit 1
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ SUNUM DEMO KURULUMU TAMAMLANDI!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "🌐 Web Uygulaması: http://localhost:8081"
echo "📊 phpMyAdmin:     http://localhost:8080"
echo ""
echo "👥 Demo Kullanıcılar:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "👤 Admin:     admin@educontent.com    / admin123"
echo "👤 Editör:    editor@educontent.com   / editor123"
echo "👤 Hakem:     reviewer@educontent.com / reviewer123"
echo "👤 Yazar:     author@educontent.com   / author123"
echo "👤 Demo:      demo@educontent.com     / demo123"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "🎯 Sunum için hazır! Başarılar! 🎉"


