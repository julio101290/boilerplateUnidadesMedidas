<?php

namespace julio101290\boilerplateunidadesmedidas\Controllers;

use App\Controllers\BaseController;
use julio101290\boilerplateunidadesmedidas\Models\{
    Unidades_medidaModel
};
use julio101290\boilerplatelog\Models\LogModel;
use CodeIgniter\API\ResponseTrait;
use julio101290\boilerplatecompanies\Models\EmpresasModel;

class Unidades_medidaController extends BaseController {

    use ResponseTrait;

    protected $log;
    protected $unidades_medida;

    public function __construct() {
        $this->unidades_medida = new Unidades_medidaModel();
        $this->log = new LogModel();
        $this->empresa = new EmpresasModel();
        helper('menu');
        helper('utilerias');
    }

    public function index() {



        helper('auth');

        $idUser = user()->id;
        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }




        if ($this->request->isAJAX()) {
            $request = $this->request;

            $draw = (int) $request->getGet('draw');
            $start = (int) $request->getGet('start');
            $length = (int) $request->getGet('length');
            $search = $request->getGet('search')['value'] ?? '';
            $orderColumnIndex = (int) $request->getGet('order')[0]['column'] ?? 0;
            $orderDirection = $request->getGet('order')[0]['dir'] ?? 'asc';

            $columns = [
                'a.id',
                'a.descripcion',
                'b.nombre',
                'a.created_at',
                'a.updated_at',
            ];
            $orderColumn = $columns[$orderColumnIndex] ?? 'a.id';

            // Builder base
            $builder = $this->unidades_medida->mdlGetUnidades_medida($empresasID);

            // Total de registros sin filtrar
            $total = $builder->countAllResults(false);

            // Filtro de búsqueda
            if ($search !== '') {
                $builder->groupStart()
                        ->like('a.descripcion', $search)
                        ->orLike('b.nombre', $search)
                        ->groupEnd();
            }

            // Total con filtro
            $filtered = $builder->countAllResults(false);

            // Orden y límite
            $builder->orderBy($orderColumn, $orderDirection)
                    ->limit($length, $start);

            // Resultado final
            $data = $builder->get()->getResultArray();

            return $this->response->setJSON([
                        'draw' => $draw,
                        'recordsTotal' => $total,
                        'recordsFiltered' => $filtered,
                        'data' => $data
            ]);
        }
        $titulos["title"] = lang('unidades_medida.title');
        $titulos["subtitle"] = lang('unidades_medida.subtitle');
        return view('julio101290\boilerplateunidadesmedidas\Views\unidades_medida', $titulos);
    }

    /**
     * Read Unidades_medida
     */
    public function getUnidades_medida() {

        helper('auth');

        $idUser = user()->id;
        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }


        $idUnidades_medida = $this->request->getPost("idUnidades_medida");
        $datosUnidades_medida = $this->unidades_medida->whereIn('idEmpresa', $empresasID)
                        ->where("id", $idUnidades_medida)->first();
        echo json_encode($datosUnidades_medida);
    }

    /**
     * Save or update Unidades_medida
     */
    public function save() {
        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;
        $datos = $this->request->getPost();
        if ($datos["idUnidades_medida"] == 0) {
            try {
                if ($this->unidades_medida->save($datos) === false) {
                    $errores = $this->unidades_medida->errors();
                    foreach ($errores as $field => $error) {
                        echo $error . " ";
                    }
                    return;
                }
                $dateLog["description"] = lang("vehicles.logDescription") . json_encode($datos);
                $dateLog["user"] = $userName;
                $this->log->save($dateLog);
                echo "Guardado Correctamente";
            } catch (\PHPUnit\Framework\Exception $ex) {
                echo "Error al guardar " . $ex->getMessage();
            }
        } else {
            if ($this->unidades_medida->update($datos["idUnidades_medida"], $datos) == false) {
                $errores = $this->unidades_medida->errors();
                foreach ($errores as $field => $error) {
                    echo $error . " ";
                }
                return;
            } else {
                $dateLog["description"] = lang("unidades_medida.logUpdated") . json_encode($datos);
                $dateLog["user"] = $userName;
                $this->log->save($dateLog);
                echo "Actualizado Correctamente";
                return;
            }
        }
        return;
    }

    /**
     * Delete Unidades_medida
     * @param type $id
     * @return type
     */
    public function delete($id) {
        $infoUnidades_medida = $this->unidades_medida->find($id);
        helper('auth');
        $userName = user()->username;
        if (!$found = $this->unidades_medida->delete($id)) {
            return $this->failNotFound(lang('unidades_medida.msg.msg_get_fail'));
        }
        $this->unidades_medida->purgeDeleted();
        $logData["description"] = lang("unidades_medida.logDeleted") . json_encode($infoUnidades_medida);
        $logData["user"] = $userName;
        $this->log->save($logData);
        return $this->respondDeleted($found, lang('unidades_medida.msg_delete'));
    }

    /**
     * Lista de tipos de Unidades via AJax
     */
    public function getUnidadesAjax() {

        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response['token'] = csrf_hash();

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;
        $idEmpresa = $postData['idEmpresa'];
        $unidades = new Unidades_medidaModel();

        if (!isset($postData['searchTerm'])) {
            // Fetch record

            $listUnidades = $unidades->select('id,descripcion')
                    ->where("deleted_at", null)
                    ->where("idEmpresa", $idEmpresa)
                    ->orderBy('id')
                    ->orderBy('idEmpresa')
                    ->orderBy('descripcion')
                    ->findAll();
        } else {
            $searchTerm = $postData['searchTerm'];

            $listUnidades = $unidades->select('id,descripcion')
                    ->where("deleted_at", null)
                    ->where("idEmpresa", $postData["idEmpresa"])
                    ->orLike('id', $searchTerm)
                    ->orLike('descripcion', $searchTerm)
                    ->findAll();
        }

        $data = array();

        foreach ($listUnidades as $unidad) {
            $data[] = array(
                "id" => $unidad['id'],
                "text" => $unidad['id'] . ' ' . $unidad['descripcion'],
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }
}
