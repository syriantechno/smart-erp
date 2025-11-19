<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\Activity;
use App\Models\CRM\Company;
use App\Models\CRM\Contact;
use App\Models\CRM\File;
use App\Models\CRM\Lead;
use App\Models\CRM\Opportunity;
use App\Models\CRM\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    private array $relatedMap = [
        'company' => Company::class,
        'contact' => Contact::class,
        'lead' => Lead::class,
        'opportunity' => Opportunity::class,
        'activity' => Activity::class,
        'task' => Task::class,
    ];

    public function index(Request $request)
    {
        $query = File::query();

        if ($request->filled('related_type') && $request->filled('related_id')) {
            $relatedType = $this->resolveRelatedType($request->related_type);
            $query->where('related_type', $relatedType)
                  ->where('related_id', $request->related_id);
        }

        $files = $query->latest()->paginate(20);

        return response()->json($files);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'max:10240'], // 10MB
            'related_type' => ['required', 'string'],
            'related_id' => ['required', 'integer'],
            'metadata' => ['nullable', 'array'],
        ]);

        $relatedType = $this->resolveRelatedType($validated['related_type']);

        $model = $relatedType::findOrFail($validated['related_id']);

        $uploadedFile = $validated['file'];
        $folder = 'crm/' . Str::kebab(class_basename($relatedType));
        $storedPath = $uploadedFile->store($folder, 'public');

        $fileRecord = File::create([
            'file_name' => $uploadedFile->getClientOriginalName(),
            'file_path' => $storedPath,
            'mime_type' => $uploadedFile->getClientMimeType(),
            'file_size' => $uploadedFile->getSize(),
            'related_type' => $relatedType,
            'related_id' => $model->id,
            'uploaded_by' => $request->user()->id,
            'metadata' => $validated['metadata'] ?? [],
        ]);

        return response()->json([
            'success' => true,
            'message' => __('File uploaded successfully.'),
            'data' => $fileRecord,
        ]);
    }

    public function download(File $file): StreamedResponse
    {
        abort_unless(Storage::disk('public')->exists($file->file_path), 404);

        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    public function destroy(File $file)
    {
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return response()->json([
            'success' => true,
            'message' => __('File deleted successfully.'),
        ]);
    }

    private function resolveRelatedType(string $type): string
    {
        $key = Str::kebab($type);

        if (! array_key_exists($key, $this->relatedMap)) {
            abort(422, __('Unsupported related type.'));
        }

        return $this->relatedMap[$key];
    }
}
