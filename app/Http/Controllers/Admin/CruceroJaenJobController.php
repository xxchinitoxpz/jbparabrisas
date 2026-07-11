<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CruceroJaenJob;
use App\Support\PublicImageStorage;
use Illuminate\Http\Request;

class CruceroJaenJobController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = CruceroJaenJob::query();

        if ($search) {
            $query->where('description', 'like', '%' . $search . '%');
        }

        if ($status) {
            $query->where('status', $status);
        }

        $jobs = $query->orderBy('job_date', 'desc')->paginate(10)->withQueryString();

        return view('admin.crucero_jaen_jobs.index', compact('jobs', 'search', 'status'));
    }

    public function create()
    {
        return view('admin.crucero_jaen_jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_date' => 'required|date',
            'description' => 'required|string',
            'status' => 'required|string|in:pendiente,cancelado,cobrado',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ], [
            'job_date.required' => 'La fecha del trabajo es obligatoria.',
            'job_date.date' => 'La fecha ingresada no es válida.',
            'description.required' => 'La descripción es obligatoria.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
            'photos.*.image' => 'Cada archivo debe ser una imagen.',
            'photos.*.mimes' => 'El formato de imagen no es válido (solo jpeg, png, jpg, gif, svg, webp).',
            'photos.*.max' => 'Cada imagen no debe pesar más de 4MB.',
        ]);

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $photos[] = PublicImageStorage::store($file, 'crucero_jaen_jobs');
            }
        }

        CruceroJaenJob::create([
            'job_date' => $request->job_date,
            'description' => $request->description,
            'status' => $request->status,
            'photos' => $photos,
        ]);

        if ($request->wantsTurboStream()) {
            session()->flash('success', 'Trabajo de Crucero Jaén registrado correctamente.');
            return response()->turboStream()
                ->action('redirect')
                ->attributes(['url' => route('admin.crucero_jaen_job.index')]);
        }

        return redirect()->route('admin.crucero_jaen_job.index')
            ->with('success', 'Trabajo de Crucero Jaén registrado correctamente.');
    }

    public function edit(string $id)
    {
        $job = CruceroJaenJob::findOrFail($id);
        return view('admin.crucero_jaen_jobs.edit', compact('job'));
    }

    public function update(Request $request, string $id)
    {
        $job = CruceroJaenJob::findOrFail($id);

        $request->validate([
            'job_date' => 'required|date',
            'description' => 'required|string',
            'status' => 'required|string|in:pendiente,cancelado,cobrado',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ], [
            'job_date.required' => 'La fecha del trabajo es obligatoria.',
            'job_date.date' => 'La fecha ingresada no es válida.',
            'description.required' => 'La descripción es obligatoria.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
            'photos.*.image' => 'Cada archivo debe ser una imagen.',
            'photos.*.mimes' => 'El formato de imagen no es válido.',
            'photos.*.max' => 'Cada imagen no debe pesar más de 4MB.',
        ]);

        $photos = $job->photos ?? [];

        // Remove marked photos
        if ($request->has('remove_photos')) {
            foreach ($request->remove_photos as $pathToRemove) {
                if (($key = array_search($pathToRemove, $photos)) !== false) {
                    PublicImageStorage::delete($pathToRemove);
                    unset($photos[$key]);
                }
            }
            $photos = array_values($photos); // reindex
        }

        // Add new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $photos[] = PublicImageStorage::store($file, 'crucero_jaen_jobs');
            }
        }

        $job->update([
            'job_date' => $request->job_date,
            'description' => $request->description,
            'status' => $request->status,
            'photos' => $photos,
        ]);

        if ($request->wantsTurboStream()) {
            session()->flash('success', 'Trabajo de Crucero Jaén actualizado correctamente.');
            return response()->turboStream()
                ->action('redirect')
                ->attributes(['url' => route('admin.crucero_jaen_job.index')]);
        }

        return redirect()->route('admin.crucero_jaen_job.index')
            ->with('success', 'Trabajo de Crucero Jaén actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $job = CruceroJaenJob::findOrFail($id);

        if ($job->photos) {
            foreach ($job->photos as $path) {
                PublicImageStorage::delete($path);
            }
        }

        $job->delete();

        return redirect()->route('admin.crucero_jaen_job.index')
            ->with('success', 'Trabajo de Crucero Jaén eliminado correctamente.');
    }
}
