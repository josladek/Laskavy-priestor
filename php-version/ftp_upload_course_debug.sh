#!/bin/bash

# FTP credentials
HOST="ftpx.forpsi.com"
USER="www.laskavypriestor.eu"
PASS="TU6faPvPhX"

echo "=== Uploading course debug files ==="

echo "Uploading course payment confirmation with debug..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/course-payment-confirmation.php

echo "Uploading register course API..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/api/ api/register-course.php

echo "=== Upload completed ==="
