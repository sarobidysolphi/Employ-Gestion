CREATE DATABASE IF NOT EXISTS employes_db CHARACTER SET utf8mb4;
USE employes_db;

CREATE TABLE IF NOT EXISTS employe (
  numEmp VARCHAR(20) PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  salaire DECIMAL(12,2) NOT NULL
);

INSERT INTO employe (numEmp, nom, salaire) VALUES
  ('E001', 'Rakoto Jean', 780),
  ('E002', 'Rasoa Marie', 2400),
  ('E003', 'Andria Paul', 5600),
  ('E004', 'Rabe Sophie', 3100),
  ('E005', 'Ravo Nirina', 950);