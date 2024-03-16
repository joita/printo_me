<?php header ("Content-Type:text/xml"); ?>
<?php echo '<?xml version="1.0"?>';?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title><?php echo (isset($meta['title']) ? $meta['title'] : 'Printome'); ?></title>
        <link><?php echo (isset($meta['url']) ? $meta['url'] : 'https://printome.mx'); ?></link>
        <description><?php echo (isset($meta['description']) ? $meta['description'] : 'Productos Printome'); ?></description>
