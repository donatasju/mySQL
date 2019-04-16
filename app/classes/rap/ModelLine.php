<?php

namespace App\Rap;

use Core\FileDB;

class ModelLine {

    /**
     * @var string Name of a table
     */
    protected $table_name;

    /**
     * @var FileDB
     */
    protected $db;

    /**
     * ModelLine constructor.
     * @param FileDB $db
     * @param $table_name
     */
    public function __construct(FileDB $db, $table_name) {
        $this->table_name = $table_name;
        $this->db = $db;
    }

    /**
     * @param Line $line
     * @return bool
     */
    public function exists(\App\Rap\Line $line) {
        return $this->db->rowExists($this->table_name, $line->getLineText());
    }

    /**
     * Checks if row by this ID exists and Inserts specific row into given table and saves it.
     *
     * @param Line $line
     * @return bool
     */
    public function insert(\App\Rap\Line $line) {
        if (!$this->exists($line)) {
            $this->db->setRow($this->table_name, $this->getCount(), $line->getData());
            $this->db->save();

            return true;
        }
    }

    /**
     * Loads all the rows from given table as array of objects.
     *
     * @return array
     */
    public function loadAll() {
        $lines_array = [];

        foreach ($this->db->getRows($this->table_name) as $line) {
            $lines_array[] = new \App\Rap\Line($line);
        }

        return $lines_array;
    }

    /**
     * @return bool|int
     */
    public function getCount() {
        $get_count = $this->db->getCount($this->table_name);
        if ($get_count) {
            return $get_count;
        }

        return 0;
    }
}