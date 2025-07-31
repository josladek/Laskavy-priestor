<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

$pageTitle = 'Podmienky používania';
?>

<?php include '../includes/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-5">
                    <h1 class="mb-4">Podmienky používania</h1>
                    <p class="text-muted mb-4">Platné od: 10. júla 2025</p>
                    
                    <h2>1. Úvodné ustanovenia</h2>
                    <p>Tieto podmienky používania upravujú vzťah medzi prevádzkovateľom služby "Láskavý Priestor" a používateľmi webovej stránky a služieb.</p>
                    
                    <h2>2. Definície</h2>
                    <ul>
                        <li><strong>Prevádzkovateľ</strong> - Láskavý Priestor, s.r.o.</li>
                        <li><strong>Používateľ</strong> - fyzická osoba využívajúca naše služby</li>
                        <li><strong>Služby</strong> - jogové lekcie, kurzy a súvisiace aktivity</li>
                        <li><strong>Kredit</strong> - elektronická platobná jednotka v systéme</li>
                    </ul>
                    
                    <h2>3. Registrácia a používateľský účet</h2>
                    <h3>3.1 Registrácia</h3>
                    <p>Na využívanie služieb je potrebná registrácia s uvedením pravdivých a aktuálnych údajov.</p>
                    
                    <h3>3.2 Bezpečnosť účtu</h3>
                    <p>Používateľ je zodpovedný za bezpečnosť svojho účtu a hesla. V prípade zneužitia účtu je potrebné okamžite informovať prevádzkovateľa.</p>
                    
                    <h2>4. Kreditný systém</h2>
                    <h3>4.1 Nákup kreditov</h3>
                    <p>Kredity možno zakúpiť cez zabezpečené platobné brány. Kredity nemajú expirációu dobu.</p>
                    
                    <h3>4.2 Používanie kreditov</h3>
                    <p>Kredity možno použiť na platbu jogových lekcií a kurzov so zľavou oproti bežnej cene.</p>
                    
                    <h3>4.3 Vrátenie kreditov</h3>
                    <p>Pri zrušení registrácie najneskôr 24 hodín pred lekciou sa kredity automaticky vrátia na účet.</p>
                    
                    <h2>5. Rezervácie a zrušenia</h2>
                    <h3>5.1 Rezervácia lekcií</h3>
                    <p>Rezervácie možno vykonať online cez webovú stránku alebo aplikáciu.</p>
                    
                    <h3>5.2 Zrušenie rezervácie</h3>
                    <p>Rezervácie možno zrušiť bezplatne najneskôr 24 hodín pred začiatkom lekcie.</p>
                    
                    <h3>5.3 Neskorý príchod</h3>
                    <p>V prípade neskorého príchodu (viac ako 15 minút) si prevádzkovateľ vyhradzuje právo odmietnuť účasť na lekcii.</p>
                    
                    <h2>6. Zdravotné obmedzenia a bezpečnosť</h2>
                    <h3>6.1 Zdravotný stav</h3>
                    <p>Používateľ je povinný informovať o zdravotných problémoch, ktoré môžu ovplyvniť účasť na jogových aktivitách.</p>
                    
                    <h3>6.2 Zodpovednosť</h3>
                    <p>Účasť na lekciách je na vlastné riziko. Prevádzkovateľ nenesie zodpovednosť za úrazy vzniknuté nedodržaním pokynov inštruktora.</p>
                    
                    <h2>7. Pravidlá správania</h2>
                    <p>V priestoroch studia je potrebné:</p>
                    <ul>
                        <li>Rešpektovať ostatných účastníkov a inštruktorov</li>
                        <li>Udržiavať ticho a pokoj</li>
                        <li>Dodržiavať hygienu a nosiť vhodnú športovú výbavu</li>
                        <li>Vypnúť mobilné telefóny</li>
                    </ul>
                    
                    <h2>8. Platby</h2>
                    <h3>8.1 Platobné metódy</h3>
                    <p>Akceptujeme platby kartou, bankovým prevodom a cez kreditný systém.</p>
                    
                    <h3>8.2 Vrátenie peňazí</h3>
                    <p>Vrátenie peňazí za zakúpené kredity nie je možné, okrem prípadov stanovených zákonom.</p>
                    
                    <h2>9. Ochrana osobných údajov</h2>
                    <p>Spracovanie osobných údajov sa riadi samostatnými <a href="privacy.php">zásadami ochrany osobných údajov</a>.</p>
                    
                    <h2>10. Zodpovednosť a obmedzenia</h2>
                    <h3>10.1 Obmedzenie zodpovednosti</h3>
                    <p>Prevádzkovateľ nenesie zodpovednosť za nepriame škody vzniknuté používaním služieb.</p>
                    
                    <h3>10.2 Vyššia moc</h3>
                    <p>Prevádzkovateľ nenesie zodpovednosť za nemožnosť poskytovania služieb z dôvodu vyššej moci.</p>
                    
                    <h2>11. Zmeny podmienok</h2>
                    <p>Prevádzkovateľ si vyhradzuje právo zmeniť tieto podmienky. O zmenách budú používatelia informovaní e-mailom alebo oznámením na webovej stránke.</p>
                    
                    <h2>12. Riešenie sporov</h2>
                    <p>Spory sa budú riešiť prednostne mimosúdne. Príslušné sú súdy Slovenskej republiky.</p>
                    
                    <h2>13. Kontaktné údaje</h2>
                    <p>
                        <strong>Láskavý Priestor, s.r.o.</strong><br>
                        Email: info@laskavypriestor.eu<br>
                        Telefón: +421 123 456 789<br>
                        Adresa: Bratislava, Slovensko
                    </p>
                    
                    <hr class="my-4">
                    <p class="text-muted small">
                        Tieto podmienky nadobúdajú účinnosť dňom ich zverejnenia na webovej stránke.
                        Posledná aktualizácia: 10. júl 2025
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>