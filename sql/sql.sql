use php;
set sql_mode = '';
CREATE TABLE users
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    email    varchar(255),
    password longtext,
    role     int
);

CREATE TABLE trademarks
(
    id      	int AUTO_INCREMENT PRIMARY KEY,
    name     	varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ,
    icon_url 	varchar(255),
	created_at  timestamp,
    updated_at  timestamp,
    deleted_at  timestamp
);


# sản phẩm thep từng danh mục: vd iphone 13 bản 64GB, xiaomi note 7 bản 128GB mới 99%,...
create table products
(
    id                  bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
    trademark_id         int,
    name                varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ,
    description         longtext  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ,
    first_image         varchar(255),
    second_image        varchar(255),
    third_image         varchar(255),
    type                varchar(20),
    status              varchar(20) default 'pending',
    memory              int default null,
    detail              longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ,
    price               bigint,
    cam                 varchar(255),
    display             varchar(255),
    ram                 varchar(255),
    rom                 varchar(255),
    color               varchar(255),
    creator_id         int,
    updated_by          int,
    created_at          timestamp,
    updated_at          timestamp,
    deleted_at          timestamp,
    FOREIGN KEY (creator_id) REFERENCES users (id),
    FOREIGN KEY (trademark_id) REFERENCES trademarks (id),
    FOREIGN KEY (updated_by) REFERENCES users (id)
);


create table orders
(
    id         bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
    phone      varchar(20),
    name       varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ,
    address    longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ,
    status     varchar(10),
    product_id bigint(20) unsigned,
    price      bigint,
    numb       bigint,
    created_at timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    FOREIGN KEY (product_id) REFERENCES products (id)
);