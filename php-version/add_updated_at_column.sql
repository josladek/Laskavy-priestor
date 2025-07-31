-- SQL skript pre pridanie updated_at stĺpca do workshop_registrations tabuľky
-- Spustiť na produkčnej databáze

ALTER TABLE workshop_registrations 
ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL;

-- Nastaviť aktuálny čas pre existujúce záznamy
UPDATE workshop_registrations 
SET updated_at = registered_on 
WHERE updated_at IS NULL;

-- Alternatívne, ak chcete nastaviť na aktuálny čas:
-- UPDATE workshop_registrations SET updated_at = NOW() WHERE updated_at IS NULL;