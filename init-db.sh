#!/bin/bash
set -e

echo "Waiting for MySQL to start..."
until mysql -uroot -p"$MYSQL_ROOT_PASSWORD" -h db --protocol=TCP -e ";" ; do
    echo "MYSQL_ROOT_PASSWORD is: $MYSQL_ROOT_PASSWORD"
    echo "MySQL is unavailable - sleeping" 
    sleep 1
done

echo "Connected to MySQL."

echo "Dropping existing database (if exists) and creating a new one..."
mysql -uroot -p"$MYSQL_ROOT_PASSWORD" -h db --protocol=TCP <<EOSQL
DROP DATABASE IF EXISTS movies_db;
CREATE DATABASE movies_db;
USE movies_db;
SOURCE /movies_db.sql;
EOSQL

echo "Database movies_db created."
