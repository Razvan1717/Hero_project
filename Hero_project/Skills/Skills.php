<?php

namespace Hero_project\Skills;

abstract class Skills {

    const RAPID_STRIKE = 'RapidStrike';
    const MAGIC_SHIELD = 'MagicShield';

    protected $name;
    protected $chance;

    protected $isUsed;

    public function isSkillUsed() {

        $rand = mt_rand(0, 100);
        $isUsed = $this->getChance() >= $rand;
        $this->isUsed = $isUsed;

        return $this;
    }

    public function modifyDamage($damage){
        return $damage;
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
    public function getChance()
    {
        return $this->chance;
    }

    /**
     * @param mixed $chance
     */
    public function setChance($chance)
    {
        $this->chance = $chance;
    }

    /**
     * @return mixed
     */
    public function getIsUsed()
    {
        return $this->isUsed;
    }




}