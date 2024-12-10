<?php

namespace App\Service;

use App\AdventureGame\AdventureGame;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Service\SessionService;
use App\Dice\DiceGraphic;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Request;


    class SessionServiceTest extends TestCase
    {
        private $requestStack;
        private $session;
        private $request;
        private $adv;
        private $service;
        public $rooms = [
            'start' => [ // key and title must have same name
                'title' => 'start', 
                'description' => "test",
                'image_class' => 'test',
                'item' => 'test',
                'action' => "test_attack",
                'forward' => "test",
                'left' => "test",
                "back" => "test"
            ],
            'end' => [
                'title' => 'end',
                'description' => "test_end",
                'image_class' => 'test_end',
                'item' => 'test_end',
                'action' => "",
                'forward' => "test_end",
                'left' => "test_end",
                "back" => "test_end"
            ],];

        protected function setUp(): void
        {
            $this->requestStack = new RequestStack();
            $this->session = new Session(new MockArraySessionStorage());
            $this->request = new Request();
            $this->request->setSession($this->session);
            $this->requestStack->push($this->request);
            $this->adv = new AdventureGame(new DiceGraphic, $this->rooms);
            $this->service = new SessionService($this->requestStack, $this->adv);
            $this->service->initSession();
            $this->service->setCurrentRoom("start");
        }
        
        public function testSetSessionCurrentRoom()
        {
            $this->assertEquals($this->service->getCurrentRoom(), $this->adv->rooms["start"]);
        }

        public function testSetNewDescriptionValueCurrentRoom()
        {
            $newValue = "a new description that replaces test";
            $this->service->setNewRoomDescValue($newValue);
            $this->assertEquals($this->service->getCurrentRoom()["description"], $newValue);
        }

        public function testAddItemToBackpack()
        {
            $testItem = "some_item";
            $this->assertTrue($this->service->isNotSessionVariableSet("backpack"));
            $this->service->setBackPackContent($testItem);
            $this->assertTrue($this->service->isItemInBackpack($testItem));
        }
        
        public function testGetSessionValueWithKey()
        {
        $testItem = "some_item";
            $this->service->setBackPackContent($testItem);
            $this->assertIsArray($this->service->getSessionValueWithKey("backpack"));
            $this->assertEquals($this->service->getSessionValueWithKey("backpack")[0], $testItem);
        }
        public function testGetSessionRooms()
        {
            $this->assertEquals($this->service->getSessionRooms(), $this->rooms);
        }
        public function testKillEnemyUpdatesSession()
        {
            $this->service->killEnemyCurrentRoom();
            $this->assertEquals($this->service->getCurrentRoom()["description"], "You slew the beast!");
        }
    }