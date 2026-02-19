<?php
function collectTextFilesContent($sourceDir, $outputFile) {
    // Ouvre le fichier de sortie en mode écriture (écrase s'il existe)
    $output = fopen($outputFile, 'w');

    // Vérifie si le dossier source existe
    if (!is_dir($sourceDir)) {
        die("Le dossier source n'existe pas : $sourceDir");
    }

    // Parcourt récursivement le dossier
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $file) {
        // Vérifie si c'est un fichier (pas un dossier)
        if ($file->isFile()) {
            // Lit le contenu du fichier
            $content = file_get_contents($file->getPathname());

            // Écrit le nom du fichier et son contenu dans le fichier de sortie
            fwrite($output, "=== Contenu du fichier : " . $file->getPathname() . " ===\n");
            fwrite($output, $content . "\n\n");
        }
    }

    fclose($output);
    echo "Le contenu de tous les fichiers texte a été copié dans : $outputFile";
}

// Exemple d'utilisation
$sourceDirectory = "D:\\code\\full-stack\\ALCHIFUNDA\\simple\\app\\Models";
$outputFile = "D:\\code\\full-stack\\ALCHIFUNDA\\simple\\app\\Models\\contenu_fichiers_texte.txt";

collectTextFilesContent($sourceDirectory, $outputFile);
?>
