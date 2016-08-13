#!/bin/bash
#50 1 * * * /home/work/www/very_crew/doc/backup.sh
cd /home/work/backup/sqldata
subfix=`date "+%Y-%m-%d_%H%M%S"`
mysqldump -u feichangjuzu -pyhl-feichangjuzu zd_very_crew --skip-lock-tables > zd_very_crew_"$subfix".sql
cp -f zd_very_crew_"$subfix".sql zd_very_crew.sql

USER="feichangjuzu"
PASS="yhl-feichangjuzu"

mysql -u $USER -p$PASS <<EOF 2> /dev/null
DROP DATABASE \`zd_very_crew-test\`;
create database \`zd_very_crew-test\` default character set utf8;
EOF

mysql -u $USER -p$PASS zd_very_crew-test <<EOF 2> /dev/null
source zd_very_crew.sql
EOF