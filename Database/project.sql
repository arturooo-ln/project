CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userPassword` varchar(50) NOT NULL,
  `userFirstName` varchar(50) NOT NULL,
  `userLastName` varchar(50) NOT NULL,
  `userPhone` varchar(20) NOT NULL,
  `userSreet` varchar(50) NOT NULL,
  `userCity` varchar(50) NOT NULL,
  `userZip` varchar(50) NOT NULL,
  `userProvince` varchar(50) NOT NULL,
  `userActivation` varchar(250) NOT NULL,
  `userStatus` enum('not verified','verified') NOT NULL,
  `admin` enum('admin','user') NOT NULL
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
  `paymentStatus` int(11) NOT NULL,
  `userFirstName` varchar(50) NOT NULL,
  `userLastName` varchar(50) NOT NULL,
  `userPhone` varchar(20) NOT NULL,
  `userSreet` varchar(50) NOT NULL,
  `userCity` varchar(50) NOT NULL,
  `userZip` varchar(50) NOT NULL,
  `userProvince` varchar(50) NOT NULL,
  `date_order` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `orderProduct` (
  `orderId` int(10) NOT NULL,
  `orderproductId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `productQuantity` int(15) DEFAULT NULL,
  `productPrice` int(15) NOT NULL,
  `totalPrice` float(15) DEFAULT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `orderPayment` (
  `paymentId` int(10) NOT NULL,
  `orderId` int(10) NOT NULL,
  `userId` int(11) NOT NULL,
  `cardName` varchar(50) NOT NULL,
  `cardNumber` int(20) NOT NULL,
  `cardCode` int(3) NOT NULL,
  `status` enum('zatwierdzono','niezatwierdzono') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `product` (
  `productId` int(11) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `productBrand` varchar(50) NOT NULL,
  `productCategory` varchar(50) NOT NULL,
  `productTitle` varchar(50) NOT NULL,
  `productPrice` float NOT NULL,
  `productDiscription` text NOT NULL,
  `productQuantity` int(10) NOT NULL,
  `productImage` text NOT NULL,
  `productDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

ALTER TABLE `orderPayment`
  ADD PRIMARY KEY (`paymentId`),
  ADD KEY `orderProduct` (`orderId`),
  ADD KEY `users` (`userId`);

ALTER TABLE `orderProduct`
  ADD PRIMARY KEY (`orderproductId`),
  ADD KEY `orderDetail` (`orderId`),
  ADD KEY `product` (`productId`);
  
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
  
  ALTER TABLE `orderPayment`
  MODIFY `paymentId` int(11) NOT NULL AUTO_INCREMENT;
  
  ALTER TABLE `orderProduct`
  MODIFY `orderproductId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
  
