<?php
/**
 * Upload dataset RAG dari WP-Admin (PDF/TXT untuk sinkron ke n8n)
 *
 * @package Websiteku
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Direktori dataset RAG di uploads.
 */
function websiteku_rag_dataset_dir()
{
    $upload = wp_upload_dir();
    $dir = trailingslashit($upload['basedir']) . 'websiteku-rag';
    if (!file_exists($dir)) {
        wp_mkdir_p($dir);
        file_put_contents($dir . '/index.php', '<?php // Silence is golden.');
        file_put_contents($dir . '/.htaccess', 'Options -Indexes');
    }
    return $dir;
}

function websiteku_rag_dataset_url()
{
    $upload = wp_upload_dir();
    return trailingslashit($upload['baseurl']) . 'websiteku-rag/';
}

/**
 * Daftar file dataset.
 */
function websiteku_get_rag_files()
{
    $files = get_option('websiteku_rag_files', array());
    return is_array($files) ? $files : array();
}

/**
 * Menu admin dataset RAG.
 */
function websiteku_rag_dataset_admin_menu()
{
    add_submenu_page(
        'websiteku-settings',
        'Dataset RAG',
        'Dataset RAG',
        'manage_options',
        'websiteku-rag-dataset',
        'websiteku_rag_dataset_admin_page'
    );
}
add_action('admin_menu', 'websiteku_rag_dataset_admin_menu', 20);

/**
 * Halaman upload & daftar file.
 */
function websiteku_rag_dataset_admin_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $notice = '';

    if (isset($_POST['websiteku_upload_rag']) && check_admin_referer('websiteku_rag_upload')) {
        if (!empty($_FILES['rag_file']['name'])) {
            $allowed = array('pdf', 'txt', 'doc', 'docx', 'md');
            $file = $_FILES['rag_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed, true)) {
                $notice = 'error:Tipe file tidak diizinkan. Gunakan PDF, TXT, DOC, DOCX, atau MD.';
            } elseif ($file['size'] > 15 * 1024 * 1024) {
                $notice = 'error:Ukuran file maksimal 15 MB.';
            } else {
                $dir = websiteku_rag_dataset_dir();
                $safe_name = sanitize_file_name($file['name']);
                $target = $dir . '/' . $safe_name;

                if (move_uploaded_file($file['tmp_name'], $target)) {
                    $files = websiteku_get_rag_files();
                    $files[] = array(
                        'id' => wp_generate_uuid4(),
                        'name' => $safe_name,
                        'path' => $target,
                        'url' => websiteku_rag_dataset_url() . $safe_name,
                        'size' => size_format($file['size']),
                        'type' => $ext,
                        'uploaded' => current_time('mysql'),
                    );
                    update_option('websiteku_rag_files', $files);
                    $notice = 'success:File berhasil diunggah ke folder dataset RAG.';
                } else {
                    $notice = 'error:Gagal mengunggah file.';
                }
            }
        } else {
            $notice = 'error:Pilih file terlebih dahulu.';
        }
    }

    if (isset($_GET['delete_rag']) && check_admin_referer('delete_rag_' . $_GET['delete_rag'])) {
        $id = sanitize_text_field($_GET['delete_rag']);
        $files = websiteku_get_rag_files();
        $new = array();
        foreach ($files as $f) {
            if ($f['id'] === $id) {
                if (file_exists($f['path'])) {
                    wp_delete_file($f['path']);
                }
            } else {
                $new[] = $f;
            }
        }
        update_option('websiteku_rag_files', $new);
        $notice = 'success:File dihapus.';
    }

    $files = websiteku_get_rag_files();
    ?>
    <div class="wrap">
        <h1>Dataset RAG (Upload dari WordPress)</h1>
        <p>Unggah dokumen materi TIK untuk basis pengetahuan chatbot AI. File disimpan di
            <code><?php echo esc_html(websiteku_rag_dataset_dir()); ?></code>
        </p>

        <div style="background:#e3f2fd;padding:15px;border-radius:8px;margin:15px 0;">
            <strong>Sinkron ke n8n + Supabase:</strong>
            <ol style="margin:8px 0 0 20px;">
                <li>Upload file di bawah ini</li>
                <li>Salin URL file atau sinkronkan folder ke Google Drive yang dipantau workflow n8n</li>
                <li>Jalankan workflow embedding di n8n agar vector DB terbarui</li>
            </ol>
        </div>

        <?php if ($notice):
            $parts = explode(':', $notice, 2);
            $class = $parts[0] === 'success' ? 'notice-success' : 'notice-error';
            ?>
            <div class="notice <?php echo esc_attr($class); ?>">
                <p><?php echo esc_html($parts[1] ?? $notice); ?></p>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" style="margin:20px 0;padding:20px;background:#fff;border:1px solid #ccc;border-radius:8px;">
            <?php wp_nonce_field('websiteku_rag_upload'); ?>
            <h2>Upload Dokumen Baru</h2>
            <input type="file" name="rag_file" accept=".pdf,.txt,.doc,.docx,.md" required>
            <p class="description">PDF materi TIK, modul, atau ringkasan untuk RAG. Maks. 15 MB.</p>
            <p><button type="submit" name="websiteku_upload_rag" class="button button-primary">Upload ke Dataset RAG</button></p>
        </form>

        <h2>File Dataset (<?php echo count($files); ?>)</h2>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Tipe</th>
                    <th>Ukuran</th>
                    <th>Diunggah</th>
                    <th>URL</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($files)): ?>
                    <tr>
                        <td colspan="6">Belum ada file. Upload dokumen materi TIK.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($files as $f): ?>
                        <tr>
                            <td><?php echo esc_html($f['name']); ?></td>
                            <td><?php echo esc_html(strtoupper($f['type'])); ?></td>
                            <td><?php echo esc_html($f['size']); ?></td>
                            <td><?php echo esc_html($f['uploaded']); ?></td>
                            <td><a href="<?php echo esc_url($f['url']); ?>" target="_blank">Unduh</a></td>
                            <td>
                                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=websiteku-rag-dataset&delete_rag=' . $f['id']), 'delete_rag_' . $f['id'])); ?>"
                                    onclick="return confirm('Hapus file ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

function websiteku_rag_files_count()
{
    return count(websiteku_get_rag_files());
}
