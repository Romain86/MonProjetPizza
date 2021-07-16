<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PizzaController extends AbstractController
{
    /**
     * @Route("/pizza", name="pizzaAll")
     */
    public function indexallpizza()
    {
        $con = mysqli_connect('localhost', 'pizza', '', 'pizzaDB');
        mysqli_query($con, "SET CHARACTER SET 'utf8'");
        /****************SELECT INFO PIZZA**********************/
        $sql_req = "select * from pizza;";
        $req = mysqli_query($con, $sql_req);

        $tablopizza = mysqli_fetch_all($req, MYSQLI_ASSOC);

        //  var_dump($tablopizza);
        //  die();

        // dump($tablopizza);

        mysqli_close($con);


        return $this->render('listepizza.html.twig', [
            'controller_name' => 'PizzaController',
            'titre' => 'Liste des Pizzas',
            'tablopizza' => $tablopizza
        ]);
    }

    /**
     * @Route("/pizza/{id}", name="OnePizza", requirements={"id"="\d+"},methods={"GET"})
     */
    public function indexonePizza($id)
    {
        $con = mysqli_connect('localhost', 'pizza', '', 'pizzaDB');
        mysqli_query($con, "SET CHARACTER SET 'utf8'");
        /****************SELECT INFO PIZZA**********************/
        $sql_req = "select * from pizza where NroPizz =" . $id;
        $req = mysqli_query($con, $sql_req);

        $maPizza = mysqli_fetch_array($req, MYSQLI_ASSOC);

        //var_dump($tablopizza);
        //die();
        dump($maPizza);
        mysqli_close($con);


        return $this->render('Onepizza.html.twig', [
            'controller_name' => 'PizzaController',
            'titre' => 'Just One Pizza',
            'maPizza' => $maPizza
        ]);
    }

    /**
     * @Route("/pizza/{id}/update", name="modifOnePizza", requirements={"id"="\d+"},methods={"GET"})
     */
    public function modifOnePizza($id)
    {
        $con = mysqli_connect('localhost', 'pizza', '', 'pizzaDB');
        mysqli_query($con, "SET CHARACTER SET 'utf8'");
        /****************SELECT INFO PIZZA**********************/
        $sql_req = "select * from pizza where NroPizz =" . $id;
        $req = mysqli_query($con, $sql_req);

        $maPizza = mysqli_fetch_array($req, MYSQLI_ASSOC);

        //var_dump($tablopizza);
        //die();

        mysqli_close($con);


        return $this->render('modifOnepizza.html.twig', [
            'controller_name' => 'PizzaController',
            'titre' => 'Just One Pizza',
            'maPizza' => $maPizza
        ]);
    }
    /**
     * @Route("/pizza/{id}/updateOnePizza", name="updateOnePizza", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function UpdateOnePizza($id)
    {
        $request = Request::createFromGlobals();
        $request->server->get('HTTP_HOST');

        $request = $request->request->all();

        $con = mysqli_connect('localhost', 'pizza', '', 'pizzaDB');
        mysqli_query($con, "SET CHARACTER SET 'utf8'");

        /****************UPDATE INFO PIZZA**********************/
        $sql_req = "UPDATE pizza SET DesignPizz='" . $request['designation'] . "' , TarifPizz='" . $request['tarif'] . "' WHERE NroPizz='" . $id . "'";

        $req = mysqli_query($con, $sql_req);
        dump($req);
        mysqli_close($con);

        die();

        if ($req) {
            $this->addFlash(
                'success',
                'Pizza mise à jour'
            );
        } else {
            $this->addFlash(
                'warning',
                'Impossible de mettre à jour la pizza'
            );
        }
        return $this->redirectToRoute('pizzaAll');
    }

    /**
     * @Route("/pizza/{id}/deleteOnePizza", name="deleteOnePizza", requirements={"id"="\d+"}, methods="DELETE")
     */
    public function DeleteOnePizza($id)
    {

        $con = mysqli_connect('localhost', 'pizza', '', 'pizzaDB');
        mysqli_query($con, "SET CHARACTER SET 'utf8'");

        /****************UPDATE INFO PIZZA**********************/
        $sql_req = "DELETE FROM pizza WHERE NroPizz='" . $id . "'";

        $req = mysqli_query($con, $sql_req);
        dump($req);

        mysqli_close($con);

        if ($req) {
            $this->addFlash(
                'success',
                'Pizza supprimée'
            );
        } else {
            $this->addFlash(
                'warning',
                'Impossible de supprimée la pizza'
            );
        }

        return $this->redirectToRoute('pizzaAll');
    }

    /**
     * @Route("/pizza/create", name="createOnePizza")
     */
    public function CreateOnePizza()
    {

        return $this->render('createOnePizza.html.twig');
    }

    /**
     * @Route("/pizza/insert", name="insertOnePizza", methods="POST")
     */
    public function InsertOnePizza()
    {

        $request = Request::createFromGlobals();
        $request->server->get('HTTP_HOST');

        $request = $request->request->all();

        dump($request);

        $con = mysqli_connect('localhost', 'pizza', '', 'pizzaDB');
        mysqli_query($con, "SET CHARACTER SET 'utf8'");

        /****************UPDATE INFO PIZZA**********************/
        $sql_req = "INSERT INTO pizza(DesignPizz, TarifPizz) VALUES ('" . $request['designation'] . "', '" . $request['tarif'] . "')";

        $req = mysqli_query($con, $sql_req);
        dump($req);

        mysqli_close($con);

        if ($req) {
            $this->addFlash(
                'success',
                'Pizza ajoutée'
            );
        } else {
            $this->addFlash(
                'warning',
                'Impossible d\'ajoutée la pizza'
            );
        }



        return $this->redirectToRoute('pizzaAll');
    }
}
