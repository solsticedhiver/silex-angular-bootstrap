<?php
namespace Todo;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TodoController
{
    public function getAllAction(Application $app)
    {
        return new JsonResponse($app['db']->fetchAll("SELECT * FROM todos"));
    }

    public function getOneAction($id, Application $app)
    {
        return new JsonResponse($app['db']
            ->fetchAssoc("SELECT * FROM todos WHERE id=:ID", ['ID' => $id]));
    }

    public function deleteOneAction($id, Application $app)
    {
        return $app['db']->delete('todos', ['ID' => $id]);
    }

    public function addOneAction(Application $app, Request $request)
    {
        $payload = json_decode($request->getContent());;

        $newTodo = [
            'id'      => (integer)$app['db']->fetchColumn("SELECT max(id) FROM todos") + 1,
            'name'  => $payload->name,
        ];
        $app['db']->insert('todos', $newTodo);

        return new JsonResponse($newTodo, 201);
    }

    public function editOneAction($id, Application $app, Request $request)
    {
        $payload = json_decode($request->getContent());;
        $todo = [
            'name'  => $payload->name,
        ];
        $app['db']->update('todos', $todo, ['id' => $id]);

        return new JsonResponse($todo);
    }
}
