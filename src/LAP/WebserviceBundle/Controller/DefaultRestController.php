<?php

namespace LAP\WebserviceBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc as ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as View;
use LAP\WebserviceBundle\Entity\Perso;
use LAP\WebserviceBundle\Entity\Guild;
use LAP\WebserviceBundle\Entity\Boot;
use LAP\WebserviceBundle\Entity\Helmet;
use LAP\WebserviceBundle\Form\PersoType;
use LAP\WebserviceBundle\Form\HelmetType;
use LAP\WebserviceBundle\Form\BootType;
use LAP\WebserviceBundle\Form\GuildType;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use LAP\WebserviceBundle\Entity\Register;
use LAP\WebserviceBundle\Form\RegisterType;

class DefaultRestController extends FOSRestController {
    /**
     * ******************************* PERSO *****************************************
     */
    /**
     * @Rest\Put("perso")
     * @ApiDoc(
     * section = "Perso Entity",
     * description="Insert perso into database.",
     * requirements = {
     * {
     * "name" = "name",
     * "dataType" = "string",
     * "description" = "Name of perso"
     * },
     * {
     * "name" = "class",
     * "dataType" = "string",
     * "description" = "Class of perso"
     * },
     * {
     * "name" = "level",
     * "dataType" = "integer",
     * "description" = "Level of perso"
     * },
     * {
     * "name" = "race",
     * "dataType" = "string",
     * "description" = "Race of perso"
     * },
     * {
     * "name" = "sexe",
     * "dataType" = "string",
     * "description" = "Sex of perso"
     * }
     * },
     * statusCodes = {
     * 201 = "Perso successfully created",
     * 400 = "Required parameters not satisfied"
     * }
     * )
     *
     * @return The perso insered into database
     */
    public function putPersoAction() {
        $em = $this->getDoctrine ()->getManager ();
        
        $entity = new Perso ();
        
        $form = $this->createForm ( new PersoType (), $entity, array (
                        'csrf_protection' => false 
        ) );
        $request = $this->getRequest ()->request->all ();
        $form->submit ( $request );
        if ($form->isValid ()) {
            $em->persist ( $entity );
            $em->flush ();
            
            $view = $this->view ( array (
                            "perso" => $entity 
            ), 201 );
            $serContext = SerializationContext::create ();
            $serContext->setGroups ( array (
                            'detail',
                            'detail_perso' 
            ) );
            $view->setSerializationContext ( $serContext );
        } else {
            $view = $this->view ( array (
                            "errors" => $form->getErrors () 
            ), 400 );
        }
        
        return $this->handleView ( $view );
    }
    /**
     * @Rest\Post("perso/{id}")
     * @ApiDoc(
     * section = "Perso Entity",
     * description="Update perso into database.",
     * requirements = {
     * {
     * "name" = "name",
     * "dataType" = "string",
     * "description" = "Name of perso"
     * },
     * {
     * "name" = "class",
     * "dataType" = "string",
     * "description" = "Class of perso"
     * },
     * {
     * "name" = "level",
     * "dataType" = "integer",
     * "description" = "Level of perso"
     * },
     * {
     * "name" = "race",
     * "dataType" = "string",
     * "description" = "Race of perso"
     * },
     * {
     * "name" = "sexe",
     * "dataType" = "string",
     * "description" = "sexe of perso"
     * }
     * },
     * statusCodes = {
     * 200 = "Perso successfully updated",
     * 400 = "Required parameters not satisfied",
     * 404 = "Entity cannot be found"
     * }
     * )
     *
     * @return The perso updated in database.
     */
    public function postPersoAction($id) {
        $em = $this->getDoctrine ()->getManager ();
        $entity = $em->getRepository ( 'LAPWebserviceBundle:Perso' )->findOneById ( $id );
        if ($entity == null) {
            $view = $this->view ( array (
                            "message" => "Perso not found " . $entity 
            ), 404 );
        } else {
            $form = $this->createForm ( new PersoType (), $entity, array (
                            "csrf_protection" => false 
            ) );
            $request = $this->getRequest ()->request->all ();
            $form->submit ( $request );
            if ($form->isValid ()) {
                $em->persist ( $entity );
                $em->flush ();
                $view = $this->view ( array (
                                "perso" => $entity 
                ), 200 );
                $serContext = SerializationContext::create ();
                $serContext->setGroups ( array (
                                'detail',
                                'detail_perso' 
                ) );
                $view->setSerializationContext ( $serContext );
            } else {
                $view = $this->view ( array (
                                "msg" => "Parameters not satisfied",
                                "errors" => $form->getErrors () 
                ), 400 );
            }
        }
        return $this->handleView ( $view );
    }
    /**
     *
     * @Rest\Get("perso/{id}")
     * @ApiDoc(
     * section = "Perso Entity",
     * description="Get a perso from database by id",
     * statusCodes = {
     * 200 = "Request Ok",
     * 204 = "No data"
     * }
     * )
     *
     * @param integer $id
     *            Id of perso insatance.
     * @return perso selected by id
     */
    public function getPersoByIdAction($id) {
        $em = $this->getDoctrine ()->getManager ();
        $data = $em->getRepository ( 'LAPWebserviceBundle:Perso' )->findOneById ( $id );
        if ($data) {
            $view = $this->view ( array (
                            "perso" => $data 
            ), 200 );
        } else {
            $view = $this->view ( array (
                            "message" => "No data" 
            ), 204 );
        }
        $serContext = SerializationContext::create ();
        $serContext->setGroups ( array (
                        'detail',
                        'detail_perso' 
        ) );
        $view->setSerializationContext ( $serContext );
        return $this->handleView ( $view );
    }
    /**
     * @Rest\Get("perso")
     *
     * @ApiDoc(
     * section = "Perso Entity",
     * description = "Get all perso from database",
     * statusCodes = {
     * 200 = "Request Ok"
     * }
     * )
     */
    public function getAllPersoAction() {
        $em = $this->getDoctrine ()->getManager ();
        $data = $em->getRepository ( 'LAPWebserviceBundle:Perso' )->findAll ();
        $view = $this->view ( array (
                        "persos" => $data 
        ), 200 );
        $serContext = SerializationContext::create ();
        $serContext->setGroups ( array (
                        'list',
                        'list_perso' 
        ) );
        $view->setSerializationContext ( $serContext );
        return $this->handleView ( $view );
    }
    /**
     * ******************************* GUILD *****************************************
     */
    /**
     * @Rest\Put("guild")
     * @ApiDoc(
     * section = "Guild Entity",
     * description="Insert guild into database.",
     * requirements = {
     * {
     * "name" = "name",
     * "dataType" = "string",
     * "description" = "Name of guild"
     * },
     * {
     * "name" = "banner",
     * "dataType" = "string",
     * "description" = "Banner of guild"
     * }
     * },
     * statusCodes = {
     * 201 = "Guild successfully created",
     * 400 = "Required parameters not satisfied"
     * }
     * )
     *
     * @return guild insered into database.
     */
    public function putGuildAction() {
        $em = $this->getDoctrine ()->getManager ();
        
        $entity = new Guild ();
        
        $form = $this->createForm ( new GuildType (), $entity, array (
                        'csrf_protection' => false 
        ) );
        $request = $this->getRequest ()->request->all ();
        $form->submit ( $request );
        if ($form->isValid ()) {
            $em->persist ( $entity );
            $em->flush ();
            
            $view = $this->view ( array (
                            "guild" => $entity 
            ), 201 );
            $serContext = SerializationContext::create ();
            $serContext->setGroups ( array (
                            'detail',
                            'detail_guild' 
            ) );
            $view->setSerializationContext ( $serContext );
        } else {
            $view = $this->view ( array (
                            "msg" => "Parameters not satisfied",
                            "errors" => $form->getErrors () 
            ), 400 );
        }
        
        return $this->handleView ( $view );
    }
    /**
     * @Rest\Post("guild/{id}")
     * @ApiDoc(
     * section = "Guild Entity",
     * description="Update guild into database.",
     * requirements = {
     * {
     * "name" = "name",
     * "dataType" = "string",
     * "description" = "Name of the guild"
     * },
     * {
     * "name" = "banner",
     * "dataType" = "string",
     * "description" = "Banner of guild"
     * }
     * },
     * statusCodes = {
     * 200 = "Perso successfully updated",
     * 400 = "Required parameters not satisfied",
     * 404 = "Entity cannot be found"
     * }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postGuildAction($id) {
        $em = $this->getDoctrine ()->getManager ();
        $entity = $em->getRepository ( 'LAPWebserviceBundle:Guild' )->findOneById ( $id );
        if ($entity == null) {
            $view = $this->view ( array (
                            "message" => "Guild not found " . $entity 
            ), 404 );
        } else {
            $form = $this->createForm ( new GuildType (), $entity, array (
                            "csrf_protection" => false 
            ) );
            $request = $this->getRequest ()->request->all ();
            $form->submit ( $request );
            if ($form->isValid ()) {
                $em->persist ( $entity );
                $em->flush ();
                $view = $this->view ( array (
                                "guil" => $entity 
                ), 200 );
                $serContext = SerializationContext::create ();
                $serContext->setGroups ( array (
                                'detail',
                                'detail_guild' 
                ) );
                $view->setSerializationContext ( $serContext );
            } else {
                $view = $this->view ( array (
                                "msg" => "Parameters not satisfied",
                                "errors" => $form->getErrors () 
                ), 400 );
            }
        }
        return $this->handleView ( $view );
    }
    /**
     * @Rest\Get("guild/{id}")
     * @ApiDoc(
     * section = "Guild Entity",
     * description="Get a guild from database by id."
     * )
     *
     * @param integer $id
     *            Id of guild insatance.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getGuildByIdAction($id) {
        $em = $this->getDoctrine ()->getManager ();
        $data = $em->getRepository ( 'LAPWebserviceBundle:Guild' )->findOneById ( $id );
        if ($data) {
            $view = $this->view ( array (
                            "guild" => $data 
            ), 200 );
        } else {
            $view = $this->view ( array (
                            "message" => "No data" 
            ), 204 );
        }
        $serContext = SerializationContext::create ();
        $serContext->setGroups ( array (
                        'detail',
                        'detail_guild' 
        ) );
        $view->setSerializationContext ( $serContext );
        return $this->handleView ( $view );
    }
    /**
     * @Rest\Get("guild")
     * @ApiDoc(
     * section = "Guild Entity",
     * description="Get all guild from database."
     * )
     */
    public function getAllGuildAction() {
        $em = $this->getDoctrine ()->getManager ();
        $data = $em->getRepository ( 'LAPWebserviceBundle:Guild' )->findAll ();
        $view = $this->view ( array (
                        "guilds" => $data 
        ), 200 );
        $serContext = SerializationContext::create ();
        $serContext->setGroups ( array (
                        'list',
                        'list_guild' 
        ) );
        $view->setSerializationContext ( $serContext );
        return $this->handleView ( $view );
    }
    /**
     * @Rest\Delete("guild/{id}")
     *
     * @ApiDoc(
     * section="Guild Entity",
     * description="Delete guild and registers",
     * statusCodes = {
     * 200 = "Guild successfully erased",
     * 400 = "Required parameters not satisfied",
     * 404 = "Entity cannot be found"
     * }
     * )
     *
     * @param $id int
     *            Id to the guild to void
     * @return
     *
     */
    public function deleteGuildAction($id) {
        $em = $this->getDoctrine ()->getManager ();
        $entity = $this->getDoctrine ()->getRepository ( "LAPWebserviceBundle:Guild" )->findOneById ( $id );
        if ($entity == null) {
            $view = $this->view ( array (
                            "msg" => "Guild not found" 
            ), 404 );
        } else {
            $em->remove ( $entity );
            $em->flush ();
            $view = $this->view ( array (
                            "msg" => "Successfully deleted" 
            ), 200 );
        }
        return $this->handleView ( $view );
    }
    
