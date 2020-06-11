<div>
    <h3> New note </h3>
    <div>
        <?php if ($params['created'] == true): ?>
            <div>
                <div>Tytuł: <?php echo $params['title']; ?></div>
                <div>Treść: <?php echo $params['content']; ?></div>
            </div>
        <?php else: ?>
            <form class="note-form" action="/?action=newnote" method="POST">
                <ul>
                    <li>
                        <label>Title <span class="required">*</span></label>
                        <input type="text" name="title" class="field-long">
                    </li>

                    <li>
                        <label>Content</label>
                        <textarea name="content" id="field5" class="field-long field-textarea"></textarea>
                    </li>

                    <li>
                        <input type="submit" value="Submit">
                    </li>
                </ul>
            </form>
        <?php endif; ?>
    </div>
</div>
