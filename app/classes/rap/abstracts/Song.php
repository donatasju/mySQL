<?php

namespace App\Rap\Abstracts;

use App\Rap\ModelLine;
use Core\FileDB;

abstract class Song extends ModelLine {

    protected $song;

    /**
     * Song constructor.
     * @param FileDB $db
     * @param $table_name
     */
    public function __construct(FileDB $db, $table_name) {
        parent::__construct($db, $table_name);

        $this->song = $this->loadAll();
    }

    /**
     * @return mixed
     */
    abstract public function getSong();
}