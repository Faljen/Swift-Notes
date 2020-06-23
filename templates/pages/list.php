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

        <div>
            <form class="settings-form" action="/" method="GET">
                <div>
                    <label>Search: <input type="text" name="searchingText"></label>
                </div>
                <?php
                $sort = $params['sort'];
                $sortBy = $sort['sortBy'] ?? 'created';
                $order = $sort['order'] ?? 'desc';
                $page = $params['page'];
                $pageSize = $page['pageSize'];
                $pageNumber = $page['pageNumber'] ?? 1;
                $pages = $page['pages'] ?? 1;
                $searchingText = $params['searchingText'] ?? null;
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
                <div>
                    <div>Page Size:</div>
                    <label>5 <input name="pageSize" type="radio"
                                    value="5" <?php echo $pageSize === 5 ? 'checked' : '' ?>></label>
                    <label>10 <input name="pageSize" type="radio"
                                     value="10" <?php echo $pageSize === 10 ? 'checked' : '' ?>></label>
                    <label>15 <input name="pageSize" type="radio"
                                     value="15" <?php echo $pageSize === 15 ? 'checked' : '' ?>></label>
                    <label>20 <input name="pageSize" type="radio"
                                     value="20" <?php echo $pageSize === 20 ? 'checked' : '' ?>></label>
                </div>
                <input type="submit" style="padding: 8px 14px; font-size: 14px" value="Submit"/>
            </form>
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

        <ul class="pagination">
            <?php $url = "&pageSize=$pageSize&searchingText=$searchingText&sortBy=$sortBy&sortOrder=$order" ?>
            <?php if ($pageNumber > 1): ?>
                <li>
                    <a href="/?pageNumber=<?php echo $pageNumber - 1 . $url ?>">
                        <button> <<</button>
                    </a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1;
                       $i <= $pages;
                       $i++): ?>
                <li>
                    <a href="/?pageNumber=<?php echo $i . $url ?>">
                        <button><?php echo $i; ?></button>
                    </a>
                </li>
            <?php endfor; ?>
            <?php if ($pageNumber < $pages): ?>
                <li>
                    <a href="/?pageNumber=<?php echo $pageNumber + 1 . $url ?>">
                        <button> >></button>
                    </a>
                </li>
            <?php endif; ?>
        </ul>

    </section>
</div>