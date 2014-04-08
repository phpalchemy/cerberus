<?php

namespace Alchemy\Component\Cerberus\Model;

use Alchemy\Component\Cerberus\Model\Base\Role as BaseRole;

class Role extends BaseRole
{
    public function save(ConnectionInterface $con = null)
    {
        if ($this->getId()) {
            $this->setUpdateDate(date("Y-m-d H:i:s"));
        } else {
            $this->setCreateDate(date("Y-m-d H:i:s"));
        }

        parent::save();
    }
}