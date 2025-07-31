# Láskavý Priestor - Yoga Studio Management System

## Overview

Láskavý Priestor is a comprehensive yoga studio management system built in PHP. The application provides separate portals for students, instructors (lektors), and administrators, featuring class scheduling, user registration, payment processing, and administrative tools. The system uses a traditional LAMP stack architecture with a focus on simplicity and maintainability.

## User Preferences

Preferred communication style: Simple, everyday language.
Work approach: Always ask for permission before starting any bug fixes or code changes.

## System Architecture

### Frontend Architecture
- **Technology Stack**: Pure PHP with server-side rendering
- **CSS Framework**: Bootstrap 5 with custom CSS variables and themes
- **JavaScript**: Vanilla JavaScript with Bootstrap components
- **Typography**: Roboto font family with FontAwesome icons
- **Design System**: Custom CSS variables for consistent theming using sage green, cream, and warm beige color palette

### Backend Architecture
- **Language**: PHP (procedural style)
- **Server**: Apache with mod_rewrite enabled
- **Database**: MySQL/MariaDB with procedural PDO connections
- **Session Management**: PHP native sessions
- **File Structure**: Modular organization with separate directories for different user roles

### Directory Structure
```
php-version/
├── admin/          # Administrator portal (27 files)
├── api/            # API endpoints (7 files) - Note: Some moved to pages/ due to server issues
├── config/         # Configuration files (4 files)
├── includes/       # Shared functions and utilities (6 files)
├── lektor/         # Instructor portal (10 files) - Consolidated from instructor/
├── pages/          # Public pages and some API functions (15 files)
├── uploads/        # File upload directories
├── assets/         # CSS and JavaScript files
└── .htaccess       # Apache URL rewriting rules
```

## Key Components

### User Management System
- **Multi-role authentication**: Students, instructors (lektors), and administrators
- **Role-based access control**: Different portal interfaces for each user type
- **Registration system**: Separate registration flows for different user roles
- **Profile management**: User profile editing and management capabilities

### Class Management
- **Class scheduling**: Create, edit, and manage yoga classes
- **Attendance tracking**: Comprehensive attendance system in lektor portal
- **Class registration**: Students can register for individual classes or courses
- **Capacity management**: Track class capacity and available spots

### Payment Integration
- **Stripe Integration**: Composer dependency for stripe/stripe-php v10.0
- **Dual pricing system**: Different pricing for members and non-members
- **Transaction processing**: Secure payment handling for class registrations

### Administrative Portal
- **Dashboard**: Comprehensive admin dashboard for system oversight
- **User management**: Manage all user accounts and roles
- **Class oversight**: Monitor all classes and registrations
- **Analytics**: System usage and performance metrics

## Data Flow

### User Registration Flow
1. User selects role during registration (student/instructor)
2. Form validation occurs client-side and server-side
3. User data is stored in database with appropriate role assignment
4. Email verification or approval process (depending on role)
5. User is redirected to appropriate portal based on role

### Class Registration Flow
1. Student browses available classes on public pages
2. Registration form processes through pages/register-class.php
3. Payment processing via Stripe integration
4. Database transaction updates class capacity and user registrations
5. Confirmation and receipt generation

### URL Routing and Redirects
- **Legacy compatibility**: .htaccess rules redirect old /instructor/ URLs to /lektor/
- **Clean URLs**: Rewrite rules for user-friendly URLs
- **API fallback**: Some API endpoints moved to pages/ directory due to server configuration issues

## External Dependencies

### Third-party Services
- **Stripe**: Payment processing (stripe/stripe-php v10.0 via Composer)
- **Google Fonts**: Roboto font family for typography
- **FontAwesome**: Icon library for UI elements
- **Bootstrap 5**: CSS framework for responsive design

### Server Dependencies
- **Apache**: Web server with mod_rewrite enabled
- **PHP**: Server-side scripting (procedural style)
- **MySQL/MariaDB**: Database management
- **Composer**: PHP dependency management

## Deployment Strategy

### Development Environment
- **Replit compatibility**: main.py file exists for Gunicorn requirement but actual app runs from php-version/
- **Local development**: Direct access to php-version directory
- **Asset management**: Separate CSS and JS files in assets/ directory

### Production Environment
- **FTP deployment**: Manual FTP upload to production server
- **Server configuration**: Apache with custom .htaccess rules
- **File permissions**: Proper upload directory permissions required
- **Database setup**: MySQL database with appropriate user privileges

### Known Issues and Solutions
- **API directory server issues**: Some API endpoints moved to pages/ directory due to server configuration problems
- **Directory consolidation**: instructor/ directory consolidated into lektor/ with redirect rules for backward compatibility
- **Clean deployment**: Project cleaned from 100+ files to 79 files, removing unnecessary documentation and backup files

### Maintenance Considerations
- **Manual cleanup required**: Some old files may need manual removal from production server
- **FTP limitations**: Server doesn't allow programmatic file deletion, requiring manual intervention
- **Legacy URL support**: Redirect rules maintain compatibility with old instructor/ URLs

## Posledná aktualizácia  
Júl 31, 2025 - GITHUB INTEGRÁCIA NASTAVENÁ A CSS SYSTÉM KOMPLETNÝ

### 💾 LOKÁLNY CSS FRAMEWORK KOMPLETNE IMPLEMENTOVANÝ (Júl 30-31, 2025)
- ✅ **BOOTSTRAP 5.3.0 LOKÁLNE**: Stiahnutý bootstrap.min.css z CDN do /assets/css/
- ✅ **FONT AWESOME 6.4.0 LOKÁLNE**: Stiahnutý fontawesome.min.css z CDN do /assets/css/
- ✅ **BOOTSTRAP JS LOKÁLNE**: Stiahnutý bootstrap.bundle.min.js z CDN do /assets/js/
- ✅ **LASKAVYPRIESTOR.CSS VYTVORENÝ**: Kompletný CSS framework s všetkými komponentmi a štýlmi
- ✅ **BTN-SUCCESS SAGE THEME**: .btn-success používa sage farbu namiesto defaultnej Bootstrap zelenej
- ✅ **VŠETKY CUSTOM ŠTÝLY KONSOLIDOVANÉ**: CSS variables, button styles, cards, forms, tables, badges, FontAwesome fixes
- ✅ **HEADER.PHP AKTUALIZOVANÝ**: Odstránené CDN linky, pridané lokálne CSS súbory
- ✅ **FOOTER.PHP AKTUALIZOVANÝ**: Bootstrap JS používa lokálny súbor namiesto CDN
- ✅ **DUPLICITNÉ ŠTÝLY ODSTRÁNENÉ**: Vyčistená <style> sekcia v header.php - všetko je v laskavypriestor.css
- ✅ **FILTER TILES ŠTÝLY**: Pastelové dlaždice s hover animáciami zahrnuté v CSS
- ✅ **ADMIN DASHBOARD KARTY**: Pastelové gradienty pre admin karty (admin-card-green, admin-card-pink, atď.)
- ✅ **KALENDÁROVÉ ŠTÝLY**: Calendar grid, time slots, day columns, week grid - všetko v CSS
- ✅ **KOMPLETNÁ NEZÁVISLOSŤ**: Aplikácia funguje bez internetového pripojenia (okrem Google Fonts)
- ✅ **SYSTEMATICKÉ CSS ČISTENIE DOKONČENÉ (Júl 31, 2025)**: Odstránených 10 CSS blokov z PHP súborov
- ✅ **VŠETKY DUPLICÁTY ELIMINOVANÉ**: verify-email.php, resend-verification.php, instructors.php, courses.php, my-classes.php, profile.php, my-courses.php, course-detail.php, class-rating.php, admin/lecturers.php
- ✅ **EMAIL ŠABLÓNY ZACHOVANÉ**: Inline CSS v email.php a email_functions.php potrebný pre správne email formátovanie
- ✅ **CENTRALIZOVANÝ CSS SYSTÉM**: Všetky štýly konsolidované v laskavypriestor.css (671 riadkov)
- 🎯 **VÝSLEDOK**: Všetky štýly sú lokálne, btn-success má sage farbu, žiadne CDN závislosti pre CSS/JS, eliminované CSS duplicity

### 🐙 GITHUB INTEGRÁCIA PRIPRAVENÁ (Júl 31, 2025)
- ✅ **GITHUB TOKEN NASTAVENÝ**: Personal Access Token pridaný do Replit Secrets
- ✅ **GITHUB ÚČET PRIPOJENÝ**: Úspešná OAuth autorizácia medzi Replit a GitHub
- ✅ **REPOZITÁR VYTVORENÝ**: josladek/laskavypriestor.eu (public repository)
- ✅ **REMOTE URL NASTAVENÉ**: https://github.com/josladek/laskavypriestor.eu.git
- ⚠️ **CLI BLOKOVANÉ**: Git príkazový riadok blokovaný Replit security policy
- 🎯 **RIEŠENIE**: Použiť Git panel v Replit UI (Tools → Add Git)
- 📋 **COMMIT MESSAGE PRIPRAVENÉ**: Detailná správa pre inicialny commit pripravená
- 📁 **PROJEKT PRIPRAVENÝ**: Všetky súbory pripravené na upload na GitHub
- 🌐 **CIEĽ**: Verejný GitHub repozitár pre backup a version control

