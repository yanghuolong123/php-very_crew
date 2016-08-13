#!/bin/bash
#50 1 * * * /home/work/www/very_crew/doc/backup.sh
cd /home/work/backup/sqldata
subfix=`date "+%Y-%m-%d_%H%M%S"`
mysqldump -u feichangjuzu -pyhl-feichangjuzu zd_very_crew --skip-lock-tables > zd_very_crew_"$subfix".sql

