<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Test
 * @subpackage PHPUnit
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

use PHPUnit\DbUnit\Database\DefaultConnection;
use PHPUnit\DbUnit\Database\Metadata\Metadata;
use PHPUnit\DbUnit\DataSet\ITable;

/**
 * @see Zend_Test_PHPUnit_Db_DataSet_QueryTable
 */
/**
 * @see Zend_Test_PHPUnit_Db_Metadata_Generic
 */
/**
 * Generic Abstraction of Zend_Db Connections in the PHPUnit Database Extension context.
 *
 * @uses       Zend_Db_Adapter_Abstract
 * @uses       DefaultConnection
 * @category   Zend
 * @package    Zend_Test
 * @subpackage PHPUnit
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Test_PHPUnit_Db_Connection extends DefaultConnection
{
    /**
     * Zend_Db_Adapter_Abstract
     *
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_connection;

    /**
     * Database Schema
     *
     * @var string $db
     */
    protected $_schema;

    /**
     * Metadata
     *
     * @param Metadata $db
     */
    protected $_metaData;

    /**
     * Construct Connection based on Zend_Db_Adapter_Abstract
     *
     * @param Zend_Db_Adapter_Abstract $db
     * @param string $schema
     */
    public function __construct(Zend_Db_Adapter_Abstract $db, $schema)
    {
        $this->_connection = $db;
        $this->_schema = $schema;
    }

    /**
     * Close this connection.
     *
     * @return void
     */
    public function close(): void
    {
        $this->_connection->closeConnection();
    }

    /**
     * Creates a table with the result of the specified SQL statement.
     *
     * @param string $resultName
     * @param string $sql
     * @return ITable
     */
    public function createQueryTable($resultName, $sql)
    {
        return new Zend_Test_PHPUnit_Db_DataSet_QueryTable($resultName, $sql, $this);
    }

    /**
     * Returns a Zend_Db Connection
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * Returns a database metadata object that can be used to retrieve table
     * meta data from the database.
     *
     * @return Metadata
     */
    public function getMetaData()
    {
        if($this->_metaData === null) {
            $this->_metaData = new Zend_Test_PHPUnit_Db_Metadata_Generic($this->getConnection(), $this->getSchema());
        }
        return $this->_metaData;
    }

    /**
     * Returns the schema for the connection.
     *
     * @return string
     */
    public function getSchema()
    {
        return $this->_schema;
    }

    /**
     * Returns the command used to truncate a table.
     *
     * @return string
     */
    public function getTruncateCommand()
    {
        return "DELETE";
    }
}
