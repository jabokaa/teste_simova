
# Script mysql

CREATE TABLE Employee (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    code VARCHAR(10) NOT NULL UNIQUE NOT NULL
);

CREATE TABLE Appointment (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    seq BIGINT UNIQUE NOT NULL,
    create_date DATETIME NOT NULL,
    update_date DATETIME NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME,
    total_time BIGINT DEFAULT 0,
    id_employee BIGINT NOT NULL,
    enabled BOOLEAN NOT NULL DEFAULT true,
    description_work VARCHAR(30) NOT NULL,
    FOREIGN KEY (id_employee) REFERENCES Employee(id)
);

