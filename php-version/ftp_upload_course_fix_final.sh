#!/bin/bash

# FTP credentials
HOST="ftpx.forpsi.com"
USER="www.laskavypriestor.eu"
PASS="TU6faPvPhX"

echo "=== Uploading FINAL course registration fix ==="

echo "Uploading fixed register-course.php..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/api/ api/register-course.php

echo "Uploading fixed course-payment-confirmation.php..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/course-payment-confirmation.php

echo "=== Upload completed - Course registration now works like lesson registration ==="
