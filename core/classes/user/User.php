<?php

namespace Core\User;

class User extends Abstracts\User {

    const ACCOUNT_TYPE_ADMIN = 0;
    const ACCOUNT_TYPE_USER = 1;


    public function __construct($data = null) {
        parent::__construct($data);

        if (!$data) {
            $this->data['is_active'] = null;
            $this->data['account_type'] = null;
            $this->data['password'] = null;
        }
    }

    public function getIsActive() {
        return $this->data['is_active'];
    }

    public function setIsActive($is_active) {
        $this->data['is_active'] = $is_active;
    }

    public function getAccountType(): int {
        return $this->data['account_type'];
    }

    public function setAccountType($type) {
        if (in_array($type, [
            self::ACCOUNT_TYPE_ADMIN,
            self::ACCOUNT_TYPE_USER
        ])) {
            $this->data['account_type'] = $type;

            return true;
        }
    }

    public function getPassword(): string {
        return $this->data['password'];
    }

    public function setPassword(string $password) {
        $this->data['password'] = $password;
    }

    public function setData(array $data) {
        parent::setData($data);
        $this->setIsActive($data['is_active'] ?? null);
        $this->setAccountType($data['account_type'] ?? null);
        $this->setPassword($data['password'] ?? '');
    }
}