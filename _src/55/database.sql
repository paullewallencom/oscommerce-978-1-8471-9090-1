INSERT INTO configuration_group VALUES ('4321', 'Hide Payment Modules', 'You can hide payment modules from everyone apart yourself by specifying your customers_id here', '100', '1');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Master Customer ID', 'MASTER_CUSTOMERS_ID', '', 'Your own customers ID (create a customer for testing)', '4321', '0', now());
