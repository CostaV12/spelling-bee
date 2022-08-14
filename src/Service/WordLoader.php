<?php

namespace Service;

use Model\Word;

class WordLoader
{
  private $wordStorage;

  public function __construct(PdoWordStorage $wordStorage)
  {
    $this->wordStorage = $wordStorage;
  }

  public function getWords()
  {
    try {
      $wordsData = $this->wordStorage->fetchAllWords();
    } catch (\Exception $e){
      trigger_error('Exception! ' . $e->getMessage());
      $wordsData = [];
    }

    // $words = [];

    // foreach($wordsData as $wordData){
    //   $words[] = $this->createWordFromData($wordData);
    // }

    return $wordsData;
  }

  public function createWordFromData(array $wordData)
  {
    $word = new Word();
    $word->setId($wordData['id']);
    $word->setWord($wordData['word']);
    $word->setTranslate($wordData['translate']);

    return $word;
  }
}
