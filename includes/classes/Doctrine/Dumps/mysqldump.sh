#!/bin/bash
# Database dump for use with Docker
mysqldump -u root -proot bjerckecms --ignore-table=bjerckecms.doctrine_migration_versions | gzip > bjerckecms_db.sql.gz

