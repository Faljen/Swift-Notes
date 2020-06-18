<?php
declare(strict_types=1);

namespace App;


use App\Exception\NotFoundException;

require_once('AbstractController.php');


class NoteController extends AbstractController
{

    public function newNote()
    {
        $page = 'newnote';

        if ($this->request->hasPost()) {

            $noteData = [
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content')
            ];
            $this->db->createNote($noteData);
            header('Location: /?before=created');

        }
        $this->view->render($page);

    }

    public function show()
    {
        $page = 'show';
        $id = (int)($this->request->getGet('id'));

        if (!$id) {
            header('Location: /?error=invalidid');
            exit;
        }

        try {
            $note = $this->db->getNote($id);
        } catch (NotFoundException $e) {
            header('Location: /?error=notfound');
            exit;
        }
        $this->view->render($page, ['note' => $note]);
    }

    public function list()
    {
        $page = 'list';
        $notes = $this->db->getNotes();

        $this->view->render($page, [
                'notes' => $notes,
                'before' => $this->request->getGet('before'),
                'error' => $this->request->getGet('error')
            ]
        );
    }


}