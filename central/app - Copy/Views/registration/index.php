<?php
// Optional: check if function 'view' exists (safety check)
if (function_exists('view')) {
    echo view('registration/side') ?? '';
    echo view('registration/tradevisitor') ?? '';
    // echo view('registration/exhibitor') ?? '';
    // echo view('registration/spot') ?? '';
}
?>



<!-- 
Table: company_data
Column Name	Type	Max Length	Primary Key	Default
id	int	11	Yes	
company_id	varchar	50	No	
database_name	varchar	100	No	
outbound	tinyint	4	No	0
company_name	varchar	255	No	
category	varchar	100	No	
address	text		No	
city	varchar	100	No	
pincode	varchar	20	No	
state	varchar	100	No	
country	varchar	100	No	
phone	varchar	50	No	
gst_number	varchar	50	No	
sales_person	varchar	100	No	
active_inactive	enum		No	active
created_at	timestamp		No	current_timestamp()
updated_at	datetime		No	
last_confirmed_at	datetime		No	
session	int	11	No	0
cross_validation	tinyint	1	No	

able: company_sources
Column Name	Type	Max Length	Primary Key	Default
id	int	11	Yes	
company_id	varchar	50	No	
source_id	int	11	No	
event_date	date		No	
notes	varchar	255	No	
created_at	timestamp		No	current_timestamp()
Table: contact
Column Name	Type	Max Length	Primary Key	Default
contact_id	int	11	Yes	
company_id	varchar	50	No	
priority	tinyint	4	No	1
name	varchar	255	No	
designation	varchar	100	No	
created_at	timestamp		No	current_timestamp()
updated_at	datetime		No	
Table: contact_email
Column Name	Type	Max Length	Primary Key	Default
email_id	int	11	Yes	
contact_id	int	11	No	
email	varchar	100	No	
is_primary	tinyint	4	No	0
created_at	timestamp		No	current_timestamp()
Table: contact_mobile
Column Name	Type	Max Length	Primary Key	Default
mobile_id	int	11	Yes	
contact_id	int	11	No	
mobile	varchar	50	No	
is_primary	tinyint	4	No	0
created_at	timestamp		No	current_timestamp() -->
