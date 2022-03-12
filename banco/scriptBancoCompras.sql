create database Compras;

use Compras;

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

