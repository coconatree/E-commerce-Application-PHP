<?php

/**
    @author Emre Caniklioglu
    Model class for representing customer table in php
 */

class customer {

    private $cid;
    private $cname;
    private $bdata;
    private $address;
    private $city;
    private $wallet;

    public function __construct($cid, $cname, $bdata, $address, $city, $wallet) {
        $this->cid = $cid;
        $this->cname = $cname;
        $this->bdata = $bdata;
        $this->address = $address;
        $this->city = $city;
        $this->wallet = $wallet;
    }

    public function getCid() {
        return $this->cid;
    }

    public function setCid($cid) {
        $this->cid = $cid;
    }

    public function getCname() {
        return $this->cname;
    }

    public function setCname($cname) {
        $this->cname = $cname;
    }

    public function getBdata() {
        return $this->bdata;
    }

    public function setBdata($bdata) {
        $this->bdata = $bdata;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getWallet() {
        return $this->wallet;
    }

    public function setWallet($wallet) {
        $this->wallet = $wallet;
    }
}