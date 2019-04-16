<?php

namespace Core\User;

class Session extends Abstracts\Session {

    /**
     * Konstruktorius pradeda sesiją ir bando
     * user'į prijungti su Cookie
     *
     * Session constructor.
     * @param \Core\User\Repository $repo
     */
    public function __construct(Repository $repo) {
        $this->repo = $repo;
        $this->is_logged_in = false;
        session_start();
        $this->loginViaCookie();
    }

    /**
     * Grazina $is_logged_in;
     */
    public function isLoggedIn() {
        return $this->is_logged_in;
    }

    /**
     * Bando user'į priloginti iš
     * Server-Side'o Cookie $_SESSION
     * bandant jį priloginti su $_SESSION'e
     * išsaugotais email ir password
     */
    public function loginViaCookie() {
        $email = $_SESSION['email'] ?? '';
        $password = $_SESSION['password'] ?? '';

        return $this->login($email, $password);
    }

    /**
     * Bando user'į priloginti per $email ir $password
     *
     * Jeigu blogas passwordas/email, return'inti
     * LOGIN_ERR_CREDENTIALS
     *
     * Jeigu useris not active, return'inti
     * LOGIN_ERR_NOT_ACTIVE
     *
     * Jeigu viskas gerai:
     * 1# į $_SESSION išsaugoti email ir password
     * 2# nusettinti $this->user
     * 3# return'inti LOGIN_SUCCESS
     *
     * @param $email
     * @param $password
     * @return int
     */
    public function login($email, $password): int {
        $user = $this->repo->load($email);
        if ($user) {
            if ($user->getPassword() == $password) {
                if ($user->getIsActive()) {
                    $_SESSION = [
                        'email' => $email,
                        'password' => $password
                    ];
                    $this->is_logged_in = true;
                    $this->user = $user;

                    return self::LOGIN_SUCCESS;

                } else {
                    return self::LOGIN_ERR_NOT_ACTIVE;
                }
            }
        }

        return self::LOGIN_ERR_CREDENTIALS;
    }

    /**
     * Išvalyti $_SESSION
     * užbaigti sesiją (Google)
     * ištrinti sesijos cookie (Google)
     * nustatyti is_logged_in
     * nustatyti $this->user
     */
    public function logout() {
        $_SESSION = [];

        setcookie(session_name(), '', -1);
        session_destroy();

        $this->is_logged_in = false;
        $this->user = null;
    }

    /**
     * Return'inti user'io objektą
     *
     * @return User
     */
    public function getUser(): User {
        return $this->user;
    }
}