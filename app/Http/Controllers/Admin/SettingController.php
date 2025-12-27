<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Backups;
use App\Services\EnvService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;


class SettingController extends Controller
{
    /**
     * Display settings page with backups
     */
    public function index()
    {
        // Get backups sorted by latest first
        $backups = Backups::orderBy('created_at', 'desc')->get();

        // Calculate file sizes and format dates
        $backups->each(function ($backup) {
            $filePath = storage_path('app/backups/' . $backup->file);
            $backup->size = File::exists($filePath)
                ? $this->formatBytes(File::size($filePath))
                : '0 Bytes';
            $backup->formatted_date = $backup->created_at->format('M d, Y \a\t h:i A');
        });

        return view('dashboard.admin.settings.index', compact('backups'));
    }

    /**
     * Create a new database backup
     * Route: POST /admin/settings/backup-database
     */
    public function createBackup(Request $request)
    {
        try {
            $databaseName = DB::getDatabaseName();
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port', '3306');

            // Create unique filename
            $timestamp = now()->format('Y-m-d_H-i-s');
            $fileName = 'backup-' . $databaseName . '-' . $timestamp . '.sql.gz';
            $filePath = storage_path('app/backups/' . $fileName);

            // Ensure backup directory exists
            $backupDir = storage_path('app/backups');
            if (!File::exists($backupDir)) {
                File::makeDirectory($backupDir, 0755, true);
            }

            // Check if mysqldump is available
            $mysqldumpCheck = shell_exec('which mysqldump');
            if (empty($mysqldumpCheck)) {
                return back()->with('error', 'mysqldump command not found. Please install MySQL client tools.');
            }

            // Build mysqldump command
            $command = sprintf(
                'mysqldump --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers --events %s | gzip -9 > %s',
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($databaseName),
                escapeshellarg($filePath)
            );

            // Execute backup command
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                // Try without routines and triggers if they cause issues
                $command = sprintf(
                    'mysqldump --host=%s --port=%s --user=%s --password=%s %s | gzip -9 > %s',
                    escapeshellarg($host),
                    escapeshellarg($port),
                    escapeshellarg($username),
                    escapeshellarg($password),
                    escapeshellarg($databaseName),
                    escapeshellarg($filePath)
                );

                exec($command, $output, $returnVar);

                if ($returnVar !== 0) {
                    throw new \Exception('Backup failed. Return code: ' . $returnVar);
                }
            }

            // Verify backup file was created
            if (!File::exists($filePath)) {
                throw new \Exception('Backup file was not created');
            }

            // Get file size
            $fileSize = File::size($filePath);

            // Store backup info in database
            $backup = Backups::create([
                'file' => $fileName,
                'path' => $filePath,
                'size' => $fileSize,
                'note' => $request->input('note', 'Manual backup')
            ]);

            // Clean old backups (keep only last 5)
            $this->cleanOldBackups(5);

            return back()->with('success', 'Backup created successfully! Size: ' . $this->formatBytes($fileSize));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Backup failed: ' . $e->getMessage());

            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    /**
     * Download backup file
     * Route: POST /admin/settings/backup/download/{path}
     */
    public function downloadFile($path)
    {
        try {
            // Decode the path if it's URL encoded
            $filename = urldecode($path);
            $filePath = storage_path('app/backups/' . $filename);

            // Check if file exists
            if (!File::exists($filePath)) {
                return back()->with('error', 'Backup file not found: ' . $filename);
            }

            // Get the backup record
            $backup = Backups::where('file', $filename)->first();
            if ($backup) {
                $backup->increment('download_count', 1);
                $backup->last_downloaded_at = now();
                $backup->save();
            }

            // Create a user-friendly filename for download
            $downloadName = 'database-backup-' . date('Y-m-d') . '-' . $filename;

            // Set headers for gzip file
            $headers = [
                'Content-Type' => 'application/gzip',
                'Content-Disposition' => 'attachment; filename="' . $downloadName . '"',
                'Content-Length' => File::size($filePath),
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ];

            return Response::download($filePath, $downloadName, $headers);
        } catch (\Exception $e) {
            Log::error('Download failed: ' . $e->getMessage());
            return back()->with('error', 'Download failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete backup file
     * Route: POST /admin/settings/backup/delete/{path}
     */
    public function deleteBackup(Request $request, $path)
    {
        try {
            // Decode the path
            $filename = urldecode($path);

            // Find the backup record
            $backup = Backups::where('file', $filename)->first();

            if (!$backup) {
                return back()->with('error', 'Backup record not found in database.');
            }

            $filePath = storage_path('app/backups/' . $filename);

            // Check if file exists and delete it
            if (File::exists($filePath)) {
                if (!File::delete($filePath)) {
                    throw new \Exception('Failed to delete file from storage.');
                }
            } else {
                Log::warning('Backup file not found in storage, but record exists: ' . $filename);
            }

            // Delete the database record
            $backup->delete();

            return back()->with('success', 'Backup deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Delete backup failed: ' . $e->getMessage());
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    /**
     * Update general settings (if needed)
     */
    public function updateGeneral(Request $request)
    {
        // Your existing general settings update logic
        // ...

        return back()->with('success', 'General settings updated successfully!');
    }

    /**
     * Update shipping settings (if needed)
     */
    public function updateShipping(Request $request)
    {
        // Your existing shipping settings update logic
        // ...

        return back()->with('success', 'Shipping settings updated successfully!');
    }

    /**
     * Update email settings (if needed)
     */
    public function updateEmail(Request $request)
    {
        // Your existing email settings update logic
        // ...

        return back()->with('success', 'Email settings updated successfully!');
    }

    /**
     * Clean old backups
     */
    private function cleanOldBackups($keep = 5)
    {
        try {
            // Get all backups ordered by date (newest first)
            $backups = Backups::orderBy('created_at', 'desc')->get();

            // Keep only the specified number of backups
            if ($backups->count() > $keep) {
                $toDelete = $backups->slice($keep);

                foreach ($toDelete as $backup) {
                    $filePath = storage_path('app/backups/' . $backup->file);

                    // Delete file from storage
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }

                    // Delete database record
                    $backup->delete();
                }

                Log::info('Cleaned ' . $toDelete->count() . ' old backups. Keeping ' . $keep . ' most recent.');
            }
        } catch (\Exception $e) {
            Log::error('Clean backups failed: ' . $e->getMessage());
        }
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Show backup restore form (optional)
     */
    public function showRestoreForm()
    {
        $backups = Backups::orderBy('created_at', 'desc')->get();
        // return view('admin.settings.restore', compact('backups'));
    }

    /**
     * Restore from backup (optional - use with caution!)
     */
    public function restoreBackup(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|exists:backups,file',
            'confirmation' => 'required|in:YES'
        ]);

        // WARNING: This will overwrite your current database!
        // Implement with extreme caution and proper backups

        return back()->with('warning', 'Restore functionality disabled for safety. Contact administrator.');
    }

    /**
     * Get backup file size (AJAX endpoint - optional)
     */
    public function getBackupSize($filename)
    {
        $filePath = storage_path('app/backups/' . $filename);

        if (!File::exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->json([
            'size' => File::size($filePath),
            'size_formatted' => $this->formatBytes(File::size($filePath))
        ]);
    }
}
