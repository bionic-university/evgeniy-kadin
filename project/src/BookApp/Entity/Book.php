<?php
namespace BookApp\Entity;

use JMS\Serializer\Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="book")
 *
 */
class Book
{
    /**
     * @var int $id
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Category")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @var int $pages_count
     * @Column(type="integer")
     */
    protected $pages_count;

    /**
     * @var string $title
     * @Column(type="string")
     */
    protected $title;

    /**
     * @var string $annotation
     * @Column(type="text")
     */
    protected $annotation;

    /**
     * @var string $cover
     * @Column(type="string")
     */
    protected $cover;

    /**
     * @var
     * @ManyToMany(targetEntity="Author", mappedBy="books")
     */
    protected $authors;

    /**
     * @var
     * @OneToMany(targetEntity="BookIsbn", mappedBy="book", cascade={"persist"})
     */
    protected $isbn;

    /**
     * @var
     * @Column(type="datetime")
     */
    protected $updated;


    public function __construct()
    {
        $this->isbn = new ArrayCollection();
        $this->authors = new ArrayCollection();
        $this->updated = new \DateTime();
    }

    /**
     * @param string $annotation
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;
    }

    /**
     * @return string
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }


    /**
     * @param string $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $isbn
     */
    public function addIsbn(BookIsbn $isbn)
    {
        $isbn->setBook($this);
        $this->isbn[] = $isbn;
    }

    /**
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param int $pages_count
     */
    public function setPagesCount($pages_count)
    {
        $this->pages_count = $pages_count;
    }

    /**
     * @return int
     */
    public function getPagesCount()
    {
        return $this->pages_count;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    public function getAuthors()
    {
        return $this->authors;
    }

    public function getIsbnArray()
    {
        $isbn = $this->getIsbn()->toArray();
        $result = array();
        foreach ($isbn as $item) {
            $result[] = $item->getIsbn();
        }
        return $result;
    }

    public function getAuthorArray()
    {
        $authors = $this->getAuthors()->toArray();
        $result = array();
        foreach ($authors as $author) {
            $result['name'] = $author->getName();
            $result['id'] = $author->getId();
        }
        return $result;
    }

    public function getData()
    {
        return [
            'book_id' => $this->getId(),
            'pages_count' => $this->getPagesCount(),
            'category' => $this->getCategory()->getData(),
            'title' => $this->getTitle(),
            'annotation' => $this->getAnnotation(),
            'cover' => $this->getCover(),
            'isbn' => $this->getIsbnArray(),
            'authors' => $this->getAuthorArray()
        ];
    }

    public function getIndexData()
    {
        return [
            'book_id' => $this->getId(),
            'title' => $this->getTitle(),
            'isbn' => $this->getIsbnArray(),
            'category_id' => $this->getCategory()->getId(),
            'author' => $this->getAuthorArray()
        ];
    }

    public function getIsbnString()
    {

    }

    public function getAuthorString()
    {
        $authors = $this->getAuthors()->toArray();
        $result = array();
        foreach ($authors as $author) {
            $result[] = $author->getName();
        }
        return implode(',', $result);
    }

    public function addAuthor(Author $author)
    {
        $author->addBook($this);
        $this->authors[] = $author;
    }

    public function getUpdated()
    {

    }

    public function setUpdated()
    {
        $this->updated = new \DateTime("now");
    }
}
