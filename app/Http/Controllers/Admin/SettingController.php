<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Backups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $backups = Backups::all();

        return view('dashboard.admin.settings.index', compact('backups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createBackup()
    {
        $databaseName = DB::getDatabaseName();
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $fileName = 'backup-' . $databaseName . '-' . date('Y-m-d-H-i-s') . '.sql.gz';
        $filePath = storage_path('app/backups/' . $fileName);

        // Ensure backup directory exists
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Build mysqldump command with gzip compression
        $command = sprintf(
            'mysqldump --host=%s --user=%s --password=%s %s | gzip > %s',
            escapeshellarg($host),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($databaseName),
            escapeshellarg($filePath)
        );

        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            return response()->json([
                'success' => false,
                'error' => 'Backup failed'
            ], 500);
        }
        Backups::create([
            'file' => $fileName,
            'path' => $filePath
        ]);
        return back()->with('success', 'Backup created successfully!');
    }

    function downloadFile($filePath, $customName = null)
    {
        // Check if file exists
        if (!File::exists($filePath)) {
            abort(404, 'File not found');
        }

        // Get filename
        $fileName = $customName ?: File::basename($filePath);

        // Download the file
        return Response::download($filePath, $fileName);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
