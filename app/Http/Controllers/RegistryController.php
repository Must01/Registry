<?php

namespace App\Http\Controllers;

use App\Models\Registry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class RegistryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Auth::user()->registries();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                    ->orWhere('sender', 'like', "%{$search}%")
                    ->orWhere('recipient', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $registries = $query->orderBy('id', 'desc')->paginate(10);

        if ($request->ajax()) {
            return view('registry._table', compact('registries'))->render();
        }
        return view('registry.index', compact('registries'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("registry.create");
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'reference_no' => 'required|string|max:255',
            'date' => 'nullable|date',
            'sender' => 'nullable|string|max:255',
            'recipient' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:1000',
            'remarks' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        // Handle file uploads
        $attachments = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('registries', $filename, 'public');
                $attachments[] = $path;
            }
        }
        $validatedData['attachments'] = json_encode($attachments);
        $validatedData['user_id'] = Auth::id();

        Registry::create($validatedData);

        return redirect()->route('registry.index')->with('success', 'Registry created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Registry $registry)
    {
        if ($registry->user_id !== Auth::id()) {
            abort(403);
        }

        $files = json_decode($registry->attachments ?? '[]');

        return view('registry.show', compact(['files', 'registry']));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $registry = Auth::user()->registries()->findOrFail($id);
        return view('registry.edit', compact('registry'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registry $registry)
    {
        if ($registry->user_id !== Auth::id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'reference_no' => 'required|string|max:255',
            'date' => 'nullable|date',
            'sender' => 'nullable|string|max:255',
            'recipient' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:1000',
            'remarks' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        // Handle new file uploads
        if ($request->hasFile('files')) {
            $attachments = json_decode($registry->attachments ?? '[]', true) ?: [];
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('registries', $filename, 'public');
                $attachments[] = $path;
            }
            $validatedData['attachments'] = json_encode($attachments);
        }

        $registry->update($validatedData);

        return redirect()->route('registry.index')->with('success', 'Registry updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registry $registry)
    {
        if ($registry->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete stored files
        $files = json_decode($registry->attachments ?? '[]', true) ?: [];
        foreach ($files as $file) {
            Storage::disk("public")->delete($file);
        }

        $registry->delete();

        return redirect()->route('registry.index')->with('success', 'Registry deleted successfully');
    }


    /**
     * Remove a file from the registry
     */
    public function removeFile(Request $request, Registry $registry)
    {
        if ($registry->user_id !== Auth::id()) {
            abort(403);
        }

        $filename = $request->filename;

        // Get files from database
        $files = json_decode($registry->attachments ?? '[]', true) ?: [];

        // Delete the file from storage
        Storage::disk('public')->delete($filename);

        // Remove filename from array
        $files = array_filter($files, fn($file) => !Str::contains($file, $filename));

        // Save
        $registry->attachments = json_encode(array_values($files));
        $registry->save();

        return back()->with('success', 'File deleted successfully');
    }


    /**
     * Download a file
     */
    public function downloadFile(Registry $registry, $filename)
    {
        if ($registry->user_id !== Auth::id()) {
            abort(403);
        }

        if (!Storage::disk('public')->exists("registries/$filename")) {
            abort(404);
        }

        return Storage::disk('public')->download("registries/$filename", Str::after($filename, '_'));
    }

    /**
     * View a file
     */
    public function viewFile(Registry $registry, $filename)
    {
        if ($registry->user_id !== Auth::id()) {
            abort(403);
        }

        $path = "registries/$filename";

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        // get file extention & content-Type
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
        ];

        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';


        return response()->file(storage_path("app/public/$path", [
            "Content-Type" => $contentType,
            "Content-Disposition" => 'inline; filename="' . Str::after($filename, '_')
        ]));
    }

    /**
     * Show CSV Export page
     */
    public function exportPage()
    {
        return view('registry.export');
    }

    /**
     * Handle CSV Export
     */
    public function export(Request $request)
    {
        // get Authenticated User
        $userId = Auth::id();

        // get user's registries
        $query = Registry::where('user_id', $userId);

        // get end/start date from url query
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');

        // add both fromDate and toDate the query
        if ($fromDate) $query->where('date', '>=', $fromDate);
        if ($toDate) $query->where('date', '<=', $toDate);

        // add order the the query and execute it
        $registries = $query->orderBy('id', 'desc')->get();

        $filename = "registry_export_" . now()->format('Y-m-d_H-i-s') . ".csv";
        // response headers
        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];


        $columns = ['reference_no', 'date', 'sender', 'recipient', 'subject', 'remarks'];

        $callback = function () use ($registries, $columns) {
            $fh = fopen('php://output', 'w');

            // BOM for UTF-8
            fprintf($fh, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($fh, ['Reference No', 'Date', 'Sender', 'Recipient', 'Subject', 'Remarks'], ";");

            // Data rows
            foreach ($registries as $r) {
                $row = [];
                foreach ($columns as $col) {
                    if ($col === 'date') {
                        $row[] = $r->date ? $r->date->format('Y-m-d') : '';
                    } else {
                        $row[] = $r->$col ?? '';
                    }
                }
                fputcsv($fh, $row, ";");
            }

            fclose($fh);
        };

        return response()->stream($callback, 200, $headers);
    }
}
