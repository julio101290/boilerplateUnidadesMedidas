<?php

namespace julio101290\boilerplateunidadesmedidas\Database\Seeds;

use CodeIgniter\Config\Services;
use CodeIgniter\Database\Seeder;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

/**
 * Class BoilerplateSeeder.
 */
class BoilerplateUnidadesMedida extends Seeder {

    /**
     * @var Authorize
     */
    protected $authorize;

    /**
     * @var Db
     */
    protected $db;

    /**
     * @var Users
     */
    protected $users;

    public function __construct() {
        $this->authorize = Services::authorization();
        $this->db = \Config\Database::connect();
        $this->users = new UserModel();
    }

    public function run() {


        // Permission
        $this->authorize->createPermission('unidades_medida-permission', 'Permissions for measure units');

        // Assign Permission to user
        $this->authorize->addPermissionToUser('unidades_medida-permission', 1);
    }

    public function down() {
        //
    }
}
