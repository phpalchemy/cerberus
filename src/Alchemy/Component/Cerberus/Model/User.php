<?php

namespace Alchemy\Component\Cerberus\Model;

use Alchemy\Component\Cerberus\Model\Base\User as BaseUser;
use Alchemy\Component\Cerberus\_ as _;

class User extends BaseUser
{
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

        parent::save();
    }
}
