#!/bin/bash

# FTP Deployment script for lektor attendance functionality
echo "Starting FTP deployment for lektor attendance system..."

# FTP Configuration (using environment variables for security)
FTP_SERVER="ftpx.forpsi.com"
FTP_USER="www.laskavypriestor.eu"
FTP_PASS="TU6faPvPhX"

# Function to upload file via FTP
upload_file() {
    local_file=$1
    remote_file=$2
    
    echo "Uploading: $local_file -> $remote_file"
    
    ftp -inv $FTP_SERVER << EOF
user $FTP_USER $FTP_PASS
binary
put $local_file $remote_file
quit
EOF
    
    if [ $? -eq 0 ]; then
        echo "✅ Successfully uploaded: $remote_file"
    else
        echo "❌ Failed to upload: $remote_file"
    fi
}

# Files to upload
echo "Uploading lektor attendance system files..."

# Upload main attendance file
upload_file "php-version/lektor/class-detail.php" "/www/lektor/class-detail.php"

echo ""
echo "🚀 Deployment completed!"
echo "📍 Check the lektor portal at: https://www.laskavypriestor.eu/lektor/"
echo "🔧 New attendance table is now available in lecturer class details"