<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EmployerApplicationController extends Controller
{
    /**
     * Show all applications for employer's jobs.
     */
    public function index()
    {
        $user = auth()->user();

        $applications = Application::with(['job', 'applicant.jobseeker'])
            ->whereHas('job', fn($q) => $q->where('user_id', $user->id))
            ->latest()
            ->paginate(10);

        return view('employer.applicants', compact('applications'));
    }

    /**
     * Update application status (accept/reject/pending)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application = Application::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return back()->with('success', 'Application status updated!');
    }

    /**
     * Export applications to Excel
     */
    public function exportExcel()
    {
        $user = auth()->user();

        $applications = Application::with(['job', 'applicant.jobseeker'])
            ->whereHas('job', fn($q) => $q->where('user_id', $user->id))
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $sheet->setCellValue('A1', 'Job Title');
        $sheet->setCellValue('B1', 'Applicant Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Phone');
        $sheet->setCellValue('E1', 'Applied On');
        $sheet->setCellValue('F1', 'Status');
        $sheet->setCellValue('G1', 'Resume Link');

        // Data rows
        $row = 2;
        foreach ($applications as $app) {
            $sheet->setCellValue('A' . $row, $app->job->title);
            $sheet->setCellValue('B' . $row, $app->applicant->name);
            $sheet->setCellValue('C' . $row, $app->applicant->email);
            $sheet->setCellValue('D' . $row, $app->applicant->jobseeker->phone ?? '');
            $sheet->setCellValue('E' . $row, $app->created_at->format('Y-m-d'));
            $sheet->setCellValue('F' . $row, ucfirst($app->status));
            $sheet->setCellValue('G' . $row, $app->applicant->jobseeker->resume ? url('storage/' . $app->applicant->jobseeker->resume) : '');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'applicants_' . now()->format('Ymd_His') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
