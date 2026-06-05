<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSection;
use App\Models\SectionItem;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function storeSection(Request $request, $courseId)
    {
        $user = Auth::user();
        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        CourseSection::create([
            'course_id' => $courseId,
            'title'     => $request->title,
            'order'     => CourseSection::where('course_id', $courseId)->count()
        ]);

        return back()->with('success', 'Apartado creado correctamente.');
    }

    public function destroySection($sectionId)
    {
        $user = Auth::user();
        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $section = CourseSection::findOrFail($sectionId);
        $section->delete();

        return back()->with('success', 'Apartado eliminado correctamente.');
    }

    public function storeItem(Request $request, $sectionId)
    {
        $user = Auth::user();
        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $request->validate([
            'type'        => 'required|in:temario,tarea',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'file'        => 'nullable|mimes:pdf|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();

            if (!file_exists(public_path('recursos/pdfs/temario'))) {
                mkdir(public_path('recursos/pdfs/temario'), 0755, true);
            }

            $request->file('file')->move(
                public_path('recursos/pdfs/temario'),
                $fileName
            );

            $filePath = 'recursos/pdfs/temario/' . $fileName;
        }

        SectionItem::create([
            'section_id'  => $sectionId,
            'type'        => $request->type,
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'file_path'   => $filePath,
            'order'       => SectionItem::where('section_id', $sectionId)->count()
        ]);

        return back()->with('success', 'Contenido añadido correctamente.');
    }

    public function editItem($itemId)
    {
        $user = Auth::user();
        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $item = SectionItem::findOrFail($itemId);
        $course = $item->section->course;

        return view('courses.edit_item', compact('item', 'course'));
    }

    public function updateItem(Request $request, $itemId)
    {
        $user = Auth::user();
        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $item = SectionItem::findOrFail($itemId);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'file'        => 'nullable|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            if ($item->file_path && file_exists(public_path($item->file_path))) {
                unlink(public_path($item->file_path));
            }

            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();

            if (!file_exists(public_path('recursos/pdfs/temario'))) {
                mkdir(public_path('recursos/pdfs/temario'), 0755, true);
            }

            $request->file('file')->move(
                public_path('recursos/pdfs/temario'),
                $fileName
            );

            $item->file_path = 'recursos/pdfs/temario/' . $fileName;
        }

        $item->title       = $request->title;
        $item->description = $request->description;
        $item->due_date    = $request->due_date;
        $item->save();

        $course = $item->section->course;
        return redirect(route('courses.show', $course->view_name))
            ->with('success', 'Contenido actualizado correctamente.');
    }

    public function destroyItem($itemId)
    {
        $user = Auth::user();
        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $item = SectionItem::findOrFail($itemId);

        if ($item->file_path && file_exists(public_path($item->file_path))) {
            unlink(public_path($item->file_path));
        }

        $item->delete();

        return back()->with('success', 'Contenido eliminado correctamente.');
    }

    public function showTask($itemId)
    {
        $item = SectionItem::findOrFail($itemId);
        $user = Auth::user();

        $submission = TaskSubmission::where('item_id', $itemId)
            ->where('user_id', $user->id_user)
            ->first();

        return view('courses.task', compact('item', 'submission'));
    }

    public function submitTask(Request $request, $itemId)
    {
        $request->validate([
            'file'    => 'required|max:10240',
            'comment' => 'nullable|string'
        ]);

        $user = Auth::user();
        $fileName = time() . '_' . $request->file('file')->getClientOriginalName();

        if (!file_exists(public_path('recursos/pdfs/entregas'))) {
            mkdir(public_path('recursos/pdfs/entregas'), 0755, true);
        }

        $request->file('file')->move(
            public_path('recursos/pdfs/entregas'),
            $fileName
        );

        $filePath = 'recursos/pdfs/entregas/' . $fileName;

        TaskSubmission::updateOrCreate(
            ['item_id' => $itemId, 'user_id' => $user->id_user],
            ['file_path' => $filePath, 'comment' => $request->comment]
        );

        return back()->with('success', 'Tarea entregada correctamente.');
    }

    public function viewSubmissions($itemId)
    {
        $user = Auth::user();
        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $item = SectionItem::findOrFail($itemId);
        $submissions = TaskSubmission::with('user')
            ->where('item_id', $itemId)
            ->get();

        return view('courses.submissions', compact('item', 'submissions'));
    }
}