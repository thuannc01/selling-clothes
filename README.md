
## Phần 1: Build và khơi chạy

Mở một terminal từ thư mục này, tạm gọi đây là `Terminal 1`
```bash
docker-compose build
docker-compose up -d

# Truy cập vào terminal của containter
docker exec -it laravel bash
# Tạo project laravel mới

composer create-project laravel/laravel .

```

Mở 1 terminal mới từ thư mục này, gọi là **Terminal 2**
```bash
sudo chown -R $USER laravel/source
```

Quay lại terminal 1, chạy lệnh sau để sửa quyền

```bash
chown -R $USER:www-data storage
chown -R $USER:www-data bootstrap/cache

chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

Truy cập `http://localhost:7979` để thử

## Phần 2: Thay đổi thông tin cơ sở dữ liệu:

Vào file `.env` trong thư mục `laravel/source`, sửa tham số của phần database như sau:
```dotenv
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=<Tên cơ sở dữ liệu của bạn>
DB_USERNAME=root
DB_PASSWORD=password
```

Sửa file `init.sql` trong thư mục `mariadb-data` như sau:
```sql
create database <Tên cơ sở dữ liệu của bạn>;
```

```bash
docker-compose restart
```

## Phần 3: Thực liện các câu lênh: 

Muốn thao tác các lệnh đối với laravel như `php artisan migrate` hay `composer install`, `npm install` thì tiến hành thực hiện lệnh `docker exec` như sau:


```bash
docker exec -it laravel bash
```

*`Docker exec` là câu lệnh sử dụng để chạy một command bên trong một container đang hoạt động.*

Bây giờ các bạn có thể sửa code Laravel tùy theo ý bạn.

Các bạn có thể truy cập `http://localhost:8080` để truy cập phpAdmin với tài khoan là `root/password`

Các bạn muốn xóa project thì xóa cả thư mục source.

Nếu đã có dữ án rồi thì copy code laravel vào thư mục này là được.

