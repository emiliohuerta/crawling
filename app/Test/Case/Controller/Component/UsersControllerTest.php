<?php

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;


/**
 * CategoryRealEstatesController Test Case
 */
class UsersControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
	

	);

    public function setUp() {
        parent::setUp();
        $Controller = new Controller();
        $View = new View($Controller);
    }

/**
 * testAdminIndex method
 *
 * @return void
 */
    public function testIndex()
    {

        //$result = $this->testAction('/users?page=1', array('method' => array('get')));

 
        // Check for a 2xx response code
        $this->assertResponseOk();

        // Assert partial response content
       // $this->assertResponseContains('john.doe');
    }

    public function testView()
    {
        $this->get('/users/view/2');

        // Check for a 2xx response code
        $this->assertResponseOk();

        // Assert partial response content
        $this->assertResponseContains('jane.doe');
    }

    public function testAdd()
    {
        $this->get('/users/add');

        // Check for a 2xx response code
        $this->assertResponseOk();

        $data = [
        'id' => 15,
        'username' => 'ken.kitchen',
        'password' => 'qwerty',
        'created' => time(),
        'modified' => time()
        ];
        $this->post('/users/add', $data);

        // Check for a 2xx response code
        $this->assertResponseSuccess();

        // Assert view variables
        $users = TableRegistry::get('Users');
        $query = $users->find()->where(['username' => $data['username']]);
        $this->assertEquals(1, $query->count());
    }

    public function testDelete()
    {
        $this->delete('/users/delete/3');

        // Check for a 2xx/3xx response code
        $this->assertResponseSuccess();

        $users = TableRegistry::get('Users');
        $data = $users->find()->where(['id' => 3]);
        $this->assertEquals(0, $data->count());
    }
}
