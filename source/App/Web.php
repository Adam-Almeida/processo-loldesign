<?php

namespace Source\App;


use League\Plates\Engine;
use Source\Boot\Message;
use Source\Models\Auth;
use Source\Models\Call;
use Source\Models\Plans;


/**
 * CONTROLADOR WEB - DESENVOLVIDO POR ADAM ALMEIDA
 * PROCESSO LOL DESIGN 2022
 * @package Source\App
 * @author Adam Almeida <adam.designjuridico@gmail.com>
 */
class Web
{
    /**@var Engine */
    private $view;

    /**@var Message */
    private $message;

    /**Web constructor.*/
    public function __construct()
    {
        $this->view = new Engine(__DIR__ . "/../../theme/", "php");
        $this->message = new Message();
    }

    /**
     * @return void
     */
    public function home(): void
    {
        echo $this->view->render("home", [
            "planAll" => (new Plans())->find()->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     * @return void
     */
    public function plan(?array $data)
    {

        /*REFATORAR IMPLEMENTAR CSRF*/
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED, '');

        $origin = $this->clearField($data['origin']);
        $destiny = $this->clearField($data['destiny']);

        if (in_array('', $data)) {
            $this->message("Preencha todos os campos para poder calcular!", "Opss! Campos em branco", "warning");
            redirect('/');
            return;
        }

        if (!is_numeric($origin) || !is_numeric($destiny) || !is_numeric($data['minutes'])) {
            $this->message("Corrija os dados e envie novamente.", "Opss! Erro nos Dados", "warning");
            redirect('/');
            return;
        }

        //* Os planos devem vir do DataBase *//
        $plan = new Plans();
        $validPlan = $plan->find("minutes = :minutes", "minutes={$data['plan']}", "minutes");

        if (!$validPlan->fetch()) {
            $this->message("O Plano selecionado não existe", "Opss!", "warning");
            redirect('/');
            return;
        }

        $dataOrigin = $this->cep($origin);
        $dataDestiny = $this->cep($destiny);

        $valueCall = (new Call())->find(
            "origin=:origin AND destiny=:destiny",
            "origin={$dataOrigin['ddd']}&destiny={$dataDestiny['ddd']}", "value")->fetch();

        if (!$valueCall) {
            $this->message("A ligação para este DDD não existe", "Opss!", "warning");
            redirect('/');
            return;
        }

        $call = new \stdClass();
        $call->origin = ($dataOrigin['ddd'] ?? "Não encontrado");
        $call->destiny = ($dataDestiny['ddd'] ?? "Não encontrado");
        $call->cepOrigin = ($dataOrigin['cep'] ?? "Não encontrado");
        $call->cepDestiny = ($dataDestiny['cep'] ?? "Não encontrado");
        $call->cityOrigin = ($dataOrigin['uf'] ?? "Não encontrado");
        $call->cityDestiny = ($dataDestiny['uf'] ?? "Não encontrado");
        $call->minutes = $data['minutes'];
        $call->plan = $data['plan'];

        /*CÁCULOS DOS PLANOS*/
        $excedMinutes = (($call->minutes > $data['plan']) ? ($call->minutes - $data['plan']) : 0);
        $call->originalValue = ($call->minutes * $valueCall->value);
        $call->value = ($excedMinutes * $valueCall->value + (($excedMinutes * $valueCall->value) * 10) / 100);

        /*RENDERIZANDO RESULTADOS*/
        echo $this->view->render("result", [
            "planAll" => (new Plans())->find()->fetch(true),
            "call" => $call,
        ]);

    }

    /*METODO PARA LIMPAR OS CAMPOS, REFATORAR PARA UM HELPER*/
    /**
     * @param string|null $param
     * @return array|string|string[]|null
     */
    private function clearField(?string $param)
    {
        if (empty($param)) {
            return '';
        }
        return str_replace(['.', '-', ',', ' ', '/', '(', ')', '!'], '', $param);
    }

    /*METODO PARA CEP, REFATORAR PARA UM SERVICE DE CEP*/
    /**
     * @param string $cep
     * @return mixed
     */
    private function cep(string $cep)
    {
        $url = "https://viacep.com.br/ws/" . $cep . "/json/";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $viacep = curl_exec($curl);
        return json_decode($viacep, true);
    }

    /**
     * @param array|null $data
     */
    public function login(?array $data): void
    {
        if (!empty($data['csrf'])) {

            if (empty($data['email']) || empty($data['password'])) {
                $this->message("Os dados não podem estar em branco", "Opss! Login Incorreto", "warning");
                redirect("/login");
                echo $this->view->render("login", [
                    "title" => "LOGIN | PROCESSO LOL DESIGN"
                ]);

                die();
            }

            $auth = new Auth();
            $login = $auth->login($data['email'], $data['password']);

            if ($login) {
                redirect("/admin/dash");
            }

            $this->message("Os dados informados estão incorretos!", "Opss! Login Incorreto", "error");
            redirect("/login");
        }

        echo $this->view->render("login", [
            "title" => "LOGIN | PROCESSO LOL DESIGN"
        ]);
    }


    public function exit(): void
    {
        $this->message("Ótimo Descanso e até logo.", "Volte Sempre!", "success");
        Auth::logout();
        redirect("/login");
    }

    /**
     * @param string $message
     * @param string $title
     * @param string $type
     * @return void
     */
    protected function message(string $message, string $title, string $type)
    {
        $this->message->renderMessage($message, $title, $type)->flash();
    }

    /**
     * @param $data
     */
    public function error($data): void
    {
        redirect("/");
    }
}