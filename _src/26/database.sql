INSERT INTO configuration_group VALUES ('23456', 'Unique product', 'Unique product', '20', '1');

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Condition product name', 'UNIQUE_IF_ONE', '', 'A search term from the products name', '23456', '1', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Condition customer firstname', 'UNIQUE_IF_TWO', '', 'A search term from the customer firstname', '23456', '2', now());
