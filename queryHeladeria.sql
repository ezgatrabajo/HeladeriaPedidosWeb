select * from empleado;
select * from cliente;

delete from  pedidodetalle where 1 = 1;



update fos_user set empresa_id = 1 where id = 16;


select * from fos_user order by id asc;



truncate table pedido;
select * from  pedido;
update pedido set user_id = 1 where id in(1,2);


truncate table  pedidodetalle;
select * from  pedidodetalle;

select * from fos_user;

delete from fos_user where id = 18;

update fos_user set rol = 5 where id in(1,2);

select * from pedido ;
delete from pedidodetalle where id > 0;
delete from pedido where id > 0;

update pedido set visto = false where id > 0;


