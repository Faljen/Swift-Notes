<?php
declare(strict_types=1);

namespace App\Controller;

class NoteController extends AbstractController
{
    private const PAGE_SIZE = 10;

    public function newNote(): void
    {
        $page = 'newnote';

        if ($this->request->hasPost()) {

            $noteData = [
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content')
            ];
            $this->noteModel->create($noteData);
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

        $pageSize = (int)$this->request->getGet('pageSize', self::PAGE_SIZE);
        $pageNumber = (int)$this->request->getGet('pageNumber', 1);

        $sortBy = $this->request->getGet('sortBy', 'created');
        $order = $this->request->getGet('sortOrder', 'desc');

        $searchingText = $this->request->getGet('searchingText', null);

        if ($searchingText) {
            $notes = $this->noteModel->search($sortBy, $order, $pageSize, $pageNumber, $searchingText);
            $notesCount = $this->noteModel->searchCount($searchingText);

        } else {
            $notes = $this->noteModel->getNotes($sortBy, $order, $pageSize, $pageNumber);
            $notesCount = $this->noteModel->getCount();
        }

        if (!in_array($pageSize, [5, 10, 15, 20])) {
            $pageSize = self::PAGE_SIZE;
        }

        $this->view->render($page, [
                'page' => ['pageSize' => $pageSize, 'pageNumber' => $pageNumber, 'pages' => (int)ceil($notesCount / $pageSize)],
                'notes' => $notes,
                'before' => $this->request->getGet('before'),
                'error' => $this->request->getGet('error'),
                'sort' => ['sortBy' => $sortBy, 'order' => $order],
                'searchingText' => $searchingText
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
            $this->noteModel->edit($noteData, $id);
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

            $this->noteModel->delete($id);
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

        return $this->noteModel->getNote($id);

    }
}