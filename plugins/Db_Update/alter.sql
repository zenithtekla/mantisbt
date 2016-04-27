ALTER TABLE mantis_plugin_Serials_customer_table 
    ADD status BOOLEAN NOT NULL DEFAULT '1',
    ADD time_stamp int(10) unsigned NOT NULL DEFAULT '1';