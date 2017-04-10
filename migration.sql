create table ribbons
(
	id serial not null
		constraint ribbons_pkey
			primary key,
	title varchar(100),
	meta_data json
);

create table documents
(
	id serial not null
		constraint documents_pkey
			primary key,
	title varchar(300),
	content text,
	meta_data json,
	ribbon_id integer
);
