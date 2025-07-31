#!/bin/bash

echo "=== FTP NASADENIE FILTROVANIA DLAŽDICAMI ==="
echo "Dátum: $(date)"
echo ""

# FTP credentials from user
FTP_SERVER="ftpx.forpsi.com"
FTP_USER="www.laskavypriestor.eu"
FTP_PASS="TU6faPvPhX"

echo "📡 Pripájam sa na FTP server: $FTP_SERVER"
echo "👤 Používateľ: $FTP_USER"
echo ""

# Upload files using curl FTP
echo "📁 Nahrávam pages/classes.php..."
curl -T "php-version/pages/classes.php" \
     --user "$FTP_USER:$FTP_PASS" \
     "ftp://$FTP_SERVER/www/pages/classes.php" \
     --connect-timeout 30 \
     --max-time 120

echo ""
echo "📁 Nahrávam includes/header.php..."
curl -T "php-version/includes/header.php" \
     --user "$FTP_USER:$FTP_PASS" \
     "ftp://$FTP_SERVER/www/includes/header.php" \
     --connect-timeout 30 \
     --max-time 120

echo ""
echo "✅ FTP NASADENIE DOKONČENÉ!"
echo "🌐 Nové filtrovanie dlaždičkami dostupné na:"
echo "   https://www.laskavypriestor.eu/pages/classes.php"
echo ""