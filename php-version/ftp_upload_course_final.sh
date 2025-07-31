#!/bin/bash

# FTP credentials
HOST="ftpx.forpsi.com"
USER="www.laskavypriestor.eu"
PASS="TU6faPvPhX"

echo "=== Uploading FINAL course payment fix ==="

echo "Uploading cleaned course payment confirmation..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/course-payment-confirmation.php

echo "=== Upload completed ==="
