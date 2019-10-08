<?php

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
/**
 * Container Resources do Slim.
 * Aqui dentro dele vamos carregar todas as dependências
 * da nossa aplicação que vão ser consumidas durante a execução
 * da nossa API
 */
$container = new \Slim\Container();  #o container carrega as variaveis para serem ustilizadas dentro dos metdos get, post, delete, put, etc no index. isso pq tais variáveis não estão disponiveis livremente
$isDevMode = true;
/**
 * Diretório de Entidades e Metadata do Doctrine
 */
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Models/Entity"), $isDevMode);
/**
 * Array de configurações da nossa conexão com o banco
 */
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);
/**
 * Instância do Entity Manager
 */
$entityManager = EntityManager::create($conn, $config);
/**
 * Coloca o Entity manager dentro do container com o nome de em (Entity Manager)
 */
$container['em'] = $entityManager;
$app = new \Slim\App($container);