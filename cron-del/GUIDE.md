## Introduction

This guide will walk you through setting up a cron job using PHP to automatically delete files in a specific directory after 10 days. This can be useful for cleaning up old or temporary files uploaded.

## Prerequisites

- Access to your server's command line interface.
- A PHP interpreter installed on your server.

## Step 1: Create a PHP Script

Create a PHP script or use our script (`delete10d.php`) to delete files older than 10 days in a specified directory.

```php
<?php
$directory = '/path/to/your/directory'; // Replace with the actual path to your directory

foreach (scandir($directory) as $file) {
    $filePath = $directory . '/' . $file;

    if (is_file($filePath) && filemtime($filePath) < strtotime('-10 days')) {
        unlink($filePath);
        echo "Deleted: $file\n";
    }
}
?>
```


## Step 2: Set Up Cron Job
Open your terminal and edit the crontab file.

`crontab -e`

Add a new line to schedule the cron job to run daily at midnight.

`0 0 * * * /path/to/php /path/to/delete_old_files.php`

Replace /path/to/php with the actual path to your PHP interpreter and /path/to/delete_old_files.php with the full path to your PHP script.

## Step 3: Save and Exit
Save the crontab file and exit the editor.

## Conclusion
You have successfully set up a cron job to automatically delete files older than 10 days in a specific directory. The cron job will run daily at midnight.


Make sure to replace placeholder paths with your actual directory paths. This guide assumes basic familiarity with the command line and file paths.

For latest version of this file, please visit https://github.com/bteamapp/bShare-Online-Hosting.wiki.git
