<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('create:view {path}', function($path) {
    $x = explode('/', $path);
    $filename = array_pop($x);

    if (sizeof($x) > 0) {
        $x = 'resources/views/' . implode('/', $x);
        shell_exec("bash -c 'mkdir -m 755 -p $x'");
    } else {
        $x = 'resources/views';
    }

    shell_exec("touch $x/$filename.blade.php");
    shell_exec("chmod 644 $x/$filename.blade.php");

    $this->comment("File created: $x/$filename");
});

Artisan::command('create:helper {path}', function($path) {
    $x = explode('/', $path);
    $filename = array_pop($x);

    if (sizeof($x) > 0) {
        $x = 'app/Helpers/' . implode('/', $x);
        shell_exec("bash -c 'mkdir -m 755 -p $x'");
    } else {
        $x = 'app/Helpers';
    }

    shell_exec("touch $x/$filename.php");
    shell_exec("chmod 644 $x/$filename.php");

    $file = fopen("$x/$filename.php", 'w');    
    $namespace = str_replace('/', "\\", ucfirst($x));
    $content = "<?php\n\nnamespace $namespace;\n\n";
    $content .= $x != 'app/Helpers' ? "use App\\Helpers\\Helper;\n\n" : "";
    $content .= "class $filename extends Helper\n{\n\n}";
    fwrite($file, $content);
    fclose($file);

    $this->comment("File created: $x/$filename");
});