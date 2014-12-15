<?php

namespace BookApp\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Category
 * @package BookApp\Entity
 * @Entity @Table(name="category")
 */
class Category
{
    /**
     * @var int $id
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var
     * @Column(type="string")
     */
    protected $name;
    /**
     * @var
     * @Column(type="string")
     */
    protected $udc;

    /**
     * @OneToMany(targetEntity="Category", mappedBy="parent", cascade={"all"})
     */
    protected $children;

    /**
     * @ManyToOne(targetEntity="Category", inversedBy="children", cascade={"all"})
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent = null;

    /**
     *
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUDC()
    {
        return $this->udc;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            'id' => $this->getId(),
            'udc' => $this->getUDC(),
            'name' => $this->getName(),
            'parent_id' => $this->getParentId()
        );
    }

    /**
     * @param $udc
     */
    public function setUdc($udc)
    {
        $this->udc = $udc;
    }

    /**
     * @return null
     */
    public function getParent()
    {
        if (isset($this->parent)) {
            return $this->parent;
        }
        return null;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Category $child
     */
    public function addChild(Category $child)
    {
        $this->children[] = $child;
        $child->setParent($this);
    }

    /**
     * @param Category $parent
     */
    public function setParent(Category $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return null
     */
    public function getParentId()
    {
        if (isset($this->parent)) {
            return $this->parent->getId();
        }
        return null;
    }


} 