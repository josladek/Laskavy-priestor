#!/bin/bash

echo "=== FTP NASADENIE PASTELOVÝCH KARIET V ADMIN DASHBOARDE ==="
echo "Dátum: $(date)"
echo ""

# FTP credentials from user
FTP_SERVER="ftpx.forpsi.com"
FTP_USER="www.laskavypriestor.eu"
FTP_PASS="TU6faPvPhX"

echo "📡 Pripájam sa na FTP server: $FTP_SERVER"
echo "👤 Používateľ: $FTP_USER"
echo ""

# Upload admin dashboard with pastel cards
echo "📁 Nahrávam admin/dashboard.php..."
curl -T "php-version/admin/dashboard.php" \
     --user "$FTP_USER:$FTP_PASS" \
     "ftp://$FTP_SERVER/www/admin/dashboard.php" \
     --connect-timeout 30 \
     --max-time 120

echo ""
echo "✅ FTP NASADENIE DOKONČENÉ!"
echo "🌐 Pastelové karty v admin dashboarde dostupné na:"
echo "   https://www.laskavypriestor.eu/admin/dashboard.php"