    /**
     * ******************************* REGISTER *****************************************
     */
    /**
     * @Rest\Put("guild/register")
     *
     * @ApiDoc(
     * section="Register Entity",
     * description="Register perso in guild",
     * requirements = {
     * {
     * "name" = "perso_id",
     * "dataType" = "integer",
     * "description" = "Id of perso"
     * },
     * {
     * "name" = "guild_id",
     * "dataType" = "integer",
     * "description" = "Id of guild"
     * },
     * {
     * "name" = "rang",
     * "dataType" = "integer",
     * "description" = "Rang of perso in guild"
     * },
     * {
     * "name" = "level",
     * "dataType" = "integer",
     * "description" = "Level of perso in guild"
     * },
     * },
     * statusCodes = {
     * 201 = "Successfully registered",
     * 400 = "Required parameters not satisfied",
     * 404 = "Entity cannot be found"
     * }
     * )
     *
     * @return
     *
     */
    public function putGuildRegisterAction() {
        $perso = $this->getDoctrine ()->getRepository ( "LAPWebserviceBundle:Perso" )->findOneById ( $this->getRequest ()->request->get ( 'perso_id' ) );
        $guild = $this->getDoctrine ()->getRepository ( "LAPWebserviceBundle:Guild" )->findOneById ( $this->getRequest ()->request->get ( 'guild_id' ) );
        if (! $perso) {
            $view = $this->view ( array (
                            "message" => "Perso not found" 
            ), 404 );
        } elseif (! $guild) {
            $view = $this->view ( array (
                            "message" => "Guild not found" 
            ), 404 );
        } else {
            $em = $this->getDoctrine ()->getManager ();
            $entity = new Register ();
            $form = $this->createForm ( new RegisterType (), $entity, array (
                            "csrf_protection" => false,
                            'validation_groups' => false 
            ) );
            $request = $this->getRequest ()->request->all ();
            $form->submit ( $request );
            $entity->setPerso ( $perso );
            $entity->setGuild ( $guild );
            if ($form->isValid ()) {
                $em->persist ( $entity );
                $em->flush ();
                $view = $this->view ( array (
                                "register" => $entity 
                ), 201 );
            } else {
                $view = $this->view ( array (
                                "message" => "Parameters not satisfied",
                                "errors" => $form->getErrors () 
                ), 400 );
            }
        }
        $serContext = SerializationContext::create ();
        $serContext->setGroups ( array (
                        'detail',
                        'detail_register' 
        ) );
        $view->setSerializationContext ( $serContext );
        return $this->handleView ( $view );
    }
    
