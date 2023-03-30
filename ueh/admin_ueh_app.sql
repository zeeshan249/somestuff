-- MariaDB dump 10.19  Distrib 10.5.10-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: admin_ueh_app
-- ------------------------------------------------------
-- Server version	10.5.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `admin_ueh_app`
--
DROP TABLE IF EXISTS `cams_user_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cams_user_login` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_mobile` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_normal` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cams_user_login`
--

LOCK TABLES `cams_user_login` WRITE;
/*!40000 ALTER TABLE `cams_user_login` DISABLE KEYS */;
INSERT INTO `cams_user_login` VALUES (1,'1','$2y$10$oR2IhFSnvR.dyi.uZQ3X5OvwZ8MILm/rGOKxDSF270CBedTTziCvq','70878'),(2,'2','$2y$10$gGfDnLHGiLS5pTPw9QREPedQkx.LZ0d.JIPmQu8FOuRTcw9Covxyq','29379'),(3,'3','$2y$10$bKpF1Dld82Vgh1/Vvjermu1UPa7gwQOadRX3i7EHP1yr7Vy9IZJs6','57780'),(4,'4','$2y$10$MigjtciOdr37A.qFDwPLxubmBt.k2I/7u85IbPJS9gzRn79/NEAfq','47582'),(5,'5','$2y$10$lP0CR6L93huGZiY6hmFD3e2Y8P9tTA/q99DH6//tIY/YJUAplOzQu','74284'),(6,'6','$2y$10$gBQ/Z9DOFhg5k9a8TL23bu77Q3qAtGXXWO8LZQzZnBEmcgFpriKIG','79485'),(7,'7','$2y$10$5zf46x3FStrd6VAQ8x0Tr.VbrtWY8mv7rQJqPg6Pk3N1WT.QWI6zW','26286'),(8,'8','$2y$10$44T.yP/glheAFThR64ObhOdoZ0wJw89rcO3eFSr8kybaO/08pSPXe','84486'),(9,'9','$2y$10$cc97DangdegNuzoOzFXhg.r7siugW7m7mVhHev5N706kFS7yru5ii','62188'),(10,'10','$2y$10$DnCdb7pAue1aO4q/WQoaNuDAQQX7HxI0djr6sSF6pdbS1i.eTazkO','85689'),(11,'11','$2y$10$5W/RqiiJ1jevSDLyfG6xg./lRoSCkKoVAzDay.5LzVad82a06kd4e','66590'),(12,'12','$2y$10$3ntiwlqsEHw6vMcnyGQYiOBqhT51c/p6KuBQiVlXEw32hwgtTwXP6','45390'),(13,'13','$2y$10$Vro9e.a6xgJ5qKPf7nGFq.W2mKmlJQVkxP.g..645G.iPuLFZui.6','90192'),(14,'14','$2y$10$z7/Th9FG1squsUI6TR2Zfeqr0D3yGDnHCNqCzXp/xB.dbOS81rwpS','23293'),(15,'15','$2y$10$TrtW1icHHV5MF2fY3CvD7.A6kddSacRq6Gj0pYmNgb1lbTpHUivD.','69794'),(16,'16','$2y$10$tQDE2FOgMmSqmzZlCvefdegSbzH9cH3.YDQavV9tpx6pVdtZu5Deq','39095'),(17,'17','$2y$10$xqNqFGYMtgkBwa/EeLgR3O6/DrdWgNtSWlDdspzpVQAe9N3EP9/Wu','75296'),(18,'18','$2y$10$1rqDOiRJaz7oFJw8337Pg.5d1AfU3SAbtfFAS8BADe9audx.H3Hzy','18797'),(19,'19','$2y$10$GGVvMZo7DG5UHoNV2lC2OefJhBxtm5U2pUNc5GiI1.2IKur7MM4A6','98098'),(20,'20','$2y$10$WWKlbFuPSwLfno0a.TnzWOinwVddcWAW3VwPykJBamttsIp0QJ7jS','56899'),(21,'21','$2y$10$MV5z6heHBhDCONyOVOKF1OeN7NXe30Rbq14pebMTlp0EOZG/qlF4e','46800'),(22,'22','$2y$10$LQwUBYZIzqo09cCMqCoBPuDZ0eRdxhE5MNgGIeOO42zH/V8rLBwXG','44601'),(23,'23','$2y$10$lOJ4NE2BOfVyFP4rqSMqjeUwW3VBgq2hT27y628yTBg0LZZ9BuT0O','84402'),(24,'24','$2y$10$iSj.tjx6lcgAskMIRVTyEejqyukgkwaBQZGdioo.lBOz8FqcEqPhW','25303'),(25,'25','$2y$10$QV177zJa5t7PDv5cBK6myelP5T7ZSLVedwQScOJwEzgP6JMZviV4y','25004'),(26,'26','$2y$10$y3cQpkk2mSefdUH9TQwlwun0XFeOoROkC7pSO4tOFLYWL5dgTtAg.','56978'),(27,'27','$2y$10$PXbLnijznZmFfrvrp04S9uriKH/aC88InxmMloYi3vp8zk8.U7vVe','11507'),(28,'28','$2y$10$RCEsT0qt1H9uwC2ym/dyQeQj.P/xRaiknQE1zr0FNXJtwznUYbJQe','93608'),(29,'29','$2y$10$FXpPlRiIQp.TX3/7vyL/cuufepHda2Xxt/zQrrPRfbtA6n3.9RXxm','92509'),(30,'30','$2y$10$HAzQ7n2r.dTl4vozaqYyYeL9..9D/nifjmmrmEpbSJ9G0.BCVX/Em','30110'),(31,'31','$2y$10$wEiLJGEkB5yX1MZRyl5HfObr/7T.hUP2M2QYuNurQnjtRB6cg6/PS','94511'),(32,'32','$2y$10$sGwIo1Z7EoeIY.ve7Raocuh.pVUOIYA1Mv1/hF1iUvXyv6wMIDUEu','14812'),(33,'33','$2y$10$rpIxvKSEcg1dzM2dakh5AeDVRFxhuWHIluQnPQYX3sXUSGR4AOLya','37713'),(34,'34','$2y$10$DNYemgHkJi3wEBFmLWzZ2uxMbttDYYsNdwmrp8jTvaOdAszB8gANG','28114'),(35,'35','$2y$10$H78X3qGvAvtoX/vvDqxJSOZIT7pwEuDIMtqKPvUtwHMcdizTOfkRi','47615'),(36,'36','$2y$10$UU1dS9s6yHU.SSw/6AxfReCq2.jrvv3f/1VVEpmw1i.zhGoGAl9ty','19716'),(37,'37','$2y$10$kk5JL58WsoTFwSo/BMg09.kP6WZviSByFSEyqIuT7k8W/EUuZIjsa','80917'),(38,'38','$2y$10$zPqmeR4yHuF1M195T1jLz.M.PfYSu2GeQWkiEjmN3Tn/SID.hbI.i','64718'),(39,'39','$2y$10$/a6UKlMP95ShlEdILV5QS.Cq6qeyzx/zV1hPGDuyIXTESOhVElD0C','16019'),(40,'40','$2y$10$bNwBJMdbXPBKh2vndB.klOIsgRXeJKs.kAtRMQCATzY0ULgChqfJS','52220'),(41,'41','$2y$10$R84VhnvNv/N9kEEJuhKJ1.7YIpbb/pohTPrekqUx.Du0boYs1o3iq','76051'),(42,'42','$2y$10$cXui02LhQ4uPeg2T3075LevDSNsfHSpYSoydHfZfGQmxDjTzG9YAu','58652'),(43,'43','$2y$10$ucaUOVgYNoe0Nh9bdaK50um2M2kVjO8A33DBP3ffH/LSqE6ISx742','19854'),(44,'44','$2y$10$dZVUTXfxhG4epc0yxTbyXeHxh/NmKZDDsWAgLtSQ/bQxHe2ZDuRPa','33555'),(45,'45','$2y$10$QBpmuP7ZWTkQpGBg4DdN8u1uq36jGl.AOhkf3ZXsTAVku5P6zyWxG','81155'),(46,'46','$2y$10$8d4sYYUJ/fVtLon2jS9Gnebv570bswM/0lZO8n9KnbPR9lsZBgABa','51156'),(47,'47','$2y$10$bLZrwXq4h44ediCEwX0De.Lxs9vyRZItDsOVkfULasknnOu/j9HAa','61957'),(48,'48','$2y$10$JZpT01XQEd/x16I7xXjxB.ZkppJXsSAz8NXklgLvhfp87Po7gajb6','30858'),(49,'49','$2y$10$hMaiZMn5xWtHs1jz4/i2leFrtkuuC7kXdjzCCg0hOM.MyTM7caagq','62259'),(50,'50','$2y$10$WMzTtT2kpAiLplc3iBr2..hQLJ0RACYcES2.dOhiWpkHnBfGEGKmS','26560'),(51,'51','$2y$10$rm5iw9J2e9BME3ar1xxmluPpqJBBpWfqJR3nnznq.XhVe/x/QTBHO','49261'),(52,'52','$2y$10$BO5kE9zsXBYbJe/lYVtj9e9XoHqNSiQSF/b1sJDe84wSaITM4lTmq','61663'),(53,'53','$2y$10$lse5LWNmfe3wok9xE68e7.IiwtKwaNB4YIbrnysxLUGJhPCF6eyV6','42564'),(54,'54','$2y$10$QziGELA1LUEOES7p/sg7E.pgo7NVEEzYBHuVjT4vvWwy/gPTSZaEa','93865'),(55,'55','$2y$10$k9p2yWAAoOgRXvATEq4GW.u3np0CqayPzOWz0C5b4kCUxbfktzPNC','26565'),(56,'56','$2y$10$9wze1ePEScxp8N/n0beaQ.wDu2FP1g5TbFq8AFp5/5GzBl/1Lvwwm','98466'),(57,'57','$2y$10$EFpJd3vCPj5yrI.s30yDmeowIhgFCNMAd1aquq3xKnLobBomJsVxC','89067'),(58,'58','$2y$10$.sfb.VxIUhLqVxdaMdJdaOnaL4wvD2DT1M4SwzsG87gACQFewYn4e','78869'),(59,'59','$2y$10$Yg8zut9WJS21PZnveWv8O.14silZ7pt3cF2UxboMl3mMWXjhCwFTy','86970'),(60,'60','$2y$10$j12kQku/gUVV2Y2YNoVfxe/3g2NpIB6MZDOr0REmxBobeLSD.2vBe','94771'),(61,'61','$2y$10$KKRYvF8Y9rs70.yvemUuZuGeCPMzBY2kS/FYI4Jlk/vZuLN0JvTDm','44372'),(62,'62','$2y$10$o/.9r2.YHOXggzediQ42ZOTjLMv6P/wuEgAZAovC7qfF0L2TFSDT2','31073'),(63,'63','$2y$10$Y.MWbYpRhICgiiY2O5g/7e7MVl4Lcj7lsD91iLVie.l.JkRPq7jJu','18473'),(64,'64','$2y$10$D6T.zVYFzvOXwHxcEjw4FuVRVPRV0KQp/sp5gF/uAWZhRAuyjjFy2','61974'),(65,'65','$2y$10$bNH5rFnYHWHiqnNMqX7A/OEkvNZ1E63k4LDaL4Ngnp1O47ih5izb.','26476'),(66,'66','$2y$10$zsSQJZ5ZxBG9qYVKkKGkqOtb83H2Gvu2WIAx923qPTKjeAJsLKrTi','69477'),(67,'67','$2y$10$EBMR1ZnrAn1fMpujr/FdReiZZ8q1TCnkyOxzeDvPomGQ20YG2Ob2O','15778'),(68,'68','$2y$10$0moPXkJyB3t3Gj9jEKtLjOKqi.HcRZOQVasnB/Yr1F1MGt14THydW','56679'),(69,'69','$2y$10$FtLdlJM.hCTeA0SaEnLqxu4rg6L2avztwa56TZGTwlDlj3G8OlvyS','68880'),(70,'70','$2y$10$4BLtMMC0Ym5KBtLnnglQT.q.nkCWyK7DQEAobrRtlWcZyyL.ZPnfy','84081'),(71,'71','$2y$10$ZTjF0h3ojWm/lWor5U1q/e6YpwjqNzn6fWlKYAz/76NzP/Vx9qYyK','47782'),(72,'72','$2y$10$E7feJMTVhRZL002ldrinO.8rzzU.E.S2hBpc7g4bUcCIUqvwDFJgi','51783'),(73,'73','$2y$10$xz9EBr.KD6LJZQqQt0Sb8eKmT7xaQsLDW.Sqoe8P3SVZ8ueReRFSe','16084'),(74,'74','$2y$10$l2m2p33Fl6IawVczMRtHTuP.5JpxAJexH7gnqnscjKv/LNS42a9ly','98285'),(75,'75','$2y$10$apxia/ci2D65g04FXygAbuCrhTrNJGoz9v5Iyp2YDFffzkaa5OMm.','81786'),(76,'76','$2y$10$NFZEtvkDNE9erLcR0yJfCOG3K8na/flr6o.GhEP1boqbYWyHGZ24m','73088'),(77,'77','$2y$10$rmjBJvDw/pp6HUBgeXhCEexoLXJaPp15um3FRUyoB71QEPx/rn.ti','62289'),(78,'78','$2y$10$f.wxanfD6XLnWDo36tknMuheSy9P8GZy0shGisiCaoCpxZMdAKpEy','68790'),(79,'79','$2y$10$GmQySp1dODpIlaljeZh5XeNnj9KVQ96Dboa3/6xE5EAkHpBRWz4Z6','86191'),(80,'80','$2y$10$JfeUz8YN.FR6OyUnislEeeOcXulKZQ8tAKBNXr/5XO.MmeYI8WHJ2','33393'),(81,'81','$2y$10$6FSsj0NbdwlaFGyBfzdCzeqNZXZgkR7.CwpdBdshc4AuaEAWKBX4a','75501'),(82,'82','$2y$10$uEXPNbmzbb/J4YBYEc5WxuuxJdZWOHtR8EQiQYfjOpHAzQerGtOLC','42902'),(83,'83','$2y$10$kXhtSjOOrEhiO1t/nQhDouFcCwffaTc/oCCk0.kVQ0lbBe28iWfD2','12903'),(84,'84','$2y$10$JwZaSWg25zB.Uzf8VNZDQOi.YYHaUxBh.caKBs0L700IxMShUlnry','12103'),(85,'85','$2y$10$l7NrZylSbsIy2q5TDg75yeEVjY2rW5Ow9NvHA.2KUfgIIggOjtYiy','68004'),(86,'86','$2y$10$stX4eMcsaKZSeMg5/atxnu.dowHpcH5TTypS2KGvLrSpBbu0EGqGa','65005'),(87,'87','$2y$10$6aOhXyc6k/d9VbMAXUN0EeWOgMuhrwTIXenOW0U87eu8sqwD5VN7e','87106'),(88,'88','$2y$10$PWB9aI74eA6jCq8l7nipHercCszBnQ86XjTWX7Gm5jHa9bvGrFJG.','17707'),(89,'89','$2y$10$QG4MfsvWG.aFNWOQeHY99OJ0OHEJ6Cd7ndzRiLV3.PuA2IQ62T.Qy','10608'),(90,'90','$2y$10$1bMEbhUQiHb9d0HizwVsL.h4mbvN1AV5eEfwG5nQjEt1SzQ7iei0u','18909'),(91,'91','$2y$10$2OfuAcyuyTTe2epC8BVyGeFnxEXR1AeXE1PYoEjLkLNyxKMRUosGq','21611'),(92,'92','$2y$10$UZYGo2h7XX6ZOFHhB//RpenO/9QM2zy6c.iM6c6buhpuseguTdm5G','69112'),(93,'93','$2y$10$5YLuOQVvw2VVm8O1SKuJTeQfYLOYfPadaDElSxuXTZQPiOVRwJNAK','64712'),(94,'94','$2y$10$KOUcIZELMfMXTNVV.LqJXeu1pw3pO0P19Qb9y3PuSwy2CZD6sSrl6','80213'),(95,'95','$2y$10$zKD5vJgG1jxh126TXZCp9OIVJfWayXa1NqIr7BuTwKutXUgEOmi6O','56014'),(96,'96','$2y$10$P61PE29JhI6pMdzDJuNXr.FJB/fD/W195WyxAMk3whNFXYTx3zCLy','70815'),(97,'97','$2y$10$bWdCcL0rBBcuzs5Fw.8R3uPx.waG/8SBY5vMSY4Vith7urggnIe4i','87416'),(98,'98','$2y$10$7DOxYzllPuFQwUUjrz3ST.Vn8ZjJvQFvpmh.4JXjs.GfD8siv5jC.','76317'),(99,'99','$2y$10$HGCRYNsNgg06UIG9uNENXOp0S6xLyZXWPDbIPVGtWe.WJeJDU6/g.','70818'),(100,'100','$2y$10$5ZkaKgtN9jpLqC.fN3JuA.K7e9z0HJxUgaUpxoxPdQZU/Zfn7PQtW','33419'),(101,'101','$2y$10$gwfKeCYHT2lX5xTMnUl5cukijKRyZOak797S5ibyx0btdF0Y1G.9e','39620'),(102,'102','$2y$10$a8DEII.IB2Q34nEHWKy.7OMbpQnbGAuPhT6jqIo/7QiRb6ky/lbGa','49521'),(103,'103','$2y$10$3x/yZEPvx3zypoMRnHnk.eMoulB8AAQGQkwT6L4QMxWgd/gVY7xc2','49521'),(104,'104','$2y$10$.qzecD9VvE3uuiviooORS.bMrC6bO0neprgzAKGTD5W3FoLhD5VXm','45822'),(105,'105','$2y$10$3kZplqNxXeTYm/M.U0YiM.wDC9DS/xX98PbMlpK59c1YvVzX9o99y','86623'),(106,'106','$2y$10$IbbdR/aA6Vz037aDaSC4TuadjxggZJfNwlFory5dPaMb7y0fQSQDy','72824'),(107,'107','$2y$10$GzqTkz2sp1PEDIy.BKqRFOHk.2cPa/mEP0dAhZ5Dnst9wMyQxCZoG','25225'),(108,'108','$2y$10$C0REDg9bkOvLwqnmmJyYXuu3O7KHT0v9EtgMKZCuTIj0ukrj2teri','22126'),(109,'109','$2y$10$xWAwinoQjhh73sUE1aG27eIsWNA.jEo3OKxYInVw2mw6jiQjm/IVu','59427'),(110,'110','$2y$10$0U95ln4EFPt.aB1Kvp6kO.LRcWgldE8wGyGKAsp3ELbPaRFdlNWWa','75828'),(111,'111','$2y$10$kRuNmDJ84C7AffQga9VoS.a65HWiX6ClveMKMqvZdvD5EDyk3TIPm','39629'),(112,'112','$2y$10$c5Imq84pLeIfWvrP7BUh5ercGg54Q4fhrmoWiRM//SKhfvhIMna2G','57030'),(113,'113','$2y$10$F3WQ.TOTYDRzSxCW9w9L8unI6nhNDqIY9dxooE67M5cXk/jm8.OL2','88231'),(114,'114','$2y$10$pnFRBQBI770zmCxgatl.VeDbEfEbs1XAhU4bq7HCV/.xhO6cWwCV.','80132'),(115,'115','$2y$10$63kRskITZgYTcoy.fD5V3OIpQ7enR59Ua0S3khArq5NMxbHmWaD2q','40133'),(116,'116','$2y$10$dTcwZHxIz5tdQV16/Ya1Vui/cqoZ3ktpYn/v7b6yCH7flHQVmlv0G','57334'),(117,'117','$2y$10$a7umcjimom5EFYbtNm0Na.38ZaC3FcJUHEPcfF8hJMH9rdP.iTpKS','76435'),(118,'118','$2y$10$jxVE8xAnwNBGRPW3mCCnUeqWuIUsTs2JNljkf2/3Y1n0TWFLLo9hu','15536'),(119,'119','$2y$10$l.7Zd0I6Vt53U7ujUVCIJeJMFZBgmEIZ348qb20zuE2QrNyuPVS6W','47537'),(120,'120','$2y$10$3DDLzk5mwyWncYsltd2F4OaazvzGwRcSsGNTm.MXrTMzCKqJWvs76','74838'),(121,'121','$2y$10$9J2AHqnAOs49dsYy8APsCO9oMglY9f5nQ8BqPZIbPWOJRncZ6.uiW','20148'),(122,'122','$2y$10$F0I1MO3htWbloV/XWGYARuGkHsJ3d0cRXR770DiQJ/rLlzhrBP02S','71349'),(123,'123','$2y$10$akF/BzlGxuaVWdfedWrPi.GI.Z/mju/5xiUw86Trhl23Hr1E.8kuO','61050'),(124,'124','$2y$10$apqKcgcxAOeyxDLoyuB7FeijiN.dRxrW6EyvA938aJOH.RCMiU0gu','34751'),(125,'125','$2y$10$uXXHWtH8mVXNGbH.X8zSNukvQA2NAFE5t0/AxpGJQwzQXpkD5iOsO','90052'),(126,'126','$2y$10$X9YRPmHNtTkByEtpS0PU7ulS4zuJ1wyDqXbE9BB4oNPKn8eJv93XW','10653'),(127,'127','$2y$10$ibZLKwA9/.QKw3Kqp/oqKubcv.vjQuN/K3b0N2s6L2ug3f2j8p8na','57655'),(128,'128','$2y$10$rbpLTYg73w5M1BQ5a3waf.T3NJYDATIXDlzy.7fifkZX5miHBpum2','49256'),(129,'129','$2y$10$vqmJ0puV1tU.UinYPRyTdOQ.XnnO9DOQy6KmEzr2SYz9HOGWZy1zO','19157'),(130,'130','$2y$10$n6bdPFadM.Z1IuQOpbaEruKCqgX0yRQVT.uDlx5O3h0Jm0a/yHTHi','68558'),(131,'131','$2y$10$/0GItbxahAR0xpF8fizF3eFZuG0Ah2E6BMERtzdGeEHWuJXYalkTC','68059'),(132,'132','$2y$10$Mycz/21S.IIkcGI8DOURC.xFArh6S6vrMYjM9KIXgFKIT0UaMZUaG','84760'),(133,'133','$2y$10$g8KZTT3yVHFNplOs7i0ryOJ5NjoaBRuRFlPoyPjGS3tlYUa1Lxjf2','67761'),(134,'134','$2y$10$tm/wN4/u9fkxRSDJoGCWQu7cTpGpZlVSfIQYOv03vf8SYq.1SmuKu','64962'),(135,'135','$2y$10$h8pxredFlEeUIx/8UTph4eka8feIT0x/.05tvmCZgLVTRqZQa.86i','66663'),(136,'136','$2y$10$nXpeBXNS0qkjRRqziPz.Au31r9Pn7wnlD4fEwH2eG9BXPauEjC7ua','21164'),(137,'137','$2y$10$PGdh1Lzb4/eUPYmFesOKS.OnrNIFvu.ToJHOAAEa28umRRtLBKwiy','99266'),(138,'138','$2y$10$DK5oes2vz8YDMPLRspkDBelFlletGSAAa9waPKI.X4OfGJ4AOVstG','84167'),(139,'139','$2y$10$JncreCqkFyWnphVOh15kqe2iTn2zj0/8CjByf81rdRpTUh6mhtjPq','69468'),(140,'140','$2y$10$HnbaqLf.7.jP/kX4ZgE3lOTx2EKzdiEIlvCao5I4Q7ovwz9YTMgI.','74569'),(141,'141','$2y$10$B1pMTWRXZii8KMWZ0o0x..s6wsdnkgBb.g9VgqF0EMITN7dZ/Hdia','51170'),(142,'142','$2y$10$NOdl/SO1VaMACJKTj7ch.Oqqby0QTwYDEiv32xKl.Rf0OGWcaJQeS','41071'),(143,'143','$2y$10$N1/jqcsRfrz2lXfW1fkd5.9IbeVwQERxJI40LzHfY6dOr4cOUvqg.','73672'),(144,'144','$2y$10$/3X.ei87gpRI3xCdbhVXueWkVrPlIBjfDl8ImohWSCEHHIAjdIeqK','38273'),(145,'145','$2y$10$nItvVlCsjcjfVF4etFq2uOnrdO0.F4d6o0m9cRb31zgm8DPX4GN46','63674'),(146,'146','$2y$10$eJTMEBPoysudE./YpKs1WerMQbUaJvxPDsZLVjwFTgNrdCF7tk91i','27776'),(147,'147','$2y$10$0IQ0eGZya8MDtNfS5JBYUO69tzU1PsKG.qUT1/x9TQnMGOBPSvi/2','61977'),(148,'148','$2y$10$dCL5PwePnSJeVPjBcvNTeeV9s52eOtd.M/.91hXSed0BQ6THRKVfi','87678'),(149,'149','$2y$10$X6ncDeoRo8K4BMmVzCljXe4EL.A.s.z3e8.gqPwSxUJU2ARKXQXEi','24079'),(150,'150','$2y$10$5ZsNNGnUz7H6eanYM0uPAe7MusjS19diF7zlnxiMOJHObjEOm6wFa','18480'),(151,'151','$2y$10$A6QWXqIUWOIDDYu2/JRrduCYVO2tYXguzQxVP3VUBi.Q49s3lcOji','39281'),(152,'152','$2y$10$QOcBkL9wiRoGoLUMThSFouj0oAnRCd1gXJXJEuJAIeUyJEuyYXiou','19982'),(153,'153','$2y$10$rUcCrV/fAAmoQqBYDAzaO.RzK2kUUeineroAgxP.B3pMzuTYYidOe','79583'),(154,'154','$2y$10$hr3Hdt2P3krElMr2IlO8ZeV/Kvd0XwJ2ZRC3yRBtERiqCFmP7B.Ki','43985'),(155,'155','$2y$10$.GZrDsycXjtTfulk4XEDjeI2CJVvByaq3XRZvYJOpImr9AK97m7Ne','37786'),(156,'156','$2y$10$SOYSQQEVP/EADjbNgW49A.u74f/Tjgua0LUDwl5ax8HeQYUoa73BO','22987'),(157,'157','$2y$10$iriq2mnaeC.N.Wx1jg5VtuYL4WoGTJJPuR4pzt1UuYKyC7l5b/HIy','35588'),(158,'158','$2y$10$rziV8opJWvvEySs/EfkFWOlid.c2RBOQJjaknN/t7PyN2H/6rb2we','30789'),(159,'159','$2y$10$BRWATPfa05jlDg94dofj6.Nq/qB8ze890gEux9T4anWRTGdVk3uBe','46590'),(160,'160','$2y$10$POSJUD51/SMd6xJsZOnzDejGukUmIC.RaE7UbYuqxaBOCYG38L986','96491'),(161,'161','$2y$10$1MtOBKYnsj7r4ElLaOzwUOBkNkjDtZnS5EgO0n9sK7KIQH5mjr672','14341'),(162,'162','$2y$10$YwRwrEZwN3of6ooO23SR2.M5s8dZsSWelSS6uUJST7rudto6sFsM2','46742'),(163,'163','$2y$10$KklbcHKAOzF2iJ1zNawsDepo28SmDvSGkQnUv4sH8Qf9B7Ja7aNTm','53143'),(164,'164','$2y$10$8eJvOz991wnSN8PIY9WozOTiNM2jbW4GlbPS9mbtLRQdaN1oT3ouC','79044'),(165,'165','$2y$10$H7TGT95h0tODfK69cjbYN.4iuFXzMQB2dbzSXbyJM.gpWCk7/8st6','76545'),(166,'166','$2y$10$tW6WgtDwve7UTiUHaurb7.2XjFTALx/HtyzmiGmYpy1Q9RnEJRQ0i','21246'),(167,'167','$2y$10$ukGlXv4YIi.SJCD.rN5jmu2OMA6UANqx8NuWsSKc/pVHJZJEWjo/O','58747'),(168,'168','$2y$10$Uu1nqf7vUfPdjxdqNzxeleSUGbnmBoGgsG4QYdStSzPDAk2M/Y/oi','18848'),(169,'169','$2y$10$myBGmIq.g0nBlM3wktZJwebzsIV5s8W1dGvoDRQODcf8XDCAjzo36','48349'),(170,'170','$2y$10$ll9FRbwuPtH1P1UqSXt5Mu18GfaxTuBYTN1SUttmtR2QRnUNpsG6O','90450'),(171,'171','$2y$10$CwZCFfjLMaUGkECKw9QYv.tisIUQADYqVTqHdPIogYjcfVdK.kPH.','69751'),(172,'172','$2y$10$idp/7wjxr2TNIqwbmd3SkOFIhH0/OvpY8UHWhSksBBANAwjEWDHWK','58052'),(173,'173','$2y$10$Vy79gsmC06.BlqpQ7Gvh6.ySWjxmdUoV97mHzG5xLmH/mzFDIi/Ha','54853'),(174,'174','$2y$10$sLeN12tuOufY9ZQLzA5qhOmVu6u5iW6unh0bj3WXAqjXapWzI4VxC','95154'),(175,'175','$2y$10$JV7qjLMiVcDSOQH0Qetcl.S8ZbeTHcTbVvExdfujioQcB1wcgFkOu','49956'),(176,'176','$2y$10$SPEqJw0RrdiIfbnq1lp23.zswB/X4RG689pHMIxP7XyAaOrbstMf6','47257'),(177,'177','$2y$10$zRVFcIdPNcwGukj3EElzM.SY/R39pOktxDfJHK3WildX6oDZppiea','77758'),(178,'178','$2y$10$wRP2BWSG.TVXVKdRI2Exqewr7badC2hWpleGhVrbBwMP931u5xmIe','40159'),(179,'179','$2y$10$fovSWceVYIgXNzk94vvo0eds2zMu7N/i6n2OgBfe6GX4e9nC9nU/K','63960'),(180,'180','$2y$10$S9.fNikfNhIa5I5qmKZQW.KOtXwv9m2X5ebcawYljQIf3yf/74BdW','88262'),(181,'181','$2y$10$lpVLMTdLtLrapvqKmJcMOO3bTz4pJys0FtjUuR7YHi.bgOnVrRXPW','25662'),(182,'182','$2y$10$4nSJGisIXlEWtyg.4Wb9C.WuWa7RREKyGgYH4cbFu2aA4g82f0bda','95263'),(183,'183','$2y$10$gCW.gZTd2vanaqJKAS5aqutKXuG5U9MWI/vTR07jg765t87ipiiBa','67864'),(184,'184','$2y$10$4rAhW5MlntLoH.JG96L9pu/G1K5cEGZadR62JtiCjrTyKFZVGd2U.','88365'),(185,'185','$2y$10$RHaRv.8QP.Jf.nJbbgxRNeOGD3eLFkv7/K0TEr4vaLruU8T5nohGC','68866'),(186,'186','$2y$10$frokZwC.XKgBEivYcQId0Oj4EN1ZehNudWi852bC9wmMlxXULPtxi','96467'),(187,'187','$2y$10$LOhRwG/KDhbaGNT0PaaecO9rI3vHQTWQ4JJfJKah.X2sDV7MLjKDa','26969'),(188,'188','$2y$10$UHQfCVhauFhKFYQcbR961OGXYRKlOjz7vjMaHZqVu4BRZRYgOxrSq','52570'),(189,'189','$2y$10$jiiDja9hKVXLGHXigO9hrOTodYoU4EOLFdVkV9OqEO5S2nbov3NFa','79771'),(190,'190','$2y$10$2XYk3G3lgLx4g2vwbzu2lO3sitJiAp.UzkplrEOuTJrW5yIc8wz9q','25272'),(191,'191','$2y$10$VElhvjkfzcz06YltzI3TPu74v6sXBc1iltsL.np.JqtZqEHl5FWeu','39173');
/*!40000 ALTER TABLE `cams_user_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link_sharing_details`
--

DROP TABLE IF EXISTS `link_sharing_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link_sharing_details` (
  `link_sharing_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_shared_by_mobile` varchar(45) DEFAULT NULL,
  `link_shared_by_name` varchar(500) DEFAULT NULL,
  `link_shared_to_mobile` varchar(45) DEFAULT NULL,
  `link_shared_to_name` varchar(500) DEFAULT NULL,
  `link_shared_status` int(11) DEFAULT 1,
  `link_shared_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`link_sharing_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link_sharing_details`
