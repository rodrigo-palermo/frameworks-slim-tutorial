<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Entity\Book;
//carregar books aqui ou já foi carregado em autoload
require 'bootstrap.php';


//obs.: contém indicação de versão 1 e 2 referentes às refatorações propostas no tutorial

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
    /**
     * Pega o ID do livro informado na URL
     */
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
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');  #cria um repositório (tipo um array), e puxa o repositorio do EntityManager. E faz referência aà entidade Book
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
    $params = (object) $request->getParams();  # Pega os dados dos parametros
    /**
     * Pega o Entity Manager do nosso Container
     */
    $entityManager = $this->get('em');  #pega os dados do container
    /**
     * Instância da nossa Entidade preenchida com nossos parametros do post
     */
    $book = (new Book())->setName($params->name)
        ->setAuthor($params->author);

    /**
     * Persiste a entidade no banco de dados
     */
    $entityManager->persist($book);  #neste momento nao precisa criar DAO, insert, etc
    $entityManager->flush();
    $return = $response->withJson($book, 201)
        ->withHeader('Content-type', 'application/json');
    return $return;
});
/**
 * Atualiza os dados de um livro
 * @request curl -X PUT http://localhost:8000/book/14 -H "Content-type: application/json" -d '{"name":"Deuses Americanos", "author":"Neil Gaiman"}'
 */
$app->put('/book/{id}', function (Request $request, Response $response) use ($app) {
    /**
     * Pega o ID do livro informado na URL
     */
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    #versao1
//    $response->getBody()->write("Modificando o livro {$id}");
//    return $response;
    #versao2
    // $return = $response->withJson(['msg'=> "Modificando o livro {$id}"], 200)
    //                    ->withHeader('Content-type', 'application/json');
    // return $return;
    #versao3
    /**
     * Encontra o Livro no Banco
     */ 
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $book = $booksRepository->find($id);   
    /**
     * Atualiza e Persiste o Livro com os parâmetros recebidos no request
     */
    $book->setName($request->getParam('name'))
        ->setAuthor($request->getParam('author'));
    /**
     * Persiste a entidade no banco de dados
     */
    $entityManager->persist($book);
    $entityManager->flush();        
    
    $return = $response->withJson($book, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;


});
/**
 * Deleta o livro informado pelo ID
 * @request curl -X DELETE http://localhost:8000/book/3
 */
$app->delete('/book/{id}', function (Request $request, Response $response) use ($app) {
    /**
     * Pega o ID do livro informado na URL
     */
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    #versao1
//    $response->getBody()->write("Deletando o livro {$id}");
//    return $response;
    #verso2
//    $return = $response->withJson(['msg' => "Deletando o livro {$id}"], 204)
//                       ->withHeader('Content-type', 'application/json');
//    return $return;
    #versao3
    /**
     * Encontra o Livro no Banco
     */
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $book = $booksRepository->find($id);

    /**
     * Remove a entidade
     */
    $entityManager->remove($book);
    $entityManager->flush();

    $return = $response->withJson(['msg' => "Deletando o livro {$id}"], 204)
                       ->withHeader('Content-type', 'application/json');
    return $return;

});
$app->run();