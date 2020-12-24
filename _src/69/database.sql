INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Second Currency for Data Entry', 'SECOND_CURRENCY', 'EUR', '3 letter code of the second currency in product entry form', '1', '10', now());

ALTER TABLE products
add products_second_currency decimal(15,4) NULL;
