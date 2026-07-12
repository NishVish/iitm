db in iitminda_form_data: Table: tradevisitor					
Field	Type	Null	Key	Default	Extra
id	int	NO	PRI		auto_increment
person_key	varchar(100)	YES	UNI		
name	text	YES			
designation	text	YES			
company_name	text	YES			
category	varchar(50)	YES			
address	text	YES			
city	text	YES			
pin	text	YES			
state	text	YES			
mobile	text	YES			
email	text	YES			
created_at	timestamp	YES		CURRENT_TIMESTAMP	DEFAULT_GENERATED
bag_collected	tinyint(1)	NO		0	


db in iitminda_visitor:					
Table: visitor					
Field	Type	Null	Key	Default	Extra
visitorid	int	NO	PRI		auto_increment
database_name	varchar(100)	NO			
table_name	varchar(100)	NO			
id	int	NO			
created_at	timestamp	YES		CURRENT_TIMESTAMP	DEFAULT_GENERATED
					
join title + select 2 + name as full name
organization as company_name
phone as mobile					
					
db - iitminda_iitmindia_2024 Table: tradev					
Field	Type	Null	Key	Default	Extra
id	int unsigned	NO	PRI		auto_increment
title	varchar(200)	NO			
select2	text	YES			
name	text	YES			
designation	varchar(200)	YES			
organisation	varchar(200)	YES			
email	text	YES			
phone	varchar(200)	YES			
mobile	varchar(200)	YES			
address	text	YES			
city	text	YES			
state	text	YES			
pincode	varchar(200)	YES			
country	varchar(200)	YES			
website	text	YES			
city_name	text	YES			
date_reg	datetime	NO		CURRENT_TIMESTAMP	DEFAULT_GENERATED
bag_collected	tinyint(1)	NO		0	




