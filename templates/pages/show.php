<div class="show">
    <ul>
        <?php $note = $params['note'] ?>
        <li>ID : <?php echo $note['ID'] ?></li>
        <li>Title : <?php echo htmlentities($note['title']) ?></li>
        <li>Content : <?php echo htmlentities($note['content']) ?></li>
        <li>Created : <?php echo htmlentities($note['created']) ?></li>
    </ul>
    <a href="/">
        <button class="showButton">Back</button>
    </a>
</div>