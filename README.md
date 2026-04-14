# フリマアプリ模擬案件
## 環境構築
### Dockerビルド
1. git clone git@github.com:rh22120301/attendance-management-test.git
2. cd flea-market-test
3. docker-compose up -d

### Laravel環境構築
1. docker-compose exec php bash
2. mkdir -p storage/framework/{cache,sessions,views}
3. chmod -R 777 storage bootstrap/cache
4. composer install
5. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
6. .envに以下の環境変数を追加
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

6. php artisan key:generate
7. php artisan migrate
8. php artisan db:seed
9. php artisan storage:link

### ER図
<img width="759" height="971" alt="flea-market-test" src="https://github.com/user-attachments/assets/74479951-1832-45c2-95b7-370582fca741" />



### 使用技術(実行環境)
- PHP  8.1.34
- mysql  Ver 8.0.26
- Laravel Framework 8.83.8

### URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
