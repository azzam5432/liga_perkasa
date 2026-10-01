#!/usr/bin/env bash
# ==============================================================================
# Script Otomasi Deployment Laravel ke Hostinger (via SSH / Terminal hPanel)
# Jalankan di folder root proyek Laravel Anda:
#   bash deploy-hostinger.sh
# ==============================================================================

set -e

echo "🚀 [1/6] Mengaktifkan Mode Pemeliharaan (Maintenance Mode)..."
php artisan down || true

echo "📦 [2/6] Memasang dependensi Composer (Production)..."
# Menggunakan --no-dev untuk performa dan --optimize-autoloader
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

echo "🗄️  [3/6] Menjalankan migrasi database..."
php artisan migrate --force

echo "⚡ [4/6] Mengoptimalkan Cache Laravel..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔒 [5/6] Mengatur permission folder storage & uploads..."
chmod -R 775 storage bootstrap/cache
chmod -R 775 public/uploads 2>/dev/null || true

echo "✨ [6/6] Menonaktifkan Maintenance Mode (Website LIVE)..."
php artisan up

echo "✅ Deployment ke Hostinger selesai dengan sukses!"
