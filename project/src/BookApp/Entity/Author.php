<?php

namespace BookApp\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Author
 * @package BookApp\Entity
 * @Entity @Table(name="author")
 */
class Author
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
     * @ManyToMany(targetEntity="Book", inversedBy="authorBooks")
     * @joinTable(name="author_book",
     *  joinColumns={@JoinColumn(name="author_id", referencedColumnName="id")},
     *  inverseJoinColumns={@JoinColumn(name="book_id", referencedColumnName="id")}
     * )
     *
     */
    private $books;

    /**
     * @var
     * @Column(type="string")
     */
    private $name;

    /**
     * @var
     * @Column(type="text")
     */
    private $bio;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @param mixed $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * @return mixed
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param mixed $books
     */
    public function addBook(Book $book)
    {
        $this->books[] = $book;
    }

    /**
     * @return mixed
     */
    public function getBooks()
    {
        return $this->books;
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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

} 