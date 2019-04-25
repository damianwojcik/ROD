<?php
    namespace App\Controller;

    use App\Entity\Client;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    class ClientController extends Controller {
        /**
         * @Route("/", name="clients_list")
         * @Method({"GET"})
         */
        public function index() {
            $clients = $this->getDoctrine()->getRepository(Client::class)->findAll();

            return $this->render('clients/index.html.twig', array('clients' => $clients));
        }
        /**
         * @Route("/client/{id}", name="client_show")
         */
        public function show($id) {
            $client = $this->getDoctrine()->getRepository(Client::class)->find($id);

            return $this->render('client/show.html.twig', array('client' => $client));
        }

        /**
         * @Route("/client/save")
         */
        public function save() {
            $entityManager = $this->getDoctrine()->getManager();

            $client = new Client();
            $client->setFirstName('Adamo');
            $client->setLastName('Wojick');

            $entityManager->persist($client);
            $entityManager->flush();

            return new Response('Saved, id:'.$client->getId());
        }
    }