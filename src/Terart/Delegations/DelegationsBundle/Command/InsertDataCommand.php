<?php

namespace Terart\Delegations\DelegationsBundle\Command;

use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InsertDataCommand extends ContainerAwareCommand {

    protected function configure(){
        $this
            ->setName('delegation:db:add-data')
            ->setHelp(<<<EOT
The <info>delegation:db:add-data</info> command executes SQL query.
 Caution: Execute only one time!
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $sql_query_arr = array(
            'Add countries...' => "LOCK TABLES `countries` WRITE; /*!40000 ALTER TABLE `countries` DISABLE KEYS */; INSERT INTO `countries` VALUES (7,'AD'),(225,'AE'),(3,'AF'),(11,'AG'),(9,'AI'),(4,'AL'),(13,'AM'),(155,'AN'),(8,'AO'),(10,'AQ'),(12,'AR'),(6,'AS'),(16,'AT'),(15,'AU'),(14,'AW'),(17,'AZ'),(29,'BA'),(21,'BB'),(20,'BD'),(23,'BE'),(36,'BF'),(35,'BG'),(19,'BH'),(37,'BI'),(25,'BJ'),(26,'BM'),(34,'BN'),(28,'BO'),(32,'BR'),(18,'BS'),(27,'BT'),(31,'BV'),(30,'BW'),(22,'BY'),(24,'BZ'),(40,'CA'),(48,'CC'),(52,'CD'),(43,'CF'),(51,'CG'),(208,'CH'),(55,'CI'),(53,'CK'),(45,'CL'),(39,'CM'),(46,'CN'),(49,'CO'),(54,'CR'),(57,'CU'),(41,'CV'),(47,'CX'),(58,'CY'),(59,'CZ'),(84,'DE'),(61,'DJ'),(60,'DK'),(62,'DM'),(63,'DO'),(5,'DZ'),(65,'EC'),(70,'EE'),(66,'EG'),(235,'EH'),(69,'ER'),(199,'ES'),(71,'ET'),(75,'FI'),(74,'FJ'),(72,'FK'),(143,'FM'),(73,'FO'),(76,'FR'),(77,'FX'),(81,'GA'),(1,'GB'),(89,'GD'),(83,'GE'),(78,'GF'),(85,'GH'),(86,'GI'),(88,'GL'),(82,'GM'),(93,'GN'),(90,'GP'),(68,'GQ'),(87,'GR'),(198,'GS'),(92,'GT'),(91,'GU'),(94,'GW'),(95,'GY'),(100,'HK'),(97,'HM'),(99,'HN'),(56,'HR'),(96,'HT'),(101,'HU'),(104,'ID'),(107,'IE'),(108,'IL'),(103,'IN'),(33,'IO'),(106,'IQ'),(105,'IR'),(102,'IS'),(109,'IT'),(110,'JM'),(112,'JO'),(111,'JP'),(114,'KE'),(119,'KG'),(38,'KH'),(115,'KI'),(50,'KM'),(182,'KN'),(116,'KP'),(117,'KR'),(118,'KW'),(42,'KY'),(113,'KZ'),(120,'LA'),(122,'LB'),(183,'LC'),(126,'LI'),(200,'LK'),(124,'LR'),(123,'LS'),(127,'LT'),(128,'LU'),(121,'LV'),(125,'LY'),(148,'MA'),(145,'MC'),(144,'MD'),(131,'MG'),(137,'MH'),(130,'MK'),(135,'ML'),(150,'MM'),(146,'MN'),(129,'MO'),(163,'MP'),(138,'MQ'),(139,'MR'),(147,'MS'),(136,'MT'),(140,'MU'),(134,'MV'),(132,'MW'),(142,'MX'),(133,'MY'),(149,'MZ'),(151,'NA'),(156,'NC'),(159,'NE'),(162,'NF'),(160,'NG'),(158,'NI'),(154,'NL'),(164,'NO'),(153,'NP'),(152,'NR'),(161,'NU'),(157,'NZ'),(165,'OM'),(168,'PA'),(171,'PE'),(79,'PF'),(169,'PG'),(172,'PH'),(166,'PK'),(174,'PL'),(202,'PM'),(173,'PN'),(176,'PR'),(175,'PT'),(167,'PW'),(170,'PY'),(177,'QA'),(178,'RE'),(179,'RO'),(180,'RU'),(181,'RW'),(188,'SA'),(195,'SB'),(190,'SC'),(203,'SD'),(207,'SE'),(192,'SG'),(201,'SH'),(194,'SI'),(205,'SJ'),(193,'SK'),(191,'SL'),(186,'SM'),(189,'SN'),(196,'SO'),(204,'SR'),(187,'ST'),(67,'SV'),(209,'SY'),(206,'SZ'),(221,'TC'),(44,'TD'),(80,'TF'),(214,'TG'),(213,'TH'),(211,'TJ'),(215,'TK'),(220,'TM'),(218,'TN'),(216,'TO'),(64,'TP'),(219,'TR'),(217,'TT'),(222,'TV'),(210,'TW'),(212,'TZ'),(224,'UA'),(223,'UG'),(226,'UM'),(2,'US'),(227,'UY'),(228,'UZ'),(98,'VA'),(184,'VC'),(230,'VE'),(232,'VG'),(233,'VI'),(231,'VN'),(229,'VU'),(234,'WF'),(185,'WS'),(236,'YE'),(141,'YT'),(237,'YU'),(197,'ZA'),(238,'ZM'),(239,'ZW'); /*!40000 ALTER TABLE `countries` ENABLE KEYS */; UNLOCK TABLES;",
            'Add company...' => "LOCK TABLES `company` WRITE; /*!40000 ALTER TABLE `company` DISABLE KEYS */; INSERT INTO `company` VALUES (NULL, 174,'Usługi Informatyczne TER-ART Wojciech Terpiłowski','Dekoracyjna','3','65-155','Zielona Góra','9730454764'); /*!40000 ALTER TABLE `company` ENABLE KEYS */; UNLOCK TABLES;",
            'Add delegation types...' => "LOCK TABLES `delegation_type` WRITE;/*!40000 ALTER TABLE `delegation_type` DISABLE KEYS */;INSERT INTO `delegation_type` VALUES (NULL,'15n9bo1e3nyvz'),(NULL,'45xbweag4lpd'),(NULL,'463zfkhk5fma');/*!40000 ALTER TABLE `delegation_type` ENABLE KEYS */;UNLOCK TABLES;",
            'Add target countries type...' => "LOCK TABLES `target_country_type` WRITE;/*!40000 ALTER TABLE `target_country_type` DISABLE KEYS */;INSERT INTO `target_country_type` VALUES (NULL,'translations.National'),(NULL,'translations.Foreign');/*!40000 ALTER TABLE `target_country_type` ENABLE KEYS */;UNLOCK TABLES;",
            'Add translations...' => "LOCK TABLES `translations` WRITE;/*!40000 ALTER TABLE `translations` DISABLE KEYS */;INSERT INTO `translations` VALUES (1,'en','translations.Accommodation','Accommodation'),(NULL,'en','translations.Consumption','Consumption'),(NULL,'en','translations.Passage','Passage'),(NULL,'en','translations.Representation','Representation'),(NULL,'en','translations.Others','Others'),(NULL,'pl','translations.Accommodation','Nocleg'),(NULL,'pl','translations.Consumption','Konsumpcja'),(NULL,'pl','translations.Passage','Przejazd'),(NULL,'pl','translations.Representation','Reprezentacja'),(NULL,'pl','translations.Others','Inne'),(NULL,'pl','1i0dlwqu6d6','Nocleg'),(NULL,'en','1i0dlwqu6d6','Accommodation'),(NULL,'pl','45xbweag4lpd','Spotkanie'),(NULL,'en','45xbweag4lpd','Meeting'),(NULL,'en','15n9bo1e3nyvz','Conference'),(NULL,'pl','15n9bo1e3nyvz','Konferencja'),(NULL,'pl','463zfkhk5fma','Szkolenie'),(NULL,'en','463zfkhk5fma','Training');/*!40000 ALTER TABLE `translations` ENABLE KEYS */;UNLOCK TABLES;",
            'Add type of expenditure...' => "LOCK TABLES `type_of_expenditure` WRITE;/*!40000 ALTER TABLE `type_of_expenditure` DISABLE KEYS */;INSERT INTO `type_of_expenditure` VALUES (NULL,'translations.Consumption','CONS'),(NULL,'translations.Passage','PASS'),(NULL,'translations.Representation','REPR'),(NULL,'translations.Others','OTHE'),(NULL,'1i0dlwqu6d6','ACCO');/*!40000 ALTER TABLE `type_of_expenditure` ENABLE KEYS */;UNLOCK TABLES;",
            'Add users...' => "LOCK TABLES `users` WRITE;/*!40000 ALTER TABLE `users` DISABLE KEYS */;INSERT INTO `users` VALUES (NULL, 1, 'administrator', 'administrator', 'admin', '3621e8f9001e26bd61e5f87121e67b51b6941a259cfdaff3f774c41d35cc3090472d86681c9bd23c54c2ea89de586d0a2820fef38f10f988fd9d34ad26fe9e9a', '147628475953317b485a871', 1, '2014-11-18 00:00:00', 'terart@terart.pl');/*!40000 ALTER TABLE `users` ENABLE KEYS */;UNLOCK TABLES;",
        );

        $em = $this->getContainer()->get('doctrine')->getManager('default');
        $conn = $em->getConnection();
        $conn->beginTransaction();
        try{
            foreach($sql_query_arr as $msq => $sql) {
                echo $msq.PHP_EOL;
                $conn->executeUpdate($sql);
            }
        }catch (DBALException $exc){
            echo $exc->getMessage().PHP_EOL;
            $conn->rollback();
            $em->close();
            die();
        }
        $conn->commit();
        echo 'Commit inserts to DB'.PHP_EOL;
        return;
    }

}