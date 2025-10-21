FROM php:8.3.7-apache

# ===========================================
# 基本設定
# ===========================================

# ドキュメントルートを Laravel の public に変更
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 必要パッケージをインストール
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zlib1g-dev \
    unzip \
    locales \
    vim \
    curl \
    git \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Node.js 18（LTS）をインストール
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Apache の rewrite モジュールを有効化
RUN a2enmod rewrite

# ===========================================
# PHP設定
# ===========================================
RUN docker-php-ext-install intl pdo_mysql zip
RUN pecl install xdebug && docker-php-ext-enable xdebug

# 不要な intl 重複ロードを防ぐ
RUN rm -f /usr/local/etc/php/conf.d/docker-php-ext-intl.ini

# タイムゾーン・Xdebug無効化設定
RUN echo "date.timezone = Asia/Tokyo" > /usr/local/etc/php/conf.d/timezone.ini
RUN echo "xdebug.mode=off" > /usr/local/etc/php/conf.d/disable-xdebug.ini

# ===========================================
# Composer インストール
# ===========================================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ===========================================
# Laravel セットアップ
# ===========================================
WORKDIR /var/www

# まず Laravel 全体をコピー（artisan 含む）
COPY . .

# Composer install（post-autoloadでartisanが必要）
RUN composer install --no-interaction --optimize-autoloader

# Node.js依存関係インストール & ビルド
RUN npm install && npm run build

# Laravel キャッシュクリア & 最適化
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear

# ストレージ関連の権限調整
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# ===========================================
# 完了
# ===========================================
EXPOSE 80
CMD ["apache2-foreground"]
