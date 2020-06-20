<div>
    <h3>Edycja notatki</h3>
    <div>
        <?php if (!empty($params['note'])) : ?>
            <?php $note = $params['note']; ?>
            <form class="note-form" action="/?action=edit" method="post">
                <input name="id" type="hidden" value="<?php echo $note['ID'] ?>"/>
                <ul>
                    <li>
                        <label>Title <span class="required">*</span></label>
                        <input type="text" name="title" class="field-long" value="<?php echo $note['title'] ?>"/>
                    </li>
                    <li>
                        <label>Content</label>
                        <textarea name="content" id="field5"
                                  class="field-long field-textarea"><?php echo $note['content'] ?></textarea>
                    </li>
                    <li>
                        <input type="submit" value="Submit"/>
                    </li>
                </ul>
            </form>
        <?php else : ?>
            <div>
                No data to display
                <a href="/">
                    <button>Back</button>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>