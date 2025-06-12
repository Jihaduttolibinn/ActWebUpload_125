<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar File</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-100 to-indigo-200 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-2xl rounded-3xl p-8 border border-purple-200">
        <h2 class="text-3xl font-extrabold text-purple-700 mb-6 text-center">📁 Daftar File yang Diunggah</h2>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
            $fileToDelete = basename($_POST['delete']);
            $filePath = "uploads/" . $fileToDelete;

            if (file_exists($filePath)) {
                unlink($filePath);
                echo "<p class='text-green-600 font-medium mb-4'>✅ File <strong>$fileToDelete</strong> berhasil dihapus.</p>";
            } else {
                echo "<p class='text-red-600 font-medium mb-4'>❌ File tidak ditemukan.</p>";
            }
        }
        ?>

        <ul class="space-y-6">
        <?php
        $dir = "uploads/";
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $path = $dir . $file;
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);

                    echo "<li class='bg-purple-50 p-5 rounded-xl shadow-md border border-purple-200'>
                            <div class='flex flex-col md:flex-row md:items-center md:justify-between gap-3'>
                                <span class='font-semibold text-gray-800 break-words'>$file</span>
                                <div class='flex gap-3 text-sm'>
                                    <a href='$path' target='_blank' class='text-blue-600 hover:text-blue-800 font-medium transition'>🔍 Lihat</a>
                                    <a href='$path' download class='text-green-600 hover:text-green-800 font-medium transition'>⬇️ Download</a>
                                    <form method='post' class='inline' onsubmit=\"return confirm('Yakin ingin menghapus file ini?');\">
                                        <input type='hidden' name='delete' value='$file'>
                                        <button type='submit' class='text-red-600 hover:text-red-800 font-medium transition'>🗑️ Hapus</button>
                                    </form>
                                </div>
                            </div>";

                    if ($isImage) {
                        echo "<div class='mt-4'><img src='$path' alt='$file' class='max-w-xs rounded-lg border-2 border-purple-200 shadow-sm'></div>";
                    }

                    echo "</li>";
                }
            } else {
                echo "<li class='text-gray-600'>⚠️ Tidak ada file yang diunggah.</li>";
            }
        } else {
            echo "<li class='text-red-600'>🚫 Folder <code>uploads/</code> tidak ditemukan.</li>";
        }
        ?>
        </ul>

        <div class="mt-8 text-center">
            <a href="index.html" class="text-purple-700 hover:text-purple-900 font-semibold hover:underline transition">← Kembali ke Upload</a>
        </div>
    </div>
</body>
</html>
