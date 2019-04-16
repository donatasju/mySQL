<?php

namespace App\Rap;

class Song extends Abstracts\Song {

    /**
     * @return array
     */
    public function getSong() {
        return $this->song;
    }
}