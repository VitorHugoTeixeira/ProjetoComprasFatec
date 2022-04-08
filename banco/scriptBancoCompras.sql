create database Compras;

use Compras;

select * from usuarios;

create table usuarios
(
	id_usuario integer not null auto_increment primary key,
    usuario varchar(15) not null,
    senha varchar(32) not null,
    dtcria datetime default now(),
    estatus char(01) default ''
);

insert into usuarios (usuario, senha) values ('admin', md5('admin123'));

select * from usuarios where senha = md5('admin123');

alter table usuarios add column nome varchar(30) default '' after senha,
                     add column tipo varchar(30) default '' after estatus;
 

