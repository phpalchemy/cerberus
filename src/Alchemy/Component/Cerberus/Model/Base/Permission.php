<?php

namespace Alchemy\Component\Cerberus\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Alchemy\Component\Cerberus\Model\Permission as ChildPermission;
use Alchemy\Component\Cerberus\Model\PermissionQuery as ChildPermissionQuery;
use Alchemy\Component\Cerberus\Model\Role as ChildRole;
use Alchemy\Component\Cerberus\Model\RolePermission as ChildRolePermission;
use Alchemy\Component\Cerberus\Model\RolePermissionQuery as ChildRolePermissionQuery;
use Alchemy\Component\Cerberus\Model\RoleQuery as ChildRoleQuery;
use Alchemy\Component\Cerberus\Model\Map\PermissionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

abstract class Permission implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Alchemy\\Component\\Cerberus\\Model\\Map\\PermissionTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the create_date field.
     * @var        \DateTime
     */
    protected $create_date;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the update_date field.
     * @var        \DateTime
     */
    protected $update_date;

    /**
     * The value for the status field.
     * Note: this column has a database default value of: 'ACTIVE'
     * @var        string
     */
    protected $status;

    /**
     * The value for the parent_id field.
     * @var        int
     */
    protected $parent_id;

    /**
     * @var        ChildPermission
     */
    protected $aPermissionRelatedByParentId;

    /**
     * @var        ObjectCollection|ChildPermission[] Collection to store aggregation of ChildPermission objects.
     */
    protected $collPermissionsRelatedById;
    protected $collPermissionsRelatedByIdPartial;

    /**
     * @var        ObjectCollection|ChildRolePermission[] Collection to store aggregation of ChildRolePermission objects.
     */
    protected $collRolePermissions;
    protected $collRolePermissionsPartial;

    /**
     * @var        ObjectCollection|ChildRole[] Cross Collection to store aggregation of ChildRole objects.
     */
    protected $collRoles;

    /**
     * @var bool
     */
    protected $collRolesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRole[]
     */
    protected $rolesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPermission[]
     */
    protected $permissionsRelatedByIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRolePermission[]
     */
    protected $rolePermissionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->status = 'ACTIVE';
    }

    /**
     * Initializes internal state of Alchemy\Component\Cerberus\Model\Base\Permission object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Permission</code> instance.  If
     * <code>obj</code> is an instance of <code>Permission</code>, delegates to
     * <code>equals(Permission)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Permission The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [optionally formatted] temporal [create_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return string|\DateTime Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreateDate($format = NULL)
    {
        if ($format === null) {
            return $this->create_date;
        } else {
            return $this->create_date instanceof \DateTime ? $this->create_date->format($format) : null;
        }
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [optionally formatted] temporal [update_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return string|\DateTime Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdateDate($format = NULL)
    {
        if ($format === null) {
            return $this->update_date;
        } else {
            return $this->update_date instanceof \DateTime ? $this->update_date->format($format) : null;
        }
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [parent_id] column value.
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->status !== 'ACTIVE') {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PermissionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PermissionTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PermissionTableMap::translateFieldName('CreateDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->create_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PermissionTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PermissionTableMap::translateFieldName('UpdateDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->update_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PermissionTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PermissionTableMap::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parent_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = PermissionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Alchemy\\Component\\Cerberus\\Model\\Permission'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aPermissionRelatedByParentId !== null && $this->parent_id !== $this->aPermissionRelatedByParentId->getId()) {
            $this->aPermissionRelatedByParentId = null;
        }
    } // ensureConsistency

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PermissionTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[PermissionTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Sets the value of [create_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object (for fluent API support)
     */
    public function setCreateDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->create_date !== null || $dt !== null) {
            if ($dt !== $this->create_date) {
                $this->create_date = $dt;
                $this->modifiedColumns[PermissionTableMap::COL_CREATE_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setCreateDate()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[PermissionTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Sets the value of [update_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object (for fluent API support)
     */
    public function setUpdateDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->update_date !== null || $dt !== null) {
            if ($dt !== $this->update_date) {
                $this->update_date = $dt;
                $this->modifiedColumns[PermissionTableMap::COL_UPDATE_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdateDate()

    /**
     * Set the value of [status] column.
     *
     * @param  string $v new value
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[PermissionTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [parent_id] column.
     *
     * @param  int $v new value
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object (for fluent API support)
     */
    public function setParentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parent_id !== $v) {
            $this->parent_id = $v;
            $this->modifiedColumns[PermissionTableMap::COL_PARENT_ID] = true;
        }

        if ($this->aPermissionRelatedByParentId !== null && $this->aPermissionRelatedByParentId->getId() !== $v) {
            $this->aPermissionRelatedByParentId = null;
        }

        return $this;
    } // setParentId()

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PermissionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPermissionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPermissionRelatedByParentId = null;
            $this->collPermissionsRelatedById = null;

            $this->collRolePermissions = null;

            $this->collRoles = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Permission::setDeleted()
     * @see Permission::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPermissionQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PermissionTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aPermissionRelatedByParentId !== null) {
                if ($this->aPermissionRelatedByParentId->isModified() || $this->aPermissionRelatedByParentId->isNew()) {
                    $affectedRows += $this->aPermissionRelatedByParentId->save($con);
                }
                $this->setPermissionRelatedByParentId($this->aPermissionRelatedByParentId);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->rolesScheduledForDeletion !== null) {
                if (!$this->rolesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rolesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \Alchemy\Component\Cerberus\Model\RolePermissionQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rolesScheduledForDeletion = null;
                }

            }

            if ($this->collRoles) {
                foreach ($this->collRoles as $role) {
                    if (!$role->isDeleted() && ($role->isNew() || $role->isModified())) {
                        $role->save($con);
                    }
                }
            }


            if ($this->permissionsRelatedByIdScheduledForDeletion !== null) {
                if (!$this->permissionsRelatedByIdScheduledForDeletion->isEmpty()) {
                    \Alchemy\Component\Cerberus\Model\PermissionQuery::create()
                        ->filterByPrimaryKeys($this->permissionsRelatedByIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->permissionsRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collPermissionsRelatedById !== null) {
                foreach ($this->collPermissionsRelatedById as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rolePermissionsScheduledForDeletion !== null) {
                if (!$this->rolePermissionsScheduledForDeletion->isEmpty()) {
                    \Alchemy\Component\Cerberus\Model\RolePermissionQuery::create()
                        ->filterByPrimaryKeys($this->rolePermissionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rolePermissionsScheduledForDeletion = null;
                }
            }

            if ($this->collRolePermissions !== null) {
                foreach ($this->collRolePermissions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[PermissionTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PermissionTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PermissionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(PermissionTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'NAME';
        }
        if ($this->isColumnModified(PermissionTableMap::COL_CREATE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'CREATE_DATE';
        }
        if ($this->isColumnModified(PermissionTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'DESCRIPTION';
        }
        if ($this->isColumnModified(PermissionTableMap::COL_UPDATE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATE_DATE';
        }
        if ($this->isColumnModified(PermissionTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'STATUS';
        }
        if ($this->isColumnModified(PermissionTableMap::COL_PARENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PARENT_ID';
        }

        $sql = sprintf(
            'INSERT INTO permission (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'NAME':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'CREATE_DATE':
                        $stmt->bindValue($identifier, $this->create_date ? $this->create_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'DESCRIPTION':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'UPDATE_DATE':
                        $stmt->bindValue($identifier, $this->update_date ? $this->update_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'STATUS':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case 'PARENT_ID':
                        $stmt->bindValue($identifier, $this->parent_id, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PermissionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getCreateDate();
                break;
            case 3:
                return $this->getDescription();
                break;
            case 4:
                return $this->getUpdateDate();
                break;
            case 5:
                return $this->getStatus();
                break;
            case 6:
                return $this->getParentId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Permission'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Permission'][$this->getPrimaryKey()] = true;
        $keys = PermissionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getCreateDate(),
            $keys[3] => $this->getDescription(),
            $keys[4] => $this->getUpdateDate(),
            $keys[5] => $this->getStatus(),
            $keys[6] => $this->getParentId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPermissionRelatedByParentId) {
                $result['PermissionRelatedByParentId'] = $this->aPermissionRelatedByParentId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPermissionsRelatedById) {
                $result['PermissionsRelatedById'] = $this->collPermissionsRelatedById->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRolePermissions) {
                $result['RolePermissions'] = $this->collRolePermissions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PermissionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setCreateDate($value);
                break;
            case 3:
                $this->setDescription($value);
                break;
            case 4:
                $this->setUpdateDate($value);
                break;
            case 5:
                $this->setStatus($value);
                break;
            case 6:
                $this->setParentId($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PermissionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCreateDate($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDescription($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUpdateDate($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setStatus($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setParentId($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PermissionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PermissionTableMap::COL_ID)) {
            $criteria->add(PermissionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PermissionTableMap::COL_NAME)) {
            $criteria->add(PermissionTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(PermissionTableMap::COL_CREATE_DATE)) {
            $criteria->add(PermissionTableMap::COL_CREATE_DATE, $this->create_date);
        }
        if ($this->isColumnModified(PermissionTableMap::COL_DESCRIPTION)) {
            $criteria->add(PermissionTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(PermissionTableMap::COL_UPDATE_DATE)) {
            $criteria->add(PermissionTableMap::COL_UPDATE_DATE, $this->update_date);
        }
        if ($this->isColumnModified(PermissionTableMap::COL_STATUS)) {
            $criteria->add(PermissionTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(PermissionTableMap::COL_PARENT_ID)) {
            $criteria->add(PermissionTableMap::COL_PARENT_ID, $this->parent_id);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(PermissionTableMap::DATABASE_NAME);
        $criteria->add(PermissionTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Alchemy\Component\Cerberus\Model\Permission (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setCreateDate($this->getCreateDate());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setUpdateDate($this->getUpdateDate());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setParentId($this->getParentId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPermissionsRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPermissionRelatedById($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRolePermissions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRolePermission($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Alchemy\Component\Cerberus\Model\Permission Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildPermission object.
     *
     * @param  ChildPermission $v
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPermissionRelatedByParentId(ChildPermission $v = null)
    {
        if ($v === null) {
            $this->setParentId(NULL);
        } else {
            $this->setParentId($v->getId());
        }

        $this->aPermissionRelatedByParentId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPermission object, it will not be re-added.
        if ($v !== null) {
            $v->addPermissionRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPermission object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPermission The associated ChildPermission object.
     * @throws PropelException
     */
    public function getPermissionRelatedByParentId(ConnectionInterface $con = null)
    {
        if ($this->aPermissionRelatedByParentId === null && ($this->parent_id !== null)) {
            $this->aPermissionRelatedByParentId = ChildPermissionQuery::create()->findPk($this->parent_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPermissionRelatedByParentId->addPermissionsRelatedById($this);
             */
        }

        return $this->aPermissionRelatedByParentId;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('PermissionRelatedById' == $relationName) {
            return $this->initPermissionsRelatedById();
        }
        if ('RolePermission' == $relationName) {
            return $this->initRolePermissions();
        }
    }

    /**
     * Clears out the collPermissionsRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPermissionsRelatedById()
     */
    public function clearPermissionsRelatedById()
    {
        $this->collPermissionsRelatedById = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPermissionsRelatedById collection loaded partially.
     */
    public function resetPartialPermissionsRelatedById($v = true)
    {
        $this->collPermissionsRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collPermissionsRelatedById collection.
     *
     * By default this just sets the collPermissionsRelatedById collection to an empty array (like clearcollPermissionsRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPermissionsRelatedById($overrideExisting = true)
    {
        if (null !== $this->collPermissionsRelatedById && !$overrideExisting) {
            return;
        }
        $this->collPermissionsRelatedById = new ObjectCollection();
        $this->collPermissionsRelatedById->setModel('\Alchemy\Component\Cerberus\Model\Permission');
    }

    /**
     * Gets an array of ChildPermission objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPermission is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPermission[] List of ChildPermission objects
     * @throws PropelException
     */
    public function getPermissionsRelatedById(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPermissionsRelatedByIdPartial && !$this->isNew();
        if (null === $this->collPermissionsRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPermissionsRelatedById) {
                // return empty collection
                $this->initPermissionsRelatedById();
            } else {
                $collPermissionsRelatedById = ChildPermissionQuery::create(null, $criteria)
                    ->filterByPermissionRelatedByParentId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPermissionsRelatedByIdPartial && count($collPermissionsRelatedById)) {
                        $this->initPermissionsRelatedById(false);

                        foreach ($collPermissionsRelatedById as $obj) {
                            if (false == $this->collPermissionsRelatedById->contains($obj)) {
                                $this->collPermissionsRelatedById->append($obj);
                            }
                        }

                        $this->collPermissionsRelatedByIdPartial = true;
                    }

                    return $collPermissionsRelatedById;
                }

                if ($partial && $this->collPermissionsRelatedById) {
                    foreach ($this->collPermissionsRelatedById as $obj) {
                        if ($obj->isNew()) {
                            $collPermissionsRelatedById[] = $obj;
                        }
                    }
                }

                $this->collPermissionsRelatedById = $collPermissionsRelatedById;
                $this->collPermissionsRelatedByIdPartial = false;
            }
        }

        return $this->collPermissionsRelatedById;
    }

    /**
     * Sets a collection of ChildPermission objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $permissionsRelatedById A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPermission The current object (for fluent API support)
     */
    public function setPermissionsRelatedById(Collection $permissionsRelatedById, ConnectionInterface $con = null)
    {
        /** @var ChildPermission[] $permissionsRelatedByIdToDelete */
        $permissionsRelatedByIdToDelete = $this->getPermissionsRelatedById(new Criteria(), $con)->diff($permissionsRelatedById);


        $this->permissionsRelatedByIdScheduledForDeletion = $permissionsRelatedByIdToDelete;

        foreach ($permissionsRelatedByIdToDelete as $permissionRelatedByIdRemoved) {
            $permissionRelatedByIdRemoved->setPermissionRelatedByParentId(null);
        }

        $this->collPermissionsRelatedById = null;
        foreach ($permissionsRelatedById as $permissionRelatedById) {
            $this->addPermissionRelatedById($permissionRelatedById);
        }

        $this->collPermissionsRelatedById = $permissionsRelatedById;
        $this->collPermissionsRelatedByIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Permission objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Permission objects.
     * @throws PropelException
     */
    public function countPermissionsRelatedById(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPermissionsRelatedByIdPartial && !$this->isNew();
        if (null === $this->collPermissionsRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPermissionsRelatedById) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPermissionsRelatedById());
            }

            $query = ChildPermissionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPermissionRelatedByParentId($this)
                ->count($con);
        }

        return count($this->collPermissionsRelatedById);
    }

    /**
     * Method called to associate a ChildPermission object to this object
     * through the ChildPermission foreign key attribute.
     *
     * @param  ChildPermission $l ChildPermission
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object (for fluent API support)
     */
    public function addPermissionRelatedById(ChildPermission $l)
    {
        if ($this->collPermissionsRelatedById === null) {
            $this->initPermissionsRelatedById();
            $this->collPermissionsRelatedByIdPartial = true;
        }

        if (!$this->collPermissionsRelatedById->contains($l)) {
            $this->doAddPermissionRelatedById($l);
        }

        return $this;
    }

    /**
     * @param ChildPermission $permissionRelatedById The ChildPermission object to add.
     */
    protected function doAddPermissionRelatedById(ChildPermission $permissionRelatedById)
    {
        $this->collPermissionsRelatedById[]= $permissionRelatedById;
        $permissionRelatedById->setPermissionRelatedByParentId($this);
    }

    /**
     * @param  ChildPermission $permissionRelatedById The ChildPermission object to remove.
     * @return $this|ChildPermission The current object (for fluent API support)
     */
    public function removePermissionRelatedById(ChildPermission $permissionRelatedById)
    {
        if ($this->getPermissionsRelatedById()->contains($permissionRelatedById)) {
            $pos = $this->collPermissionsRelatedById->search($permissionRelatedById);
            $this->collPermissionsRelatedById->remove($pos);
            if (null === $this->permissionsRelatedByIdScheduledForDeletion) {
                $this->permissionsRelatedByIdScheduledForDeletion = clone $this->collPermissionsRelatedById;
                $this->permissionsRelatedByIdScheduledForDeletion->clear();
            }
            $this->permissionsRelatedByIdScheduledForDeletion[]= $permissionRelatedById;
            $permissionRelatedById->setPermissionRelatedByParentId(null);
        }

        return $this;
    }

    /**
     * Clears out the collRolePermissions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRolePermissions()
     */
    public function clearRolePermissions()
    {
        $this->collRolePermissions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRolePermissions collection loaded partially.
     */
    public function resetPartialRolePermissions($v = true)
    {
        $this->collRolePermissionsPartial = $v;
    }

    /**
     * Initializes the collRolePermissions collection.
     *
     * By default this just sets the collRolePermissions collection to an empty array (like clearcollRolePermissions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRolePermissions($overrideExisting = true)
    {
        if (null !== $this->collRolePermissions && !$overrideExisting) {
            return;
        }
        $this->collRolePermissions = new ObjectCollection();
        $this->collRolePermissions->setModel('\Alchemy\Component\Cerberus\Model\RolePermission');
    }

    /**
     * Gets an array of ChildRolePermission objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPermission is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRolePermission[] List of ChildRolePermission objects
     * @throws PropelException
     */
    public function getRolePermissions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRolePermissionsPartial && !$this->isNew();
        if (null === $this->collRolePermissions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRolePermissions) {
                // return empty collection
                $this->initRolePermissions();
            } else {
                $collRolePermissions = ChildRolePermissionQuery::create(null, $criteria)
                    ->filterByPermission($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRolePermissionsPartial && count($collRolePermissions)) {
                        $this->initRolePermissions(false);

                        foreach ($collRolePermissions as $obj) {
                            if (false == $this->collRolePermissions->contains($obj)) {
                                $this->collRolePermissions->append($obj);
                            }
                        }

                        $this->collRolePermissionsPartial = true;
                    }

                    return $collRolePermissions;
                }

                if ($partial && $this->collRolePermissions) {
                    foreach ($this->collRolePermissions as $obj) {
                        if ($obj->isNew()) {
                            $collRolePermissions[] = $obj;
                        }
                    }
                }

                $this->collRolePermissions = $collRolePermissions;
                $this->collRolePermissionsPartial = false;
            }
        }

        return $this->collRolePermissions;
    }

    /**
     * Sets a collection of ChildRolePermission objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rolePermissions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPermission The current object (for fluent API support)
     */
    public function setRolePermissions(Collection $rolePermissions, ConnectionInterface $con = null)
    {
        /** @var ChildRolePermission[] $rolePermissionsToDelete */
        $rolePermissionsToDelete = $this->getRolePermissions(new Criteria(), $con)->diff($rolePermissions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rolePermissionsScheduledForDeletion = clone $rolePermissionsToDelete;

        foreach ($rolePermissionsToDelete as $rolePermissionRemoved) {
            $rolePermissionRemoved->setPermission(null);
        }

        $this->collRolePermissions = null;
        foreach ($rolePermissions as $rolePermission) {
            $this->addRolePermission($rolePermission);
        }

        $this->collRolePermissions = $rolePermissions;
        $this->collRolePermissionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RolePermission objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RolePermission objects.
     * @throws PropelException
     */
    public function countRolePermissions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRolePermissionsPartial && !$this->isNew();
        if (null === $this->collRolePermissions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRolePermissions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRolePermissions());
            }

            $query = ChildRolePermissionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPermission($this)
                ->count($con);
        }

        return count($this->collRolePermissions);
    }

    /**
     * Method called to associate a ChildRolePermission object to this object
     * through the ChildRolePermission foreign key attribute.
     *
     * @param  ChildRolePermission $l ChildRolePermission
     * @return $this|\Alchemy\Component\Cerberus\Model\Permission The current object (for fluent API support)
     */
    public function addRolePermission(ChildRolePermission $l)
    {
        if ($this->collRolePermissions === null) {
            $this->initRolePermissions();
            $this->collRolePermissionsPartial = true;
        }

        if (!$this->collRolePermissions->contains($l)) {
            $this->doAddRolePermission($l);
        }

        return $this;
    }

    /**
     * @param ChildRolePermission $rolePermission The ChildRolePermission object to add.
     */
    protected function doAddRolePermission(ChildRolePermission $rolePermission)
    {
        $this->collRolePermissions[]= $rolePermission;
        $rolePermission->setPermission($this);
    }

    /**
     * @param  ChildRolePermission $rolePermission The ChildRolePermission object to remove.
     * @return $this|ChildPermission The current object (for fluent API support)
     */
    public function removeRolePermission(ChildRolePermission $rolePermission)
    {
        if ($this->getRolePermissions()->contains($rolePermission)) {
            $pos = $this->collRolePermissions->search($rolePermission);
            $this->collRolePermissions->remove($pos);
            if (null === $this->rolePermissionsScheduledForDeletion) {
                $this->rolePermissionsScheduledForDeletion = clone $this->collRolePermissions;
                $this->rolePermissionsScheduledForDeletion->clear();
            }
            $this->rolePermissionsScheduledForDeletion[]= clone $rolePermission;
            $rolePermission->setPermission(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Permission is new, it will return
     * an empty collection; or if this Permission has previously
     * been saved, it will retrieve related RolePermissions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Permission.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRolePermission[] List of ChildRolePermission objects
     */
    public function getRolePermissionsJoinRole(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRolePermissionQuery::create(null, $criteria);
        $query->joinWith('Role', $joinBehavior);

        return $this->getRolePermissions($query, $con);
    }

    /**
     * Clears out the collRoles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoles()
     */
    public function clearRoles()
    {
        $this->collRoles = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRoles collection.
     *
     * By default this just sets the collRoles collection to an empty collection (like clearRoles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRoles()
    {
        $this->collRoles = new ObjectCollection();
        $this->collRolesPartial = true;

        $this->collRoles->setModel('\Alchemy\Component\Cerberus\Model\Role');
    }

    /**
     * Checks if the collRoles collection is loaded.
     *
     * @return bool
     */
    public function isRolesLoaded()
    {
        return null !== $this->collRoles;
    }

    /**
     * Gets a collection of ChildRole objects related by a many-to-many relationship
     * to the current object by way of the role_permission cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPermission is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildRole[] List of ChildRole objects
     */
    public function getRoles(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRolesPartial && !$this->isNew();
        if (null === $this->collRoles || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRoles) {
                    $this->initRoles();
                }
            } else {

                $query = ChildRoleQuery::create(null, $criteria)
                    ->filterByPermission($this);
                $collRoles = $query->find($con);
                if (null !== $criteria) {
                    return $collRoles;
                }

                if ($partial && $this->collRoles) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRoles as $obj) {
                        if (!$collRoles->contains($obj)) {
                            $collRoles[] = $obj;
                        }
                    }
                }

                $this->collRoles = $collRoles;
                $this->collRolesPartial = false;
            }
        }

        return $this->collRoles;
    }

    /**
     * Sets a collection of Role objects related by a many-to-many relationship
     * to the current object by way of the role_permission cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $roles A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPermission The current object (for fluent API support)
     */
    public function setRoles(Collection $roles, ConnectionInterface $con = null)
    {
        $this->clearRoles();
        $currentRoles = $this->getRoles();

        $rolesScheduledForDeletion = $currentRoles->diff($roles);

        foreach ($rolesScheduledForDeletion as $toDelete) {
            $this->removeRole($toDelete);
        }

        foreach ($roles as $role) {
            if (!$currentRoles->contains($role)) {
                $this->doAddRole($role);
            }
        }

        $this->collRolesPartial = false;
        $this->collRoles = $roles;

        return $this;
    }

    /**
     * Gets the number of Role objects related by a many-to-many relationship
     * to the current object by way of the role_permission cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Role objects
     */
    public function countRoles(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRolesPartial && !$this->isNew();
        if (null === $this->collRoles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRoles) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRoles());
                }

                $query = ChildRoleQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPermission($this)
                    ->count($con);
            }
        } else {
            return count($this->collRoles);
        }
    }

    /**
     * Associate a ChildRole to this object
     * through the role_permission cross reference table.
     *
     * @param ChildRole $role
     * @return ChildPermission The current object (for fluent API support)
     */
    public function addRole(ChildRole $role)
    {
        if ($this->collRoles === null) {
            $this->initRoles();
        }

        if (!$this->getRoles()->contains($role)) {
            // only add it if the **same** object is not already associated
            $this->collRoles->push($role);
            $this->doAddRole($role);
        }

        return $this;
    }

    /**
     *
     * @param ChildRole $role
     */
    protected function doAddRole(ChildRole $role)
    {
        $rolePermission = new ChildRolePermission();

        $rolePermission->setRole($role);

        $rolePermission->setPermission($this);

        $this->addRolePermission($rolePermission);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$role->isPermissionsLoaded()) {
            $role->initPermissions();
            $role->getPermissions()->push($this);
        } elseif (!$role->getPermissions()->contains($this)) {
            $role->getPermissions()->push($this);
        }

    }

    /**
     * Remove role of this object
     * through the role_permission cross reference table.
     *
     * @param ChildRole $role
     * @return ChildPermission The current object (for fluent API support)
     */
    public function removeRole(ChildRole $role)
    {
        if ($this->getRoles()->contains($role)) { $rolePermission = new ChildRolePermission();

            $rolePermission->setRole($role);
            if ($role->isPermissionsLoaded()) {
                //remove the back reference if available
                $role->getPermissions()->removeObject($this);
            }

            $rolePermission->setPermission($this);
            $this->removeRolePermission(clone $rolePermission);
            $rolePermission->clear();

            $this->collRoles->remove($this->collRoles->search($role));

            if (null === $this->rolesScheduledForDeletion) {
                $this->rolesScheduledForDeletion = clone $this->collRoles;
                $this->rolesScheduledForDeletion->clear();
            }

            $this->rolesScheduledForDeletion->push($role);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPermissionRelatedByParentId) {
            $this->aPermissionRelatedByParentId->removePermissionRelatedById($this);
        }
        $this->id = null;
        $this->name = null;
        $this->create_date = null;
        $this->description = null;
        $this->update_date = null;
        $this->status = null;
        $this->parent_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collPermissionsRelatedById) {
                foreach ($this->collPermissionsRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRolePermissions) {
                foreach ($this->collRolePermissions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRoles) {
                foreach ($this->collRoles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPermissionsRelatedById = null;
        $this->collRolePermissions = null;
        $this->collRoles = null;
        $this->aPermissionRelatedByParentId = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PermissionTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