### 🔧 EMAIL VERIFIKÁCIA A SESSION MANAGEMENT OPRAVENÉ (Júl 22, 2025)
- ✅ **SESSION CONFLICTS VYRIEŠENÉ**: Opravená duplicitná inicializácia session v config.php
- ✅ **EMAIL VERIFIKÁCIA FUNKČNÁ**: Opravené parametre funkcií sendEmailVerification()
- ✅ **SESSION WARNINGS ELIMINOVANÉ**: Pridaná session_status() kontrola
- ✅ **DEBUG LOGGING PRIDANÉ**: Email systém má rozšírené loggovanie pre troubleshooting
- ✅ **ADMIN PORTÁL ROZŠÍRENÝ**: Pridaný create-user.php formulár pre správu používateľov
- ✅ **FTP DEPLOYMENT ÚSPEŠNÝ**: Všetky opravy nahrané na produkčný server cez ftpx.forpsi.com
- ✅ **EMAIL KÓDOVANIE OPRAVENÉ**: UTF-8 base64 kódovanie pre správne zobrazenie slovenčiny
- ✅ **VERIFIKAČNÝ LINK VIDITEĽNÝ**: Pridaný jasný textový link navyše k tlačidlu
- ✅ **OUTLOOK KOMPATIBILITA**: Všetky štýly prekonvertované na inline pre MS Outlook 365

### 🔄 AUTOMATICKÉ OZNAČENIE STATUSU LEKCIÍ (Júl 24, 2025)
- ✅ **ISFINISHED() FUNKCIA**: Kontrola či lekcia už skončila na základe dátum + time_end
- ✅ **GETEVENTSTATUS() FUNKCIA**: Určenie statusu lekcie (finished/today/upcoming)
- ✅ **AUTOMATICKÉ OZNAČENIE**: Lekcie sa označujú ako "Ukončená" po skončení
- ✅ **KONZISTENTNÉ ROZHRANIE**: Rovnaké označenia v classes.php aj attendance.php
- ✅ **DYNAMIC STATUS BADGES**: Farebné označenia - šedá (Ukončená), modrá (Dnes), zelená (Budúca)
- ✅ **REAL-TIME UPDATES**: Status sa aktualizuje pri každom načítaní stránky
- ✅ **IMPROVED UX**: Ukončené lekcie majú tlačidlo "Zobraziť dochádzku" namiesto "Označiť"
- ✅ **PRODUCTION DEPLOYMENT**: Všetky zmeny nahrané na produkčný server

### 🧭 JEDNOTNÉ NAVIGAČNÉ MENU IMPLEMENTOVANÉ (Júl 24, 2025)
- ✅ **UNIVERZÁLNE HORIZONTÁLNE MENU**: Všetci používatelia (klienti, lektori, admin) majú rovnaké menu: Domov | Lekcie | Kurzy | Workshopy | Lektori
- ✅ **ROLE-ŠPECIFICKÉ DROPDOWN**: Špecializované funkcie presunuté do dropdown menu pod menom používateľa
- ✅ **FAVICON CHYBA OPRAVENÁ**: Odstránený odkaz na neexistujúci favicon.png z header.php
- ✅ **PROFILE.PHP OPRAVENÝ**: Pridané $currentPage = 'profile' pre správne rozpoznanie stránky
- ✅ **KONZISTENTNÁ NAVIGÁCIA**: Menu zostáva rovnaké naprieč všetkými stránkami bez ohľadu na rolu
- ✅ **PRODUKČNÉ NASADENIE**: header.php a profile.php úspešne nahrané na server cez FTP
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu (všetky roly majú teraz jednotné menu)

### 📝 NOTES FIELD SUPPORT PRE KURZY A WORKSHOPY (Júl 25, 2025)
- ✅ **WORKSHOP API ROZŠÍRENÉ**: register-workshop.php teraz podporuje POST parametre z confirmation formu
- ✅ **NOTES FIELD PRIDANÉ**: Workshop_registrations tabuľka má podporu pre poznámky klientov
- ✅ **KURZ CONFIRMATION PAGE**: Vytvorený course-registration-confirm.php s notes poľom
- ✅ **KONZISTENTNÝ UX FLOW**: Všetky registrácie (lekcie, kurzy, workshopy) majú rovnaký 4-krokový proces
- ✅ **PAYMENT REQUEST SYSTEM**: Workshop a kurz registrácie používajú request_id parameter namiesto session dát
- ✅ **DATABASE INTEGRATION**: Notes sa ukladajú do registračných tabuliek a zobrazujú v payment requests
- ✅ **EMAIL NOTIFICATIONS**: Poznámky sa zahŕňajú do platobných emailov ako súčasť popisu
- ✅ **SQL QUERY OPRAVENÉ**: Zjednotené používanie CONCAT(first_name, last_name) v course-detail.php a course-registration-confirm.php
- ✅ **UNDEFINED ARRAY KEY BUG**: Opravené chýbajúce JOIN pre instructor_name a weeks kalkuláciu
- 🎯 **UNIFIKOVANÝ SYSTÉM**: Lekcie, kurzy aj workshopy majú identický registračný flow s notes podporou
- 📋 **POŽADOVANÝ FLOW**: Klik → confirmation page → "Potvrdiť registráciu za cenu" → payment info + email
- ⚠️ **IDENTIFIKOVANÝ PROBLÉM**: Databáza neobsahuje žiadne aktívne kurzy s status='active' a end_date >= CURDATE()
- ⚠️ **COURSES.PHP STATUS**: Zobrazuje sa správa "Žiadne kurzy" namiesto tlačidiel "Zobraziť detail"
- ⚠️ **DÔVOD**: getCourses(true) vracia prázdny array kvôli filtrom na aktívne kurzy
- ⚠️ **IMPACT**: Course-detail.php nemožno testovať bez existujúcich kurzov v databáze

### 🗑️ ADRESÁR UPLOAD_PACKAGE VYMAZANÝ (Júl 25, 2025)
- ✅ **ZASTARANÉ SÚBORY ODSTRÁNENÉ**: Vymazaný celý upload_package/ adresár s duplicitnými súbormi
- ✅ **PROJEKT VYČISTENÝ**: Odstránených 100+ nepotrebných súborov z deployment balíka  
- ✅ **AKTUÁLNA ŠTRUKTÚRA**: Zostal len php-version/ s aktuálnymi produkčnými súbormi
- ✅ **DISKOVÉ MIESTO UVOĽNENÉ**: Projekt značne zmenšený po odstránení duplicitných súborov
- 📝 **DÔVOD MAZANIA**: Upload_package obsahoval len historické súbory z júla 2025 pre email verifikáciu opravy

### 🔄 KURZ ODHLASOVANIE A OPÄTOVNÁ REGISTRÁCIA OPRAVENÉ (Júl 25, 2025)
- ✅ **PROBLEM FIXED**: Odhlásené kurzy sa už nezobrazujú v "Moje kurzy"
- ✅ **RE-REGISTRATION ENABLED**: Klienti sa môžu znovu prihlásiť na kurzy z ktorých sa odhlásili
- ✅ **LESSON CANCELLATION**: Pri odhlásení z kurzu sa automaticky zrušia aj registrácie na všetky lekcie kurzu
- ✅ **CANCELLED STATUS CLEANUP**: Zrušené registrácie sa mažú pri novej registrácii
- ✅ **DATABASE CONSISTENCY**: getUserCourseRegistrations() zobrazuje len potvrdené registrácie
- ✅ **LESSON AUTO-REGISTRATION**: Pri registrácii na kurz sa automaticky vytvárajú registrácie na všetky lekcie kurzu
- ✅ **PRODUCTION DEPLOYMENT**: Všetky súbory (functions.php, my-courses.php, register-course.php) nahrané na server
- ✅ **KURZ PLATOBNÉ POTVRDENIE OPRAVENÉ**: Registrácia na kurz teraz správne zobrazuje platobné informácie a odosiela email
- ✅ **SESSION DATA BUG VYRIEŠENÝ**: Kurz registrácia zmenená z session dát na URL parametre (rovnako ako lekcie)
- ✅ **PAYMENT FLOW UNIFIKOVANÝ**: Kurzy teraz používajú rovnaký flow ako lekcie: request_id parameter namiesto session storage
- ✅ **BACKEND LOGIKA OPRAVENÁ**: register-course.php presmerováva na course-payment-confirmation.php?request_id=X
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu (kurz registrácia s QR kódom a emailom funkčná)

### 💳 WORKSHOP A KURZ PLATBY IMPLEMENTOVANÉ (Júl 25, 2025)
- ✅ **WORKSHOP SYSTEM OVERHAUL**: Workshopy majú teraz jednu cenu bez rozlíšenia člen/nečlen
- ✅ **KREDIT PAYMENTS ODSTRÁNENÉ**: Workshopy a kurzy sa nemôžu platiť kreditom - len bankovým prevodom
- ✅ **PAYMENT REQUEST SYSTEM**: Vytvorený komplexný systém platobných požiadaviek pre workshopy a kurzy
- ✅ **EMAIL NOTIFICATIONS**: Automatické email notifikácie s QR kódmi pre workshop a kurz platby
- ✅ **DATABÁZA ROZŠÍRENÁ**: Pridané payment_status stĺpce do workshop_registrations a course_registrations
- ✅ **CONFIRMATION PAGES**: 
  - workshop-payment-confirmation.php - potvrdzovacia stránka pre workshopy
  - course-payment-confirmation.php - potvrdzovacia stránka pre kurzy
