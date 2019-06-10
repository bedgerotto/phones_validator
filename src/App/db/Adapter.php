<?php
  namespace App\db;

  class Adapter
  {
    private $connection;

    public function __construct()
    {
      $connection = new \SQLite3(__DIR__.'/../../../customers.db');

      $this->connection = $connection;
    }

    public function findAll()
    {
      return $this->connection->query('SELECT * FROM customer');
    }
  }