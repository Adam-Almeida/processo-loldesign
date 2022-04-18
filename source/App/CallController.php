<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Call;

class CallController extends Controller
{
    /**
     * Metodo que renderiza a Dash de Ligações
     */
    public function callArea(): void
    {
        $callsAll = (new Call())->find()->fetch(true);

        echo $this->view->render("call", [
            "title" => "CADASTRO DE LIGAÇÕES | PROCESSO LOL DESIGN",
            "user" => Auth::user()->first_name . " " . Auth::user()->last_name,
            "callsAll" => $callsAll
        ]);
    }

    /**
     * Metodo de criacao de Especialidades
     */
    public function callCreate()
    {

        $post = (object)filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

        if (!is_numeric($post->origin) || !is_numeric($post->destiny)) {
            $this->message("Confira os dados e tente novamente.", "Que Pena!", "warning");
            redirect("./admin/planos");
        }

        if (!empty($post)) {

            $value = floatval(str_replace(',', '.', str_replace('.', '', $post->value)));

            $plan = new Call();
            $plan->bootstrap($post->origin, $post->destiny, $value);

            if ($plan->save()) {
                $this->message("Ligação criada com sucesso", "Bom Trabalho", "success");
                redirect("./admin/dash");
                return;
            }
        }
        $this->message("Erro ao cadastrar a ligação", "Que Pena!", "error");
        redirect("./admin/dash");
    }

    public function callEdit(array $data): void
    {

        if (!empty($data['id']) && !is_numeric($data['id'])) {
            redirect("/admin/dash");
            return;
        }

        $callsAll = (new Call())->find()->fetch(true);
        $callEdit = (new Call())->findById($data['id']);

        echo $this->view->render("call", [
            "title" => "CADASTRO DE LIGAÇÕES | PROCESSO LOL DESIGN",
            "user" => Auth::user()->first_name . " " . Auth::user()->last_name,
            "callsAll" => $callsAll,
            "edit" => $callEdit
        ]);
    }

    public function callUpdate(array $data): void
    {
        if (!empty($data['id']) && !is_numeric($data['id'])) {
            redirect("/admin/dash");
            return;
        }

        $post = (object)filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

        if (!is_numeric($post->origin) || !is_numeric($post->destiny)) {
            $this->message("Confira os dados e tente novamente.", "Que Pena!", "warning");
            redirect("./admin/dash");
        }

        if (!empty($post)) {

            $value = floatval(str_replace(',', '.', str_replace('.', '', $post->value)));

            $plan = (new Call())->findById($data['id']);
            $plan->origin = $post->origin;
            $plan->destiny = $post->destiny;
            $plan->value = $value;

            if ($plan->save()) {
                $this->message("Edição feita com sucesso", "Bom Trabalho", "success");
                redirect("./admin/dash");
                return;
            }
        }
        $this->message("Erro ao editar a ligação", "Que Pena!", "error");
        redirect("./admin/dash");

    }

    public function callDelete(array $data)
    {
        if (!empty($data['id']) && !is_numeric($data['id'])) {
            redirect("/admin/dash");
            return;
        }

        $idCall = filter_var($data['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        $call = (new Call())->findById($idCall);

        if (!$call) {
            $this->message("A ligação não foi encontrada", "Oppsss!", "info");
            redirect("./admin/dash");
            return;
        }

        if ($call->destroy()) {
            $this->message("A ligação foi excluida com sucesso", "Bom Trabalho!", "error");
            redirect("/admin/dash");
            return;
        }
        $this->message("Erro ao fazer exclusão!", "Oppsss", "warning");
        redirect("/admin/dash");
    }
}