create database COVID;

create table customers
(
first_name varchar(30) not null,
last_name varchar(30) not null,
birthdate date not null,
nfc_id int not null auto_increment,
number_of_id_doc bigint(100) not null,
type_of_id_doc	varchar(100),
authority_of_id_doc varchar(100),

constraint PKcustomers primary key(nfc_id)
);

create table places
(
number_of_beds tinyint not null,
place_id int not null,
place_name varchar(100),
place_desc varchar(100),

constraint PKplaces primary key (place_id)
);

create table visit
(
date_of_entrance date not null,
time_of_entrance time not null,
date_of_exit date not null,
time_of_exit time not null,
nfc_id int not null,
place_id int not null,

constraint PKvisit primary key (nfc_id,place_id),
constraint FKcustomers foreign key (nfc_id) references customers(nfc_id) on update cascade on delete cascade,
constraint FKplaces foreign key (place_id) references places(place_id) on update cascade on delete cascade

);

create table access
(
date_of_start date not null,
time_of_start time not null,
date_of_end date not null,
time_of_end time not null,
nfc_id int not null,
place_id int not null,

constraint PKaccess primary key (nfc_id,place_id),
constraint FK1customers foreign key (nfc_id) references customers(nfc_id) on update cascade on delete cascade,
constraint FK1places foreign key (place_id) references places(place_id) on update cascade on delete cascade

);

create table services
(
service_id int not null,
service_desc varchar(100) not null,

constraint PKservices primary key (service_id)
);

create table service_charge
(
date_of_charge date not null,
time_of_charge time not null,
amount float not null,
description_of_charge varchar(100) not null,

constraint PKservice_charge primary key (date_of_charge,time_of_charge)

);

create table enjoy_services
(
nfc_id int not null,
date_of_charge date not null,
time_of_charge time not null,
service_id int not null,

constraint PKenjoy_services primary key (nfc_id,date_of_charge,time_of_charge,service_id),
constraint FK2customers foreign key (nfc_id) references customers(nfc_id) on update cascade on delete cascade,
constraint FKservice_charge foreign key (date_of_charge,time_of_charge) references service_charge(date_of_charge,time_of_charge) on update cascade on delete cascade,
constraint FKservices foreign key (service_id) references services(service_id) on update cascade on delete cascade

);

create table provided
(
service_id int not null,
place_id int not null,

constraint PKprovided primary key (service_id,place_id),
constraint FK1services foreign key (service_id) references services(service_id) on update cascade on delete cascade,
constraint FK2places foreign key (place_id) references places(place_id) on update cascade on delete cascade

);

create table services_with_registration
( 
service_id int not null,

constraint PKservices_with_registration primary key (service_id),
constraint FK2services foreign key (service_id) references services(service_id) on update cascade on delete cascade
);

create table services_without_registration
( 
service_id int not null,

constraint PKservices_without_registration primary key (service_id),
constraint FK3services foreign key (service_id) references services(service_id) on update cascade on delete cascade
);

create table registrations_to_services
(
nfc_id int not null,
service_id int not null,
date_of_registration date not null,
time_of_registration time not null,

constraint PKregistrations_to_services primary key(nfc_id,service_id),
constraint FK4services foreign key (service_id) references services(service_id) on update cascade on delete cascade,
constraint FK3customers foreign key (nfc_id) references customers(nfc_id) on update cascade on delete cascade

);

create table customer_phone
(
	nfc_id int not null,
	phone_number bigint not null,
	constraint PKcustomer_phone primary key (nfc_id, phone_number),
	constraint FKcustomer_phone foreign key (nfc_id) references customers(nfc_id) on update cascade on delete cascade
);

create table customer_email
(
	nfc_id int not null,
	email varchar(100) not null,
	constraint PKcustomer_email primary key (nfc_id, email),
	constraint FKcustomer_email foreign key (nfc_id) references customers(nfc_id) on update cascade on delete cascade
);
















