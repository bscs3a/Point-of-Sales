CREATE DATABASE IF NOT EXISTS bscs3a;
USE bscs3a;

CREATE TABLE employees (
    id INT(10) NOT NULL AUTO_INCREMENT,
    image_url VARCHAR(255) NULL DEFAULT NULL,
    first_name VARCHAR(30) NOT NULL,
    middle_name VARCHAR(30),
    last_name VARCHAR(30) NOT NULL,
    dateofbirth DATE NOT NULL,
    gender ENUM('Male','Female') NOT NULL,
    nationality VARCHAR(30) NOT NULL,
    address VARCHAR(255) NOT NULL,
    contact_no VARCHAR(20) DEFAULT 'N/A',
    email VARCHAR(30) DEFAULT 'N/A',
    civil_status ENUM('Single','Married','Divorced','Widowed') NOT NULL,
    department ENUM('Product Order','Human Resources','Point of Sales', 'Inventory','Finance','Delivery') NOT NULL,
    position VARCHAR(50) NOT NULL,
    sss_number VARCHAR(20), -- SSS number
    philhealth_number VARCHAR(20), -- PhilHealth number
    tin_number VARCHAR(20), -- TIN number
    pagibig_number VARCHAR(20), -- Pag-IBIG number
    PRIMARY KEY (id)
);



CREATE TABLE employment_info (
    id INT(10) NOT NULL AUTO_INCREMENT,
    dateofhire DATE NOT NULL,
    startdate DATE NOT NULL,
    enddate DATE,
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
    salary_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (salary_id) REFERENCES salary_info (id)
);

CREATE TABLE benefit_info (
    id INT(10) NOT NULL AUTO_INCREMENT,
    philhealth DECIMAL(10,2) NOT NULL,
    sss_fund DECIMAL(10,2) NOT NULL,
    pagibig_fund DECIMAL(10,2) NOT NULL,
    thirteenth_month DECIMAL(10,2) NOT NULL,
    salary_id INT(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (salary_id) REFERENCES salary_info (id)
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
    type ENUM('Sick Leave','Vacation Leave','5 Days Forced Leave','Special Privilege Leave','Maternity Leave','Paternity Leave','Parental Leave','Rehabilitation Leave','Special Leave (For Women)','Study Leave','Terminal Leave','Special Emergency Leave') NOT NULL,
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
    address VARCHAR(255) NOT NULL,
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
('https://pbs.twimg.com/profile_images/1776936838118404096/cxF34bgy_400x400.jpg', 'Jarelle Anne', 'Cañada', 'Pamintuan', '2001-08-31', 'Female', 'Filipino', 'Rias-Eveland Boulevard', '09123456789', 'jarelleannepamintuan@gmail.com','Single', 'Human Resources', 'HR Manager'),
('https://pbs.twimg.com/profile_images/1556154158860107776/1eTSWQJx_400x400.jpg', 'Ziggy', 'Castro', 'Co', '2001-12-19', 'Female', 'Filipino', 'Pampanga', '09123456789', 'ziggyco@example.com','Single', 'Human Resources', 'Compensation and Benefits Specialist'),
('https://pbs.twimg.com/profile_images/1591010546899308544/9_n476w9_400x400.png', 'Nathaniel', '', 'Fernandez', '2003-04-06', 'Male', 'Filipino', 'Pampanga', '09123456789', 'nathZ@example.com','Single', 'Human Resources', 'Legal Compliance Specialist');

INSERT INTO employment_info (dateofhire, startdate, enddate, employees_id) VALUES
('2021-01-01', '2021-01-01', NULL, 1),
('2021-01-01', '2021-01-01', NULL, 2),
('2021-01-01', '2021-01-01', NULL, 3);

INSERT INTO salary_info (monthly_salary, total_salary, employees_id) VALUES
(45000.00, 28633.00, 1),
(43000.00, 28633.00, 2),
(43000.00, 28633.00, 3);

INSERT INTO tax_info (income_tax, withholding_tax, salary_id) VALUES
(5416.67, 4208.33, 1),
(4916.67, 3808.33, 2),
(4916.67, 3808.33, 3);

INSERT INTO benefit_info (philhealth, sss_fund, pagibig_fund, thirteenth_month, salary_id) VALUES
(2250.00, 2016.00, 200.00, 45000.00, 1),
(2150.00, 1926.40, 200.00, 43000.00, 2),
(2150.00, 1926.40, 200.00, 43000.00, 3);

INSERT INTO account_info (username, password, role, employees_id) VALUES
('juuchiruru', 'konneko', 'Human Resources', 1),
('nausica', 'cat', 'Human Resources', 2),
('nae8f', 'gacha', 'Human Resources', 3);

INSERT INTO leave_requests (type, details, start_date, end_date, status, employees_id) VALUES
('Sick Leave', 'Enjoy this moon necklace. I got it for you. You remind me of the moon, because it\'s always there and it\'s beautiful.', '2022-08-28 08:00:00', '2022-08-28 08:00:00', 'Pending', 1);

INSERT INTO applicants (image_url, first_name, middle_name, last_name, dateofbirth, gender, nationality, civil_status, applyingForDepartment, address, contact_no, email, applyingForPosition) VALUES
('https://pbs.twimg.com/profile_images/1776936537089089536/Ws5Ihsh7_400x400.jpg', 'Jaruu', 'Eveland', 'Rias', '2001-08-31', 'Male', 'Filipino', 'Single', 'Human Resources', 'Country Roads Take Me Home', '09123456789', 'foxwriter@example.com', 'HR Coordinator'),
('https://pbs.twimg.com/profile_images/1752672426381762560/lGu3Vx-C_400x400.jpg', 'Suzuran', '', 'Yamino', '2001-08-31', 'Female', 'Filipino', 'Single', 'Finance', 'Sorcerer, I Hardly Even Know Her!', '09123456789', 'sorcerer@example.com', 'Credit Analyst');