- ✅ **EMAIL FUNCTIONS**: 
  - sendWorkshopPaymentEmail() - email funkcia pre workshop platby
  - sendCoursePaymentEmail() - email funkcia pre kurz platby
  - generateWorkshopPaymentHtml() - HTML šablóna pre workshop emaily
  - generateCoursePaymentHtml() - HTML šablóna pre kurz emaily
- ✅ **UI UPDATES**: Odstránená kredit logika z workshops.php stránky
- ✅ **CONSISTENT PAYMENT FLOW**: Jednotný platobný proces pre všetky typy služieb (lekcie, kurzy, workshopy)
- ✅ **PRODUKČNÉ NASADENIE**: Všetky súbory nahrané na produkčný server cez FTP
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu (workshop a kurz platby funkčné)

### 🔧 KURZ REGISTRÁCIA KOMPLETNE OPRAVENÁ (Júl 25, 2025)
- ✅ **COURSE-DETAIL.PHP SQL OPRAVENÉ**: Zmenil `CONCAT(u.first_name, ' ', u.last_name)` na `u.name` + `$lesson['time']` na `$lesson['time_start']`
- ✅ **COURSE-REGISTRATION-CONFIRM.PHP OPRAVENÉ**: Opravené SQL query používa `u.name` namiesto neexistujúcich `u.first_name, u.last_name`
- ✅ **FORMATTIME() NULL PROTECTION**: Pridaná ochrana proti null hodnotám v functions.php pre elimináciu deprecated warnings
- ✅ **API/REGISTER-COURSE.PHP REDIRECT FIX**: Opravený redirect z `../pages/` na správnu `url()` funkciu
- ✅ **INTERNAL SERVER ERROR VYRIEŠENÝ**: Registrácia kurzu teraz správne presmerúva na course-payment-confirmation.php
- ✅ **KOMPLETNÝ WORKFLOW FUNKČNÝ**: Detail → Prihlásiť sa → Potvrdiť → Platobné potvrdenie s QR kódom a emailom
- ✅ **AUTOMATICKÁ REGISTRÁCIA NA LEKCIE**: Pri registrácii na kurz sa automaticky vytvárajú registrácie na všetky lekcie
- ✅ **PRODUKČNÉ NASADENIE**: Všetky opravené súbory nahrané na server (course-detail.php, course-registration-confirm.php, functions.php, api/register-course.php)
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu - kurz registrácia plne funkčná

### 🔄 KURZ/WORKSHOP OPÄTOVNÁ REGISTRÁCIA OPRAVENÁ (Júl 26, 2025)
- ✅ **CANCELLED REGISTRÁCIE PROBLÉM VYRIEŠENÝ**: Klienti môžu znovu registrovať na kurzy/workshopy po odhlásení
- ✅ **KURZ REGISTRÁCIA OPRAVENÁ**: register-course.php kontroluje len aktívne registrácie (confirmed/pending)
- ✅ **WORKSHOP REGISTRÁCIA OPRAVENÁ**: register-workshop.php kontroluje len aktívne registrácie (confirmed/waitlisted/pending)
- ✅ **AUTOMATICKÉ CLEANUP**: Cancelled registrácie sa automaticky mažú pred novou registráciou
- ✅ **KONZISTENTNÁ LOGIKA**: Všetky registračné typy používajú rovnaký prístup k cancelled stavom
- ✅ **PRODUKČNÉ NASADENIE**: Oba súbory nahrané na server cez FTP
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu - opätovná registrácia funkčná

### 🎯 WORKSHOP SYSTÉM PLNE ZJEDNOTENÝ S KURZMI (Júl 26, 2025)
- ✅ **WORKSHOP FLOW ZJEDNOTENÝ**: Workshop registrácia má teraz identický flow ako kurzy
- ✅ **PAYMENT_REQUESTS SYSTÉM**: Workshop používa payment_requests tabuľku ako kurzy
- ✅ **QR GENERÁTOR UNIFIKOVANÝ**: Workshop používa generateQRPaymentString() funkciu ako kurzy
- ✅ **URL PARAMETRE**: Workshop confirmation používa request_id parameter namiesto session dát
- ✅ **EMAIL FUNKCIONALITA**: Workshop emaily majú rovnakú štruktúru ako kurz emaily
- ✅ **POLE MAPPING OPRAVENÉ**: Použité správne názvy polí (title, time_start, time_end, duration_hours)
- ✅ **PACKAGE_ID ŠTANDARDIZOVANÉ**: Workshop používa package_id='WORKSHOP' v payment_requests
- ✅ **CONFIRMATION PAGE UPDATOVANÁ**: Workshop confirmation page používa správne polia
- ✅ **KOMPLETNÝ FLOW**: Výber → confirmation → payment info → email (identický s kurzmi)
- ✅ **PRODUKČNÉ NASADENIE**: Všetky workshop súbory nahrané na server cez FTP
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu - workshop systém plne funkčný

### 🚀 WORKSHOP SYSTÉM PLNE NASADENÝ NA PRODUKCIU (Júl 26-27, 2025)
- ✅ **FTP NASADENIE DOKONČENÉ**: Všetky workshop súbory nahrané na produkčný server
- ✅ **MYSQL DATABÁZA AKTUALIZOVANÁ**: Vykonané potrebné ALTER TABLE príkazy pre workshops a payment_requests
- ✅ **NOVÉ STĹPCE PRIDANÉ**: 
  - workshops.custom_instructor_name (VARCHAR 255)
  - workshops.is_free (TINYINT 1)  
  - payment_requests.workshop_id (INT)
  - workshop_registrations.updated_at (TIMESTAMP) - pridané 27.7.2025
- ✅ **INDEXY VYTVORENÉ**: idx_payment_requests_workshop_id pre optimalizáciu
- ✅ **WORKSHOP STRÁNKY FUNKČNÉ**: https://www.laskavypriestor.eu/pages/workshops.php načítava správne
- ✅ **ADMIN ROZHRANIE PRIPRAVENÉ**: Workshop admin rozhranie na /admin/workshops.php
- ✅ **EMAIL SYSTÉM INTEGROVANÝ**: Workshop emaily s QR kódmi a platobným potvrdením
- ✅ **PAYMENT FLOW ZJEDNOTENÝ**: Identický s kurzmi - confirmation → payment → email
- ✅ **KLIENTSKÝ PORTÁL KOMPLETNÝ**: Stránka "Moje workshopy" s možnosťou odhlásenia (27.7.2025)
- ✅ **NAVIGAČNÉ MENU AKTUALIZOVANÉ**: Pridaný odkaz "Moje workshopy" do klientského dropdown menu
- ✅ **QR KÓDY KOMPLETNE OPRAVENÉ**: Pridaný qr_generator.php include + opravené zobrazenie QR kódu na web stránke (27.7.2025)
- ✅ **QR BASE64 GENERÁCIA**: Zjednotená logika s kurzami pre správne zobrazenie QR kódov v emailoch aj na web stránke
- ✅ **CHYBY OPRAVENÉ**: Workshop payment confirmation a databázové stĺpce opravené
- ✅ **EDIT-WORKSHOP.PHP VYTVORENÝ**: Kompletný súbor pre editáciu workshopov podľa aktuálnych atribútov (27.7.2025)
- ✅ **VŠETKY AKTUÁLNE ATRIBÚTY**: is_free, custom_instructor_name, image_url, duration_hours, notes - zjednotené s create-workshop.php
- ✅ **DATABÁZOVÁ CHYBA OPRAVENÁ**: Zmenené db()->fetchRow() na správne db()->fetch() (28.7.2025)
- ✅ **ADMIN ROZHRANIE KOMPLETNÉ**: Vytváranie, editácia, mazanie a zobrazenie workshopov funkčné
- ✅ **PRODUKČNÝ SYSTÉM KOMPLETNÝ**: Workshop systém pripravený na plné používanie
- 🌐 **LIVE NA**: https://www.laskavypriestor.eu - workshop registrácie a správa plne funkčné

