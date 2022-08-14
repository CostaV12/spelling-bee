<?php

namespace Service;

class Container
{
  private $configuration;

  private $pdo;

  private $wordLoader;

  private $wordStorage;

  public function __construct(array $configuration)
  {
    $this->configuration = $configuration;
  }

  public function getPDO(){
    if($this->pdo === NULL){
      $this->pdo = new \PDO(
        $this->configuration['db_dsn'],
        $this->configuration['db_user'],
        $this->configuration['db_pass'],
        array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
      );
    }
    $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    return $this->pdo;
  }

  public function getWordLoader(){
    if($this->wordLoader === NULL){
      $this->wordLoader = new WordLoader($this->getWordStorage());
    }

    return $this->wordLoader;
  }

  public function getWordStorage(){
    if($this->wordStorage === NULL){
      $this->wordStorage = new PdoWordStorage($this->getPDO());
    }

    return $this->wordStorage;
  }
}
