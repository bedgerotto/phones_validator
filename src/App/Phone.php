<?php
  namespace App;

  use App\db\Adapter,
      App\collections\PhonesCollection;

  class Phone
  {
    const countries_params = [
      237 => [ 'name' => 'Cameroon',   'regex' => '/\(237\)\ ?[2368]\d{7,8}$/' ],
      251 => [ 'name' => 'Ethiopia',   'regex' => '/\(251\)\ ?[1-59]\d{8}$/'   ],
      212 => [ 'name' => 'Morocco',    'regex' => '/\(212\)\ ?[5-9]\d{8}$/'    ],
      258 => [ 'name' => 'Mozambique', 'regex' => '/\(258\)\ ?[28]\d{7,8}$/'   ],
      256 => [ 'name' => 'Uganda',     'regex' => '/\(256\)\ ?\d{9}/'          ]
    ];

    public $number;
    public $country;
    public $code;

    public function __construct($number = null)
    {
      $this->number = $number;
      $this->country = $this->countryFromNumber();
      $this->code = $this->countryCodeFromNumber();
    }

    public function isValid()
    {
      if (empty($this->number))
        return false;

      $pattern = self::countries_params[$this->countryCodeFromNumber()]['regex'];
      preg_match($pattern, $this->number, $matches);

      if (empty($matches))
        return false;

      return true;
    }

    public static function findBy($filters)
    {
      $adapter = new Adapter();
      $result = $adapter->findAll();
      $phones = new PhonesCollection($result, $filters);

      return $phones->filteredCollection();
    }

    private function countryFromNumber()
    {
      if (empty($this->number))
        return null;

      $countryData = self::countries_params[$this->countryCodeFromNumber()];

      if (empty($countryData))
        return null;

      return $countryData['name'];
    }

    private function countryCodeFromNumber()
    {
      preg_match('/\d{3}(?=\))/', $this->number, $country_code);

      if (empty($country_code))
        return false;

      return $country_code[0];
    }
  }
