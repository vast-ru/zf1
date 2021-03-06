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

use PHPUnit\DbUnit\Operation\Composite;
use PHPUnit\DbUnit\Operation\Factory;
use PHPUnit\DbUnit\Operation\Operation;
use PHPUnit\DbUnit\TestCase;

/**
 * @see Zend_Test_PHPUnit_Db_Operation_Truncate
 */
/**
 * @see Zend_Test_PHPUnit_Db_Operation_Insert
 */
/**
 * @see Zend_Test_PHPUnit_Db_DataSet_DbTableDataSet
 */
/**
 * @see Zend_Test_PHPUnit_Db_DataSet_DbTable
 */
/**
 * @see Zend_Test_PHPUnit_Db_DataSet_DbRowset
 */
/**
 * Generic Testcase for Zend Framework related DbUnit Testing with PHPUnit
 *
 * @uses       TestCase
 * @category   Zend
 * @package    Zend_Test
 * @subpackage PHPUnit
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Test_PHPUnit_DatabaseTestCase extends TestCase
{
    /**
     * Creates a new Zend Database Connection using the given Adapter and database schema name.
     *
     * @param  Zend_Db_Adapter_Abstract $connection
     * @param  string $schema
     * @return Zend_Test_PHPUnit_Db_Connection
     */
    protected function createZendDbConnection(Zend_Db_Adapter_Abstract $connection, $schema)
    {
        return new Zend_Test_PHPUnit_Db_Connection($connection, $schema);
    }

    /**
     * Convenience function to get access to the database connection.
     *
     * @return Zend_Db_Adapter_Abstract
     */
    protected function getAdapter()
    {
        return $this->getConnection()->getConnection();
    }

    /**
     * Returns the database operation executed in test setup.
     *
     * @return Operation
     */
    protected function getSetUpOperation()
    {
        return new Composite(array(
            new Zend_Test_PHPUnit_Db_Operation_Truncate(),
            new Zend_Test_PHPUnit_Db_Operation_Insert(),
        ));
    }

    /**
     * Returns the database operation executed in test cleanup.
     *
     * @return Operation
     */
    protected function getTearDownOperation()
    {
        return Factory::NONE();
    }

    /**
     * Create a dataset based on multiple Zend_Db_Table instances
     *
     * @param  array $tables
     * @return Zend_Test_PHPUnit_Db_DataSet_DbTableDataSet
     */
    protected function createDbTableDataSet(array $tables=array())
    {
        $dataSet = new Zend_Test_PHPUnit_Db_DataSet_DbTableDataSet();
        foreach($tables AS $table) {
            $dataSet->addTable($table);
        }
        return $dataSet;
    }

    /**
     * Create a table based on one Zend_Db_Table instance
     *
     * @param Zend_Db_Table_Abstract $table
     * @param string $where
     * @param string $order
     * @param string $count
     * @param string $offset
     * @return Zend_Test_PHPUnit_Db_DataSet_DbTable
     */
    protected function createDbTable(Zend_Db_Table_Abstract $table, $where=null, $order=null, $count=null, $offset=null)
    {
        return new Zend_Test_PHPUnit_Db_DataSet_DbTable($table, $where, $order, $count, $offset);
    }

    /**
     * Create a data table based on a Zend_Db_Table_Rowset instance
     *
     * @param  Zend_Db_Table_Rowset_Abstract $rowset
     * @param  string
     * @return Zend_Test_PHPUnit_Db_DataSet_DbRowset
     */
    protected function createDbRowset(Zend_Db_Table_Rowset_Abstract $rowset, $tableName = null)
    {
        return new Zend_Test_PHPUnit_Db_DataSet_DbRowset($rowset, $tableName);
    }
}
