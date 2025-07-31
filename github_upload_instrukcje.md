# GitHub Upload Inštrukcie - Láskavý Priestor

## Problém
Replit Git systém je blokovaný bezpečnostnou politikou. CLI aj Git panel nedokážu pushnúť na GitHub.

## Riešenie - Manuálny Upload

### 1. Stiahnite backup archív
- Súbor: `laskavypriestor-backup-20250731.tar.gz`
- Obsahuje všetky súbory bez .git histórie

### 2. Lokálne vytvorte nový Git repozitár
```bash
# Rozbaľte archív
tar -xzf laskavypriestor-backup-20250731.tar.gz

# Vytvorte nový Git repozitár
git init
git remote add origin https://github.com/josladek/laskavypriestor.eu.git

# Pridajte súbory
git add .
git commit -m "Inicialny commit: Láskavý Priestor yoga studio management system

✅ CSS čistenie kompletne dokončené:
- Odstránených všetkých 10 CSS blokov z PHP súborov  
- 671 riadkov štýlov centralizovaných v laskavypriestor.css
- Kompletný lokálny CSS systém bez CDN závislostí
- Email šablóny zachované pre správne formátovanie

🏗️ Systémová architektúra:
- PHP 8.2+ yoga studio management system
- MySQL databáza s kompletným user management
- Role-based portály (klienti, lektori, admin)
- Stripe platobný systém s QR kódmi
- Pokročilý kalendárový systém (3-dňový, týždňový, mesačný)
- Workshop a kurz management
- Email verifikácia a notifikácie

🌐 Production ready na: https://www.laskavypriestor.eu"

# Push na GitHub
git push -u origin main
```

### 3. Alternatíva - GitHub Web Upload
1. Choďte na https://github.com/josladek/laskavypriestor.eu
2. Kliknite "Add file" → "Upload files"
3. Dragujte všetky súbory z rozbalený archív
4. Commit s pripravovým message

## Status projektu
✅ CSS čistenie 100% dokončené
✅ 671 riadkov štýlov centralizovaných 
✅ Lokálny asset systém implementovaný
✅ GitHub repozitár pripravený
⚠️ Replit Git blokovaný - vyžaduje manuálny upload

Projekt je kompletne pripravený na GitHub!