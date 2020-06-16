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

        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Options</th>
                </tr>
                </thead>
            </table>
        </div>

        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                
                </tbody>
            </table>
        </div>

    </section>
</div>