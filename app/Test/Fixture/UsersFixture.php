<?php 
/**
 * Action Fixture
 */
class UsersFixture extends CakeTestFixture {
 
/**
* Records
*
* @var array
*/
public $records = [
[
'id' => 1,
'username' => 'john.doe',
'password' => 'loremipsum',
'role' => 'admin',
'created' => '2015-08-08 20:51:50',
'modified' => '2015-08-08 20:51:50'
],
[
'id' => 2,
'username' => 'jane.doe',
'password' => 'loremipsum',
'role' => 'editor',
'created' => '2015-08-08 20:51:50',
'modified' => '2015-08-08 20:51:50'
],
[
'id' => 3,
'username' => 'jack.doe',
'password' => 'loremipsum',
'role' => 'viewer',
'created' => '2015-08-08 20:51:50',
'modified' => '2015-08-08 20:51:50'
],
];

}