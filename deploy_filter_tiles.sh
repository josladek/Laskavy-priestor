#!/bin/bash

echo "=== NASADENIE FILTROVANIA DLAŽDICAMI NA PRODUKČNÝ SERVER ==="
echo "Dátum: $(date)"
echo ""

# FTP credentials
FTP_SERVER="ftpx.forpsi.com"
FTP_USER="laskavypriestor.eu"
FTP_PASS="Mandala123"

# Create temporary FTP script
cat > /tmp/ftp_upload.txt << 'EOF'
# Connect and navigate to web directory
cd /
cd web/

# Upload modified files
put php-version/pages/classes.php pages/classes.php
put php-version/includes/header.php includes/header.php

# Verify uploads
ls -la pages/classes.php
ls -la includes/header.php

# Quit
quit
EOF

echo "📁 Nahrávam upravené súbory:"
echo "   1. pages/classes.php - nové filtrovanie dlaždicami"
echo "   2. includes/header.php - CSS štýly pre dlaždice"
echo ""

# Execute FTP upload
ftp -n "$FTP_SERVER" < /tmp/ftp_upload.txt

echo ""
echo "✅ NASADENIE DOKONČENÉ!"
echo "🌐 Stránka dostupná na: https://www.laskavypriestor.eu/pages/classes.php"
echo ""
echo "🎨 Nové funkcie:"
echo "   - Filtrovanie pomocou pastelových dlaždíc"
echo "   - Každý typ lekcie má vlastnú farbu a ikonu"
echo "   - Hover animácie a aktívne stavy"
echo "   - Počítanie lekcií v reálnom čase"
echo ""

# Cleanup
rm -f /tmp/ftp_upload.txt

exit 0