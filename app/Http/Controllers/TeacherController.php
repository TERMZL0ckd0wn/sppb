<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teachers;

class TeacherController extends Controller
{
    public function index(Request $request)
{
    $q = $request->query('q');

    $query = teachers::query();

    if ($q) {
        $query->where(function ($sq) use ($q) {
            $sq->where('name', 'like', "%{$q}%")
               ->orWhere('email', 'like', "%{$q}%")
               ->orWhere('phone', 'like', "%{$q}%")
               ->orWhere('no_matrik', 'like', "%{$q}%")
               ->orWhere('department', 'like', "%{$q}%");
        });
    }

    $teachers = $query->orderBy('name')->paginate(10)->withQueryString();

    return view('admin.teacher', compact('teachers', 'q'));
}

    // Return only table rows for AJAX requests
    public function rows(Request $request)
    {
        $q = $request->query('q');

        $query = teachers::query();

        if ($q) {
            $query->where(function ($sq) use ($q) {
                $sq->where('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%")
                   ->orWhere('phone', 'like', "%{$q}%")
                   ->orWhere('no_matrik', 'like', "%{$q}%")
                   ->orWhere('department', 'like', "%{$q}%");
            });
        }

        $teachers = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin._teacher_rows', compact('teachers'));
    }

    // Show create form
    public function create()
    {
        return view('admin.addteacher');
    }

    // Store new teacher
    public function store(Request $request)
    {
        $data = $request->validate([
            'no_matrik' => 'required|string|max:255|unique:teachers,no_matrik',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
        ]);

        \App\Models\teachers::create($data);

        return redirect(url('/teacher'))->with('success', 'Pensyarah baru telah ditambah.');
    }

    // Import teachers from CSV file
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

            $teacherData = [
                'no_matrik' => $no_matrik,
                'name' => $name,
                'email' => $dataRow['email'] ?? null,
                'phone' => $dataRow['phone'] ?? null,
                'department' => $dataRow['department'] ?? $dataRow['dept'] ?? null,
            ];

            try {
                \App\Models\teachers::updateOrCreate(
                    ['no_matrik' => $no_matrik],
                    $teacherData
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
        $teacher = teachers::findOrFail($id);
        return view('admin.editteacher', compact('teacher'));
    }

    // Update teacher
    public function update(Request $request, $id)
    {
        $teacher = teachers::findOrFail($id);

        $data = $request->validate([
            'no_matrik' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
        ]);

        $teacher->update($data);

        return redirect(url('/teacher'))->with('success', 'Maklumat pensyarah dikemaskini.');
    }

}
