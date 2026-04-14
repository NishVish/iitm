<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InteracitveController extends Controller
{


    public function index()
    {
        return view('web.interactive.index');
    }

    public function reload(Request $request)
    {

        $userid = session()->get('userid');
        return $this->stalldemo(true, $userid);

    }
    // Add a default for $userid so the page doesn't crash on first load
    public function stalldemo($img = false, $userid = null)
    {
        // dd($img);
        if (!session()->has('userid')) {
            session()->put('userid', rand(1000, 9999));
        }

        $userid = session()->get('userid');
        // dd($userid);

        // 🔥 get flag from session (and REMOVE it)

        $baseurl = url('/');

        if ($img && $userid) {
            $framePath = $baseurl . '/public/session/' . $userid . '/frame_';
            $logoPath = $baseurl . '/public/session/' . $userid . '/logo.png';
        } else {
            $framePath = $baseurl . '/public/session/default/frame_';
            $logoPath = $baseurl . '/public/session/default/logo.png';
        }
        // echo "<pre>";
        // echo $logoPath;
        // echo "<br>";
        // echo $framePath;
        // echo "</pre>";
        // exit;
        return view('web.interactive.visionstudio', [
            'img' => $img,
            'userid' => $userid,
            'framePath' => $framePath,
            'logoPath' => $logoPath
        ]);
    }

    public function uploadLogo(Request $request)
    {
        // Validate inputs
        $request->validate([
            'logo' => 'required|image|max:2048',
            'userid' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $userid = $request->input('userid');

            // Define the path
            $destinationPath = public_path('session/' . $userid);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Save the image
            $image->move($destinationPath, 'logo.png');
            $fullImagePath = $destinationPath . DIRECTORY_SEPARATOR . 'logo.png';


            // echo $fullImagePath;
            // exit;
            // --- THIS IS HOW YOU USE IT ---
            // Pass the absolute path of the newly saved logo to your render function
            $this->runBlenderRender($fullImagePath);

            // After the render is done (and you've commented out the exit; in runBlenderRender)
            return $this->stalldemo(true, $userid);
        }

        return redirect()->back();
    }

    protected function runBlenderRender($imagePath)
    {
        $blender = env('BLENDER_PATH');

        // Matching your specific folder name: blender_assests
        $scene = base_path('blender_assests' . DIRECTORY_SEPARATOR . 'scene.blend');
        $script = base_path('blender_assests' . DIRECTORY_SEPARATOR . 'render.py');

        $cmd = sprintf(
            '%s -b %s -P %s -- %s 2>&1',
            escapeshellarg($blender),
            escapeshellarg($scene),
            escapeshellarg($script),
            escapeshellarg($imagePath)
        );

        // echo "<pre>COMMAND: $cmd\n\n";
        exec($cmd, $output, $resultCode);
        // echo "LOG:\n" . implode("\n", $output) . "</pre>";
        // exit;
    }
    public function clearSession()
    {
        session()->flush();
        return redirect()->route('stalldemo');

        // 1. Get the current userid before flushing
        $userid = session('userid');

        if ($userid) {
            // 2. Delete the physical folder for this user
            $folderPath = public_path('session/' . $userid);
            if (File::exists($folderPath)) {
                File::deleteDirectory($folderPath);
            }
        }

        // 3. Clear the session

        // 4. Redirect back to start fresh
    }

    public function blender_info()
    {
        $os = PHP_OS_FAMILY;

        $result = [
            'os' => $os,
            'php_version' => PHP_VERSION,
            'blender_found' => false,
            'blender_path' => null,
            'blender_version' => null,
            'error' => null,
        ];

        try {
            // Detect Blender in PATH
            $command = $os === 'Windows'
                ? 'where blender'
                : 'which blender';

            $output = [];
            exec($command . ' 2>&1', $output);

            $blenderPath = !empty($output) ? trim($output[0]) : null;

            // Fallback common locations
            if (!$blenderPath) {
                $paths = $os === 'Windows'
                    ? [
                        "C:\\Program Files\\Blender Foundation\\Blender\\blender.exe",
                        "C:\\Program Files\\Blender Foundation\\Blender 5.1\\blender.exe",
                    ]
                    : [
                        "/usr/bin/blender",
                        "/usr/local/bin/blender",
                        "/snap/bin/blender",
                    ];

                foreach ($paths as $p) {
                    if (file_exists($p)) {
                        $blenderPath = $p;
                        break;
                    }
                }
            }

            // If found, get ONLY first clean version line
            if ($blenderPath) {
                $result['blender_found'] = true;
                $result['blender_path'] = $blenderPath;

                $versionOutput = [];
                exec("\"$blenderPath\" --version 2>&1", $versionOutput);

                // Clean: take only first line that contains Blender version
                foreach ($versionOutput as $line) {
                    if (stripos($line, 'blender') !== false) {
                        $result['blender_version'] = trim($line);
                        break;
                    }
                }

                // fallback if not matched
                if (!$result['blender_version'] && isset($versionOutput[0])) {
                    $result['blender_version'] = trim($versionOutput[0]);
                }

            } else {
                $result['error'] = 'Blender not found on this system.';
            }

        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }

        return view('web.interactive.blender-info', compact('result'));
    }
}