### 🚀 POKROČILÉ KLIENTSKÉ FUNKCIE IMPLEMENTOVANÉ (Júl 28, 2025)
- ✅ **ONLINE KALENDÁR KOMPLETNÝ**: Interaktívny kalendár s možnosťou registrácie na lekcie priamo z kalendára
- ✅ **KLIENTSKÉ ŠTATISTIKY**: Komplexný prehľad dochádzky, obľúbených typov a pokroku klienta
- ✅ **CLASS RATING SYSTÉM**: Možnosť hodnotenia lekcií s 5-hviezdičkovým systémom
- ✅ **ROZŠÍRENÉ REPORTY**: Detailné štatistiky pre adminov a lektorov s grafmi a exportom
- ✅ **HROMADNÁ KOMUNIKÁCIA**: Email systém pre kontakt s klientmi s šablónami správ
- ✅ **NAVIGÁCIA AKTUALIZOVANÁ**: Všetky nové funkcie pridané do dropdown menu s ikonami
- ✅ **HELPER FUNKCIE PRIDANÉ**: formatDateTime(), getUserCreditBalance() pre lepšiu funkcionalita
- ✅ **EMAIL ŠABLÓNY**: Profesionálne HTML šablóny pre hromadné emaily
- ✅ **ROLE-BASED ACCESS**: Rôzne funkcie dostupné podľa role používateľa (admin/lektor/klient)
- ✅ **DATABÁZOVÁ INTEGRÁCIA**: Všetky funkcie plne integrované s existujúcou databázou
- ✅ **PHP 8.1+ KOMPATIBILITA OPRAVENÁ**: Deprecated strftime() nahradené modernými date() funkciami
- ✅ **TABUĽKA KONZISTENCIA VYRIEŠENÁ**: Všetky súbory používajú správnu tabuľku 'registrations'
- ✅ **ROLE AUTENTIFIKÁCIA OPRAVENÁ**: requireRole('klient') namiesto neexistujúceho 'client'
- ✅ **DATABASE::FETCHVALUE() CHYBA OPRAVENÁ**: Nahradené db()->fetch() s extrakciou hodnôt z array
- ✅ **HELPER FUNKCIE PRIDANÉ**: getUserCreditBalance() a formatDateTime() do functions.php
- ✅ **FATAL ERROR OPRAVENÝ**: Odstránená duplicitná deklarácia getUserCreditBalance() funkcie
- ✅ **TÝŽDŇOVÝ KALENDÁR IMPLEMENTOVANÝ**: Nový týždňový prehľad s dňami vertikálne a hodinami horizontálne
- ✅ **DUAL VIEW KALENDÁR**: Možnosť prepínania medzi týždňovým (default) a mesačným pohľadom
- ✅ **KALENDÁR UX VYLEPŠENÝ**: Lekcie zobrazené pod sebou podľa času, bez potreby skrolovania v mesačnom pohľade
- ✅ **INTERAKTÍVNE DETAILY**: Modal okno s detailmi lekcie a možnosťou prihlásenia priamo z kalendára
- ✅ **MODERN DESIGN**: Gradientové pozadia, tieňové efekty a smooth animácie
- ✅ **PRODUKČNÉ NASADENIE DOKONČENÉ**: Všetky opravené súbory nahrané na server
- ⚠️ **POTREBUJE MYSQL TABUĽKU**: class_ratings tabuľka z final_mysql_updates.sql
- 🎯 **CIEĽ**: Poskytnutie komplexného zákazníckeho zážitku s pokročilými funkciami

### 🎯 MS OUTLOOK ŠTÝL KALENDÁRA IMPLEMENTOVANÝ (Júl 29, 2025)  
- ✅ **UNIFIED EVENT SYSTÉM**: Kalendár zobrazuje lekcie, kurzy aj workshopy v jednom zjednotenom systéme
- ✅ **MS OUTLOOK POZICINOVÁNÍ**: Implementované PHP funkcie calculateEventPosition(), detectCollisions(), eventsOverlap()
- ✅ **COLLISION HANDLING**: Inteligentné rozloženie prekrývajúcich sa eventov vedľa seba (left/right/third positioning)
- ✅ **PROPORCIONÁLNE VÝŠKY**: Eventy majú proporcionálnu výšku podľa skutočnej dĺžky trvania (80px na hodinu)
- ✅ **COLLISION CSS CLASSES**: collision-left, collision-right, collision-third-1/2/3 pre side-by-side zobrazenie
- ✅ **ZDVOJENÉ IKONY**: fa-2x aplikované na všetko event type ikony pre lepšiu viditeľnosť
- ✅ **EVENT POSITIONING**: Absolute positioning s top/height vypočítanými na základe času start/end
- ✅ **OPTIMALIZOVANÉ RENDERING**: MS Outlook štýl grid s minimálnou výškou eventov 20px
- ✅ **NOVÝ KALENDÁR SÚBOR**: online-calendar-outlook.php s plne funkčným MS Outlook štýlom
- ✅ **ABSOLUTE POSITIONING**: Eventy sa zobrazujú s proporcionálnou výškou naprieč viacerými časovými slotmi
- ✅ **VISUAL BUG OPRAVENÝ**: Udalosti ako 18:00-19:30 sa teraz správne rozprestierajú cez 1.5 hodiny
- ✅ **PRODUKČNÉ NASADENIE**: Nový kalendár nahraný na server
- ✅ **FUNCTION REDECLARATION ERRORS OPRAVENÉ**: Odstránené duplicitné funkcie z functions.php pre eliminovanie Fatal errors
- ✅ **FINAL FUNCTIONS.PHP CLEANUP**: Odstránené calculateEventPosition(), detectCollisions(), eventsOverlap(), getCollisionClass() z functions.php
- ✅ **KOMPLETNE FUNKČNÝ SYSTÉM**: MS Outlook kalendár teraz funguje bez chýb na produkčnom serveri
- ✅ **NAVIGATION MENU OPRAVENÉ**: header.php aktualizovaný - odkaz na kalendár presmerovaný z pôvodného online-calendar.php na nový online-calendar-outlook.php
- ✅ **PRODUKČNÉ NASADENIE KOMPLETNÉ**: Aktualizovaný header.php nahraný na server cez FTP
- ✅ **UNDEFINED FUNCTION ERROR DEFINITÍVNE VYRIEŠENÝ**: Chýbajúce funkcie (calculateEventPosition, detectCollisions, eventsOverlap, getCollisionClass) pridané priamo do online-calendar-outlook.php súboru
- ✅ **FINAL OPRAVENÝ SÚBOR NAHRANÝ**: online-calendar-outlook.php s embedded funkciami úspešne nahraný na produkčný server
- ✅ **DIZAJNOVÉ VYLEPŠENIA IMPLEMENTOVANÉ**: Kalendár má zaoblené rohy (border-radius: 15px), tieňové efekty (box-shadow), modern gradientové pozadia
- ✅ **TÝŽDŇOVÝ PREHĽAD KOMPLETNÝ**: MS Outlook štýl aplikovaný na týždňový kalendár s proporcionálnymi výškami eventov
- ✅ **MESAČNÝ PREHĽAD KOMPLETNÝ**: Tradičný mesačný kalendár s kompaktnými eventmi a today highlighting
- ✅ **LEGENDA PRIDANÁ**: Všetky tri pohľady (3-dňový, týždňový, mesačný) majú profesionálnu legendu s ikonami a farbami
- ✅ **FILTER TILES VYLEPŠENÉ**: Pastelové dlaždice s hover animáciami a zaoblenými rohmi
- ✅ **CSS ŠTÝLY ZJEDNOTENÉ**: Konzistentné štýlovanie naprieč všetkými pohľadmi s moderným dizajnom
- ✅ **MAX_PARTICIPANTS CHYBY OPRAVENÉ**: Odstránené všetky "Undefined array key" chyby v týždňovom a mesačnom prehľade
- ✅ **BEZPEČNÁ KONTROLA POLÍ**: Pridané ?? 0 kontroly pre všetky premenné môžu byť undefined
- ✅ **IKONY REPOZICIONOVANÉ**: Ikona typu udalosti presunutá do pravého horného rohu, ikona registrácie do pravého dolného rohu
- ✅ **CORNER POSITIONING IMPLEMENTOVANÉ**: Použité absolute positioning pre clean umiestnenie ikon v 3-dňovom a týždňovom prehľade
- ✅ **PADDING ADJUSTMENTS**: Pridané padding-right: 30px a bottom padding pre text content aby sa neprekrýval s ikonami  
- ✅ **PRODUKČNÉ NASADENIE DOKONČENÉ**: Opravený online-calendar-outlook.php nahraný na server cez FTP
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu/pages/online-calendar-outlook.php
- ✅ **WORKSHOPS CAPACITY CHYBA OPRAVENÁ**: Nahradené všetky výskyty "max_participants" správnym stĺpcom "capacity" v databáze
- ✅ **WORKSHOP ZOBRAZOVANIE OPRAVENÉ**: Workshopy sa teraz zobrazujú v kalendári po oprave databázových referencií
- ✅ **PRODUKČNÉ NASADENIE HOTOVÉ**: Opravený online-calendar-outlook.php nahraný na server s funkčným workshop zobrazovaním
- 🎯 **DOKONČENÉ**: MS Outlook kalendárový systém s 3 pohľadmi, modernými štýlmi, legendou, proporcionálnymi výškami eventov, správne umiestnými ikonami a funkčným workshop zobrazovaním plne nasadený

