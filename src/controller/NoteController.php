<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;


class NoteController extends AbstractController
{

    public function newNote(): void
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

    public function show(): void
    {
        $page = 'show';
        $note = $this->getNoteParams();
        $this->view->render($page, ['note' => $note]);
    }

    public function list(): void
    {
        $page = 'list';

        $sortBy = $this->request->getGet('sortBy', 'created');
        $order = $this->request->getGet('sortOrder', 'desc');

        $notes = $this->db->getNotes($sortBy, $order);

        $this->view->render($page, [
                'notes' => $notes,
                'before' => $this->request->getGet('before'),
                'error' => $this->request->getGet('error'),
                'sort' => ['sortBy' => $sortBy, 'order' => $order]
            ]
        );
    }

    public function edit(): void
    {
        $page = 'edit';

        if ($this->request->isPost()) {
            $id = (int)$this->request->getPost('id');
            $noteData = [
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content')
            ];
            $this->db->editNote($noteData, $id);
            header('Location: /?before=updated');
            exit;
        }

        $note = $this->getNoteParams();
        $this->view->render($page, ['note' => $note, 'before' => 'updated']);
    }

    public function delete(): void
    {
        $page = 'delete';

        if ($this->request->isPost()) {
            $id = (int)$this->request->getPost('id');

            $this->db->deleteNote($id);
            header('Location: /?before=deleted');
            exit;
        }
        $note = $this->getNoteParams();

        $this->view->render($page, ['note' => $note, 'before' => 'deleted']);
    }

    private function getNoteParams(): array
    {
        $id = (int)$this->request->getGet('id');
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
        return $note;
    }
}