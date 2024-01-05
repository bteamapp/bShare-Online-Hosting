
<?php
$directory = '/public_html/uploads-cdn'; // Đường dẫn thư mục A

// Lặp qua tất cả các file trong thư mục
foreach (scandir($directory) as $file) {
    $filePath = $directory . '/' . $file;

    // Kiểm tra xem file có phải là file và đã tồn tại ít nhất 10 ngày hay không
    if (is_file($filePath) && filemtime($filePath) < strtotime('-10 days')) {
        unlink($filePath); // Xóa file
        echo "Deleted: $file\n";
    }
}
?>