--

LOCK TABLES `link_sharing_details` WRITE;
/*!40000 ALTER TABLE `link_sharing_details` DISABLE KEYS */;
INSERT INTO `link_sharing_details` VALUES (1,'7407417111','ranjit bangal','79 0879 8385','A Pal',1,'2020-06-29 19:04:24'),(2,'7407417111','ranjit bangal','79 0879 8385','A Pal',1,'2020-06-29 19:04:24'),(3,'7407417111','ranjit bangal','79 0879 8385','A Pal',1,'2020-06-29 19:04:24'),(4,'7407417111','ranjit bangal','81700 38014','A Sir',1,'2020-06-29 19:04:31'),(5,'7407417111','ranjit bangal','+91 97320 10540','Subhranil Sir',1,'2020-06-29 19:06:52'),(6,'7407417111','ranjit bangal','96359 83383','Ankita',1,'2020-06-30 21:31:40'),(7,'7407417111','ranjit bangal','79 0879 8385','A Pal',1,'2020-07-08 18:19:00'),(8,'8170038018','Admin off','+919800150003','Pribrata Whats App Message',1,'2020-07-09 14:09:08'),(9,'6296980637','abhishek Chatterjee','9434349610','A mallick',1,'2020-07-09 15:26:48'),(10,'6296980637','abhishek Chatterjee','+91 6295 147 261','Abhay Di Whatsapp no',1,'2020-07-09 15:40:01'),(11,'6296980637','abhishek Chatterjee','6297383815','Abhijit Batabyal Jyoti Commercial',1,'2020-07-09 15:40:57'),(12,'6296980637','abhishek Chatterjee','9614278725','Abhijit Cps',1,'2020-07-09 15:41:30'),(13,'6296980637','abhishek Chatterjee','9679189869','Abhijit Pratihaar',1,'2020-07-09 15:42:33'),(14,'6296980637','abhishek Chatterjee','+91 83358 56498','Abhilash Sengupta Electrical Rabindra Path Bhawan',1,'2020-07-09 15:44:06'),(15,'6296980637','abhishek Chatterjee','+91 83358 56498','Abhilash Sengupta Electrical Rabindra Path Bhawan',1,'2020-07-09 15:44:44'),(16,'6296980637','abhishek Chatterjee','9734732839','Ajijul Bk. t. p. p',1,'2020-07-09 15:46:18'),(17,'6296980637','abhishek Chatterjee','9153738767','Alida Bpie',1,'2020-07-09 15:47:28'),(18,'6296980637','abhishek Chatterjee','+91 89450 60771','Amit Sks Whatsapp New No',1,'2020-07-09 15:49:10'),(19,'6296980637','abhishek Chatterjee','9162297666','Anku Jamshedpur Ph No',1,'2020-07-09 15:50:41'),(20,'6296980637','abhishek Chatterjee','07869886344','Ankush Banta',1,'2020-07-09 15:53:01'),(21,'6296980637','abhishek Chatterjee','7008103095','Annantada Orissa Ph No',1,'2020-07-09 15:53:15'),(22,'6296980637','abhishek Chatterjee','+91 90938 69021','Arif Baidya Whatsapp no',1,'2020-07-09 15:55:56'),(23,'8013407749','Kaushik Mondal','8013407749','Kaushik',1,'2020-07-09 19:15:28'),(24,'6296980637','abhishek Chatterjee','6296981865','Baren Roy Tpiti Electrician 1st Year Student',1,'2020-07-10 13:14:46'),(25,'6296980637','abhishek Chatterjee','8597887784','Dinabandhu Kar Whatsapp No',1,'2020-07-10 21:26:10');
/*!40000 ALTER TABLE `link_sharing_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2019_08_19_000000_create_failed_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mock_version_history`
--

DROP TABLE IF EXISTS `mock_version_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mock_version_history` (
  `version_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(45) DEFAULT NULL,
  `whats_new_in_version` varchar(500) DEFAULT NULL,
  `version_date` datetime DEFAULT current_timestamp(),
  `is_version_active` int(11) DEFAULT 1,
  PRIMARY KEY (`version_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mock_version_history`
--

LOCK TABLES `mock_version_history` WRITE;
/*!40000 ALTER TABLE `mock_version_history` DISABLE KEYS */;
INSERT INTO `mock_version_history` VALUES (1,'1.3','New Options','2020-06-13 20:05:34',1),(2,'1.3','Bug Fixes','2020-06-13 20:05:38',1),(3,'1.3','UI Improvement','2020-06-13 20:05:43',1);
/*!40000 ALTER TABLE `mock_version_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_about_us`
--

DROP TABLE IF EXISTS `ueh_about_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_about_us` (
  `about_us_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `about_us_scrolling_text` longtext DEFAULT NULL,
  `about_us_top_banner_image_1` varchar(45) DEFAULT NULL,
  `about_us_top_banner_image_2` varchar(45) DEFAULT NULL,
  `about_us_top_banner_image_3` varchar(45) DEFAULT NULL,
  `about_us_top_banner_image_4` varchar(45) DEFAULT NULL,
  `about_us_top_banner_image_5` longtext DEFAULT NULL,
  `about_us_description` longtext DEFAULT NULL,
  `about_us_second_banner_image_1` longtext DEFAULT NULL,
  `why_us_heading_1` longtext DEFAULT NULL,
  `why_us_heading_description_1` longtext DEFAULT NULL,
  `why_us_heading_2` longtext DEFAULT NULL,
  `why_us_heading_description_2` longtext DEFAULT NULL,
  `why_us_heading_3` longtext DEFAULT NULL,
  `why_us_heading_description_3` longtext DEFAULT NULL,
  `why_us_heading_4` longtext DEFAULT NULL,
  `why_us_heading_description_4` longtext DEFAULT NULL,
  `why_us_heading_5` longtext DEFAULT NULL,
  `why_us_heading_description_5` longtext DEFAULT NULL,
  `testimonial_user_1_name` longtext DEFAULT NULL,
  `testimonial_user_1_profile_image` longtext DEFAULT NULL,
  `testimonial_1_description` longtext DEFAULT NULL,
  `testimonial_user_2_name` longtext DEFAULT NULL,
  `testimonial_user_2_profile_image` longtext DEFAULT NULL,
  `testimonial_2_description` longtext DEFAULT NULL,
  `testimonial_user_3_name` longtext DEFAULT NULL,
  `testimonial_user_3_profile_image` longtext DEFAULT NULL,
  `testimonial_3_description` longtext DEFAULT NULL,
  `contact_address` longtext DEFAULT NULL,
  `contact_email` longtext DEFAULT NULL,
  `contact_mobile` longtext DEFAULT NULL,
  `about_us_status` int(11) DEFAULT 1,
  `about_us_created_by` int(11) DEFAULT NULL,
  `about_us_created_at` datetime DEFAULT current_timestamp(),
  `about_us_updated_by` int(11) DEFAULT NULL,
  `about_us_updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`about_us_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_about_us`
--

LOCK TABLES `ueh_about_us` WRITE;
/*!40000 ALTER TABLE `ueh_about_us` DISABLE KEYS */;
INSERT INTO `ueh_about_us` VALUES (1,' UEH is under Govt of India Registered Organization, Registration Number IV 010100267 Based on TR act 1882 * An ISO 9001:2015 Certified Organization CER NO- QMS/011494/0719 * An MSME Certified Organization, UAM NO WB02D0003936 * It is NITI Aayog, Govt of India Registration Organization Unique ID- WB/2019/0239739 * An Central Vigilance Commission Certified Organization C.No 6377589384 * An Autonomous Institute Registered Under Govt of West Bengal','1_new.jpg','2_new.jpg','3_new.jpg','4_new.jpg','5.jpg','<strong>UNIVERSAL EDUCATION HUB</strong> is trust registered under the India Trust Act, 1882 with Registration  Number IV-010100267. The Trust is formed on 2019, by Mr. Gour Bhattacharya. UNIVERSAL EDUCATION HUB(UEH) is  a non-profit trust committed to provide certificates to students who are learning different types of courses in  different institutes.The trust aims to provide certificates for the follwing types of courses: <br/><br/> <ul><li><strong> Art & Painting School</strong></li><li><strong>Beauty Parlour</strong></li><li><strong>Dance & Song School</strong></li><li><strong>Spoken English</strong></li><li><strong>Vocational Traning Centre</strong></li>\n<li><strong>Boutique Music & Musical Instrument Training Centre</strong></li><li><strong>Yoga & Pranayam Traning Centre</strong></li><li><strong>Any Astrologycal Traning Centre</strong> </li><li><strong>Kumphu / Karate School</strong></li><li><strong>Any Skill Development Centre</strong></li><li> <strong>Computer Traning centre</strong></li><li><strong>Play School ( Play To UKG )</strong></li><li><strong>Any Job Oriented Teaching & Traning Institute</strong></li>  Currently UEH is providing certificates to more than 25 centers at different location of India. Around 1000 students are enhancing their skills by learning different courses from the those centers and they will be certified by us after successful completion of the course. In the coming years we will tie up with many more institutes. UEH has a simple aim, it is to provide certificates to all students who have engaged themselves to enhance their skills by enrolling in different institutes.\n<br/><br/> \n OUR MISSION\n  :- <br/><br/>\n<ul>\n<li><strong>To serve the Society by providing Quality certficates to students based on their skill set.</strong></li>\n<li><strong>To promote the importance of skill development at an early stage of a students life.</strong></li>\n\n<li><strong>To achieve socioal-economical development in a serene and competitive environment.</strong></li>\n\n<li><strong>To provide certficates on all the best skill development courses.</strong></li>\n\n\n</ul>\n \n','6.jpg','<strong>ISO CERTIFIED</strong>','<strong>Universal Education Hub is an ISO 9001:2015 certified organization.</strong>\n<p>ISO 9001 is defined as the international standard that specifies requirements for quality management system (QMS). \nOrganizations use the standard to demonstrate the ability to consistently provide products \nand services that meet customer and regulatory requirements. \nIt is the most popular standard in the ISO 9000 series and the only standard in the series to which\n organizations can certify.</p>','<strong>QUALITY EDUCATION</strong>','<p><strong>Quality education</strong> enables people to develop all of their attributes and skills to achieve their potential as human beings and members of society.  <strong>Quality education</strong> provides the foundation for equity in society. <strong>Quality education</strong> is one of the most basic public services. </p>','<strong>ONLINE SOLUTIONS</strong>','<p>We at <strong>UEH</strong> follow the theory of Digital India and we try to do most of our work through online We are constantly working to move our entire process flow to be done through online. Once we achieve our 100% goal we will get following benefits.</p>','<strong>FAST PROCESSING</strong>','			\n<p class=\"has-text-color has-normal-font-size has-very-dark-gray-color\">In this fastest growing world no one will wait for your, so we believe in Fast Processing and we provide hassle free work flow for everything. With <strong>Universal Education Hub</strong> each and every small institute and training centres can provide certificates to their students or trainee. Join us and get certified your students tomorrow onwards.</p>','<strong>OTHERS</strong>','<ul>\r <li>It is under Govt of India Registered Organization, Regi No IV 010100267 Based on TR act 1882.</li>\r <li>It ISO 9001:2015 Certified Organization CER NO- QMS/011494/0719.</li>\r <li>An MSME Certified Organization, UAM NO WB02D0003936.</li>\r <li>It is NITI Aayog, Govt of India Registration Organization Unique ID- WB/2019/0239739.</li>\r <li>An Central Vigilance Commission Certified Organization C.No 6377589384.</li>\r <li>An Autonomous Institute Registered Under Govt of West Bengal.</li>\r <li>UEH issued Certificates valid All over India.</li>\r <li>Online Registration Facility Available Here &amp; Very Simple Criteria For Franchise Registration.</li>\r <li>Good &amp; First Service.</li>\r <li>No Hidden Cost &amp; easy Payment System.</li>\r <li>Any certificate 3 to 10 days delivery at your Centre by post or hand to hand.</li>\r </ul>','RAGHURAM RASTRA','12.jpg','<p>I am very happy &#038; delighted that Me &#038; my institute is a part of Universal Education Hub.<br />','Mrs Sudana Bric','13.jpg','<p>Now it’s very easy and convenient to get certified our students just because of Universal Education Hub. Thanks UEH for speedy &#038; sparkling workflow.</p>','Mr Rob Roy','14.jpg',' <p>Our institute got trust of Universal Education Hub and we recommend to all to avail services from Universal Education Hub. Thanks UEH.</p>','Lalbazar, Ramkrishna Pally, Bankura -West Bengal(India)-722101','universaleducationhub@gmail.com','8597 500 501',1,NULL,'2020-05-11 12:46:17',NULL,'2020-05-11 12:46:17');
/*!40000 ALTER TABLE `ueh_about_us` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_certificate`
--

DROP TABLE IF EXISTS `ueh_certificate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_certificate` (
  `certificate_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `franchise_id` int(11) DEFAULT NULL,
  `certificate_application_number` varchar(45) DEFAULT NULL,
  `certificate_status` int(11) DEFAULT 1,
  `certificate_created_at` datetime DEFAULT current_timestamp(),
  `certificate_ueh_number` varchar(45) DEFAULT NULL,
  `certificate_approved_rejected_on` datetime DEFAULT NULL,
  PRIMARY KEY (`certificate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_certificate`
--

LOCK TABLES `ueh_certificate` WRITE;
/*!40000 ALTER TABLE `ueh_certificate` DISABLE KEYS */;
INSERT INTO `ueh_certificate` VALUES (1,1,1,9,'CR15920343374003',2,'2020-06-13 13:15:41','UEH/WB/20/C00001','2020-06-13 07:47:12'),(2,2,2,47,'CR15965606089901',1,'2020-08-04 22:33:56',NULL,NULL);
/*!40000 ALTER TABLE `ueh_certificate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_course`
--

DROP TABLE IF EXISTS `ueh_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_course` (
  `course_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `franchise_type_id` int(11) DEFAULT NULL,
  `course_name` longtext DEFAULT NULL,
  `course_image` longtext DEFAULT NULL,
  `course_description` longtext DEFAULT NULL,
  `course_status` int(11) DEFAULT 1,
  `course_created_by` int(11) DEFAULT NULL,
  `course_created_at` datetime DEFAULT current_timestamp(),
  `course_updated_by` int(11) DEFAULT NULL,
  `course_updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_course`
--

LOCK TABLES `ueh_course` WRITE;
/*!40000 ALTER TABLE `ueh_course` DISABLE KEYS */;
INSERT INTO `ueh_course` VALUES (1,NULL,' <p>Art &amp; Painting School</p>','1.jpeg','<p>Dance and Song School</p>',1,NULL,'2020-05-11 14:49:32',NULL,'2020-05-11 14:49:32'),(2,NULL,'  <p>&nbsp;Beauty Parlour</p>','2.jpg','<p>Spoken English</p>',1,NULL,'2020-05-11 14:49:33',NULL,'2020-05-11 14:49:33'),(3,NULL,'<p>Yoga &#038; Pranayam Traning Centre</p>','3.jpg','<p>Vocational Training Centre</p>',1,NULL,'2020-05-11 14:49:35',NULL,'2020-05-11 14:49:35'),(4,NULL,'<p>Music &#038; Musical Instrument Traning Centre</p>','4.jpg','<p>Boutique</p>',1,NULL,'2020-05-11 14:49:36',NULL,'2020-05-11 14:49:36'),(5,NULL,'    <p>Kumphu / Karate&nbsp; School</p>','5.jpg','<p>Any Skill Development Centre</p>',1,NULL,'2020-05-11 14:49:37',NULL,'2020-05-11 14:49:37'),(6,NULL,'<p>Computer Traning centre</p>','6.jpg','<p>Play School(Play to UKG)</p>',1,NULL,'2020-05-11 14:49:39',NULL,'2020-05-11 14:49:39'),(7,NULL,'<p>Dance and Song School</p>','7.jpg','<p>Any Job Oriented Teaching and Training Institutes</p>',1,NULL,'2020-05-11 14:49:41',NULL,'2020-05-11 14:49:41'),(8,NULL,'<p>Spoken English</p>','8.jpg',' <p>Art &amp; Painting School</p>',1,NULL,'2020-05-11 14:49:41',NULL,'2020-05-11 14:49:41'),(9,NULL,'<p>Vocational Training Centre</p>','9.jpg','  <p>&nbsp;Beauty Parlour</p>',1,NULL,'2020-05-11 14:49:42',NULL,'2020-05-11 14:49:42'),(10,NULL,'<p>Boutique</p>','10.jpg','<p>Yoga &#038; Pranayam Traning Centre</p>',1,NULL,'2020-05-11 14:49:44',NULL,'2020-05-11 14:49:44'),(11,NULL,'<p>Any Skill Development Centre</p>','11.jpg','<p>Music &#038; Musical Instrument Traning Centre</p>',1,NULL,'2020-05-11 14:49:46',NULL,'2020-05-11 14:49:46'),(12,NULL,'<p>Play School(Play to UKG)</p>','12.jpg','    <p>Kumphu / Karate&nbsp; School</p>',1,NULL,'2020-05-11 14:49:47',NULL,'2020-05-11 14:49:47'),(13,NULL,'<p>Any Job Oriented Teaching and Training Institutes</p>','13.jpg','<p>Computer Traning centre</p>',1,NULL,'2020-05-11 14:49:48',NULL,'2020-05-11 14:49:48'),(14,NULL,'<p>Handy Craft</p>','14.jpg','<p>Handy Craft</p>',1,NULL,'2020-05-11 14:49:48',NULL,'2020-05-11 14:49:48');
/*!40000 ALTER TABLE `ueh_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_ec_member`
--

DROP TABLE IF EXISTS `ueh_ec_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_ec_member` (
  `ec_member_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ec_member_applicant_name` longtext DEFAULT NULL,
  `ec_member_guardian_name` longtext DEFAULT NULL,
  `ec_member_nominee_name` longtext DEFAULT NULL,
  `ec_member_nominee_relation` longtext DEFAULT NULL,
  `ec_member_dob` date DEFAULT NULL,
  `ec_member_age` longtext DEFAULT NULL,
  `ec_member_mobile` varchar(45) DEFAULT NULL,
  `ec_member_caste` varchar(45) DEFAULT NULL,
  `ec_member_educational_qualification` longtext DEFAULT NULL,
  `ec_member_address` longtext DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `ec_member_pin` longtext DEFAULT NULL,
  `ec_member_account_number` longtext DEFAULT NULL,
  `ec_member_account_ifsc` longtext DEFAULT NULL,
  `ec_member_bank` longtext DEFAULT NULL,
  `ec_member_bank_branch` longtext DEFAULT NULL,
  `ec_member_document_pan` longtext DEFAULT NULL,
  `ec_member_document_aadhar` longtext DEFAULT NULL,
  `ec_member_document_voter_card` longtext DEFAULT NULL,
  `ec_member_code` varchar(45) DEFAULT NULL,
  `ec_member_applied_date` datetime DEFAULT current_timestamp(),
  `ec_member_foundation_percentage` longtext DEFAULT NULL,
  `ec_member_certificate_percentage` longtext DEFAULT NULL,
  `ec_member_designated_location` int(11) DEFAULT NULL,
  `ec_member_reference_name` longtext DEFAULT NULL,
  `ec_member_application_number` longtext DEFAULT NULL,
  `ec_member_approved_rejected_date` datetime DEFAULT NULL,
  `ec_member_approved_rejected_remarks` longtext DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ec_member_information_source` longtext DEFAULT NULL,
  `ec_member_approved_rejected_by` int(11) DEFAULT NULL,
  `ec_member_status` int(11) DEFAULT 0,
  `referred_by_name` longtext DEFAULT NULL,
  PRIMARY KEY (`ec_member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_ec_member`
--

LOCK TABLES `ueh_ec_member` WRITE;
/*!40000 ALTER TABLE `ueh_ec_member` DISABLE KEYS */;
INSERT INTO `ueh_ec_member` VALUES (1,'Test Purpose',NULL,NULL,NULL,'2020-05-11',NULL,'9800150003',NULL,'Graduate','Asansol',1,'713301',NULL,NULL,NULL,NULL,NULL,'A15891900067101.jpg',NULL,'UEH/WB/20/00054','2020-05-11 15:11:04',NULL,NULL,NULL,NULL,'EC15891900084793','2020-06-18 03:35:21','Approved',2,'Facebook',1,1,NULL),(2,'Antara Acharya',NULL,NULL,NULL,'1988-08-26',NULL,'9903698379',NULL,'Higher secondary','Jirat Station Para Balagarh Hooghly',1,'712501',NULL,NULL,NULL,NULL,NULL,'A15892643377221.jpg',NULL,'UEH/WB/20/00051','2020-05-12 11:49:26',NULL,NULL,NULL,NULL,'EC15892643410934','2020-06-18 03:49:54','..',21,'Internet',1,1,NULL),(3,'Kashnaprava Halder Bhattacharjee',NULL,NULL,NULL,'1977-09-30',NULL,'8420658623',NULL,'B.A','650 R.N.Tagore Road     Dumdum',1,'700077',NULL,NULL,NULL,NULL,'P15899326538176.jpg',NULL,NULL,'UEH/WB/20/00057','2020-05-20 05:28:39',NULL,NULL,NULL,NULL,'EC15899326603792','2020-06-18 03:51:40','57 - Training Required',24,'Facebook',1,1,NULL),(4,'ASHIS BISWAS',NULL,NULL,NULL,'1994-03-11',NULL,'9126875748',NULL,'M.A','74,MADHUPUR ROAD,PO/PS- BERHAMPORE, DIS- MURSHIDABAD,PIN-742101',1,'742101',NULL,NULL,NULL,NULL,NULL,'A15917931127503.jpg',NULL,'UEH/WB/20/00055','2020-06-10 18:17:27',NULL,NULL,NULL,NULL,'EC15917931167734','2020-06-18 03:50:35','55',22,'Internet',1,1,NULL),(5,'kshudiram karmakar',NULL,NULL,NULL,'1991-03-02',NULL,'6294580829',NULL,'m.a .bed','vill +p.o - Helena susunia    dist-bankura  pin-722146',1,'722146',NULL,NULL,NULL,NULL,'P15921075033744.jpg',NULL,NULL,'UEH/WB/20/00019','2020-06-14 09:35:29',NULL,NULL,NULL,NULL,'EC15921075175786','2020-06-18 03:42:09','Approve',8,'Facebook',1,1,NULL),(6,'Arup kumar pal',NULL,NULL,NULL,'1976-01-25',NULL,'8116208564',NULL,'mp','pandua , patrasayer , bankura',1,'722206',NULL,NULL,NULL,NULL,NULL,'A15923947227266.jpg',NULL,'UEH/WB/20/00036','2020-06-17 17:22:12',NULL,NULL,NULL,NULL,'EC15923947241440','2020-06-18 03:43:26','Approve',10,'Facebook',1,1,NULL),(7,'swapan kumar barik',NULL,NULL,NULL,'1979-09-14',NULL,'7047127767',NULL,'gradute','4/1 banku bihari pal lane \nbaranagar , kolkata',1,'700036',NULL,NULL,NULL,NULL,NULL,'A15923950478464.jpg',NULL,'UEH/WB/20/00046','2020-06-17 17:27:38',NULL,NULL,NULL,NULL,'EC15923950492954','2020-06-18 03:48:47','..',18,'Facebook',1,1,NULL),(8,'chandana dutta',NULL,NULL,NULL,'1954-09-15',NULL,'8967063734',NULL,'mp','school danga , bankura \naakriti apartment\nnear helth point',1,'722101',NULL,NULL,NULL,NULL,NULL,'A15923952492398.jpg',NULL,'UEH/WB/20/00044','2020-06-17 17:30:59',NULL,NULL,NULL,NULL,'EC15923952509504','2020-06-18 03:47:28','..',17,'Facebook',1,1,NULL),(9,'Sourav Dey',NULL,NULL,NULL,'1977-11-12',NULL,'8910804614',NULL,'post graduate','12/1gangadhar sen lane \n2nd floor , meghbath bhawan , baranagar kolkata',1,'700036',NULL,NULL,NULL,NULL,NULL,'A15923954890038.jpg',NULL,'UEH/WB/20/00040','2020-06-17 17:34:59',NULL,NULL,NULL,NULL,'EC15923954905451','2020-06-18 03:46:18','..',13,'Facebook',1,1,NULL),(10,'Rajkumar ghosh',NULL,NULL,NULL,'1969-07-03',NULL,'9875595588',NULL,'gradute','8/3 banku bihari pal lane \nbaranagar , north 24parganas',1,'700036',NULL,NULL,NULL,NULL,NULL,'A15923959856757.jpg',NULL,'UEH/WB/20/00041','2020-06-17 17:43:16',NULL,NULL,NULL,NULL,'EC15923959877225','2020-06-18 03:46:32','..',14,'Facebook',1,1,NULL),(11,'Dipak Saha',NULL,NULL,NULL,'1964-03-04',NULL,'7044191972',NULL,'mp','731 , R.N tagore road ,\nsouth dumdum (m) , bediapara\nnorth 24pgns',1,'700077',NULL,NULL,NULL,NULL,NULL,'A15923963692863.jpg',NULL,'UEH/WB/20/00047','2020-06-17 17:49:41',NULL,NULL,NULL,NULL,'EC15923963716290','2020-06-18 03:49:00','..',19,'Facebook',1,1,NULL),(12,'chand middya',NULL,NULL,NULL,'1999-10-01',NULL,'7029313814',NULL,'hs','pandua , patrasayer , bankura',1,'722206',NULL,NULL,NULL,NULL,NULL,'A15923965760298.jpg',NULL,'UEH/WB/20/00039','2020-06-17 17:53:07',NULL,NULL,NULL,NULL,'EC15923965783203','2020-06-18 03:46:01','Approve',12,'Facebook',1,1,NULL),(13,'sanjay ghosh',NULL,NULL,NULL,'1996-01-04',NULL,'8327327911',NULL,'hs','dignagar ,\nausgram ,\npurba burdwan',1,'713128',NULL,NULL,NULL,NULL,'P15923969457612.jpg',NULL,NULL,'UEH/WB/20/00043','2020-06-17 17:59:17',NULL,NULL,NULL,NULL,'EC15923969481914','2020-06-18 03:47:09','..',16,'Facebook',1,1,NULL),(14,'Radhanath Chakrabarty',NULL,NULL,NULL,'1978-11-28',NULL,'6295860158',NULL,'hs','lachhmanpur \ngangagalghati \nbankura',1,'722133',NULL,NULL,NULL,NULL,NULL,'A15923972205414.jpg',NULL,'UEH/WB/20/00037','2020-06-17 18:03:51',NULL,NULL,NULL,NULL,'EC15923972223161','2020-06-18 03:43:53','Approve',11,'Facebook',1,1,NULL),(15,'Nirupama Nandi',NULL,NULL,NULL,'1997-10-01',NULL,'8777864869',NULL,'M.P','Rampur Sitala main road kol-70141',1,'700141',NULL,NULL,NULL,NULL,NULL,'A15923989649016.jpg',NULL,'UEH/WB/20/00056','2020-06-17 18:32:57',NULL,NULL,NULL,NULL,'EC15923989677423','2020-06-18 03:51:22','56',23,'Facebook',1,1,NULL),(16,'Gour panja',NULL,NULL,NULL,'1994-01-31',NULL,'8918733236',NULL,'msc','pandua , patrasayer ,\nbankura',1,'722206',NULL,NULL,NULL,NULL,NULL,'A15923999043501.jpg',NULL,'UEH/WB/20/00042','2020-06-17 18:48:37',NULL,NULL,NULL,NULL,'EC15923999062240','2020-06-18 03:46:45','..',15,'Facebook',1,1,NULL),(17,'pijush kanti dhak',NULL,NULL,NULL,'1992-03-15',NULL,'7679270674',NULL,'ba','palashdanga , pratappur \nsirsara bankura',1,'722155',NULL,NULL,NULL,NULL,NULL,'A15924000415437.jpg',NULL,'UEH/WB/20/00049','2020-06-17 18:50:54',NULL,NULL,NULL,NULL,'EC15924000432696','2020-06-18 03:49:27','..',20,'Facebook',1,1,NULL),(18,'Rajkumar mondal',NULL,NULL,NULL,'1986-09-19',NULL,'8116678954',NULL,'hs','netaji subhas pally , block b , durgapur 1 \npaschim bardhaman',1,'713201',NULL,NULL,NULL,NULL,NULL,'A15924002032176.jpg',NULL,'UEH/WB/20/00030','2020-06-17 18:53:36',NULL,NULL,NULL,NULL,'EC15924002053198','2020-06-18 03:42:43','Approve',9,'Facebook',1,1,NULL),(19,'chandan rakshit',NULL,NULL,NULL,'1975-03-26',NULL,'9434224182',NULL,'ba','goinathpur , arabindapally \nbankura',1,'722101',NULL,NULL,NULL,NULL,NULL,'A15924003727235.jpg',NULL,'UEH/WB/20/00006','2020-06-17 18:56:25',NULL,NULL,NULL,NULL,'EC15924003741513','2020-06-18 03:39:31','Approve',4,'Facebook',1,1,NULL),(20,'Sukla Dey',NULL,NULL,NULL,'1990-05-04',NULL,'9064248665',NULL,'ba','cinema road , bankura',1,'722101',NULL,NULL,NULL,NULL,NULL,'A15924005504020.jpg',NULL,'UEH/WB/20/00007','2020-06-17 18:59:23',NULL,NULL,NULL,NULL,'EC15924005524276','2020-06-18 03:40:04','Approve',5,'Facebook',1,1,NULL),(21,'srikanta karmakar',NULL,NULL,NULL,'1989-11-22',NULL,'9614137545',NULL,'ba','doltala \nkamarpara , bankura',1,'722101',NULL,NULL,NULL,NULL,NULL,'A15924007072620.jpg',NULL,'UEH/WB/20/00003','2020-06-17 19:02:00',NULL,NULL,NULL,NULL,'EC15924007090536','2020-06-18 03:37:03','Approved',3,'Facebook',1,1,NULL),(22,'Soma das',NULL,NULL,NULL,'1988-06-30',NULL,'9749422269',NULL,'gradute','suryasen pally , c block , durgapur 1\npaschim burdhaman',1,'713201',NULL,NULL,NULL,NULL,NULL,'A15924009342496.jpg',NULL,'UEH/WB/20/00008','2020-06-17 19:05:47',NULL,NULL,NULL,NULL,'EC15924009363204','2020-06-18 03:40:41','Approve',6,'Facebook',1,1,NULL),(23,'kakali Roy',NULL,NULL,NULL,'1987-05-13',NULL,'9932365544',NULL,'mp','nadadihi\nsalbani\nbankura',1,'722102',NULL,NULL,NULL,NULL,NULL,'A15924011041858.jpg',NULL,'UEH/WB/20/00014','2020-06-17 19:08:37',NULL,NULL,NULL,NULL,'EC15924011062812','2020-06-18 03:41:16','Approve',7,'Facebook',1,1,NULL),(24,'Tapan Paul',NULL,NULL,NULL,'1980-08-08',NULL,'9064359334',NULL,'ma','Gangagalghati \nbankura',1,'722133',NULL,NULL,NULL,NULL,NULL,'A15924531521638.jpg',NULL,'UEH/WB/20/00045','2020-06-18 09:36:27',NULL,NULL,NULL,NULL,'EC15924531547212','2020-06-18 04:11:06','45',25,'Facebook',1,1,NULL),(25,'Madhumanti Chowdhury',NULL,NULL,NULL,'2004-10-11',NULL,'7439349136',NULL,'10 pass','I/20 baghajatin post office regent estate',1,'700092',NULL,NULL,NULL,NULL,NULL,'A15927503068587.jpg',NULL,'UEH/WB/20/00058','2020-06-21 20:08:53',NULL,NULL,NULL,NULL,'EC15927503094508','2020-06-22 12:30:16','OK',26,'Facebook',1,1,NULL),(26,'Manoj Das',NULL,NULL,NULL,'1987-02-02',NULL,'9134455433',NULL,'m. p','vii+po Gulandar\nps itahar\nDist uttar dinaj pur',1,'733128',NULL,NULL,NULL,NULL,NULL,'A15928819883617.jpg',NULL,NULL,'2020-06-23 08:44:29',NULL,NULL,NULL,NULL,'EC15928819918555','2020-06-23 03:27:49','wrong information....Aadhar card address not found.',NULL,'Facebook',1,2,NULL),(27,'Arup Das',NULL,NULL,NULL,'1987-02-08',NULL,'9748713213',NULL,'10th','165/7 Parui Kancha Road kolkata - 700061',1,'700061',NULL,NULL,NULL,NULL,NULL,'A15929275797987.jpg',NULL,'UEH/WB/20/00059','2020-06-23 21:24:39',NULL,NULL,NULL,NULL,'EC15929275826537','2020-06-23 16:32:07','ok success your aim....',27,'Facebook',1,1,NULL),(28,'Nargish Nazeer Hossain',NULL,NULL,NULL,'2021-07-01',NULL,'9595067483',NULL,'B.A.,','1117, Anand Nagar, Binakhi lay Out, Nagpur, 44001',27,'440017',NULL,NULL,NULL,NULL,NULL,'A15932802173161.jpg',NULL,'UEH/MH/20/00001','2020-06-27 23:20:50',NULL,NULL,NULL,NULL,'EC15932802208191','2020-06-30 13:28:47','EXECUTIVE MEMBER YOUR APPLICATION IS SUCCESSFUL......THANK YOU',28,'Facebook',1,1,NULL),(29,'puja maity',NULL,NULL,NULL,'2020-07-01',NULL,'9083187697',NULL,'hs','kakdwip pukur beriya',1,'743347',NULL,NULL,NULL,NULL,NULL,'A15935703277572.jpg',NULL,'UEH/WB/20/00060','2020-07-01 07:56:24',NULL,NULL,NULL,NULL,'EC15935703311041','2020-07-01 04:34:09','Your Application is ok ..but address suporting document not match ..please lets send by whatsapp .\nThank yoy',29,'Facebook',1,1,NULL),(30,'Debashri Senapati',NULL,NULL,NULL,'1992-03-25',NULL,'8642847259',NULL,'M. A of Bridal Makeup','Vill. Krishnanagar., post..  Gorh krishnanagar, p.s Nandigram, Dist.  Purba Medinipur state..  West Bengal',1,'721650',NULL,NULL,NULL,NULL,NULL,'A15935798071340.jpg',NULL,NULL,'2020-07-01 10:34:27',NULL,NULL,NULL,NULL,'EC15935798099038',NULL,NULL,NULL,'Internet',NULL,0,NULL),(31,'pujita pal',NULL,NULL,NULL,'2020-07-01',NULL,'6296128076',NULL,'tehatta','tehatta',1,'741160',NULL,NULL,NULL,NULL,'P15935891540501.jpg',NULL,NULL,NULL,'2020-07-01 13:09:16',NULL,NULL,NULL,NULL,'EC15935891561838','2020-07-01 08:00:26','Aadhrcard & Pan card no upload....please submit vallid documents',NULL,'Facebook',1,2,NULL),(32,'Sneha Oriflame Beauty  Akadami',NULL,NULL,NULL,'2020-08-06',NULL,'7872787855',NULL,'HS','purulia.Nilkuthidunga',1,'723101',NULL,NULL,NULL,NULL,NULL,'A15937608930555.jpg',NULL,NULL,'2020-07-03 12:51:48',NULL,NULL,NULL,NULL,'EC15937608965678','2020-07-06 03:10:53','mistekly fillup ec member from. your franchise registration successful....',NULL,'Executive Member',1,2,'sneha Bhagat'),(33,'Suman Shit',NULL,NULL,NULL,'1991-11-09',NULL,'9333193819',NULL,'Masters in computer applications (MCA)','kenduadihi Sahanapally Bankura',1,'722102',NULL,NULL,NULL,NULL,NULL,'A15938033345124.jpg',NULL,NULL,'2020-07-04 00:39:28',NULL,NULL,NULL,NULL,'EC15938033396026',NULL,NULL,NULL,'Executive Member',NULL,0,'Gour Bhattacharya'),(34,'rumki das',NULL,NULL,NULL,'2020-07-30',NULL,'9932427906',NULL,'12pass','dankuni moshat',1,'712701',NULL,NULL,NULL,NULL,NULL,'A15961014234795.jpg',NULL,NULL,'2020-07-30 15:00:57',NULL,NULL,NULL,NULL,'EC15961014328187','2020-08-19 15:27:27','DOCUMENT NOT MATCH',NULL,'Facebook',1,2,NULL),(35,'Manti Sarkar',NULL,NULL,NULL,'1989-11-28',NULL,'8723935671',NULL,'H.S pass','312/1,17 no dakshindari road.near ultodangga',1,'700048',NULL,NULL,NULL,NULL,NULL,'A15974024703631.jpg',NULL,'UEH/WB/20/00062','2020-08-14 16:24:44',NULL,NULL,NULL,NULL,'EC15974024743752','2020-08-17 06:32:38','ok',73,'Facebook',1,1,NULL),(36,'Keya Das',NULL,NULL,NULL,'1992-11-23',NULL,'8250204948',NULL,'Graduation incomplete','Baranilpure Road,uttarpara,Near Bhanga Masjid,Barddhaman purba,west bengal ,Barddhaman sadar',1,'713103',NULL,NULL,NULL,NULL,'P15976437516813.jpg',NULL,NULL,'UEH/WB/20/00061','2020-08-17 11:26:42',NULL,NULL,NULL,NULL,'EC15976437570268','2020-08-17 06:32:07','ok',72,'Executive Member',1,1,'Gour Bhattacharya'),(37,'Keya Das',NULL,NULL,NULL,'1992-11-23',NULL,'8250204948',NULL,'graduation incomplete','Baranilpure Road, Uttar para,NearBhanga Masjid,Barddhamansadar,Purba Burdwan',1,'713103',NULL,NULL,NULL,NULL,'P15976444637556.jpg',NULL,NULL,NULL,'2020-08-17 11:38:36',NULL,NULL,NULL,NULL,'EC15976444712746','2020-08-17 06:30:52','double application',NULL,'Facebook',1,2,NULL),(38,'ARDHENDU MUKHERJEE',NULL,NULL,NULL,'1995-01-11',NULL,'9647015645',NULL,'HS PASSED','paschim Mamudpur Dakshin para po:-Bhanderdihi PS-Manteshwar Dist:- Purba Burdwan',1,'713426',NULL,NULL,NULL,NULL,NULL,'A15976640768406.jpg',NULL,'UEH/WB/20/00063','2020-08-17 17:05:38',NULL,NULL,NULL,NULL,'EC15976640848330','2020-08-17 14:37:46','ok',74,'Executive Member',1,1,'KEYA DAS'),(39,'KHEALI CHOWDHURY',NULL,NULL,NULL,'1994-04-14',NULL,'8250893553',NULL,'MBA','AMTALA, SARAITIKAR, GOLAPBAG',1,'713104',NULL,NULL,NULL,NULL,NULL,'A15977322201112.jpg',NULL,'UEH/WB/20/00064','2020-08-18 12:00:44',NULL,NULL,NULL,NULL,'EC15977322234727','2020-08-18 06:41:32','ok',76,'Executive Member',1,1,'KEYA DAS'),(40,'Supriti Singha Roy',NULL,NULL,NULL,'2020-08-25',NULL,'9831253790',NULL,'bsc','Supriti Singha Roy ,Flat no-1, RA-189 ,3rd floor back, Shantinagar, Saltlake sector- 4, Chinrighata, 700105\nland mark - Oyo town house',1,'700105',NULL,NULL,NULL,NULL,NULL,'A15983502107130.jpg',NULL,NULL,'2020-08-25 15:40:27',NULL,NULL,NULL,NULL,'EC15983502160607','2020-08-25 12:12:02','mistake fillup',NULL,'Internet',1,2,NULL),(41,'Poulami Panchadhyayee',NULL,NULL,NULL,'2000-09-12',NULL,'9641222480',NULL,'H.S','Ghol,Chaulkhola, Chhotachaulkhola,purba medinipur,Chaulkhola West Bengal.',1,'721455',NULL,NULL,NULL,NULL,NULL,'A15983518449738.jpg',NULL,'UEH/WB/20/00065','2020-08-25 16:07:51',NULL,NULL,NULL,NULL,'EC15983518589931','2020-08-25 12:15:09','ok',77,'Facebook',1,1,NULL),(42,'SUPRITI SINGHA ROY',NULL,NULL,NULL,'1997-01-28',NULL,'9831253790',NULL,'Bsc - Biotechnology','Vill- Putunda,  P.O - Saktigarh, Dist - Burdwan,Pin - 713149.\nPh no - 8240761522',1,'713149',NULL,NULL,NULL,NULL,NULL,'A15983533792526.jpg',NULL,NULL,'2020-08-25 16:33:15',NULL,NULL,NULL,NULL,'EC15983533824650',NULL,NULL,NULL,'Internet',NULL,0,NULL),(43,'SOUVIK GANGULY',NULL,NULL,NULL,'1988-05-02',NULL,'9775639784',NULL,'B.A.','VILL BAHULARA,PO MAKARKOLE,PS ONDA DIST BANKURA',1,'722144',NULL,NULL,NULL,NULL,NULL,'A15986216962528.jpg',NULL,'UEH/WB/20/00066','2020-08-28 19:05:24',NULL,NULL,NULL,NULL,'EC15986217223341','2020-08-28 13:41:08','OK',80,'Friend',1,1,'GOUR BHATTACHARYA'),(44,'Abhijit Chattopadhyay',NULL,NULL,NULL,'1988-07-04',NULL,'9773011174',NULL,'Graduation','Vill+Post - Selampur, PS - Goghat, Dist- Hooghly',1,'712122',NULL,NULL,NULL,NULL,NULL,'A15987602172977.jpg',NULL,'UEH/WB/20/00067','2020-08-30 09:33:50',NULL,NULL,NULL,NULL,'EC15987602238765','2020-08-30 06:15:40','OK',82,'Executive Member',1,1,'Souvik Ganguly'),(45,'KRISHNADAS KUNDU',NULL,NULL,NULL,'1991-04-06',NULL,'9614631033',NULL,'B.A','VILL+P.O+P.S-ONDA.DIST-BANKURA.PIN-722144.',1,'722144',NULL,NULL,NULL,NULL,'P15987674710964.jpg',NULL,NULL,'UEH/WB/20/00068','2020-08-30 11:34:58',NULL,NULL,NULL,NULL,'EC15987674880352','2020-08-30 07:09:03','ok',83,'Executive Member',1,1,'SOUVIK GANGULY'),(46,'chaitali nayak',NULL,NULL,NULL,'1983-01-01',NULL,'8240115028',NULL,'Ba','Chaitali nayak\nw/o=subhasis nayak\n41/5    Bachashpati para road\nDakshineswar.\nkol-700076',1,'700076',NULL,NULL,NULL,NULL,'P15987816206110.jpg',NULL,NULL,NULL,'2020-08-30 15:30:41',NULL,NULL,NULL,NULL,'EC15987816250687','2020-09-03 15:26:56','WRONG FILLAP....YOUR FRANCHICE FROM FILLAP ALLREADY DONE',NULL,'Facebook',1,2,NULL),(47,'Tufan Ghosh',NULL,NULL,NULL,'1996-04-05',NULL,'6295095161',NULL,'6295095161','VILL+P.O: HELNA SUSUNIA\nDIST:BANKURA',1,'722146',NULL,NULL,NULL,NULL,NULL,'A15991353552448.jpg',NULL,'UEH/WB/20/00069','2020-09-03 17:46:08',NULL,NULL,NULL,NULL,'EC15991353665852','2020-09-03 15:24:50','OK',86,'Executive Member',1,1,'KSHUDIRAM KARMAKAR'),(48,'TUFAN GHOSH',NULL,NULL,NULL,'1996-04-05',NULL,'6295095161',NULL,'H.S','VILL+P.O: HELNA SUSUNIA\nDIST:BANKURA',1,'722146',NULL,NULL,NULL,NULL,NULL,'A15991356796864.jpg',NULL,NULL,'2020-09-03 17:51:29',NULL,NULL,NULL,NULL,'EC15991356875288','2020-09-03 15:26:02','DOUBLE FILAP',NULL,'Executive Member',1,2,'KSHUDIRAM KARMAKAR'),(49,'Sarmistha Dutta',NULL,NULL,NULL,'1986-01-11',NULL,'9874018647',NULL,'Graduate','408 Bhrambhopur rd',1,'700084',NULL,NULL,NULL,NULL,NULL,'A15994772743131.jpg',NULL,NULL,'2020-09-07 04:14:44',NULL,NULL,NULL,NULL,'EC15994772794023','2020-09-08 08:30:20','Wrong filap',NULL,'Friend',1,2,'Supriti Singha Roy'),(50,'Sarmistha Dutta',NULL,NULL,NULL,'1986-01-11',NULL,'9874018647',NULL,'Graduate','24A Rahim Ostagar rd',1,'700045',NULL,NULL,NULL,NULL,'P15994827492082.jpg',NULL,NULL,NULL,'2020-09-07 05:46:02',NULL,NULL,NULL,NULL,'EC15994827555607','2020-09-08 08:30:38','Wrong filap',NULL,'Friend',1,2,'Supriti Singha Roy'),(51,'Nipa Bid',NULL,NULL,NULL,'1986-07-19',NULL,'9564472129',NULL,'Master of Arts','D/O Bikash Karmakar\nDurgapur bypass road, saradapally,\nPo+Dist- Bankura',1,'722122',NULL,NULL,NULL,NULL,NULL,'A16013003957371.jpg',NULL,'UEH/WB/20/00070','2020-09-28 06:40:33',NULL,NULL,NULL,NULL,'EC16013004177138','2020-09-28 15:31:11','ok',92,'Internet',1,1,NULL),(52,'Epsita Dikshit',NULL,NULL,NULL,'1995-08-20',NULL,'9434113729',NULL,'12passed','jangipur sd hospital, murshidabad, fultola , raghunathjang, jangipur',1,'742225',NULL,NULL,NULL,NULL,NULL,'A16033876096777.jpg',NULL,'UEH/WB/20/00071','2020-10-22 22:56:55',NULL,NULL,NULL,NULL,'EC16033876128863','2020-10-25 13:56:35','ok',94,'Facebook',1,1,NULL),(53,'Srabani paramanik dey',NULL,NULL,NULL,'1984-01-20',NULL,'9064626301',NULL,'BA Pass','Noon Gola Road Bankura',1,'722101',NULL,NULL,NULL,NULL,NULL,'A16067442364812.jpg',NULL,'UEH/WB/20/00072','2020-11-30 19:21:37',NULL,NULL,NULL,NULL,'EC16067442427325','2020-12-01 13:02:37','OK',99,'Facebook',1,1,NULL),(54,'Samir Goswami',NULL,NULL,NULL,'1990-01-04',NULL,'7001819211',NULL,'12','vill+po. cb nagar, nabadwip, nadia, west bangal',1,'741301',NULL,NULL,NULL,NULL,NULL,'A16103019004223.jpg',NULL,NULL,'2021-01-10 23:35:57',NULL,NULL,NULL,NULL,'EC16103019284417',NULL,NULL,NULL,'Friend',NULL,0,'self'),(55,'soma debnath',NULL,NULL,NULL,'1987-01-05',NULL,'9933919008',NULL,'madhayamik','Vill+post- Baikara P.S.- Gaighata Dist-n 24 parganas.',1,'743245',NULL,NULL,NULL,NULL,NULL,'A16106377530396.jpg',NULL,NULL,'2021-01-14 20:52:52',NULL,NULL,NULL,NULL,'EC16106377593162',NULL,NULL,NULL,'Facebook',NULL,0,NULL),(56,'Dipchayanika Das',NULL,NULL,NULL,'1982-04-15',NULL,'7002609071',NULL,'H.S.L.C','W/O: Amrit Das\nN-Aria Sukantaroad, Word no-02,\nLanka; Hojai; Assam.',4,'782446',NULL,NULL,NULL,NULL,NULL,'A16106421533281.jpg',NULL,NULL,'2021-01-14 22:06:11',NULL,NULL,NULL,NULL,'EC16106421572080',NULL,NULL,NULL,'Facebook',NULL,0,NULL),(57,'Sukanta Baidya',NULL,NULL,NULL,'1998-07-21',NULL,'9903667556',NULL,'HS Passed','Mondal Para, Garagacha, Garia Station Road, Kol - 700084, P.S. - Narendrapur, P.O. - Garia, West Bengal, India',1,'700084',NULL,NULL,NULL,NULL,NULL,'A16126832919811.jpg',NULL,'UEH/WB/21/00001','2021-02-07 13:05:24',NULL,NULL,NULL,NULL,'EC16126832959791','2021-02-07 17:50:03','ok',107,'Executive Member',1,1,'Facebook'),(58,'Rupa Ghosh',NULL,NULL,NULL,'1989-09-10',NULL,'7003143003',NULL,'9th pass','memanpur kalitola \nPO - vivekananda Pally\nPS - MAHESHTALA',1,'700139',NULL,NULL,NULL,NULL,NULL,'A16129491003777.jpg',NULL,NULL,'2021-02-10 14:55:18',NULL,NULL,NULL,NULL,'EC16129491038111',NULL,NULL,NULL,'Facebook',NULL,0,NULL),(59,'kaushik paul',NULL,NULL,NULL,'1992-10-05',NULL,'8967491470',NULL,'H.s','vill- South Kalatala , P.O - Charbrahma Nagar , P.S - Nabadwip , Dist - Nadia',1,'741301',NULL,NULL,NULL,NULL,NULL,'A16138303438450.jpg',NULL,'UEH/WB/21/00002','2021-02-20 07:12:35',NULL,NULL,NULL,NULL,'EC16138303517264','2021-02-20 17:52:15','ok',113,'Facebook',1,1,NULL),(60,'Snigdha Mukherjee',NULL,NULL,NULL,'1971-12-28',NULL,'9476302476',NULL,'MP','Lalbazar Dipogora Vairabi Goli Po&Dt Bankura',1,'722101',NULL,NULL,NULL,NULL,NULL,'A16139764636555.jpg',NULL,NULL,'2021-02-21 23:48:33',NULL,NULL,NULL,NULL,'EC16139764810152',NULL,NULL,NULL,'Friend',NULL,0,'Gour Bhattacharya'),(61,'somnath Paul make over',NULL,NULL,NULL,'1994-07-03',NULL,'7003115864',NULL,'madhyamik','Jagacha howrah sartragachi _700112',1,'700112',NULL,NULL,NULL,NULL,'P16160623665116.jpg',NULL,NULL,NULL,'2021-03-18 03:13:16',NULL,NULL,NULL,NULL,'EC16160623752952',NULL,NULL,NULL,'Friend',NULL,0,'nothing'),(62,'RUPA BHATTACHARYA',NULL,NULL,NULL,'1992-09-13',NULL,'9332679700',NULL,'Ba','Ramkrishna Pally, Lalbazar, Bankura',1,'722101',NULL,NULL,NULL,NULL,'P16172102757456.jpg',NULL,NULL,NULL,'2021-03-31 17:04:37',NULL,NULL,NULL,NULL,'EC16172102765721','2021-04-01 13:50:00','ok',NULL,'Facebook',1,2,NULL),(63,'UEH SELF',NULL,NULL,NULL,'2019-07-27',NULL,'8597500501',NULL,'Ba','Lalbazar bankura',1,'722101',NULL,NULL,NULL,NULL,'P16172844467165.jpg',NULL,NULL,NULL,'2021-04-01 13:40:48',NULL,NULL,NULL,NULL,'EC16172844483307','2021-04-01 13:49:25','cancle',NULL,'Facebook',1,2,NULL),(64,'UEH SELF',NULL,NULL,NULL,'2019-07-27',NULL,'9749304040',NULL,'Ba','Lalbazar bankura',1,'722101',NULL,NULL,NULL,NULL,'P16172849341671.jpg',NULL,NULL,'UEH/WB/21/00003','2021-04-01 13:48:58',NULL,NULL,NULL,NULL,'EC16172849378644','2021-04-01 13:49:47','ok',117,'Facebook',1,1,NULL);
/*!40000 ALTER TABLE `ueh_ec_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_feedback`
--

DROP TABLE IF EXISTS `ueh_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_feedback` (
  `feedback_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `feedback_title` longtext DEFAULT NULL,
  `feedback_description` longtext DEFAULT NULL,
  `feedback_created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`feedback_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_feedback`
--

LOCK TABLES `ueh_feedback` WRITE;
/*!40000 ALTER TABLE `ueh_feedback` DISABLE KEYS */;
INSERT INTO `ueh_feedback` VALUES (1,2,27,'tedt','test','2021-02-27 06:19:29');
/*!40000 ALTER TABLE `ueh_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_franchise`
--

DROP TABLE IF EXISTS `ueh_franchise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_franchise` (
  `franchise_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `franchise_organisation_name` longtext DEFAULT NULL,
  `franchise_nature_of_business` longtext DEFAULT NULL,
  `franchise_business_grade` longtext DEFAULT NULL,
  `franchise_current_student_strength` longtext DEFAULT NULL,
  `franchise_applicant_name` longtext DEFAULT NULL,
  `franchise_dob` date DEFAULT NULL,
  `franchise_age` longtext DEFAULT NULL,
  `franchise_mobile` varchar(45) DEFAULT NULL,
  `franchise_caste` varchar(45) DEFAULT NULL,
  `franchise_educational_qualification` longtext DEFAULT NULL,
  `franchise_address` longtext DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `franchise_pin` longtext DEFAULT NULL,
  `franchise_document_pan` longtext DEFAULT NULL,
  `franchise_document_aadhar` longtext DEFAULT NULL,
  `franchise_document_trade_license` longtext DEFAULT NULL,
  `franchise_document_voter_card` longtext DEFAULT NULL,
  `franchise_code` varchar(45) DEFAULT NULL,
  `franchise_ec_member_code` int(11) DEFAULT NULL,
  `franchise_valid_till` datetime DEFAULT NULL,
  `franchise_application_number` longtext DEFAULT NULL,
  `franchise_approved_rejected_date` datetime DEFAULT NULL,
  `franchise_approved_rejected_remarks` longtext DEFAULT NULL,
  `franchise_applied_date` datetime DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `franchise_information_source` longtext DEFAULT NULL,
  `franchise_type_id` int(11) DEFAULT NULL,
  `franchise_approved_rejected_by` int(11) DEFAULT NULL,
  `franchise_status` int(11) DEFAULT 0,
  `referred_by_name` longtext DEFAULT NULL,
  PRIMARY KEY (`franchise_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_franchise`
--

LOCK TABLES `ueh_franchise` WRITE;
/*!40000 ALTER TABLE `ueh_franchise` DISABLE KEYS */;
INSERT INTO `ueh_franchise` VALUES (1,'Education','Education',NULL,NULL,'Test purpose','2020-05-11',NULL,'9083213952',NULL,'Graduate','Asansol',1,'713347',NULL,'A15891898899735.jpg',NULL,NULL,NULL,NULL,'2022-06-13 13:05:42','FR15891898910761','2020-08-04 14:16:49','TEST','2020-05-11 15:09:06',5,'Facebook',1,1,2,NULL),(2,'Antara\'s Professional Bridal Makeover','Antara\'s Professional Bridal Makeover',NULL,NULL,'Antara Acharya','1988-08-26',NULL,'9903698379',NULL,'Higher secondary','Jirat Station Para Balagarh Hooghly',1,'712501',NULL,'A15892648536156.jpg',NULL,NULL,'UEH/WB/20/FR0026',64,'2022-08-04 19:18:25','FR15892648563720','2020-08-04 13:48:25','OK','2020-05-12 11:58:01',53,'Internet',2,1,1,NULL),(3,'MOU MAKE OVER&ACADEMY','MOU MAKE OVER&ACADEMY',NULL,NULL,'Debyani chatterjee','1984-07-21',NULL,'7063810465',NULL,'Matrik pass','village.andal.post.andal.dist .poschim burdwan....pin.713321..stystion road',1,'713321',NULL,'A15893817088140.jpg',NULL,NULL,'UEH/WB/20/FR0027',NULL,'2022-08-04 19:07:31','FR15893817128882','2020-08-04 13:37:31','OK','2020-05-13 20:25:22',48,'Facebook',2,1,1,NULL),(4,'ILA\'S MAKEOVER ACADEMY CENTER','ILA\'S MAKEOVER ACADEMY CENTER',NULL,NULL,'ILA DAS','1991-07-23',NULL,'9836581443',NULL,'M.A.','165/ 7 PARUI KANCHA ROAD , ASHPHAL TALA.',1,'700061',NULL,'A15894377748995.jpg',NULL,NULL,'UEH/WB/20/FR0028',NULL,'2022-08-04 19:07:58','FR15894377785681','2020-08-04 13:37:58','OK','2020-05-14 12:00:15',49,'Facebook',2,1,1,NULL),(5,'Make up artistry','Make up artistry',NULL,NULL,'Susmita Singha Roy','1993-11-19',NULL,'7908188282',NULL,'M. A. in Bengali','36/3 Barabagan Lane, Alambazar',1,'700035',NULL,'A15900724833906.jpg',NULL,NULL,'UEH/WB/20/FR0029',NULL,'2022-08-04 19:08:26','FR15900724928508','2020-08-04 13:38:26','OK','2020-05-21 20:17:35',50,'Facebook',2,1,1,NULL),(6,'Dayita\'z professional artist bridal makeup  studio @ academy','Dayita\'z professional artist bridal makeup  studio @ academy',NULL,NULL,'Dayita chakraborty','2000-01-10',NULL,'9609815378',NULL,'12 pass','31.no .p.c sarani desbhanbhu para siliguri',1,'734404',NULL,'A15903051044313.jpg',NULL,NULL,NULL,NULL,NULL,'FR15903051105072','2020-08-04 14:17:55','PAYMENT NO SEND','2020-05-24 12:55:26',NULL,'Internet',2,1,2,NULL),(7,'SWAPNO MAKEOVER & BEAUTY ACADEMY','SWAPNO MAKEOVER & BEAUTY ACADEMY',NULL,NULL,'ANAMIKA SAU','1995-04-06',NULL,'8250139940',NULL,'B.A.','D/O- ASHUTOSH SAU\nVILL- MAHATPUR\nP.O.- NARANDA\nP.S.- PANSKURA\nDIST.- PURBA MEDINIPUR',1,'721139',NULL,'A15905184981803.jpg',NULL,NULL,'UEH/WB/20/FR0030',64,'2022-08-04 19:09:08','FR15905185048157','2020-08-04 13:39:08','OK','2020-05-27 00:12:27',51,'Facebook',2,1,1,NULL),(8,'Training Centre','Training Centre',NULL,NULL,'Sayani Mullick','1993-07-28',NULL,'9831347333',NULL,'MA','Laxmi house flat no 1c 1st floor jhowtala Teghoria near loknath mandir Kolkata 700157',1,'700157',NULL,'A15917992628275.jpg',NULL,NULL,'UEH/WB/20/FR0010',NULL,'2022-08-04 11:30:40','FR15917992644004','2020-08-04 06:00:40','OK','2020-06-10 19:59:57',36,'Facebook',2,1,1,NULL),(9,'Test Business','Test Business',NULL,NULL,'Priyabrata Maiti','2020-06-13',NULL,'9800150003',NULL,'NA','Asansol',1,'713301','P15920314512898.jpg',NULL,NULL,NULL,NULL,NULL,'2022-06-13 12:36:02','FR15920314526051','2020-08-04 14:17:34','TEST','2020-06-13 12:27:33',4,'Facebook',1,1,2,NULL),(10,'RANGA ALO\'S MAKEOVER','RANGA ALO\'S MAKEOVER',NULL,NULL,'Aparna Debnath','1960-09-15',NULL,'9749638363',NULL,'HS','1no. Santigarh colony \nsantipur\nNadia',1,'741404',NULL,'A15922172979758.jpg',NULL,NULL,'UEH/WB/20/FR0032',2,'2022-08-04 19:19:06','FR15922173102506','2020-08-04 13:49:06','OK','2020-06-15 16:06:06',54,'Facebook',2,1,1,'Antara Acharya'),(11,'Test','Test',NULL,NULL,'test','2020-06-17',NULL,'7384809452',NULL,'gg','hjj',2,'713301',NULL,'A15923908021047.jpg',NULL,NULL,NULL,NULL,NULL,'FR15923908030878','2020-08-04 14:16:59','TEST','2020-06-17 16:16:48',NULL,'Facebook',1,1,2,NULL),(12,'Test','Test',NULL,NULL,'Test','2020-06-17',NULL,'1234567890',NULL,'Graduate','Test',1,'111111','P15923947603380.jpg',NULL,NULL,NULL,NULL,NULL,NULL,'FR15923947618691','2020-08-04 14:16:36','TEST','2020-06-17 17:22:50',NULL,'Executive Member',1,1,2,'test referred'),(13,'SAMPURNA LEDIES BEAUTY PARLOUR','SAMPURNA LEDIES BEAUTY PARLOUR',NULL,NULL,'TANU CHATTERJEE','1989-05-29',NULL,'8617394883',NULL,'M.P.','VILL- P.O- GANGAJAL GHATI\nDIST- BANKURA',1,'722133',NULL,'A15924007121874.jpg',NULL,NULL,'UEH/WB/20/FR0033',NULL,'2022-08-04 19:20:20','FR15924007394878','2020-08-04 13:50:20','OK','2020-06-17 19:02:30',55,'Facebook',2,1,1,NULL),(14,'Beauty','Beauty',NULL,NULL,'Subhra das( gan)',NULL,NULL,'9732552494',NULL,'BA pass','Barajaguli ,Digha para ,Nadia,,WB ,741221',1,'741221','P15924106339693.jpg',NULL,NULL,NULL,NULL,NULL,NULL,'FR15924106376410','2020-08-04 06:07:58','WRONG','2020-06-17 21:47:32',NULL,'0',0,1,2,NULL),(15,'Beauty','Beauty',NULL,NULL,'Subhra das (  gan )','2020-06-17',NULL,'9732552494',NULL,',B. A .Paa','Barajaguli ,Digha para ,Nadia ,',1,'741221',NULL,'A15924134914995.jpg',NULL,NULL,'UEH/WB/20/FR0016',NULL,'2022-08-04 11:38:05','FR15924134956394','2020-08-04 06:08:05','OK','2020-06-17 22:35:12',42,'Facebook',2,1,1,NULL),(16,'Sahana\'s Makeover  & beauti academy','Sahana\'s Makeover  & beauti academy',NULL,NULL,'Sahana Sen Mitra','1986-10-17',NULL,'7003417107',NULL,'M.A','63, south pansila. sodepur. Kolkata- 700112. Ankush apartment 2nd floor.',1,'700112',NULL,'A15926772242588.jpg',NULL,NULL,'UEH/WB/20/FR0034',NULL,'2022-08-04 19:20:47','FR15926772279287','2020-08-04 13:50:47','OK','2020-06-20 23:50:43',56,'Internet',2,1,1,NULL),(17,'Chandaba Beauty parlour','Chandaba Beauty parlour',NULL,NULL,'chandana  Das','1987-03-19',NULL,'9134455433',NULL,'mp','p o Gulandar\np s itahar\nDist Uttar Dinaj pur',1,'733128',NULL,'A15928833456298.jpg',NULL,NULL,'UEH/WB/20/FR0035',NULL,'2022-08-04 19:21:14','FR15928833495252','2020-08-04 13:51:14','OK','2020-06-23 09:07:07',57,'Facebook',2,1,1,NULL),(18,'Skin\'z skin n Makeup Academy','Skin\'z skin n Makeup Academy',NULL,NULL,'Nargish Nazeer Hossain','1976-03-01',NULL,'9595067483',NULL,'B.A.','1117, Binakhi lay out, Anand Nagar, Nagpur',27,'440017',NULL,'A15932822653958.jpg',NULL,NULL,'UEH/MH/20/FR0001',NULL,'2022-08-04 19:23:19','FR15932822683608','2020-08-04 13:53:19','OK','2020-06-27 23:54:58',59,'Facebook',2,1,1,NULL),(19,'BULTI LADIES BEAUTY PARLOUR','BULTI LADIES BEAUTY PARLOUR',NULL,NULL,'ANUSHREE CHAKRABARTY','1985-12-21',NULL,'8670448800',NULL,'Madhyamik','VILL+POST-LACHHMANPUR.P.S-GANGAJALGHATI.DIST-BANKURA.',1,'722133','P15933180551203.jpg','A15933180624943.jpg',NULL,NULL,'UEH/WB/20/FR0036',64,'2022-08-04 19:21:39','FR15933180712170','2020-08-04 13:51:39','OK','2020-06-28 09:51:24',58,'Facebook',2,1,1,NULL),(20,'Paromita\'s makeup studio & academy','Paromita\'s makeup studio & academy',NULL,NULL,'Paromita mondal','1999-07-20',NULL,'6297138803',NULL,'Higher secondary','Paromita Mondal.\nD/O Mantu Mondal.\nvill- Bhawanipur (Mondal para)\nCity- Basirhat\nP.O- Basirhat College\nDist- North 24 Parganas',1,'743412',NULL,'A15935406260356.jpg',NULL,NULL,'UEH/WB/20/FR0037',NULL,'2022-08-04 19:23:49','FR15935406327714','2020-08-04 13:53:49','OK','2020-06-30 23:41:15',60,'Facebook',2,1,1,NULL),(21,'Sunanda\'s makeover studio and academy','Sunanda\'s makeover studio and academy',NULL,NULL,'Sunanda biswas','1999-08-28',NULL,'9733317419',NULL,'graduate','Vill+po Gopalpur\nps haroa\ndist - north 24 pgs',1,'743445',NULL,'A15936791330770.jpg',NULL,NULL,'UEH/WB/20/FR0039',NULL,'2022-08-04 19:24:47','FR15936791370337','2020-08-04 13:54:47','OK','2020-07-02 14:09:35',62,'Facebook',2,1,1,NULL),(22,'IT Real Solutions','IT Real Solutions',NULL,NULL,'Suman Shit','1991-11-09',NULL,'9333193819',NULL,'Master in computer application','kenduadihi Sahanapally Bankura',1,'722102',NULL,'A15937547078480.jpg',NULL,NULL,NULL,NULL,NULL,'FR15937547167104','2020-08-04 14:17:22','PAYMENT NO SEND','2020-07-03 11:08:45',NULL,'Executive Member',6,1,2,'Gour Bhattacharya'),(23,'Sneha Oriflame Beauty Acadami','Sneha Oriflame Beauty Acadami',NULL,NULL,'sneha Bhagat','2020-07-03',NULL,'7872787855',NULL,'HS','purulia .Nilkuthidunga',1,'723101',NULL,'A15937629409565.jpg',NULL,NULL,'UEH/WB/20/FR0040',NULL,'2022-08-04 19:25:10','FR15937629431878','2020-08-04 13:55:10','OK','2020-07-03 13:25:55',63,'Internet',16,1,1,NULL),(24,'Debashri\'s Professional Makeup Institute...','Debashri\'s Professional Makeup Institute...',NULL,NULL,'Debashri Senspati','2016-03-25',NULL,'8642847259',NULL,'Masters of Makeup artist...','vill. Krishnanagar.... post...  Garh krishnanagar.... p. s ..  Nandigram.... Dist... Medinipur...',1,'721650',NULL,'A15938283299494.jpg',NULL,NULL,'UEH/WB/20/FR0038',NULL,'2022-08-04 19:24:17','FR15938283337574','2020-08-04 13:54:17','OK','2020-07-04 07:36:13',61,'Internet',16,1,1,NULL),(25,'RESHMA\'S MAKEOVER','RESHMA\'S MAKEOVER',NULL,NULL,'Reshma chowdhury','1997-03-08',NULL,'9064868915',NULL,'H.S pass','Balaidas chatterjee road opposite Surya Sarkar ration shop,pal para, Hakim Para, Siliguri',1,'734001',NULL,'A15940119561476.jpg',NULL,NULL,'UEH/WB/20/FR0041',NULL,'2022-08-04 19:25:33','FR15940119621450','2020-08-04 13:55:33','OK','2020-07-06 10:36:57',64,'Facebook',16,1,1,NULL),(26,'Suvra\'s Makeover','Suvra\'s Makeover',NULL,NULL,'Suvra Saha','1994-12-31',NULL,'8240695212',NULL,'Parsuing M.com','P-97,Kalindi Housing Estate,Skyline, First Floor,Near Axis Bank.',1,'700089',NULL,'A15948768276791.jpg',NULL,NULL,'UEH/WB/20/FR0042',NULL,'2022-08-04 19:25:59','FR15948768300407','2020-08-04 13:55:59','OK','2020-07-16 10:51:03',65,'Facebook',16,1,1,NULL),(27,'Moon\"z Makeover  (makeup studio n academy)','Moon\"z Makeover  (makeup studio n academy)',NULL,NULL,'Moon Das Dutta','1987-10-03',NULL,'6291864991',NULL,'MA','Mahendra dutta road .opposite nearest lane of banipur baniniketan high school Habra West Bengal',1,'743233',NULL,'A15948906975825.jpg',NULL,NULL,'UEH/WB/20/FR0043',NULL,'2022-08-04 19:26:24','FR15948906998026','2020-08-04 13:56:24','OK','2020-07-16 14:42:20',66,'Facebook',16,1,1,NULL),(28,'Abhijit\'s make up world. profesonal bridal makeup artist.','Abhijit\'s make up world. profesonal bridal makeup artist.',NULL,NULL,'Abhijit das.','1992-09-23',NULL,'9123679396',NULL,'higher secondary.','D/147,baghajatin,jadavpur university, kolkata-700032. west Bengal.',1,'700032',NULL,'A15950837751164.jpg',NULL,NULL,'UEH/WB/20/FR0044',64,'2022-08-04 19:27:31','FR15950837813108','2020-08-04 13:57:31','OK','2020-07-18 20:19:49',67,'Facebook',16,1,1,NULL),(29,'Sunita Ghosh','Sunita Ghosh',NULL,NULL,'Sunita Ghosh','2020-07-29',NULL,'7450965510',NULL,'HS','krishnapur chandiberiya Urvashi apartment nearby nabjagran club.',1,'700102',NULL,'A15960151606292.jpg',NULL,NULL,NULL,NULL,NULL,'FR15960151641801','2020-08-04 13:58:19','DOUBLE APPLY','2020-07-29 15:03:34',NULL,'Facebook',2,1,2,NULL),(30,'Sunita Ghosh','Sunita Ghosh',NULL,NULL,'Sunita Ghosh','1989-11-22',NULL,'7450965510',NULL,'HS','krishnapur chandiberiya Urvashi apartment.near nabjagran club',1,'700102',NULL,'A15960157662983.jpg',NULL,NULL,'UEH/WB/20/FR0045',NULL,'2022-08-04 19:28:27','FR15960157690571','2020-08-04 13:58:27','OK','2020-07-29 15:13:39',68,'Facebook',2,1,1,NULL),(31,'The Institute of Vedic Astrology','The Institute of Vedic Astrology',NULL,NULL,'Gour Bhattacharya','1983-09-02',NULL,'9332679700',NULL,'ma','Lalbazar , Ramkrishna Pally , Bankura',1,'722101',NULL,'A15961012600271.jpg',NULL,NULL,'UEH/WB/20/FR0001',NULL,'2022-08-04 10:58:20','FR15961012626350','2020-08-04 05:28:20','A','2020-07-30 14:58:08',30,'Facebook',9,1,1,NULL),(32,'Shambhavi Collection','Shambhavi Collection',NULL,NULL,'Sukla dey','1990-05-04',NULL,'9064248665',NULL,'ba','SUKLA DEY , C/O Raghunath Dey , cinema Road Bankura',1,'722101',NULL,'A15961020113048.jpg',NULL,NULL,'UEH/WB/20/FR0002',NULL,'2022-08-04 10:58:20','FR15961020139305','2022-08-04 10:58:20','A','2020-07-30 15:10:40',30,'Facebook',14,1,1,NULL),(33,'Khushi Ladies Beauty Parlour','Khushi Ladies Beauty Parlour',NULL,NULL,'Manasi Chaudhuri','1997-01-01',NULL,'9732084567',NULL,'mp','Lower Beniasole , Arabinda Pally , post Adra , Purulia',1,'723121',NULL,'A15961022785773.jpg',NULL,NULL,'UEH/WB/20/FR0003',NULL,'2022-08-04 11:17:16','FR15961022807003','2020-08-04 05:47:16','Approved','2020-07-30 15:15:07',31,'Executive Member',2,1,1,'srikanta karmakar'),(34,'Moon\'Z Ladies Beauty Parlour','Moon\'Z Ladies Beauty Parlour',NULL,NULL,'Munmun Kar','1990-05-12',NULL,'7908988336',NULL,'mp','Anara Banglow side qtr no L/81c , post anara , para , purulia',1,'723126',NULL,'A15961025586992.jpg',NULL,NULL,'UEH/WB/20/FR0004',NULL,'2022-08-04 11:18:01','FR15961025607901','2020-08-04 05:48:01','Approved','2020-07-30 15:19:47',32,'Executive Member',2,1,1,'srikanta karmakar'),(35,'Trisha\'S Beauty Makeover','Trisha\'S Beauty Makeover',NULL,NULL,'Sampa Saha','1985-11-22',NULL,'9748702775',NULL,'ba','245/A , Ramchandrapur , Sodepur , north 24 pgns',1,'700110',NULL,'A15961027940872.jpg',NULL,NULL,'UEH/WB/20/FR0006',NULL,'2022-08-04 11:27:02','FR15961027959327','2020-08-04 05:57:02','OK','2020-07-30 15:23:42',33,'Facebook',2,1,1,NULL),(36,'Ishika Ladies Beauty parlour','Ishika Ladies Beauty parlour',NULL,NULL,'Runu singha','1979-08-24',NULL,'9614802745',NULL,'mp','Rabindra sarani ,  bankura',1,'722101',NULL,'A15961029807848.jpg',NULL,NULL,'UEH/WB/20/FR0007',NULL,'2022-08-04 11:27:59','FR15961029833283','2020-08-04 05:57:59','OK','2020-07-30 15:26:50',34,'Executive Member',2,1,1,'srikanta karmakar'),(37,'Netaji computer Traning Centre','Netaji computer Traning Centre',NULL,NULL,'Parikshit Mandal','2000-10-24',NULL,'8250466943',NULL,'hs','Helna Susunia \nBankura',1,'722146',NULL,'A15961032219655.jpg',NULL,NULL,'UEH/WB/20/FR0009',NULL,'2022-08-04 11:29:27','FR15961032242668','2020-08-04 05:59:27','OK','2020-07-30 15:30:51',35,'Executive Member',6,1,1,'Kshudiram Karmakar'),(38,'Glow-up Ladies Beauty Parlour & Traning Centre','Glow-up Ladies Beauty Parlour & Traning Centre',NULL,NULL,'Pali Saha','1975-09-03',NULL,'9748416112',NULL,'mp','Vivekananda Pally , Malda',1,'732101',NULL,'A15961034842731.jpg',NULL,NULL,'UEH/WB/20/FR0011',NULL,'2022-08-04 11:32:20','FR15961034875502','2020-08-04 06:02:20','OK','2020-07-30 15:35:14',37,'Facebook',2,1,1,NULL),(39,'Shiny World Ladies Beauty Parlour & makeup Traning Centre','Shiny World Ladies Beauty Parlour & makeup Traning Centre',NULL,NULL,'Shrabani Dutta','1979-09-20',NULL,'9002310923',NULL,'mp','Upper Nadiha , near agun club\npo Dulmi Nadiha , Purulia',1,'723102',NULL,'A15961037308290.jpg',NULL,NULL,'UEH/WB/20/FR0012',NULL,'2022-08-04 11:35:44','FR15961037329518','2020-08-04 06:05:44','a','2020-07-30 15:39:19',38,'Facebook',2,1,1,NULL),(40,'Sumi Beauty Parlour','Sumi Beauty Parlour',NULL,NULL,'Khandakar Nazia Hossain','1982-03-20',NULL,'8768694969',NULL,'hs','Vill+PO+PS- MURARAI\nBIRBHUM',1,'731219',NULL,'A15961106898380.jpg',NULL,NULL,'UEH/WB/20/FR0013',NULL,'2022-08-04 11:36:08','FR15961106921003','2020-08-04 06:06:08','OK','2020-07-30 17:35:21',39,'Executive Member',2,1,1,'srikanta karmakar'),(41,'Sipra Beauty Parlour','Sipra Beauty Parlour',NULL,NULL,'Sipra Sengupta','1978-01-13',NULL,'6296939540',NULL,'mp','Badya para , Hat Ashuria\nbankura',1,'722204',NULL,'A15961108891813.jpg',NULL,NULL,'UEH/WB/20/FR0014',NULL,'2022-08-04 11:36:39','FR15961108915606','2020-08-04 06:06:39','OK','2020-07-30 17:38:41',40,'Executive Member',2,1,1,'Kakali Roy'),(42,'Labannya Ladies Beauty parlour & Makeup World','Labannya Ladies Beauty parlour & Makeup World',NULL,NULL,'Labani Biswas ( Basak )','1996-10-08',NULL,'7001492747',NULL,'ba','Malda court Station , po Mangalbari Dist malda',1,'732142',NULL,'A15961111385183.jpg',NULL,NULL,'UEH/WB/20/FR0015',NULL,'2022-08-04 11:37:17','FR15961111415683','2020-08-04 06:07:17','OK','2020-07-30 17:42:51',41,'Facebook',2,1,1,NULL),(43,'Sushri Ladies Herbal Beauty parlour','Sushri Ladies Herbal Beauty parlour',NULL,NULL,'Basanti Mallik Dutta','1978-07-12',NULL,'9932670275',NULL,'mp','Bibarda\nBankura',1,'722152',NULL,'A15961113861887.jpg',NULL,NULL,'UEH/WB/20/FR0018',NULL,'2022-08-04 11:40:27','FR15961113891621','2020-08-04 06:10:27','OK','2020-07-30 17:46:59',43,'Facebook',2,1,1,NULL),(44,'Mousumi ladies Beauty Psrlour','Mousumi ladies Beauty Psrlour',NULL,NULL,'Mousumi Chand','1978-05-04',NULL,'9333952510',NULL,'hs','Barabazar , Bankura',1,'722101','P15961156759413.jpg',NULL,NULL,NULL,'UEH/WB/20/FR0021',NULL,'2022-08-04 11:43:07','FR15961156783662','2020-08-04 06:13:07','OK','2020-07-30 18:58:30',44,'Executive Member',2,1,1,'Arup kumar Pal'),(45,'Dream Gents& Ladies Beauty Parlour','Dream Gents& Ladies Beauty Parlour',NULL,NULL,'Sima Roy','1974-12-03',NULL,'7980434636',NULL,'hs','Nabatirtha , udhayrajpur \nmadhyamgram , kolkata',1,'700129',NULL,'A15961159145822.jpg',NULL,NULL,'UEH/WB/20/FR0022',NULL,'2022-08-04 12:06:29','FR15961159176210','2020-08-04 06:36:29','OK','2020-07-30 19:02:29',45,'Executive Member',2,1,1,'Soma Das'),(46,'BUULAN\'S LADIES BEAUTY PARLOUR','BUULAN\'S LADIES BEAUTY PARLOUR',NULL,NULL,'Chandana Dutta','1954-09-15',NULL,'8967063734',NULL,'mp','School Danga , Aakriti Appartment \nBankura',1,'722101',NULL,'A15961161251983.jpg',NULL,NULL,'UEH/WB/20/FR0023',NULL,'2022-08-04 19:04:50','FR15961161276168','2020-08-04 13:34:50','OK','2020-07-30 19:05:59',46,'Executive Member',2,1,1,'Arup Kumar Pal'),(47,'JYOSTNA LADIES BEAUTY PARLOUR','JYOSTNA LADIES BEAUTY PARLOUR',NULL,NULL,'Soma kundu dey','1993-03-04',NULL,'8918433269',NULL,'ba','Katjuru danga , keshra road\nkenduadihi \nbankura',1,'722102',NULL,'A15961164224151.jpg',NULL,NULL,'UEH/WB/20/FR0024',NULL,'2022-08-04 19:05:27','FR15961164255151','2020-08-04 13:35:27','OK','2020-07-30 19:10:57',47,'Executive Member',2,1,1,'Chandana Dutta'),(48,'OUNG  nritya mandir','OUNG  nritya mandir',NULL,NULL,'pijush kanti dhak','1992-03-15',NULL,'7679270674',NULL,'ba','v.u palash danga (pratappur) p.o. sirsara dist: bankura ; p.s.- bankura;',1,'722155',NULL,'A15961169080294.jpg',NULL,NULL,'UEH/WB/20/FR0025',NULL,'2022-08-04 19:18:01','FR15961169118145','2020-08-04 13:48:01','OK','2020-07-30 19:19:03',52,'Facebook',7,1,1,NULL),(49,'Ananya Makeover & Beauty Studio','Ananya Makeover & Beauty Studio',NULL,NULL,'Anamika Ghosh','1995-11-16',NULL,'7908114618',NULL,'B.A .(Honours) Pass','Vill+P.o -Fulia Belemath \np.s - santipur \nsub -Division- Ranaghat \nDISTRICT-Nadia',1,'741402',NULL,'A15966310935683.jpg',NULL,NULL,'UEH/WB/20/FR0046',64,'2022-08-10 18:36:25','FR15966311028230','2020-08-10 13:06:25','OK','2020-08-05 18:09:15',70,'Facebook',2,1,1,NULL),(50,'Mampi Ladies Beauty Parlour','Mampi Ladies Beauty Parlour',NULL,NULL,'Priyanka Roy','1997-07-10',NULL,'7074271070',NULL,'H.S','V+p - Chandipur ,ps Baduriya Dist. North24pgns ,city Chandipur',1,'743237',NULL,'A15966895513604.jpg',NULL,NULL,'UEH/WB/20/FR0047',NULL,'2022-08-10 18:36:42','FR15966895546452','2020-08-10 13:06:42','OK','2020-08-06 10:22:50',71,'Facebook',2,1,1,NULL),(51,'GLAMOUR QUEEN LADIES BEAUTY SALON','GLAMOUR QUEEN LADIES BEAUTY SALON',NULL,NULL,'DIPANNITA BHANDARI','1992-09-11',NULL,'8617592342',NULL,'B.A.     pass','W/O  - JAYANTA BHANDARI \nSHYAM BASUR  CHAK\nCHHOTO   MANOHAR  PUR\nSHYAMBASURCHAK, SOUTH   TWENTY  FOUR  PARGANAS\nWEST  BENGAL  - 743351',1,'743351',NULL,'A15976598291556.jpg',NULL,NULL,'UEH/WB/20/FR0048',NULL,'2022-08-17 20:31:05','FR15976598338456','2020-08-17 15:01:05','ok','2020-08-17 15:54:45',75,'Facebook',2,1,1,NULL),(52,'Midnight Beauty & Foreign Cosmetics by SAMPI❤','Midnight Beauty & Foreign Cosmetics by SAMPI❤',NULL,NULL,'SUPRITI SINGHA ROY','1997-01-28',NULL,'9831253790',NULL,'Bsc- Biotechnology','Vill- Putunda, P.O - Saktigath, Dist - Purba Burdwan, Pin - 713149.\nPh no - 8240761522',1,'713149',NULL,'A15983527723760.jpg',NULL,NULL,NULL,NULL,NULL,'FR15983527778967','2020-08-25 12:01:12','Double Apply..','2020-08-25 16:23:10',NULL,'Internet',16,1,2,NULL),(53,'Midnight Beauty & Foreign cosmetics by SAMPI❤','Midnight Beauty & Foreign cosmetics by SAMPI❤',NULL,NULL,'SUPRITI SINGHA ROY','1997-01-28',NULL,'9831253790',NULL,'Bsc- Biotechnology','Vill- Putunda,  P.O - Saktigarh,  Dist - Purba Burdwan, Pin- 713149.\nPh no - 8240761522',1,'713149',NULL,'A15983531693954.jpg',NULL,NULL,'UEH/WB/20/FR0049',NULL,'2022-08-25 22:29:35','FR15983531724201','2020-08-25 16:59:35','ok','2020-08-25 16:29:45',78,'Internet',16,1,1,NULL),(54,'Priya\'s Makeover & Beautician','Priya\'s Makeover & Beautician',NULL,NULL,'Priya Adhikary Dhalla','1993-08-20',NULL,'6296915832',NULL,'BA','Apc roy Road\nMrizapur\nBasirhat-1\nBasirhat college, north 24 parganas\nWest Bengal-743412',1,'743412',NULL,'A15985146883777.jpg',NULL,NULL,'UEH/WB/20/FR0050',NULL,'2022-08-27 14:33:01','FR15985146924887','2020-08-27 09:03:01','ok...payment receved 1000/-Due 4000/-...Thank you','2020-08-27 13:21:49',79,'Facebook',16,1,1,NULL),(55,'suchismita,s studio &academy','suchismita,s studio &academy',NULL,NULL,'suchismita Biswas','1997-09-25',NULL,'8637043198',NULL,'b.a','radhanagar annapurna saroni Krishnagar nadia near tv tower',1,'741103',NULL,'A15987174694732.jpg',NULL,NULL,'UEH/WB/20/FR0051',NULL,'2022-08-29 21:51:05','FR15987174724120','2020-08-29 16:21:05','ok..payment 1000 receved & Due 4000/-\nthank you \nUEH','2020-08-29 21:41:37',81,'Facebook',16,1,1,NULL),(56,'chaitalis makeup Academy & Beautician','chaitalis makeup Academy & Beautician',NULL,NULL,'Chaitali Nayak','1983-01-01',NULL,'8240115028',NULL,'BA','Chaitali nayak \n41/5 Bachaspati para road\nDakshineswar, kamarhati\nkol=700076',1,'700076',NULL,'A15987821830911.jpg',NULL,NULL,'UEH/WB/20/FR0052',NULL,'2022-09-01 23:21:56','FR15987821868261','2020-09-01 17:51:56','ok...','2020-08-30 15:40:02',84,'Facebook',16,1,1,NULL),(57,'PADMA\'S MAKEOVER & BEAUTICIAN','PADMA\'S MAKEOVER & BEAUTICIAN',NULL,NULL,'Padma Maji','1983-01-22',NULL,'9064595826',NULL,'MP','C/O  - BIREN CHANDRA MAJI . VILL - ITURI ,  POST - TILURI , DIST - BANKURA',1,'722153','P15991272499620.jpg',NULL,NULL,NULL,'UEH/WB/20/FR0053',NULL,'2022-09-03 18:30:03','FR15991272556495','2020-09-03 13:00:03','ok..receved 1000/- Due 4000.....thank you','2020-09-03 15:31:31',85,'Facebook',2,1,1,NULL),(58,'Sharmi\'s makeover Academy','Sharmi\'s makeover Academy',NULL,NULL,'Sarmistha Dutta','1986-01-11',NULL,'9874108647',NULL,'Graduate','24A Rahim Ostagar rd',1,'700045',NULL,'A15994934886082.jpg',NULL,NULL,'UEH/WB/20/FR0054',NULL,'2022-09-08 01:29:45','FR15994934956382','2020-09-08 08:29:45','OK PAID 1000 DUE 4000/-','2020-09-07 08:45:08',87,'Friend',16,1,1,'Supriti Singha Roy'),(59,'Blush','Blush',NULL,NULL,'Tamal sen','1988-12-15',NULL,'9830817773',NULL,'H.s pass','9/4 Sarkar  hat lane,  sarsuna, \nNear sarkar hat kali bedi',1,'700061',NULL,'A15996746972275.jpg',NULL,NULL,'UEH/WB/20/FR0055',NULL,'2022-09-10 00:50:26','FR15996747017301','2020-09-10 07:50:26','ok..Paid 1000/- , Due 9000/- Thank you \nUEH','2020-09-09 11:05:28',88,'Friend',2,1,1,'Shilpi sen'),(60,'puspa\'s makeover institute','puspa\'s makeover institute',NULL,NULL,'puspa biswas','1991-04-10',NULL,'9932472788',NULL,'H.S','vill-kodubari paschim para, po+ps-gazole, dist-malda',1,'732124',NULL,'A16006047453544.jpg',NULL,NULL,'UEH/WB/20/FR0056',27,'2022-09-20 05:54:44','FR16006047506843','2020-09-20 12:54:44','ok','2020-09-20 05:26:12',89,'Executive Member',16,1,1,'Arup Das'),(61,'SOMEN DAS MEKUP STUDIO AND ACADEMY','SOMEN DAS MEKUP STUDIO AND ACADEMY',NULL,NULL,'SOMEN DAS','1990-11-04',NULL,'8789394345',NULL,'HS PAS','BHULI C BLOCK Q NO 199 BHULI NAGAR DHANBAD JHARKHAND',6,'828104',NULL,'A16011144263721.jpg',NULL,NULL,'UEH/JH/20/FR0001',NULL,'2022-09-26 03:29:44','FR16011144304704','2020-09-26 10:29:44','ok','2020-09-26 03:01:29',90,'Executive Member',2,1,1,'KEYA DAS'),(62,'Aparna Yadav','Aparna Yadav',NULL,NULL,'Aparna Yadav','1991-04-21',NULL,'9051117399',NULL,'h.s pass','8/8, R.B.C ROAD DUM DUM CAMT \nGORABAZAR HANUMAN MANDIR',1,'700028',NULL,'A16011320829246.jpg',NULL,NULL,NULL,NULL,NULL,'FR16011320878504','2020-09-26 18:05:48','double filup','2020-09-26 08:01:37',NULL,'Facebook',2,1,2,NULL),(63,'aparna makeup institute & Academy','aparna makeup institute & Academy',NULL,NULL,'aparna yadav','1991-04-21',NULL,'9051117399',NULL,'h.s pass','8/8,R.B.C ROAD DUM DUM CANT \n(GORABAZARHANUMANMANDIR)\nP.O+P.S :-DUM DUM',1,'700028',NULL,'A16011330279300.jpg',NULL,NULL,'UEH/WB/20/FR0057',NULL,'2022-09-26 11:05:32','FR16011330377058','2020-09-26 18:05:32','ok','2020-09-26 08:17:27',91,'Facebook',2,1,1,NULL),(64,'PRIYANKA MEHENDI & MAKEUP STUDIO & ACADEMY','PRIYANKA MEHENDI & MAKEUP STUDIO & ACADEMY',NULL,NULL,'PRIYANKA MONDAL.','1991-12-18',NULL,'8250134080',NULL,'H.S.','VILL+P.O+P.S-ONDA.\nDIST-BANKURA.',1,'722144','P16025152934846.jpg',NULL,NULL,NULL,'UEH/WB/20/FR0058',NULL,'2022-10-15 21:16:50','FR16025153136353','2020-10-15 15:46:50','ok','2020-10-12 20:38:36',93,'Executive Member',2,1,1,'KRISHNADAS KUNDU'),(65,'subhankar\'s makeup & academy','subhankar\'s makeup & academy',NULL,NULL,'subhankar Naskar','1999-08-01',NULL,'8013560312',NULL,'hs','thakuranichak kalitala, p.s.nischinda, post.samabaypally, dist- howrah',1,'711205',NULL,'A16039463336122.jpg',NULL,NULL,'UEH/WB/20/FR0059',NULL,'2022-10-29 10:19:24','FR16039463494424','2020-10-29 04:49:24','Thank you receved 1000/-Due 4000/-...','2020-10-29 10:09:39',95,'Facebook',2,1,1,NULL),(66,'Moumita\'s makeover & beauty salon','Moumita\'s makeover & beauty salon',NULL,NULL,'Moumita Mondal','1986-09-28',NULL,'7679465015',NULL,'HS','C/O - Aditya Mondal\nvill+post-Sonamukhi nimtala\ndist-Bankura',1,'722207',NULL,'A16044034477233.jpg',NULL,NULL,'UEH/WB/20/FR0060',NULL,'2022-11-06 17:25:32','FR16044034614290','2020-11-06 11:55:32','Your Registration & Payment ok...Thank You','2020-11-03 17:07:58',96,'Facebook',2,1,1,NULL),(67,'Tumpa\'s Makeover Studio & Beauty Academy','Tumpa\'s Makeover Studio & Beauty Academy',NULL,NULL,'Tumpa Mandal','1996-10-23',NULL,'8972795936',NULL,'B.sc','vill+p.o-Kalitala, P.S- Hemnagar coastal(Hingalganj) Dist-North 24 Pgs,',1,'743439',NULL,'A16045491321175.jpg',NULL,NULL,'UEH/WB/20/FR0061',NULL,'2022-11-20 15:17:40','FR16045491427085','2020-11-20 09:47:40','ok...full registration paid sucessful','2020-11-05 09:36:00',97,'Facebook',16,1,1,NULL),(68,'Babon\'c Makeover and Academy','Babon\'c Makeover and Academy',NULL,NULL,'Babon Majumder','1996-04-28',NULL,'7872459338',NULL,'graduate','Vill+post: Machalandapur (Chandipur)\nDist: North 24 PGS \npin: 743247',1,'743247',NULL,'A16051472622523.jpg',NULL,NULL,NULL,NULL,NULL,'FR16051472662713','2020-11-12 06:50:27','name not match','2020-11-12 07:44:53',NULL,'Facebook',16,1,2,'Mampi das'),(69,'Babon\'c Makeover and Academy','Babon\'c Makeover and Academy',NULL,NULL,'Manojit Majumdar','1996-04-28',NULL,'7872459338',NULL,'graduate','Vill+PO: Machalandapur (Chandipur)\nDist: North 24 PGS \nPin: 743247',1,'743247',NULL,'A16051481853240.jpg',NULL,NULL,'UEH/WB/20/FR0062',NULL,'2022-11-20 15:17:53','FR16051481897595','2020-11-20 09:47:53','ok...full registration paid sucessful','2020-11-12 08:00:17',98,'Facebook',16,1,1,NULL),(70,'Pranab\'z Makeover','Pranab\'z Makeover',NULL,NULL,'Pranab Biswas','1996-05-11',NULL,'6291725277',NULL,'H.S passed','71,masjid bati binad nagar, Kanchrapara',1,'743145',NULL,'A16060191513882.jpg',NULL,NULL,NULL,NULL,NULL,'FR16060191564054','2020-12-30 17:39:01','Payment no paid ....couse of reject .','2020-11-22 09:56:22',NULL,'Facebook',16,1,2,NULL),(71,'Sumi\'s Makeover Academy','Sumi\'s Makeover Academy',NULL,NULL,'Dulali Deb','1974-03-31',NULL,'9433173562',NULL,'Madhyamik','100 R. K. Banerjee Sarani, Mankundu Dakshinpara, Hooghly. Opposite: Unnayan Sangha',1,'712139',NULL,'A16063610361247.jpg',NULL,NULL,'UEH/WB/20/FR0064',NULL,'2022-12-09 10:12:06','FR16063610389193','2020-12-09 17:12:06','OK','2020-11-26 08:54:08',101,'Facebook',2,1,1,NULL),(72,'SUSMITA\'S MAKEOVER','SUSMITA\'S MAKEOVER',NULL,NULL,'SUSMITA DAS','1999-12-20',NULL,'7685863922',NULL,'Graduate','ND-18/1, Jagatpur, Nabaniketan, Nabalaxmi Khalar math,P.O: Ashwininagar,P.S: Baguiati, Dist: North 24 parganas.',1,'700159',NULL,'A16063934412472.jpg',NULL,NULL,NULL,NULL,NULL,'FR16063934458244','2020-11-26 17:03:07','wrong name academy ....fresh registred ok','2020-11-26 17:54:29',NULL,'Facebook',16,1,2,NULL),(73,'SUSMITA\'S MAKEOVER & ACADEMY','SUSMITA\'S MAKEOVER & ACADEMY',NULL,NULL,'SUSMITA DAS','1999-12-20',NULL,'7685863922',NULL,'Graduate','ND -18/1,  Jagatpur, Nabaniketan, Nabalaxmi Khalar Math, P.O:  Ashwini Nagar, P.S: Baguiati,Dist: North 24 parganas .',1,'700159',NULL,'A16064099513413.jpg',NULL,NULL,'UEH/WB/20/FR0063',NULL,'2022-12-05 17:37:35','FR16064099543511','2020-12-05 12:07:35','Registration payment all complite ..Thank you','2020-11-26 22:29:44',100,'Facebook',16,1,1,NULL),(74,'rashida makeup studio & academic','rashida makeup studio & academic',NULL,NULL,'rashida sultana','1980-01-06',NULL,'9007643300',NULL,'h.s pass','w/o: sk mahmudur Rahman, danga maheshpur, elahipur, hooghly, west bengal, 712707\ncurrent address :- \nrashida Sultana \npriya embroidery\n9 west row\nkolkata:-700017\n(dhagor bazar)',1,'700017',NULL,'A16065854724597.jpg',NULL,NULL,'UEH/WB/20/FR0065',NULL,'2022-12-09 10:12:27','FR16065854752366','2020-12-09 17:12:27','OK','2020-11-28 23:15:05',102,'Friend',2,1,1,'aparna yadav'),(75,'Biswajit\'s creative makeup academy','Biswajit\'s creative makeup academy',NULL,NULL,'Biswajit Das','2000-09-05',NULL,'8617054105',NULL,'HS','Simanta Pally, Krishnanagar, Nadia',1,'741101',NULL,'A16071532879097.jpg',NULL,NULL,'UEH/WB/20/FR0066',NULL,'2022-12-16 05:02:27','FR16071532992672','2020-12-16 12:02:27','Registration Full Paid ..Thank You','2020-12-05 12:58:23',103,'Facebook',2,1,1,NULL),(76,'Happy Moon\'s Makeover & Academy','Happy Moon\'s Makeover & Academy',NULL,NULL,'Munmun Barat','1988-05-17',NULL,'8617395473',NULL,'H.S','Munmun Barat\nc/o ....Jayant Barat\nTaldangra, District- Bankura, pin - 722152,Cinema Road',1,'722152',NULL,'A16102938786712.jpg',NULL,NULL,'UEH/WB/21/FR0001',NULL,'2023-01-23 22:20:33','FR16102938812048','2021-01-23 16:50:32','ok','2021-01-10 21:21:46',104,'Facebook',2,1,1,NULL),(77,'Tapasi makeover and academy','Tapasi makeover and academy',NULL,NULL,'Tapasi dey','1981-09-29',NULL,'7318613357',NULL,'gradutaion','sonamukhi.bidyasagor palli 3 number goli.bankura',1,'722207',NULL,'A16106085993330.jpg',NULL,NULL,'UEH/WB/21/FR0002',NULL,'2023-01-23 22:20:48','FR16106086030350','2021-01-23 16:50:48','ok','2021-01-14 12:46:46',105,'Facebook',2,1,1,NULL),(78,'Shibam Ladies Beauty Parlour','Shibam Ladies Beauty Parlour',NULL,NULL,'Soma Debnath','1987-01-05',NULL,'9933919008',NULL,'Madhayamik','Village+Post - Baikara, Police station - Gaighata, District - North 24 parganas',1,'743245',NULL,'A16106390120568.jpg',NULL,NULL,'UEH/WB/21/FR0003',NULL,'2023-01-23 22:21:04','FR16106390159438','2021-01-23 16:51:04','ok','2021-01-14 21:13:49',106,'Facebook',2,1,1,NULL),(79,'Dipmita makeover','Dipmita makeover',NULL,NULL,'Dipchayanika Das','1982-04-15',NULL,'7002609071',NULL,'H.S.L.C.','W/O : Amrit Das\nN-Aria, Sukanta road, Word no-02;\nLanka; Hojai; Assam',4,'782446',NULL,'A16106429585861.jpg',NULL,NULL,'UEH/AS/21/FR0001',NULL,'2023-02-15 22:50:31','FR16106429630113','2021-02-15 17:20:31','ok ..full paid for Registration','2021-01-14 22:19:37',112,'Facebook',2,1,1,NULL),(80,'Tukai ladies beauty parlour and Ruby\'s makeover','Tukai ladies beauty parlour and Ruby\'s makeover',NULL,NULL,'Ruby Maji','1984-07-20',NULL,'6203424152',NULL,'Matric pass','Tukai ladies beauty parlour,Kundahit, College road',6,'815355',NULL,'A16107730691804.jpg',NULL,NULL,NULL,NULL,NULL,'FR16107731438060','2021-01-16 05:41:02','wrong name ....','2021-01-16 10:30:13',NULL,'Facebook',2,1,2,NULL),(81,'Tukai ladies beauty parlour & makeup world','Tukai ladies beauty parlour & makeup world',NULL,NULL,'Ruby Maji','1984-07-20',NULL,'6203424152',NULL,'Matric pass','Tukai ladies beauty parlour, Kundahit, College road',6,'815355',NULL,'A16107753911578.jpg',NULL,NULL,'UEH/JH/21/FR0001',NULL,'2023-02-08 23:10:27','FR16107754147721','2021-02-08 17:40:27','ok','2021-01-16 11:08:03',108,'Facebook',2,1,1,NULL),(82,'SUBHAM LADIES BEAUTYPARLOR','SUBHAM LADIES BEAUTYPARLOR',NULL,NULL,'PARBATI SARKAR','1983-12-25',NULL,'8944851233',NULL,'8th pass','VILL-NARIKELA, P.O+P.S-GAIGHATA, DIST-NORTH 24 PARGANA, PIN-743249',1,'743249',NULL,'A16114181419633.jpg',NULL,NULL,'UEH/WB/21/FR0005',NULL,'2023-02-08 23:11:18','FR16114181719003','2021-02-08 17:41:18','ok','2021-01-23 21:39:41',110,'Internet',2,1,1,NULL),(83,'Golap Makeover & Beautician Academy','Golap Makeover & Beautician Academy',NULL,NULL,'Gulab Das','1997-11-29',NULL,'8910954392',NULL,'10th pass','15 TELIPARA CHATRA Baidyabati municipality 272/b cultural unit math',1,'712204',NULL,'A16114245743665.jpg',NULL,NULL,'UEH/WB/21/FR0004',NULL,'2023-02-08 23:11:05','FR16114245803621','2021-02-08 17:41:05','ok ..all payment complit ..thank you','2021-01-23 23:26:22',109,'Facebook',2,1,1,NULL),(84,'Rinki\'S  Makeup & Academy','Rinki\'S  Makeup & Academy',NULL,NULL,'Rinki Mondal','2003-02-05',NULL,'8777814378',NULL,'H. S.','Noapara, Chandannagar, Hooghly',1,'712138',NULL,'A16114617004465.jpg',NULL,NULL,NULL,NULL,NULL,'FR16114617040302','2021-02-07 04:08:54','Application reject ..Remark -payment issue...','2021-01-24 09:45:21',NULL,'Facebook',16,1,2,NULL),(85,'Baishali\'z creations','Baishali\'z creations',NULL,NULL,'Baishali Pradhan','1987-04-23',NULL,'8768437044',NULL,'BA','Gangadharpur Golabari Howrah.',1,'711302',NULL,'A16120233730957.jpg',NULL,NULL,'UEH/WB/21/FR0006',NULL,'2023-02-08 23:11:58','FR16120233789686','2021-02-08 17:41:58','ok all payment complit ..thank you','2021-01-30 21:46:26',111,'Friend',16,1,1,'Joyeeta di'),(86,'Rup\'s Makeover Beauty seloon &spa','Rup\'s Makeover Beauty seloon &spa',NULL,NULL,'Rupa Ghosh','1989-09-10',NULL,'7003143003',NULL,'9th pass','memanpur kalitola\nPO- vivekananda Pally\nPS- MAHESHTALA',1,'700139',NULL,'A16130532696450.jpg',NULL,NULL,'UEH/WB/21/FR0007',NULL,'2023-02-26 09:59:53','FR16130532726721','2021-02-26 16:59:53','ok..Registration full paid ..thank you','2021-02-11 19:52:09',114,'Facebook',16,1,1,NULL),(87,'Moumita\'z makeup studio & academy','Moumita\'z makeup studio & academy',NULL,NULL,'Moumita Biswas','1989-06-03',NULL,'7872249374',NULL,'M.A','vill+p.o- Baran beria\ndist-Nadia\np.s-Dhantala',1,'741504',NULL,'A16136646644462.jpg',NULL,NULL,NULL,NULL,NULL,'FR16136646720098','2021-03-29 12:36:51','no payment done','2021-02-18 09:11:30',NULL,'Facebook',16,1,2,NULL),(88,NULL,'Piu Bera',NULL,NULL,'Piu Bera','2021-03-05',NULL,'8637381927',NULL,'class 8','contai',1,'721401',NULL,'A16149336930392.jpg',NULL,NULL,NULL,NULL,NULL,'FR16149336982225','2021-03-05 09:17:02','wrong communication','2021-03-05 01:42:29',NULL,'Internet',2,1,2,NULL),(89,NULL,'Sneha\'s Make-up Artistry (Studio and Academy)',NULL,NULL,'Sneha Biswas Mondal','1991-06-25',NULL,'9062327984',NULL,'MA','Subhasgram RNC Road (East), p.o-subhasgram,p.s-Sonarpur,Kol-700147,West Bengal, India',1,'700147',NULL,'A16150426904807.jpg',NULL,NULL,'UEH/WB/21/FR0008',NULL,'2023-03-12 08:32:30','FR16150426943285','2021-03-12 15:32:30','ok full paid of registration , thank you','2021-03-06 07:58:18',115,'Facebook',16,1,1,NULL),(90,NULL,'Makeup And Hair By Gargee',NULL,NULL,'Gargi Das','1991-07-02',NULL,'8910802606',NULL,'B.Sc','107 Shibtala Street Bhadrakali Hooghly',1,'712232',NULL,'A16158144163121.jpg',NULL,NULL,'UEH/WB/21/FR0010',NULL,'2023-04-04 13:56:32','FR16158144203395','2021-04-04 13:56:32','ok.Registration Fees Full Payment . Thank You','2021-03-15 06:20:34',118,'Facebook',16,1,1,NULL),(91,NULL,'BHASWATI\'S MAKEOVER',NULL,NULL,'BHASWATI PAL','1995-09-30',NULL,'7003064819',NULL,'12 pass','74, MAKHLA JELEPARA,   P.O -  MAKHLA,   P.S - UTTARPARA,  DIST - HOOGHLY,',1,'712245',NULL,'A16161726780851.jpg',NULL,NULL,'UEH/WB/21/FR0009',NULL,'2023-03-27 14:07:11','FR16161726820380','2021-03-27 14:07:11','OK FULL PAID OF REGISTRATION .\nThank you','2021-03-19 09:51:29',116,'Internet',16,1,1,NULL),(92,NULL,'Neharch Beauty Exclusive Makeover',NULL,NULL,'Sneha Paul','2001-06-09',NULL,'8910561683',NULL,'Graduation','41, k. k ramdas road, Golbagan, north nimta, Kolkata 700 049',1,'700049','P16177670027684.jpg',NULL,NULL,NULL,'UEH/WB/21/FR0011',NULL,'2023-04-25 12:02:38','FR16177670037515','2021-04-25 12:02:38','Ok.Registration fees Due 5000/- thank you .','2021-04-07 03:43:23',119,'Facebook',16,1,1,NULL),(93,NULL,'Aalo\'s mekeover',NULL,NULL,'Dipa singha','1989-08-20',NULL,'7620100064',NULL,'m.a','Laxmi bidi road( near bus stand)\npost - dhuliyan.\ndist - murshidabad\np.s - samserganj\nstate- w.b',1,'742202',NULL,'A16183205405465.jpg',NULL,NULL,'UEH/WB/21/FR0012',NULL,'2023-04-25 12:03:21','FR16183206359010','2021-04-25 12:03:21','Ok Thank you Your Registration Fees full payment Done','2021-04-13 13:30:37',120,'Facebook',2,1,1,NULL);
/*!40000 ALTER TABLE `ueh_franchise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_franchise_type`
--

DROP TABLE IF EXISTS `ueh_franchise_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_franchise_type` (
  `franchise_type_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `franchise_type_name` longtext DEFAULT NULL,
  `franchise_type_status` int(11) DEFAULT 1,
  `franchise_type_created_by` int(11) DEFAULT NULL,
  `franchise_type_created_at` datetime DEFAULT current_timestamp(),
  `franchise_type_updated_by` int(11) DEFAULT NULL,
  `franchise_type_updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`franchise_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_franchise_type`
--

LOCK TABLES `ueh_franchise_type` WRITE;
/*!40000 ALTER TABLE `ueh_franchise_type` DISABLE KEYS */;
INSERT INTO `ueh_franchise_type` VALUES (1,'ART & PAINTING SCHOOL',1,NULL,'2020-05-11 14:25:36',NULL,'2020-05-11 14:25:36'),(2,'BEAUTY PARLOUR',1,NULL,'2020-05-11 14:25:36',NULL,'2020-05-11 14:25:36'),(3,'YOGA & PRANAYAM TRANING CENTRE',1,NULL,'2020-05-11 14:25:38',NULL,'2020-05-11 14:25:38'),(4,'MUSIC & MUSICAL INSTRUMENT TRANING CENTRE',1,NULL,'2020-05-11 14:25:38',NULL,'2020-05-11 14:25:38'),(5,'KUMPHU / KARATE SCHOOL',1,NULL,'2020-05-11 14:25:39',NULL,'2020-05-11 14:25:39'),(6,'COMPUTER TRANING CENTRE',1,NULL,'2020-05-11 14:25:40',NULL,'2020-05-11 14:25:40'),(7,'DANCE AND SONG SCHOOL',1,NULL,'2020-05-11 14:25:41',NULL,'2020-05-11 14:25:41'),(8,'SPOKEN ENGLISH',1,NULL,'2020-05-11 14:25:42',NULL,'2020-05-11 14:25:42'),(9,'VOCATIONAL TRAINING CENTRE',1,NULL,'2020-05-11 14:25:42',NULL,'2020-05-11 14:25:42'),(10,'BOUTIQUE',1,NULL,'2020-05-11 14:25:43',NULL,'2020-05-11 14:25:43'),(11,'ANY SKILL DEVELOPMENT CENTRE',1,NULL,'2020-05-11 14:25:44',NULL,'2020-05-11 14:25:44'),(12,'PLAY SCHOOL(PLAY TO UKG)',1,NULL,'2020-05-11 14:25:46',NULL,'2020-05-11 14:25:46'),(13,'ANY JOB ORIENTED TEACHING AND TRAINING INSTITUTES',1,NULL,'2020-05-11 14:25:46',NULL,'2020-05-11 14:25:46'),(14,'HANDY CRAFT',1,NULL,'2020-05-11 14:25:47',NULL,'2020-05-11 14:25:47'),(15,'MEHANDI ARTIST',1,NULL,'2020-05-11 14:25:47',NULL,'2020-06-02 15:50:26'),(16,'MAKEUP ARTIST',1,NULL,'2020-07-01 17:01:28',NULL,'2020-07-01 17:01:28');
/*!40000 ALTER TABLE `ueh_franchise_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_gallery`
--

DROP TABLE IF EXISTS `ueh_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_gallery` (
  `gallery_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gallery_name` longtext DEFAULT NULL,
  `gallery_description` longtext DEFAULT NULL,
  `gallery_image` longtext DEFAULT NULL,
  `gallery_status` int(11) DEFAULT 1,
  `gallery_created_by` int(11) DEFAULT NULL,
  `gallery_created_at` datetime DEFAULT current_timestamp(),
  `gallery_updated_by` int(11) DEFAULT NULL,
  `gallery_updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_gallery`
--

LOCK TABLES `ueh_gallery` WRITE;
/*!40000 ALTER TABLE `ueh_gallery` DISABLE KEYS */;
INSERT INTO `ueh_gallery` VALUES (1,'a','a','2.jpeg',1,NULL,'2020-05-11 15:02:46',NULL,'2020-05-11 15:02:46'),(2,'a','a','3.jpeg',1,NULL,'2020-05-11 15:02:47',NULL,'2020-05-11 15:02:47'),(3,'a','a','5_1.jpeg',1,NULL,'2020-05-11 15:02:48',NULL,'2020-05-11 15:02:48'),(4,'a','a','6_1.jpeg',1,NULL,'2020-05-11 15:02:48',NULL,'2020-05-11 15:02:48'),(5,'a','a','7.jpeg',1,NULL,'2020-05-11 15:02:49',NULL,'2020-05-11 15:02:49'),(6,'a','a','9.jpeg',1,NULL,'2020-05-11 15:02:49',NULL,'2020-05-11 15:02:49'),(7,'a','aa','10.jpeg',1,NULL,'2020-05-11 15:02:50',NULL,'2020-05-11 15:02:50'),(8,'a','a','11.jpeg',1,NULL,'2020-05-11 15:02:51',NULL,'2020-05-11 15:02:51');
/*!40000 ALTER TABLE `ueh_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_role`
--

DROP TABLE IF EXISTS `ueh_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_role` (
  `role_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_name` longtext DEFAULT NULL,
  `role_status` int(11) DEFAULT 1,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_role`
--

LOCK TABLES `ueh_role` WRITE;
/*!40000 ALTER TABLE `ueh_role` DISABLE KEYS */;
INSERT INTO `ueh_role` VALUES (1,'Franchise',1),(2,'Executive',1),(3,'Student',1),(4,'Admin',1);
/*!40000 ALTER TABLE `ueh_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_state`
--

DROP TABLE IF EXISTS `ueh_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_state` (
  `state_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `state_name` longtext DEFAULT NULL,
  `state_code` longtext DEFAULT NULL,
  `state_status` int(11) DEFAULT 1,
  `state_created_by` int(11) DEFAULT NULL,
  `state_created_at` datetime DEFAULT current_timestamp(),
  `state_updated_by` int(11) DEFAULT NULL,
  `state_updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_state`
--

LOCK TABLES `ueh_state` WRITE;
/*!40000 ALTER TABLE `ueh_state` DISABLE KEYS */;
INSERT INTO `ueh_state` VALUES (1,'West Bengal','WB',1,NULL,'2020-05-11 13:29:37',NULL,'2020-05-11 13:29:37'),(2,'Tripura','TP',1,NULL,'2020-05-11 13:29:38',NULL,'2020-05-11 13:29:38'),(3,'Arunachal Pradesh','AR',1,NULL,'2020-05-11 13:29:38',NULL,'2020-05-11 13:29:38'),(4,'Assam','AS',1,NULL,'2020-05-11 13:29:39',NULL,'2020-05-11 13:29:39'),(5,'Bihar','BR',1,NULL,'2020-05-11 13:29:42',NULL,'2020-05-11 13:29:42'),(6,'Jharkhand','JH',1,NULL,'2020-05-11 13:29:43',NULL,'2020-05-11 13:29:43'),(7,'Manipur','MN',1,NULL,'2020-05-11 13:29:43',NULL,'2020-05-11 13:29:43'),(8,'Mizoram','MZ',1,NULL,'2020-05-11 13:29:45',NULL,'2020-05-11 13:29:45'),(9,'Nagaland','NG',1,NULL,'2020-05-11 13:29:46',NULL,'2020-05-11 13:29:46'),(10,'Odisha','OD',1,NULL,'2020-05-11 13:29:46',NULL,'2020-05-11 13:29:46'),(11,'Sikkim','SK',1,NULL,'2020-05-11 13:33:49',NULL,'2020-05-11 13:33:49'),(12,'Meghalaya','ML',1,NULL,'2020-05-11 13:33:51',NULL,'2020-05-11 13:33:51'),(13,'Delhi','DL',1,NULL,'2020-05-11 13:33:51',NULL,'2020-05-11 13:33:51'),(14,'Haryana','HR',1,NULL,'2020-05-11 13:33:52',NULL,'2020-05-11 13:33:52'),(15,'Jammu & Kasmir','JK',1,NULL,'2020-05-11 13:33:53',NULL,'2020-05-11 13:33:53'),(16,'Himachal Pradesh','HP',1,NULL,'2020-05-11 13:33:55',NULL,'2020-05-11 13:33:55'),(17,'Uttar Pradesh','UP',1,NULL,'2020-05-11 13:33:56',NULL,'2020-05-11 13:33:56'),(18,'Punjab','PB',1,NULL,'2020-05-11 13:33:57',NULL,'2020-05-11 13:33:57'),(19,'Uttarakhand','UT',1,NULL,'2020-05-11 13:33:58',NULL,'2020-05-11 13:33:58'),(20,'Rajasthan','RJ',1,NULL,'2020-05-11 13:33:59',NULL,'2020-05-11 13:33:59'),(21,'Andhra Pradesh','AP',1,NULL,'2020-05-11 13:34:01',NULL,'2020-05-11 13:34:01'),(22,'Karnataka','KA',1,NULL,'2020-05-11 13:34:02',NULL,'2020-05-11 13:34:02'),(23,'Kerala','KL',1,NULL,'2020-05-11 13:34:03',NULL,'2020-05-11 13:34:03'),(24,'Tamil Nadu','TN',1,NULL,'2020-05-11 13:34:04',NULL,'2020-05-11 13:34:04'),(25,'Telangana','TG',1,NULL,'2020-05-11 13:34:05',NULL,'2020-05-11 13:34:05'),(26,'Gujarat','GJ',1,NULL,'2020-05-11 13:34:06',NULL,'2020-05-11 13:34:06'),(27,'Maharashtra','MH',1,NULL,'2020-05-11 13:34:07',NULL,'2020-05-11 13:34:07'),(28,'Madhya Pradesh','MP',1,NULL,'2020-05-11 13:34:08',NULL,'2020-05-11 13:34:08'),(29,'Chhattisgrah','CG',1,NULL,'2020-05-11 13:34:08',NULL,'2020-05-11 13:34:08'),(30,'Goa','GA',1,NULL,'2020-05-11 13:34:11',NULL,'2020-05-11 13:34:11');
/*!40000 ALTER TABLE `ueh_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_student`
--

DROP TABLE IF EXISTS `ueh_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_student` (
  `student_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `student_name` longtext DEFAULT NULL,
  `student_guardian_name` longtext DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `student_dob` date DEFAULT NULL,
  `student_age` longtext DEFAULT NULL,
  `student_mobile` varchar(45) DEFAULT NULL,
  `student_educational_qualification` longtext DEFAULT NULL,
  `student_address` longtext DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `student_pin` longtext DEFAULT NULL,
  `franchise_id` int(11) DEFAULT NULL,
  `student_document_pan` longtext DEFAULT NULL,
  `student_document_aadhar` longtext DEFAULT NULL,
  `student_document_voter_card` longtext DEFAULT NULL,
  `student_code` varchar(45) DEFAULT NULL,
  `student_registration_code` varchar(45) DEFAULT NULL,
  `student_session` longtext DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `student_information_source` longtext DEFAULT NULL,
  `student_status` int(11) DEFAULT 1,
  `student_created_at` datetime DEFAULT current_timestamp(),
  `student_updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_student`
--

LOCK TABLES `ueh_student` WRITE;
/*!40000 ALTER TABLE `ueh_student` DISABLE KEYS */;
INSERT INTO `ueh_student` VALUES (1,'Priyabrata Maiti',NULL,1,'2020-06-13',NULL,'7384809452','bb','hhjj',1,'722101',9,NULL,NULL,NULL,'UEH/WB/20/S00001','UEH/WB/20/R00001',NULL,6,'Facebook',3,'2020-06-13 13:14:30','2020-06-13 13:14:30'),(2,'SOMA DE',NULL,2,'1993-03-04',NULL,'8918433269','B.A PASS','katjuridanga,kenduadihi,bankura,West Bengal,722102',1,'722102',47,NULL,NULL,NULL,'UEH/WB/20/S00002','UEH/WB/20/R00002',NULL,69,'Facebook',2,'2020-08-04 22:33:42','2020-08-04 22:33:42');
/*!40000 ALTER TABLE `ueh_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ueh_user`
--

DROP TABLE IF EXISTS `ueh_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ueh_user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `user_name` longtext DEFAULT NULL,
  `user_dob` date DEFAULT NULL,
  `user_mobile_number` longtext DEFAULT NULL,
  `password` longtext DEFAULT NULL,
  `user_profile_image` longtext DEFAULT NULL,
  `user_email_id` longtext DEFAULT NULL,
  `user_device_token` longtext DEFAULT NULL,
  `user_status` int(11) DEFAULT 1,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ueh_user`
--

LOCK TABLES `ueh_user` WRITE;
/*!40000 ALTER TABLE `ueh_user` DISABLE KEYS */;
INSERT INTO `ueh_user` VALUES (1,1,'Gour Bhattacharya','2020-05-11','8597500501','$2y$10$v3M.C8IMnpbwupy2Z6J6uOMJyq6UxIKxODRETK0UC5/2FnCQGBNnK','1588243525111_1.jpg',NULL,'dDkI3FJZQLSvXhO6slx3fU:APA91bFr-BMgmFjPGqeYVSfvDlyZ2ZBM2Nj_QvjhBSVDn6MnvXw2ZULpJ8ibCcBVZIr26ZWrR98JQHlJZwJstFVnMC0YqojIwUOZ8wTKF7s8Ksx0WutjFPE_viEOn-T-_DOyV2FIhy7p',1),(2,2,'Test Purpose','2020-05-11','9800150003','$2y$10$yz94jumE68zTmYU0b7FmP.9CCPFPvrFsooi4Z..xRmRJDRtA01bte','default.png',NULL,'eP4xCDtoTqKTqdhYFrCDD4:APA91bG4HyBgxo094UMn8eo89rZ5QweWjDAX243fapXkNGCRsEWh50lCzg975n9rv9HwExBJrHZfF9hfLzrMVpGrujJXk9YBbG2ay-Jv5DUOaOGPMlfAP3s-CPIXc0bzFcLRxyFTedCU',1),(3,2,'srikanta karmakar','1989-11-22','9614137545','$2y$10$WLPE0rpKujj2Zn0xKvijZutgWMhe.alnyyfVbqDy8gVVj8XLppGHe','default.png',NULL,NULL,1),(4,2,'chandan rakshit','1975-03-26','9434224182','$2y$10$gNOd.tZBcMMc5MkHnunHweUUYBGrJQSYp8kmwBv4pZGLurneKx8Qa','default.png',NULL,NULL,1),(5,2,'Sukla Dey','1990-05-04','9064248665','$2y$10$cghisBb.nmSn9MobixULXOdkf3RkzsAeXATyVMzY32/bMz7.LKebm','default.png',NULL,NULL,1),(6,2,'Soma das','1988-06-30','9749422269','$2y$10$P7KCoAbJ7WFxKwVW.zDLNeQCsAbP1Agnw1OOjeCl8ZnmjwgNMBfIW','default.png',NULL,NULL,1),(7,2,'kakali Roy','1987-05-13','9932365544','$2y$10$ZWAnb2krTz08jWrdCDWjfu1xtxWiygeauh6FZYvcFyw9NbZOKY5si','default.png',NULL,NULL,1),(8,2,'kshudiram karmakar','1991-03-02','6294580829','$2y$10$K35ua4xGRNl6X8g7YS3wLOD6KlPlkpJ1ACXuCQ6h6itli6HLDXcw6','default.png',NULL,NULL,1),(9,2,'Rajkumar mondal','1986-09-19','8116678954','$2y$10$g8ea7EasBnhILHHeaM3dhetrz6fvdENiig/2Q.DTvtvw2lwD2CRIW','default.png',NULL,NULL,1),(10,2,'Arup kumar pal','1976-01-25','8116208564','$2y$10$qzTXGABTmKZIQEUQHL6OCedyk.VuF6UEseLyj.evqU6xHQoOky6cK','default.png',NULL,NULL,1),(11,2,'Radhanath Chakrabarty','1978-11-28','6295860158','$2y$10$tsTJmHYI6uR6CdqW2gYXH.mv0.B4iPn9zexjs/haVkpR7pKFTW45O','default.png',NULL,NULL,1),(12,2,'chand middya','1999-10-01','7029313814','$2y$10$AzdvfoPg/l1iQSbcUiTlTuwjHi4Dqd3SrtO6gv386/8kDJqww8txy','default.png',NULL,NULL,1),(13,2,'Sourav Dey','1977-11-12','8910804614','$2y$10$yaaMuLNpS0OSWTfKYRTQq.qjFbNEZCxkKNKLdN9d51aXw7TmxfwsG','default.png',NULL,NULL,1),(14,2,'Rajkumar ghosh','1969-07-03','9875595588','$2y$10$ecoeUfEGLS9YBsh1.YTk4u1fbt3JYaC9HGcSGW9AtTFP33BAdeK/2','default.png',NULL,NULL,1),(15,2,'Gour panja','1994-01-31','8918733236','$2y$10$Bm9cCxJULYiIqVE0CF5FGeRIMRsoPfMn5p0zVgyEOONhPTETGQgRa','default.png',NULL,NULL,1),(16,2,'sanjay ghosh','1996-01-04','8327327911','$2y$10$i3CkJubxTOzMFykE/JNELu9tvOCXwKjM/jQO5GDAH.9x9EVq6FF0a','default.png',NULL,NULL,1),(17,2,'chandana dutta','1954-09-15','8967063735','$2y$10$ruQv5jD1ATg2p1FvTly.UO8siJt2U/Ka7wFcmopWmx4g6bGFXGI0m','default.png',NULL,NULL,1),(18,2,'swapan kumar barik','1979-09-14','7047127767','$2y$10$tbhs6J7/BQKs5hidb8gcZ.oiZKFDEk5MsVKO2JARvRwvQihP0JNc6','default.png',NULL,NULL,1),(19,2,'Dipak Saha','1964-03-04','7044191972','$2y$10$L3aRWAW46XlxGDiWMgjKSuLtcIT79yiUufvAxtytbYeYYds4DuVqC','default.png',NULL,NULL,1),(20,2,'pijush kanti dhak','1992-03-15','7679270675','$2y$10$h2DS21Tu2g3wjaVeTlro9uapPXfHjXucPsq9FEX5UBOVv1xTdwXp.','default.png',NULL,NULL,1),(21,2,'Antara Acharya','1988-08-26','9903698370','$2y$10$0pil2vwE8gyn6S9Ce0wQhe6dKeCihoT6FJjO8I8BNxHbsVKriWnsq','default.png',NULL,NULL,1),(22,2,'ASHIS BISWAS','1994-03-11','9126875748','$2y$10$nVAogiEC5KytC3YfJyAJleCBCs8eystx7EXYWvG1dTx.2cmuUO3va','default.png',NULL,'cUh7PtMSRa6O1A7Fu0JWSs:APA91bFtrZUW18ODLeThnMdCudVU5U7vWkOKzrANjlU6xZfrllvv4YhwCidVGwiNjGzeX1vICmF4ON544LV4dYTavuqiNZRGY58NLPGsdd2Q6J6ytVYPFSueCR0vNvicSfdsvfgJIHIC',1),(23,2,'Nirupama Nandi','1997-10-01','8777864869','$2y$10$/ri.j5gegey/7SIrKCD0FurDbBMII174g1EOcvaOxUPfQV6.4ug1C','default.png',NULL,NULL,1),(24,2,'Kashnaprava Halder Bhattacharjee','1977-09-30','8420658623','$2y$10$Rl8h1T9sk95bRFRcZEmhL.vgNbQmqIMXATW801T02ByGmvtGeLilS','default.png',NULL,NULL,1),(25,2,'Tapan Paul','1980-08-08','9064359334','$2y$10$weUI5TyN9jKNWMnIB6MuROdWGlNcg2qU0JZzQH/pGfDu5s5XOghMS','default.png',NULL,NULL,1),(26,2,'Madhumanti Chowdhury','2004-10-11','7439349136','$2y$10$1Sr33vyUQviBTkEtLvOQU.nZ.nkTKu3LNo552HA9d/jKY2YiZGDMi','default.png',NULL,NULL,1),(27,2,'Arup Das','1987-02-08','9748713213','$2y$10$wCFphQpyovuw8PNQJhvnj.FtnlbxmpXGuuV56jIqd8DJtBnyoAbfC','default.png',NULL,'dDkI3FJZQLSvXhO6slx3fU:APA91bFr-BMgmFjPGqeYVSfvDlyZ2ZBM2Nj_QvjhBSVDn6MnvXw2ZULpJ8ibCcBVZIr26ZWrR98JQHlJZwJstFVnMC0YqojIwUOZ8wTKF7s8Ksx0WutjFPE_viEOn-T-_DOyV2FIhy7p',1),(28,2,'Nargish Nazeer Hossain','2021-07-01','9595067484','$2y$10$6A6Xmf80ivqqJGb9Iqj8yOjgcesABNRYhbF3QdcMaIDFU4Ft9HDqC','default.png',NULL,NULL,1),(29,2,'puja maity','2020-07-01','9083187697','$2y$10$P.5sDpCrZz9p778h0VGzGuB/BakaY5rGV2qDFnz0pbYJXO.h7L3HS','default.png',NULL,NULL,1),(30,1,'Gour Bhattacharya','1983-09-02','9332679700','$2y$10$a5MfdTqEMo3Qn/L69vvp4Or13TpgbOGD8Axl/FU49eg9Vd.bu.Ayy','1596552218466.jpg',NULL,'dDkI3FJZQLSvXhO6slx3fU:APA91bFr-BMgmFjPGqeYVSfvDlyZ2ZBM2Nj_QvjhBSVDn6MnvXw2ZULpJ8ibCcBVZIr26ZWrR98JQHlJZwJstFVnMC0YqojIwUOZ8wTKF7s8Ksx0WutjFPE_viEOn-T-_DOyV2FIhy7p',1),(31,1,'Manasi Chaudhuri','1997-01-01','9732084567','$2y$10$UGlaFX5DtwDQX6yu8dLsJ.CL6rMwbDJ/7Kvg0RFbn2fsZzS22gjp6','default.png',NULL,NULL,1),(32,1,'Munmun Kar','1990-05-12','7908988336','$2y$10$BbGWzrDZ3v0PJjs5GseAaugqWIaqe2VZHofwYv0pgnvYP/Fxs7GMi','default.png',NULL,NULL,1),(33,1,'Sampa Saha','1985-11-22','9748702775','$2y$10$W2SjcgPsw9ZW4VLvLNAVkeN1vJEKuLPl.0Vm6IjyHuTPPTmxY46I6','default.png',NULL,'cAnTMSKzR2SFBENeoJpIyJ:APA91bFPQgRjjSXNw0PF0AlK6-YWHs67wHTnhsbUf2L_D87Y_HH4Pl0_yxGaO6I_6mBRub8lu4P0GIFBxt3_sww3aAPeg_As4jORWcXap3Qn4HmxjHtIIG5GMJOpLMlIc16VfptsCAoN',1),(34,1,'Runu singha','1979-08-24','9614802745','$2y$10$m8/1JVv10T9iPqxjkSq6IuUwmu0XMB2pr7WtccAq.idmdxzHyflJi','default.png',NULL,NULL,1),(35,1,'Parikshit Mandal','2000-10-24','8250466943','$2y$10$BtMdhiCQwi/qt9gCh.FGmOY4mRCPtBiUv3SyAPYtf4bOwFpdZHPb.','1596549047287.jpg',NULL,'fmD6KvhBQDmc1MNwlMV0hZ:APA91bFqw9Z73_NQE7HOT7RBXc_E-ImOBTdtRGjcTN33B5pqC0IQ6JVAczRk0I-c4j9BM8e2Nuc9oDaHo9JtA7bEzL9C0SikzZL-BX3PM3h9gGAnw8Cnxe1RmNHQrjDRJj43MqJ1dVR8',1),(36,1,'Sayani Mullick','1993-07-28','9831347333','$2y$10$B2NVbDJ7pOdV6L0i2kyqmOf0CgqJBw7/UY/Neiyhx0KCWZr17XzYy','default.png',NULL,NULL,1),(37,1,'Pali Saha','1975-09-03','9748416112','$2y$10$x9oLmuu03wb0Sez2lSkCvO45iWzHCJxm3ngpXf6kU8o2k1zScMRSa','default.png',NULL,NULL,1),(38,1,'Shrabani Dutta','1979-09-20','9002310923','$2y$10$cc7j7nJLj0c79QRA1oUu7.m7YVTNYSqvd9zZxaQdofbTKWJ9jVEs.','default.png',NULL,NULL,1),(39,1,'Khandakar Nazia Hossain','1982-03-20','8768694969','$2y$10$vzKemGw/a4U7Ily1uVI5J.vyjFvNd1km0NLJHEpdw9DDhSIv9bXIG','default.png',NULL,NULL,1),(40,1,'Sipra Sengupta','1978-01-13','6296939540','$2y$10$or5uTSuqIDZp7f4u.3Vj7.aCHUgQWpJ11EUrHdEiiwNaS7XqDLeiC','default.png',NULL,NULL,1),(41,1,'Labani Biswas ( Basak )','1996-10-08','7001492747','$2y$10$GSGtvVCDET5O9oVhDIoV0OUPQDM/10V/XHNJZk.hBENPxEVf2k0M2','default.png',NULL,'d7Oyxsn8RAGMo_-TUy9Tma:APA91bELU59ejsQzO7riVUpdhY8gXD0yU25ws9o-JQhPPGMYf8FMcQQfxlo7n-qTpEhPyTPDm9CWTha72Lj318VqbApbVhlaogbQ54kIuYkNHDm1JFFetNpQSWlC0-zIDhRyUka4DqDg',1),(42,1,'Subhra das (  gan )','2020-06-17','9732552494','$2y$10$7GStw98ZSDFOYqtVpjGgdOq3i7lE8EQC7AEb/rsJjp2Uk/.rb1A4m','default.png',NULL,NULL,1),(43,1,'Basanti Mallik Dutta','1978-07-12','9932670275','$2y$10$AwQS.7CQ1jiqNUGhgdjXD.7LVZDDlFjq6elBqntcPInimHsezeEjy','default.png',NULL,NULL,1),(44,1,'Mousumi Chand','1978-05-04','9333952510','$2y$10$URr9kHAt9TKRFo1TSqwCpOCUSaotffOMrXSZD5NuKb1ka5dv3TQ46','default.png',NULL,NULL,1),(45,1,'Sima Roy','1974-12-03','7980434636','$2y$10$2cxNUqqQOX02MDWfVAYTKexqq6UTQsl7XOhYcCGmNWphKujaXtgjK','default.png',NULL,NULL,1),(46,1,'Chandana Dutta','1954-09-15','8967063734','$2y$10$6lH4y0Yk8l2TIviouSW85OKovl/W8uV0jypF2MfPafxzxylKrV5WO','default.png',NULL,NULL,1),(47,1,'Soma kundu dey','1993-03-04','8918433269','$2y$10$mN8cfcHFNAHzp/y9.JqjceJ6mrE8FcgUdzph3vm99S6kB.iD3aIg.','1596560733077.jpg',NULL,'f9ntVF7JQEil5_xIRlPtXQ:APA91bEKUPnRlTtyqwrWnyWx5SlczqJUV9FhSrX8gvr1pBOWUE_fZaRV2-1qsA3X_awHAYRB5VcRg3Caz8KTzDZ-NA11gjwPQmLEYJUyEF-IvXlg48niNUrPsKW5c3LtpIdEZ0cv46ZQ',1),(48,1,'Debyani chatterjee','1984-07-21','7063810465','$2y$10$Bqzw6.eXhZLqrfHwceO82e1TJZqPLf4Lln3sCAjZK8BYm1QUT2I/W','1596598205497.jpg',NULL,'fA3JowxORKmaO8Z-57fYLi:APA91bGnF2eWN0r4KfEK5PSCbpqt4i_Aw8fR8byqAbohl_kYD2yMOoV-qSxy1HZoR-VVKnE_CmKPd8kLu0p7EVLvd3gxc3R8fkOrs6rU0lmuGq6sSZF__j5K3hsYoI3z4vbMbvvMljfx',1),(49,1,'ILA DAS','1991-07-23','9836581443','$2y$10$vjOZ8HO6TCZ8llIbsbdQ/umWrNKkT8IhUz7mw6BIU45o/sdVvnwdO','default.png',NULL,'dX05bjPiTXWIBJpOv-Yqyu:APA91bHTRfJX1uA4h3tHkG0qH2_Izw4yeh8Yf83Mmcyrv9rdy7QsrWKw4INkzTj87P6XbPi9h6Mgywr9fxIJzlAeCxr8nko0irjXMEnTH9yCFlXWCeT-mNaXz7CLImdRhGunCrVkhNK8',1),(50,1,'Susmita Singha Roy','1993-11-19','7908188282','$2y$10$GuVQfaSRIoDjz3a.uBAxEO.ZYthCIIzhuHDGaUiGEK0wKxx.aDY6W','default.png',NULL,NULL,1),(51,1,'ANAMIKA SAU','1995-04-06','8250139940','$2y$10$0hYbfIYpdxAtA0XnNhOtmOAfQZMG.CQhiWey751sCc51ZP3Sv8E8a','default.png',NULL,NULL,1),(52,1,'pijush kanti dhak','1992-03-15','7679270674','$2y$10$eZoksMCC6DzKVaFfA/OEgOeovd15JdxB90Zo0jrYWbhb4R/k1wB2e','default.png',NULL,NULL,1),(53,1,'Antara Acharya','1988-08-26','9903698379','$2y$10$5IhhZ8wLdO6eSjkittLAxeorIJd/L5Ymub9.3.dKeI18N8NMKoMJC','default.png',NULL,NULL,1),(54,1,'Aparna Debnath','1960-09-15','9749638363','$2y$10$Or5q8iImbOB3Cne4dky2fe2kurI4LMg40qFgQTZAuiRlkiNNXnR/u','1598701618101.jpg',NULL,'euts1l8aRW2F4yCosDSNoM:APA91bED2gSVH6GgpiQ69STIix0iK7pQwS4XCOMFnoeEK-SYoSHdv2bNzrPbqgvL12C81G8NZ7z9V3Ij-CAj65_M_I7thcl0ANlc4m1RORkXiouduXMSYUFNYg4JhNhIedLX-5orsXGb',1),(55,1,'TANU CHATTERJEE','1989-05-29','8617394883','$2y$10$62HZychQCp.wP2RCgNDK1eqFdR4hZWb9GKxXWtvAydVfMl.LHNCti','default.png',NULL,NULL,1),(56,1,'Sahana Sen Mitra','1986-10-17','7003417107','$2y$10$VB9XLpaqc0NK7LD/pChtmObQSC.bsp2I6EOLdlJjXLxmkuregTRUO','default.png',NULL,NULL,1),(57,1,'chandana  Das','1987-03-19','9134455433','$2y$10$RrTvVAo1bMgXnzLTRZ8miedR7D7jNwZYhkOP4IozmkR.NMAVDETHC','default.png',NULL,NULL,1),(58,1,'ANUSHREE CHAKRABARTY','1985-12-21','8670448800','$2y$10$Megx.GxZorIDPkV4TdU8DObc1WLjmFICqnJ9Ang5aqVJcMKKd.5Qu','default.png',NULL,NULL,1),(59,1,'Nargish Nazeer Hossain','1976-03-01','9595067483','$2y$10$OfNVn2tkJGWfTuuHHokloetlWQsrxm7ZQDyva6Uz2KL4vkTifL39W','default.png',NULL,NULL,1),(60,1,'Paromita mondal','1999-07-20','6297138803','$2y$10$ntX6Q5Q6cSP4./6cjD4rVOm73brfcVzDc8bMOFhe0VQ.VtwERFHA.','default.png',NULL,NULL,1),(61,1,'Debashri Senspati','2016-03-25','8642847259','$2y$10$JlcSsSCqSHt/2GF2Nx99Pe6WRxsvgxfk9jR3110vYqdlhPglZOJ2O','default.png',NULL,NULL,1),(62,1,'Sunanda biswas','1999-08-28','9733317419','$2y$10$3cK/S/wVTxRxR7OB4SnAEu5W.Y4Yy3iONZx5k71o6BhHaQc5GzS/i','default.png',NULL,'cCsEePEnQZ6hb3m2VxyGPv:APA91bE-wQvJV4dv-cE2AX15KKF1oF8rBfuRIvBbrOhRaT_JabBNzpt6Gs1D6I0ELyGwPGn8CKd9yXPLOqbado8anF5AwaJsSMOJ4w7lgtGEJqGwSG1WCOj197Xr3Dk0YedMFghcnCCl',1),(63,1,'sneha Bhagat','2020-07-03','7872787855','$2y$10$83NajdD5.Gx/.OJ9sZbz.OY4tcPD/zThon1z86L.8D/x9FADkKSvm','default.png',NULL,NULL,1),(64,1,'Reshma chowdhury','1997-03-08','9064868915','$2y$10$/go67tf/g/LzYDTLeyaBNetpV8ig06vKncIt0udS5M8U418mBWOdC','1596973095546.jpg',NULL,'cUb9q-4pS--sfunyikaYqP:APA91bHa98Crg6H1Vp00oswMxREeCebQ_rUAGjPu_W58bdK_ZkIO7fga5wIZXq4pnfk8tNf5rfyv03cwZVw9s6lvNFMAPQxFBTYOR8RYjFveQcbN1KNnDjNUB2adHs80n0bouaUZ6mpS',1),(65,1,'Suvra Saha','1994-12-31','8240695212','$2y$10$5pm6uVEk1Ua7KZ0F7/cii.kS7wm/MnD8G.0saD.3mm60p3oaW1jcy','default.png',NULL,'cSlNHhF5QbSIMoBSXpOlx9:APA91bGw-wKtIrseqaqWTN2SvhQ6i2H2WzQm4oiOgZYtgL-ZVcu7JC5LPgE0-roQU9jV_IKNDMlerYYyqGfS3WETkG9XuQaMczt51Oy_JZsP-bjsFi3KI3nUX8TcquvJDWMmPgelth5T',1),(66,1,'Moon Das Dutta','1987-10-03','6291864991','$2y$10$5k3vgh6UsQaVniwndgh5LOQa/XmVT1L9nNckxQcIJ4meOAJw4IDo.','default.png',NULL,NULL,1),(67,1,'Abhijit das.','1992-09-23','9123679396','$2y$10$05Qxr9z8YLZZD9llvtQqGeBVk6Zuj/LJHWNxDkFaKyA8WUx.qzkji','default.png',NULL,'e-Qm7-9OQyCeuNP5Gz5EA-:APA91bFfeAjswWenLfalzUzsKdL51gq8JuWtVseiMBNRNbruaoUlGvLsIDd5FCVQ3ra5d6Uc2JS4SUN_TJhJKfKJDXA_Fh7qpPk2nxSiKDT9-Opid6ZklYiE_YdcfNhzu4B83jY0kKat',1),(68,1,'Sunita Ghosh','1989-11-22','7450965510','$2y$10$5gigqGKvSs7biqG1d5LOleqFyqBAXHxZNCLkxzdA8vuw11Spnapzu','1596618495440.jpg',NULL,'fgGvd42fSXyS32dFFq5ON_:APA91bHuNawWJV8McAu7suguuK-3F6_GsF69BZHIcSpCQjSGC11klWCVNvmQYSyyKeV8H42DDcXE6Bld-zEbPwkr_4RqFvoq8r7-bMb8aCqYtwcn0JeGtH0gzD_rYyKLjJTlzgJPPzO2',1),(69,3,'SOMA DE','1993-03-04','8918433269','$2y$10$7KgTV4sTYXvoGleHN2PLZ.dlxiBZwHt3HjlzMedlvUWk23sFjPU4e','1596560595092.jpg',NULL,NULL,1),(70,1,'Anamika Ghosh','1995-11-16','7908114618','$2y$10$lAfWJ66rMf7neSGqtppdaOEMucj5CO2qBYD5PXB5dXCnCApGGDRhS','default.png',NULL,'dgNlr29vS8CUpmfOpcZNXo:APA91bG-Hv1G3DSjyp67sY4WOrsdGxZIAeqfcsEIxw-koWN8yif1E1-uiO71Og4qtehJP6IwpWeUDmCawpGp9sst_KW7FhyuaVA0agDv1U4SNoFDtd_D9IfwOapYpqQoQ_qA47nN8zLM',1),(71,1,'Priyanka Roy','1997-07-10','7074271070','$2y$10$FijZkJRio6/.nGcclBMCpeax2ZdwfIOA6T20pfo3LiKmlGeL9Nz3y','default.png',NULL,'ezQWd24ASfWpKyfBhs4mg2:APA91bHuKoNtJCI0MWsDgpZfPJjvjo4a5x8_BAbv_qm9q2890VyX5W34xxXFw34ATFG6uamIPfP39Q1YKjIbIfat0jfVCeiDIo6QzgNbndkGHkJ7-ZZ-pjMKZTYkPYR2oEfjT4ymdcGy',1),(72,2,'Keya Das','1992-11-23','8250204948','$2y$10$atSVwf9WrW1Q5uwzwoMF8ONrhJBMUKwQuMJkpSd3fkfFZMnJJYig.','default.png',NULL,NULL,1),(73,2,'Manti Sarkar','1989-11-28','8723935671','$2y$10$S.y.KJARnNeiVF7PT0z3EeBSmBxD8PNDhrf8qH0WFARZKWt60uYDm','default.png',NULL,NULL,1),(74,2,'ARDHENDU MUKHERJEE','1995-01-11','9647015645','$2y$10$24kx.vwiuR9iTHVNgWrj7O4pMJpqwO7KTrx9W6wuLk0eobP5ueTWy','1597675211353.jpg',NULL,'dIolF_V3RHGv4wP3eWZJHW:APA91bFoJzC47BjiK0ZBjEweAwrgRonmwZ3B6F28xP8qeC8R9gzMy7reNXSAM2ErK4-gpUSNbbTK30k1FaESnot8ECKBuBWFFEzNz0QH4mzlIFnNUWrGGzomvoB7vznQ56w79huD7FL8',1),(75,1,'DIPANNITA BHANDARI','1992-09-11','8617592342','$2y$10$urashYGVR6zrlRZBTZoL6.KmLPzEzIClUJEg7DzJMoE3Cqge3AO4y','default.png',NULL,NULL,1),(76,2,'KHEALI CHOWDHURY','1994-04-14','8250893553','$2y$10$caFqJXwVS4Wb9z33aMVaVuGV5w6NUbS3jAtwWIz60e3tDTBFQ6.Iq','default.png',NULL,NULL,1),(77,2,'Poulami Panchadhyayee','2000-09-12','9641222480','$2y$10$n/yWctiW/ifiwO/wouEOg.0Ey1XqYIeNTI08WGLiUS6rKA7dkgp2q','default.png',NULL,'c-vwCVsVTx-yvEoRqVD0yI:APA91bFJ7qWIXczwo0Y-OQYLQGrk-QJQq3__GvMEqZlFWWxj757LSovuRoCUmC0vVnJC2rT5xmc5ahR-HeTKmSYq6btpqCkwIKp08r0cd8ORRs8O4wZAmlsWEe-8gyrB3zGH8UfeC2f9',1),(78,1,'SUPRITI SINGHA ROY','1997-01-28','9831253790','$2y$10$WOL1wWXni0r3Iis6Y88/qOOGwny9XGJvo39CBBPbWEwGqoBNyJEpy','default.png',NULL,NULL,1),(79,1,'Priya Adhikary Dhalla','1993-08-20','6296915832','$2y$10$Wk/L/t3JXQvyTlqXQsMezOXbFiw25a6atJrOK0Q5U7o7.B5Fud78.','1598847401824.jpg',NULL,'faYm3VypQNaYMFxAzfXtRW:APA91bFX12B-dIK6a8wGNX2MdeyP6uuGU2-9md0nZ7Rh6rJWrn2r3f021a4j1ddvrNhwlYl1o7XYweyONx6XzBpDerlxxuOEXuNqSGD35aVIO7UUPCDrEXLfVOXRNxNDLSmoKF8UwfPC',1),(80,2,'SOUVIK GANGULY','1988-05-02','9775639784','$2y$10$l5ov2Jiyugsz7g/yuSGs4Ojn/K/6/Lk4C.LPXz.GGlVBDzwZbRmSK','1598668571370.jpg',NULL,'ddQE_vMORaqkAKtz4NWOAr:APA91bF1Hp5V6ZLAO2ldpIvMvWkrlvmdSWq_BOXiB2VcyUTsm5zrXLtfkPvMLTrjsN5jAMU9aiLX9x1facoJbnQfSek-_yMwX_xdX6GkKH_be7qyV50fmoF6zIelTCmIjKY7_pPNoq2c',1),(81,1,'suchismita Biswas','1997-09-25','8637043198','$2y$10$w.JDpsYD.QA/5DkXt2n/M.ObxY0mJjPIBEJ2UMNbBvQrOHKL67j0u','default.png',NULL,NULL,1),(82,2,'Abhijit Chattopadhyay','1988-07-04','9773011174','$2y$10$XRn320HXZh7dPIg6z2BZx.a3DtUwMLwUA.HU.2DR4EEEKxouQfGdS','default.png',NULL,'ddQE_vMORaqkAKtz4NWOAr:APA91bF1Hp5V6ZLAO2ldpIvMvWkrlvmdSWq_BOXiB2VcyUTsm5zrXLtfkPvMLTrjsN5jAMU9aiLX9x1facoJbnQfSek-_yMwX_xdX6GkKH_be7qyV50fmoF6zIelTCmIjKY7_pPNoq2c',1),(83,2,'KRISHNADAS KUNDU','1991-04-06','9614631033','$2y$10$v.xgnP4P08/uspunA6o/9esKFJTrR57tHhberlqk1NMO2i9J5daFK','default.png',NULL,'cEbKOqjtQq-baGeAUcgfP8:APA91bG64WJGx3B7USs_a1ujbUwbBGDwJpwB713kRO5P9JtT8G7Raa-Y7TZJXvUw1P0ukpt4yLYwa6ARTZjYZSmITQgOM7Wklv-lLFHkodwJmyy-aOCXGWVLDoryzlwfUCMyASVjiwBp',1),(84,1,'Chaitali Nayak','1983-01-01','8240115028','$2y$10$yyZTnkhCR5ktctBd7wCB0OSiGT14ljEsWJ0DXYoltfO1HL68rYnF6','1599208152601.jpg',NULL,'cq-O1LunQAyryqcLDhv3Oy:APA91bEyZQA6SQc_4LFCX2tIEgyuFabBWNl3uK8JG-zTZNSJI1Yb3OyVhCW0UfkxPvfWONdZKmrn9upZiyGlhGWW3BCiJpRknOcAtms3UwBF9lsXLLHU_65rbZ6vP8JzHX5X96Bk_8iJ',1),(85,1,'Padma Maji','1983-01-22','9064595826','$2y$10$e73/a.KgVU71i6Ldfihw5.F6eTkIbllWBsiWAKRaW1wVSgJiAkbbC','default.png',NULL,NULL,1),(86,2,'Tufan Ghosh','1996-04-05','6295095161','$2y$10$iN1cPA.Rn2nqTk6Iwk/wjuDqtBzMTzQQTshclo3E76oyVb6JR1jNK','default.png',NULL,NULL,1),(87,1,'Sarmistha Dutta','1986-01-11','9874108647','$2y$10$Znyjmza6FeWzy2v10kw0AuEZR6quaPGc794GP3jO1MOjwT1jCiKUa','default.png',NULL,NULL,1),(88,1,'Tamal sen','1988-12-15','9830817773','$2y$10$fM9iRmhTIcR9bMrtQ2YXieQ9ZYhu4zbaBoQeYqpAHKjQTx9mLSKWy','default.png',NULL,NULL,1),(89,1,'puspa biswas','1991-04-10','9932472788','$2y$10$oWta9FwjIYYP4dIRT6n1iusft4VDGXC5PCCIY7ghapqgDag7XVyzW','default.png',NULL,NULL,1),(90,1,'SOMEN DAS','1990-11-04','8789394345','$2y$10$koFp0LkBx.mQTDherdy/ceSh6Pq4Y1zBNlBypRoSUCxtCdYwyPWoa','default.png',NULL,NULL,1),(91,1,'aparna yadav','1991-04-21','9051117399','$2y$10$MTs4LdZC6Hl3WUh0Kd4.L.4EXjK1y4bLdcgFro6mCuYlONcpAetOa','default.png',NULL,NULL,1),(92,2,'Nipa Bid','1986-07-19','9564472129','$2y$10$Z5VOIzX30Ay99Ks6SGGbIuJj5r3uNrzYcwhb4OgXJGV0W5pPm4oq6','default.png',NULL,NULL,1),(93,1,'PRIYANKA MONDAL.','1991-12-18','8250134080','$2y$10$rDAuEa7IweIFSFQ0RShigOLjWV/SzjFaJjDv6oxwg4SNd2mjrDmlO','default.png',NULL,'cEbKOqjtQq-baGeAUcgfP8:APA91bG64WJGx3B7USs_a1ujbUwbBGDwJpwB713kRO5P9JtT8G7Raa-Y7TZJXvUw1P0ukpt4yLYwa6ARTZjYZSmITQgOM7Wklv-lLFHkodwJmyy-aOCXGWVLDoryzlwfUCMyASVjiwBp',1),(94,2,'Epsita Dikshit','1995-08-20','9434113729','$2y$10$DNsEh99NdYHPRCTen.VWtu0ON4BzjX5CZzdjh7zh82ZkFb9PJ8fxO','default.png',NULL,NULL,1),(95,1,'subhankar Naskar','1999-08-01','8013560312','$2y$10$x3y9HxSOuBVW4iyEfQKPIOux3XUzGHmyYd0DMpUteoIMlbq8Wrf0e','default.png',NULL,NULL,1),(96,1,'Moumita Mondal','1986-09-28','7679465015','$2y$10$94/bez7.uG7HD.Q7KOmlzuKCHoSfmM4mk9BPkSFcU2gr3dXtRong6','default.png',NULL,'dZF9JqSORfCRhrHBcCw0gd:APA91bF5QAcOL9mxh9TgU5G34ZJ9_KW4EJcLt9TmXBez1JyGyYaSGXuJVAo07FSg2Kqn0bz2CSxf_GYGg72LpSWmh3CMT8IB2eTAkFaC0ud94M4sfWmLWbH9NKk_ealPeeRaW0mfdkGC',1),(97,1,'Tumpa Mandal','1996-10-23','8972795936','$2y$10$LSUweEGa4hPxKBOkKy8E.eJrFnLzPxcEiXFe11sDdQygChlrc8n6a','default.png',NULL,NULL,1),(98,1,'Manojit Majumdar','1996-04-28','7872459338','$2y$10$VOjaZX0B5CwrJ79C7lqciuE4N0QN7VQXE.yJmAuq4JRK4yDTAEF1S','default.png',NULL,NULL,1),(99,2,'Srabani paramanik dey','1984-01-20','9064626301','$2y$10$sX9Jhn4DxWrK9R6IN4111ed1vhdxL7ctDXSp.5x8c9cugbzHpl3Jm','default.png',NULL,NULL,1),(100,1,'SUSMITA DAS','1999-12-20','7685863922','$2y$10$sztym5soOXplzHDfO9ta2uNj1BVgzOonaiToagKepXwP98.YYfeIK','default.png',NULL,NULL,1),(101,1,'Dulali Deb','1974-03-31','9433173562','$2y$10$kbcj6obGr4PMxKmFpv47XuAlRCQ3JwKCN2Rblb6dBiFszyT9ptOEi','default.png',NULL,NULL,1),(102,1,'rashida sultana','1980-01-06','9007643300','$2y$10$yIk7lzA6w3zcZNFM8MgvX.MvGLtyEq/lyS4fPShkIpvizf1bhZvvm','default.png',NULL,NULL,1),(103,1,'Biswajit Das','2000-09-05','8617054105','$2y$10$kcXCwCCId3you6w3C5vKIO4PLuLlho0FsR2jnlw8OOE2RaQv89lYe','default.png',NULL,NULL,1),(104,1,'Munmun Barat','1988-05-17','8617395473','$2y$10$kCDNkLoFT5MRNriM3Z5qYOqFcNXvOzbllCp.a9rmXXNvGMV.IOFzu','default.png',NULL,NULL,1),(105,1,'Tapasi dey','1981-09-29','7318613357','$2y$10$9fuA0/XMgHUOZFDxhAcSPuRtTYaWXcn5cT0xpNGouAOqXTbNfQtPG','default.png',NULL,NULL,1),(106,1,'Soma Debnath','1987-01-05','9933919008','$2y$10$6RFRuS.Zc/5hnj0yBtfBtO9jrY0GTDhWnDlWn5Ygr35smtStRjHhG','default.png',NULL,NULL,1),(107,2,'Sukanta Baidya','1998-07-21','9903667556','$2y$10$mvHDjGqZCViNJMF5i4VaD.1x2tl6J2wYwRHBK/PjMfPl4fUuZHsIG','default.png',NULL,NULL,1),(108,1,'Ruby Maji','1984-07-20','6203424152','$2y$10$HCf5DkpFdt1YF8Gm1aERTuEuAExKYgIMsUeyObWibbFm5PJNO/WVu','default.png',NULL,NULL,1),(109,1,'Gulab Das','1997-11-29','8910954392','$2y$10$YxbFxNc93DSTcHoLifA8dO9OxJxpHDt2OzTxZ1IDO0LemLBV/IZTC','1612807146161.jpg',NULL,'dZF9JqSORfCRhrHBcCw0gd:APA91bF5QAcOL9mxh9TgU5G34ZJ9_KW4EJcLt9TmXBez1JyGyYaSGXuJVAo07FSg2Kqn0bz2CSxf_GYGg72LpSWmh3CMT8IB2eTAkFaC0ud94M4sfWmLWbH9NKk_ealPeeRaW0mfdkGC',1),(110,1,'PARBATI SARKAR','1983-12-25','8944851233','$2y$10$0ave8dQufqtZqAGsSO3gNeKyShqPrABtTGUJk3yYN.yTaQKFtPVdS','default.png',NULL,NULL,1),(111,1,'Baishali Pradhan','1987-04-23','8768437044','$2y$10$3aVTvAk07T2o90onTnn9yeyQnQy8o9bp84NTSCfJjq/eDQYjsNjuq','default.png',NULL,NULL,1),(112,1,'Dipchayanika Das','1982-04-15','7002609071','$2y$10$hX0KHYz.TpLHL88c5T.6pOwsQKJ6GRYnPSNZzIZIWURsKHEFjPyBW','default.png',NULL,NULL,1),(113,2,'kaushik paul','1992-10-05','8967491470','$2y$10$5tLz7hi/ho2wIcqIn2qTe.rxH/Se3xGAGTD0M5g4ybKbU/hslxB2G','default.png',NULL,NULL,1),(114,1,'Rupa Ghosh','1989-09-10','7003143003','$2y$10$A.HSF6yAHUqni3AXqfSbLe/DXjy2C/R4868IXuDeDEl4XEBfKMOZ.','1618926922245.jpg',NULL,'eTdaIRm-QFemeBNQEQS5hU:APA91bHv7wkea8WK71392gwbWMETi5rVdl_bb3erLsLXKHBvdlfiL6sIsdKC-mZLMLUAlLxc3wkp0arRckb7QSPCX6h_eNKvdGAWHy8hHOspbXfQmV3sH6YfrA9EMWVFonDNKV1zN8Qz',1),(115,1,'Sneha Biswas Mondal','1991-06-25','9062327984','$2y$10$rqVIE0KKFlOcAW2B7NHFb.nI9FY4u6fxgOKAigXH70VFm8szPbpfe','default.png',NULL,NULL,1),(116,1,'BHASWATI PAL','1995-09-30','7003064819','$2y$10$woaWUP0qLgDc21CkY3SkGepFtPYroaIgcJyVMrrrtCtzulHKVhBhm','default.png',NULL,NULL,1),(117,2,'UEH SELF','2019-07-27','9749304040','$2y$10$VPWkyOu/KPCr5hSNwUvgY.S38CtlS/v3c3l32WFVfZvYoS9oGZBc2','default.png',NULL,NULL,1),(118,1,'Gargi Das','1991-07-02','8910802606','$2y$10$o/tLnBpl0GiQzYxHroNQIuZB1qjXFrZzanrwfyCo2vktAp2G/Rle2','default.png',NULL,NULL,1),(119,1,'Sneha Paul','2001-06-09','8910561683','$2y$10$2PPJqNg2.vSvu57vXqUbAOJwzgC2M92Eq0GD1gadoEE56PNWfCBm6','default.png',NULL,NULL,1),(120,1,'Dipa singha','1989-08-20','7620100064','$2y$10$3q1bt8AO2trFpIWhx.fvmeerQfR53fb11zrB8oI92NQT.fmBocHeW','default.png',NULL,'ctKxxrB6QyWGg2GNeVFwZr:APA91bEguI5Q2yLDhlGxZcGBKjf_aEQI8483WBvJshtIkCnvmSa_L6QLzhu9ZLMOvKqC4BFqS5qzZ1jmua3gVz3XdQ7teY-pmtbIhLXelJqOc4ei3URXTiUNDqiYFgXCqIO_tPdhPQz8',1);
/*!40000 ALTER TABLE `ueh_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-27  8:37:50
