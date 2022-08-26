<?php

class Book
{
  private $id;
  private $title;
  private $author;
  private $image;
  private $price;
  private $description;
  private $quantity = 1;


  public function getId()
  {
    return $this->id;
  }

  public function getTitle()
  {
    return $this->title;
  }
  public function setTitle($title)
  {
    return $this->title = $title;
  }

  public function getAuthor()
  {
    return $this->author;
  }
  public function setAuthor($author)
  {
    return $this->author = $author;
  }

  public function getImage()
  {
    return $this->image;
  }
  public function setImage($image)
  {
    return $this->image = $image;
  }

  public function getPrice()
  {
    return $this->price;
  }
  public function setPrice($price)
  {
    return $this->price = $price;
  }

  public function getDescription()
  {
    return $this->description;
  }
  public function setDescription($description)
  {
    return $this->description = $description;
  }


  /**
   * Get the value of quantity
   */ 
  public function getQuantity()
  {
    return $this->quantity;
  }

  /**
   * Set the value of quantity
   *
   * @return  self
   */ 
  public function setQuantity($quantity)
  {
    $this->quantity = $quantity;

    return $this;
  }
}