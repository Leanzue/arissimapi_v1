DROP TABLE IF EXISTS imsistatus_responses;
DROP TABLE IF EXISTS imsistatus_requests;
DROP TABLE IF EXISTS esims;

CREATE TABLE esims(
   id INT AUTO_INCREMENT,
   imsi VARCHAR(255) NULL,
   iccid VARCHAR(255) NULL,
   pin VARCHAR(255) NULL,
   puk VARCHAR(255) NULL,
   ac VARCHAR(255) NULL,
   eki VARCHAR(255) NULL,
   pin2 VARCHAR(255) NULL,
   puk2 VARCHAR(255) NULL,
   adm1 VARCHAR(255) NULL,
   opc VARCHAR(255) NULL,
   
   PRIMARY KEY(id), 
   CONSTRAINT uc_imsi UNIQUE (imsi),
   CONSTRAINT uc_iccid UNIQUE (iccid)
);

CREATE TABLE imsistatus_requests(
   id INT AUTO_INCREMENT,
   esim_id INT NULL,
   filename_prefix VARCHAR(255) NULL,
   filename_extension VARCHAR(255) NULL,
   created_at DATETIME NULL,
   request_id VARCHAR(255) NULL,
   response_url VARCHAR(255) NULL,
   responded INTEGER DEFAULT 0,
   responded_at DATETIME NULL,
   last_state_at DATETIME NULL,
   response_message VARCHAR(500) NULL,
   
   FOREIGN KEY (esim_id) REFERENCES esims(id) ON DELETE SET NULL,
   PRIMARY KEY(id)
);

CREATE TABLE imsistatus_responses(
   id INT AUTO_INCREMENT,
   request_id INT NULL,
   icc VARCHAR(255) NULL,
   status VARCHAR(255) NULL,
   created_at DATETIME NULL,
   status_change_date DATETIME NULL,
   
   FOREIGN KEY (request_id) REFERENCES imsistatus_requests(id) ON DELETE SET NULL,
   PRIMARY KEY(id)
);