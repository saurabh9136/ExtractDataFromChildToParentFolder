<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Second-Level Subfolders</title>
</head>
<body>

    <h2>Delete Second-Level Subfolders</h2>

    <form action="" method="post">
        <label for="folderPath">Enter Folder Path:</label>
        <input type="text" id="folderPath" name="folderPath" required><br>

        <button type="submit">Delete Second-Level Subfolders</button>
    </form>

    <?php
    function deleteSecondLevelSubfolders($folderPath) {
        $subfolders = glob($folderPath . '/*', GLOB_ONLYDIR);

        foreach ($subfolders as $subfolder) {
            $secondLevelSubfolders = glob($subfolder . '/*', GLOB_ONLYDIR);

            if (count($secondLevelSubfolders) > 0) {
                // Move the contents of the second-level subfolder to its parent
                moveContentsToParent($subfolder, $secondLevelSubfolders);

                // Delete the second-level subfolder
                rmdir($subfolder);

                echo "<p>Second-level subfolder '$subfolder' deleted successfully.</p>";
            }
        }
    }

    function moveContentsToParent($parentFolder, $subfolders) {
        foreach ($subfolders as $subfolder) {
            $files = glob($subfolder . '/*');

            foreach ($files as $file) {
                // Move the file to the parent folder
                $newLocation = $parentFolder . '/' . basename($file);
                rename($file, $newLocation);
            }
        }
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $folderPath = $_POST['folderPath'];

        deleteSecondLevelSubfolders($folderPath);
    }
    ?>

</body>
</html>