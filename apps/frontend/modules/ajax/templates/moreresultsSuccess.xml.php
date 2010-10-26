<root>
    <?php foreach ($results as $result): ?>
    <result>
        <title><?php echo $result['title'] ?></title>
        <content><?php echo $result['content'] ?></content>
        <clickUrl><?php echo $result['clickUrl'] ?></clickUrl>
        <displayUrl><?php echo $result['displayUrl'] ?></displayUrl>
        <thumbnail><?php echo $result['thumbnail'] ?></thumbnail>
    </result>
    <?php endforeach ; ?>
</root>
