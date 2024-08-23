<?php

class Cryptex
{
    protected $max;
    protected $prime;
    protected $inverse;
    protected $xor;
    protected $smooth;
    protected $start;

    public function __construct($registry)
    {
        $config = $registry->get('config');

        $this->max = $config->get('cryptex_max');
        $this->prime = $config->get('cryptex_prime');
        $this->inverse = $config->get('cryptex_inverse');
        $this->xor = $config->get('cryptex_xor');
        $this->smooth = $config->get('cryptex_smooth');
        $this->start = $config->get('cryptex_start');
    }

    public function encode($int)
    {
        $int = (int)$int;

        if ($int < $this->start) {
            return $int;
        }

        $int = (($int * $this->prime) % $this->max) ^ $this->xor;

        return $int + $this->smooth;
    }

    public function decode($int)
    {
        $int = (int)$int;

        if ($int < $this->start) {
            return $int;
        }

        $int = $int - $this->smooth;

        $int = (($int ^ $this->xor) * $this->inverse) % $this->max;

        return $int;
    }
}