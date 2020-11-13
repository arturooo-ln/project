CREATE TABLE `admin` (
  `adminId` int(10) NOT NULL,
  `adminUsername` varchar(25) NOT NULL,
  `adminPassword` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `admin` (`adminId`, `adminUsername`, `adminPassword`) VALUES
(1,'admin', '0192023a7bbd73250516f069df18b500');
CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userFirstName` varchar(50) NOT NULL,
  `userLastName` varchar(50) NOT NULL,
  `userPhone` varchar(20) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userPassword` varchar(50) NOT NULL,
  `userActivation` varchar(250) NOT NULL,
  `userStatus` enum('not verified','verified') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `brand` (
  `brandId` int(11) NOT NULL,
  `brandName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `category` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `orderDetail` (
  `orderId` int(10) NOT NULL,
  `userId` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `adres` varchar(50) NOT NULL,
  `postalCode` int(10) NOT NULL,
  `city` varchar(50) NOT NULL,
  `voivodeship` varchar(50) NOT NULL,
  `cardName` varchar(50) NOT NULL,
  `cardNumber` varchar(20) NOT NULL,
  `cardCode` int(3) NOT NULL,
  `productQuantity` int(15) DEFAULT NULL,
  `totalPrice` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `product` (
  `productId` int(11) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `productBrand` varchar(50) NOT NULL,
  `productCategory` varchar(50) NOT NULL,
  `productTitle` varchar(50) NOT NULL,
  `productPrice` varchar(50) NOT NULL,
  `productDiscription` varchar(50) NOT NULL,
  `productImage` BLOB NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminId`);
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brandId`);
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryId`);
ALTER TABLE `orderDetail`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `users` (`userId`);
ALTER TABLE `product`
  ADD PRIMARY KEY (`productId`);
  
  
ALTER TABLE `admin`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `brand`
  MODIFY `brandId` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `category`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `orderDetail`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `product`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
  