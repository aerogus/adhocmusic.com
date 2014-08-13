#!/bin/sh

mysqldump -h localhost -u root -p adhocmusic > adhocmusic.sql
tar czf adhocmusic.sql.tgz adhocmusic.sql
rm adhocmusic.sql

