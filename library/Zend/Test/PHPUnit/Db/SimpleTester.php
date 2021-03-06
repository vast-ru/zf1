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

use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\DefaultTester;
use PHPUnit\DbUnit\Operation\Composite;
use PHPUnit\DbUnit\Operation\Factory;

/**
 * @see Zend_Test_PHPUnit_Db_Operation_Truncate
 */
/**
 * @see Zend_Test_PHPUnit_Db_Operation_Insert
 */
/**
 * Simple Tester for Database Tests when the Abstract Test Case cannot be used.
 *
 * @uses       DefaultTester
 * @category   Zend
 * @package    Zend_Test
 * @subpackage PHPUnit
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Test_PHPUnit_Db_SimpleTester extends DefaultTester
{
    /**
     * Creates a new default database tester using the given connection.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        if(!($connection instanceof Zend_Test_PHPUnit_Db_Connection)) {
            throw new Zend_Test_PHPUnit_Db_Exception("Not a valid Zend_Test_PHPUnit_Db_Connection instance, ".get_class($connection)." given!");
        }

        $this->connection = $connection;
        $this->setUpOperation = new Composite(array(
            new Zend_Test_PHPUnit_Db_Operation_Truncate(),
            new Zend_Test_PHPUnit_Db_Operation_Insert(),
        ));
        $this->tearDownOperation = Factory::NONE();
    }

    /**
     * Set Up the database using the given Dataset and the SetUp strategy "Truncate, then Insert"
     *
     * @param IDataSet $dataSet
     */
    public function setUpDatabase(IDataSet $dataSet)
    {
        $this->setDataSet($dataSet);
        $this->onSetUp();
    }
}
