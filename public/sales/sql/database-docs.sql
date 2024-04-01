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

-- Assuming the categories already exist in the Categories table
-- You should adjust the following INSERT statements according to the Category_ID values in your Categories table

    INSERT INTO Products (Supplier_ID, Category_ID, ProductImage, ProductName, Supplier, Description, DeliveryRequired, Price, Stocks, UnitOfMeasurement, TaxRate, ProductWeight) 
    VALUES 
    (1, 1, 'hammer_large.jpg', 'Hammer (Large)', 'Supplier A', 'Heavy-duty hammer for construction work', 'No', 299.00, 50, 'pcs', 0.12, 1.5),
    (2, 1, 'screwdriver_set_standard.jpg', 'Screwdriver Set (Standard)', 'Supplier B', 'Set of 6 screwdrivers with various sizes', 'No', 199.00, 30, 'set', 0.12, 0.8),
    (3, 2, 'cement_50kg.jpg', 'Cement (50kg)', 'Supplier C', 'Portland cement for construction purposes', 'Yes', 220.00, 100, 'kg', 0.12, 50),
    (4, 2, NULL, 'Gravel (1 ton)', NULL, 'Crushed stone for construction projects', 'Yes', 500.00, 50, 'ton', 0.12, 907.185),
    (5, 3, NULL, 'Paint Brush Set', NULL, 'Set of 10 paint brushes for art projects', 'No', 99.00, 20, 'set', 0.12, 0.5),
    (6, 4, NULL, 'Safety Helmet', NULL, 'Hard hat helmet for construction safety', 'No', 150.00, 40, 'pcs', 0.12, 0.3),
    (7, 1, NULL, 'Drill Machine', NULL, 'Cordless drill machine with rechargeable batteries', 'No', 599.00, 15, 'pcs', 0.12, 2),
    (8, 2, NULL, 'Plywood (4x8 feet)', NULL, 'Plywood sheets for carpentry and construction', 'Yes', 600.00, 30, 'sheet', 0.12, 20),
    (9, 2, NULL, 'Steel Bar (1 meter)', NULL, 'Deformed steel bars for reinforcement in concrete construction', 'Yes', 50.00, 200, 'meter', 0.12, 2.5),
    (10, 5, NULL, 'Paint Thinner', NULL, 'Solvent used for thinning oil-based paints and cleaning paint brushes', 'No', 150.00, 50, NULL, 0.12, 1),
    (11, 2, NULL, 'Concrete Blocks (Standard)', NULL, 'Standard concrete blocks for building walls', 'Yes', 5.00, 200, 'pcs', 0.12, 2.3),
    (12, 2, NULL, 'Roofing Shingles (Bundle)', NULL, 'Bundle of roofing shingles for covering roofs', 'Yes', 25.00, 100, 'bundle', 0.12, 13.6078),
    (13, 2, NULL, 'Sand (1 cubic yard)', NULL, 'Fine aggregate sand for various construction applications', 'Yes', 40.00, 150, 'cubic yard', 0.12, 1088.62),
    (14, 2, NULL, 'Brick (Standard)', NULL, 'Standard clay bricks for construction', 'Yes', 0.50, 500, 'pcs', 0.12, 2.5),
    (15, 2, NULL, 'Wood Studs (8 feet)', NULL, 'Standard wood studs for framing walls', 'Yes', 3.00, 300, '8 feet', 0.12, 3.62874),
    (16, 2, NULL, 'Galvanized Nails (5 lbs)', NULL, 'Galvanized nails for various construction applications', 'Yes', 10.00, 100, 'lbs', 0.12, 2.26796),
    (17, 2, NULL, 'Drywall (4x8 feet)', NULL, 'Drywall sheets for interior wall finishing', 'Yes', 12.00, 200, 'sheet', 0.12, 22.6796),
    (18, 2, NULL, 'Concrete Mix (50 lb)', NULL, 'Pre-mixed concrete for small-scale construction projects', 'Yes', 8.00, 150, 'lb', 0.12, 22.6796);

    INSERT INTO Categories (Category_Name) 
    VALUES 
        ('Tools'),
        ('Building Materials'),
        ('Art Supplies'),
        ('Safety Gear'),
        ('Paints and Chemicals');
