<div class="show">
    <ul>
        <?php $note = $params['note'] ?>
        <li>ID : <?php echo $note['ID'] ?></li>
        <li>Title : <?php echo $note['title'] ?></li>
        <li>Content : <?php echo $note['content'] ?></li>
        <li>Created : <?php echo $note['created'] ?></li>
    </ul>

    <form action="/?action=delete" method="POST" id="deleteForm">
        <input name="id" type="hidden" value="<?php echo $note['ID'] ?>">
    </form>
    <button type="submit" class="deleteButton" form="deleteForm">Delete</button>
    <a href="/">
        <button class="showButton">Back</button>
    </a>
</div>