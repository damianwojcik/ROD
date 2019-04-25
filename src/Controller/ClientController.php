<?php
    namespace App\Controller;

    use App\Entity\Client;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    class ClientController extends Controller {
        /**
         * @Route("/", name="index")
         * @Method({"GET", "POST"})
         */
        public function index(Request $request) {
            $client = new Client();

            $form = $this->createFormBuilder($client)
                ->add('firstName', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'required' => false
                ))
                ->add('lastName', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'required' => false
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Zapisz',
                    'attr' => array('class' => 'btn btn-primary mt-3')
                ))
                ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $client = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($client);
                $entityManager->flush();

                return $this->redirectToRoute('index');
            }

            return $this->render('index.html.twig', array(
                'form' => $form->createView()
            ));
        }

        /**
         * @Route("/admin", name="admin_index")
         * @Method({"GET"})
         */
        public function adminIndex() {
            $clients = $this->getDoctrine()->getRepository(Client::class)->findAll();

            return $this->render('admin/index.html.twig', array('clients' => $clients));
        }

        /**
         * @Route("/admin/client/{id}", name="admin_client_show")
         * @Method({"GET"})
         */
        public function adminClientShow($id) {
            $client = $this->getDoctrine()->getRepository(Client::class)->find($id);

            return $this->render('admin/show.html.twig', array('client' => $client));
        }

        /**
         * @Route("/admin/client/edit/{id}", name="admin_client_edit")
         * @Method({"GET", "POST"})
         */
        public function adminClientEdit(Request $request, $id) {
            $client = new Client();
            $client = $this->getDoctrine()->getRepository(Client::class)->find($id);

            $form = $this->createFormBuilder($client)
                ->add('firstName', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'required' => false
                ))
                ->add('lastName', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'required' => false
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Zapisz',
                    'attr' => array('class' => 'btn btn-primary mt-3')
                ))
                ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirectToRoute('index');
            }

            return $this->render('admin/edit.html.twig', array(
                'form' => $form->createView()
            ));
        }

        /**
         * @Route("/admin/delete/{id}", name="admin_client_delete")
         * @Method({"DELETE"})
         */
        public function adminClientDelete(Request $request, $id) {
            $client = $this->getDoctrine()->getRepository(Client::class)->find($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();

            $response = new Response();
            $response->send();

            // return $this->render('admin/show.html.twig', array('client' => $client));
        }
    }