<?php

namespace julio101290\boilerplateunidadesmedidas\Models;

use CodeIgniter\Model;

class Unidades_medidaModel extends Model {

    protected $table = 'unidades_medida';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'idEmpresa', 'descripcion', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $deletedField = 'deleted_at';
    protected $validationRules = [
        'idEmpresa' => 'required|greater_than[0]',
        'descripcion' => 'required|min_length[3]',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function mdlGetUnidades_medida(array $idEmpresas) {
        return $this->db->table('unidades_medida a')
                        ->select('
            a.id,
            a.idEmpresa,
            a.descripcion,
            a.created_at,
            a.updated_at,
            a.deleted_at,
            b.nombre AS nombreEmpresa
        ')
                        ->join('empresas b', 'a.idEmpresa = b.id')
                        ->whereIn('a.idEmpresa', $idEmpresas);
    }
}
