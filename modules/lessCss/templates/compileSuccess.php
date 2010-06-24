<?php
echo "Status:\n\n";
foreach ($files as $file)
{
  printf("* compiled %s to %s in %f seconds\n", $file['lessFile'], $file['cssFile'], $file['compTime']);
}
if (count($errors))
{
  echo "\nErrors:\n\n";
  foreach ($sf_data->getRaw('errors') as $file => $error)
  {
    printf("* ERROR in %s:\n%s\n", urldecode($file), urldecode($error));
  }
}