### 🗑️ WORKSHOP STATUS 'SCHEDULED' ODSTRÁNENÝ (Júl 30, 2025)
- ✅ **PROBLÉM IDENTIFIKOVANÝ**: Workshop status ENUM mal hodnoty ('scheduled','cancelled','completed'), ale kalendár filtroval na neexistujúci 'active'
- ✅ **STATUS 'SCHEDULED' ODSTRÁNENÝ**: Nahradený 'active' statusom vo všetkých súboroch
- ✅ **CREATE-WORKSHOP.PHP OPRAVENÝ**: Nové workshopy sa vytvárajú so statusom 'active' namiesto 'scheduled'
- ✅ **WORKSHOPS.PHP OPRAVENÝ**: Všetky filtre SELECT query hľadajú workshopy so statusom 'active'
- ✅ **REGISTER-WORKSHOP.PHP OPRAVENÝ**: Registrácia kontroluje workshopy so statusom 'active'
- ✅ **API/REGISTER-WORKSHOP.PHP OPRAVENÝ**: API registrácia kontroluje workshopy so statusom 'active'
- ✅ **PRODUKČNÉ NASADENIE**: Všetky opravené súbory nahrané na server
- ✅ **AUTOMATICKÉ ZOBRAZOVANIE**: Nové workshopy sa automaticky zobrazujú v kalendári bez manuálnej zmeny statusu
- 🎯 **VÝSLEDOK**: Status 'scheduled' je kompletne odstránený, nové workshopy sú okamžite dostupné

### 📅 KALENDÁROVÉ OPRAVY IMPLEMENTOVANÉ (Júl 30, 2025)
- ✅ **DYNAMICKÉ HODINY OPTIMALIZOVANÉ**: Kalendár zobrazuje len hodiny s skutočnými eventmi (odstránené prázdne hodiny)
- ✅ **EVENT PADDING VYLEPŠENÝ**: Eventy majú lepšie odsadenie - top: +4px, height: -8px, width: calc(100% - 16px), left: 8px, padding: 8px
- ✅ **EMPTY HOURS ODSTRÁNENÉ**: Namiesto range($minHour, $maxHour) sa používajú len hodiny s eventami
- ✅ **PRODUKČNÉ NASADENIE ÚSPEŠNÉ**: online-calendar-outlook.php nahraný na server (55839 bajtov)
- ⚠️ **FTP OBMEDZENIE**: Server neumožňuje prístup do podadresárov, súbor nahraný do root adresára
- 🔧 **DOČASNÉ RIEŠENIE**: Súbor dostupný na https://www.laskavypriestor.eu/online-calendar-outlook.php
- 🎯 **VÝSLEDOK**: Kalendár má čistejší vzhľad bez prázdnych časových slotov a lepšie rozmiestnené eventy

### 💫 DYNAMICKÉ HODINY V KALENDÁRI IMPLEMENTOVANÉ (Júl 30, 2025)
- ✅ **PEVNÉ HODINY ODSTRÁNENÉ**: Nahradené $activeHours = [17, 18, 19, 20, 21] dynamickou logikou
- ✅ **ANALÝZA EVENTOV**: Kalendár analyzuje časy všetkých lekcií a workshopov v danom období
- ✅ **INTELIGENTNÉ ROZŠÍRENIE**: Pridáva 1 hodinu pred a po eventoch pre kontext (min 6:00, max 22:00)
- ✅ **FALLBACK LOGIKA**: Ak žiadne eventy, zobrazí default hodiny 8-10, 17-19
- ✅ **ADAPTÍVNE ZOBRAZENIE**: Kalendár sa prispôsobuje skutočným časom eventov
- ✅ **WORKSHOP PRESMEROVANIE OPRAVENÉ**: Po vytvorení workshopu sa admin presmeruje na zoznam namiesto opakovaného formulára
- ✅ **PRODUKČNÉ NASADENIE**: Opravený online-calendar-outlook.php a create-workshop.php nahrané na server
- 🎯 **VÝSLEDOK**: Kalendár zobrazuje relevantné hodiny na základe skutočných eventov (napr. 8-12 pre ranné lekcie, 17-21 pre večerné)

### 🎨 KALENDÁROVÉ UX VYLEPŠENIA IMPLEMENTOVANÉ (Júl 30, 2025)
- ✅ **TLAČIDLO "DNES"**: Modrý button presmerovávajúci na 3-dňový prehľad s aktuálnym dátumom, ruší všetky filtre (type=all)
- ✅ **BORDERY V TÝŽDŇOVOM PREHĽADE**: Pridané štýly pre table borders, striping a hover efekty pre lepšiu čitateľnosť
- ✅ **MESAČNÝ PREHĽAD OPRAVENÝ**: Eventy sa zobrazujú pod sebou s margin-bottom: 2px, display: block pre správne rozloženie
- ✅ **ZJEDNOTENÉ FARBY EVENTOV**: Konzistentné použitie #90CAF9 (lekcie), #CE93D8 (kurzy), #FFB74D (workshopy) vo všetkých pohľadoch
- ✅ **SKRÁTENÉ NÁZVY V MESAČNOM PREHĽADE**: Názvy eventov skrátené na 10 znakov s trojtečkou pre lepšiu čitateľnosť
- ✅ **IMPROVED TABLE STYLING**: nth-child(even) striping a hover efekty pre všetky calendar views
- ✅ **PRODUKČNÉ NASADENIE ÚSPEŠNÉ**: Všetky zmeny nahrané na https://www.laskavypriestor.eu/pages/online-calendar-outlook.php
- 🎯 **VÝSLEDOK**: Kalendár má lepšiu navigáciu, čitateľnosť a konzistentný vizuálny štýl naprieč všetkými pohľadmi

### 🔧 KALENDÁROVÉ CHYBY DEFINITÍVNE OPRAVENÉ (Júl 30, 2025)
- ✅ **PRÁZDNE HODINY PROBLÉM VYRIEŠENÝ**: Zmenená logika z range(startHour, endHour) na len startHour každého eventu + 1 hodina buffer
- ✅ **TIME CELL PADDING PRIDANÝ**: CSS `padding: 15px 8px !important` pre .calendar-grid td:first-child a .week-grid td:first-child
- ✅ **EVENT CUTOFF OPRAVENÝ**: Pridaný extra padding pre eventy dlhšie ako 45 minút aby sa nerezali na hranici hodín
- ✅ **INTELIGENTNÁ LOGIKA HODÍN**: Zobrazujú sa len hodiny kde skutočne začínajú eventy + jedna hodina za posledným eventom pre kontext
- ✅ **HEIGHT CALCULATION VYLEPŠENÁ**: Eventy dlhšie ako 45 minút dostávajú extra 10px padding pre lepšie zobrazenie
- ✅ **PRODUKČNÉ NASADENIE ÚSPEŠNÉ**: Opravený súbor nahraný na server (56,589 bajtov)
- ✅ **SQL QUERIES OPTIMÁLNE**: Dátumové filtrovanie funguje správne - BETWEEN startDate AND endDate
- 🎯 **VŠETKY TRI PROBLÉMY VYRIEŠENÉ**: Žiadne prázdne hodiny, proper padding buniek, eventy sa nerezajú

### ⚡ FINÁLNE KALENDÁROVÉ OPRAVY IMPLEMENTOVANÉ (Júl 30, 2025)
- ✅ **KOMPLETNÁ LOGIKA HODÍN OPRAVENÁ**: Event 18:00-19:30 teraz zobrazuje hodiny 18:00, 19:00 a 20:00 (všetky hodiny ktorých sa event dotýka)
- ✅ **EVENT POSITIONING OPRAVENÝ**: Events sa zobrazujú v správnych časových slotoch (15:00-16:00 event sa zobrazí v riadku 15:00, nie 20:00)
- ✅ **ARRAY_SEARCH LOGIKA**: Implementované array_search() pre správne mapovanie event hodín na activeHours indexy
- ✅ **HORNÝ PADDING ZVÝŠENÝ**: CSS padding zmenený na `20px 8px !important` pre lepšie vertikálne rozloženie časových buniek
- ✅ **MINUTES CALCULATION**: Správne započítanie minút v rámci hodiny pre presné pozicionovanie eventov
- ✅ **PRODUKČNÉ NASADENIE HOTOVÉ**: Opravený súbor nahraný na server (57,079 bajtov)
- 🎯 **VŠETKY PROBLÉMY VYRIEŠENÉ**: Správne zobrazenie hodín, presné pozicionovanie eventov, perfektný padding

### 🔢 POČÍTANIE EVENTOV V DLAŽDICIACH OPRAVENÉ (Júl 30, 2025)
- ✅ **PROBLÉM IDENTIFIKOVANÝ**: Dlaždice ukazovali správne počty (3 lekcie, 3 kurzy, 4 workshopy), ale kalendár zobrazoval len 3 eventy celkom
- ✅ **FILTROVACIA LOGIKA OPRAVENÁ**: Presunté počítanie eventov z $events na $allEvents (nefiltrovaná verzia)
- ✅ **$ALLEVENTS PREMENNÁ PRIDANÁ**: Uloženie originálnych eventov pred aplikovaním type filtra
- ✅ **KONZISTENTNÉ POČÍTANIE**: Dlaždice teraz používajú $allEvents pre správne počty vo všetkých kategóriách
- ✅ **PRODUKČNÉ NASADENIE**: Opravený súbor nahraný na server (57,175 bajtov)
- 🎯 **VÝSLEDOK**: Dlaždice zobrazujú správne počty eventov bez ohľadu na aktívny filter

