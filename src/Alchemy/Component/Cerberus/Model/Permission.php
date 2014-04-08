<?php

namespace Alchemy\Component\Cerberus\Model;

use Alchemy\Component\Cerberus\Model\Base\Permission as BasePermission;
use \Propel\Runtime\Map\TableMap;

class Permission extends BasePermission
{
    public function save(\Propel\Runtime\Connection\ConnectionInterface $con = null)
    {
        if ($this->getId()) {
            $this->setUpdateDate(date("Y-m-d H:i:s"));
        } else {
            $this->setCreateDate(date("Y-m-d H:i:s"));
        }

        parent::save();
    }

    public function toArray($keyColumn = null, $usePrefix = false, $keyType = TableMap::TYPE_FIELDNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {
        parent::toArray($keyColumn, $usePrefix, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
    }
}
