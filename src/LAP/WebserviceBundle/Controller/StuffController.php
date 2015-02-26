<?php

namespace LAP\WebserviceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LAP\WebserviceBundle\Entity\Stuff;
use LAP\WebserviceBundle\Form\StuffType;

/**
 * Stuff controller.
 *
 * @Route("/stuff")
 */
class StuffController extends Controller
{

    /**
     * Lists all Stuff entities.
     *
     * @Route("/", name="stuff")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LAPWebserviceBundle:Stuff')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Stuff entity.
     *
     * @Route("/", name="stuff_create")
     * @Method("POST")
     * @Template("LAPWebserviceBundle:Stuff:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Stuff();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stuff_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Stuff entity.
     *
     * @param Stuff $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Stuff $entity)
    {
        $form = $this->createForm(new StuffType(), $entity, array(
            'action' => $this->generateUrl('stuff_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Stuff entity.
     *
     * @Route("/new", name="stuff_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Stuff();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Stuff entity.
     *
     * @Route("/{id}", name="stuff_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LAPWebserviceBundle:Stuff')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stuff entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Stuff entity.
     *
     * @Route("/{id}/edit", name="stuff_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LAPWebserviceBundle:Stuff')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stuff entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Stuff entity.
    *
    * @param Stuff $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Stuff $entity)
    {
        $form = $this->createForm(new StuffType(), $entity, array(
            'action' => $this->generateUrl('stuff_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Stuff entity.
     *
     * @Route("/{id}", name="stuff_update")
     * @Method("PUT")
     * @Template("LAPWebserviceBundle:Stuff:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LAPWebserviceBundle:Stuff')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stuff entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('stuff_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Stuff entity.
     *
     * @Route("/{id}", name="stuff_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LAPWebserviceBundle:Stuff')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Stuff entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('stuff'));
    }

    /**
     * Creates a form to delete a Stuff entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stuff_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