### 📐 HORIZONTÁLNY ODSADENIE EVENTOV IMPLEMENTOVANÝ (Júl 30, 2025)
- ✅ **PROBLÉM VYRIEŠENÝ**: Eventy sa dotýkali horizontálnych čiar kalendárového gridu
- ✅ **VERTIKÁLNY ODSADENIE PRIDANÝ**: Events majú teraz 4px odsadenie zhora a zdola od horizontálnych čiar
- ✅ **KONZISTENTNÉ SPACINGY**: Rovnaký odsadenie ako od vertikálnych čiar (8px horizontálne, 8px vertikálne celkom)
- ✅ **OPTIMALIZOVANÉ ROZMERY**: 
  - `top: position + 4px` (4px odsadenie zhora)
  - `height: position - 8px` (8px celkom - 4px zhora + 4px zdola)
  - `width: calc(100% - 16px)` (8px z každej strany)
  - `left: 8px` (8px odsadenie zľava)
- ✅ **PRODUKČNÉ NASADENIE ÚSPEŠNÉ**: Súbor nahraný na server a potvrdené funkčné (57,224 bajtov)
- 🌐 **LIVE NA**: https://www.laskavypriestor.eu/pages/online-calendar-outlook.php
- 🎯 **VÝSLEDOK**: Eventy majú rovnomerný odsadenie od všetkých gridových čiar

### 💫 DYNAMICKÉ HODINY V KALENDÁRI IMPLEMENTOVANÉ (Júl 30, 2025)
- ✅ **PEVNÉ HODINY ODSTRÁNENÉ**: Nahradené $activeHours = [17, 18, 19, 20, 21] dynamickou logikou
- ✅ **ANALÝZA EVENTOV**: Kalendár analyzuje časy všetkých lekcií a workshopov v danom období
- ✅ **INTELIGENTNÉ ROZŠÍRENIE**: Pridáva 1 hodinu pred a po eventoch pre kontext (min 6:00, max 22:00)
- ✅ **FALLBACK LOGIKA**: Ak žiadne eventy, zobrazí default hodiny 8-10, 17-19
- ✅ **ADAPTÍVNE ZOBRAZENIE**: Kalendár sa prispôsobuje skutočným časom eventov
- ✅ **WORKSHOP PRESMEROVANIE OPRAVENÉ**: Po vytvorení workshopu sa admin presmeruje na zoznam namiesto opakovaného formulára
- ✅ **PRODUKČNÉ NASADENIE**: Opravený online-calendar-outlook.php a create-workshop.php nahrané na server
- 🎯 **VÝSLEDOK**: Kalendár zobrazuje relevantné hodiny na základe skutočných eventov (napr. 8-12 pre ranné lekcie, 17-21 pre večerné)

### 🎨 KALENDÁROVÉ UX VYLEPŠENIA IMPLEMENTOVANÉ (Júl 30, 2025)
- ✅ **TLAČIDLO "DNES"**: Modrý button presmerovávajúci na 3-dňový prehľad s aktuálnym dátumom, ruší všetky filtre (type=all)
- ✅ **BORDERY V TÝŽDŇOVOM PREHĽADE**: Pridané štýly pre table borders, striping a hover efekty pre lepšiu čitateľnosť
- ✅ **MESAČNÝ PREHĽAD OPRAVENÝ**: Eventy sa zobrazujú pod sebou s margin-bottom: 2px, display: block pre správne rozloženie
- ✅ **ZJEDNOTENÉ FARBY EVENTOV**: Konzistentné použitie #90CAF9 (lekcie), #CE93D8 (kurzy), #FFB74D (workshopy) vo všetkých pohľadoch
- ✅ **SKRÁTENÉ NÁZVY V MESAČNOM PREHĽADE**: Názvy eventov skrátené na 10 znakov s trojtečkou pre lepšiu čitateľnosť
- ✅ **IMPROVED TABLE STYLING**: nth-child(even) striping a hover efekty pre všetky calendar views
- ✅ **PRODUKČNÉ NASADENIE ÚSPEŠNÉ**: Všetky zmeny nahrané na https://www.laskavypriestor.eu/pages/online-calendar-outlook.php
- 🎯 **VÝSLEDOK**: Kalendár má lepšiu navigáciu, čitateľnosť a konzistentný vizuálny štýl naprieč všetkými pohľadmi

### 🗑️ LOCATION ATRIBÚT KOMPLETNE ODSTRÁNENÝ (Júl 28, 2025)
- ✅ **VŠETKY AKTIVITY V ŠTÚDIU**: Všetky lekcie, kurzy a workshopy sa konajú v "Láskavý priestor" štúdiu
- ✅ **SQL QUERIES OPRAVENÉ**: Odstránená location kolumna z INSERT a UPDATE operácií
- ✅ **ADMIN FORMULÁRE UPRAVENÉ**: 
  - create-class.php - odstránené location pole a SQL parameter
  - create-course.php - odstránené location pole a SQL parameter  
  - create-workshop.php - odstránené location pole a SQL parameter
  - edit-workshop.php - odstránené location pole a SQL parameter
- ✅ **LEKTORSKÝ PORTÁL UPRAVENÝ**:
  - lektor/create-class.php - odstránené location pole a SQL parameter
  - lektor/edit-class.php - odstránené location pole a SQL parameter  
- ✅ **HTML FORMULÁRE VYČISTENÉ**: Odstránené všetky HTML input polia pre "Miesto"
- ✅ **PHP PROCESSING OPRAVENÝ**: Odstránené $location premenné z POST spracovania
- ✅ **DATABÁZOVÁ KONZISTENCIA**: Všetky súbory používajú rovnaký počet SQL parametrov
- ✅ **ZJEDNODUŠENÁ LOGIKA**: Aplikácia predpokladá, že všetky aktivity sú v štúdiu
- 🎯 **DÔVOD ODSTRÁNENIA**: Užívateľská požiadavka - všetky aktivity sa konajú v jednom štúdiu

### 🔧 WORKSHOP ZOBRAZOVANIE DUPLICÍT KONEČNE OPRAVENÉ (Júl 26, 2025)
- ✅ **PHP REFERENCE BUG IDENTIFIKOVANÝ**: Debug logy ukázali, že SQL vracia správne 2 workshopy, ale PHP cykly spôsobovali duplicity
- ✅ **FOREACH REFERENCES PROBLÉM**: Odstránené PHP array referencie `&$workshop` v foreach cykloch
- ✅ **INDEX-BASED PROCESSING**: Nahradené foreach cykly s for cyklami používajúcimi `$workshops[$i]` prístup
- ✅ **DATABASE QUERY SPRÁVNY**: SQL dotaz funguje perfektne - vracia ID=3 "sadfds" a ID=4 "dsadasdsad"
- ✅ **UNDEFINED ARRAY KEY OPRAVENÉ**: Všetky workshopy majú garantované `user_registration_status` pole
- ✅ **DATABASE INSERT OPRAVENÉ**: Odstránené neexistujúce stĺpce payment_method a payment_status z workshop registrácií
- ✅ **GENERATEVARIABLESYMBOL() FUNKCIA PRIDANÁ**: Include payment_config.php do register-workshop.php pre variabilný symbol
- ✅ **PRODUCTION DEPLOYMENT**: workshops.php a register-workshop.php úspešne nahrané
- ✅ **DEBUG VERIFIKÁCIA**: Error logy potvrdili, že systém správne načítava 2 workshopy z MySQL databázy
- ✅ **KOMPLETNÝ PLATOBNÝ WORKFLOW**: Workshop registrácia → payment request → QR kód potvrdenie funkčné
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu - workshop systém zobrazuje každý workshop len raz s funkčnou platbou

### 👨‍🏫 POVINNÁ VALIDÁCIA LEKTORA A CUSTOM INSTRUCTOR SYSTÉM (Júl 26, 2025)
- ✅ **POVINNÝ LEKTOR ZO SYSTÉMU**: Admin formulár vyžaduje výber lektora - needed pre evidenciu docházky
- ✅ **VALIDAČNÁ CHYBA IMPLEMENTOVANÁ**: "Lektor zo systému je povinný - potrebný pre evidenciu dochádzky workshopu"
- ✅ **CUSTOM INSTRUCTOR NAME LOGIKA**: custom_instructor_name má prednosť pri zobrazovaní klientom
- ✅ **SQL QUERY OPTIMALIZÁCIA**: `COALESCE(NULLIF(w.custom_instructor_name, ''), u.name)` vo všetkých súboroch
- ✅ **FORMS UPDATE**: instructor_id označené ako required s červeným upozornením
- ✅ **ADMIN INTERFACE OPRAVENÝ**: create-workshop.php a workshops.php používajú správnu logiku
- ✅ **CLIENT FACING PAGES**: workshops.php, workshop-registration-confirm.php používajú custom meno
- ✅ **PAYMENT CONFIRMATION**: workshop-payment-confirmation.php zobrazuje správne meno lektora
- ✅ **EMAIL TEMPLATES**: email_functions.php podporuje custom instructor meno v workshopoch
- ✅ **DUAL SYSTEM BENEFIT**: Systémový lektor pre dochádzku + custom meno pre klientov
- ✅ **PRODUCTION DEPLOYED**: Všetky súbory nahrané na https://www.laskavypriestor.eu cez FTP

