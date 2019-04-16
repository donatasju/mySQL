<?php

namespace Core\Models;

use Core\FileDB;

/**
 * Class for working between database class and "User" class.
 */
class ModelUser {

    /**
     * @var string Name of a table
     */
    protected $table_name;

    /**
     * @var FileDB
     */
    protected $db;

    /**
     * ModelUsers constructor.
     * @param FileDB $db
     * @param $table_name
     */
    public function __construct(FileDB $db, $table_name) {
        $this->table_name = $table_name;
        $this->db = $db;
    }

    /**
     * @param $email
     * @return bool|\Core\User\User
     */
    public function load($email) {
        $data_row = $this->db->getRow($this->table_name, $email);
        if ($data_row) {
            return new \Core\User\User($data_row);
        }
    }

    /**
     * @param \Core\User\User $user
     * @return bool
     */
    public function exists(\Core\User\User $user) {
        return $this->db->rowExists($this->table_name, $user->getEmail());
    }

    /**
     * Checks if row by this ID exists and Inserts specific row into given table and saves it.
     *
     * @param \Core\User\User $user
     * @return bool
     */
    public function insert(\Core\User\User $user) {
        if (!$this->exists($user)) {
            $this->db->setRow($this->table_name, $user->getEmail(), $user->getData());
            $this->db->save();

            return true;
        }
    }

    /**
     * Checks if row by this ID exists and Updates specific row into given table and saves it.
     *
     * @param $id
     * @param \Core\User\User $user
     * @return bool
     */
    public function update($id, \Core\User\User $user) {
        if ($this->exists($user)) {
            $this->db->setRow($this->table_name, $id, $user->getData());
            $this->db->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes given row by the ID and saves into the database.
     *
     * @param \Core\User\User $user
     * @return bool
     */
    public function delete(\Core\User\User $user) {
        if ($this->exists($user)) {
            $this->db->deleteRow($this->table_name, $user->getEmail());
            $this->db->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Loads all the rows from given table as array of objects.
     *
     * @return array
     */
    public function loadAll() {
        $user_array = [];
        foreach ($this->db->getRows($this->table_name) as $user) {
            $user_array[] = new \Core\User\User($user);
        }
        return $user_array;
    }

    /**
     * Deletes all the rows from the given table, and saves into the database.
     * @return bool
     */
    public function deleteAll() {
        if ($this->db->deleteRows($this->table_name)) {
            $this->db->save();
            return true;
        } else {
            return false;
        }
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