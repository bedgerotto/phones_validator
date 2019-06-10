<?php
  namespace App\collections;

  use App\Phone;

  class PhonesCollection
  {
    private $records;
    private $data = [];
    private $filters;

    public function __construct($db_result, $filters = [])
    {
      $this->records = $db_result;
      $this->filters = $this->prepareFilters($filters);
    }

    public function filteredCollection()
    {
      $this->collection();

      if (!empty($this->filters['country']))
        $this->data = array_filter($this->data, function($phone) {
          return $phone->code == $this->filters['country'];
        });

      if (!is_null($this->filters['state']))
        $this->data = array_filter($this->data, function($phone) {
          return $phone->isValid() == $this->filters['state'];
        });
      
      return $this->data;
    }

    private function collection()
    {
      while ($register = $this->records->fetchArray(SQLITE3_ASSOC))
      {
        $phone = new Phone($register['phone']);

        array_push($this->data, $phone);
      }
    }

    private function prepareFilters($filters)
    {
      $state = null;
      $country = null;

      if (isset($filters['state']) && $filters['state'] == '1' )
        $state = true;

      if (isset($filters['state']) && $filters['state'] == '2' )
        $state = false;

      if (isset($filters['country']) && !empty($filters['country']))
        $country = $filters['country'];
      
      return [ 'state' => $state, 'country' => $country ];
    }
  }
  