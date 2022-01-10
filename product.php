<?php

/**
    @author Emre Caniklioglu
    Model for the product table
 */

class product {

    private $pid;
    private $pname;
    private $price;
    private $stock;

    public function __construct($pid, $pname, $price, $stock)
    {
        $this->pid = $pid;
        $this->pname = $pname;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getPid() {
        return $this->pid;
    }

    public function setPid($pid) {
        $this->pid = $pid;
    }

    public function getPname() {
        return $this->pname;
    }

    public function setPname($pname) {
        $this->pname = $pname;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }
}