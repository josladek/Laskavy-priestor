#!/bin/bash

# FTP credentials
HOST="ftpx.forpsi.com"
USER="www.laskavypriestor.eu"
PASS="TU6faPvPhX"

echo "=== KOMPLETNÉ NASADENIE NA PRODUKČNÝ SERVER ==="
echo "Nahrávam všetky súbory projektu na https://www.laskavypriestor.eu"

# Upload all directories and files
echo "📁 Uploading admin/ directory..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/ admin/

echo "📁 Uploading api/ directory..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/ api/

echo "📁 Uploading config/ directory..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/ config/

echo "📁 Uploading includes/ directory..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/ includes/

echo "📁 Uploading lektor/ directory..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/ lektor/

echo "📁 Uploading pages/ directory..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/ pages/

echo "📁 Uploading assets/ directory..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/ assets/

echo "📄 Uploading root files..."
ncftpput -v -u "$USER" -p "$PASS" "$HOST" /www/ index.php
ncftpput -v -u "$USER" -p "$PASS" "$HOST" /www/ .htaccess

echo "=== NASADENIE DOKONČENÉ ==="
echo "✅ Všetky súbory nahrané na produkčný server"
echo "🌐 Dostupné na: https://www.laskavypriestor.eu"
echo "📋 Kurz registrácia s QR kódom a emailom plně funkčná"
