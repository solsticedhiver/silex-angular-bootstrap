<?php
namespace Annonce;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnnonceController
{
	
    public function getAllAction(Application $app)
    {	
    	// s�lectionne une collection (analogue � une table de base de donn�es relationnelle)
    	$collection = $app['db']->Annonces;
    	$cursor = $collection->find();
    	foreach ($cursor as $key => $value) {
    		$json[] = $value;
    	}
        return new JsonResponse($json);
    }

    public function getOneAction($id, Application $app)
    {
    	// s�lectionne une collection (analogue � une table de base de donn�es relationnelle)
    	$collection = $app['db']->Annonces;
    	$cursor = $collection->findOne(array('_id' => new \MongoId($id)));
    	 
    	return new JsonResponse($cursor);
    }

    public function deleteOneAction($id, Application $app)
    {
    	$collection = $app['db']->Annonces;
    	$bool = $collection->remove(array('_id' => new \MongoId($id)), array('justOne' => true));
    	return new Response('{message: ok}', 201);
    }

    public function addOneAction(Application $app, Request $request)
    {
        $payload = json_decode($request->getContent());

        $newAnnonce = array(
            'titre'  => $payload->titre,
        	'lieu'   => $payload->lieu,
        	'heure'  => $payload->heure,
        	'date_annonce' => date('c'),
        	'date_validite_debut' => $payload->date_validite_debut,
        	'date_validite_fin' => $payload->date_validite_fin
        	// � compl�ter
        );
        $categorie = $app['db']->Categorie->findOne(array('nom' => $payload->categorie));
        
        if ($categorie !== NULL) {
        	$id = new \MongoId($categorie['_id']->{'$id'});
        	$newAnnonce['categorie'] = $id;
        }
        $app['db']->Annonces->insert($newAnnonce);

        return new JsonResponse($newAnnonce, 201);
    }

    public function editOneAction($id, Application $app, Request $request)
    {
        $payload = json_decode($request->getContent());;
        $user = [
            'titre'  => $payload->titre,
        ];
        $collection = $app['db']->Annonces;
        $collection->update($user);

        return new JsonResponse($user);
    }
}
