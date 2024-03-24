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
    clock_out TIMESTAMP DEFAULT current_timestamp(),
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
    status ENUM('Pending','Approved','Denied') DEFAULT 'Pending' NOT NULL,
    employees_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (employees_id) REFERENCES employees (id)
);

CREATE TABLE applicants (
    id INT(10) NOT NULL AUTO_INCREMENT,
	image_url VARCHAR(255) NULL DEFAULT NULL,
    first_name VARCHAR(30) NOT NULL,
    middle_name VARCHAR(30),
    last_name VARCHAR(30) NOT NULL,
    dateofbirth DATE NOT NULL,
    gender ENUM('Male','Female') NOT NULL,
    nationality VARCHAR(30) NOT NULL,
    civil_status ENUM('Single','Married','Divorced','Widowed') NOT NULL,
    applyingForDepartment ENUM('Product Order','Human Resources','Point of Sales', 'Inventory','Finance','Delivery') NOT NULL,
    contact_no VARCHAR(20) DEFAULT 'N/A',
    email VARCHAR(30) DEFAULT 'Email not available',
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
    account_info_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (account_info_id) REFERENCES account_info (id)
);

-- EXAMPLE DATA
INSERT INTO employees (image_url, first_name, middle_name, last_name, dateofbirth, gender, nationality, address, contact_no, email, civil_status, department, position) VALUES
('https://pbs.twimg.com/profile_images/1761013959287623680/tzx6DEES_400x400.jpg', 'Jarelle Anne', 'Cañada', 'Pamintuan', '2001-08-31', 'Female', 'Filipino', 'Rias-Eveland Boulevard', '09123456789', 'jarelleannepamintuan@gmail.com','Single', 'Human Resources', 'HR Manager'),
('https://pbs.twimg.com/profile_images/1556154158860107776/1eTSWQJx_400x400.jpg', 'Ziggy', 'Castro', 'Co', '2001-12-19', 'Female', 'Filipino', 'Pampanga', '09123456789', 'ziggyco@example.com','Single', 'Human Resources', 'Compensation and Benefits Specialist');

INSERT INTO employment_info (dateofhire, startdate, enddate, employees_id) VALUES
('2021-01-01 08:00:00', '2021-01-01 08:00:00', NULL, 1),
('2021-01-01 08:00:00', '2021-01-01 08:00:00', NULL, 1);

INSERT INTO salary_info (monthly_salary, total_salary, employees_id) VALUES
(40000.00, 28633.00, 1),
(40000.00, 28633.00, 1);

INSERT INTO tax_info (income_tax, withholding_tax, employees_id) VALUES
(4166.67, 3208.33, 1),
(4166.67, 3208.33, 1);

INSERT INTO benefit_info (philhealth, sss_fund, pagibig_fund, thirteenth_month, employees_id) VALUES
(2000.00, 1792.00, 200.00, 40000.00, 1),
(2000.00, 1792.00, 200.00, 40000.00, 1);

INSERT INTO leave_requests (type, details, start_date, end_date, status, employees_id) VALUES
('Sick Leave', 'Enjoy this moon necklace. I got it for you. You remind me of the moon, because it\'s always there and it\'s beautiful.', '2022-08-28 08:00:00', '2022-08-28 08:00:00', 'Pending', 1);

INSERT INTO applicants (image_url, first_name, middle_name, last_name, dateofbirth, gender, nationality, civil_status, applyingForDepartment, contact_no, email, applyingForPosition) VALUES
('https://pbs.twimg.com/profile_images/1762475736345067521/C-4MMKJQ_400x400.jpg', 'Jaruu', 'Eveland', 'Rias', '2001-08-31', 'Male', 'Filipino', 'Single', 'Human Resources', '09123456789', 'foxwriter@example.com', 'HR Coordinator');