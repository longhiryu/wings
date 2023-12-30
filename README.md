# Hướng dẫn deploy Docker
## Cài đặt Docker và Docker Compose trên Ubuntu
https://docs.docker.com/engine/install/ubuntu/
https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04

## Clone source và copy database vào foler database 
database/db_name.sql

## Khởi chạy Docker
docker-compose up --build

## Mở tab terminal khác và chạy lệnh xác định id của container
docker container ps

## Import Database
docker exec -i <id_mysql_container> mysql -uthewings -pthewings2023 thewings < database/db_name.sql

## Truy cập vào bash của container app
docker exec -it <id_container> bash

## Chạy lệnh cài đặt
sh docker.sh