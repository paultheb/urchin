<?php

class Urchin implements \ArrayAccess
{
    private $session;

    protected $user;

    private $default = array(
        'session' => true,
        'is_admin' => false,
        'logged_in' => false,
    );

    public function __construct( &$session )
    {
        $this->session = &$session;

        $this->setup();
    }

    public function login($is_admin = false) {
        $this->session['logged_in'] = true;
        $this->session['is_admin'] = $is_admin;
    }

    public function logout() {
        $this->clear();
    }

    public function isLoggedIn() {
        return (bool)$this->session['logged_in'];
    }

    public function isAdmin() {
        return (bool)$this->session['is_admin'];
    }

    public function offsetExists($offset) {
        return isset($this->session[$offset]);
    }

    public function offsetGet($offset) {
        return $this->session[$offset];
    }

    public function offsetSet($offset, $value) {
        return $this->session[$offset] = $value;
    }

    public function offsetUnset($offset) {
        unset($this->session[$offset]);
    }

    private function clear() {
        $this->session['session'] = false;

        $this->setup();
    }

    private function setup()
    {
        if( !isset($this->session['session']) || !$this->session['session'] ) {
            $this->session = $this->default;
        }
    }
}
