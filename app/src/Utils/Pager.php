<?php

namespace App\Utils;


class Pager 
{

    public int $page;
    public int $size;

    public function __construct(int $page, int $size) {
        $this->page = $page;
        $this->size = $size;
    }
    
    public function getOffset() {
        return ($this->page - 1) * $this->size;
    }

    public function next() {
        $this->page++;
    }
}
