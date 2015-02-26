<?php

namespace LAP\WebserviceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LAP\WebserviceBundle\Entity\Boot;
use LAP\WebserviceBundle\Form\BootType;

/**
 * Boot controller.
 *
 * @Route("/boot")
 */
class BootController extends Controller
{

    /**
     * Lists all Boot entities.
     *
     * @Route("/", name="boot")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LAPWebserviceBundle:Boot')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Boot entity.
     *
     * @Route("/", name="boot_create")
     * @Method("POST")
     * @Template("LAPWebserviceBundle:Boot:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Boot();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('boot_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Boot entity.
     *
     * @param Boot $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Boot $entity)
    {
        $form = $this->createForm(new BootType(), $entity, array(
            'action' => $this->generateUrl('boot_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Boot entity.
     *
     * @Route("/new", name="boot_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Boot();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Boot entity.
     *
     * @Route("/{id}", name="boot_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LAPWebserviceBundle:Boot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Boot entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Boot entity.
     *
     * @Route("/{id}/edit", name="boot_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LAPWebserviceBundle:Boot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Boot entity.');
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
    * Creates a form to edit a Boot entity.
    *
    * @param Boot $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Boot $entity)
    {
        $form = $this->createForm(new BootType(), $entity, array(
            'action' => $this->generateUrl('boot_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Boot entity.
     *
     * @Route("/{id}", name="boot_update")
     * @Method("PUT")
     * @Template("LAPWebserviceBundle:Boot:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LAPWebserviceBundle:Boot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Boot entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('boot_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Boot entity.
     *
     * @Route("/{id}", name="boot_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LAPWebserviceBundle:Boot')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Boot entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('boot'));
    }

    /**
     * Creates a form to delete a Boot entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('boot_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
