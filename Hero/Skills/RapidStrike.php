<?php

namespace Hero_project\Skills;

include_once 'SkillsInterface.php';

class RapidStrike extends Skills implements SkillsInterface {

    public function __construct($name, $chance)
    {
        $this->name = $name;
        $this->chance = $chance;
    }

    public function modifyDamage($damage)
    {
        return $damage * 2;
    }
}