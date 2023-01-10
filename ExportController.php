<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\DbDumper\Databases\MySql;

class ExportController extends Controller
{
    public function export()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        $dumpFile = storage_path("app/{$database}.sql");

        $dumper = MySql::create()
            ->setDbName($database)
            ->setUserName($username)
            ->setPassword($password)
            ->dumpToFile($dumpFile);

        return response()->download($dumpFile)->deleteFileAfterSend(true);
    }
}
