<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Grade;
use App\Models\GradeLog;

class GradeController extends Controller
{
    /**
     * Wyświetla listę ocen nauczyciela.
     */
   public function index()
    {
        $grades = Grade::with('student')
            ->where('teacher_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('teacher.grades.index', compact('grades'));
    }

    /**
     * Formularz tworzenia nowej oceny.
     */
    public function create()
    {
        $students = User::where('role', 'user')->get(); // uczniowie
        return view('teacher.grades.create', compact('students'));
    }

    /**
     * Zapisuje nową ocenę.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:100',
            'grade' => 'required|numeric|between:1,6',
            'comment' => 'nullable|string|max:255',
        ]);

        Grade::create([
            'student_id' => $request->student_id,
            'teacher_id' => Auth::id(),
            'subject' => $request->subject,
            'grade' => $request->grade,
            'comment' => $request->comment,
        ]);

        return redirect()->route('teacher.grades.index')->with('success', 'Ocena została dodana.');
    }

    /**
     * Szczegóły jednej oceny.
     */
    public function show(Grade $grade)
    {
        if ($grade->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('teacher.grades.show', compact('grade'));
    }

    /**
     * Formularz edycji oceny.
     */
    public function edit(Grade $grade)
    {
        if ($grade->teacher_id !== Auth::id()) {
            abort(403);
        }

        $students = User::where('role', 'user')->get();
        return view('teacher.grades.edit', compact('grade', 'students'));
    }

    public function logs(Request $request)
    {
        $gradeIds = Grade::where('teacher_id', Auth::id())->pluck('id');

        $logs = GradeLog::with(['grade.student', 'changedBy'])
            ->whereIn('grade_id', $gradeIds);

        // Filtrowanie
        if ($request->filled('student')) {
            $logs->whereHas('grade.student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student . '%');
            });
        }

        if ($request->filled('subject')) {
            $logs->whereHas('grade', function ($q) use ($request) {
                $q->where('subject', 'like', '%' . $request->subject . '%');
            });
        }

        if ($request->filled('from_date')) {
            $logs->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $logs->whereDate('created_at', '<=', $request->to_date);
        }

        // Sortowanie
        $logs->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));

        //$grades = $query->latest()->paginate(10);
        
        // Eksport do CSV
        if ($request->has('export') && $request->export === 'csv') {
            $logsToExport = $logs->get(); // Pobierz wszystkie, tylko do eksportu

            $filename = 'logs_' . now()->format('Ymd_His') . '.csv';
            $headers = ['Content-Type' => 'text/csv'];

            $callback = function () use ($logsToExport) {
                $handle = fopen('php://output', 'w');
                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM for UTF-8
                fputcsv($handle, ['Uczeń', 'Przedmiot', 'Stara ocena', 'Nowa ocena', 'Komentarz', 'Zmienione przez', 'Data']);

                foreach ($logsToExport as $log) {
                    fputcsv($handle, [
                        $log->grade->student->name ?? 'Nieznany',
                        $log->grade->subject,
                        "'" . $log->old_grade,
                        "'" . $log->new_grade,
                        $log->comment,
                        $log->changedBy->name ?? 'Nieznany',
                        $log->created_at->format('Y-m-d H:i'),
                    ]);
                }

                fclose($handle);
            };

            return response()->stream($callback, 200, array_merge($headers, [
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ]));
        }

        // Paginacja wyników przefiltrowanych i posortowanych
        $logs = $logs->paginate(10)->appends($request->query());

        return view('teacher.grades.logs', [
            'logs' => $logs,
            'request' => $request
        ]);
    }

    /**
     * Aktualizacja oceny.
     */
    public function update(Request $request, Grade $grade)
    {
        if ($grade->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:100',
            'grade' => 'required|numeric|between:1,6',
            'comment' => 'nullable|string|max:255',
        ]);

        if ($request->grade != $grade->grade) {
            \App\Models\GradeLog::create([
                'grade_id' => $grade->id,
                'changed_by' => Auth::id(),
                'old_grade' => $grade->grade,
                'new_grade' => $request->grade,
                'comment' => $request->comment,
            ]);
        }
        
        $grade->update([
            'student_id' => $request->student_id,
            'subject' => $request->subject,
            'grade' => $request->grade,
            'comment' => $request->comment,
        ]);

        return redirect()->route('teacher.grades.index')->with('success', 'Ocena zaktualizowana.');
    }

    /**
     * Usunięcie oceny.
     */
    public function destroy(Grade $grade)
    {
        if ($grade->teacher_id !== Auth::id()) {
            abort(403);
        }

        $grade->delete();

        return redirect()->route('teacher.grades.index')->with('success', 'Ocena usunięta.');
    }

    
}
