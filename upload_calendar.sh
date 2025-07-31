#!/bin/bash

# FTP nastavenia
FTP_SERVER="ftpx.forpsi.com"
FTP_USER="www.laskavypriestor.eu"
FTP_PASS="TU6faPvPhX"
FTP_DIR="/www"

echo "🚀 Nahrávam kalendár na produkčný server..."

# Nahraj online-calendar.php
echo "📅 Nahrávam online-calendar.php..."
lftp -c "
set ftp:ssl-allow no
open ftp://$FTP_USER:$FTP_PASS@$FTP_SERVER
cd $FTP_DIR/pages
put php-version/pages/online-calendar.php
quit
"

if [ $? -eq 0 ]; then
    echo "✅ Kalendár úspešne nahraný na produkčný server!"
    echo "🌐 Dostupný na: https://www.laskavypriestor.eu/pages/online-calendar.php"
else
    echo "❌ Chyba pri nahrávaní kalendára!"
    exit 1
fi

echo "🎨 Kalendár má teraz:"
echo "  • Týždňový pohľad ako predvolený (dni vertikálne, hodiny horizontálne)"
echo "  • Mesačný pohľad s kompletným zobrazením bez skrolovania"
echo "  • Pastelovú farebnú schému (zelená, modrá, ružová)"
echo "  • Dynamické časové sloty - zobrazujú sa len hodiny s lekciami + kontext"
echo "  • Opravené 'max_participants' upozornenia"
echo "  • Interaktívne modálne okná s detailmi lekcií"
echo "  • Možnosť prihlásenia priamo z kalendára"