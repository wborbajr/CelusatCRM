<?php

  define('boolean', 1);
  define('string', 2);
  define('integer', 3);

  $php_ini_all = Array(
    Array(string, 'arg_separator.input'),
    Array(string, 'arg_separator.output'),
    Array(boolean, 'display_errors'),
    Array(boolean, 'display_startup_errors'),
    Array(boolean, 'magic_quotes_runtime'),
    Array(integer, 'error_reporting'),
    Array(string, 'variables_order'),
    Array(string, 'gpc_order')
  );

  $php_ini_perdir = Array(
    Array(boolean, 'asp_tags'),
    Array(boolean, 'magic_quotes_gpc'),
    Array(string, 'output_buffering'),
    Array(boolean, 'register_globals'),
    Array(boolean, 'short_open_tag')
  );
  
  function display_php_conf() {
      foreach ( $GLOBALS['php_ini_all'] as $option ) {
        $value = ini_get($option[1]);
        echo "ini_set('$option[1]', '$value');\n";
      }
    }
  
    function display_htaccess_conf() {
      global $php_ini_all, $php_ini_perdir;
  
      foreach ( array_merge($php_ini_all, $php_ini_perdir) as $option ) {
        $value = ini_get($option[1]);
  
        if ( $option[0] == boolean ) {
          $value = $value ? 'on' : 'off';
          $directive = 'php_flag';
        } else {
          $directive = 'php_value';
        }
  
        echo "$directive $option[1] $value \n";
      }
    }

header('Content-type: text/plain');

  echo "PHP settings:n";
  display_php_conf();

  echo "n.htaccess settings:n";
  display_htaccess_conf();    
    
?>