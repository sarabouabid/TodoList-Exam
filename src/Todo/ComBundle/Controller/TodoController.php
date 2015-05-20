<?php

namespace Todo\ComBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Todo\ComBundle\Entity\Todo;
use Todo\ComBundle\Form\TodoType;

/**
 * Todo controller.
 *
 * @Route("/todo")
 */
class TodoController extends Controller
{

    /**
     * Lists all Todo entities.
     *
     * @Route("/", name="todo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TodoComBundle:Todo')->findByPT(new \DateTime());

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Todo entity.
     *
     * @Route("/", name="todo_create")
     * @Method("POST")
     * @Template("TodoComBundle:Todo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Todo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('todo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Todo entity.
     *
     * @param Todo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Todo $entity)
    {
        $form = $this->createForm(new TodoType(), $entity, array(
            'action' => $this->generateUrl('todo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Todo entity.
     *
     * @Route("/new", name="todo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Todo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Todo entity.
     *
     * @Route("/{id}", name="todo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TodoComBundle:Todo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Todo entity.');
        }

 
        return array(
            'entity'      => $entity, 
        );
    }

    
}
