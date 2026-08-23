<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with stats and applicant list.
     */
    public function index(Request $request)
    {
        // Statistics counters
        $stats = [
            'total'     => Applicant::count(),
            'new'       => Applicant::where('status', 'جديد')->count(),
            'review'    => Applicant::where('status', 'قيد المراجعة')->count(),
            'accepted'  => Applicant::where('status', 'مقبول')->count(),
            'rejected'  => Applicant::where('status', 'مرفوض')->count(),
        ];

        // Query with filters and search
        $query = Applicant::query();

        if ($request->filled('search')) {
            $search = trim($request->get('search'));
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhere('nationality', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->get('gender'));
        }

        $applicants = $query->latest()->paginate(10)->withQueryString();

        return view('admin.dashboard', compact('applicants', 'stats'));
    }

    /**
     * Return applicant details as JSON (for quick modal preview).
     */
    public function show(Applicant $applicant)
    {
        return response()->json([
            'id'             => $applicant->id,
            'full_name'      => $applicant->full_name,
            'national_id'    => $applicant->national_id,
            'gender'         => $applicant->gender,
            'birth_date'     => $applicant->birth_date ? $applicant->birth_date->format('Y-m-d') : null,
            'nationality'    => $applicant->nationality,
            'status'         => $applicant->status,
            'admin_notes'    => $applicant->admin_notes,
            'created_at'     => $applicant->created_at->format('Y-m-d H:i'),
            'cv_url'         => route('admin.applicants.cv', $applicant->id),
            'id_url'         => route('admin.applicants.id_doc', $applicant->id),
        ]);
    }

    /**
     * Update the status and internal notes of an applicant.
     */
    public function updateStatus(Request $request, Applicant $applicant)
    {
        $validated = $request->validate([
            'status'      => ['required', 'in:جديد,قيد المراجعة,مقبول,مرفوض'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'status.required' => 'يرجى اختيار حالة الطلب.',
            'status.in'       => 'حالة الطلب المحددة غير صالحة.',
        ]);

        $applicant->update([
            'status'      => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $applicant->admin_notes,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة طلب ' . $applicant->full_name . ' بنجاح إلى: ' . $applicant->status);
    }

    /**
     * Download or view applicant CV safely.
     */
    public function downloadCv(Applicant $applicant)
    {
        if (!$applicant->cv_path || !Storage::disk('public')->exists($applicant->cv_path)) {
            return redirect()->back()->with('error', 'ملف السيرة الذاتية غير موجود في التخزين.');
        }

        return Storage::disk('public')->response(
            $applicant->cv_path,
            'CV_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $applicant->national_id) . '.pdf'
        );
    }

    /**
     * Download or view applicant ID document safely.
     */
    public function downloadId(Applicant $applicant)
    {
        if (!$applicant->id_path || !Storage::disk('public')->exists($applicant->id_path)) {
            return redirect()->back()->with('error', 'مستند الهوية غير موجود في التخزين.');
        }

        $extension = pathinfo($applicant->id_path, PATHINFO_EXTENSION);
        $fileName = 'ID_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $applicant->national_id) . '.' . $extension;

        return Storage::disk('public')->response($applicant->id_path, $fileName);
    }

    /**
     * Delete an applicant and their stored files.
     */
    public function destroy(Applicant $applicant)
    {
        $name = $applicant->full_name;

        // Delete physical files
        if ($applicant->cv_path && Storage::disk('public')->exists($applicant->cv_path)) {
            Storage::disk('public')->delete($applicant->cv_path);
        }
        if ($applicant->id_path && Storage::disk('public')->exists($applicant->id_path)) {
            Storage::disk('public')->delete($applicant->id_path);
        }

        $applicant->delete();

        return redirect()->route('admin.dashboard')->with('success', 'تم حذف طلب المتقدم ' . $name . ' وملفاته بنجاح.');
    }
}
