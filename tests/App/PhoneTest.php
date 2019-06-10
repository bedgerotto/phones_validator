<?php
  namespace App;
  
  use App\TestCase,
      App\Phone;

  class PhoneTest extends TestCase
  {
    const validNumbers   = ['(212) 698054317', '(258) 847651504', '(256) 775069443', '(251) 914701723', '(237) 697151594'];
    const invalidNumbers = ['(212) 6617344445', '(258) 84330678235', '(256) 7503O6263', '(251) 9773199405', '(237) 6A0311634'];

    public function testValidateClassAttributes()
    {
      $this->assertClassHasAttribute('number', Phone::class);
      $this->assertClassHasAttribute('country', Phone::class);
      $this->assertClassHasAttribute('code', Phone::class);
    }

    public function testDeclaresIsValidMethod()
    {
      $phone = new Phone();
      $method_defined = method_exists($phone, 'isValid');

      $this->assertTrue($method_defined);
    }

    public function testDeclaresFindByMethod()
    {
      $phone = new Phone();
      $method_defined = method_exists($phone, 'findBy');

      $this->assertTrue($method_defined);
    }

    public function testCountriesParamsPhoneCodeShouldBeValid()
    {
      $this->assertEquals(Phone::countries_params[237], [ 'name' => 'Cameroon',   'regex' => '/\(237\)\ ?[2368]\d{7,8}$/' ]);
      $this->assertEquals(Phone::countries_params[251], [ 'name' => 'Ethiopia',   'regex' => '/\(251\)\ ?[1-59]\d{8}$/'   ]);
      $this->assertEquals(Phone::countries_params[212], [ 'name' => 'Morocco',    'regex' => '/\(212\)\ ?[5-9]\d{8}$/'    ]);
      $this->assertEquals(Phone::countries_params[258], [ 'name' => 'Mozambique', 'regex' => '/\(258\)\ ?[28]\d{7,8}$/'   ]);
      $this->assertEquals(Phone::countries_params[256], [ 'name' => 'Uganda',     'regex' => '/\(256\)\ ?\d{9}/'          ]);
    }

    public function testValidNumbersFromDistinctCountries()
    {
      foreach (self::validNumbers as $number) {
        $phone = new Phone($number);

        $this->assertTrue($phone->isValid());
      }
    }

    public function testInvalidNumbersFromDistinctCountries()
    {
      foreach (self::invalidNumbers as $number) {
        $phone = new Phone($number);

        $this->assertFalse($phone->isValid());
      }
    }

    public function testValidateIfANumberIsFromMorocco()
    {
      $valid_phone = new Phone('(212) 698054317');
      $invalid_phone = new Phone('(212) 6546545369');

      $this->assertEquals($valid_phone->country, 'Morocco');
      $this->assertEquals($invalid_phone->country, 'Morocco');
    }

    public function testGetCorrectCountryCodeFromNumber()
    {
      $phone = new Phone('(212) 698054317');

      $this->assertEquals($phone->code, 212);
    }

    public function testFindValidNumbersFromCameroon()
    {
      $phones = Phone::findBy(['country' => 237, 'state' => '1']);

      $this->assertEquals(7, count($phones));
    }

    public function testFindInvalidNumbersFromUganda()
    {
      $phones = Phone::findBy(['country' => 256, 'state' => '2']);

      $this->assertEquals(1, count($phones));
    }

    public function testFindAllNumbersFromMorocco()
    {
      $phones = Phone::findBy(['country' => 212]);

      $this->assertEquals(7, count($phones));
    }

    public function testFindAllInvalidNumbers()
    {
      $phones = Phone::findBy(['state' => 2]);

      $this->assertEquals(11, count($phones));
    }
  }