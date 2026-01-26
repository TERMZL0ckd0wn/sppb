<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\students;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = students::query();

        if ($q) {
            $query->where(function ($sq) use ($q) {
                $sq->where('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%")
                   ->orWhere('phone', 'like', "%{$q}%")
                   ->orWhere('no_matrik', 'like', "%{$q}%")
                   ->orWhere('course', 'like', "%{$q}%")
                   ->orWhere('kohort', 'like', "%{$q}%");
            });
        }

        $students = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.student', compact('students', 'q'));
    }

    // Return only table rows for AJAX requests
    public function rows(Request $request)
    {
        $q = $request->query('q');

        $query = students::query();

        if ($q) {
            $query->where(function ($sq) use ($q) {
                $sq->where('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%")
                   ->orWhere('phone', 'like', "%{$q}%")
                   ->orWhere('no_matrik', 'like', "%{$q}%")
                   ->orWhere('course', 'like', "%{$q}%")
                   ->orWhere('kohort', 'like', "%{$q}%");
            });
        }

        $students = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin._student_rows', compact('students'));
    }

    // Show create form
    public function create()
    {
        return view('admin.addstudent');
    }

    // Store new student
    public function store(Request $request)
    {
        $data = $request->validate([
            'no_matrik' => 'required|string|max:255|unique:students,no_matrik',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'course' => 'nullable|string|max:255',
            'kohort' => 'nullable|string|max:50',
        ]);

        \App\Models\students::create($data);

        return redirect(url('/student'))->with('success', 'Pelajar baru telah ditambah.');
    }

    // Import students from CSV file
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        if ($handle === false) {
            return redirect()->back()->with('error', 'Gagal membuka fail.');
        }

        $header = null;
        $rowNumber = 0;
        $imported = 0;
        $errors = [];

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $rowNumber++;
            if (!$header) {
                $header = array_map(function ($h) { return strtolower(trim($h)); }, $row);
                continue;
            }

            if (count($row) === 0) continue;

            $dataRow = array_combine($header, $row);

            $no_matrik = trim($dataRow['no_matrik'] ?? $dataRow['no matric'] ?? $dataRow['id'] ?? '');
            $name = trim($dataRow['name'] ?? $dataRow['nama'] ?? '');

            if (empty($no_matrik) || empty($name)) {
                $errors[] = "Row {$rowNumber}: missing no_matrik or name";
                continue;
            }

            $studentData = [
                'no_matrik' => $no_matrik,
                'name' => $name,
                'email' => $dataRow['email'] ?? null,
                'phone' => $dataRow['phone'] ?? null,
                'course' => $dataRow['course'] ?? $dataRow['program'] ?? null,
                'kohort' => $dataRow['kohort'] ?? $dataRow['year'] ?? null,
            ];

            try {
                \App\Models\students::updateOrCreate(
                    ['no_matrik' => $no_matrik],
                    $studentData
                );
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Row {$rowNumber}: {$e->getMessage()}";
            }
        }

        fclose($handle);

        $message = "Imported {$imported} rows.";
        $redirect = redirect()->back()->with('success', $message);
        if (!empty($errors)) {
            $redirect = $redirect->with('import_errors', $errors);
        }

        return $redirect;
    }

    // Show edit form
    public function edit($id)
    {
        $student = students::findOrFail($id);
        return view('admin.editstudent', compact('student'));
    }

    // Update student
    public function update(Request $request, $id)
    {
        $student = students::findOrFail($id);

        $data = $request->validate([
            'no_matrik' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'course' => 'nullable|string|max:255',
            'kohort' => 'nullable|string|max:50',
        ]);

        $student->update($data);

        return redirect(url('/student'))->with('success', 'Maklumat pelajar dikemaskini.');
    }
}
