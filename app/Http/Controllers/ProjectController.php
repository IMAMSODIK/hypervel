<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('images')->orderBy('sort_order')->orderBy('id')->get();

        return view('master.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('master.projects.edit', ['project' => new Project()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $project = Project::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?: Str::slug($validated['title']),
            'category' => $validated['category'] ?? '',
            'client' => $validated['client'] ?? '',
            'location' => $validated['location'] ?? '',
            'year' => $validated['year'] ?? '',
            'short_description' => $validated['short_description'] ?? '',
            'content' => $validated['content'] ?? '',
            'icon' => $validated['icon'] ?? '',
            'featured_image' => $this->uploadFile($request, 'featured_image', 'projects'),
            'disk' => 'public',
            'meta_description' => $validated['meta_description'] ?? '',
            'meta_keywords' => $validated['meta_keywords'] ?? '',
            'is_featured' => $request->has('is_featured'),
            'sort_order' => $validated['sort_order'] ?? (Project::max('sort_order') + 1),
            'is_active' => $request->has('is_active'),
        ]);

        $this->handleGallery($request, $project);

        return redirect()->route('master.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $project->load('images');

        return view('master.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $this->validateRequest($request, $project);

        if ($request->hasFile('featured_image')) {
            $this->deleteFile($project->featured_image, $project->disk);
            $project->featured_image = $request->file('featured_image')->store('projects', 'public');
            $project->disk = 'public';
        }
        if ($request->boolean('clear_featured') && $project->featured_image) {
            $this->deleteFile($project->featured_image, $project->disk);
            $project->featured_image = null;
        }

        $project->title = $validated['title'];
        $project->slug = $validated['slug'] ?: Str::slug($validated['title']);
        $project->category = $validated['category'] ?? '';
        $project->client = $validated['client'] ?? '';
        $project->location = $validated['location'] ?? '';
        $project->year = $validated['year'] ?? '';
        $project->short_description = $validated['short_description'] ?? '';
        $project->content = $validated['content'] ?? '';
        $project->icon = $validated['icon'] ?? '';
        $project->meta_description = $validated['meta_description'] ?? '';
        $project->meta_keywords = $validated['meta_keywords'] ?? '';
        $project->is_featured = $request->has('is_featured');
        $project->sort_order = $validated['sort_order'] ?? $project->sort_order;
        $project->is_active = $request->has('is_active');
        $project->save();

        $this->handleGallery($request, $project);

        return redirect()->route('master.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->featured_image) {
            $this->deleteFile($project->featured_image, $project->disk);
        }
        foreach ($project->images as $img) {
            $this->deleteFile($img->image, $img->disk);
        }
        $project->images()->delete();
        $project->delete();

        return redirect()->route('master.projects.index')->with('success', 'Project deleted successfully.');
    }

    public function destroyImage(Project $project, ProjectImage $image)
    {
        $this->deleteFile($image->image, $image->disk);
        $image->delete();

        return back()->with('success', 'Image removed.');
    }

    public function listing()
    {
        $projects = Project::active()->paginate(9);

        PageView::record('projects');

        return view('projects.index', compact('projects'));
    }

    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $project->load('images');

        PageView::record('project', $project->id);

        $related = Project::active()->where('id', '!=', $project->id)->limit(3)->get();

        return view('projects.show', compact('project', 'related'));
    }

    private function validateRequest(Request $request, ?Project $project = null): array
    {
        $slugRule = ['nullable', 'string', 'max:200'];
        if ($request->filled('slug')) {
            $slugRule[] = 'unique:projects,slug,' . ($project?->id ?? 'NULL');
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => $slugRule,
            'category' => ['nullable', 'string', 'max:100'],
            'client' => ['nullable', 'string', 'max:150'],
            'location' => ['nullable', 'string', 'max:150'],
            'year' => ['nullable', 'string', 'max:10'],
            'short_description' => ['nullable', 'string', 'max:300'],
            'content' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'meta_keywords' => ['nullable', 'string', 'max:300'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'gallery.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'featured_image.image' => 'Featured image must be an image.',
            'featured_image.mimes' => 'Allowed: jpg, jpeg, png, webp.',
            'featured_image.max' => 'Max size 2MB.',
            'gallery.*.image' => 'Gallery file must be an image.',
            'gallery.*.mimes' => 'Allowed: jpg, jpeg, png, webp.',
            'gallery.*.max' => 'Max size 2MB per image.',
        ]);
    }

    private function uploadFile(Request $request, string $field, string $folder): ?string
    {
        if ($request->hasFile($field)) {
            return $request->file($field)->store($folder, 'public');
        }

        return null;
    }

    private function handleGallery(Request $request, Project $project): void
    {
        if ($request->hasFile('gallery')) {
            $order = $project->images()->max('sort_order') ?? 0;
            foreach ($request->file('gallery') as $file) {
                $path = $file->store('projects/gallery', 'public');
                $project->images()->create([
                    'image' => $path,
                    'disk' => 'public',
                    'sort_order' => ++$order,
                ]);
            }
        }
    }

    private function deleteFile(?string $path, string $disk): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}