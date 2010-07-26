<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>LESS files compilation</title>
    <?php foreach ($files as $index => $f) : ?>
      <?php echo stylesheet_tag($f, array('rel' => 'stylesheet/less', 'type' => 'text/css', 'title' => $index)); ?>
    <?php endforeach; ?>
    <?php //todo: constant ?>
    <script type='text/javascript' src='/sfLESSPlugin/js/jquery-1.4.2.min.js'></script>
    <script type='text/javascript' src='/sfLESSPlugin/js/less-1.0.33.js'></script>
  </head>
  <body>
    <h1>Compiling Less files</h1>
    <ul>
      <?php foreach ($files as $f) : ?>
      <li><?php echo $f; ?></li>
      <?php endforeach; ?>
    </ul>
    <ul id="style">

    </ul>
    <script type="text/javascript">//<![CDATA[

      // TODO: escaping
      var files = [<?php foreach($files as $f) echo ("'$f', ") ?>null];
      var styles = $('style[id^=less:]', 'head');

      $.each(styles, function (i, style)
      {
        style = $(style);
        var id = style.attr('id');
        $('#style').append($('<li>').html(id + getFileName(id)));
        $.post(
          '<?php echo url_for('@less_css_save_css'); ?>',
          {
            file: getFileName(id),
            content: style.html(),
            "<?php echo $csrfName; ?>": "<?php echo $csrfToken; ?>"
          }
        );
      });

      function getFileName(id)
      {
        return files[parseInt(id.replace('less:', ''), 10)];
      }

    //]]></script>
  </body>
</html>


