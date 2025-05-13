<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with('teacher')->where('student_id', Auth::id());

        // Filtrowanie po przedmiocie
        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }
    
        // Filtrowanie po dacie (zakres)
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
    
        $grades = $query->latest()->paginate(10);
        // Eksport do CSV
        if ($request->has('export') && $request->export === 'csv') {
            $filename = 'moje_oceny_' . now()->format('Ymd_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($grades) {
                $handle = fopen('php://output', 'w');

                // Dodanie BOM dla UTF-8 (polskie znaki)
                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

                // Nagłówki kolumn
                fputcsv($handle, ['Przedmiot', 'Ocena', 'Komentarz', 'Nauczyciel', 'Data wystawienia']);

                foreach ($grades as $grade) {
                    fputcsv($handle, [
                        $grade->subject,
                        '=' . '"' . number_format($grade->grade, 1, ',', '') . '"', // Excel-friendly
                        $grade->comment,
                        $grade->teacher->name ?? 'Nieznany',
                        $grade->created_at->format('Y-m-d H:i')
                    ]);
                }

                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        }

        return view('student.grades.index', compact('grades'));
    }

    public function show(Grade $grade)
    {
        if ($grade->student_id !== Auth::id()) {
            abort(403);
        }

        return view('student.grades.show', compact('grade'));
    }

    public function statistics()
    {
        $userId = Auth::id();
    
        $grades = Grade::where('student_id', $userId)->get();
    
        $average = $grades->avg('grade') ?? 0;
        $count = $grades->count();
        $max = $grades->max('grade') ?? 0;
        $min = $grades->min('grade') ?? 0;
    
        $gradesBySubject = $grades->groupBy('subject');
    
        return view('student.grades.statistics', compact(
            'average',
            'count',
            'max',
            'min',
            'gradesBySubject'
        ));
    }
}
