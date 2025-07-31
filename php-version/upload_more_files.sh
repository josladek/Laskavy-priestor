#!/bin/bash

# FTP credentials
FTP_HOST="ftpx.forpsi.com"
FTP_USER="www.laskavypriestor.eu"
FTP_PASS="TU6faPvPhX"
FTP_DIR="/www"

# Additional files to upload
FILES=(
    "includes/functions.php"
    "includes/email_functions.php"
    "pages/courses.php"
    "pages/workshops.php"
    "pages/course-detail.php"
    "pages/workshop-detail.php"
    "admin/payment-requests.php"
)

echo "Uploading additional files to production server..."

for file in "${FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "Uploading $file..."
        curl -T "$file" "ftp://$FTP_HOST$FTP_DIR/$file" --user "$FTP_USER:$FTP_PASS" --ftp-create-dirs
        if [ $? -eq 0 ]; then
            echo "✓ $file uploaded successfully"
        else
            echo "✗ Failed to upload $file"
        fi
    else
        echo "⚠ $file not found, skipping"
    fi
done

echo "Additional upload complete!"
