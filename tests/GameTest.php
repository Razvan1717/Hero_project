<?php

namespace tests\EntityTest;

use Hero_project\Gameplay\Game\Game;
use Hero_project\Players\Beast;
use Hero_project\Players\Hero;
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';
include_once 'Hero_project/Players/Beast.php';
include_once 'Hero_project/Players/Entity.php';
include_once 'Hero_project/Players/Hero.php';
include_once 'Hero_project/Skills/Skills.php';
include_once 'Hero_project/Skills/RapidStrike.php';
include_once 'Hero_project/Skills/MagicShield.php';
include_once 'Hero_project/Skills/SkillsInterface.php';
include_once 'Hero_project/Gameplay/Game.php';

class GameTest extends TestCase
{

    public $hero;
    public $beast;

    public function setUp():void
    {
        $hero = new Hero();

        $hero->setHealth(20);
        $hero->setStrength(30);
        $hero->setDefence(40);
        $hero->setSpeed(50);
        $hero->setLuck(60);

        $beast = new Beast();

        $beast->setHealth(25);
        $beast->setStrength(23);
        $beast->setDefence(45);
        $beast->setSpeed(65);
        $beast->setLuck(35);

        $this->beast = $beast;
        $this->hero = $hero;


    }

    public function testFirstAttacker(){

        $hero = $this->hero;
        $beast = $this->beast;

        $game = new Game();
        $game->beast = $beast;
        $game->hero = $hero;

        $result = $game->firstAttacker();
        $this->assertEquals($beast, $result);
    }

    public function testPlayersAreAlive(){

        $beast = $this->beast;
        $hero = $this->hero;

        $game = new Game();
        $game->beast = $beast;
        $game->hero = $hero;


        $this->assertTrue($game->playersAreAlive());
    }

    public function testWinner(){
        $beast = $this->beast;
        $hero = $this->hero;

        $game = new Game();
        $game->beast = $beast;
        $game->hero = $hero;

        $beast->setHealth(0);

        $result = $game->setWinner();

        $this->assertEquals($hero, $result);

    }


}