<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommandController extends Controller
{



    public function run(Request $request)
    {
        $cmd = trim($request->cmd);

        if (!$cmd) {
            return response()->json([
                'success' => false,
                'output' => 'No command provided'
            ]);
        }

        $descriptors = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ];

        $process = proc_open(
            "cmd.exe /c " . $cmd,
            $descriptors,
            $pipes,
            "C:\\"
        );

        if (!is_resource($process)) {
            return response()->json([
                'success' => false,
                'output' => 'Failed to start process'
            ]);
        }

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        $exitCode = proc_close($process);

        return response()->json([
            'success' => $exitCode === 0,
            'command' => $cmd,
            'output' => $stdout ?: $stderr,
            'exit_code' => $exitCode
        ]);
    }
    // public function run(Request $request)
    // {
    //     $cmd = trim($request->cmd);

    //     $cwd = session('cwd', base_path());

    //     if (str_starts_with($cmd, 'cd ')) {
    //         $path = trim(substr($cmd, 3));
    //         $newPath = $cwd . DIRECTORY_SEPARATOR . $path;

    //         if (is_dir($newPath)) {
    //             session(['cwd' => $newPath]);
    //             return response()->json([
    //                 'success' => true,
    //                 'output' => "Changed directory to $newPath"
    //             ]);
    //         }

    //         return response()->json([
    //             'success' => false,
    //             'output' => "Directory not found"
    //         ]);
    //     }

    //     $output = shell_exec("cd /d \"$cwd\" && $cmd 2>&1");

    //     return response()->json([
    //         'success' => true,
    //         'output' => $output,
    //         'cwd' => $cwd
    //     ]);
    // }
    public function hello()
    {
        return response()->json([
            'success' => true,
            'command' => 'hello',
            'output' => 'hello world'
        ]);
    }
}