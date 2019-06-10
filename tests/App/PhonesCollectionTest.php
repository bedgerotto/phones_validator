<?php
  namespace App;
  
  use App\TestCase,
      App\db\Adapter,
      App\collections\PhonesCollection;

  class PhonesCollectionTest extends TestCase
  {

    public function testValidateClassAttributes()
    {
      $this->assertClassHasAttribute('records', PhonesCollection::class);
      $this->assertClassHasAttribute('data', PhonesCollection::class);
      $this->assertClassHasAttribute('filters', PhonesCollection::class);
    }

    public function testCollectionMustParseDataFromDBResult()
    {
      $db = new Adapter();
      $collection = $db->findAll();

      $this->assertNotEmpty($collection);
    }
  }