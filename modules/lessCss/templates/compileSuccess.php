<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>LESS files compilation</title>
    <?php foreach ($files as $index => $f) : ?>
      <?php echo stylesheet_tag($f, array('rel' => 'stylesheet/less', 'type' => 'text/css', 'title' => $index, 'media' => 'print')); ?>
    <?php endforeach; ?>
    <?php //todo: constant ?>
    <script type='text/javascript' src='/sfLESSPlugin/js/jquery-1.4.2.min.js'></script>
    <script type='text/javascript' src='<?php echo sfLESS::getConfig()->getLessJsPath(); ?>'></script>
  </head>
  <body>
    <h1>Compiling Less files</h1>
    <ul id="style">
    </ul>
    <script type="text/javascript">//<![CDATA[

      // The less files
      var files = [<?php foreach($files as $f) echo ("'$f', ") ?>null];

      $.each($('style[id^=less:]', 'head'), function (i, style)
      {
        style = $(style);
        var index = parseInt(style.attr('id').replace('less:', ''), 10);
        var file = getFileName(index);

        if (file !== false)
        {
          $('#style').append($('<li>').html(getFileName(index)));

          $.post(
            '<?php echo url_for('@less_css_save_css'); ?>',
            {
              file: file,
              content: style.html(),
              "<?php echo $csrfName; ?>": "<?php echo $csrfToken; ?>"
            }
          );
        }
      });

      function getFileName(index)
      {
        if (index >= 0 && index < files.length)
        {
          return files[index];
        }
        else
        {
          return false;
        }
      }

    //]]></script>
  </body>
</html>


