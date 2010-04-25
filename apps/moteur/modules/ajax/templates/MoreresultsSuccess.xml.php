<root>
    <?php foreach ($results as $result): ?>
    <result>
        <title><?php echo $result['title'] ?></title>
        <content><?php echo $result['content'] ?></content>
    </result>
    <?php endforeach ; ?>
</root>