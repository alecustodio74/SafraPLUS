<?php
$paginationFile = 'c:/Users/santo/Music/Github/SafraPLUS/Sistema/resources/views/vendor/pagination/tailwind.blade.php';
if (file_exists($paginationFile)) {
    $content = file_get_contents($paginationFile);
    $content = str_replace("{!! __('Showing') !!}", "Mostrando", $content);
    $content = str_replace("{!! __('to') !!}", "a", $content);
    $content = str_replace("{!! __('of') !!}", "de", $content);
    $content = str_replace("{!! __('results') !!}", "resultados", $content);
    // Also handle simple translations if they don't use __()
    $content = str_replace("Showing", "Mostrando", $content);
    $content = str_replace(" to ", " a ", $content);
    $content = str_replace(" of ", " de ", $content);
    $content = str_replace(" results", " resultados", $content);
    file_put_contents($paginationFile, $content);
    echo "Pagination updated.\n";
}

$baseDir = 'c:/Users/santo/Music/Github/SafraPLUS/Sistema/resources/views';
$dirs = scandir($baseDir);
foreach ($dirs as $dir) {
    if ($dir === '.' || $dir === '..')
        continue;
    $path = $baseDir . '/' . $dir;
    if (is_dir($path)) {
        foreach (['create.blade.php', 'edit.blade.php', 'index.blade.php'] as $file) {
            $filePath = $path . '/' . $file;
            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                $initialLength = strlen($content);
                // Remove the h2 tag that causes duplication (usually inside a mb-6 div near the top)
                $content = preg_replace('/^\s*<h2 class="text-2xl font-bold text-gray-900 tracking-tight">.*?<\/h2>\r?\n?/m', '', $content);
                if (strlen($content) < $initialLength) {
                    file_put_contents($filePath, $content);
                    echo "Updated: $filePath\n";
                }
            }
        }
    }
}
echo "All views updated.\n";