    /**
     * ******************************* STUFF *****************************************
     */
    /**
     * @Rest\Put("stuff")
     *
     * @ApiDoc(
     * section="Stuff Entity",
     * description="Insert a stuff",
     * requirements = {
     * {
     * "name" = "perso_id",
     * "dataType" = "integer",
     * "description" = "Id of perso"
     * },
     * {
     * "name" = "type",
     * "dataType" = "string",
     * "description" = "Type of stuff",
     * "requirement" = "boot|helmet"
     * },
     * {
     * "name" = "name",
     * "dataType" = "string",
     * "description" = "Name of stuff"
     * },
     * {
     * "name" = "rarity",
     * "dataType" = "integer",
     * "description" = "Rarity of stuff"
     * },
     * {
     * "name" = "level",
     * "dataType" = "integer",
     * "description" = "Level of stuff"
     * },
     * {
     * "name" = "weight",
     * "dataType" = "integer",
     * "description" = "Weight of stuff"
     * }
     * },
     * statusCodes = {
     * 201 = "Stuff successfully created",
     * 400 = "Required parameters not satisfied",
     * 404 = "Entity cannot be found"
     * }
     * )
     *
     * @return Stuff The stuff object
     */
    public function putStuffAction() {
        $type = $this->getRequest ()->request->get ( 'type' );
        
        switch ($type) {
            case "boot" :
                $em = $this->getDoctrine ()->getManager ();
                $entity = new Boot ();
                $perso = $this->getDoctrine ()->getRepository ( "LAPWebserviceBundle:Perso" )->findOneById ( $this->getRequest ()->request->get ( 'perso_id' ) );
                if ($perso) {
                    $form = $this->createForm ( new BootType (), $entity, array (
                                    "csrf_protection" => false,
                                    'validation_groups' => false 
                    ) );
                    $request = $this->getRequest ()->request->all ();
                    $form->submit ( $request );
                    $entity->setPerso ( $perso );
                    if ($form->isValid ()) {
                        $em->persist ( $entity );
                        $em->flush ();
                        $view = $this->view ( array (
                                        "boot" => $entity 
                        ), 201 );
                    } else {
                        $view = $this->view ( array (
                                        "message" => "Parameters not satisfied",
                                        "errors" => $form->getErrors () 
                        ), 400 );
                    }
                } else {
                    $view = $this->view ( array (
                                    "message" => "Perso not found" 
                    ), 404 );
                }
                break;
            case "helmet" :
                $em = $this->getDoctrine ()->getManager ();
                $entity = new Helmet ();
                $perso = $this->getDoctrine ()->getRepository ( "LAPWebserviceBundle:Perso" )->findOneById ( $this->getRequest ()->request->get ( 'perso_id' ) );
                if ($perso) {
                    $form = $this->createForm ( new HelmetType (), $entity, array (
                                    "csrf_protection" => false,
                                    'validation_groups' => false 
                    ) );
                    $request = $this->getRequest ()->request->all ();
                    $form->submit ( $request );
                    $entity->setPerso ( $perso );
                    if ($form->isValid ()) {
                        $em->persist ( $entity );
                        $em->flush ();
                        $view = $this->view ( array (
                                        "helmet" => $entity 
                        ), 201 );
                    } else {
                        $view = $this->view ( array (
                                        "message" => "Parameters not satisfied",
                                        "errors" => $form->getErrors () 
                        ), 400 );
                    }
                } else {
                    $view = $this->view ( array (
                                    "message" => "Perso not found" 
                    ), 404 );
                }
                break;
            default :
                $view = $this->view ( array (
                                "message" => "Error type stuff",
                                400 
                ) );
                break;
        }
        $serContext = SerializationContext::create ();
        $serContext->setGroups ( array (
                        'detail_stuff',
                        'detail' 
        ) );
        $view->setSerializationContext ( $serContext );
        return $this->handleView ( $view );
    }
    /**
     * @Rest\Post("stuff/{id}")
     *
     * @ApiDoc(
     * section="Stuff Entity",
     * description="Updates a stuff",
     * requirements = {
     * {
     * "name" = "perso_id",
     * "dataType" = "integer",
     * "description" = "Id of perso"
     * },
     * {
     * "name" = "type",
     * "dataType" = "string",
     * "description" = "Type of stuff",
     * "requirement" = "boot|helmet"
     * },
     * {
     * "name" = "name",
     * "dataType" = "string",
     * "description" = "Name of stuff"
     * },
     * {
     * "name" = "rarity",
     * "dataType" = "integer",
     * "description" = "Rarity of stuff"
     * },
     * {
     * "name" = "level",
     * "dataType" = "integer",
     * "description" = "Level of stuff"
     * },
     * {
     * "name" = "weight",
     * "dataType" = "integer",
     * "description" = "Weight of stuff"
     * }
     * },
     * statusCodes = {
     * 200 = "Stuff successfully updated",
     * 400 = "Required parameters not satisfied",
     * 404 = "Entity cannot be found"
     * }
     * )
     *
     * @return
     *
     */
    public function postStuffAction($id) {
        $type = $this->getRequest ()->request->get ( 'type' );
        
        switch ($type) {
            case "boot" :
                $em = $this->getDoctrine ()->getManager ();
                $entity = $this->getDoctrine ()->getRepository ( "LAPWebserviceBundle:Boot" )->findOneById ( $id );
                $perso = $this->getDoctrine ()->getRepository ( "LAPWebserviceBundle:Perso" )->findOneById ( $this->getRequest ()->request->get ( 'perso_id' ) );
                if ($perso) {
                    if ($entity) {
                        $form = $this->createForm ( new BootType (), $entity, array (
                                        "csrf_protection" => false,
                                        'validation_groups' => false 
                        ) );
                        $request = $this->getRequest ()->request->all ();
                        $form->submit ( $request );
                        $entity->setPerso ( $perso );
                        if ($form->isValid ()) {
                            $em->persist ( $entity );
                            $em->flush ();
                            $view = $this->view ( array (
                                            "boot" => $entity 
                            ), 201 );
                        } else {
                            $view = $this->view ( array (
                                            "message" => "Parameters not satisfied",
                                            "errors" => $form->getErrors () 
                            ), 400 );
                        }
                    } else {
                        $view = $this->view ( array (
                                        "message" => "Boot not found" 
                        ), 404 );
                    }
                } else {
                    $view = $this->view ( array (
                                    "message" => "Perso not found" 
                    ), 404 );
                }
                break;
            case "helmet" :
                $em = $this->getDoctrine ()->getManager ();
                $entity = $this->getDoctrine ()->getRepository ( "LAPWebserviceBundle:Helmet" )->findOneById ( $id );
                $perso = $this->getDoctrine ()->getRepository ( "LAPWebserviceBundle:Perso" )->findOneById ( $this->getRequest ()->request->get ( 'perso_id' ) );
                if ($perso) {
                    if ($entity) {
                        $form = $this->createForm ( new HelmetType (), $entity, array (
                                        "csrf_protection" => false,
                                        'validation_groups' => false 
                        ) );
                        $request = $this->getRequest ()->request->all ();
                        $form->submit ( $request );
                        $entity->setPerso ( $perso );
                        if ($form->isValid ()) {
                            $em->persist ( $entity );
                            $em->flush ();
                            $view = $this->view ( array (
                                            "helmet" => $entity 
                            ), 201 );
                        } else {
                            $view = $this->view ( array (
                                            "message" => "Parameters not satisfied",
                                            "errors" => $form->getErrors () 
                            ), 400 );
                        }
                    } else {
                        $view = $this->view ( array (
                                        "message" => "helmet not found" 
                        ), 404 );
                    }
                } else {
                    $view = $this->view ( array (
                                    "message" => "Perso not found" 
                    ), 404 );
                }
                break;
            default :
                $view = $this->view ( array (
                                "message" => "Error type stuff",
                                400 
                ) );
                break;
        }
        $serContext = SerializationContext::create ();
        $serContext->setGroups ( array (
                        'detail_stuff',
                        'detail' 
        ) );
        $view->setSerializationContext ( $serContext );
        return $this->handleView ( $view );
    }
}