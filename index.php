<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'bootstrap.php';

/**
 * Lista de todos os livros
 * @request curl -X GET http://localhost:8000/book
 */
$app->get('/book', function (Request $request, Response $response) use ($app) {
    #versao1
//    $response->getBody()->write("Lista de Livros");
//    return $response;
    #versao2
//    $return = $response->withJson(['msg' => 'Lista de Livros'], 200);
//    return $return;
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $books = $booksRepository->findAll();
    $return = $response->withJson($books, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});


/**
 * Retornando mais informações do livro informado pelo id
 * @request curl -X GET http://localhost:8000/book/1
 */
$app->get('/book/{id}', function (Request $request, Response $response) use ($app) {

    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    #versao1
//    $response->getBody()->write("Exibindo o livro {$id}");
//    return $response;
    #versao2
//    $return = $response->withJson(['msg' => "Exibindo o livro {$id}"], 200)
//                       ->withHeader('Content-type', 'application/json');;
//    return $return;
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $book = $booksRepository->find($id);
    $return = $response->withJson($book, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;

});
/**
 * Cadastra um novo Livro
 * * @request curl -X POST http://localhost:8000/book -H "Content-type: application/json" -d '{"name":"O Oceano no Fim do Caminho", "author":"Neil Gaiman"}'
 */
$app->post('/book', function (Request $request, Response $response) use ($app) {
    #versao1
//    $response->getBody()->write("Cadastrando um livro");
//    return $response;
    #versao2
//    $return = $response->withJson(['msg' => "Cadastrando um livro"], 201)
//                       ->withHeader('Content-type', 'application/json');
//
//    return $return;
    #versao3
    $params = (object) $request->getParams();
    /**
     * Pega o Entity Manager do nosso Container
     */
    $entityManager = $this->get('em');
    /**
     * Instância da nossa Entidade preenchida com nossos parametros do post
     */
    $book = (new Book())->setName($params->name)
        ->setAuthor($params->author);

    /**
     * Persiste a entidade no banco de dados
     */
    $entityManager->persist($book);
    $entityManager->flush();
    $return = $response->withJson($book, 201)
        ->withHeader('Content-type', 'application/json');
    return $return;
});
/**
 * Atualiza os dados de um livro
 */
$app->put('/book/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
//    $response->getBody()->write("Modificando o livro {$id}");
//    return $response;
    $return = $response->withJson(['msg'=> "Modificando o livro {$id}"], 200)
                       ->withHeader('Content-type', 'application/json');
    return $return;
});
/**
 * Deleta o livro informado pelo ID
 */
$app->delete('/book/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
//    $response->getBody()->write("Deletando o livro {$id}");
//    return $response;
    $return = $response->withJson(['msg' => "Deletando o livro {$id}"], 204)
                       ->withHeader('Content-type', 'application/json');
    return $return;
});
$app->run();