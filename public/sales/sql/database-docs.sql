-- Products Table
CREATE TABLE IF NOT EXISTS Products (
    ProductID INT AUTO_INCREMENT PRIMARY KEY,
    ProductName VARCHAR(255),
    Description TEXT,
    Category VARCHAR(100),
    DeliveryRequired ENUM('Yes', 'No') DEFAULT 'No',
    Price DECIMAL(10, 2),
    Stocks INT,
    TaxRate DECIMAL(5, 2) DEFAULT 0 
);

-- Customers Table
CREATE TABLE IF NOT EXISTS Customers (
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(100),
    LastName VARCHAR(100),
    Phone VARCHAR(20),
    Email VARCHAR(100)
);

-- Employees Table
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
    UnitPrice DECIMAL(10, 2),
    FOREIGN KEY (SaleID) REFERENCES Sales(SaleID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);

-- DeliveryOrders Table
CREATE TABLE IF NOT EXISTS DeliveryOrders (
    DeliveryOrderID INT AUTO_INCREMENT PRIMARY KEY,
    SaleID INT,  
    ProductID INT,
    Quantity INT,
    DeliveryAddress TEXT,
    DeliveryDate DATE,
    ReceivedDate DATE,  
    DeliveryStatus ENUM('Pending', 'In Transit', 'Delivered') DEFAULT 'Pending',
    FOREIGN KEY (SaleID) REFERENCES Sales(SaleID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);

-- Inserting sample data into Products table
INSERT INTO Products (ProductName, Description, Category, DeliveryRequired, Price, Stocks, TaxRate) 
VALUES 
    ('Hammer', 'Heavy-duty hammer for construction work', 'Tools', 'No', 299.00, 50, 0.12),
    ('Screwdriver Set', 'Set of 6 screwdrivers with various sizes', 'Tools', 'No', 199.00, 30, 0.12),
    ('Cement', 'Portland cement for construction purposes', 'Building Materials', 'Yes', 220.00, 100, 0.12),
    ('Gravel', 'Crushed stone for construction projects', 'Building Materials', 'Yes', 500.00, 50, 0.12),
    ('Paint Brush Set', 'Set of 10 paint brushes for art projects', 'Art Supplies', 'No', 99.00, 20, 0.12),
    ('Safety Helmet', 'Hard hat helmet for construction safety', 'Safety Gear', 'No', 150.00, 40, 0.12),
    ('Drill Machine', 'Cordless drill machine with rechargeable batteries', 'Tools', 'No', 599.00, 15, 0.12),
    ('Plywood', 'Plywood sheets for carpentry and construction', 'Building Materials', 'Yes', 600.00, 30, 0.12),
    ('Steel Bar', 'Deformed steel bars for reinforcement in concrete construction', 'Building Materials', 'Yes', 50.00, 200, 0.12),
    ('Paint Thinner', 'Solvent used for thinning oil-based paints and cleaning paint brushes', 'Paints and Chemicals', 'No', 150.00, 50, 0.12);


INSERT INTO `products` (`ProductID`, `ProductName`, `Description`, `Category`, `Size`, `Price`, `Quantity`) VALUES
(1, 'Hammer', 'Heavy-duty hammer for construction work', 'Tools', '', 999.00, 50),
(2, 'Screwdriver Set', 'Set of 6 screwdrivers with various sizes', 'Tools', '', 749.00, 30),
(3, 'Paint Brush Set', 'Set of 10 paint brushes for art projects', 'Art Supplies', '', 499.00, 20),
(4, 'Drill Machine', 'Cordless drill machine with rechargeable batteries', 'Tools', '', 2999.00, 15),
(5, 'Safety Helmet', 'Hard hat helmet for construction safety', 'Safety Gear', '', 1499.00, 40),
(6, 'Cement', 'Portland cement for construction purposes', 'Building Materials', '40 kg', 220.00, 100),
(7, 'Galvanized Iron (GI) Sheet', 'Galvanized iron sheet for roofing and siding', 'Building Materials', '8 ft x 4 ft', 450.00, 50),
(8, 'Plywood', 'Plywood sheets for carpentry and construction', 'Building Materials', '8 ft x 4 ft', 600.00, 30),
(9, 'Steel Bar', 'Deformed steel bars for reinforcement in concrete construction', 'Building Materials', '6 meters', 50.00, 200),
(10, 'Paint Thinner', 'Solvent used for thinning oil-based paints and cleaning paint brushes', 'Paints and Chemicals', '', 150.00, 50),
(11, 'Wrench Set', 'Set of 6 wrenches for various mechanical tasks', 'Tools', '', 899.00, 25),
(12, 'Utility Knife', 'Multipurpose utility knife for cutting tasks', 'Tools', '', 299.00, 40),
(13, 'Adjustable Pliers', 'Set of 6 adjustable pliers for gripping and turning nuts and bolts', 'Tools', '', 699.00, 20),
(14, 'Paint Roller', 'High-quality paint roller for smooth application of paint', 'Art Supplies', '', 199.00, 35),
(15, 'Sketch Pad', 'Sketch pad for drawing and sketching', 'Art Supplies', '', 99.00, 50),
(16, 'Canvas Set', 'Set of 6 canvases for painting', 'Art Supplies', '', 599.00, 15),
(17, 'Safety Vest', 'High-visibility safety vest for construction sites', 'Safety Gear', '', 299.00, 30),
(18, 'Safety Goggles', 'Protective safety goggles for eye protection', 'Safety Gear', '', 149.00, 45),
(19, 'Safety Gloves', 'Durable safety gloves for hand protection', 'Safety Gear', '', 199.00, 20),
(20, 'Roofing Nails', 'Box of 1000 roofing nails for securing roofing materials', 'Building Materials', '', 99.00, 100),
(21, 'Concrete Blocks', 'Set of 6 concrete blocks for construction', 'Building Materials', '', 799.00, 10),
(22, 'Sandpaper Set', 'Set of 6 sandpapers for sanding wood and metal surfaces', 'Building Materials', '', 149.00, 25),
(23, 'Acrylic Paint Set', 'Set of 6 acrylic paint tubes for painting projects', 'Paints and Chemicals', '', 399.00, 30),
(24, 'Brush Cleaner', 'Solvent for cleaning paint brushes and other painting tools', 'Paints and Chemicals', '', 249.00, 20),
(25, 'Paint Tray', 'Paint tray for holding paint during painting tasks', 'Paints and Chemicals', '', 99.00, 40);


