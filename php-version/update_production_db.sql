-- Add payment_status columns to workshop and course registrations if they don't exist
ALTER TABLE workshop_registrations ADD COLUMN IF NOT EXISTS payment_status VARCHAR(20) DEFAULT 'pending';
ALTER TABLE course_registrations ADD COLUMN IF NOT EXISTS payment_status VARCHAR(20) DEFAULT 'pending';
