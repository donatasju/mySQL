<?php

namespace App\Rap;

class Line {

    protected $data;

    public function __construct($data = null) {
        if (!$data) {
            $this->data = [
                'line_text' => null,
                'user_full_name' => null
            ];
        } else {
            $this->setData($data);
        }
    }

    public function setLineText(string $line_text) {
        $this->data['line_text'] = $line_text;
    }

    public function getLineText(): string {
        return $this->data['line_text'];
    }

    public function setUserFullName(string $user_full_name) {
        $this->data['user_full_name'] = $user_full_name;
    }

    public function getUserFullName(): string {
        return $this->data['user_full_name'];
    }

    public function setData(array $data) {
        $this->setLineText($data['line_text'] ?? '');
        $this->setUserFullName($data['user_full_name'] ?? '');
    }

    public function getData() {
        return $this->data;
    }
}