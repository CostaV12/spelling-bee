<?php

namespace Model;

class Word
{
  private $id;

  private $word;

  private $translate;

  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of word
   */
  public function getWord()
  {
    return $this->word;
  }

  /**
   * Set the value of word
   *
   * @return  self
   */
  public function setWord($word)
  {
    $this->word = $word;

    return $this;
  }

  /**
   * Get the value of translate
   */
  public function getTranslate()
  {
    return $this->translate;
  }

  /**
   * Set the value of translate
   *
   * @return  self
   */
  public function setTranslate($translate)
  {
    $this->translate = $translate;

    return $this;
  }
}
