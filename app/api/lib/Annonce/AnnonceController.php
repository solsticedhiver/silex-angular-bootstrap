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
    	// sélectionne une collection (analogue à une table de base de données relationnelle)
    	$collection = $app['db']->Annonces;
    	$cursor = $collection->find();
    	foreach ($cursor as $key => $value) {
    		$json[] = $value;
    	}
        return new JsonResponse($json);
    }

    public function getOneAction($id, Application $app)
    {
    	// sélectionne une collection (analogue à une table de base de données relationnelle)
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

        $newAnnonce = array (
				'titre' => $payload->titre,
				'lieu' => $payload->lieu,
				'heure' => $payload->heure,
				'date_annonce' => date ( 'c' ),
				'date_validite_debut' => $payload->date_validite_debut,
				'date_validite_fin' => $payload->date_validite_fin 
		);
		// à compléter
		
        // recupère l'id de la catégorie en BDD
        $categorie = $app['db']->Categorie->findOne(array('nom' => $payload->categorie));
        
        if ($categorie !== NULL) {
        	$id = new \MongoId($categorie['_id']->{'$id'});
        	$newAnnonce['categorie'] = $id;
        } else {
        	return new JsonResponse("Error: can't find category", 400);
        }
        
        // récupère l'id du user dans la BDD
        $user = $app['db']->Utilisateur->findOne(array('nom' => $payload->pseudo));
        
        if ($user !== NULL) {
        	$id = new \MongoId($user['_id']->{'$id'});
        	$newAnnonce['user'] = $id;
        } else {
        	return new JsonResponse("Error: can't find user", 400);
        }
        $app['db']->Annonces->insert($newAnnonce);

        return new JsonResponse($newAnnonce, 201);
    }

    public function editOneAction($id, Application $app, Request $request) {
		$payload = json_decode ( $request->getContent () );
		
		$annonce = [ 
				'titre' => $payload->titre,
				'user' => new \MongoId($payload->user->{'$id'}),
				'lieu' => $payload->lieu,
				'heure' => $payload->heure,
				'categorie' => new \MongoId($payload->categorie->{'$id'}),
				'date_annonce' => $payload->date_annonce,
        		'date_validite_debut' => $payload->date_validite_debut,
        		'date_validite_fin' => $payload->date_validite_fin
        ];
        $collection = $app['db']->Annonces;
        $collection->update(array('_id' => new \MongoId($id)),$annonce);

        return new JsonResponse($annonce);
    }
    
    public function searchOne($cat, $loc, Application $app, Request $request) {
    	$collection = $app['db']->Annonces;
    	
    }
}
