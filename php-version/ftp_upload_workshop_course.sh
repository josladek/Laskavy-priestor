#!/bin/bash

# FTP credentials
HOST="ftpx.forpsi.com"
USER="www.laskavypriestor.eu"
PASS="TU6faPvPhX"

echo "=== Uploading workshop and course payment system files ==="

# Upload new files
echo "Uploading confirmation pages..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/workshop-payment-confirmation.php
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/course-payment-confirmation.php

echo "Uploading updated API files..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/api/ api/register-workshop.php
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/api/ api/register-course.php

echo "Uploading updated email functions..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/includes/ includes/email_functions.php

echo "Uploading updated workshops page..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/workshops.php

echo "=== Upload completed ==="
