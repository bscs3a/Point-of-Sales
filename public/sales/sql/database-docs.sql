-- Audit Trail Table
CREATE TABLE tbl_sls_audit (

    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(255),
    log_action VARCHAR(255),
    log_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO tbl_sls_audit (employee_name, log_action) VALUES ('Alfaro, Aian Louise', 'Log in');
INSERT INTO tbl_sls_audit (employee_name, log_action) VALUES ('Alfaro, Aian Louise', 'Log out');

SELECT * FROM tbl_sls_audit;

-- Categories Table
CREATE TABLE Categories (
    Category_ID INT(11) NOT NULL AUTO_INCREMENT,
    Category_Name VARCHAR(50) NOT NULL,
    PRIMARY KEY (Category_ID)
);

-- Products Table
CREATE TABLE Products (
    ProductID INT(11) NOT NULL AUTO_INCREMENT,
    Supplier_ID INT(11) NOT NULL,
    Category_ID INT(11) NOT NULL,
    ProductImage VARCHAR(250) NOT NULL,
    ProductName VARCHAR(100) DEFAULT NULL,
    Supplier VARCHAR(50) NOT NULL,
    Description VARCHAR(255) DEFAULT NULL,
    DeliveryRequired VARCHAR(3) DEFAULT NULL,
    Price DECIMAL(10,2) DEFAULT NULL,
    Stocks INT(11) DEFAULT NULL,
    UnitOfMeasurement VARCHAR(20) DEFAULT NULL,
    TaxRate DECIMAL(5,2) DEFAULT NULL,
    ProductWeight DECIMAL(10,2) DEFAULT NULL,
    FOREIGN KEY (Category_ID) REFERENCES Categories(Category_ID),
    PRIMARY KEY (ProductID)
);

-- Customers Table
CREATE TABLE IF NOT EXISTS Customers (
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(100),
    LastName VARCHAR(100),
    Phone VARCHAR(20),
    Email VARCHAR(100)
);

-- Employees Table -- Filler OnLy
CREATE TABLE IF NOT EXISTS Employees (
    EmployeeID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(100),
    LastName VARCHAR(100),
    Position VARCHAR(100),
    Email VARCHAR(100),
    Phone VARCHAR(20)
);

-- Sales Table with DeliveryDate column
CREATE TABLE IF NOT EXISTS Sales (
    SaleID INT AUTO_INCREMENT PRIMARY KEY,
    SaleDate DATETIME,
    SalePreference ENUM('Delivery', 'Pick-up'),
    ShippingFee DECIMAL(10, 2),
    PaymentMode ENUM('Cash', 'Card'),
    CardNumber VARCHAR(16),
    ExpiryDate TEXT,
    CVV VARCHAR(3),
    TotalAmount DECIMAL(10, 2),
    EmployeeID INT,
    CustomerID INT,
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID),
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);

