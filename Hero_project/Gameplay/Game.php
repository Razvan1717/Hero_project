<?php

namespace Hero_project\Gameplay\Game;

include_once '../Players/Beast.php';
include_once '../Players/Entity.php';
include_once '../Players/Hero.php';
include_once '../Skills/Skills.php';
include_once '../Skills/RapidStrike.php';
include_once '../Skills/MagicShield.php';
include_once '../Skills/SkillsInterface.php';

use Hero_project\Skills\Skills;
use Hero_project\Skills\RapidStrike;
use Hero_project\Skills\MagicShield;
use Hero_project\Players\Entity;
use Hero_project\Players\Hero;
use Hero_project\Players\Beast;
use PHPUnit\Framework\Exception;


class Game
{
    /** @var Hero $hero */
    public $hero;
    /** @var Beast $beast */
    public $beast;
    public $attacker;
    public $winner;

    // create the battle

    public function startGame(){

        $this->createBeast()->createHero()->firstAttacker();
        $this->showInfo();
        $rounds  = 1;
        $maxRounds = 20;

        echo "<br>" . 'First attacker is: ' . $this->attacker->getName() . "<br>";
        while($this->playersAreAlive() && $rounds <= $maxRounds ){
            echo  '<br>' .'Round: '. $rounds  . '<br>';

            switch ($this->attacker){
                case $this->hero;
                    $this->heroAttack();
                    $this->attacker = $this->beast;
                    break;
                case $this->beast;
                    $this->beastAttack();
                    $this->attacker = $this->hero;
                    break;
            }
            $rounds++;
        }
        if($rounds == 20){
            echo "Draw!!";
            die();
        }
        $this->setWinner();
        echo '<br>'. 'The winner is: ' . $this->winner->getName() . '!';
    }

    public function showInfo(){
        echo "Name: " . $this->hero->getName() . "<br>";
        echo "Health: ". $this->hero->getHealth() . "<br>";
        echo "Defence: ". $this->hero->getDefence() . "<br>";
        echo "Strength: ". $this->hero->getStrength() . "<br>";
        echo "Speed: ". $this->hero->getSpeed() . "<br>";
        echo "Luck: ". $this->hero->getLuck() . "<br>";
        echo "<br>"."<br>";
        echo "Name: " . $this->beast->getName() . "<br>";
        echo "Health: ". $this->beast->getHealth() . "<br>";
        echo "Defence: ". $this->beast->getDefence() . "<br>";
        echo "Strength: ". $this->beast->getStrength() . "<br>";
        echo "Speed: ". $this->beast->getSpeed() . "<br>";
        echo "Luck: ". $this->beast->getLuck() . "<br>";

    }


    public function createHero(){
        //add stats to hero
        $this->hero = new Hero();
        $this->hero->setName('Orderus');
        $this->hero->setHealth(rand(70, 100));
        $this->hero->setStrength(rand(70, 80));
        $this->hero->setDefence(rand(45, 55));
        $this->hero->setSpeed(rand(40, 50));
        $this->hero->setLuck(rand(10, 30));

        //add skills to hero

        $rapidStrike = new RapidStrike(Skills::RAPID_STRIKE, 10);
        $magicShield = new MagicShield(Skills::MAGIC_SHIELD, 20);

        $this->hero->addSkill($rapidStrike)
            ->addSkill($magicShield);

        return $this;
    }

    public function createBeast(){
        //add stats to beast
        $this->beast = new Beast();
        $this->beast->setName('Wild Beast');
        $this->beast->setHealth(rand(60, 90));
        $this->beast->setStrength(rand(60, 90));
        $this->beast->setDefence(rand(40, 60));
        $this->beast->setSpeed(rand(40, 60));
        $this->beast->setLuck(rand(25, 40));

        return $this;
    }

    //who attack first?

    public function firstAttacker(){
        if($this->hero->getSpeed() > $this->beast->getSpeed()){
            $this->attacker = $this->hero;
        }
        elseif($this->beast->getSpeed() > $this->hero->getSpeed()){
            $this->attacker = $this->beast;
        }
        elseif($this->hero->getLuck() > $this->beast->getLuck()){
            $this->attacker = $this->hero;
        }
        elseif($this->beast->getLuck() > $this->hero->getLuck()){
            $this->attacker = $this->beast;
        }   else {
           throw new Exception('Players can\'t decide who to attack first!');
        }
        return $this->attacker;
    }

    // damage function

    public function getDamage(Entity $attacker, Entity $defender){
        return $attacker->getStrength() - $defender->getDefence();
    }

    // hero attack function

    public function heroAttack(){

        $rapidStrike = $this->getHeroSkill(Skills::RAPID_STRIKE);
        $damage = $this->getDamage($this->hero, $this->beast);
        $rapidStrike->isSkillUsed();

        $this->beast->isLucky();

        if($this->beast->getIsLucky()){
            $damage = 0;
            echo  $this->hero->getName() . ' miss his attack!' . "<br>";
        }
        if($rapidStrike->getIsUsed()){
            $damage = $rapidStrike->modifyDamage($damage);
        }

        $beastHealth = $this->beast->getHealth()- $damage;
        $this->beast->setHealth($beastHealth);

        if($rapidStrike->getIsUsed()){
            echo 'Hero use ' . $rapidStrike->getName() . '!' . '<br>' ;
        }else {
            echo "Hero din't use any skill" . "<br>";
        }
        echo $this->hero->getName() . " deal " . $damage . " to " . $this->beast->getName() . "!" . '<br>';
    }

    public function beastAttack(){

        $magicShield = $this->getHeroSkill(Skills::MAGIC_SHIELD);
        $damage = $this->getDamage($this->beast, $this->hero);
        $magicShield->isSkillUsed();

        $this->hero->isLucky();

        if($this->hero->getIsLucky()){
            $damage = 0;
            echo $this->beast->getName() . ' miss his attack!' . '<br>';
        }elseif($magicShield->getIsUsed()){
            $damage = $magicShield->modifyDamage($damage);
        }

        $heroHealth = $this->hero->getHealth() - $damage;
        $this->hero->setHealth($heroHealth);

        if($magicShield->getIsUsed()){
            echo $this->hero->getName() . ' use '. $magicShield->getName() . '!'. '<br>';
        }else{
            echo $this->hero->getName() . " din't use any skill" . '<br>';
        }
        echo $this->beast->getName() . " deal " . $damage . " to " . $this->hero->getName() . "!" . '<br>';

    }

    //check if hero has skill

    public function getHeroSkill($skill) : Skills{
        $skillNames = $this->hero->getSkillsNames();

        if(!in_array($skill, $skillNames)){
            echo 'wrong skill name';
        }

        $skills = $this->hero->getSkills();

        return $skills[$skill];
    }


    public function setWinner(){
        if($this->hero->getHealth() > $this->beast->getHealth()){
            $this->winner = $this->hero;
        }
        else{
            $this->winner = $this->beast;
        }
        return $this->winner;
    }

    // check if players are allive

    public function playersAreAlive(){
        if($this->hero->getHealth() > 0 && $this->beast->getHealth() > 0){
            return true;
        } else{
            return false;
        }
    }

}

$a = new Game();
$a->startGame();