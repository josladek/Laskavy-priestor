{pkgs}: {
  deps = [
    pkgs.mariadb
    pkgs.ncftp
    pkgs.php82Extensions.gd
    pkgs.php82Extensions.mbstring
    pkgs.php82Extensions.curl
    pkgs.php82Extensions.mysqli
    pkgs.php82Extensions.pdo_mysql
    pkgs.php82Extensions.pdo
    pkgs.php82
    pkgs.curl
    pkgs.netcat
    pkgs.lftp
    pkgs.postgresql
    pkgs.openssl
  ];
}
