<?php

namespace LAP\WebserviceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LAP\WebserviceBundle\Entity\Guild;
use LAP\WebserviceBundle\Form\GuildType;

/**
 * Guild controller.
 *
 * @Route("/guild")
 */
class GuildController extends Controller
{

    /**
     * Lists all Guild entities.
     *
     * @Route("/", name="guild")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LAPWebserviceBundle:Guild')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Guild entity.
     *
     * @Route("/", name="guild_create")
     * @Method("POST")
     * @Template("LAPWebserviceBundle:Guild:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Guild();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('guild_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Guild entity.
     *
     * @param Guild $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Guild $entity)
    {
        $form = $this->createForm(new GuildType(), $entity, array(
            'action' => $this->generateUrl('guild_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Guild entity.
     *
     * @Route("/new", name="guild_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Guild();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Guild entity.
     *
     * @Route("/{id}", name="guild_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LAPWebserviceBundle:Guild')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Guild entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Guild entity.
     *
     * @Route("/{id}/edit", name="guild_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LAPWebserviceBundle:Guild')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Guild entity.');
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
    * Creates a form to edit a Guild entity.
    *
    * @param Guild $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Guild $entity)
    {
        $form = $this->createForm(new GuildType(), $entity, array(
            'action' => $this->generateUrl('guild_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Guild entity.
     *
     * @Route("/{id}", name="guild_update")
     * @Method("PUT")
     * @Template("LAPWebserviceBundle:Guild:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LAPWebserviceBundle:Guild')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Guild entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('guild_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Guild entity.
     *
     * @Route("/{id}", name="guild_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LAPWebserviceBundle:Guild')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Guild entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('guild'));
    }

    /**
     * Creates a form to delete a Guild entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('guild_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
