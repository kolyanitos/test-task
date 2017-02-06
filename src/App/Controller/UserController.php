<?php


namespace App\Controller;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends MainController
{
    public function loginAction(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if ($username and $password) {
            $user = $this->getRepository()
                ->getUserByUsernameAndPassword(
                    $username,
                    md5($password)
                );

            if ($user) {
                $this->session->set('user', $user->getId());
            }
        }

        return $this->redirectResponse($this->generateUrl('task_list'));
    }

    public function logoutAction(Request $request)
    {
        $this->session->set('user', null);

        return $this->redirectResponse($this->generateUrl('task_list'));
    }

    private function getRepository() {
        return $this->em->getRepository(User::class);
    }
}