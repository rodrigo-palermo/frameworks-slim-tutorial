<?php
namespace App\Models\Entity;
/**
 * @Entity @Table(name="books")   #usa a tabela books do banco
 **/
class Book {
    #para o Doctrine comunicar a classe com o banco
    #o @ID será PK 
    # é o auto incremento do banco. Cada banco implmeenta de um jeito
    /**  
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    public $id;
    /**
     * @var string
     * @Column(type="string")
     */
    public $name;
    /**
     * @var string
     * @Column(type="string")
     */
    public $author;
    /**
     * @return int id
     */
    public function getId(){
        return $this->id;
    }
    /**
     * @return string name
     */
    public function getName(){
        return $this->name;
    }
    /**
     * @return string author
     */
    public function getAuthor() {
        return $this->author;
    }
    /**
     * @return Book()
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }
    /**
     * @return Book()
     */
    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }
}