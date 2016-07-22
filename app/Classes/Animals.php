<?php

namespace Classes;

class Animals
{
    private $name;
    private $idSpecies;
    private $owner;

    public function __construct($idSpecies=null,$name=null)
    {
        $this->name=$name;
        $this->idSpecies=$idSpecies;
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