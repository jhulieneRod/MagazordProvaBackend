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

    // Cria a conexão com o banco de dados
    $conn = DriverManager::getConnection($connectionParams);

    // Cria o banco de dados se não existir
    $conn->getSchemaManager()->createDatabase('provamagazord');

    // Cria as tabelas no banco de dados
    $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
    $schemaTool->createSchema(array(
        $entityManager->getClassMetadata('Pessoa'),
        $entityManager->getClassMetadata('Contato')
    ));

} catch (Exception $e) {
    echo 'Erro ao conectar ao MySQL: ' . $e->getMessage();
}