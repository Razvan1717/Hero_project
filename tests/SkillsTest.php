<?php

namespace tests\EntityTest;

use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';
require_once 'Hero_project/Skills/Skills.php';

class SkillsTest extends TestCase
{
    public $skill;

    public function testIsSkillUsed(){

        /* @var $skill \Hero_project\Skills\Skills|\PHPUnit_Framework_MockObject_MockObject */
        $skill = $this->getMockBuilder('Hero_project\Skills\Skills')->getMockForAbstractClass();


        $skill->setChance(100);
        $result = $skill->isSkillUsed();

        $this->assertTrue($result);
    }

    public function testIsSkillUsedFalse(){

        /* @var $skill \Hero_project\Skills\Skills|\PHPUnit_Framework_MockObject_MockObject */
        $skill = $this->getMockBuilder('Hero_project\Skills\Skills')->getMockForAbstractClass();

        $skill->setChance(0);
        $result = $skill->isSkillUsed();

        $this->assertFalse($result);

    }

}