-- SaleDetails Table
CREATE TABLE IF NOT EXISTS SaleDetails (
    SaleDetailID INT AUTO_INCREMENT PRIMARY KEY,
    SaleID INT,
    ProductID INT,
    Quantity INT,
    ProductWeight DECIMAL(10, 2),
    UnitPrice DECIMAL(10, 2),
    Subtotal DECIMAL(10, 2),
    Tax DECIMAL(10, 2),
    TotalAmount DECIMAL(10, 2),
    FOREIGN KEY (SaleID) REFERENCES Sales(SaleID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);

-- Trucks Table -- Filler Only
CREATE TABLE IF NOT EXISTS Trucks (
    TruckID INT AUTO_INCREMENT PRIMARY KEY,
    TruckName VARCHAR(100),
    TruckType VARCHAR(50),
    Capacity DECIMAL(10, 2)
);

-- DeliveryOrders Table
CREATE TABLE IF NOT EXISTS DeliveryOrders (
    DeliveryOrderID INT AUTO_INCREMENT PRIMARY KEY,
    SaleID INT,  
    ProductID INT,
    Quantity INT,
    ProductWeight DECIMAL(10, 2),
    DeliveryAddress TEXT,
    DeliveryDate DATE,
    ReceivedDate DATE,  
    DeliveryStatus ENUM('Pending', 'In Transit', 'Delivered') DEFAULT 'Pending',
    TruckID INT,
    FOREIGN KEY (SaleID) REFERENCES Sales(SaleID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID),
    FOREIGN KEY (TruckID) REFERENCES Trucks(TruckID)
);

-- TargetSales Table
CREATE TABLE IF NOT EXISTS TargetSales (
    TargetID INT AUTO_INCREMENT PRIMARY KEY,
    MonthYear DATE,
    TargetAmount DECIMAL(10, 2),
    EmployeeID INT,
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);

CREATE TABLE ReturnProducts (
    ReturnID INT AUTO_INCREMENT PRIMARY KEY,
    SaleID INT,
    ProductID INT,
    Quantity INT,
    Reason VARCHAR(255),
    PaymentReturned DECIMAL(10, 2),
    ReturnDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (SaleID) REFERENCES Sales(SaleID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);

-- Assuming the categories already exist in the Categories table
-- You should adjust the following INSERT statements according to the Category_ID values in your Categories table

    INSERT INTO Products (Supplier_ID, Category_ID, ProductImage, ProductName, Supplier, Description, DeliveryRequired, Price, Stocks, UnitOfMeasurement, TaxRate, ProductWeight) 
    VALUES 
    (1, 1, 'uploads/hammer.png', 'Hammer (Large)', 'Supplier A', 'Heavy-duty hammer for construction work', 'No', 299.00, 50, 'pcs', 0.12, 1.5),
    (2, 1, 'screwdriver_set_standard.jpg', 'Screwdriver Set (Standard)', 'Supplier B', 'Set of 6 screwdrivers with various sizes', 'No', 199.00, 30, 'set', 0.12, 0.8),
    (3, 2, 'cement_50kg.jpg', 'Cement (50kg)', 'Supplier C', 'Portland cement for construction purposes', 'Yes', 220.00, 100, 'kg', 0.12, 50),
    (4, 2, 'default.jpg', 'Gravel (1 ton)', 'Default Supplier', 'Crushed stone for construction projects', 'Yes', 500.00, 50, 'ton', 0.12, 907.185),
    (5, 3, 'default.jpg', 'Paint Brush Set', 'Default Supplier', 'Set of 10 paint brushes for art projects', 'No', 99.00, 20, 'set', 0.12, 0.5),
    (6, 4, 'default.jpg', 'Safety Helmet', 'Default Supplier', 'Hard hat helmet for construction safety', 'No', 150.00, 40, 'pcs', 0.12, 0.3),
    (7, 1, 'uploads/drill.png', 'Drill Machine', 'Default Supplier', 'Cordless drill machine with rechargeable batteries', 'No', 599.00, 15, 'pcs', 0.12, 2),
    (8, 2, 'default.jpg', 'Plywood (4x8 feet)', 'Default Supplier', 'Plywood sheets for carpentry and construction', 'Yes', 600.00, 30, 'sheet', 0.12, 20),
    (9, 2, 'default.jpg', 'Steel Bar (1 meter)', 'Default Supplier', 'Deformed steel bars for reinforcement in concrete construction', 'Yes', 50.00, 200, 'meter', 0.12, 2.5),
    (10, 5, 'default.jpg', 'Paint Thinner', 'Default Supplier', 'Solvent used for thinning oil-based paints and cleaning paint brushes', 'No', 150.00, 50, 'pcs', 0.12, 1),
    (11, 2, 'default.jpg', 'Concrete Blocks (Standard)', 'Default Supplier', 'Standard concrete blocks for building walls', 'Yes', 5.00, 200, 'pcs', 0.12, 2.3),
    (12, 2, 'default.jpg', 'Roofing Shingles (Bundle)', 'Default Supplier', 'Bundle of roofing shingles for covering roofs', 'Yes', 25.00, 100, 'bundle', 0.12, 13.6078),
    (13, 2, 'default.jpg', 'Sand (1 cubic yard)', 'Default Supplier', 'Fine aggregate sand for various construction applications', 'Yes', 40.00, 150, 'cubic yard', 0.12, 1088.62),
    (14, 2, 'default.jpg', 'Brick (Standard)', 'Default Supplier', 'Standard clay bricks for construction', 'Yes', 0.50, 500, 'pcs', 0.12, 2.5),
    (15, 2, 'default.jpg', 'Wood Studs (8 feet)', 'Default Supplier', 'Standard wood studs for framing walls', 'Yes', 3.00, 300, '8 feet', 0.12, 3.62874),
    (16, 2, 'default.jpg', 'Galvanized Nails (5 lbs)', 'Default Supplier', 'Galvanized nails for various construction applications', 'Yes', 10.00, 100, 'lbs', 0.12, 2.26796),
    (17, 2, 'default.jpg', 'Drywall (4x8 feet)', 'Default Supplier', 'Drywall sheets for interior wall finishing', 'Yes', 12.00, 200, 'sheet', 0.12, 22.6796),
    (18, 2, 'default.jpg', 'Concrete Mix (50 lb)', 'Default Supplier', 'Pre-mixed concrete for small-scale construction projects', 'Yes', 8.00, 150, 'lb', 0.12, 22.6796);

    INSERT INTO Categories (Category_Name) 
    VALUES 
        ('Tools'),
        ('Building Materials'),
        ('Art Supplies'),
        ('Safety Gear'),
        ('Paints and Chemicals');


    -- Dummy Sales Data for 2022
    INSERT INTO `sales` (`SaleDate`, `SalePreference`, `ShippingFee`, `PaymentMode`, `TotalAmount`, `EmployeeID`, `CustomerID`) 
    VALUES 
        ('2022-01-15 10:30:00', 'Delivery', 10.00, 'Cash', 150.00, 1, 1),
        ('2022-02-05 14:45:00', 'Pick-up', 0.00, 'Card', 250.00, 2, 2),
        ('2022-03-20 11:00:00', 'Delivery', 20.00, 'Cash', 180.00, 3, 3),
        ('2022-04-10 09:15:00', 'Delivery', 15.00, 'Cash', 200.00, 1, 1),
        ('2022-05-22 13:00:00', 'Pick-up', 0.00, 'Cash', 300.00, 2, 2),
        ('2022-06-08 16:30:00', 'Delivery', 25.00, 'Card', 350.00, 3, 3),
        ('2022-07-14 10:00:00', 'Delivery', 10.00, 'Cash', 180.00, 1, 1),
        ('2022-08-29 12:45:00', 'Pick-up', 0.00, 'Cash', 270.00, 2, 2),
        ('2022-09-05 15:20:00', 'Delivery', 20.00, 'Card', 400.00, 3, 3),
        ('2022-10-18 09:30:00', 'Delivery', 15.00, 'Cash', 220.00, 1, 1),
        ('2022-11-25 11:45:00', 'Pick-up', 0.00, 'Cash', 280.00, 2, 2),
        ('2022-12-30 14:00:00', 'Delivery', 25.00, 'Card', 320.00, 3, 3);

    -- Dummy Target Sales Data for 2022
    INSERT INTO `targetsales` (`MonthYear`, `TargetAmount`, `EmployeeID`) 
    VALUES 
        ('2022-01-01', 5000.00, 1),
        ('2022-02-01', 6000.00, 2),
        ('2022-03-01', 7000.00, 3),
        ('2022-04-01', 5500.00, 1),
        ('2022-05-01', 6500.00, 2),
        ('2022-06-01', 7500.00, 3),
        ('2022-07-01', 6000.00, 1),
        ('2022-08-01', 7000.00, 2),
        ('2022-09-01', 8000.00, 3),
        ('2022-10-01', 6000.00, 1),
        ('2022-11-01', 6500.00, 2),
        ('2022-12-01', 7500.00, 3);

    -- Dummy Sales Data for 2023
    INSERT INTO `sales` (`SaleDate`, `SalePreference`, `ShippingFee`, `PaymentMode`, `TotalAmount`, `EmployeeID`, `CustomerID`) 
    VALUES 
        ('2023-01-15 10:30:00', 'Delivery', 10.00, 'Cash', 200.00, 1, 1),
        ('2023-02-05 14:45:00', 'Pick-up', 0.00, 'Card', 300.00, 2, 2),
        ('2023-03-20 11:00:00', 'Delivery', 20.00, 'Cash', 250.00, 3, 3),
        ('2023-04-10 09:15:00', 'Delivery', 15.00, 'Cash', 350.00, 1, 1),
        ('2023-05-22 13:00:00', 'Pick-up', 0.00, 'Cash', 400.00, 2, 2),
        ('2023-06-08 16:30:00', 'Delivery', 25.00, 'Card', 450.00, 3, 3),
        ('2023-07-14 10:00:00', 'Delivery', 10.00, 'Cash', 300.00, 1, 1),
        ('2023-08-29 12:45:00', 'Pick-up', 0.00, 'Cash', 350.00, 2, 2),
        ('2023-09-05 15:20:00', 'Delivery', 20.00, 'Card', 500.00, 3, 3),
        ('2023-10-18 09:30:00', 'Delivery', 15.00, 'Cash', 400.00, 1, 1),
        ('2023-11-25 11:45:00', 'Pick-up', 0.00, 'Cash', 450.00, 2, 2),
        ('2023-12-30 14:00:00', 'Delivery', 25.00, 'Card', 500.00, 3, 3);

    -- Dummy Target Sales Data for 2023
    INSERT INTO `targetsales` (`MonthYear`, `TargetAmount`, `EmployeeID`) 
    VALUES 
        ('2023-01-01', 6000.00, 1),
        ('2023-02-01', 7000.00, 2),
        ('2023-03-01', 8000.00, 3),
        ('2023-04-01', 6500.00, 1),
        ('2023-05-01', 7500.00, 2),
        ('2023-06-01', 8500.00, 3),
        ('2023-07-01', 7000.00, 1),
        ('2023-08-01', 8000.00, 2),
        ('2023-09-01', 9000.00, 3),
        ('2023-10-01', 7000.00, 1),
        ('2023-11-01', 7500.00, 2),
        ('2023-12-01', 8500.00, 3);

    -- Dummy Sales Data for 2024
    INSERT INTO `sales` (`SaleDate`, `SalePreference`, `ShippingFee`, `PaymentMode`, `TotalAmount`, `EmployeeID`, `CustomerID`) 
    VALUES 
        ('2024-01-15 10:30:00', 'Delivery', 10.00, 'Cash', 210.00, 1, 1),
        ('2024-02-05 14:45:00', 'Pick-up', 0.00, 'Card', 310.00, 2, 2),
        ('2024-03-20 11:00:00', 'Delivery', 20.00, 'Cash', 260.00, 3, 3);

    -- Dummy Target Sales Data for 2024
    INSERT INTO `targetsales` (`MonthYear`, `TargetAmount`, `EmployeeID`) 
    VALUES 
        ('2024-01-01', 6100.00, 1),
        ('2024-02-01', 7100.00, 2),
        ('2024-03-01', 8100.00, 3);

    -- Adjust TotalAmount for each sale to be close to or above the target sales
    UPDATE `sales` s
    JOIN (
        SELECT 
            ts.`EmployeeID`,
            ts.`MonthYear`,
            ts.`TargetAmount`,
            SUM(s.`TotalAmount`) AS `TotalSalesAmount`
        FROM 
            `targetsales` ts
        LEFT JOIN 
            `sales` s ON ts.`EmployeeID` = s.`EmployeeID`
        GROUP BY 
            ts.`EmployeeID`, ts.`MonthYear`, ts.`TargetAmount`
    ) t ON s.`EmployeeID` = t.`EmployeeID`
    SET 
        s.`TotalAmount` = CASE 
            WHEN t.`TotalSalesAmount` < t.`TargetAmount` THEN s.`TotalAmount` + (t.`TargetAmount` - t.`TotalSalesAmount`)
            ELSE s.`TotalAmount`
        END;