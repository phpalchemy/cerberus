<?php

namespace Alchemy\Component\Cerberus\Model;

use Alchemy\Component\Cerberus\Model\Base\User as BaseUser;

class User extends BaseUser
{
    private $passwordUpdated = false;

    public function setPassword($password)
    {
        $this->passwordUpdated = true;
        parent::setPassword($password);
    }

    public function save()
    {
        if ($this->getId()) {
            $this->setUpdateDate(date("Y-m-d H:i:s"));
        } else {
            if ($this->getPassword() == "") {
                throw new \Exception(_("User Password can't be empty."));
            }

            $this->setCreateDate(date("Y-m-d H:i:s"));
        }

        if ($this->passwordUpdated) {
            $this->setPassword(md5($this->getPassword()));
        }

        parent::save();
    }

    public function getByUsername($username)
    {
        return UserQuery::create()->findOneByUsername($username);
    }
}
