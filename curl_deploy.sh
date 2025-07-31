#!/bin/bash

echo "=== NASADENIE FILTROVANIA DLAŽDICAMI POMOCOU CURL ==="
echo "Dátum: $(date)"
echo ""

# Test production server accessibility first
echo "🔍 Testujem dostupnosť produkčného servera..."
curl -s --head "https://www.laskavypriestor.eu" | head -1

echo ""
echo "📁 Pripravujem súbory na nasadenie:"
echo "   1. pages/classes.php - nové filtrovanie dlaždicami"
echo "   2. includes/header.php - CSS štýly pre dlaždice"
echo ""

# Check if files exist
if [ -f "php-version/pages/classes.php" ]; then
    echo "✅ Súbor classes.php existuje ($(stat -c%s php-version/pages/classes.php) bytes)"
else
    echo "❌ Súbor classes.php neexistuje!"
    exit 1
fi

if [ -f "php-version/includes/header.php" ]; then
    echo "✅ Súbor header.php existuje ($(stat -c%s php-version/includes/header.php) bytes)"
else
    echo "❌ Súbor header.php neexistuje!"
    exit 1
fi

echo ""
echo "ℹ️  Poznámka: Pre FTP nasadenie je potrebné manuálne nahrať súbory"
echo "   Server: ftpx.forpsi.com"
echo "   Cieľ: /web/pages/classes.php a /web/includes/header.php"
echo ""

echo "✅ SÚBORY PRIPRAVENÉ NA NASADENIE!"
echo "🌐 Po nasadení bude dostupné na: https://www.laskavypriestor.eu/pages/classes.php"
echo ""
echo "🎨 Nové funkcie filtrovania dlaždicami:"
echo "   - Pastelové dlaždice pre každý typ lekcie"
echo "   - Unikátne FontAwesome ikony"
echo "   - Hover animácie a aktívne stavy"
echo "   - Real-time počítanie lekcií"
echo "   - Responsívne rozloženie"
echo ""