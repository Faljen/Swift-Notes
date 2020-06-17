<div>
    <h3>List of notes</h3>
    <section>
        <div class="msg">
            <?php
            if (!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created':
                        echo 'Your note has been added';
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
                        <td><?php echo htmlentities($param['title']) ?></td>
                        <td><?php echo htmlentities($param['created']) ?></td>
                        <td>
                            <button>
                                <a href="/?action=show&id=<?php echo $param['id'] ?>">Show</a>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </section>
</div>