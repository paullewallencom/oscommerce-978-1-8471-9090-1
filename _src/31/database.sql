ALTER TABLE products 
ADD affiliate INT NOT NULL DEFAULT 0 AFTER products_id ,
ADD affiliate_url VARCHAR( 255 ) NULL AFTER affiliate ;
