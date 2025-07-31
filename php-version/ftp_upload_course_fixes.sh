#!/bin/bash

# FTP credentials
HOST="ftpx.forpsi.com"
USER="www.laskavypriestor.eu"
PASS="TU6faPvPhX"

echo "=== Uploading course cancellation fixes ==="

echo "Uploading updated functions..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/includes/ includes/functions.php

echo "Uploading updated my-courses page..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/my-courses.php

echo "Uploading updated course registration API..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/api/ api/register-course.php

echo "=== Upload completed ==="
