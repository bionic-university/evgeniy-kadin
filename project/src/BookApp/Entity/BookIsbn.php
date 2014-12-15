<?php
/**
 * Created by PhpStorm.
 * User: eugeny
 * Date: 15.11.14
 * Time: 16:30
 */

namespace BookApp\Entity;

/**
 *
 * Class BookIsbn
 * @package BookApp\Entity
 * @Entity @Table(name="book_isbn")
 */
class BookIsbn
{
    /**
     * @var
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var
     * @Column(type="integer")
     */
    private $book_id;

    /**
     * @var
     * @Column(type="string")
     */
    private $isbn;
    /**
     * @var
     * @ManyToOne(targetEntity="Book", inversedBy="isbn", cascade={"all"})
     * @JoinColumn(name="book_id", referencedColumnName="id")
     */

    private $book;

    /**
     * @param mixed $book
     */
    public function setBook($book)
    {
        $this->book = $book;
    }

    /**
     * @return mixed
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param mixed $book_id
     */
    public function setBookId($book_id)
    {
        $this->book_id = $book_id;
    }

    /**
     * @return mixed
     */
    public function getBookId()
    {
        return $this->book_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $isbn
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    /**
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }


} 