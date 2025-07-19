-- MySQL initialization script for Furniture E-commerce
-- This script will be executed when the MySQL container starts for the first time

-- Create additional database for testing if needed
CREATE DATABASE IF NOT EXISTS furniture_ecommerce_test;

-- Grant privileges
GRANT ALL PRIVILEGES ON furniture_ecommerce.* TO 'laravel_user'@'%';
GRANT ALL PRIVILEGES ON furniture_ecommerce_test.* TO 'laravel_user'@'%';
FLUSH PRIVILEGES;

-- Set MySQL configurations for better performance
SET GLOBAL innodb_buffer_pool_size = 256M;
SET GLOBAL max_connections = 200;
SET GLOBAL innodb_log_file_size = 50M;

-- Create indexes for better performance (Laravel migrations will create these, but good to have as backup)
-- These will be created by Laravel migrations, so commented out
-- CREATE INDEX idx_products_category_status ON products(category_id, status);
-- CREATE INDEX idx_products_featured ON products(featured, status);
-- CREATE INDEX idx_orders_user_status ON orders(user_id, status);
-- CREATE INDEX idx_cart_items_cart_product ON cart_items(cart_id, product_id);
