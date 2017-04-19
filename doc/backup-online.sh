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

#tar -P -zcf uploads.tar.gz /home/work/www/very_crew/frontend/web/uploads

rm -rf /home/work/www/very_crew-test/
cp -r -f /home/work/www/very_crew/ /home/work/www/very_crew-test/

cd /home/work/www/very_crew-test/frontend
chmod -R 777 runtime web/assets web/uploads

cd /home/work/www/very_crew-test/backend
chmod -R 777 runtime web/assets web/uploads

sed -i 's/zd_very_crew/zd_very_crew-test/g' /home/work/www/very_crew-test/backend/config/db.php
sed -i 's/zd_very_crew/zd_very_crew-test/g' /home/work/www/very_crew-test/frontend/config/db.php
