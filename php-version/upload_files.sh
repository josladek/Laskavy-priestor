#!/bin/bash

# FTP credentials
FTP_HOST="ftpx.forpsi.com"
FTP_USER="www.laskavypriestor.eu"
FTP_PASS="TU6faPvPhX"
FTP_DIR="/www"

# Files to upload
FILES=(
    "api/register-course.php"
    "api/register-workshop.php"
    "pages/course-registration-confirm.php"
    "pages/workshop-registration-confirm.php"
    "pages/workshop-payment-confirmation.php"
    "pages/course-payment-confirmation.php"
)

echo "Uploading files to production server..."

for file in "${FILES[@]}"; do
    echo "Uploading $file..."
    curl -T "$file" "ftp://$FTP_HOST$FTP_DIR/$file" --user "$FTP_USER:$FTP_PASS" --ftp-create-dirs
    if [ $? -eq 0 ]; then
        echo "✓ $file uploaded successfully"
    else
        echo "✗ Failed to upload $file"
    fi
done

echo "Upload complete!"
