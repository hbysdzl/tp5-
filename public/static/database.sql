
-- 创建数据库

create database qiyecn charset=utf8;


-- 管理员表

create table qi_manage (
	id int unsigned not null auto_increment,
	username varchar(50) not null unique comment '管理员名称',
	password varchar(32) not null comment '密码',
	sex enum('1','0') not null default '1' comment '性别',
	realityname varchar(10) not null default '' comment '真实姓名',
	email varchar(50) not null default '' comment '邮箱',
	tel varchar(20) not null default '' comment '手机号',
	face varchar(255) not null default '' comment '头像',
	addtime int unsigned not null comment '注册时间',
	updatetime timestamp not null comment '修改时间',
	last_time int unsigned not null default 0 comment '最后登录时间',
	last_ip varchar(20) not null default '' comment '最后登录ip',
	last_addr varchar(30) not null default '' comment '最后登录地区',
	remark varchar(255) not null default '' comment '备注',
	status enum('1','0','-1') default '1' comment '状态',
	primary key(id),
	key tel(tel)
)engine=innodb default charset=utf8;



-- 微信会员表

create table member (
	id int unsigned not null auto_increment,
	nikname varchar(50) not null default '' comment '微信昵称',
	face varchar(255) not null default '' comment '微信图像',
	gender enum('1','0') comment '性别',
	province varchar(10) not null default '' comment '省份',
	city varchar(10) not null default '' comment '城市',
	truename varchar(20) not null default '' comment '真实姓名',
	tel varchar(12) not null default '' comment '手机号',
	status enum('0','1','-1') default '0' comment '状态',
	primary key(id),
	key truename(truename)
)engine=innodb default charset=utf8;