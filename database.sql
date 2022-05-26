conn SYSTEM/SYSTEM as sysdba;
drop user proj cascade;
create user proj identified by proj;
grant connect ,resource to proj;
grant create Materialized view to proj;
conn proj/proj;


------------------------------------------------------------------------------------------------------------------------
--create category table
create table category(
id varchar2(4) PRIMARY KEY,
name varchar2(100),
description varchar2(500)
);

--create product table
create table product(
id varchar2(4) PRIMARY KEY,
name varchar2(20),
parent_cat varchar2(4),
price number,
FOREIGN KEY (parent_cat) REFERENCES category on delete cascade
);

--create cart table
create table cart(
id varchar2(6) PRIMARY KEY,
product_id varchar2(4),
dat date,
FOREIGN KEY (product_id) REFERENCES product on delete cascade
);

----------------------------------------------------------------------------------------------------------------------
--create category sequence
create sequence category_seq
start with 1
maxvalue 999
nocycle;

--create product sequence
create sequence product_seq
start with 1
maxvalue 999
nocycle;

--create cart sequence
create sequence cart_seq
start with 1
maxvalue 999
nocycle;
----------------------------------------------------------------------------------------------------------------------

--insert into category table 3 rows using sequence
insert into category (id,name,description) values ('c' || to_char(category_seq.nextval),'shoes','its very expensive shoes');
insert into category (id,name,description) values ('c' || to_char(category_seq.nextval),'mobile','its very expensive mobile');
insert into category (id,name,description) values ('c' || to_char(category_seq.nextval),'laptop','its very expensive laptop');

--insert into product table 6 rows using sequence
insert into product (id,name,parent_cat,price) values ('p' || to_char(product_seq.nextval),'nike','c1',100);
insert into product (id,name,parent_cat,price) values ('p' || to_char(product_seq.nextval),'adidas','c1',500);
insert into product (id,name,parent_cat,price) values ('p' || to_char(product_seq.nextval),'iphone','c2',1700);
insert into product (id,name,parent_cat,price) values ('p' || to_char(product_seq.nextval),'samsung','c2',3500);
insert into product (id,name,parent_cat,price) values ('p' || to_char(product_seq.nextval),'hp','c3',15000);
insert into product (id,name,parent_cat,price) values ('p' || to_char(product_seq.nextval),'lenovo','c3',11000);

--insert into cart table 3 rows using sequence
insert into cart (id,product_id,dat) values ('t' || to_char(cart_seq.nextval),'p1',to_date('01-05-22','dd-mm-yy'));
insert into cart (id,product_id,dat) values ('t' || to_char(cart_seq.nextval),'p2',to_date('12-06-22','dd-mm-yy'));
insert into cart (id,product_id,dat) values ('t' || to_char(cart_seq.nextval),'p3',to_date('11-08-22','dd-mm-yy'));

------------------------------------------------------------------------------------------------------------------------

--create Materialized view to show products that costs more than 10000
create Materialized view expensive_products
as
select * from product where price>10000;

------------------------------------------------------------------------------------------------------------------------
--Insert category procedures
create or replace procedure categ_insert(name in varchar2, description in varchar2)
as
begin
insert into category(id,name,description) values ('c' || to_char(category_seq.nextval),name,description);
end;
/


--Insert product procedures
create or replace procedure prod_insert(name in varchar2,parent_cat in varchar2,price in number)
as
begin
insert into product(id,name,parent_cat,price) values ('p' || to_char(product_seq.nextval),name,parent_cat,price);
end;
/


--Insert cart procedures
create or replace procedure cart_insert(pid in varchar2, dat in date)
as
begin
insert into cart(id,product_id,dat) values ('t' || to_char(cart_seq.nextval),pid,to_date(dat));
end;
/


--delete procedure to use for all tables by checking the first letter of the id column
create or replace procedure delete_record(fid in varchar2)
as
begin
if substr(fid,1,1) = 't' then
delete from cart where id=fid;
elsif substr(fid,1,1) = 'c' then
delete from category where id=fid;
elsif substr(fid,1,1)='p' then
delete from product where id=fid;
end if;
end;
/


--update category_description_procedure
create procedure update_cat_desc(cat_desc in varchar2,new_cat_desc in varchar2 ) 
as  
begin  
update category set description=new_cat_desc
where description = cat_desc ;
end;
/


--update category_name_procedure
create procedure update_cat_name(cat_name in varchar2,new_cat_name in varchar2 ) 
as  
begin  
update category set name=new_cat_name
where name = cat_name;
end;
/

--update product_name_procedure
create procedure update_prod_name(prod_name in varchar2,new_prod_name in varchar2 ) 
as  
begin  
update product set name=new_prod_name
where name = prod_name;
end;
/



--getAllData function
create function getAllData(pid product.id%type)
return varchar2
is 
i product.id%type;
n product.name%type;
p product.price%type;
c product.parent_cat%type;
begin
select id,parent_cat,name,price into i,c,n,p
from product
where id=pid;
return 'id:' || i || ' category_id:' || c || ' name:' || n || ' price:' || p;
end;
/
