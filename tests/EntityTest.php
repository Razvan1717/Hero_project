<?php

namespace tests\EntityTest;

require_once 'vendor/autoload.php';
require_once 'Hero_project/Players/Entity.php';

use Hero_project\Players\Entity;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public $player;

        public function setUp():void
    {
        /* @var $player \Hero_project\Players\Entity|\PHPUnit_Framework_MockObject_MockObject */
        $player = $this->getMockBuilder(Entity::class)->getMockForAbstractClass();

        $player->setHealth(50);
        $player->setStrength(60);
        $player->setLuck(25);
        $player->setSpeed(40);
        $player->setDefence(45);

        $this->player = $player;
        }

        public function testGetSetHealth(){

            $player = $this->player;
            $this->assertEquals(50, $player->getHealth());
            $player->setHealth(30);
            $this->assertEquals(30, $player->getHealth());
        }

        public function testGetSetStrenth(){

            $player = $this->player;
            $this->assertEquals(60, $player->getStrength());
            $player->setStrength(80);
            $this->assertEquals(80, $player->getStrength());
        }

        //same thing for all setters and getters

        public function testIsLucky(){

            $player = $this->player;
            $player->setLuck(100);
            $result = $player->isLucky();

            $this->assertTrue($result);
        }

        public function testIsLuckyFalse(){

            $player = $this->player;
            $player->setLuck(0);
            $result = $player->isLucky();

            $this->assertFalse($result);

        }

}