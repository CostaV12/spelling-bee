<?php

namespace Service;

class PdoWordStorage
{
  private $pdo;

  public function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function fetchAllWords()
  {
    $pdo = $this->pdo;
    $stmt = $pdo->prepare("SELECT * FROM words ORDER BY RAND() LIMIT 5 ");
    $stmt->execute();
    $wordsArray = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return $wordsArray;
  }
}
