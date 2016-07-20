<?php

namespace Classes;

class Animals
{
    private $name;
    private $idSpecies;
    private $owner;

    public function __construct($name=null,$idSpecies=null,$owner=null)
    {
        $this->name=$name;
        $this->idSpecies=$idSpecies;
        $this->owner=$owner;
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getIdSpecies()
    {
        return $this->idSpecies;
    }

    /**
     * @param mixed $idSpecies
     */
    public function setIdSpecies($idSpecies)
    {
        $this->idSpecies = $idSpecies;
    }
}