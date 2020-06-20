<div>
    <h3>List of notes</h3>
    <section>
        <div class="msg">
            <?php
            if (!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created':
                        echo 'Your note has been added';
                    case 'updated':
                        echo 'Your note has been updated';
                }
            }
            ?>
        </div>

        <div class="error">
            <?php
            if (!empty($params['error'])) {
                switch ($params['error']) {
                    case 'notfound':
                        echo 'A note with this ID doesn\'t exist';
                        break;
                    case 'invalidid':
                        echo 'Invalid ID note';
                        break;
                }
            }
            ?>
        </div>

        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Created</th>
                    <th>Options</th>
                </tr>
                </thead>
            </table>
        </div>

        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <?php foreach ($params['notes'] ?? [] as $param): ?>
                    <tr>
                        <td><?php echo $param['id'] ?></td>
                        <td><?php echo $param['title'] ?></td>
                        <td><?php echo $param['created'] ?></td>
                        <td>
                            <button>
                                <a href="/?action=show&id=<?php echo $param['id'] ?>">
                                    Show
                                </a>
                            </button>
                            <button>
                                <a href="/?action=delete&id=<?php echo $param['id'] ?>">
                                    Delete
                                </a>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </section>
</div>