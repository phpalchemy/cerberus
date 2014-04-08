<?php

namespace Alchemy\Component\Cerberus\Model;

use Alchemy\Component\Cerberus\Model\Base\User as BaseUser;

class User extends BaseUser
{
    protected $passwordCryptCost = 10;
    protected $passwordCryptSalt = "6a42dd6e7ca9a813693714b0d9aa1ad8";

    /**
     * @param mixed $passwordCryptCost
     */
    public function setPasswordCryptCost($passwordCryptCost)
    {
        $this->passwordCryptCost = $passwordCryptCost;
    }

    /**
     * @param mixed $passwordCryptSalt
     */
    public function setPasswordCryptSalt($passwordCryptSalt)
    {
        $this->passwordCryptSalt = $passwordCryptSalt;
    }

    public function setPassword($password)
    {
        // min php ver. 5.3.7+
        $password = crypt($password, '$2a$'.$this->passwordCryptCost.'$'.$this->passwordCryptSalt.'$');

//        $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
//        $salt = base64_encode($salt);
//        $salt = str_replace('+', '.', $salt);
//        $this->passwordCryptSalt = $salt;
//
//        $password = crypt($password, '$2y$'.$this->passwordCryptCost.'$'.$this->passwordCryptSalt.'$');

        parent::setPassword($password);
    }

    public function save(ConnectionInterface $con = null)
    {
        if ($this->getId()) {
            $this->setUpdateDate(date("Y-m-d H:i:s"));
        } else {
            if ($this->getPassword() == "") {
                throw new \Exception(_("User Password can't be empty."));
            }

            $this->setCreateDate(date("Y-m-d H:i:s"));
        }

        parent::save();
    }

    public function getByUsername($username)
    {
        return UserQuery::create()->findOneByUsername($username);
    }

    public function authenticate($password)
    {
        // we need sanitize the value of $password param
        $password = crypt($password, '$2a$'.$this->passwordCryptCost.'$'.$this->passwordCryptSalt.'$');
        return ($this->getPassword() == $password);
    }
}
