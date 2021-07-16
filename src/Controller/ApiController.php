<?php


namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Pizza;
use App\Form\Type\PizzaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/json/pizza",  name="Pizzajson", methods={"GET","HEAD"})
     */
    public function jsonpizza()
    {

        $entityManager = $this->getDoctrine()->getManager();
        $pizza = $entityManager->getRepository(Pizza::class)->findAll();
        return $this->json(['pizzas' => $pizza]);
    }

    /**
     * @Route("/api/json/pizza/{id}", name="OnePizzajson", requirements={"id"="\d+"},methods={"GET"})
     */
    public function indexonePizza($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $pizza = $entityManager->getRepository(Pizza::class)->find($id);
        return $this->json(['pizzas' => $pizza]);
    }

    /**
     * @Route("/api/json/pizza/new", name="jsonNewPizza", methods="POST")
     */
    public function jsonNewPizza(EntityManagerInterface $entityManager, Request $request)
    {
        $pizza = new Pizza();
        $form = $this->createForm(PizzaType::class, $pizza);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $pizza = $form->getData();
            $entityManager->persist($pizza);
            $entityManager->flush();

            return $this->redirectToRoute("Pizzajson");
        }
        return $this->render("api/formPizza.html.twig", ['form' => $form->createView()]); //TODO render form add pizza
    }

    /**
     * @Route("/api/json/pizza/{id}/edit", name="jsonEditPizza", methods="GET", requirements={"id"="\d+"})
     */
    public function jsonEditPizza($id)
    {
        die("edit pizza " . $id . " form");
        return $this->render(""); // TODO render form edit pizza
    }

    /**
     * @Route("/api/json/pizza",  name="jsonCreatePizza", methods="POST")
     */
    public function jsonCreatePizza()
    {
        // die("Je suis en method POST" . $request);
        $con = mysqli_connect('localhost', 'pizza', '', 'pizzadb');
        mysqli_query($con, "SET CHARACTER SET 'utf8'");
        /****************SELECT INFO PIZZA**********************/
        $sql_req = "select * from pizza;";
        $req = mysqli_query($con, $sql_req);

        $tablopizza = mysqli_fetch_all($req, MYSQLI_ASSOC);

        //var_dump($tablopizza);
        //die();

        mysqli_close($con);


        return $this->json(['pizzas' => $tablopizza]); // TODO database update
    }

    /**
     * @Route("/api/json/pizza/{id}", name="jsonUpdatePizza", methods="PUT", requirements={"id"="\d+"})
     */
    public function jsonUpdatePizza($id, EntityManagerInterface $entityManager)
    {
        $currentPizza = $entityManager->getRepository(Pizza::class)->find($id);
        $form = $this->createForm(PizzaType::class, $currentPizza);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($currentPizza);
            $entityManager->flush();
        }

        return $this->render("api/formPizza.html.twig", ['form' => $form->createView()]); // TODO render update pizza
    }

    /**
     * @Route("/api/json/pizza/{id}", name="jsonDeletePizza", methods="DELETE", requirements={"id"="\d+"})
     */
    public function jsonDeletePizza($id, EntityManagerInterface $entityManager)
    {
        $pizza = $entityManager->getRepository(Pizza::class)->find($id);

        $entityManager->remove($pizza);
        $entityManager->flush();

        return $this->redirectToRoute("Pizzajson"); // TODO update database
    }







    /**
     * @Route("/api/xml/pizza",  name="Pizzaxml", methods={"GET","HEAD"})
     */
    public function xmlpizza()
    {
        $con = mysqli_connect('localhost', 'pizza', '', 'pizzadb');
        mysqli_query($con, "SET CHARACTER SET 'utf8'");
        /****************SELECT INFO PIZZA**********************/
        $sql_req = "select * from pizza;";
        $req = mysqli_query($con, $sql_req);



        $xml_output = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
        $xml_output  .= '<ListePizza>';

        while ($ligne = mysqli_fetch_array($req)) // ou fecth_array ou fetch_object ou fetch_row
        {


            $xml_output .= "<item><nom_pizza>";

            $str = $ligne['DesignPizz'];
            $xml_output .= $str;

            $xml_output .= "</nom_pizza>";

            $xml_output .= "<tarif_pizza>" . $ligne['TarifPizz'] . "</tarif_pizza>";
            $xml_output .= "<numero_pizza>" . $ligne['NroPizz'] . "</numero_pizza></item>";
        }
        $xml_output .= '</ListePizza>';
        mysqli_close($con);

        // echo ($xml_output) ; die();
        $response = new Response($xml_output);
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }

    /**
     * @Route("/api/xml/pizza/{id}",  name="OnePizzaxml", methods={"GET","HEAD"})
     */
    public function xmlOnepizza($id)
    {
        $con = mysqli_connect('localhost', 'pizza', '', 'pizzadb');
        mysqli_query($con, "SET CHARACTER SET 'utf8'");
        /****************SELECT INFO PIZZA**********************/
        $sql_req = "select * from pizza WHERE NroPizz =" . $id;
        $req = mysqli_query($con, $sql_req);



        $xml_output = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
        $xml_output  .= '<ListePizza>';

        while ($ligne = mysqli_fetch_array($req)) // ou fecth_array ou fetch_object ou fetch_row
        {


            $xml_output .= "<item><nom_pizza>";

            $str = $ligne['DesignPizz'];
            $xml_output .= $str;

            $xml_output .= "</nom_pizza>";

            $xml_output .= "<tarif_pizza>" . $ligne['TarifPizz'] . "</tarif_pizza>";
            $xml_output .= "<numero_pizza>" . $ligne['NroPizz'] . "</numero_pizza></item>";
        }
        $xml_output .= '</ListePizza>';
        mysqli_close($con);

        // echo ($xml_output) ; die();
        $response = new Response($xml_output);
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }
}
