--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Toys'),(2,'Car Parts'),(3,'Clothing');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `featured_products`
--

LOCK TABLES `featured_products` WRITE;
/*!40000 ALTER TABLE `featured_products` DISABLE KEYS */;
INSERT INTO `featured_products` VALUES (1,21);
/*!40000 ALTER TABLE `featured_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Among Us Impostor','Among Us Impostor with tongue out attempting to attack among us crewmate toy for kids age 3 to 12',4999,1,1),(2,'LEGO Upscaled-Minifig','Large scale LEGO Minifig to build for ages 10+',6999,1,1),(21,'Among Us Tshirt','NO WAY FILE UPLOADING WORKS EZ EZ EZ EZ EZ EZ',7999,3,1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$w20uIj3eayEm0Yi.YT5cJeEL2mTF6odbeaaJ54oZK1Q8b5Aa3wrcO',1),(3,'lynith','$2y$10$K.18arEJ5bOe6/OLkWsr0.30AaNXXBCj5GYG.POYyMjIOvlZfvbWy',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
