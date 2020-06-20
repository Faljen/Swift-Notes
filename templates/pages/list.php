<div>
    <h3>List of notes</h3>
    <section>
        <div class="msg">
            <?php
            if (!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created':
                        echo 'Your note has been added';
                        break;
                    case 'updated':
                        echo 'Your note has been updated';
                        break;
                    case 'deleted':
                        echo 'Your note has been deleted';
                        break;
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

        <?php if ((count($params['notes'])) > 1): ?>
            <div>
                <form class="settings-form" action="/" method="GET">
                    <?php
                    $sort = $params['sort'];
                    $sortBy = $sort['sortBy'] ?? 'created';
                    $order = $sort['order'] ?? 'desc';
                    ?>
                    <div>
                        <div>Sort by:</div>
                        <label>date: <input name="sortBy" type="radio" value="created"
                                <?php echo $sortBy === 'created' ? 'checked' : '' ?> /></label>
                        <label>title: <input name="sortBy" type="radio" value="title"
                                <?php echo $sortBy === 'title' ? 'checked' : '' ?> /></label>
                    </div>
                    <div>
                        <div>Order:</div>
                        <label>descending: <input name="sortOrder" type="radio" value="desc"
                                <?php echo $order === 'desc' ? 'checked' : '' ?> /></label>
                        <label>ascending: <input name="sortOrder" type="radio" value="asc"
                                <?php echo $order === 'asc' ? 'checked' : '' ?> /></label>
                    </div>
                    <input type="submit" value="Sort"/>
                </form>
            </div>
        <?php endif; ?>


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
                <?php if ($params['notes']): ?>
                    <?php foreach ($params['notes'] as $param): ?>
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
                <?php else: ?>
                    <h2 style="color: black; text-align: center">No notes to display. Create a new note!</h2>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </section>
</div>