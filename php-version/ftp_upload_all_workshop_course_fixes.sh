#!/bin/bash

# FTP credentials
HOST="ftpx.forpsi.com"
USER="www.laskavypriestor.eu"
PASS="TU6faPvPhX"

echo "=== Uploading ALL workshop and course payment system files ==="

echo "Uploading workshop payment confirmation..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/workshop-payment-confirmation.php

echo "Uploading updated workshops page..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/workshops.php

echo "Uploading course payment confirmation..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/course-payment-confirmation.php

echo "Uploading updated courses page..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/pages/ pages/courses.php

echo "Uploading payment requests admin page..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/admin/ admin/payment-requests.php

echo "Uploading email functions..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/includes/ includes/email_functions.php

echo "Uploading register course API..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/api/ api/register-course.php

echo "Uploading register workshop API..."
ncftpput -R -v -u "$USER" -p "$PASS" "$HOST" /www/api/ api/register-workshop.php

echo "=== Upload completed ==="