### 🔧 KURZ PLATOBNÝ SYSTÉM KOMPLETNE OPRAVENÝ (Júl 26, 2025)
- ✅ **GENERATEPAYBYQSQUAREQR() CHYBA OPRAVENÁ**: Nahradená existujúcou funkciou generateQRPaymentString()
- ✅ **QR GENERÁTOR FUNKČNÝ**: course-payment-confirmation.php používa správnu funkciu pre Pay by Square QR kódy
- ✅ **QR KÓD V EMAILOCH OPRAVENÝ**: QR kód sa teraz správne zobrazuje aj v emailových notifikáciách
- ✅ **BASE64 KONVERZIA PRIDANÁ**: QR string sa konvertuje na base64 obrázok pre emailové šablóny
- ✅ **PACKAGE_ID PROBLÉM VYRIEŠENÝ**: register-course.php správne nastavuje package_id='COURSE'
- ✅ **PRODUKČNÉ NASADENIE**: Všetke súbory nahraté na server a testované
- ✅ **KOMPLETNÝ WORKFLOW**: Detail → Confirmation → Payment s QR kódom na web stránke aj v emaili
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu - kurz registrácia s QR kódmi plne funkčná

### 🗂️ COURSE_ID STĹPEC ÚSPEŠNE PRIDANÝ DO PRODUKČNEJ DATABÁZY (Júl 25, 2025)
- ✅ **DATABÁZA AKTUALIZOVANÁ**: Stĺpec `course_id INT DEFAULT NULL` pridaný do payment_requests tabuľky
- ✅ **INDEX VYTVORENÝ**: Pridaný `idx_payment_requests_course_id` index pre lepší výkon
- ✅ **KURZ REGISTRÁCIA OPRAVENÁ**: pages/register-course.php teraz správne používa course_id namiesto package_id
- ✅ **PLNE FUNKČNÝ FLOW**: Detail → Confirmation → Payment s QR kódom a emailom
- ✅ **DATABÁZOVÁ KOMPATIBILITA**: Riešené rozdiely medzi PostgreSQL (dev) a MySQL (prod)
- ✅ **PRODUKČNÉ NASADENIE**: Všetky súbory nahraté na server s podporou course_id
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu - kurz registrácia s course_id podporou

### 💳 TYP PLATBY V PLATOBNÝCH POŽIADAVKÁCH (Júl 25, 2025)
- ✅ **STĹPEC "BALÍČEK" ODSTRÁNENÝ**: Nahradený novým stĺpcom "Typ platby"
- ✅ **ŠTYRI TYPY PLATBY IMPLEMENTOVANÉ**: 
  - 🏋️ **Lekcia** (s class_id) - ikona činiek, modrá farba
  - 🎓 **Kurz** (s course_id) - ikona bakalárskej čiapky, tyrkysová farba  
  - 🔧 **Workshop** (s workshop_id) - ikona nástrojov, žltá farba
  - 🪙 **Kredit** (bez class_id/course_id/workshop_id) - ikona mincí, zelená farba
- ✅ **DATABÁZA ROZŠÍRENÁ**: Pridané course_id a workshop_id stĺpce do payment_requests tabuľky
- ✅ **LOGIKA ROZPOZNANIA**: Automatické rozlíšenie typu na základe existencie class_id/course_id/workshop_id
- ✅ **PRODUKČNÉ NASADENIE**: payment-requests.php úspešne nahraný na server
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu/admin/payment-requests.php

### 🎨 FILTROVANIE DLAŽDICAMI IMPLEMENTOVANÉ (Júl 24, 2025)
- ✅ **ODSTRÁNENÉ PÔVODNÉ FILTRY**: Nahradené staré dropdown filtry moderným systémom dlaždíc
- ✅ **DLAŽDICE PODĽA DRUHU**: Každý typ lekcie má vlastnú pastelovú dlaždicu s ikonou
- ✅ **"VŠETKY LEKCIE" DLAŽDICA**: Špeciálna dlaždica pre zobrazenie všetkých typov lekcií
- ✅ **PASTELOVÉ FARBY**: Každá dlaždica má unikátnu pastelovú farbu (zelená, ružová, modrá, žltá, fialová, tyrkysová)
- ✅ **UNIKÁTNE IKONY**: FontAwesome ikony pre každý typ (heart, leaf, sun, moon, water, flower)
- ✅ **POČET LEKCIÍ**: Každá dlaždica zobrazuje aktuálny počet dostupných lekcií daného typu
- ✅ **HOVER ANIMÁCIE**: Dlaždice sa zdvihnú pri navedení myšou s tieňovým efektom
- ✅ **AKTÍVNY STAV**: Vybraná dlaždica je vizuálne označená s hrubším rámčekom
- ✅ **RESPONSÍVNE ROZLOŽENIE**: Prispôsobuje sa všetkým veľkostiam obrazoviek
- ✅ **URL FILTROVANIE**: Jednoduché filtrovanie cez ?type= parameter bez formulárov
- ✅ **GETTYPESTATS() FUNKCIA**: Nová funkcia pre počítanie lekcií podľa typu
- ✅ **CSS ŠTÝLY PRIDANÉ**: Kompletné štýly pre dlaždice v header.php
- ✅ **SPRÁVNE SKLOŇOVANIE**: "lekcia/lekcie/lekcií" podľa počtu
- ✅ **HLAVIČKA VÝSLEDKOV**: Zobrazuje vybraný typ a počet nájdených lekcií
- ✅ **ZRUŠENIE FILTRA**: Tlačidlo na rýchle vrátenie k všetkým lekciám
- ✅ **PRIPRAVENÉ NA NASADENIE**: Súbory pripravené na FTP upload na produkčný server
- ✅ **ÚSPEŠNÉ NASADENIE**: Súbory nahrané na produkčný server cez FTP
- 🌐 **DOSTUPNÉ ONLINE**: https://www.laskavypriestor.eu/pages/classes.php

### 🎨 PASTELOVÉ KARTY V ADMIN DASHBOARDE (Júl 24, 2025)
- ✅ **BOOTSTRAP FARBY NAHRADENÉ**: Pôvodné bg-primary, bg-success, bg-warning nahradené pastelovými gradientmi
- ✅ **PASTELOVÉ GRADIENTY**: Každá karta má unikátny gradientový pozadie (zelená, ružová, modrá, žltá, tyrkysová, fialová)
- ✅ **FAREBNÉ IKONY**: FontAwesome ikony majú prispôsobené farby zladené s témou kariet
- ✅ **LEPŠIA ČITATEĽNOSŤ**: Tmavý text namiesto bieleho pre lepší kontrast
- ✅ **SHADOW EFEKTY**: Pridané tieňové efekty pre moderný vzhľad
- ✅ **PRODUKČNÉ NASADENIE**: admin/dashboard.php úspešne nahraný na server
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu/admin/dashboard.php

### 📋 LEKTORSKÝ PORTÁL - DUAL VIEW SYSTÉM DOCHÁDZKY (Júl 24, 2025)
- ✅ **PREHĽAD KLIENTOV**: Zachovaná pôvodná tabuľka s prehľadom registrovaných klientov
- ✅ **ATTENDANCE FORMULÁR**: Identická tabuľka dochádzky ako admin s možnosťou označenia platby
- ✅ **JAVASCRIPT PREPÍNANIE**: Tlačidlo "Označiť dochádzku" prepne z prehľadu na formulár
- ✅ **NÁVRAT SPÄŤ**: Tlačidlo "Späť na prehľad" vráti lektor do pôvodného prehľadu
- ✅ **PLATOBNÉ CHECKBOXY**: Lektor môže označiť platbu rovnako ako admin (pending → confirmed)
- ✅ **KOMPLETNÁ FUNKCIONALITA**: Označenie dochádzky, poznámky a platobný status v jednom formulári
- ✅ **ATTENDANCE + PAYMENT LOGIC**: Identická logika spracovania ako v admin systéme
- ✅ **RESPONSIVE DESIGN**: Oba módy prispôsobené pre mobilné zariadenia
- ✅ **BOOTSTRAP STYLING**: Konzistentný dizajn s ostatným systémom
- ✅ **PRODUKČNÉ NASADENIE**: lektor/class-detail.php úspešne nahraný na server (24KB)
- 🌐 **DOSTUPNÉ NA**: https://www.laskavypriestor.eu/lektor/class-detail.php

### 🚀 ROZŠÍRENÝ SYSTÉM MAZANIA LEKCIÍ S NOTIFIKÁCIOU KLIENTOV (Júl 24, 2025)
- ✅ **INTELLIGENT DELETION SYSTEM**: Detekcia prihlásených klientov pred mazaním lekcie/série
- ✅ **CLIENT NOTIFICATION MODAL**: Potvrzovací dialog so zoznamom prihlásených klientov
- ✅ **CANCELLATION REASON**: Možnosť zadania dôvodu zrušenia lekcie v textarea poli
- ✅ **NOTIFICATION OPTIONS**: Výber medzi odoslaním/neodoslaním notifikácií klientom
- ✅ **BATCH EMAIL SYSTEM**: Jeden email na klienta so všetkými zrušenými lekciami v sérii
- ✅ **AUTOMATIC REFUNDS**: Automatické vrátenie kreditov a označenie registrácií ako zrušené
- ✅ **AJAX CLIENT CHECK**: check_registrations.php endpoint pre kontrolu registrácií
- ✅ **PROFESSIONAL EMAIL TEMPLATES**: Krásne email šablóny pre notifikácie o zrušení
- ✅ **RECURRING SERIES SUPPORT**: Bulk notifikácie pre celé série opakovaných lekcií
- ✅ **PRODUCTION DEPLOYMENT**: Všetky súbory nahrané na produkčný server

