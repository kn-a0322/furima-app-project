# Furima（フリマアプリ）

## プロジェクト概要

Furimaは、個人間で商品を売買できるフリーマーケットアプリケーションです。
ユーザーは商品を出品し、他のユーザーが購入できるプラットフォームを提供します。

### 主な機能

- ユーザー登録・ログイン機能
- 商品の出品・閲覧・購入機能
- プロフィール管理機能
- 商品のいいね機能
- 商品へのコメント機能
- カテゴリー別の商品検索機能
- 購入履歴・出品履歴の管理

## 使用技術
- **PHP**: 8.2.11
- **Laravel**: 10.x
- **MySQL**: 8.0.26
- **nginx**: 1.21.1


## 環境構築手順

### 必要な環境

- Docker Desktop
- Git

### セットアップ手順

1. **リポジトリのクローン**
```bash
git clone <repository-url>
cd furima-app-project
```

2. **Docker環境の起動**
```bash
docker-compose up -d
```

3. **PHPコンテナに入る**
```bash
docker-compose exec php bash
```

4. **Composerパッケージのインストール**
```bash
composer install
```

5. **環境変数ファイルの設定**
```bash
cp .env.example .env
```

6. **アプリケーションキーの生成**
```bash
php artisan key:generate
```

7. **.envファイルのデータベース設定を編集**
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

8. **データベースのマイグレーション**
```bash
php artisan migrate
```


### アクセスURL

- **アプリケーション**: http://localhost
- **phpMyAdmin**: http://localhost:8080
  - ユーザー名: `laravel_user`
  - パスワード: `laravel_pass`

### Docker環境の停止

```bash
docker-compose down
```

## ER図

このプロジェクトのデータベース設計は以下のER図に基づいています。

詳細は `docs/ER.drawio` ファイルをご参照ください。

### リレーション

- **users - profiles**: 1対1の関係
- **users - items**: 1対多の関係（出品）
- **users - orders**: 1対多の関係（購入）
- **users - likes**: 1対多の関係
- **users - comments**: 1対多の関係
- **items - orders**: 1対0..1の関係
- **items - category_item**: 1対多の関係
- **categories - category_item**: 1対多の関係
- **items - likes**: 1対多の関係
- **items - comments**: 1対多の関係

---



