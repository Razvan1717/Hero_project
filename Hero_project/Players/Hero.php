<?php
namespace Hero_project\Players;

use Hero_project\Skills\Skills;

include_once "Entity.php";
include_once "../Skills/Skills.php";

class Hero extends Entity
{
    protected $skills = array();

    protected $skillsNames = array(
        Skills::RAPID_STRIKE,
        Skills::MAGIC_SHIELD
    );

    /**
     * @return array
     */

    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @return array
     */
    public function getSkillsNames()
    {
        return $this->skillsNames;
    }

    // first time need to check if skills are set

    public function isSkillSet(Skills $skill, $skillName){
        if(isset($this->skills[$skillName]) &&
         $this->skills[$skillName] instanceof $skill){
            return true;
        }
            return false;
    }

    //add skill to hero

    public function addSkill(Skills $skill){
        foreach($this->skillsNames as $skillName){
            if(!$this->isSkillSet($skill, $skillName) && $skillName == $skill->getName()){
                $this->skills[$skillName] = $skill;
            }
        }
        return $this;
    }
}