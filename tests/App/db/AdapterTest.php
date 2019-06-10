<?php
  namespace App\db;
  
  use App\TestCase,
      App\db\Adapter;

  class AdapterTest extends TestCase
  {
    public function testValidateClassAttributes()
    {
      $this->assertClassHasAttribute('connection', Adapter::class);
    }

    public function testDeclaresFindAllMethod()
    {
      $db = new Adapter();
      $method_defined = method_exists($db, 'findAll');

      $this->assertTrue($method_defined);
    }

    public function testFindAllMustReturnASQLiteResultInstance()
    {
      $db = new Adapter();

      $this->assertInstanceOf('SQLite3Result', $db->findAll());
    }
  }