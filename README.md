# junnang
전설의 냉면

[http://junnang.co.kr/](http://junnang.co.kr/)


### db 

```sql

CREATE TABLE members (
	seq BIGINT NOT NULL AUTO_INCREMENT,
    user_id VARCHAR(32) NOT NULL,    
	email VARCHAR(64) NULL,
	name VARCHAR(32) NULL DEFAULT NULL,
	password VARCHAR(128) NOT NULL,
	member_type CHAR(1) NOT NULL DEFAULT 'B',
	created_at DATETIME NOT NULL DEFAULT now(),
	updated_at DATETIME NOT NULL DEFAULT now(),
	deleted_at DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (seq, user_id),
	UNIQUE INDEX user_id (user_id)
) COLLATE='utf8mb4_unicode_ci' ENGINE=InnoDB;


CREATE TABLE inquiries (
	seq BIGINT NOT NULL AUTO_INCREMENT,
	name VARCHAR(32) NULL DEFAULT NULL,
    hp VARCHAR(12) NOT NULL, 
    status VARCHAR(2) NOT NULL DEFAULT '0',  -- 0: 미처리(등록), 1: 처리중, 9: 처리완료,
	content VARCHAR(128) NOT NULL,
	memo VARCHAR(2048) NULL,
	created_at DATETIME NOT NULL DEFAULT now(),
	updated_at DATETIME NOT NULL DEFAULT now(),
	deleted_at DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (seq)
) COLLATE='utf8mb4_unicode_ci' ENGINE=InnoDB;

```