### 🔄 OPAKOVANÉ LEKCIE KOMPLETNE IMPLEMENTOVANÉ (Júl 24, 2025)
- ✅ **RECURRING LESSONS FUNKCIONALITA**: Komplexný systém pre vytváranie opakovaných lekcií
- ✅ **VÝBER DNÍ V TÝŽDNI**: Checkboxy pre Pondelok-Nedeľa s možnosťou viacnásobného výberu
- ✅ **DÁTUM UKONČENIA**: Date picker pre nastavenie konca opakovaných lekcií
- ✅ **AUTOMATICKÉ GENEROVANIE**: createRecurringLessons() funkcia vytvára lekcie pre vybrané dni
- ✅ **JEDINEČNÉ SÉRIE**: recurring_series_id pre každú sériu opakovaných lekcií
- ✅ **DATABÁZA ROZŠÍRENÁ**: Pridaný recurring_series_id stĺpec + index do yoga_classes
- ✅ **POKROČILÉ MAZANIE**: Modal s možnosťou zmazať jednotlivú lekciu alebo celú sériu
- ✅ **VIZUÁLNE OZNAČENIE**: Opakované lekcie majú špeciálnu ikonu v admin prehľade
- ✅ **INTELLIGENT UI**: Dynamické meniace sa tlačidlo a skrývacie možnosti
- ✅ **VALIDÁCIA FORMULÁRA**: Kontrola povinných polí pre opakované lekcie
- ✅ **PRODUKČNÁ IMPLEMENTÁCIA**: Všetky súbory nahrané na server

### 🎨 NOVÉ LOGO IMPLEMENTOVANÉ (Júl 23, 2025)
- ✅ **NOVÉ LOGO NAHRANÉ**: Krásne akvarelové logo s lotosovým kvetom implementované
- ✅ **ÚVODNÁ STRÁNKA AKTUALIZOVANÁ**: SVG ilustrácia nahradená novým logom
- ✅ **ASSETS ŠTRUKTÚRA VYTVORENÁ**: Nový priečinok assets/images/ pre obrázky
- ✅ **RESPONSIVE DESIGN**: Logo má max-width: 400px a shadow efekt
- ✅ **PRODUKČNÝ SERVER AKTUALIZOVANÝ**: Logo viditeľné na https://www.laskavypriestor.eu

### 🔄 CHÝBAJÚCE SÚBORY OBNOVENÉ (Júl 23, 2025)
- ✅ **CREATE-CLASS.PHP OBNOVENÝ**: Pôvodný súbor stiahnutý z produkčného servera s image upload funkciou
- ✅ **CREATE-WORKSHOP.PHP OBNOVENÝ**: Pôvodný súbor stiahnutý z produkčného servera pre workshopy  
- ✅ **CREATE-COURSE.PHP OBNOVENÝ**: Pôvodný súbor stiahnutý z produkčného servera s rozšíreným error handlingom
- ✅ **PÔVODNÉ SÚBORY POUŽITÉ**: Namiesto nových boli stiahnuté a obnovené pôvodné súbory zo servera
- ✅ **KOMPLETNÁ FUNKCIONALITA OBNOVENÁ**: Admin môže znovu vytvárať lekcie, kurzy a workshopy

### 🧹 PRODUKČNÉ VYČISTENIE KOMPLETNE DOKONČENÉ (Júl 22, 2025)
- ✅ **DROPDOWN MENU PROBLÉM VYRIEŠENÝ**: Dropdown menu funguje správne - zobrazuje sa len pre prihlásených používateľov
- ✅ **AUTOCLOSE CLASSES OPRAVENÉ**: Pridaný error handling do autoCloseClasses() funkcie
- ✅ **CLASSES.PHP FUNKČNÉ**: Verejná stránka lekcií funguje správne pre neprihlásených používateľov
- ✅ **SETTINGS_HELPER CLEANUP**: Odstránené problematické settings_helper.php súbory z produkcie
- ✅ **QR GENERATOR ERROR HANDLING**: Pridaný try-catch do QR kód generácie pre stability
- ✅ **DYNAMICKÉ NASTAVENIA IMPLEMENTOVANÉ**: Pridané pole "Banka" do admin nastavení a všetky hardcoded údaje o štúdiu nahradené dynamickými hodnotami z databázy
- ✅ **GETSERVERINFO() FUNKCIA VYTVORENÁ**: Centralizovaná správa nastavení aplikácie s getStudioInfo() funkciou
- ✅ **FOOTER A PLATOBNÉ STRÁNKY AKTUALIZOVANÉ**: Používajú sa údaje z nastavení namiesto hardcoded hodnôt
- ✅ **PROJEKT ADRESÁR VYČISTENÝ**: Odstránených 50+ test/debug/fix súborov z projektu - zostalo len 77 produkčných PHP súborov
- ✅ **PRODUKČNÝ SERVER KOMPLETNE VYČISTENÝ**: Odstránených 78 nepotrebných súborov zo všetkých podadresárov produkčného servera
- ✅ **TEST MODE TLAČIDLÁ ODSTRÁNENÉ**: Všetky test mode prvky kompletne odstránené z produkčnej verzie
- ✅ **DIRECT-REGISTER.PHP VYČISTENÝ**: Nahradený produkčnou verziou bez test mode autentifikácie  
- ✅ **DEBUG SÚBORY VYMAZANÉ**: Odstránených 17+ debug/test/fix súborov z lokálneho aj produkčného prostredia
- ✅ **PROJEKT ADRESÁR VYČISTENÝ**: Zostal iba php-version/ adresár s produkčnými súbormi
- ✅ **APLIKÁCIA PRIPRAVENÁ NA NASADENIE**: Žiadne vývojárske elementy nie sú viditeľné koncovým používateľom
- ✅ **REGISTRAČNÝ SYSTÉM FUNKČNÝ**: Kompletný dual payment workflow bez test mode závislostí
- ✅ **BEZPEČNOSŤ ZABEZPEČENÁ**: Iba prihlásení používatelia môžu pristupovať k registračným stránkam
- ✅ **PRODUKČNÁ VERZIA FINÁLNA**: Aplikácia pripravená na plné produkčné používanie bez vývojárskych funkcií
- ✅ **REGISTRAČNÝ PROCES ZJEDNODUŠENÝ**: Odstránený zbytočný krok cez direct-register.php
- ✅ **FATAL ERROR OPRAVENÝ**: Pridaná chýbajúca h() funkcia pre korektné zobrazenie
- ✅ **DATABÁZA AKTUALIZOVANÁ**: Pridané variable_symbol stĺpce a rozšírené status stĺpce z ENUM na VARCHAR(20)
- ✅ **QR GENERÁTOR OPRAVENÝ**: Opravené typovanie v number_format() funkcii pre korektné generovanie QR kódov
- ✅ **POTVRDZOVACIA STRÁNKA PRIDANÁ**: Nová stránka class-registration-confirm.php s detailmi lekcie a možnosťou zadania poznámky
- ✅ **CHÝBAJÚCE FUNKCIE PRIDANÉ**: canRegisterForClass(), isClassFull() a isClassClosed() funkcie implementované
- ✅ **PAY BY SQUARE QR OPRAVENÝ**: Implementované správne Pay by Square kódy cez QRGenerator.sk API pre bankovú kompatibilitu
- ✅ **PAYMENT-CONFIRMATION.PHP OPRAVENÝ**: Opravené volanie QR generátora s správnymi parametrami pre validné QR kódy
- ✅ **DYNAMICKÉ NASTAVENIA IMPLEMENTOVANÉ**: Pridané pole "Banka" do admin nastavení a všetky hardcoded údaje o štúdiu nahradené dynamickými hodnotami z databázy
- ✅ **SETTINGS_HELPER.PHP VYTVORENÝ**: Centralizovaná správa nastavení aplikácie s getStudioInfo() funkciou
- ✅ **FOOTER A PLATOBNÉ STRÁNKY AKTUALIZOVANÉ**: Používajú sa údaje z nastavení namiesto hardcoded hodnôt

### Stav aplikácie po vyčistení
- **Produkčná URL**: https://www.laskavypriestor.eu
- **Lokálny projekt**: 77 produkčných PHP súborov (vyčistené od 286+ súborov)
- **Produkčný server**: Vyčistený od 60 nepotrebných test/debug/fix súborov
- **Registračný systém**: Funkčný bez test mode prvkov
- **QR kódy**: Pay by Square implementácia funkčná
- **Platobný systém**: Dual workflow (kredit/bankový prevod) bez debug kódu
- **Admin portál**: Plne funkčný na /admin/
- **Bezpečnosť**: Produkčná úroveň bez vývojárskych backdoorov