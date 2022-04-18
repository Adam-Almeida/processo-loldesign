<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\Plans;

class PlanController extends Controller
{

    public function planArea(): void
    {
        echo $this->view->render("plan", [
            "title" => "LISTA DE PLANOS | PROCESSO LOL DESIGN 2022",
            "plansAll" => (new Plans())->find()->fetch(true)
        ]);
    }


    public function planosCreate()
    {

        $post = (object)filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

        if (!is_numeric($post->minutes)) {
            $this->message("Confira os dados e tente novamente.", "Que Pena!", "warning");
            redirect("./admin/planos");
            return;
        }

        if (!empty($post)) {

            $plan = new Plans();
            $plan->bootstrap($post->plan, $post->minutes);

            if ($plan->save()) {
                $this->message("Plano criado com sucesso", "Bom Trabalho", "success");
                redirect("./admin/planos");
                return;
            }
        }
        $this->message("Erro ao cadastrar o plano", "Que Pena!", "error");
        redirect("./admin/planos");
    }

    public function planEdit(array $data)
    {
        if (!empty($data['id']) && !is_numeric($data['id'])) {
            redirect("/admin/planos");
            return;
        }

        $plans = new Plans();

        $plansAll = $plans->find()->fetch(true);
        $plansEdit = $plans->findById($data['id']);

        echo $this->view->render("plan", [
            "title" => "LISTA DE PLANOS | PROCESSO LOL DESIGN 2022",
            "plansAll" => $plansAll,
            "edit" => $plansEdit
        ]);
    }

    public function planUpdate(array $data)
    {
        if (!empty($data['id']) && !is_numeric($data['id'])) {
            redirect("/admin/planos");
            return;
        }

        $post = (object)filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

        if (!is_numeric($post->minutes)) {
            $this->message("Confira os dados e tente novamente.", "Que Pena!", "warning");
            redirect("./admin/planos");
            return;
        }

        if (!empty($post)) {

            $plan = (new Plans())->findById($data['id']);
            $plan->plan = $post->plan;
            $plan->minutes = $post->minutes;

            if ($plan->save()) {
                $this->message("Plano editado com sucesso", "Bom Trabalho", "success");
                redirect("./admin/planos");
                return;
            }
        }
        $this->message("Erro ao editar o plano", "Que Pena!", "error");
        redirect("./admin/planos");

    }

    /**
     * Metodo para Excluir uma Especialidades
     * @param array $data
     */
    public function planDelete(array $data)
    {
        if (!empty($data['id']) && !is_numeric($data['id'])) {
            redirect("/admin/dash");
            return;
        }

        $idPlan = filter_var($data['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        $plan = (new Plans())->findById($idPlan);

        if (!$plan) {
            $this->message("O Plano não foi encontrado", "Oppsss!", "info");
            redirect("./admin/planos");
            return;
        }

        if ($plan->destroy()) {
            $this->message("O Plano foi excluido com sucesso", "Bom Trabalho!", "error");
            redirect("/admin/planos");
            return;
        }
        $this->message("Erro ao fazer exclusão!", "Oppsss", "warning");
        redirect("/admin/planos");
    }

}