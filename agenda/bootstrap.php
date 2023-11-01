<?php

require_once 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

// Configurações do Doctrine
$isDevMode = true;
$metadataPaths = [__DIR__ . '/src'];
$config = Setup::createAnnotationMetadataConfiguration($metadataPaths, $isDevMode, null, null, false);

// Configurações de conexão com o MySQL
$connectionParams = array(
    'dbname' => 'provamagazord',
    'user' => 'root',
    'password' => '#test-magazord#',
    'host' => 'db',
    'driver' => 'pdo_mysql',
);

try {
    $entityManager = EntityManager::create($connectionParams, $config);
    
    function getEntityManager() { 
        global $entityManager; 
        return $entityManager; 
    }

    $schemaManager = $entityManager->getConnection()->getSchemaManager();

    $databases = $schemaManager->listDatabases();
    $databaseName = 'provamagazord';

    if (!in_array($databaseName, $databases)) {
        $query = $platform->getCreateDatabaseSQL($databaseName);
        $connection->executeStatement($query);
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $classes = [
            $entityManager->getClassMetadata('Pessoa'),
            $entityManager->getClassMetadata('Contato')
        ];

        $schemaTool->updateSchema($classes);
    }

} catch (Exception $e) {
    echo 'Erro ao conectar ao MySQL: ' . $e->getMessage();
}