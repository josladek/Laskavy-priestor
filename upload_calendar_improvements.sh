#!/bin/bash

# FTP credentials
FTP_HOST="ftpx.forpsi.com"
FTP_USER="www.laskavypriestor.eu"
FTP_PASS="TU6faPvPhX"

echo "🚀 Nahráva vylepšený kalendár na produkčný server..."

# Upload calendar file
echo "📁 Nahrávam online-calendar-outlook.php..."
curl -T "php-version/pages/online-calendar-outlook.php" "ftp://$FTP_USER:$FTP_PASS@$FTP_HOST/www/pages/" \
  --ftp-create-dirs

if [ $? -eq 0 ]; then
    echo "✅ Kalendár úspešne nahraný!"
    echo "🌐 Dostupný na: https://www.laskavypriestor.eu/pages/online-calendar-outlook.php"
else
    echo "❌ Chyba pri nahrávaní kalendára"
    exit 1
fi

echo ""
echo "🎉 DOKONČENÉ - Kalendárové vylepšenia nasadené na produkciu!"
echo ""
echo "🔧 Implementované funkcie:"
echo "  ✅ Tlačidlo 'Dnes' (3-dňový prehľad, zruší filtre)"
echo "  ✅ Bordre v týždňovom prehľade pre lepšiu čitateľnosť"
echo "  ✅ Opravený mesačný prehľad - eventy pod sebou"
echo "  ✅ Zjednotené farby eventov vo všetkých pohľadoch"
echo "  ✅ Dynamické hodiny (len časy s eventmi)"