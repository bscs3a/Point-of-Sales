-- Products Table
CREATE TABLE Products (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    ProductName VARCHAR(100),
    Description VARCHAR(255),
    Category VARCHAR(50),
    DeliveryRequired VARCHAR(3),
    Price DECIMAL(10, 2),
    Stocks INT,
    UnitOfMeasurement VARCHAR(20),
    TaxRate DECIMAL(5, 2),
    ProductWeight DECIMAL(10, 2)
);

-- Customers Table
CREATE TABLE IF NOT EXISTS Customers (
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(100),
    LastName VARCHAR(100),
    Phone VARCHAR(20),
    Email VARCHAR(100)
);

-- Employees Table -- Filler onLy
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

-- Trucks Table
CREATE TABLE IF NOT EXISTS Trucks (
    TruckID INT AUTO_INCREMENT PRIMARY KEY,
    PlateNumber VARCHAR(20),
    TruckType ENUM('Light-Duty', 'Heavy-Duty'),
    Capacity DECIMAL(10, 2)
    TruckStatus ENUM('Available', 'In Transit', 'Unavailable') DEFAULT 'Available'
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
    DeliveryStatus ENUM('Pending', 'In Transit', 'Delivered', 'Not Delivered') DEFAULT 'Pending',
    TruckID INT,
    FOREIGN KEY (SaleID) REFERENCES Sales(SaleID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID),
    FOREIGN KEY (TruckID) REFERENCES Trucks(TruckID)
);

INSERT INTO Products (ProductName, Description, Category, DeliveryRequired, Price, Stocks, TaxRate, UnitOfMeasurement, ProductWeight) 
VALUES 
    ('Hammer (Large)', 'Heavy-duty hammer for construction work', 'Tools', 'No', 299.00, 50, 0.12, 'pcs', 1.5),
    ('Screwdriver Set (Standard)', 'Set of 6 screwdrivers with various sizes', 'Tools', 'No', 199.00, 30, 0.12, 'set', 0.3,)
    ('Cement (50kg)', 'Portland cement for construction purposes', 'Building Materials', 'Yes', 220.00, 100, 0.12, 'kg', 50),
    ('Gravel (1 ton)', 'Crushed stone for construction projects', 'Building Materials', 'Yes', 500.00, 50, 0.12, 'ton', 907.185),  -- Converted 1 ton to kg
    ('Paint Brush Set', 'Set of 10 paint brushes for art projects', 'Art Supplies', 'No', 99.00, 20, 0.12, 'set', 0.5),
    ('Safety Helmet', 'Hard hat helmet for construction safety', 'Safety Gear', 'No', 150.00, 40, 0.12, 'pcs', 0.3),
    ('Drill Machine', 'Cordless drill machine with rechargeable batteries', 'Tools', 'No', 599.00, 15, 0.12, 'pcs', 2),
    ('Plywood (4x8 feet)', 'Plywood sheets for carpentry and construction', 'Building Materials', 'Yes', 600.00, 30, 0.12, 'sheet', 20),
    ('Steel Bar (1 meter)', 'Deformed steel bars for reinforcement in concrete construction', 'Building Materials', 'Yes', 50.00, 200, 0.12, 'meter', 2.5),
    ('Paint Thinner', 'Solvent used for thinning oil-based paints and cleaning paint brushes', 'Paints and Chemicals', 'No', 150.00, 50, 0.12, NULL, 1),
    ('Concrete Blocks (Standard)', 'Standard concrete blocks for building walls', 'Building Materials', 'Yes', 5.00, 200, 0.12, 'pcs', 2.3),
    ('Roofing Shingles (Bundle)', 'Bundle of roofing shingles for covering roofs', 'Building Materials', 'Yes', 25.00, 100, 0.12, 'bundle', 13.6078),  -- Converted 30 lbs to kg
    ('Sand (1 cubic yard)', 'Fine aggregate sand for various construction applications', 'Building Materials', 'Yes', 40.00, 150, 0.12, 'cubic yard', 1088.62),  -- Converted 1 cubic yard to kg
    ('Brick (Standard)', 'Standard clay bricks for construction', 'Building Materials', 'Yes', 0.50, 500, 0.12, 'pcs', 2.5),
    ('Wood Studs (8 feet)', 'Standard wood studs for framing walls', 'Building Materials', 'Yes', 3.00, 300, 0.12, '8 feet', 3.62874),  -- Converted 8 lbs to kg
    ('Galvanized Nails (5 lbs)', 'Galvanized nails for various construction applications', 'Building Materials', 'Yes', 10.00, 100, 0.12, 'lbs', 2.26796),  -- Converted 5 lbs to kg
    ('Drywall (4x8 feet)', 'Drywall sheets for interior wall finishing', 'Building Materials', 'Yes', 12.00, 200, 0.12, 'sheet', 22.6796),  -- Converted 50 lbs to kg
    ('Concrete Mix (50 lb)', 'Pre-mixed concrete for small-scale construction projects', 'Building Materials', 'Yes', 8.00, 150, 0.12, 'lb', 22.6796);  -- Converted 50 lbs to kg

INSERT INTO trucks (TruckType, PlateNumber) VALUES ('Light-Duty', 'ALD123');
INSERT INTO trucks (TruckType, PlateNumber) VALUES ('Light-Duty', 'DUY234');
INSERT INTO trucks (TruckType, PlateNumber) VALUES ('Light-Duty', 'VRR125');

INSERT INTO trucks (TruckType, PlateNumber) VALUES ('Heavy-Duty', 'DJD233');
INSERT INTO trucks (TruckType, PlateNumber) VALUES ('Heavy-Duty', 'PGD994');
INSERT INTO trucks (TruckType, PlateNumber) VALUES ('Heavy-Duty', 'UHD535');


UPDATE deliveryorders
SET DeliveryStatus = 'Pending',
    ReceivedDate = NULL,
    TruckID = NULL;