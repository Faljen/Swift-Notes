<div class="show">
    <ul>
        <?php $note = $params['note'] ?>
        <li>ID : <?php echo $note['ID'] ?></li>
        <li>Title : <?php echo $note['title'] ?></li>
        <li>Content : <?php echo $note['content'] ?></li>
        <li>Created : <?php echo $note['created'] ?></li>
    </ul>
    <a href="/?action=edit&id=<?php echo $note['ID'] ?>">
        <button class="showButton">Edit</button>
    </a>
    <a href="/">
        <button class="showButton">Back</button>
    </a>
</div>