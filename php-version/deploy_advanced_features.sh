#!/bin/bash

# FTP deployment script for advanced client features
FTP_HOST="ftpx.forpsi.com"
FTP_USER="www.laskavypriestor.eu"
FTP_PASS="TU6faPvPhX"
FTP_DIR="/www/"

echo "=== NASADENIE POKROČILÝCH FUNKCIÍ NA PRODUKCIU ==="
echo "Nahrávanie súborov na https://www.laskavypriestor.eu"
echo

# Upload new files
echo "📤 Nahrávanie nových súborov..."

# Advanced client features
ftp -inv $FTP_HOST << FTPEOF
user $FTP_USER $FTP_PASS
cd $FTP_DIR

# Upload main new files
lcd pages
cd pages
put online-calendar.php
put reports.php
put communication.php
put my-statistics.php
put class-rating.php

cd ../includes
lcd ../includes
put functions.php
put email_functions.php
put header.php

bye
FTPEOF

echo "✅ Nasadenie dokončené!"
echo "🔗 Nové funkcie dostupné na: https://www.laskavypriestor.eu"
echo
echo "📋 PRIDANÉ FUNKCIE:"
echo "   • Online kalendár: /pages/online-calendar.php"
echo "   • Reporty a štatistiky: /pages/reports.php"
echo "   • Hromadná komunikácia: /pages/communication.php"
echo "   • Klientské štatistiky: /pages/my-statistics.php"
echo "   • Hodnotenie lekcií: /pages/class-rating.php"
echo
echo "⚠️  POŽADOVANÉ SQL SKRIPTY:"
echo "   Spustite mysql_updates.sql na MySQL databáze"

