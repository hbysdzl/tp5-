
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


-- 网站配置表

create table qi_config (
	id int unsigned not null auto_increment,
	config text comment '网站配置参数',
	primary key(id)
)engine=innodb default charset=utf8;

-- 栏目表

create table qi_category(
	id int unsigned not null auto_increment,
	name varchar(10) not null default '' comment '栏目名称',
	pid int unsigned not null default 0 comment '上级栏目id',
	sort int unsigned not null default 0 comment '排序',
	pic varchar(255) not null default '' comment '栏目图片',
	keyword varchar(100) not null default '' comment '关键词',
	`desc` varchar(255) not null default '' comment '描述',
	remark varchar(255) not null default '' comment '摘要',
	comment text comment '内容',
	primary key(id),
	key name(name)
)engine=innodb default charset=utf8;


-- 内容表
create table qi_article(
	id int unsigned not null auto_increment,
	cid int unsigned not null default 0 comment '所属栏目id',
	title varchar(50) not null default '' comment '标题',
	keyword varchar(50) not null default '' comment '关键词',
	`desc` varchar(200) not null default '' comment '描述',
	remark varchar(100) not null default '' comment '摘要',
	author varchar(10) not null default '' comment '作者',
	views int unsigned not null default 0 comment '浏览次数',
	content text comment '内容',
	addtime int unsigned not null default 0 comment '添加时间',
	toptime int unsigned not null default 0 comment '置顶时间戳',
	istop tinyint not null default 0 comment '是否置顶 1是 0否',
	primary key(id),
	key cid(cid),
	key title(title)
)engine=innodb default charset=utf8;


-- 内容图片表
create table qi_pics (
	id int unsigned not null auto_increment,
	aid int unsigned not null default 0 comment '所属内容',
	pic varchar(255) not null default '' comment '图片地址',
	sort int unsigned not null default 0 comment '排序',
	primary key(id)
)engine=innodb default charset=utf8;


-- 轮播图表

create table qi_banner (
	id int unsigned not null auto_increment,
	title varchar(100) not null default '' comment '图片标题',
	pic varchar(255) not null default '' comment '图片地址',
	url varchar(100) not null default '' comment '链接地址',
	isshow enum('0','1') not null default '1' comment '是否显示',
	sort tinyint unsigned not null default 0 comment '排序',
	primary key(id),
	key title(title)
 )engine=innodb default charset=utf8;

-- 会员表

create table kd_member(
	id int unsigned not null auto_increment comment 'ID',
	truename varchar(32) not null default '' comment '姓名',
	phone varchar(13) not null default '' comment '手机号',
	openid varchar(100) not null default '' comment 'openid',
	nikname varchar(100) not null default '' comment '微信昵称',
	sex enum('0','1') not null default '0' comment '性别',
	face varchar(255) not null default '' comment '头像',
	addr varchar(32) not null default '地区' comment '地区',
	status enum('1','0','-1') not null default '1' comment '状态',
    primary key (id),
    unique index (openid),
    index (phone)
)engine=innodb default charset=utf8;