CREATE DATABASE IF NOT EXISTS humanresourcesdb;
USE humanresourcesdb;

CREATE TABLE employees (
    id INT(10) NOT NULL AUTO_INCREMENT,
	  image_url VARCHAR(255) NULL DEFAULT NULL,
    first_name VARCHAR(30) NOT NULL,
    middle_name VARCHAR(30),
    last_name VARCHAR(30) NOT NULL,
    dateofbirth DATE NOT NULL,
    gender ENUM('male','female') NOT NULL,
    nationality VARCHAR(30) NOT NULL,
    address VARCHAR(255) NOT NULL,
    contact_no VARCHAR(20) DEFAULT 'N/A',
    email VARCHAR(30) DEFAULT 'N/A',
    civil_status ENUM('Single','Married','Divorced','Widowed') NOT NULL,
    department ENUM('Product Order','Human Resources','Point of Sales', 'Inventory','Finance','Delivery') NOT NULL,
	  position VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE employment_info (
    id INT(10) NOT NULL AUTO_INCREMENT,
    dateofhire DATETIME NOT NULL,
    startdate DATETIME NOT NULL,
    enddate DATETIME,
    employees_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (employees_id) REFERENCES employees (id)
);

CREATE TABLE salary_info (
    id INT(10) NOT NULL AUTO_INCREMENT,
    monthly_salary DECIMAL(10,2) NOT NULL,
    total_salary DECIMAL(10,2) NOT NULL,
    employees_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (employees_id) REFERENCES employees (id)
);

CREATE TABLE tax_info (
    id INT(10) NOT NULL AUTO_INCREMENT,
    income_tax DECIMAL(10,2) NOT NULL,
    withholding_tax DECIMAL(10,2) NOT NULL,
    employees_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (employees_id) REFERENCES employees (id)
);

CREATE TABLE benefit_info (
    id INT(10) NOT NULL AUTO_INCREMENT,
    philhealth DECIMAL(10,2) NOT NULL,
    sss_fund DECIMAL(10,2) NOT NULL,
    pagibig_fund DECIMAL(10,2) NOT NULL,
    thirteenth_month DECIMAL(10,2) NOT NULL,
    employees_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (employees_id) REFERENCES employees (id)
);

CREATE TABLE attendance (
    id INT(10) NOT NULL AUTO_INCREMENT,
    attendance_date DATETIME NOT NULL,
    clock_in TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    clock_out TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    employees_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (employees_id) REFERENCES employees (id)
);

CREATE TABLE leave_requests (
    id INT(10) NOT NULL AUTO_INCREMENT,
    type VARCHAR(30) NOT NULL,
    details VARCHAR(255) NOT NULL,
    date_submitted TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    status ENUM('Pending','Approved','Denied'),
    employees_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (employees_id) REFERENCES employees (id)
);

CREATE TABLE applicants (
    id INT(10) NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    middle_name VARCHAR(30),
    last_name VARCHAR(30) NOT NULL,
    dateofbirth DATETIME NOT NULL,
    gender ENUM('Male','Female') NOT NULL,
    nationality VARCHAR(30) NOT NULL,
    civil_status ENUM('Single','Married','Divorced','Widowed') NOT NULL,
    applyingForPosition VARCHAR(30) NOT NULL,
    apply_date TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (id)
);

CREATE TABLE account_info (
    id INT(10) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Product Order','Human Resources','Point of Sales', 'Inventory','Finance','Delivery') NOT NULL,
    employees_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (employees_id) REFERENCES employees (id)
);

CREATE TABLE session (
    id INT(10) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL UNIQUE,
    login_time TIMESTAMP DEFAULT current_timestamp(),
    logout_time TIMESTAMP DEFAULT current_timestamp(),
    role ENUM('Product Order','Human Resources','Point of Sales', 'Inventory','Finance','Delivery') NOT NULL,
    PRIMARY KEY (id)
);